<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BuyNow extends Component
{
    public $product;
    public $quantity = 1;
    public $selectedCombination = [];

    protected $listeners = [
        'buyNowWithVariant' => 'buyWithCombination',
        'showVariantRequired' => 'notifyMissingVariants',
    ];

    public function mount(Product $product, $qt = 1)
    {
        $this->product = $product;
        $this->quantity = $qt;
    }

    public function render()
    {
        return view('livewire.buy-now');
    }

    public function notifyMissingVariants($missingTypes = [])
    {
        $list = is_array($missingTypes) ? implode(', ', $missingTypes) : 'variant options';
        $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'Please select ' . $list . ' before buying');
    }

    public function buyWithCombination($combination = [], $qty = 1)
    {
        $this->selectedCombination = is_array($combination) ? $combination : [];
        $this->quantity = is_numeric($qty) ? (int)$qty : 1;
        $this->buyNow();
    }

    public function buyNow()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'client') {
            $this->dispatch('Notification', product: ['name' => 'Error'], message: 'Just clients can add to carts');
            return;
        }

        $product = Product::with('combinations')->findOrFail($this->product->id);

        if ($product->magasin->status !== 'active') {
            $this->dispatch('Notification', product: ['name' => $this->product->name], message: 'This vendor is not active');
            return;
        }

        // Server-side guard: if product has variant combinations, all of them must be selected
        if ($product->combinations && $product->combinations->count() > 0) {
            $requiredTypes = $product->combinations
                ->flatMap(fn($c) => array_keys($c->combination ?? []))
                ->unique()
                ->values()
                ->all();
            $missing = array_values(array_diff($requiredTypes, array_keys($this->selectedCombination ?: [])));
            if (count($missing) > 0) {
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Please select ' . implode(', ', $missing) . ' before buying');
                return;
            }
        }

        $cart = session()->get('cart', []);
        $cartKey = $product->id;
        $comboHash = !empty($this->selectedCombination) ? md5(json_encode($this->selectedCombination)) : null;
        if ($comboHash) {
            $cartKey = $product->id . '_' . $comboHash;
        }

        $extraPrice = 0;
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
                $extraPrice = $combo->extra_price;
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
        }

        if (isset($cart[$cartKey])) {
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
        return redirect()->route('frontend.cart');
    }
}
