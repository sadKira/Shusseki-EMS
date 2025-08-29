<?php

namespace App\Livewire\Management;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Setting;
use App\Enums\AccountStatus;
use App\Enums\TsuushinRole;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Enums\UserApproval;
use App\Enums\AttendanceStatus;
use App\Models\EventAttendanceLog;
use App\Models\SchoolYear;

use Carbon\Carbon;

use Livewire\Component;

class StudentRecord extends Component
{
    use WithPagination;

    public $search = '';
    public $sanctionedSearch = '';
    public $selectedStatus = 'Active Accounts';
    public $selectedStatus_level = 'All';
    public $selectedStatus_course = 'All';
    public $selectedSchoolYear;

    public function mount()
    {
        // Retrieve the globally set school year from session
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }

    // Doughnut chart
    public function getAttendanceDoughnutData()
    {
        $schoolYear = Setting::getSchoolYear();
        
        // Cache the attendance doughnut data for 10 minutes (600 seconds)
        return Cache::remember("students:attendance:doughnut:{$schoolYear}", 600, function () use ($schoolYear) {
            // Get all finished events within the school year
            $events = Event::where('school_year', $schoolYear)
                ->where('status', EventStatus::Finished->value)
                ->get();

            $presentCount = 0;
            $lateCount = 0;
            $absentCount = 0;

            foreach ($events as $event) {
                $logs = EventAttendanceLog::where('event_id', $event->id)->get();
                $presentCount += $logs->where('attendance_status', 'present')->count();
                $lateCount += $logs->where('attendance_status', 'late')->count();
                $absentCount += $logs->where('attendance_status', 'absent')->count();
            }

            // Late counts as present for the overall total
            $effectivePresent = $presentCount + $lateCount;

            $total = $effectivePresent + $absentCount;

            if ($total > 0) {
                $presentPercent = round(($effectivePresent / $total) * 100, 1);
                $latePercent = round(($lateCount / $total) * 100, 1);
                $absentPercent = round(($absentCount / $total) * 100, 1);
            } else {
                $presentPercent = $latePercent = $absentPercent = 0;
            }

            // Empty state check
            $hasEvents = ($presentCount + $lateCount + $absentCount) > 0;

            return [
                'labels' => ['Present', 'Late', 'Absent'],
                'data' => [$presentPercent, $latePercent, $absentPercent],
                'colors' => ['#22c55e', '#f59e0b', '#ef4444'], // green, amber, red
                'percentages' => [
                    'present' => $presentPercent,
                    'late'    => $latePercent,
                    'absent'  => $absentPercent,
                ],
                'totals' => [
                    'present' => $presentCount,
                    'late'    => $lateCount,
                    'absent'  => $absentCount,
                ],
                'hasEvents' => $hasEvents,
            ];
        });
    }

    // Append missing users
    public function appendMissingAccounts()
    {
        // Fetch all active users (who should have logs)
        $activeUsers = User::where('role', 'user')
            ->where('status', UserApproval::Approved)
            ->where('account_status', AccountStatus::Active)
            ->pluck('id'); // we only need IDs

        // Get all finished events in the selected school year
        $events = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished)
            ->pluck('id'); // only IDs

        $now = now();
        $toInsert = [];

        foreach ($events as $eventId) {
            // Get already logged user_ids for this event
            $loggedUserIds = EventAttendanceLog::where('event_id', $eventId)
                ->pluck('user_id')
                ->toArray();

            // Get missing users (diff between active users and logged ones)
            $missingUserIds = $activeUsers->diff($loggedUserIds);

            // Prepare absent logs for bulk insert
            foreach ($missingUserIds as $userId) {
                $toInsert[] = [
                    'event_id' => $eventId,
                    'user_id' => $userId,
                    'attendance_status' => AttendanceStatus::Absent,
                    'time_in' => null,
                    'time_out' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert all missing records in bulk
        if (!empty($toInsert)) {
            EventAttendanceLog::insert($toInsert);
            
            // Clear relevant caches after inserting missing logs
            $this->clearStudentRecordCaches();
        }

        // Optional: return count of created logs
        return count($toInsert);
    }

    // Computed property for missing accounts
    public function getMissingAccountsCountProperty()
    {
        $schoolYear = $this->selectedSchoolYear;
        
        // Cache the missing accounts count for 5 minutes (300 seconds)
        return Cache::remember("students:missing:count:{$schoolYear}", 300, function () use ($schoolYear) {
            $activeUsers = User::where('role', 'user')
                ->where('status', UserApproval::Approved)
                ->where('account_status', AccountStatus::Active)
                ->pluck('id')
                ->toArray();

            $events = Event::where('school_year', $schoolYear)
                ->where('status', EventStatus::Finished)
                ->get();

            $missingCount = 0;

            foreach ($events as $event) {
                $loggedUserIds = $event->attendanceLogs()->pluck('user_id')->toArray();

                // Add count of users not logged in this event
                $missingCount += count(array_diff($activeUsers, $loggedUserIds));
            }

            return $missingCount;
        });
    }

    // Clear all student record related caches
    protected function clearStudentRecordCaches(): void
    {
        $schoolYear = $this->selectedSchoolYear;
        
        Cache::forget("students:attendance:doughnut:{$schoolYear}");
        Cache::forget("students:missing:count:{$schoolYear}");
        Cache::forget("students:base:counts:{$schoolYear}");
        Cache::forget("events:finished:{$schoolYear}");
        Cache::forget("attendance:logs:{$schoolYear}");
    }

    public function render()
    {
        $schoolYear = $this->selectedSchoolYear;
        
        // Cache the base student counts for 5 minutes (300 seconds)
        $baseCounts = Cache::remember("students:base:counts:{$schoolYear}", 300, function () use ($schoolYear) {
            // Base query: approved users with role = user
            $baseQuery = User::where('status', 'approved')
                ->where('role', 'user');

            // Get total approved users count
            $totalApproved = (clone $baseQuery)->count();

            // Count of active and inactive users among approved users
            $activeCount = (clone $baseQuery)
                ->where('account_status', 'active')
                ->count();

            return [
                'totalApproved' => $totalApproved,
                'activeCount' => $activeCount,
            ];
        });

        // Extract cached counts
        $totalApproved = $baseCounts['totalApproved'];
        $activeCount = $baseCounts['activeCount'];

        // Base query: approved users with role = user
        $baseQuery = User::where('status', 'approved')
            ->where('role', 'user');

        // Build the filtered query for display (Student List)
        $filteredQueryList = (clone $baseQuery)
            ->where('account_status', 'active')
            ->search($this->search)
            ->orderBy('name', 'asc');

        // Build the filtered query for display (Sanctioned)
        $filteredQuery = (clone $baseQuery)
            ->where('account_status', 'active')
            ->search($this->sanctionedSearch)
            ->orderBy('name', 'asc');

        // Build the filtered query for display (Sanctioned - Count)
        $filteredQueryCount = (clone $baseQuery)
            ->where('account_status', 'active')
            ->orderBy('name', 'asc');

        // Cache finished events for 10 minutes (600 seconds)
        $finishedEvents = Cache::remember("events:finished:{$schoolYear}", 600, function () use ($schoolYear) {
            return Event::where('school_year', $schoolYear)
                ->where('status', EventStatus::Finished)
                ->pluck('id');
        });

        // Cache attendance logs for 5 minutes (300 seconds)
        $attendanceLogs = Cache::remember("attendance:logs:{$schoolYear}", 300, function () use ($finishedEvents) {
            return EventAttendanceLog::whereIn('event_id', $finishedEvents)
                ->get()
                ->groupBy('user_id');
        });

        // Add counts to ALL users in Student List
        $users = $filteredQueryList->get()->map(function ($student) use ($attendanceLogs, $finishedEvents) {
            $logs = $attendanceLogs->get($student->id, collect());

            // If no logs → treat missing events as absent
            $absentCount = $finishedEvents->count() - $logs->count();
            $absentCount += $logs->where('attendance_status', 'absent')->count();

            $lateCount = $logs->where('attendance_status', 'late')->count();

            $student->late_count = $lateCount;
            $student->absent_count = $absentCount;

            return $student;
        });

        // Now sanctionedStudents is just a filter on users (no extra query)
        $sanctionedStudents = $users->filter(function ($student) {
            return $student->late_count > 0 || $student->absent_count > 0;
        });


        // Doughnut chart
        $attendanceDoughnutData = $this->getAttendanceDoughnutData();

        return view('livewire.management.student-record', [
            'users' => $users, // has late/absent counts
            'totalApproved' => $totalApproved,
            'activeCount' => $activeCount,
            'schoolYear' => $this->selectedSchoolYear,
            'attendanceDoughnutData' => $attendanceDoughnutData,
            'sanctionedStudents' => $sanctionedStudents,
            'sanctionedCount' => $sanctionedStudents->count(),
        ]);
    }
}
