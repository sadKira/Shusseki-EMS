<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;

class ViewEvent extends Component
{

    public $event;
    
    // Mounting data
    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.management.view-event');
    }
}
