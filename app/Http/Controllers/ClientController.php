<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        return view('client.index');
    }
    public function orders()
    {
        $orders = Auth::user()->orders()
            ->with(['shippingAddress', 'billingAddress', 'orderItems'])
            ->paginate(10);

        return view('client.pages.orders', compact('orders'));
    }
    public function orderDetails($orderId)
    {
        $order = Auth::user()->orders()
            ->with(['shippingAddress', 'billingAddress'])
            ->findOrFail($orderId);
        $orderItems = OrderItem::where('order_id', $orderId)
            ->with(['product:id,name,price,principalImage'])
            ->get();
        return view('client.pages.order_invoice', compact('order', 'orderItems'));
    }
    public function wishlist()
    {
        $wishlist = session()->get('wishlist', []);
        return view('client.pages.wishlist', compact('wishlist'));
    }

    public function reviews()
    {
        $user = Auth::user();
        $reviews = Review::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('client.pages.reviews', compact('reviews'));
    }

    public function profile()
    {
        $user = Auth::user();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'phoneNumber' => $user->phoneNumber,
            'profilePicture' => $user->profile_picture,
            'bio' => $user->bio,
            'status' => $user->status,
        ];

        return view('client.pages.profile', compact('data'));
    }




    /*
    public function chat()
    {
        return view('client.pages.chat');
    }
    public function download()
    {
        return view('client.pages.downloads');
    }
    public function invoice()
    {
        return view('client.pages.order_invoice');
    }
    */
}
