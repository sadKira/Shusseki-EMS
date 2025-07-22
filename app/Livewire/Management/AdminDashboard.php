<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Models\EventAttendanceLog;

use Carbon\Carbon;

class AdminDashboard extends Component
{

    public $selectedSchoolYear = 'All';

    public $selectedMonth;

    public $schoolYears = [];

    public $attendanceTrendData = [];

    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
        $this->schoolYears = Setting::getAvailableSchoolYears(); // loads from SchoolYear model

        $this->attendanceTrendData = $this->getAttendanceTrendData();
    }

    // Setting school year
    public function updateSchoolYear()
    {
        Setting::setSchoolYear($this->selectedSchoolYear);
    }

    public function updatedSelectedSchoolYear($value)
    {
        Setting::setSchoolYear($value);
    }

    public function getAttendanceTrendData()
    {
        $schoolYear = Setting::getSchoolYear();
        // $month = now()->month;
        // $year = now()->year;

        $events = Event::where('school_year', $schoolYear)
            // ->whereMonth('date', $month)
            // ->whereYear('date', $year)
            ->where('status', EventStatus::Finished->value)
            ->orderBy('date')
            ->get();

        $trend = [
            'labels' => [],
            'eventNames' => [],
            'present' => [],
            'late' => [],
            'absent' => [],
            'hasEvents' => $events->count() > 0,
        ];

        foreach ($events as $event) {
            $trend['labels'][] = \Carbon\Carbon::parse($event->date)->format('M j');
            $trend['eventNames'][] = $event->title;
            $logs = EventAttendanceLog::where('event_id', $event->id)->get();
            $trend['present'][] = $logs->where('attendance_status', 'present')->count();
            $trend['late'][] = $logs->where('attendance_status', 'late')->count();
            $trend['absent'][] = $logs->where('attendance_status', 'absent')->count();
        }

        return $trend;
    }


    public function render()
    {
        $baseQuery = Event::query();

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->when($this->selectedMonth !== 'All' && $this->selectedMonth !== null, function ($query) {
                $monthNumber = Carbon::parse("1 {$this->selectedMonth}")->month;
                $query->whereMonth('date', $monthNumber);
            })
            ->whereYear('date', now()->year);;
        // ->when($this->selectedSchoolYear !== 'All' && $this->selectedSchoolYear !== null, function ($query) {
        //     $query->where('school_year', $this->selectedSchoolYear);


        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        // Count of events for the school year where status is not postponed
        $nonPostponedEventCount = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', '!=', EventStatus::Postponed->value)
            ->count();

        // Count of postponed events for the school year
        $postponedEventCount = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Postponed->value)
            ->count();

        // Get the start and end of the current week (Monday to Sunday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY)->toDateString();

        $weekEventCount = Event::where('school_year', $this->selectedSchoolYear)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->count();

        $events = $filteredQuery
            ->orderByRaw("
                CASE 
                    WHEN status = ? THEN 2
                    WHEN status = ? THEN 1
                    ELSE 0
                END", [EventStatus::Postponed->value, EventStatus::Finished->value])
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();

        return view('livewire.management.admin-dashboard', [
            'events' => $events,
            'eventCount' => $filteredEventCount,
            'nonPostponedEventCount' => $nonPostponedEventCount,
            'postponedEventCount' => $postponedEventCount,
            'weekEventCount' => $weekEventCount,
        ]);
    }
}
