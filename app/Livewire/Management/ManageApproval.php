<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;

class ManageApproval extends Component
{
    // User approval
    public function approve($userId)
    {
        $user = User::find($userId);
        $user->update(['status' => 'approved']);
        session()->flash('message', "{$user->name} has been approved.");

        // return redirect(request()->route('manage_approval')); 
    }

    // User reject
    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete(); // This permanently deletes the account
       
    }

    // Multi select functionality
    public $selected = [];
    public $selectAll = false;
    public $selectPage = false;

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = User::where('status', 'pending')->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function cancelSelection()
    {
        $this->selected = [];
        $this->selectPage = false;
    }

    public function bulkApprove()
    {
        User::whereIn('id', $this->selected)->update(['status' => 'approved']);
        $this->cancelSelection();
        session()->flash('message', 'Selected users approved successfully.');
    }

    public function bulkReject()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->cancelSelection();
        session()->flash('message', 'Selected users rejected and deleted.');
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_diff($this->selected, [$id]);
        } else {
            $this->selected[] = $id;
        }
    }
    public function render()
    {
        $users = User::where('status', 'pending')->get();
        return view('livewire.management.manage-approval', ['users' => $users]);
    }
    
}
