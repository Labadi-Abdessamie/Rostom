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
            'email' => 'required|email|max:255',
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
}
