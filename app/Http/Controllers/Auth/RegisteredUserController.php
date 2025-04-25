<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */


    public function create()
    {
        return redirect()->route('login');
        /*
        $login = false;
        $register = true;
        return view('frontend.pages.login', compact('login', 'register'));
        */
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
            'role' => ['required', 'in:client,vendor'],
            'agreedCheck' => ['accepted']
        ], [
            'agreedCheck.accpeted' => 'The privacy policy must be accepted.',
            'password_confirmation.same' => 'The two passwords do not match.'
        ], [], 'signup');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'client') {
            Bag::create([
                'type' => 'cart',
                'user_id' => $user->id,
            ]);
            Bag::create([
                'type' => 'wishlist',
                'user_id' => $user->id,
            ]);
        }
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
