<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Route;

class ManageApprovalBadge extends Component
{
    public $count;
    public $currentRoute;

    public function mount($currentRoute = null)
    {
        $this->currentRoute = $currentRoute ?? Route::currentRouteName();
        $this->count = User::where('status', 'pending')->count();
    }

    #[\Livewire\Attributes\On('refreshPendingCount')]
    public function refreshPendingCount()
    {
        $this->count = User::where('status', 'pending')->count();
    }
    
    public function render()
    {
        return view('livewire.management.manage-approval-badge');
    }
}
