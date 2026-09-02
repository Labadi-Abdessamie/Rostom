<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartPanel extends Component
{
    public $isOpen = false;
    public $cart = [];
    public $subtotal = 0;
    public $itemCount = 0;

    protected $listeners = [
        'open-cart-panel' => 'open',
        'close-cart-panel' => 'close',
        'toggle-cart-panel' => 'toggle',
        'Notification' => 'refresh',
        'refreshCart' => 'refresh',
    ];

    public function mount()
    {
        $this->refresh();
    }

    public function open()
    {
        $this->refresh();
        $this->isOpen = true;
        $this->dispatch('cart-panel-sync', ['open' => true]);
    }

    public function close()
    {
        $this->isOpen = false;
        $this->dispatch('cart-panel-sync', ['open' => false]);
    }

    public function toggle()
    {
        if ($this->isOpen) {
            $this->close();
        } else {
            $this->open();
        }
    }

    public function refresh()
    {
        $this->cart = session()->get('cart', []);

        $subtotal = 0;
        $itemCount = 0;
        foreach ($this->cart as $item) {
            $subtotal += ($item['product']['price'] ?? 0) * ($item['quantity'] ?? 1);
            $itemCount += (int) ($item['quantity'] ?? 1);
        }
        $this->subtotal = $subtotal;
        $this->itemCount = $itemCount;
    }

    public function DeleteFromCart($productId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            $this->refresh();
            $this->dispatch('refreshIcons');
            $this->dispatch('Notification', product: ['name' => 'Product'], message: 'Removed from cart');
        }
    }

    public function increaseQuantity($productId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        $cart = session()->get('cart', []);
        if (! isset($cart[$productId])) {
            return;
        }
        $current = (int) ($cart[$productId]['quantity'] ?? 1);
        $maxStock = (int) ($cart[$productId]['product']['actual_quantity'] ?? 999);
        if ($current >= $maxStock) {
            $this->dispatch('Notification', product: ['name' => $cart[$productId]['product']['name'] ?? 'Product'], message: 'No more stock available');
            return;
        }
        $cart[$productId]['quantity'] = $current + 1;
        session()->put('cart', $cart);
        $this->refresh();
        $this->dispatch('refreshIcons');
    }

    public function decreaseQuantity($productId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        $cart = session()->get('cart', []);
        if (! isset($cart[$productId])) {
            return;
        }
        $current = (int) ($cart[$productId]['quantity'] ?? 1);
        if ($current <= 1) {
            return;
        }
        $cart[$productId]['quantity'] = $current - 1;
        session()->put('cart', $cart);
        $this->refresh();
        $this->dispatch('refreshIcons');
    }

    public function ClearCart()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        session()->put('cart', []);
        $this->refresh();
        $this->dispatch('refreshIcons');
        $this->dispatch('Notification', product: ['name' => 'Cart'], message: 'Cleared');
    }

    public function render()
    {
        return view('livewire.cart-panel');
    }
}

