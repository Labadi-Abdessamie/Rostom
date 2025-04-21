<?php

namespace App\Http\Controllers;


use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function update(){
        $user = Auth::user();
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phoneNumber' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (request()->hasFile('profilePicture')) {
            $data['profilePicture'] = request()->file('profilePicture')->store('profile_pictures', 'public');
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function address()
{
    // Retrieve the authenticated user
    $user = Auth::user();

    // Retrieve the addresses associated with the user, ordered by the most recent
    $addresses = $user->addresses()->latest()->get();

    // Return the 'client.pages.address' view with the addresses data
    return view('client.pages.address', compact('addresses'));
}
public function addAddress()
{
    $user = Auth::user();

    // Optional: Check if user already has a principal address
    $hasPrincipal = $user->addresses()->where('principalAddress', true)->exists();

    return view('client.pages.add_address', [
        'hasPrincipal' => $hasPrincipal
    ]);
}
    public function updatePassword(Request $request)
{
    // Get the currently authenticated user
    $user = Auth::user();

    // Validate the incoming request data
    $data = $request->validate([
        'current_password' => 'required|string',  // Ensure the current password is provided
        'new_password' => 'required|string|min:8|confirmed', // Ensure new password is confirmed
    ]);

    // Check if the provided current password matches the user's password in the database
    if (!Hash::check($data['current_password'], $user->password)) {
        // If not, return an error message
        return redirect()->back()->with('error', 'Current password is incorrect.');
    }

    // Update the password only if the current password is correct
    $user->update([
        'password' => Hash::make($data['new_password']) // Hash the new password
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Password updated successfully.');
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
