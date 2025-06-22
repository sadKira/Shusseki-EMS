<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.user_app')]
class Dashboard extends Component
{
    public $user; // or: public $user;

    public function mount()
    {
        $this->user = Auth::user();

    }
    public function render()
    {
        return view('livewire.user.dashboard');
    }
}
