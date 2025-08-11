<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\EventAttendanceLog;
use Carbon\Carbon;
use App\Enums\EventStatus;

#[Layout('components.layouts.user_app')]
class Dashboard extends Component
{
    public $selectedMonth;
    public $selectedSchoolYear;

    // Mounting data
    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }

    public function render()
    {
        $baseQuery = Event::query(); 

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->whereMonth('date', Carbon::parse("1 {$this->selectedMonth}")->month)
            ->whereYear('date', now()->year);

            // ->when($this->selectedMonth !== 'All' && $this->selectedMonth !== null, function ($query) {
            //     $monthNumber = Carbon::parse("1 {$this->selectedMonth}")->month;
            //     $query->whereMonth('date', $monthNumber);
            // });

        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        $events = $filteredQuery
            ->orderByRaw("
                CASE 
                    WHEN status = ? THEN 2
                    WHEN status = ? THEN 1
                    ELSE 0
                END", [EventStatus::Postponed->value, EventStatus::Finished->value])
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();


        // Separate query: attendance logs for only finished events for current user
        $attendanceLogs = EventAttendanceLog::whereIn('event_id', 
                $events->pluck('id')
            )
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('event_id'); // makes it easy to access by event ID

        return view('livewire.user.dashboard', [
            'events' => $events,
            'attendanceLogs' => $attendanceLogs,
        ]);
    }
}
