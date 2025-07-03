<?php

use App\Models\Event;
use App\Models\User;
use App\Models\EventAttendanceLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\AttendanceStatus;

uses(RefreshDatabase::class);

it('stores correct attendance status in the event attendance log', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();

    // Create log with a specific status
    $log = EventAttendanceLog::factory()->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'attendance_status' => 'present',
    ]);

    // Reload to confirm relationship integrity
    $log->refresh();

    expect($log->attendance_status)->toBe(AttendanceStatus::Present);
    expect($log->user->id)->toBe($user->id);
    expect($log->event->id)->toBe($event->id);
});

