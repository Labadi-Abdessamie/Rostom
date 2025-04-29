<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
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
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
