<?php

namespace App\Http\Controllers;


use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        return view('client.index');
    }
    public function orders()
    {
        return view('client.pages.orders');
    }
    public function wishlist()
{
    $wishlist = session()->get('wishlist',[]);
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
public function updateReview(Request $request, $id)
{
    $request->validate([
        'rate' => 'required|integer|min:1|max:5',
        'content' => 'required|string|max:1000',
    ]);

    $review = Review::where('id', $id)->where('user_id', Auth::id())->first();

    if ($review) {
        $review->update([
            'rate' => $request->input('rate'),
            'content' => $request->input('content'),
        ]);
        return redirect()->back()->with('success', 'Review updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Review not found or unauthorized.');
    }
}
public function deleteReview($id){
    $review = Review::where('id', $id)->where('user_id', Auth::id())->first();

    if ($review) {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'Review not found or unauthorized.');
    }
}
    public function profile()
    {
        return view('client.pages.profile');
    }
    public function address()
    {
        return view('client.pages.address');
    }
    public function addAddress()
    {
        return view('client.pages.add_address');
    }
    public function updateProfile() {}
    public function updatePassword() {}


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
