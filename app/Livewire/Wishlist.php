<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wishlist extends Component
{
    protected $listeners = ['Notification' => 'refreshWishlist'];
    public $wishlist;

    public function mount()
    {
        $this->wishlist = session()->get('wishlist', []);
    }

    public function refreshWishlist()
    {
        $this->wishlist = session()->get('wishlist', []);
    }

    public function DeleteFromWishlist($productId)
    {
        $user = Auth::user();
        if ($user) {
            $wishlist = session()->get('wishlist', []);
            if ($wishlist != []) {
                if (isset($wishlist[$productId])) {
                    unset($wishlist[$productId]);
                    session()->put('wishlist', $wishlist);
                    $this->dispatch('Notification', product: ['name' => 'Product'], message: 'Removed From wishlist');
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function addToCart($productId, $quantity = 1)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::findOrFail($productId);
            if ($product->magasin->status == 'active') {
                $cart = session()->get('cart', []);
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $quantity;
                } else {
                    $cart[$productId] = [
                        'id' => null,
                        'quantity' => $quantity,
                        'product' => [
                            'image' => $product->principalImage,
                            'name' => $product->name,
                            'actual_quantity' => $product->actual_quantity,
                            'price' => $product->price,
                        ]
                    ];
                }
                session()->put('cart', $cart);
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Added To cart');
            } else {
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Error Adding To cart');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function ClearWishlist()
    {
        $user = Auth::user();
        if ($user) {
            session()->put('wishlist', []);
            $this->dispatch('Notification', product: ['name' => 'Wishlist'], message: 'Cleared');
        } else {
            return redirect()->route('login');
        }
    }
    public function render()
    {
        return view('livewire.wishlist');
    }
}
