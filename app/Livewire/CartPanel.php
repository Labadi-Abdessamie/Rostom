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
            $base = $item['product']['base_price'] ?? $item['product']['price'] ?? 0;
            $extra = $item['extra_price'] ?? 0;
            $subtotal += ($base + $extra) * ($item['quantity'] ?? 1);
            $itemCount += (int) ($item['quantity'] ?? 1);
        }
        $this->subtotal = $subtotal;
        $this->itemCount = $itemCount;
    }

    public function DeleteFromCart($cartKey)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        $cart = session()->get('cart', []);
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            $this->refresh();
            $this->dispatch('refreshIcons');
            $this->dispatch('Notification', product: ['name' => 'Product'], message: 'Removed from cart');
        }
    }

    public function increaseQuantity($cartKey)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        $cart = session()->get('cart', []);
        if (! isset($cart[$cartKey])) {
            return;
        }
        $current = (int) ($cart[$cartKey]['quantity'] ?? 1);
        $maxStock = (int) ($cart[$cartKey]['product']['actual_quantity'] ?? 999);

        // If the cart item has a variant combination, look up the real combo stock
        if (!empty($cart[$cartKey]['combination'])) {
            $numericId = (int) explode('_', $cartKey)[0];
            $product = \App\Models\Product::with('combinations')->find($numericId);
            if ($product && $product->combinations) {
                $savedCombo = $cart[$cartKey]['combination'];
                $combo = $product->combinations->first(function ($c) use ($savedCombo) {
                    $comboData = $c->combination;
                    foreach ($savedCombo as $k => $v) {
                        if (!isset($comboData[$k]) || $comboData[$k] !== $v) {
                            return false;
                        }
                    }
                    return true;
                });
                if ($combo && $combo->quantity > 0) {
                    $maxStock = (int) $combo->quantity;
                }
            }
        }

        if ($current >= $maxStock) {
            $this->dispatch('Notification', product: ['name' => $cart[$cartKey]['product']['name'] ?? 'Product'], message: 'No more stock available');
            return;
        }
        $cart[$cartKey]['quantity'] = $current + 1;
        session()->put('cart', $cart);
        $this->refresh();
        $this->dispatch('refreshIcons');
    }

    public function decreaseQuantity($cartKey)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }
        $cart = session()->get('cart', []);
        if (! isset($cart[$cartKey])) {
            return;
        }
        $current = (int) ($cart[$cartKey]['quantity'] ?? 1);
        if ($current <= 1) {
            return;
        }
        $cart[$cartKey]['quantity'] = $current - 1;
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

