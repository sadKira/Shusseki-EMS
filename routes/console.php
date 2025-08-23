<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Event;
use App\Models\Setting;
use App\Enums\EventStatus;
use App\Mail\EventReminder;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Schedule::command('events:mark-untracked')->everyMinute();

Schedule::call(function () {

    // Find events that will happen 3 days from now
    $upcomingEvents = Event::whereBetween('date', [
        now()->addDay()->startOfDay(),
        now()->addDays(3)->endOfDay(),
    ])
    ->where('status', '!=', EventStatus::Postponed)
    ->where('school_year', Setting::getSchoolYear())
    ->get();

    foreach ($upcomingEvents as $event) {

        // Send email to ALL users
        $users = User::where('role', 'user')
        ->where('status', 'approved')
        ->where('account_status', 'active')
        ->get();

        foreach ($users as $index => $user) {
            Mail::to($user->email)
            ->later(now()->addSeconds($index * 10), new EventReminder($event, $user));
        }
    }
})->dailyAt('08:00'); // Run once a day at 8 AM