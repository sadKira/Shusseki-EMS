<?php

namespace App\Livewire\Tsuushin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.user_app')]
class TsuushinDashboard extends Component
{
    public function render()
    {
        return view('livewire.tsuushin.tsuushin-dashboard');
    }
}
