<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wishlist extends Component
{
    protected $listeners = ['Notification' => 'refreshWishlist'];
    public $wishlist;
    public $availableStock;

    public function mount()
    {
        $this->wishlist = session()->get('wishlist', []);
        $this->availableStock = null;
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
                $wishlist = session()->get('wishlist', []);
                $qty = $quantity;

                // Check if enough stock available
                if ($product->actual_quantity < $qty) {
                    $qty = $product->actual_quantity;
                    $this->dispatch('Notification', product: ['name' => $product->name], message: 'Only ' . $product->actual_quantity . ' available in stock');
                }

                if (isset($wishlist[$productId])) {
                    $newQty = $wishlist[$productId]['quantity'] + $qty;
                    if ($newQty > $product->actual_quantity) {
                        $qty = $product->actual_quantity - $wishlist[$productId]['quantity'];
                        if ($qty < 0) $qty = 0;
                    }
                    $wishlist[$productId]['quantity'] = $newQty > $product->actual_quantity ? $product->actual_quantity : $newQty;
                } else {
                    $wishlist[$productId] = [
                        'quantity' => $qty,
                        'product' => [
                            'image' => $product->principalImage,
                            'name' => $product->name,
                            'actual_quantity' => $product->actual_quantity,
                            'price' => $product->price,
                        ]
                    ];
                }

                session()->put('wishlist', $wishlist);
                $this->dispatch('Notification', product: ['name' => $product->name], message: $qty . 'x ' . $product->name . ' added to cart');
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