<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email||lowercase|max:255',
            'phoneNumber' => 'nullable|string|max:10',
            'bio' => 'nullable|string|max:1000',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($data['email'] !== $user->email) {
            $request->user()->email_verified_at = null;
        }

        if (request()->hasFile('profilePicture')) {
            $file = request()->file('profilePicture');
            $path = $file->store('profile_pictures/' . $user->id, 'public');
            $data['profilePicture'] = basename($path);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);
        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    //! function for the profiles edition by the Admin

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:10'],
            'password' => ['required',],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => "admin",
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Admin created succefuly.');
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $type = $user->role;
        return view('admin.pages.edit_user', compact('user', 'type'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'User updated successfully.');
    }
    public function deleteUser(Request $request, $id)
    {
        //! add here to change the pending orders to cancelled and the reviews to anynomus
        $user = User::findOrFail($id);
        if ($user->role == "client") {
            foreach ($user->reviews as $review) {
                $review->delete();
            }
            foreach ($user->orders as $order) {
                if ($order->status == "pending") {
                    $order->status = "cancelled";
                    $order->save();
                }
            }
            foreach ($user->bags as $bag) {
                $bag->delete();
            }
            /*
            foreach ($user->addresses as $address) {
                $address->delete();
            }
            */
        } else if ($user->role == "vendor") {
            $user->magasin->status = "inactive";
            $user->magasin->save();
        }
        $user->status = "inactive";
        $user->save();

        $returnUrl = $request->input('return_url');
        if ($returnUrl && filter_var($returnUrl, FILTER_VALIDATE_URL) && str_contains($returnUrl, url('/'))) {
            return redirect()->to($returnUrl)->with('success', 'User deleted successfully.');
        }
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
