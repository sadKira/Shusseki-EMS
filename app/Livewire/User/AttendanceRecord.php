<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\EventAttendanceLog;
use Carbon\Carbon;
use App\Enums\EventStatus;

#[Layout('components.layouts.user_app')]
class AttendanceRecord extends Component
{
    public $selectedSchoolYear;
    public $search = '';
    
    // Mounting data
    public function mount()
    {
 
        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }


    public function render()
    {
        $baseQuery = Event::query(); 

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished);

        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        $events = $filteredQuery
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->search($this->search)
            ->get();


        // Separate query: attendance logs for only finished events for current user
        $attendanceLogs = EventAttendanceLog::whereIn('event_id', 
                $events->pluck('id')
            )
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('event_id'); // makes it easy to access by event ID

        return view('livewire.user.attendance-record', [
            'events' => $events,
            'attendanceLogs' => $attendanceLogs,
        ]);
    }
}
