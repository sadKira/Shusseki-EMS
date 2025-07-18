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
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On; 


#[Layout('components.layouts.attendance_bin_app')]
class AttendanceBin extends Component
{
    public $event;
    public $student_id;
    public $name;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    // #[On('scanned-student')]
    public function scanStudent($studentId)
    {

        $user = User::where('student_id', $studentId)->first();

        // Check if user exists
        if (!$user) {
            // User not found
            $this->dispatch('scanned-student', [
                'error' => 'User Account not Found',
                'errorType' => 'not_found',
            ]);
            return;
        }

        // Check account status
        if ($user->account_status !== AccountStatus::Active) {
            $this->dispatch('scanned-student', [
                'error' => 'User is not Active',
                'errorType' => 'inactive',
            ]);
            return;
        }

        // Check approval status
        if ($user->status === UserApproval::Pending) {
            $this->dispatch('scanned-student', [
                'error' => 'User is not Approved',
                'errorType' => 'pending',
            ]);
            return;
        }

        // Dispatch browser event with student data
        $this->dispatch('scanned-student', [
            'student_id' => $user->student_id,
            'name' => $user->name,
        ]);

        // Set for dynamic label
        $this->student_id = $user->student_id;
        $this->name = $user->name;

        Log::info('scanned-student', [
            'student_id' => $user->student_id,
            'name' => $user->name,
        ]);


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


    // Update student status
    public function markScanned($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'scanned']);

        // Close modal
        Flux::modals()->close();

    }

    public function markLate($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'late']);
        
        // Close modal
        Flux::modals()->close();

    }

    public function markPresent($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'present']);
        
        // Close modal
        Flux::modals()->close();

    }

    public function markAbsent($userId)
    {
        $log = EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->first();

        $log->update(['attendance_status' => 'absent']);
        
        // Close modal
        Flux::modals()->close();

    }

    // Remove record
    public function removeLogRecord(int $userId): void
    {
        EventAttendanceLog::where('event_id', $this->event->id)
            ->where('user_id', $userId)
            ->delete();

        // Close modal
        Flux::modals()->close();
    }

    // Mark event finished
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

        // Close all modals
        Flux::modals()->close();

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
