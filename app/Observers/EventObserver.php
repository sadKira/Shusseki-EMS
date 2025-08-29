<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class EventObserver
{
    protected function forgetKeysFor(Event $event): void
    {
        $schoolYear = $event->school_year;
        if (!$schoolYear) {
            return;
        }

        Cache::forget("dashboard:trend:{$schoolYear}");
        Cache::forget("dashboard:counts:non_postponed_total:{$schoolYear}");
        Cache::forget("dashboard:counts:finished_total:{$schoolYear}");
        Cache::forget("dashboard:counts:postponed_total:{$schoolYear}");
        Cache::forget("dashboard:lists:finished:{$schoolYear}");
        Cache::forget("dashboard:lists:postponed:{$schoolYear}");

        // Timelines: earliest-month and list caches
        Cache::forget("events:first_month:{$schoolYear}");
        Cache::forget("events:list:{$schoolYear}");

        // ManageEvents page caches (per month/year)
        if ($event->date && $event->school_year) {
            $y = Carbon::parse($event->date)->year;
            $m = Carbon::parse($event->date)->month;
            $sy = $event->school_year;

            Cache::forget("manage:lists:month_events:{$sy}:{$y}-{$m}");
            Cache::forget("manage:counts:non_postponed_month:{$sy}:{$y}-{$m}");
            Cache::forget("manage:counts:postponed_month:{$sy}:{$y}-{$m}");
            Cache::forget("manage:counts:untracked_month:{$sy}:{$y}-{$m}");

            // current-month grouped list (today's month bucket)
            $ym = Carbon::now()->format('Y-m');
            Cache::forget("manage:lists:grouped_current_month:{$sy}:{$ym}");

        }

        // Per-month invalidation
        if ($event->date && $event->school_year) {
            $y = Carbon::parse($event->date)->year;
            $m = Carbon::parse($event->date)->month;
            $sy = $event->school_year;

            Cache::forget("dashboard:lists:month_events:{$sy}:{$y}-{$m}");
            Cache::forget("dashboard:counts:filtered:{$sy}:{$y}-{$m}");
        }

        Cache::forget("dashboard:lists:untracked:{$schoolYear}:" . now()->toDateString());
    }

    public function created(Event $event): void
    {
        $this->forgetKeysFor($event);
    }

    public function updated(Event $event): void
    {
        $this->forgetKeysFor($event);

        // If the event moved months (or school year), also forget the OLD month bucket
        $oldDate = $event->getOriginal('date');
        $oldSchoolYear = $event->getOriginal('school_year') ?? $event->school_year;

        if ($oldDate && $oldSchoolYear) {
            $oldY = Carbon::parse($oldDate)->year;
            $oldM = Carbon::parse($oldDate)->month;

            Cache::forget("dashboard:lists:month_events:{$oldSchoolYear}:{$oldY}-{$oldM}");
            Cache::forget("dashboard:counts:filtered:{$oldSchoolYear}:{$oldY}-{$oldM}");
            Cache::forget("dashboard:counts:non_postponed_month:{$oldSchoolYear}:{$oldY}-{$oldM}");
        }

        // If the school year changed, also clear the old-year aggregates/lists
        if ($oldSchoolYear && $oldSchoolYear !== $event->school_year) {
            Cache::forget("dashboard:trend:{$oldSchoolYear}");
            Cache::forget("dashboard:counts:non_postponed_total:{$oldSchoolYear}");
            Cache::forget("dashboard:counts:finished_total:{$oldSchoolYear}");
            Cache::forget("dashboard:counts:postponed_total:{$oldSchoolYear}");
            Cache::forget("dashboard:lists:finished:{$oldSchoolYear}");
            Cache::forget("dashboard:lists:postponed:{$oldSchoolYear}");
            Cache::forget("dashboard:lists:untracked:{$oldSchoolYear}:" . now()->toDateString());

            // Timelines: earliest-month and list caches for old SY
            Cache::forget("events:first_month:{$oldSchoolYear}");
            Cache::forget("events:list:{$oldSchoolYear}");

            // ManageEvents page caches for old SY (month from oldDate if available)
            if ($oldDate) {
                $oldY = Carbon::parse($oldDate)->year;
                $oldM = Carbon::parse($oldDate)->month;
                Cache::forget("manage:lists:month_events:{$oldSchoolYear}:{$oldY}-{$oldM}");
                Cache::forget("manage:counts:non_postponed_month:{$oldSchoolYear}:{$oldY}-{$oldM}");
                Cache::forget("manage:counts:postponed_month:{$oldSchoolYear}:{$oldY}-{$oldM}");
                Cache::forget("manage:counts:untracked_month:{$oldSchoolYear}:{$oldY}-{$oldM}");
            }
        }
    }

    public function deleted(Event $event): void
    {
        $this->forgetKeysFor($event);
    }
}
