<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Enums\Tags;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $title, $description, $date, $location;
    public $start_time, $end_time, $image;
    public $tag;

    public $selectedSchoolYear; // This will be bound to the global school year

    protected function rules()
    {
        return [
            'title' => 'required|string|max:155',
            'description' => 'required|string|min:40|max:155',
            'date' => 'required|string',
            'location' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i   ',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'tag' => ['required', new Enum(Tags::class)],
            'image' => 'required|image|max:2048',
        ];
    }

    public function mount()
    {
        $this->selectedSchoolYear = session('selectedSchoolYear'); // Assuming it’s set globally
    }

    public function createEvent()
    {
        $this->validate();

        // Convert date and time to correct format
        $formattedDate = Carbon::createFromFormat('F d, Y', $this->date)->format('Y-m-d');
        $formattedStart = Carbon::createFromFormat('H:i', $this->start_time)->format('H:i:s');
        $formattedEnd = Carbon::createFromFormat('H:i', $this->end_time)->format('H:i:s');

        // Handle image upload
        $imagePath = $this->image ? $this->image->store('events', 'public') : null;

        $event = Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'date' => $formattedDate,
            'location' => $this->location,
            'start_time' => $formattedStart,
            'end_time' => $formattedEnd,
            'school_year' => $this->selectedSchoolYear,
            'image' => $imagePath,
            'tag' => $this->tag, 
        ]);

        session()->flash('success', 'Event created successfully!');

        return redirect()->route('manage_events');
    }

    public function render()
    {
        return view('livewire.management.create-event', [
            'tags' => Tags::cases(),
        ]);
    }
}
