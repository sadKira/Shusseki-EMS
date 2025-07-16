<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Layout;
use App\Models\EventAttendanceLog;
use App\Models\User;
use Carbon\Carbon;
use App\Enums\AttendanceStatus;
use App\Enums\EventStatus;
use App\Enums\AccountStatus;
use App\Enums\UserApproval;


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

    public function resetModalState()
    {
        $this->scannedUserId = null;
        $this->lateUserId = null;
        $this->presentUserId = null;
        $this->absentUserId = null;
        $this->removeUserId = null;
    }


    // Update student status
    public function markScanned($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'scanned']);
        
        // Reset modal state
        // $this->resetModalState();

        // Close Modal
        $this->modal('mark-scanned')->close();

    }

    public function markLate($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'late']);
        
        // Reset modal state
        // $this->resetModalState();

        // Close Modal
        $this->modal('mark-late')->close();

    }

    public function markPresent($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'present']);
        
        // Reset modal state
        // $this->resetModalState();

        // Close Modal
        $this->modal('mark-present')->close();

    }

    public function markAbsent($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'absent']);
        
        // Reset modal state
        // $this->resetModalState();

        // Close Modal
        $this->modal('mark-absent')->close();

    }

    // Remove record
    public function removeLogRecord(int $userId): void
    {
        EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->delete();

        // Close Modal
        $this->modal('remove-record')->close();
    }

    public function markEventAsFinished()
    {
        //  Mark event as finished
        $this->event->status = EventStatus::Finished; 
        $this->event->save();

        // Get all active users
        $activeUsers = User::where('role', 'user')
        ->where('status', UserApproval::Approved) // or 'approved'
        ->where('account_status', AccountStatus::Active) // or 'active'
        ->get();
        // dd($activeUsers->pluck('id')->toArray());

        // Get IDs of users who already have an attendance log for this event
        $loggedUserIds = $this->event->attendanceLogs()->pluck('user_id')->toArray();
        // dd($loggedUserIds);
        // dd($loggedUserIds, $activeUsers->pluck('id')->toArray());

        // Filter active users who are not yet logged
        $missingUsers = $activeUsers->whereNotIn('id', $loggedUserIds);
        // dd($missingUsers->pluck('id')->toArray());

        // Create absent logs for missing users
        foreach ($missingUsers as $user) {
            $this->event->attendanceLogs()->create([
                'user_id' => $user->id,
                'attendance_status' => AttendanceStatus::Absent,
                'time_in' => null,
                'time_out' => null,
            ]);
        }

        return redirect()->route('view_event', $this->event);
  
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
