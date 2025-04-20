<?php

namespace App\Livewire;

use Livewire\Component;

class Icons extends Component
{
    protected $listeners = ['Notification' => 'render'];
    public function render()
    {
        return view('livewire.icons');
    }
}
