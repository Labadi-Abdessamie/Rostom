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

        $user = Auth::user();

        // ✅ Redirect according to role
        if ($user->role == 'client') {
            // ✅ Handle Cart
            $cart = $user->bags->where('type', 'cart')->first();
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

            // ✅ Handle Wishlist
            $wishlist = $user->bags->where('type', 'wishlist')->first();
            if ($wishlist) {
                $wishlist->load(['bagItems.product']);
                $wishlistItems = [];

                foreach ($wishlist->bagItems as $item) {
                    if ($item->product) {
                        $wishlistItems[$item->product->id] = [
                            'id' => $item->id,
                            'quantity' => $item->quantity,
                            'product' => [
                                'name' => $item->product->name,
                                'image' => $item->product->principalImage,
                                'actual_quantity' => $item->product->actual_quantity,
                                'price' => $item->product->price
                            ]
                        ];
                    }
                }
                session(['wishlist' => $wishlistItems]);
            }
        }

        switch ($user->role) {
            case "client":
            case "vendor":
                /*if (is_null($user->email_verified_at)) {
                    return redirect()->route('verification.notice');
                }*/
                break;
            case "admin":
                break;
            default:
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/');
                break;
        }

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role == 'client') {
            $cart = $user->bags()->where('type', 'cart')->with('bagItems')->first();
            $sessionCart = session()->get('cart', []);
            if ($cart) {
                $dbItems = $cart->bagItems->keyBy('product_id');
                $sessionProductIds = collect($sessionCart)->keys()->map(fn($id) => (int) $id);

                foreach ($sessionCart as $productId => $sessionItem) {
                    $productId = (int) $productId;

                    if ($dbItems->has($productId)) {
                        $dbItem = $dbItems[$productId];
                        if ($dbItem->quantity != $sessionItem['quantity']) {
                            $dbItem->update(['quantity' => $sessionItem['quantity']]);
                        }
                    } else {
                        $cart->bagItems()->create([
                            'bag_id' => $cart->id,
                            'product_id' => $productId,
                            'quantity' => $sessionItem['quantity'],
                        ]);
                    }
                }
                foreach ($dbItems as $productId => $dbItem) {
                    if (!isset($sessionCart[$productId])) {
                        $dbItem->delete();
                    }
                }
            }
            $wishlist = $user->bags()->where('type', 'wishlist')->with('bagItems')->first();
            $sessionWishlist = session()->get('wishlist', []);
            if ($wishlist) {
                $dbItems = $wishlist->bagItems->keyBy('product_id');
                $sessionProductIds = collect($sessionWishlist)->keys()->map(fn($id) => (int) $id);

                foreach ($sessionWishlist as $productId => $sessionItem) {
                    $productId = (int) $productId;

                    if ($dbItems->has($productId)) {
                        $dbItem = $dbItems[$productId];
                        if ($dbItem->quantity != $sessionItem['quantity']) {
                            $dbItem->update(['quantity' => $sessionItem['quantity']]);
                        }
                    } else {
                        $wishlist->bagItems()->create([
                            'bag_id' => $wishlist->id,
                            'product_id' => $productId,
                            'quantity' => $sessionItem['quantity'],
                        ]);
                    }
                }
                foreach ($dbItems as $productId => $dbItem) {
                    if (!isset($sessionWishlist[$productId])) {
                        $dbItem->delete();
                    }
                }
            }
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
