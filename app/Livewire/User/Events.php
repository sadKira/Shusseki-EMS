<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use Carbon\Carbon;
use App\Enums\EventStatus;
use App\Models\EventAttendanceLog;

#[Layout('components.layouts.user_app')]
class Events extends Component
{
    public $selectedMonth;
    public $selectedSchoolYear;
    public $search = '';

    // Mounting data
    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }

    // Timeline logic
    public function getGroupedEventsProperty()
    {
        $schoolYear = $this->selectedSchoolYear;

        // Split SY format like "2024-2025"
        [$startYear, $endYear] = explode('-', $schoolYear);
        $startYear = (int) $startYear;
        $endYear = (int) $endYear;

        // Detect earliest month in the school year
        $firstEventInStartYear = Event::where('school_year', $schoolYear)
            ->whereYear('date', $startYear)
            ->orderBy('date', 'asc')
            ->first();

        if ($firstEventInStartYear) {
            $startMonth = (int) Carbon::parse($firstEventInStartYear->date)->month;
        } else {
            // fallback: earliest event in school year (could be in second year)
            $firstEvent = Event::where('school_year', $schoolYear)
                ->orderBy('date', 'asc')
                ->first();

            $startMonth = $firstEvent 
                ? (int) Carbon::parse($firstEvent->date)->month 
                : 7; // default July fallback
        }

        // Get events for that school year and sort starting from earliest month
        $events = Event::where('school_year', $schoolYear)
            ->search($this->search)
            ->get()
            ->sortBy(function ($event) use ($startYear, $startMonth) {
                $date = \Carbon\Carbon::parse($event->date);

                // Adjust year for ordering so earliest month is considered "start"
                $adjustedYear = $date->year;
                if ($date->year === $startYear && $date->month < $startMonth) {
                    // Push months before startMonth to next cycle
                    $adjustedYear++;
                }

                return [$adjustedYear, $date->month, $date->day];
            });

        
        
        // Group by date
        return $events->groupBy(function ($event) {
             return \Carbon\Carbon::parse($event->date)->format('F Y');
        });
    }


    public function render()
    {
        $eventIds = $this->groupedEvents
        ->flatten() // merge grouped collections into one
        ->pluck('id');

        // Separate query: attendance logs for only finished events for current user
        $attendanceLogs = EventAttendanceLog::whereIn('event_id', 
               $eventIds
            )
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('event_id'); // makes it easy to access by event ID
        
        return view('livewire.user.events', [
            'groupedEvents' => $this->groupedEvents,
            'attendanceLogs' => $attendanceLogs,
        ]);
    }
}
