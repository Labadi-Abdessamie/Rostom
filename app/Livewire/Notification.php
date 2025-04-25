<?php

namespace App\Livewire;

use Livewire\Component;

class Notification extends Component
{
    protected $listeners = ['Notification' => 'showNotification'];
    public $show = false;
    public $message;
    public $productName;

    public function render()
    {
        return view('livewire.notification');
    }
    public function showNotification($product, $message)
    {
        if ($message == "Added To cart") {
            $this->productName = $product;
        } else {
            $this->productName = null;
        }
        $this->message = $message;
        $this->show = true;
        $this->dispatch('hide-notification');
    }
    public function hideNotification()
    {
        $this->show = false;
    }
}
