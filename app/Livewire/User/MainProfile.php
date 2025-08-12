<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.user.layout')]

class MainProfile extends Component
{
    public function render()
    {
        return view('livewire.user.main-profile');
    }
}
