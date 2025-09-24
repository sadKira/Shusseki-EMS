<?php

namespace App\Observers;

use App\Models\EventAttendanceLog;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class EventAttendanceLogObserver
{
    protected function forgetTrend(EventAttendanceLog $log): void
    {
        $event = Event::find($log->event_id);
        if (!$event || !$event->school_year) {
            return;
        }
        // Cache::forget("dashboard:trend:{$event->school_year}");

        $schoolYear = $event->school_year;

        // Forget everything that depends on attendance logs
        Cache::forget("dashboard:trend:{$schoolYear}");
        Cache::forget("students:attendance:doughnut:{$schoolYear}");
        Cache::forget("students:missing:count:{$schoolYear}");
        Cache::forget("students:base:counts:{$schoolYear}");
        Cache::forget("events:finished:{$schoolYear}");
        Cache::forget("attendance:logs:{$schoolYear}");
    }

    public function created(EventAttendanceLog $log): void
    {
        $this->forgetTrend($log);
    }

    public function updated(EventAttendanceLog $log): void
    {
        $this->forgetTrend($log);
    }

    public function deleted(EventAttendanceLog $log): void
    {
        $this->forgetTrend($log);
    }
}
