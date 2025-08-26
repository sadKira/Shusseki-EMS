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

// Test command for email reminders
Artisan::command('test:email-reminders {--days=3} {--limit=5}', function () {
    $days = (int) $this->option('days') ?: 3;
    $limit = (int) $this->option('limit') ?: 5;
    
    $this->info("Testing email reminders for events {$days} days from now...");
    
    // Find events that will happen X days from now
    $upcomingEvents = Event::whereBetween('date', [
        now()->addDay()->startOfDay(),
        now()->addDays($days)->endOfDay(),
    ])
    ->where('status', '!=', EventStatus::Postponed)
    ->where('school_year', Setting::getSchoolYear())
    ->get();

    $this->info("Found {$upcomingEvents->count()} upcoming events.");

    foreach ($upcomingEvents as $event) {
        $this->line("Processing event: {$event->name} on {$event->date}");
        
        // Get limited number of users for testing
        $users = User::where('role', 'user')
        ->where('status', 'approved')
        ->where('account_status', 'active')
        ->limit($limit)
        ->get();
        
        $this->info("Sending to {$users->count()} users (limited for testing):");
        
        foreach ($users as $index => $user) {
            $this->line("  - {$user->name} ({$user->email})");
            
            // Send immediately for testing (no delay)
            Mail::to($user->email)->send(new EventReminder($event, $user));
        }
        
        $this->newLine();
    }
    
    $this->info('Test email reminders sent!');
})->purpose('Test email reminders for upcoming events');


// Schedule::command('events:mark-untracked')->everyMinute();

// Clearing expired password reset tokens in the db
Schedule::command('auth:clear-resets')->everyFifteenMinutes();

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