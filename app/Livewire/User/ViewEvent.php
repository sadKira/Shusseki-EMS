<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Event;
use App\Enums\EventStatus;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.user_app')]
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
        return view('livewire.user.view-event');
    }
}
