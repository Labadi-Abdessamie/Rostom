<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
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
        foreach ($cart as $productId => $item) {
            $total += $item['quantity'] * $item['product']['price'];
            $orderItems[$productId] = [
                'quantity' => $item['quantity']
            ];
        }
        $order = Order::create([
            'status' => 'pending',
            'details' => $request->details,
            'totalAmount' => $total,
            //'date' => Carbon::now()->addDays(15),
            'user_id' => Auth::id(),
            'shippingAddress_id' => $request->id,
            'billingAddress_id' => $request->billingId ?? $request->id,
        ]);


        foreach ($orderItems as $productId => $item) {
            OrderItem::create([
                'quantity' => $item['quantity'],
                'order_id' => $order->id,
                'product_id' => $productId
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
            return redirect()->back()->with('error', 'You can\'t delete this order.');
        }
        foreach ($order->items as $item) {
            $item->delete();
        }
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function confirmOrder(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'delivered';
        $order->save();
        foreach ($order->orderItems as $item) {
            Product::findOrFail($item->product->id);
            $item->product->actual_quantity -= $item->quantity;
            $item->product->save();
            Magasin::findOrFail($item->product->magasin->id);
            $item->product->magasin->balance += $item->product->price * $item->quantity;
            $item->product->magasin->save();
        }
        return redirect()->back()->with('message', 'Order confirmed successfully.');
    }
    public function cancelOrder(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();
        return redirect()->back()->with('message', 'Order cancelled successfully.');
    }
}
