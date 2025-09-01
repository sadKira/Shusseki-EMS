<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use App\Models\EventAttendanceLog;
use App\Enums\EventStatus;
use App\Models\Setting;

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class ViewStudentRecord extends Component
{
    public $user;
    public $selectedSchoolYear;
    public string $current_admin_key = '';
    public string $pendingAction = '';
    public int|null $pendingUserId = null;
    public int|null $pendingEventId = null;

    // Mounting data
    public function mount(User $user)
    {
        $this->user = $user;
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }

    protected function clearStudentRecordCaches(): void
    {
        $schoolYear = $this->selectedSchoolYear;

        Cache::forget("students:attendance:doughnut:{$schoolYear}");
        Cache::forget("students:missing:count:{$schoolYear}");
        Cache::forget("students:base:counts:{$schoolYear}");
        Cache::forget("events:finished:{$schoolYear}");
        Cache::forget("attendance:logs:{$schoolYear}");
    }

    // Generate PDF
    public function generateStampCard()
    {
        [$startYear, $endYear] = explode('-', $this->selectedSchoolYear);
        $startDate = Carbon::create($startYear, 7, 1);
        $endDate   = Carbon::create($endYear, 6, 30);

        // Load only the current user's logs for each event
        $events = Event::with(['attendanceLogs' => function ($query) {
            $query->where('user_id', $this->user->id);
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
        $userName = str_replace(' ', '_', $this->user->name);

        $pdf = Pdf::loadView('reports.generate-stampcard-admin', [
            'user' => $this->user,
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

    // Update student status
    public function markLate($userId, $eventId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markLate';
        $this->pendingUserId = $userId;
        $this->pendingEventId = $eventId;
        
        Flux::modal('admin-key')->show();

    }

    public function markPresent($userId, $eventId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markPresent';
        $this->pendingUserId = $userId;
        $this->pendingEventId = $eventId;
        
        Flux::modal('admin-key')->show();
        
    }

    public function markAbsent($userId, $eventId)
    {
        // Close initial modal
        Flux::modals()->close();
        $this->pendingAction = 'markAbsent';
        $this->pendingUserId = $userId;
        $this->pendingEventId = $eventId;
        
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
            EventAttendanceLog::where('event_id', $this->pendingEventId)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'scanned']);
        }

        if ($this->pendingAction === 'markLate' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->pendingEventId)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'late']);
        }

        if ($this->pendingAction === 'markPresent' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->pendingEventId)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'present']);
        }

        if ($this->pendingAction === 'markAbsent' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->pendingEventId)
                ->where('user_id', $this->pendingUserId)
                ->first()
                ?->update(['attendance_status' => 'absent']);
        }

        if ($this->pendingAction === 'removeLogRecord' && $this->pendingUserId) {
            EventAttendanceLog::where('event_id', $this->pendingEventId)
                ->where('user_id', $this->pendingUserId)
                ->delete();
        }

        // Always clear caches since logs changed
        $this->clearStudentRecordCaches();

        $this->reset(['current_admin_key', 'pendingAction', 'pendingUserId']);
        $this->resetErrorBag();
        $this->dispatch('admin-key-updated');
        Flux::modals()->close();
    }

    public function render()
    {
        $finishedEvents = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished)
            ->pluck('id');

        $logs = EventAttendanceLog::where('user_id', $this->user->id) // 
            ->whereIn('event_id', $finishedEvents)
            ->get();

        $lateCount = $logs->where('attendance_status', 'late')->count();
        $absentCount = $finishedEvents->count() - $logs->count()
            + $logs->where('attendance_status', 'absent')->count();

        $this->user->late_count = $lateCount;
        $this->user->absent_count = $absentCount;


        // Rendering attendance record
        $baseQuery = Event::query(); 

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished);

        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        $events = $filteredQuery
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();


        // Separate query: attendance logs for only finished events for current user
        $attendanceLogs = EventAttendanceLog::whereIn('event_id', 
                $events->pluck('id')
            )
            ->where('user_id', $this->user->id)
            ->get()
            ->keyBy('event_id'); // makes it easy to access by event ID


        return view('livewire.management.view-student-record', [
            'events' => $events,
            'user' => $this->user,
            'attendanceLogs' => $attendanceLogs,
        ]);
    }
}
