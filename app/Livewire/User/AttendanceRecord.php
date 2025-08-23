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

use Barryvdh\DomPDF\Facade\Pdf;

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

    // Generate PDF
    public function generateStampCard()
    {
        [$startYear, $endYear] = explode('-', $this->selectedSchoolYear);
        $startDate = Carbon::create($startYear, 7, 1);
        $endDate   = Carbon::create($endYear, 6, 30);

        // Load only the current user's logs for each event
        $events = Event::with(['attendanceLogs' => function ($query) {
            $query->where('user_id', Auth::id());
        }])
            ->where('school_year', $this->selectedSchoolYear)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', EventStatus::Finished->value)
            ->orderBy('date', 'asc')
            ->get();

        $totalEvents  = $events->count();
        $hasEvents    = $events->isNotEmpty();

        // ---- Summary counts ----
        $presentCount = 0;
        $lateCount    = 0;
        $absentCount  = 0; // includes "no log"

        $normalize = function ($status) {
            if (is_object($status)) {
                if (property_exists($status, 'value')) {
                    $status = $status->value;
                } elseif (property_exists($status, 'name')) {
                    $status = $status->name;
                } elseif (method_exists($status, 'value')) {
                    $status = $status->value();
                } elseif (method_exists($status, 'name')) {
                    $status = $status->name();
                }
            }
            return strtolower((string) $status);
        };

        foreach ($events as $event) {
            $log = $event->attendanceLogs->first();
            $status = $normalize($log?->attendance_status);

            switch ($status) {
                case 'present':
                    $presentCount++;
                    break;
                case 'late':
                    $lateCount++;
                    break;
                case 'absent':
                    $absentCount++;
                    break;
                default:
                    // No log or unrecognized -> absent
                    $absentCount++;
                    break;
            }
        }

        $attendedCount = $presentCount + $lateCount;

        // User name
        $userName = str_replace(' ', '_', Auth::user()->name);

        $pdf = Pdf::loadView('reports.generate-stampcard', [
            'selectedSchoolYear' => $this->selectedSchoolYear,
            'events'             => $events,
            'hasEvents'          => $hasEvents,

            // summary numbers
            'totalEvents'   => $totalEvents,
            'presentCount'  => $presentCount,
            'lateCount'     => $lateCount,
            'absentCount'   => $absentCount,
            'attendedCount' => $attendedCount,
            'userName' => $userName,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "{$userName}_StampCard_{$this->selectedSchoolYear}.pdf");
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
        $attendanceLogs = EventAttendanceLog::whereIn(
            'event_id',
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
