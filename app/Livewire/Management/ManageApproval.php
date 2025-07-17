<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Flux\Flux;

class ManageApproval extends Component
{
    use WithPagination;

    // Multi select
    public $selected = [];
    public $selectAll = false;
    public $selectPage = false;

    // Approval
    public function approve($userId)
    {
        $user = User::find($userId);
        $user->update(['status' => 'approved']);
        session()->flash('message', "{$user->name} has been approved.");
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Rejection
    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
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
        return User::query()->where('status', 'pending')->latest();
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
        User::whereIn('id', $this->selected)->update(['status' => 'approved']);
        $this->cancelSelection();
        session()->flash('message', 'Selected users approved successfully.');
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Reject selected
    public function bulkReject()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->cancelSelection();
        session()->flash('message', 'Selected users rejected and deleted.');
        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
    }

    // Bulk appprove
    public function totalbulkApprove()
    {
        User::where('status', 'pending')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->update(['status' => 'approved']);
        session()->flash('message', 'All pending users approved.');

        $this->cancelSelection();

        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();

    }

    // Bulk reject
    public function totalbulkReject()
    {
        User::where('status', 'pending')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->delete();
        session()->flash('message', 'All pending users rejected and deleted.');

        $this->cancelSelection();

        $this->dispatch('refreshPendingCount');

        // Close modal
        Flux::modals()->close();
        
    }

    public function render()
    {
        return view('livewire.management.manage-approval', [
            'users' => $this->users,
            'pendingCount' => $this->usersQuery->count(),
        ]);
    }
}
