<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Renderless;

class ManageApprovalBadge extends Component
{
    public $count;

    public function mount()
    {
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
