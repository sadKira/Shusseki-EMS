<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    protected function forgetKeys(): void
    {
        Cache::forget('students:counts:approved');
        Cache::forget('students:counts:active');
        Cache::forget('students:counts:inactive');
        Cache::forget('students:counts:tsuushin');
        Cache::forget('students:counts:pending');
        
        // Clear student record related caches
        $this->clearStudentRecordCaches();
        
        // List keys are search/pagination-specific; rely on short TTLs.
        // If using Redis tags, you can flush tags instead.
    }

    // Clear all student record related caches
    protected function clearStudentRecordCaches(): void
    {
        // Get current school year from settings
        $schoolYear = \App\Models\Setting::getSchoolYear();
        
        Cache::forget("students:attendance:doughnut:{$schoolYear}");
        Cache::forget("students:missing:count:{$schoolYear}");
        Cache::forget("students:base:counts:{$schoolYear}");
        Cache::forget("events:finished:{$schoolYear}");
        Cache::forget("attendance:logs:{$schoolYear}");
    }

    public function created(User $user): void
    {
        $this->forgetKeys();
    }

    public function updated(User $user): void
    {
        // If approval/account_status changed, counts are stale
        $this->forgetKeys();
    }

    public function deleted(User $user): void
    {
        $this->forgetKeys();
    }
}
