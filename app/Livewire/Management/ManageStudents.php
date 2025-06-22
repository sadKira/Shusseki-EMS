<?php

namespace App\Livewire\Management;

use App\Models\User;
use Livewire\Component;

class ManageStudents extends Component
{
    public function render()
    {
        $users = User::all();

        return view('livewire.management.manage-students', [
            'users' => $users,
        ]);
    }
}
