<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteFromCart extends Component
{
    public $productId;

    public function render()
    {
        return view('livewire.delete-from-cart');
    }
    public function mount(Product $productId)
    {
        $this->productId = (string) $productId;
    }
    public function DeleteFromCart()
    {
        $user = Auth::user();
        if ($user) {
            $cart = session()->get('cart', []);
            if ($cart != []) {
                //if (isset($cart[$this->productId])) {
                unset($cart[$this->productId]);
                session()->put('cart', $cart);
                //}
            }
            return redirect()->back();
        } else {
            return redirect()->route('login');
        }
    }
}
