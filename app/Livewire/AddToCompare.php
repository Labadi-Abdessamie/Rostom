<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class AddToCompare extends Component
{
    public $productId;

    public function render()
    {
        return view('livewire.add-to-compare');
    }
    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function addToCompare()
    {
        $product = Product::findOrFail($this->productId);
        $compare = session()->get('compare', []);
        if (isset($compare[$this->productId])) {
        } else {
            $compare[$this->productId] = [
                'name' => $product->name,
                'image' => $product->principalImage,
                'actual_quantity' => $product->actual_quantity,
                'rate' => $product->rate_average,
                'price' => $product->price,
            ];
        }
        session()->put('compare', $compare);
        $this->dispatch('Notification', product: ['name' => $product->name], message: 'Added To compare');
        //return redirect()->back()->with('success', 'Added');
    }
}
