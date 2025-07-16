<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Validation\Rule;

class EditEvent extends Component
{
    use WithFileUploads;

    public $event;
    public $title, $description, $date, $location;
    public $time_in, $start_time, $end_time, $image;

    // Mounting data
    public function mount(Event $event)
    {
        $this->event = $event;

        $this->title = $event->title;
        $this->description = $event->description;
        $this->date = Carbon::parse($event->date)->format('F d, Y');
        $this->location = $event->location;
        $this->time_in = Carbon::parse($event->time_in)->format('h:i A');
        $this->start_time = Carbon::parse($event->start_time)->format('h:i A');
        $this->end_time = Carbon::parse($event->end_time)->format('h:i A');
    }

    protected function rules()
    {
        return [
            'title' => [
            'required',
            'string',
            'max:155',
            // Rule::unique('events', 'title')->ignore($this->event->id)
            ],

            'description' => 'required|string|min:40|max:2000',
            'date' => 'required|string',
            'location' => 'required|string|max:255',
            'time_in' => 'required|date_format:h:i A',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A|after:start_time',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function updateEvent()
    {
        $this->validate();

        $formattedDate = Carbon::createFromFormat('F d, Y', $this->date)->format('Y-m-d');
        $formattedIn = Carbon::createFromFormat('h:i A', $this->time_in)->format('H:i:s');
        $formattedStart = Carbon::createFromFormat('h:i A', $this->start_time)->format('H:i:s');
        $formattedEnd = Carbon::createFromFormat('h:i A', $this->end_time)->format('H:i:s');

        if ($this->image) {
            // Delete old image
            if ($this->event->image) {
                Storage::disk('public')->delete($this->event->image);
            }
            $imagePath = $this->image->store('events', 'public');
            $this->event->image = $imagePath;
        }

        $this->event->update([
            'title' => $this->title,
            'description' => $this->description,
            'date' => $formattedDate,
            'location' => $this->location,
            'time_in' => $formattedIn,
            'start_time' => $formattedStart,
            'end_time' => $formattedEnd,
        ]);

        return redirect()->route('view_event', $this->event);
    }


    public function render()
    {
        return view('livewire.management.edit-event');
    }
}
