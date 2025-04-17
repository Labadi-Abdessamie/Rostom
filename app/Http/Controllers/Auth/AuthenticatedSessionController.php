<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('frontend.pages.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [], [], 'login');
        $request->authenticate();

        $request->session()->regenerate();

        $cart = Auth::user()->bags->where('type', 'cart')->first();
        if ($cart) {
            $cart->load(['bagItems.product']);
            $cartItems = [];

            foreach ($cart->bagItems as $item) {
                if ($item->product) {
                    $cartItems[$item->product->id] = [
                        'id' => $item->id,
                        'quantity' => $item->quantity,
                        'product' => [
                            'name' => $item->product->name,
                            'image' => $item->product->principalImage,
                            'actual_quantity' => $item->product->actual_quantity,
                            'price' => $item->product->price
                        ]
                    ];
                } else {
                    $item->delete();
                }
            }
            session(['cart' => $cartItems]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
