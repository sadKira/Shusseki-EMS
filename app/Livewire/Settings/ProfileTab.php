<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class ProfileTab extends Component
{
    public $currentRoute;

    public function mount($currentRoute = null)
    {
        $this->currentRoute = $currentRoute ?? Route::currentRouteName();
    }

    public function render()
    {
        return view('livewire.settings.profile-tab');
    }
}
