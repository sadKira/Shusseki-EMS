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

use Barryvdh\DomPDF\Facade\Pdf;

class AdminDashboard extends Component
{

    public $selectedSchoolYear;

    public $selectedMonth;

    public $attendanceTrendData = [];

    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();

        $this->attendanceTrendData = $this->getAttendanceTrendData();
    }

    // Attendance trend chart
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
                $currentYear = $endYear;
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
            'years' => $years,
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'hasEvents' => $hasEvents,
        ];
    }


    // Generate report
    public function generateYearlyReport()
    {
        [$startYear, $endYear] = explode('-', $this->selectedSchoolYear);
        $startDate = Carbon::create($startYear, 7, 1); // School year starts July
        $endDate = Carbon::create($endYear, 6, 30);    // Ends June next year

        // Fetch events within the school year
        $events = Event::with('attendanceLogs')
            ->where('school_year', $this->selectedSchoolYear)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', EventStatus::Finished->value) // Only finished events for accuracy
            ->get();

        $monthlySummary = [];

        foreach (range(0, 11) as $i) {
            $monthDate = $startDate->copy()->addMonths($i);
            $monthName = $monthDate->format('F Y');

            // Events for the month
            $monthEvents = $events->filter(function ($event) use ($monthDate) {
                return Carbon::parse($event->date)->format('Y-m') === $monthDate->format('Y-m');
            });

            // Attendance logs for all events in the month
            $logs = $monthEvents->flatMap->attendanceLogs;

            $monthlySummary[] = [
                'month' => $monthName,
                'total_events' => $monthEvents->count(),
                'total_attendees' => $logs->where('attendance_status', '!=', 'absent')->count(),
                'present' => $logs->where('attendance_status', 'present')->count(),
                'late' => $logs->where('attendance_status', 'late')->count(),
                'absent' => $logs->where('attendance_status', 'absent')->count(),
            ];
        }

        // Yearly totals/rates based on monthlySummary (mirrors attendanceTrendData logic)
        $presentTotal = array_sum(array_column($monthlySummary, 'present'));
        $lateTotal    = array_sum(array_column($monthlySummary, 'late'));
        $absentTotal  = array_sum(array_column($monthlySummary, 'absent'));
        $grandTotal   = $presentTotal + $lateTotal + $absentTotal;

        // Attendance rate treats Present + Late as "attended"
        $presentFinal    = $presentTotal + $lateTotal;
        $presentPercent  = $grandTotal > 0 ? round(($presentFinal / $grandTotal) * 100, 1) : 0;
        $latePercent     = $grandTotal > 0 ? round(($lateTotal / $grandTotal) * 100, 1) : 0;
        $absentPercent   = $grandTotal > 0 ? round(($absentTotal / $grandTotal) * 100, 1) : 0;

        // "No events" condition in Blade
        $hasEvents = $events->isNotEmpty();

        // Generate PDF
        $pdf = Pdf::loadView('generate-report', [
            'selectedSchoolYear' => $this->selectedSchoolYear,
            'monthlySummary' => $monthlySummary,
            'presentPercent' => $presentPercent,
            'latePercent' => $latePercent,
            'absentPercent' => $absentPercent,
            'hasEvents' => $hasEvents,
        ]);

        // return $pdf->download("Attendance_Report_{$this->selectedSchoolYear}.pdf");

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Attendance_Report_{$this->selectedSchoolYear}.pdf");
    }



    public function render()
    {
        $baseQuery = Event::query();

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->when($this->selectedMonth !== null, function ($query) {
                $monthNumber = Carbon::parse("1 {$this->selectedMonth}")->month;
                $query->whereMonth('date', $monthNumber);
            })
            ->whereYear('date', now()->year)
            ->where('status', '!=', EventStatus::Postponed->value);

        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        // Count of events for the school year where status is not postponed
        $nonPostponedEventCount = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', '!=', EventStatus::Postponed->value)
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
            'finishedCount' => $finishedCount,
            'postponedCount' => $postponedCount,
            'untrackedCount' => $untrackedCount,
        ]);
    }
}
