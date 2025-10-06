<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventAttendanceLog;
use App\Enums\EventStatus;
use Flux\Flux;
use App\Models\Setting;
use App\Mail\EventReminder;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewEvent extends Component
{

    public $event;
    public $attendanceStats = [];
    public $attendancePercentages = [];

    // Mounting data
    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function markEventAsPostponed()
    {
        // Mark event as postponed
        $this->event->status = EventStatus::Postponed;
        $this->event->save();

        Flux::modals()->close();

        return redirect()->route('view_event', $this->event);
    }

    public function markEventAsResumed()
    {
        // Mark event as unfinished
        $this->event->status = EventStatus::NotFinished;
        $this->event->save();

        Flux::modals()->close();

        return redirect()->route('view_event', $this->event);
    }

    public function sendEmailUpdate()
    {
        $event = $this->event;

        User::where('role', 'user')
            ->where('status', 'approved')
            ->where('account_status', 'active')
            ->chunk(100, function ($users) use ($event) {
                foreach ($users as $user) {
                    Mail::to($user->email)->queue(new EventReminder($event, $user));
                }
            });

        Flux::modals()->close();
    }

    public function exportAttendanceReport()
    {
        $event = $this->event;

        // Fetch attendance logs with relationships (student, course, etc.)
        $logs = EventAttendanceLog::with(['user.course', 'user.schoolYear'])
            ->where('event_id', $event->id)
            ->get();

        // Counts
        $presentCount = $logs->where('attendance_status', 'present')->count();
        $lateCount    = $logs->where('attendance_status', 'late')->count();
        $absentCount  = $logs->where('attendance_status', 'absent')->count();
        $totalAttendees = $presentCount + $lateCount + $absentCount;

        // Percentages
        $presentPercent = $totalAttendees > 0 ? round(($presentCount / $totalAttendees) * 100, 1) : 0;
        $latePercent    = $totalAttendees > 0 ? round(($lateCount / $totalAttendees) * 100, 1) : 0;
        $absentPercent  = $totalAttendees > 0 ? round(($absentCount / $totalAttendees) * 100, 1) : 0;

        // Generate PDF
        $pdf = Pdf::loadView('reports.generate-event-report', [
            'event'           => $event,
            'logs'            => $logs,
            'presentCount'    => $presentCount,
            'lateCount'       => $lateCount,
            'absentCount'     => $absentCount,
            'totalAttendees'  => $totalAttendees,
            'presentPercent'  => $presentPercent,
            'latePercent'     => $latePercent,
            'absentPercent'   => $absentPercent,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "Attendance_Report_{$event->title}.pdf");
    }



    public function render()
    {
        // Attendance stats
        $totalAttendees = $this->event->attendanceLogs()->where('attendance_status', '!=', 'absent')->count();

        // Status counts (without excused)
        $presentCount = $this->event->attendanceLogs()->where('attendance_status', 'present')->count();
        $lateCount    = $this->event->attendanceLogs()->where('attendance_status', 'late')->count();
        $absentCount  = $this->event->attendanceLogs()->where('attendance_status', 'absent')->count();

        // Calculate percentages
        $totalForPercentage = max($totalAttendees, 1); // Avoid division by zero
        $presentPercentage = ($presentCount / $totalForPercentage) * 100;
        $latePercentage    = ($lateCount / $totalForPercentage) * 100;
        $absentPercentage  = ($absentCount / $totalForPercentage) * 100;

        return view('livewire.management.view-event', [
            'totalAttendees'   => $totalAttendees,
            'presentCount'     => $presentCount,
            'lateCount'        => $lateCount,
            'absentCount'      => $absentCount,
            'presentPercentage' => $presentPercentage,
            'latePercentage'   => $latePercentage,
            'absentPercentage' => $absentPercentage,
        ]);
    }
}
