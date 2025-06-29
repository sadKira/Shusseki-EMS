<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class ManageApproval extends Component
{
    use WithPagination;

    public $selected = [];
    public $selectAll = false;
    public $selectPage = false;

    // Approval
    public function approve($userId)
    {
        $user = User::find($userId);
        $user->update(['status' => 'approved']);
        session()->flash('message', "{$user->name} has been approved.");
    }

    // Rejection
    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
    }

    public function getUsersProperty()
    {
        return $this->usersQuery->paginate(10);
    }

    public function getUsersQueryProperty()
    {
        return User::query()->where('status', 'pending')->latest();
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->users->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->selected = $this->usersQuery->pluck('id')->map(fn ($id) => (string) $id)->toArray();
    }

    public function cancelSelection()
    {
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }

    public function bulkApprove()
    {
        User::whereIn('id', $this->selected)->update(['status' => 'approved']);
        $this->cancelSelection();
        session()->flash('message', 'Selected users approved successfully.');
        $this->redirectRoute('manage_approval');
    }

    public function bulkReject()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->cancelSelection();
        session()->flash('message', 'Selected users rejected and deleted.');
        $this->redirectRoute('manage_approval');
    }

    public function render()
    {
        return view('livewire.management.manage-approval', [
            'users' => $this->users,
            'pendingCount' => $this->usersQuery->count(),
        ]);
    }
}
