<?php

namespace App\Livewire\Management;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

// #[Layout('components.layouts.app.sidebar')]
class ManageStudents extends Component
{
    public function render()
    {
        return view('livewire.management.manage-students');
    }
}
