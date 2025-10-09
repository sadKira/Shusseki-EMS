<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Models\EventAttendanceLog;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        $schoolYear = $this->selectedSchoolYear;

        return Cache::remember("dashboard:trend:{$schoolYear}", 1800, function () use ($schoolYear) {
            [$syStart, $syEnd] = explode('-', $schoolYear);
            $syStart = (int) $syStart;
            $syEnd = (int) $syEnd;

            // Find earliest finished event date within the school year; fallback to July of start year
            $firstDate = Event::where('school_year', $schoolYear)
                ->where('status', EventStatus::Finished->value)
                ->min('date');

            if ($firstDate) {
                $first = Carbon::parse($firstDate);
                $startMonth = (int) $first->month;
                $startYear = (int) $first->year;
            } else {
                $startMonth = 7;
                $startYear = $syStart;
            }

            // Build 12-month rolling window from the detected start month/year
        $months = [];
        $years = [];
        $monthYearPairs = [];
        $currentYear = $startYear;
        $currentMonth = $startMonth;

        // Build 12 months starting from the start month
        for ($i = 0; $i < 12; $i++) {
                $months[] = Carbon::create($currentYear, $currentMonth, 1)->format('M');
            $years[] = $currentYear;
            $monthYearPairs[] = ['month' => $currentMonth, 'year' => $currentYear];

            $currentMonth++;
            if ($currentMonth > 12) {
                $currentMonth = 1;
                    // switch to the end year if we roll over
                    $currentYear = $syEnd;
                }
            }

            // Aggregate attendance logs grouped by month and status in a single query
            $windowStart = Carbon::create($startYear, $startMonth, 1)->startOfDay();
            $windowEnd = $windowStart->copy()->addMonths(12)->endOfDay();

            $rows = DB::table('events')
                ->join('event_attendance_logs', 'event_attendance_logs.event_id', '=', 'events.id')
                ->selectRaw('YEAR(events.date) as y, MONTH(events.date) as m, event_attendance_logs.attendance_status as s, COUNT(*) as c')
                ->where('events.school_year', $schoolYear)
                ->whereBetween('events.date', [$windowStart->toDateString(), $windowEnd->toDateString()])
                ->where('events.status', EventStatus::Finished->value)
                ->groupBy('y', 'm', 's')
                ->orderBy('y')
                ->orderBy('m')
                ->get();

            $present = array_fill(0, 12, 0);
            $late = array_fill(0, 12, 0);
            $absent = array_fill(0, 12, 0);

            // Map row month/year to index in our 12-month window
            foreach ($rows as $r) {
                $index = null;
                for ($i = 0; $i < 12; $i++) {
                    $labelMonth = Carbon::create($years[$i], Carbon::parse("1 {$months[$i]} {$years[$i]}")->month, 1)->month;
                    if ((int) $years[$i] === (int) $r->y && (int) $labelMonth === (int) $r->m) {
                        $index = $i;
                        break;
                    }
                }
                if ($index === null) continue;

                if ($r->s === 'present') $present[$index] += (int) $r->c;
                if ($r->s === 'late') $late[$index] += (int) $r->c;
                if ($r->s === 'absent') $absent[$index] += (int) $r->c;
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
        });
    }


    // Generate report
    public function generateYearlyReport()
    {

        // Fetch events within the school year
        $events = Event::with('attendanceLogs')
            ->where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished->value) // Only finished events for accuracy
            ->orderBy('date')
            ->get();

        // Aggregated Data
        // $monthlySummary = [];

        // foreach (range(0, 11) as $i) {
        //     $monthDate = $startDate->copy()->addMonths($i);
        //     $monthName = $monthDate->format('F Y');

        //     // Events for the month
        //     $monthEvents = $events->filter(function ($event) use ($monthDate) {
        //         return Carbon::parse($event->date)->format('Y-m') === $monthDate->format('Y-m');
        //     });

        //     // Attendance logs for all events in the month
        //     $logs = $monthEvents->flatMap->attendanceLogs;

        //     $monthlySummary[] = [
        //         'month' => $monthName,
        //         'total_events' => $monthEvents->count(),
        //         'total_attendees' => $logs->where('attendance_status', '!=', 'absent')->count(),
        //         'present' => $logs->where('attendance_status', 'present')->count(),
        //         'late' => $logs->where('attendance_status', 'late')->count(),
        //         'absent' => $logs->where('attendance_status', 'absent')->count(),
        //     ];
        // }

        // All Events Data
        $eventSummary = [];

        foreach ($events as $event) {
            $logs = $event->attendanceLogs;

            $eventSummary[] = [
                'event_title'     => $event->title,
                'date'            => $event->date,
                'total_attendees' => $logs->where('attendance_status', '!=', 'absent')->count(),
                'present'         => $logs->where('attendance_status', 'present')->count(),
                'late'            => $logs->where('attendance_status', 'late')->count(),
                'absent'          => $logs->where('attendance_status', 'absent')->count(),
            ];
        }

        // Yearly totals/rates based on monthlySummary (mirrors attendanceTrendData logic)
        $presentTotal = array_sum(array_column($eventSummary, 'present'));
        $lateTotal    = array_sum(array_column($eventSummary, 'late'));
        $absentTotal  = array_sum(array_column($eventSummary, 'absent'));
        $grandTotal   = $presentTotal + $lateTotal + $absentTotal;

        // Attendance rate treats Present + Late as "attended"
        $presentFinal    = $presentTotal + $lateTotal;
        $presentPercent  = $grandTotal > 0 ? round(($presentFinal / $grandTotal) * 100, 1) : 0;
        $latePercent     = $grandTotal > 0 ? round(($lateTotal / $grandTotal) * 100, 1) : 0;
        $absentPercent   = $grandTotal > 0 ? round(($absentTotal / $grandTotal) * 100, 1) : 0;

        // "No events" condition in Blade
        $hasEvents = $events->isNotEmpty();

        // Generate PDF
        $pdf = Pdf::loadView('reports.generate-report', [
            'selectedSchoolYear' => $this->selectedSchoolYear,
            'eventSummary'       => $eventSummary,
            'presentPercent' => $presentPercent,
            'latePercent' => $latePercent,
            'absentPercent' => $absentPercent,
            'hasEvents' => $hasEvents,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Attendance_Report_{$this->selectedSchoolYear}.pdf");

        
    }

    public function refreshChart()
    {
        // This will update $attendanceTrendData
        $this->attendanceTrendData = $this->getAttendanceTrendData();

        // Dispatch event with new data to JavaScript
        $this->dispatch('chart-data-updated', data: $this->attendanceTrendData);
        
    }



    public function render()
    {
        $baseQuery = Event::query(); 

        // Cached counts (5–10 min TTL)
        $yearKey = $this->selectedSchoolYear;
        $monthNum = Carbon::parse("1 {$this->selectedMonth}")->month;
        $yearNow = now()->year;

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->whereMonth('date', Carbon::parse("1 {$this->selectedMonth}")->month)
            ->whereYear('date', now()->year);

        // Count of filtered events
        $filteredEventCount = Cache::remember("dashboard:counts:filtered:{$yearKey}:{$yearNow}-{$monthNum}", 120, function () use ($filteredQuery) {
            return (clone $filteredQuery)->count();
        });


        // Count of events for the school year where status is not postponed
        $nonPostponedEventCount = Cache::remember("dashboard:counts:non_postponed_total:{$yearKey}", 600, function () use ($yearKey) {
            return Event::where('school_year', $yearKey)
            ->where('status', '!=', EventStatus::Postponed->value)
            ->count();
        });

        // Count of events for the month where status is not postponed
        $nonPostponedEventCountMonth = Cache::remember("dashboard:counts:non_postponed_month:{$yearKey}:{$yearNow}-{$monthNum}", 600, function () use ($yearKey, $monthNum, $yearNow) {
            return Event::where('school_year', $yearKey)
                ->whereMonth('date', $monthNum)
                ->whereYear('date', $yearNow)
            ->where('status', '!=', EventStatus::Postponed->value)
            ->count();
        });

        // events query and order
        $events = Cache::remember("dashboard:lists:month_events:{$yearKey}:{$yearNow}-{$monthNum}", 120, function () use ($filteredQuery) {
            return $filteredQuery
            ->orderByRaw("
                CASE 
                    WHEN status = ? THEN 2
                    WHEN status = ? THEN 1
                    ELSE 0
                END", [EventStatus::Postponed->value, EventStatus::Finished->value])
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();
        });

        // event count
        $now = now('Asia/Manila');

        $untrackedEvents = Cache::remember("dashboard:lists:untracked:{$yearKey}:{$now->toDateString()}", 300, function () use ($yearKey, $now) {
            return Event::where('school_year', $yearKey)
            ->where('status', EventStatus::NotFinished->value)
            ->where(function ($query) use ($now) {
                $query->whereDate('date', '<', $now->toDateString())
                    ->orWhere(function ($q) use ($now) {
                        $q->whereDate('date', $now->toDateString())
                            ->whereTime('end_time', '<', $now->toTimeString());
                    });
            })
            ->get();
        });

        $finishedEvents = Cache::remember("dashboard:lists:finished:{$yearKey}", 300, function () use ($yearKey) {
            return Event::where('school_year', $yearKey)
            ->where('status', EventStatus::Finished->value)
            ->get();
        });

        $postponedEvents = Cache::remember("dashboard:lists:postponed:{$yearKey}", 300, function () use ($yearKey) {
            return Event::where('school_year', $yearKey)
            ->where('status', EventStatus::Postponed->value)
            ->get();
        });

        return view('livewire.management.admin-dashboard', [
            'events' => $events,
            'eventCount' => $filteredEventCount,
            'nonPostponedEventCount' => $nonPostponedEventCount,
            'nonPostponedEventCountMonth' => $nonPostponedEventCountMonth,
            'finishedEvents' => $finishedEvents,
            'postponedEvents' => $postponedEvents,
            'untrackedEvents' => $untrackedEvents,
            
        ]);
    }
}
