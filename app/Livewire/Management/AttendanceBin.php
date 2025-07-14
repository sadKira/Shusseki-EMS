<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Layout;
use App\Models\EventAttendanceLog;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\AttendanceStatus;

#[Layout('components.layouts.attendance_bin_app')]
class AttendanceBin extends Component
{
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function scanStudent($studentId)
    {
        $user = User::where('student_id', $studentId)->first();
        if (!$user) return;

        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $user->id)
            ->first();

        // Always compare in UTC. $eventTimeIn is the event's time-in in Asia/Manila, converted to UTC.
        $eventTimeIn = Carbon::parse($this->event->date . ' ' . $this->event->time_in, 'Asia/Manila')->setTimezone('UTC');
        $now = Carbon::now('UTC');

        if (!$log) {
            // Time-in scan
            $status = $now->lt($eventTimeIn)
                ? AttendanceStatus::Scanned
                : AttendanceStatus::Late;
            EventAttendanceLog::create([
                'event_id' => $this->event->id,
                'user_id' => $user->id,
                'time_in' => $now,
                'attendance_status' => $status,
            ]);
        } elseif ($log->time_in && !$log->time_out) {
            // Time-out scan
            $newStatus = $log->attendance_status === AttendanceStatus::Scanned
                ? AttendanceStatus::Present
                : $log->attendance_status; // If Late, keep Late
            $log->update([
                'time_out' => $now,
                'attendance_status' => $newStatus,
            ]);
        }
    }

    public function render()
    {
        $logs = EventAttendanceLog::where('event_id', $this->event->id)
            ->with('user')
            ->orderByDesc('time_in')
            ->get();

        return view('livewire.management.attendance-bin', [
            'users' => $logs,
            'event' => $this->event,
        ]);
    }
}
