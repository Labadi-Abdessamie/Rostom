<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToCart extends Component
{
    public $product;
    public $quantity = 1;


    public function render()
    {
        return view('livewire.add-to-cart');
    }

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'client') {
                $product = Product::findOrFail($this->product->id);
                if ($product->magasin->status == 'active') {
                    $cart = session()->get('cart', []);
                    if (isset($cart[$this->product->id])) {
                        $cart[$this->product->id]['quantity']++;
                    } else {
                        $cart[$this->product->id] = [
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
                    session()->put('cart', $cart);
                    $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Added To cart');
                    //return redirect()->back()->with('success', 'Added');
                } else {
                    $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Error Adding To cart');
                }
            } else {
                $this->dispatch('Notification', product: "error", message: 'Just clients can add to carts');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
