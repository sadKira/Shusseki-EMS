<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class EditProfileTab extends Component
{
    public $currentRoute;

    public function mount($currentRoute = null)
    {
        $this->currentRoute = $currentRoute ?? Route::currentRouteName();
    }
    public function render()
    {
        return view('livewire.user.edit-profile-tab');
    }
}
