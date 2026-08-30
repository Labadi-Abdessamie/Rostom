<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToCart extends Component
{
    public $product;
    public $quantity = 1;
    public $availableStock;
    public $error;

    public function render()
    {
        $this->availableStock = $this->product->actual_quantity;
        return view('livewire.add-to-cart');
    }

    public function mount(Product $product, $qt = 1)
    {
        $this->product = $product;
        $this->quantity = $qt;
        $this->availableStock = $product->actual_quantity;
        $this->error = null;
    }

    public function addToCart()
    {
        $this->error = null;
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'client') {
            $this->dispatch('Notification', product: ['name' => 'Error'], message: 'Only clients can add to cart');
            return;
        }

        $product = Product::findOrFail($this->product->id);

        // Check if vendor's magasin is active
        if ($product->magasin->status !== 'active') {
            $this->dispatch('Notification', product: ['name' => $product->name], message: 'This vendor is not active');
            return;
        }

        // Check stock availability
        if ($product->actual_quantity <= 0) {
            $this->dispatch('Notification', product: ['name' => $product->name], message: 'Out of stock');
            return;
        }

        // Validate quantity against available stock
        $qty = $this->quantity;
        if ($qty > $product->actual_quantity) {
            $qty = $product->actual_quantity;
            $this->dispatch('Notification', product: ['name' => $product->name], message: 'Quantity adjusted to available stock');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['quantity'] + $qty;
            if ($newQty > $product->actual_quantity) {
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Cannot add more than available stock');
                return;
            }
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'quantity' => $qty,
                'product' => [
                    'image' => $product->principalImage,
                    'name' => $product->name,
                    'actual_quantity' => $product->actual_quantity,
                    'price' => $product->price,
                ]
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('Notification', product: ['name' => $product->name], message: $qty . 'x ' . $product->name . ' added to cart');
    }
}