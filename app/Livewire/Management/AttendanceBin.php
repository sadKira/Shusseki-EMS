<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.attendance_bin_app')]
class AttendanceBin extends Component
{
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    

    public function render()
    {
        return view('livewire.management.attendance-bin');
    }
}
