<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;

class ManageApproval extends Component
{
    public function approve($userId)
    {
        $user = User::find($userId);
        $user->update(['status' => 'approved']);
        session()->flash('message', "{$user->name} has been approved.");

        // return redirect(request()->route('manage_approval')); 
    }

    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete(); // This permanently deletes the account
       
    }
    public function render()
    {
        $users = User::where('status', 'pending')->get();
        return view('livewire.management.manage-approval', ['users' => $users]);
    }
    
}
