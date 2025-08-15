<?php

namespace App\Livewire\Management;

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Setting;
use App\Enums\AccountStatus;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Models\EventAttendanceLog;
use App\Models\SchoolYear;

use Carbon\Carbon;

use Livewire\Component;

class StudentRecord extends Component
{
    use WithPagination;

    public $search = '';
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
    }





    public function render()
    {

        // Base query: approved users with role = user
        $baseQuery = User::where('status', 'approved')
            ->where('role', 'user');

        // Get total approved users count
        $totalApproved = (clone $baseQuery)->count();

        // Count of active and inactive users among approved users
        $activeCount = (clone $baseQuery)
            ->where('account_status', 'active')
            ->count();


        // Build the filtered query for display (Student List)
        $filteredQueryList = (clone $baseQuery)
            ->where('account_status', 'active')
            ->search($this->search)
            ->orderBy('name', 'asc');

        // Build the filtered query for display (Sanctioned)
        $filteredQuery = (clone $baseQuery)
            ->where('account_status', 'active')
            ->orderBy('name', 'asc');
        // ->orderBy($this->sortField, $this->sortDirection);

        // Get all finished events for the selected school year
        $finishedEvents = Event::where('school_year', $this->selectedSchoolYear)
            ->where('status', EventStatus::Finished)
            ->pluck('id');

        // Get attendance logs for those events
        $attendanceLogs = EventAttendanceLog::whereIn('event_id', $finishedEvents)
            ->get()
            ->groupBy('user_id');

        // Determine sanctioned students with their late & absent counts
        $sanctionedStudents = $filteredQuery->get()->map(function ($student) use ($finishedEvents, $attendanceLogs) {
            $logs = $attendanceLogs->get($student->id, collect());

            // If no logs for all events → missing events count as absent
            $absentCount = $finishedEvents->count() - $logs->count();

            // Add absents from logs with 'absent' status
            $absentCount += $logs->where('attendance_status', 'absent')->count();

            // Late count
            $lateCount = $logs->where('attendance_status', 'late')->count();

            // Add the counts to the student model
            $student->late_count = $lateCount;
            $student->absent_count = $absentCount;

            return $student;
        })->filter(function ($student) {
            // Only return if they have at least 1 late or absent
            return $student->late_count > 0 || $student->absent_count > 0;
        });


        // Doughnut chart
        $attendanceDoughnutData = $this->getAttendanceDoughnutData();

        return view('livewire.management.student-record', [
            'users' => $filteredQueryList->get(),
            'totalApproved' => $totalApproved,
            'activeCount' => $activeCount,
            'schoolYear' => $this->selectedSchoolYear,
            'attendanceDoughnutData' => $attendanceDoughnutData,
            'sanctionedStudents' => $sanctionedStudents,
            'sanctionedCount' => $sanctionedStudents->count(),
        ]);
    }
}
