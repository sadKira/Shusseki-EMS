<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Renderless;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class ManageApprovalBadge extends Component
{
    public $count = 0;
    public $currentRoute;

    public function mount($currentRoute = null)
    {
        $this->currentRoute = $currentRoute ?? Route::currentRouteName();
        $this->count = $this->getPendingCount();
    }

    #[\Livewire\Attributes\On('refreshPendingCount')]
    public function refreshPendingCount()
    {
        // Clear the cache and get fresh count
        Cache::forget('students:counts:pending');
        $this->count = $this->getPendingCount();
        
        // Force a re-render
        $this->dispatch('$refresh');
    }

    protected function getPendingCount(): int
    {
        return Cache::remember('students:counts:pending', 300, function () {
            return User::where('status', 'pending')->count();
        });
    }
    
    public function render()
    {
        return view('livewire.management.manage-approval-badge');
    }
}
