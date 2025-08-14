<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Models\EventAttendanceLog;
use App\Models\User;

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
        [$startYear, $endYear] = explode('-', $schoolYear);
        $startYear = (int)$startYear;
        $endYear = (int)$endYear;

        // Get the first event in the school year to determine start month
        $firstEvent = Event::where('school_year', $schoolYear)
            ->orderBy('date', 'asc')
            ->first();

        $startMonth = $firstEvent ? (int)\Carbon\Carbon::parse($firstEvent->date)->month : 7; // Default to July if no events

        $months = [];
        $years = [];
        $monthYearPairs = [];
        $currentYear = $startYear;
        $currentMonth = $startMonth;

        // Build 12 months starting from the start month
        for ($i = 0; $i < 12; $i++) {
            $monthName = \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('M');
            $months[] = $monthName;
            $years[] = $currentYear;
            $monthYearPairs[] = ['month' => $currentMonth, 'year' => $currentYear];

            $currentMonth++;
            if ($currentMonth > 12) {
                $currentMonth = 1;
                $currentYear = $endYear; // Switch to the end year after December
            }
        }

        $present = [];
        $late = [];
        $absent = [];

        foreach ($monthYearPairs as $pair) {
            $events = Event::where('school_year', $schoolYear)
                ->whereMonth('date', $pair['month'])
                ->whereYear('date', $pair['year'])
                ->where('status', EventStatus::Finished->value)
                ->get();

            $monthPresent = $monthLate = $monthAbsent = 0;
            foreach ($events as $event) {
                $logs = EventAttendanceLog::where('event_id', $event->id)->get();
                $monthPresent += $logs->where('attendance_status', 'present')->count();
                $monthLate += $logs->where('attendance_status', 'late')->count();
                $monthAbsent += $logs->where('attendance_status', 'absent')->count();
            }
            $present[] = $monthPresent;
            $late[] = $monthLate;
            $absent[] = $monthAbsent;
        }

        $hasEvents = array_sum($present) + array_sum($late) + array_sum($absent) > 0;

        return [
            'labels' => $months,
            'years' => $years,  // Now properly populated
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'hasEvents' => $hasEvents,
        ];
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
            ->whereYear('date', now()->year)
            ->where('status', '!=', EventStatus::Postponed->value);
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

        // events query
        $events = $filteredQuery
            ->orderByRaw("
                CASE 
                    WHEN status = ? THEN 2
                    WHEN status = ? THEN 1
                    ELSE 0
                END", [EventStatus::Postponed->value, EventStatus::Finished->value])
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();

        // event count
        $now = now();

        $finishedCount = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished->value)
            ->count();

        $postponedCount = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Postponed->value)
            ->count();

        $untrackedCount = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::NotFinished->value)
            ->where(function ($query) use ($now) {
                $query->whereDate('date', '<', $now->toDateString())
                    ->orWhere(function ($q) use ($now) {
                        $q->whereDate('date', $now->toDateString())
                            ->whereTime('end_time', '<', $now->toTimeString());
                    });
            })
            ->count();

        return view('livewire.management.admin-dashboard', [
            'events' => $events,
            'eventCount' => $filteredEventCount,
            'nonPostponedEventCount' => $nonPostponedEventCount,
            'postponedEventCount' => $postponedEventCount,
            'finishedCount' => $finishedCount,
            'postponedCount' => $postponedCount,
            'untrackedCount' => $untrackedCount,
        ]);
    }
}
