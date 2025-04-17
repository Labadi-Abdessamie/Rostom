<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use App\Models\BagItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $cart = session()->get('cart', []);
            return view('frontend.pages.cart_view', compact('cart'));
        } else {
            return redirect()->route('login');
        }
    }
    public function clearCart()
    {
        $user = Auth::user();
        if ($user) {
            session(['cart' => []]);
            /*$cart = $user->bags->where('type', 'cart')->first();
            foreach ($cart->bagItems as $item) {
                BagItem::destroy($item->id);
            }
            */
            return redirect()->route('frontend.cart');
        } else {
            return redirect()->route('login');
        }
    }
    public function removeItem($item_id)
    {
        $user = Auth::user();
        if ($user) {
            $cart = session()->get('cart', []);
            if ($cart != []) {
                unset($cart[$item_id]);
                session()->put('cart', $cart);
            }
            return redirect()->back();
        } else {
            return redirect()->route('login');
        }
    }
    public function addItem($product_id)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::findOrFail($product_id);
            if ($product->magasin->status == 'active') {
                $cart = session()->get('cart', []);
                if (isset($cart[$product_id])) {
                    $cart[$product_id]['quantity']++;
                } else {
                    $cart[$product_id] = [
                        'id' => null,
                        'quantity' => 1,
                        'product' => [
                            'image' => $product->principalImage,
                            'name' => $product->name,
                            'actual_quantity' => $product->actual_quantity,
                            'price' => $product->price,
                        ]
                    ];
                }
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Added');
            } else {
                return redirect()->back()->with('error', 'This product is unavailable.');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function updateItem($item_id) {}
}
