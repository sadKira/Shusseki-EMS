<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use App\Enums\EventStatus;

class ViewEvent extends Component
{

    public $event;
    
    // Mounting data
    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function markEventAsPostponed() 
    {
        //  Mark event as finished
        $this->event->status = EventStatus::Postponed;
        $this->event->save();

        return redirect()->route('view_event', $this->event);
    }

    public function markEventAsResumed() 
    {
        //  Mark event as finished
        $this->event->status = EventStatus::NotFinished;
        $this->event->save();

        return redirect()->route('view_event', $this->event);
    }

    public function render()
    {
        return view('livewire.management.view-event');
    }
}
