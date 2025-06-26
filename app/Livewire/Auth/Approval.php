<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth')]
class Approval extends Component
{
    public function render()
    {
        return view('livewire.auth.approval');
    }
}
