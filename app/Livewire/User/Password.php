<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.user.layout')]
class Password extends Component
{
    public function render()
    {
        return view('livewire.user.password');
    }
}
