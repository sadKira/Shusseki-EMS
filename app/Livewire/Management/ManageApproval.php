<?php

namespace App\Livewire\Management;

use App\Mail\AccountApprove;
use App\Mail\AccountRejected;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Flux\Flux;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class ManageApproval extends Component
{
    use WithPagination;

    public $search = '';

    // Multi select
    public $selected = [];
    public $selectAll = false;
    public $selectPage = false;

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Approval
    public function approve($userId)
    {
        $user = User::find($userId);
        $user->update(['status' => 'approved']);

        Mail::to($user->email)->queue(new AccountApprove($user));

        // Clear the pending count cache
        Cache::forget('students:counts:pending');
        
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Rejection
    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        
        Mail::to($user->email)->queue(new AccountRejected());

        $user->delete();
        
        // Clear the pending count cache
        Cache::forget('students:counts:pending');
        
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate(10);
    }

    public function getUsersQueryProperty()
    {
        return User::query()->where('status', 'pending')
        ->latest()
        ->search($this->search);
    }

    // Update selection
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->users->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->selected = $this->usersQuery->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }

    public function cancelSelection()
    {
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }

    // Approve selected
    public function bulkApprove()
    {
        // Fetch selected users
        $users = User::whereIn('id', $this->selected)->get();

        // Approve selected
        foreach ($users as $index => $user) {
            $user->update(['status' => 'approved']);

            // Send email
            Mail::to($user->email)
            ->later(now()->addSeconds($index * 10), new AccountApprove($user));
        }

        // Clear the pending count cache
        Cache::forget('students:counts:pending');
        
        $this->cancelSelection();
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Reject selected
    public function bulkReject()
    {
        // Fetch selected users
        $users = User::whereIn('id', $this->selected)->get();

        // Reject selected
        foreach ($users as $index => $user) {
            // Send email
            Mail::to($user->email)
            ->later(now()->addSeconds($index * 10), new AccountRejected());

            $user->delete();
        }

        // Clear the pending count cache
        Cache::forget('students:counts:pending');
        
        $this->cancelSelection();
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Bulk approve
    public function totalbulkApprove()
    {
        // Fetch users
        $users = User::where('status', 'pending')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->get();

        // Approve all users
        foreach ($users as $index => $user) {
            $user->update(['status' => 'approved']);

            // Send email
            Mail::to($user->email)
            ->later(now()->addSeconds($index * 10), new AccountApprove($user));
        }

        // Clear the pending count cache
        Cache::forget('students:counts:pending');

        $this->cancelSelection();
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Bulk reject
    public function totalbulkReject()
    {
        // Fetch users
        $users = User::where('status', 'pending')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->get();

        // Reject all users
        foreach ($users as $index => $user) {
            // Send email
            Mail::to($user->email)
            ->later(now()->addSeconds($index * 10), new AccountRejected());

            $user->delete();
        }
        
        // Clear the pending count cache
        Cache::forget('students:counts:pending');
        
        $this->cancelSelection();

        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    public function render()
    {
        // Get cached pending count (like FilterTable does)
        $pendingCount = Cache::remember('students:counts:pending', 300, function () {
            return User::where('status', 'pending')->count();
        });

        return view('livewire.management.manage-approval', [
            'users' => $this->users,
            'pendingCount' => $pendingCount,
        ]);
    }
}
