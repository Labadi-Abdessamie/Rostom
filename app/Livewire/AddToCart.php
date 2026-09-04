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
    public $selectedCombination = [];

    protected $listeners = [
        'addToCartWithVariant' => 'addWithCombination',
        'showVariantRequired' => 'notifyMissingVariants',
    ];

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

    public function notifyMissingVariants($missingTypes = [])
    {
        $list = is_array($missingTypes) ? implode(', ', $missingTypes) : 'variant options';
        $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Please select ' . $list . ' before adding to cart');
    }

    public function addWithCombination($combination = [], $qty = 1)
    {
        $this->selectedCombination = is_array($combination) ? $combination : [];
        $this->quantity = is_numeric($qty) ? (int)$qty : 1;
        $this->addToCart();
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

        $product = Product::with('combinations')->findOrFail($this->product->id);

        // Server-side guard: if product has variant combinations, all of them must be selected
        if ($product->combinations && $product->combinations->count() > 0) {
            $requiredTypes = $product->combinations
                ->flatMap(fn($c) => array_keys($c->combination ?? []))
                ->unique()
                ->values()
                ->all();
            $missing = array_values(array_diff($requiredTypes, array_keys($this->selectedCombination ?: [])));
            if (count($missing) > 0) {
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Please select ' . implode(', ', $missing) . ' before adding to cart');
                return;
            }
        }

        // Check if vendor's magasin is active
        if ($product->magasin->status !== 'active') {
            $this->dispatch('Notification', product: ['name' => $product->name], message: 'This vendor is not active');
            return;
        }

        // Variant-aware stock check
        $stock = $product->actual_quantity;
        if (!empty($this->selectedCombination)) {
            $combo = $product->combinations->first(function ($c) {
                $comboData = $c->combination;
                foreach ($this->selectedCombination as $k => $v) {
                    if (!isset($comboData[$k]) || $comboData[$k] !== $v) {
                        return false;
                    }
                }
                return true;
            });
            if ($combo) {
                $stock = $combo->quantity;
            }
        }

        if ($stock <= 0) {
            $this->dispatch('Notification', product: ['name' => $product->name], message: 'Selected variant is out of stock');
            return;
        }

        $qty = $this->quantity;
        if ($qty > $stock) {
            $qty = $stock;
            $this->dispatch('Notification', product: ['name' => $product->name], message: 'Quantity adjusted to available stock');
        }

        $cart = session()->get('cart', []);
        $cartKey = $product->id;
        $comboHash = !empty($this->selectedCombination) ? md5(json_encode($this->selectedCombination)) : null;
        if ($comboHash) {
            $cartKey = $product->id . '_' . $comboHash;
        }

        $extraPrice = 0;
        if (!empty($this->selectedCombination)) {
            $combo = $product->combinations->first(function ($c) {
                $comboData = $c->combination;
                foreach ($this->selectedCombination as $k => $v) {
                    if (!isset($comboData[$k]) || $comboData[$k] !== $v) {
                        return false;
                    }
                }
                return true;
            });
            if ($combo) {
                $extraPrice = $combo->extra_price;
            }
        }

        if (isset($cart[$cartKey])) {
            $newQty = $cart[$cartKey]['quantity'] + $qty;
            if ($newQty > $stock) {
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Cannot add more than available stock');
                return;
            }
            $cart[$cartKey]['quantity'] += $qty;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'quantity' => $qty,
                'combination' => !empty($this->selectedCombination) ? $this->selectedCombination : null,
                'extra_price' => $extraPrice,
                'product' => [
                    'image' => $product->principalImage,
                    'name' => $product->name,
                    'price' => $product->price,
                    'base_price' => $product->price,
                    'actual_quantity' => $stock,
                ]
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('Notification', product: ['name' => $product->name], message: $qty . 'x ' . $product->name . ' added to cart');
    }
}
