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
