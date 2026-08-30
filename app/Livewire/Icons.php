<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Icons extends Component
{
    protected $listeners = ['Notification' => 'render', 'refreshIcons' => 'render'];

    public $cartCount = 0;
    public $wishlistCount = 0;
    public $compareCount = 0;

    public function mount()
    {
        $this->refreshCounts();
    }

    public function refreshCounts()
    {
        $this->cartCount = count(session('cart', []));
        $this->wishlistCount = count(session('wishlist', []));
        $this->compareCount = count(session('compare', []));
    }

    public function render()
    {
        $this->refreshCounts();
        return view('livewire.icons');
    }
}
