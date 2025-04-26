<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BuyNow extends Component
{
    public  $product;
    public  $quantity = 1;

    public function mount(Product $product, $qt = 1)
    {
        $this->product = $product;
        $this->quantity = $qt;
    }
    public function render()
    {
        return view('livewire.buy-now');
    }
    public function buyNow()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role === 'client') {
                $product = Product::findOrFail($this->product->id);
                if ($product->magasin->status == 'active') {
                    $cart = session()->get('cart', []);
                    if (isset($cart[$this->product->id])) {
                        $cart[$this->product->id]['quantity'] += $this->quantity;
                    } else {
                        $cart[$this->product->id] = [
                            'id' => null,
                            'quantity' => $this->quantity,
                            'product' => [
                                'image' => $this->product->principalImage,
                                'name' => $this->product->name,
                                'actual_quantity' => $this->product->actual_quantity,
                                'price' => $this->product->price,
                            ]
                        ];
                    }
                    session()->put('cart', $cart);
                    return redirect()->route('frontend.cart');
                } else {
                    $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Error Adding To cart');
                }
            } else {
                $this->dispatch('Notification', product: ['name' => "Error :"], message: 'Just clients can add to carts');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
