<?php

namespace App\Livewire;

use Livewire\Component;

class UpdateQuantity extends Component
{
    public $type;
    public $product_id;
    public $quantity;

    public function mount($type, $id, $qt)
    {
        $this->type = $type;
        $this->product_id = $id;
        $this->quantity = $qt;
    }
    public function render()
    {
        return view('livewire.update-quantity');
    }
    public function updatedQuantity($value)
    {
        $bag = session()->get($this->type, []);
        if (isset($bag[$this->product_id])) {
            $bag[$this->product_id]['quantity'] = $value;
            $this->quantity = $value;
            session()->put($this->type, $bag);
            $this->dispatch('Notification', product: ['name' => 'Product'], message: "Updated");
        } else {
            $this->dispatch('Notification', product: ['name' => 'Product'], message: "Error Updating");
        }
    }
    public function increase()
    {
        $this->updatedQuantity($this->quantity + 1);
    }
    public function decrease()
    {
        if ($this->quantity > 1) {
            $this->updatedQuantity($this->quantity - 1);
        }
    }
}
