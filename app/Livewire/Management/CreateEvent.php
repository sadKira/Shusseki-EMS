<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;


class CreateEvent extends Component
{
    use WithFileUploads;

    public $title, $date, $location;
    public $time_in, $start_time, $end_time, $image;

    public $selectedSchoolYear; // Bound to the global school year

    protected function rules()
    {
        return [
            'title' => 'required|string|unique:events,title|max:155',
            'date' => 'required|string',
            'location' => 'required|string|max:255',
            'time_in' => 'required|date_format:h:i A',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A|after:start_time',
            'image' => 'nullable|image|max:5048',
        ];
    }

    public function mount()
    {
        $this->image = 'images/MKD_Logo.png';
        $this->selectedSchoolYear = Setting::getSchoolYear(); // Get current school year from settings
    }

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
            

            $formattedIn =  Carbon::createFromFormat('h:i A', $this->time_in)->format('H:i:s');
            $formattedStart = Carbon::createFromFormat('h:i A', $this->start_time)->format('H:i:s');
            $formattedEnd = Carbon::createFromFormat('h:i A', $this->end_time)->format('H:i:s');

            // $imagePath = $this->image ? $this->image->store('events', 'public') : null;
            
            $imagePath = null;

            if ($this->image instanceof TemporaryUploadedFile) {
                $imagePath = $this->image->store('events', 'public');
            } else {
                // Use default image
                $imagePath = $this->image; // e.g., images/MKD_Logo.png
            }

            $event = Event::create([
                'title' => $this->title,
                'date' => $formattedDate,
                'location' => $this->location,
                'time_in' => $formattedIn,
                'start_time' => $formattedStart,
                'end_time' => $formattedEnd,
                'school_year' => $this->selectedSchoolYear,
                'image' => $imagePath,
            ]);

            return redirect()->route('event_timeline');
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        // }
    }


    public function render()
    {
        return view('livewire.management.create-event');
    }
}
