<?php

namespace App\Livewire;

use App\Models\BagItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{

    protected $listeners = ['Notification' => 'refreshCart'];
    public $cart;
    public $type;

    public function mount($type)
    {
        $this->type = $type;
        $this->cart = session()->get('cart', []);
    }

    public function refreshCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function DeleteFromCart($productId)
    {
        $user = Auth::user();
        if ($user) {
            $cart = session()->get('cart', []);
            if ($cart != []) {
                if (isset($cart[$productId])) {
                    unset($cart[$productId]);
                    session()->put('cart', $cart);
                    $this->dispatch('Notification', product: ['name' => 'Product'], message: 'Removed From cart');
                }
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function ClearCart()
    {
        $user = Auth::user();
        if ($user) {
            session()->put('cart', []);
            $this->dispatch('Notification', product: ['name' => 'Cart'], message: 'Cleared');
        } else {
            return redirect()->route('login');
        }
    }
    public function render()
    {
        if ($this->type == "mini") {
            return view('livewire.mini-cart');
        }
        return view('livewire.cart');
    }
}
