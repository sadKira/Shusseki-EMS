<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing_app')]
class Welcome extends Component
{
    public function render()
    {
        return view('livewire.landing.welcome');
    }
}
