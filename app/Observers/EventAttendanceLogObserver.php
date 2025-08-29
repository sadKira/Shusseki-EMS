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
        Cache::forget("dashboard:trend:{$event->school_year}");
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
