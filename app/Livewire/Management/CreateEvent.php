<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use App\Models\Setting;
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
    public $tag = null;

    public $selectedSchoolYear; // This will be bound to the global school year

    protected function rules()
    {
        // dd($this->tag);
        return [
            'title' => 'required|string|max:155',
            'description' => 'required|string|min:40|max:2000',
            'date' => 'required|string',
            'location' => 'required|string|max:255',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A|after:start_time',
            'tag' => ['required', new Enum(Tags::class)],
            'image' => 'required|image|max:2048',
        ];
    }

    public function mount()
    {
        $this->selectedSchoolYear = Setting::getSchoolYear(); // Get current school year from settings
    }
    // {
    //     // dd('called');
    //     $this->validate();

    //     // Convert date and time to correct format
    //     $formattedDate = Carbon::createFromFormat('F d, Y', $this->date)->format('Y-m-d');
    //     $formattedStart = Carbon::createFromFormat('h:i A', $this->start_time)->format('H:i:s');
    //     $formattedEnd = Carbon::createFromFormat('h:i A', $this->end_time)->format('H:i:s');

    //     // Handle image upload
    //     $imagePath = $this->image ? $this->image->store('events', 'public') : null;

    //     $event = Event::create([
    //         'title' => $this->title,
    //         'description' => $this->description,
    //         'date' => $formattedDate,
    //         'location' => $this->location,
    //         'start_time' => $formattedStart,
    //         'end_time' => $formattedEnd,
    //         'school_year' => $this->selectedSchoolYear,
    //         'image' => $imagePath,
    //         'tag' => $this->tag, 
    //     ]);

    //     session()->flash('success', 'Event created successfully!');

    //     return redirect()->route('manage_events');
    // }


    public function createEvent()
    {
        // try {
            $this->validate();

            // Debug: see what value is coming in
            // dd($this->date);

            $formattedDate = Carbon::createFromFormat('F d, Y', $this->date);
            if (!$formattedDate) {
                throw new \Exception("Date format is invalid: " . $this->date);
            }
            $formattedDate = $formattedDate->format('Y-m-d');
            

            $formattedStart = Carbon::createFromFormat('h:i A', $this->start_time)->format('H:i:s');
            $formattedEnd = Carbon::createFromFormat('h:i A', $this->end_time)->format('H:i:s');

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
        // } catch (\Exception $e) {
            // dd($e->getMessage());
        // }
    }


    public function render()
    {
        return view('livewire.management.create-event', [
            'tags' => Tags::cases(),
        ]);
    }
}
