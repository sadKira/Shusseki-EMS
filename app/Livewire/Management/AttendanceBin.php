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
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use Livewire\WithPagination;


#[Layout('components.layouts.attendance_bin_app')]
class AttendanceBin extends Component
{
    use WithPagination;
    public $event;
    public $student_id;
    public $name;
    public string $current_admin_key = '';
    public string $pendingAction = '';
    public int|null $pendingUserId = null;

    public $studentIdInput;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    // Attendance Logic
    public function updatedStudentIdInput($value)
    {
        if (!empty($value)) {
            $this->scanStudent($value);
            $this->reset('studentIdInput'); // clear field for next scan
        }
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
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markScanned';
        $this->pendingUserId = $userId;

        Flux::modal('admin-key')->show();

    }

    public function markLate($userId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markLate';
        $this->pendingUserId = $userId;
        
        Flux::modal('admin-key')->show();

    }

    public function markPresent($userId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markPresent';
        $this->pendingUserId = $userId;
        
        Flux::modal('admin-key')->show();
        
    }

    public function markAbsent($userId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markAbsent';
        $this->pendingUserId = $userId;
        
        Flux::modal('admin-key')->show();

    }

    // Remove time-out
    public function removeTimeOut($userId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'removeLogTimeOut';
        $this->pendingUserId = $userId;
        
        Flux::modal('admin-key')->show();

    }

    // Remove record
    public function removeLogRecord(int $userId): void
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'removeLogRecord';
        $this->pendingUserId = $userId;
        
        Flux::modal('admin-key')->show();

    }

    // Action verification
    public function verifyAdminKey()
    {
        $setting = Setting::where('key', 's_a_k')->first();

        if (!$setting || !Hash::check($this->current_admin_key, $setting->value)) {
            $this->reset(['current_admin_key']);
            $this->dispatch('admin-key-updated');
            throw ValidationException::withMessages([
                'current_admin_key' => ['The admin key is incorrect'],
            ]);
            
        }

        // Proceed with action
        if ($this->pendingAction === 'markScanned' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->event->id)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'scanned']);
        }

        if ($this->pendingAction === 'markLate' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->event->id)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'late']);
        }

        if ($this->pendingAction === 'markPresent' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->event->id)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'present']);
        }

        if ($this->pendingAction === 'markAbsent' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->event->id)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'absent']);
        }

        if ($this->pendingAction === 'removeLogTimeOut' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->event->id)
                ->where('user_id', $this->pendingUserId)
                ->update(['time_out' => null]);
        }

        if ($this->pendingAction === 'removeLogRecord' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->event->id)
                ->where('user_id', $this->pendingUserId)
                ->delete();
        }

        $this->reset(['current_admin_key', 'pendingAction', 'pendingUserId']);
        $this->resetErrorBag();
        $this->dispatch('admin-key-updated');
        Flux::modals()->close();
    }

    public function markAllPresent()
    {

        // Get all users with 'scanned' status and update
        EventAttendanceLog::where('event_id', $this->event->id)
        ->where('attendance_status', AttendanceStatus::Scanned)
        ->whereNull('time_out')
        ->update([
            'attendance_status' => AttendanceStatus::Present,
            'time_out' => now(),
        ]);

        // Get all users with 'late' status and update
        EventAttendanceLog::where('event_id', $this->event->id)
        ->where('attendance_status', AttendanceStatus::Late)
        ->whereNull('time_out')
        ->update([
            'time_out' => now(),
        ]);

    }

    // Mark event finished
    public function markEventAsFinished()
    {
        //  Mark event as finished
        $this->event->status = EventStatus::Finished; 
        $this->event->save();

        // Get all users with 'scanned' status
        EventAttendanceLog::where('event_id', $this->event->id)
        ->where('attendance_status', AttendanceStatus::Scanned)
        ->whereNull('time_out')
        ->update(['attendance_status' => AttendanceStatus::Absent]);

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
        // Attendance Logs
        $logs = EventAttendanceLog::where('event_id', $this->event->id)
            ->with('user:id,name,student_id,year_level')
            ->latest('time_in')
            ->paginate(25);
            // ->with('user')
            // ->orderByDesc('time_in')
            // ->get();

         // Attendance stats
        $totalAttendees = $this->event->attendanceLogs()->where('attendance_status', '!=', 'absent')->count();

        // Status counts (without excused)
        $presentCount = $this->event->attendanceLogs()->where('attendance_status', 'present')->count();
        $lateCount    = $this->event->attendanceLogs()->where('attendance_status', 'late')->count();
        $absentCount  = $this->event->attendanceLogs()->where('attendance_status', 'absent')->count();

        return view('livewire.management.attendance-bin', [
            'users' => $logs,
            'event' => $this->event,
            'totalAttendees'   => $totalAttendees,
            'presentCount'     => $presentCount,
            'lateCount'        => $lateCount,
            'absentCount'      => $absentCount,
        ]);
    }
}
