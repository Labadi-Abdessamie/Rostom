<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Compare extends Component
{
    protected $listeners = ['Notification' => 'refreshCompare'];
    public $items;

    public function mount()
    {
        $this->items = session()->get('compare', []);
    }

    public function refreshCompare()
    {
        $this->items = session()->get('compare', []);
    }

    public function DeleteFromCompare($productId)
    {
        $compare = session()->get('compare', []);
        if ($compare != []) {
            if (isset($compare[$productId])) {
                unset($compare[$productId]);
                session()->put('compare', $compare);
                $this->dispatch('Notification', product: ['name' => 'Product'], message: 'Removed From compare');
            }
        }
    }

    public function addToCart($productId)
    {
        $user = Auth::user();
        if ($user) {
            $product = Product::findOrFail($productId);
            if ($product->magasin->status == 'active') {
                $cart = session()->get('cart', []);
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity']++;
                } else {
                    $cart[$productId] = [
                        'id' => null,
                        'quantity' => 1,
                        'product' => [
                            'image' => $product->principalImage,
                            'name' => $product->name,
                            'actual_quantity' => $product->actual_quantity,
                            'price' => $product->price,
                        ]
                    ];
                }
                session()->put('cart', $cart);
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Added To cart');
                //return redirect()->back()->with('success', 'Added');
            } else {
                $this->dispatch('Notification', product: ['name' => $product->name], message: 'Error Adding To cart');
            }
        } else {
            return redirect()->route('login');
        }
    }



    public function render()
    {
        return view('livewire.compare');
    }
}
