<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Layout;
use App\Models\EventAttendanceLog;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\AttendanceStatus;
use Livewire\Livewire;

#[Layout('components.layouts.attendance_bin_app')]
class AttendanceBin extends Component
{
    public $event;
    public $student_id;
    public $name;
    public ?int $scannedUserId = null;
    public ?int $lateUserId = null;
    public ?int $presentUserId = null;
    public ?int $absentUserId = null;
    public ?int $removeUserId = null;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function scanStudent($studentId)
    {

        $user = User::where('student_id', $studentId)->first();
        if (!$user) return;

        // Dispatch browser event with student data
        $this->dispatch('scanned-student', [
            'student_id' => $user->student_id,
            'name' => $user->name,
        ]);

        
        // Set for dynamic label
        $this->student_id = $user->student_id;
        $this->name = $user->name;

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

    // Obtaining sutdent name
    // public function getSelectedUserProperty(): ?User
    // {
    //     return User::find($this->selectedUserId);
    // }


    // Modal functionality
    public function markAsScanned(int $userId): void
    {
        $this->scannedUserId = $userId;
        $this->modal('mark-scanned')->show(); // Flux modal
    }

    public function markAsLate(int $userId): void
    {
        $this->lateUserId = $userId;
        $this->modal('mark-late')->show(); // Flux modal
    }

    public function markAsPresent(int $userId): void
    {
        $this->presentUserId = $userId;
        $this->modal('mark-present')->show(); // Flux modal
    }

    public function markAsAbsent(int $userId): void
    {
        $this->absentUserId = $userId;
        $this->modal('mark-absent')->show(); // Flux modal
    }

    public function removeRecord(int $userId): void
    {
        $this->removeUserId = $userId;
        $this->modal('remove-record')->show(); // Flux modal
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
