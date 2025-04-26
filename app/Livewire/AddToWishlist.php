<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToWishlist extends Component
{
    public $product;
    public $quantity = 1;

    public function render()
    {
        return view('livewire.add-to-wishlist');
    }

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToWishlist()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'client') {
                $product = Product::findOrFail($this->product->id);
                if ($product->magasin->status == 'active') {
                    $wishlist = session()->get('wishlist', []);
                    if (isset($wishlist[$this->product->id])) {
                        $wishlist[$this->product->id]['quantity']++;
                    } else {
                        $wishlist[$this->product->id] = [
                            'id' => null,
                            'quantity' => 1,
                            'product' => [
                                'image' => $this->product->principalImage,
                                'name' => $this->product->name,
                                'actual_quantity' => $this->product->actual_quantity,
                                'price' => $this->product->price,
                            ]
                        ];
                    }
                    session()->put('wishlist', $wishlist);
                    $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Added To wishlist');
                } else {
                    $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Error Adding To wishlist');
                }
            } else {
                $this->dispatch('Notification', product: ['name' => "Error :"], message: 'Just clients can add to wishlists');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
