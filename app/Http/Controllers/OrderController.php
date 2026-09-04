<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'address' => ['required', 'string', 'min:3', 'max:50'],
            'phoneNumber' => ['required', 'string', 'size:10'],
            'email' => ['required', 'email'],
            'details' => ['nullable', 'string', 'max:255'],
            'TermsConditions' => ['accepted'],
            //
            'billingId' => ['nullable', 'integer'],
            'billingName' => ['nullable', 'string', 'max:50'],
            'billingAddress' => ['nullable', 'string', 'max:100'],
            'billingPhoneNumber' => ['nullable', 'string', 'size:10'],
            'billingEmail' => ['nullable', 'email'],
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('frontend.index')->with('message', 'Your cart is empty!');
        }
        $orderItems = [];
        $total = 0;
        $shipping_fee = 100;
        $total += $shipping_fee;
        foreach ($cart as $cartKey => $item) {
            // Extract product_id from cart key (format: productId or productId_combinationHash)
            $productId = explode('_', $cartKey)[0];
            $basePrice = $item['product']['base_price'] ?? $item['product']['price'] ?? 0;
            $extraPrice = $item['extra_price'] ?? 0;
            $itemTotal = $item['quantity'] * ($basePrice + $extraPrice);
            $total += $itemTotal;
            $orderItems[$productId] = [
                'quantity' => $item['quantity'],
                'combination' => $item['combination'] ?? null,
                'base_price' => $basePrice,
                'extra_price' => $extraPrice,
            ];
        }
        $order = Order::create([
            'status' => 'pending',
            'details' => $request->details,
            'totalAmount' => $total,
            'paymentMethod' => 'cashOnDelivery',
            'paymentStatus' => 'pending',
            //'date' => Carbon::now()->addDays(15),
            'user_id' => Auth::id(),
            'shippingAddress_id' => $request->id,
            'billingAddress_id' => $request->billingId ?? $request->id,
        ]);


        foreach ($orderItems as $productId => $item) {
            OrderItem::create([
                'quantity' => $item['quantity'],
                'order_id' => $order->id,
                'product_id' => $productId,
                'variant_combination' => $item['combination'],
                'base_price' => $item['base_price'] ?? ($item['product']['price'] ?? 0),
                'extra_price' => $item['extra_price'] ?? 0,
            ]);
        }
        session()->put('cart', []);
        return redirect()->route('frontend.index')->with('message', 'Order placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $status = $value;
                $description = $data["Just-$key"] ?? null;

                $item = OrderItem::findorFail($key);

                if ($status) {
                    $item->status = "available";
                    $item->description = null;
                } else {
                    $item->status = "notAvailable";
                    if ($description) {
                        $item->description = $description;
                    }
                }
                $item->save();
            }
        }
        $order = Order::findorFail($id);

        $pendingItems = $order->orderItems()->where('status', 'pending')->get();
        if ($pendingItems->count() == 0) {
            $order->status = 'confirmed';
        } elseif ($pendingItems->count() < $order->orderItems->count()) {
            $order->status = 'processing';
        }
        $order->save();

        return redirect()->route('vendor.orders');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        if ($order->status == 'delivered') {
            return redirect()->route('admin.orders')->with('error', "You can't delete this order.");
        }
        foreach ($order->orderItems as $item) {
            $item->delete();
        }
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
    }

    public function confirmOrder(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'delivered';
        $order->save();

        foreach ($order->orderItems as $item) {
            if ($item->status !== 'available') continue;

            $product = $item->product;

            // If item has a variant combination, deduct from that combo stock
            if ($item->variant_combination && !empty($item->variant_combination)) {
                $combo = \App\Models\VariantCombination::where('product_id', $product->id)
                    ->get()
                    ->first(function ($c) use ($item) {
                        $data = $c->combination ?? [];
                        foreach ($item->variant_combination as $k => $v) {
                            if (!isset($data[$k]) || $data[$k] !== $v) return false;
                        }
                        return true;
                    });
                if ($combo && $combo->quantity < $item->quantity) {
                    return redirect()->back()->with('error', 'Not enough stock available for this variant item.');
                }
                if ($combo) {
                    $combo->quantity -= $item->quantity;
                    $combo->save();
                }
            } else {
                // Default product stock
                if ($product->actual_quantity < $item->quantity) {
                    return redirect()->back()->with('error', 'Not enough stock available for this item.');
                }
                $product->actual_quantity -= $item->quantity;
                $product->save();
            }
        }

        return redirect()->back()->with('message', 'Order confirmed successfully.');
    }

    public function confirmPayment(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->paymentStatus === 'success') {
            return redirect()->back()->with('error', 'Payment already confirmed.');
        }

        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Order must be delivered before payment can be confirmed.');
        }

        // Vendor can only confirm payment for their available products
        $vendorItems = collect();
        foreach ($order->orderItems as $item) {
            if ($item->status !== 'available') continue;
            $magasin = $item->product->magasin;
            if ($magasin->user_id === Auth::id()) {
                $vendorItems->push($item);
            }
        }

        if ($vendorItems->isEmpty()) {
            return redirect()->back()->with('error', 'You have no available products in this order to confirm payment.');
        }

        // Only set order payment to success if no other vendors have unconfirmed available items
        $otherVendorHasPending = false;
        foreach ($order->orderItems as $item) {
            if ($item->status !== 'available') continue;
            $magasin = $item->product->magasin;
            if ($magasin->user_id !== Auth::id()) {
                $otherVendorHasPending = true;
                break;
            }
        }

        if (!$otherVendorHasPending) {
            $order->paymentStatus = 'success';
            $order->save();
        }

        foreach ($vendorItems as $item) {
            $magasin = Magasin::findOrFail($item->product->magasin->id);
            $linePrice = ($item->base_price ?? $item->product->price ?? 0) + ($item->extra_price ?? 0);
            $magasin->balance += $linePrice * $item->quantity;
            $magasin->save();

            // Mark this vendor's item as confirmed so it disappears from pending
            $item->status = 'confirmed';
            $item->save();
        }

        return redirect()->back()->with('message', 'Payment confirmed successfully.');
    }
    public function cancelOrder(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();
        return redirect()->back()->with('message', 'Order cancelled successfully.');
    }
}
