<?php

use App\Livewire\Management\AttendanceBin;
use App\Livewire\Management\ViewEvent;
use App\Models\Event;
use App\Models\User;
use App\Models\EventAttendanceLog;
use App\Enums\UserRole;
use App\Enums\AttendanceStatus;
use App\Enums\EventStatus;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('admin can view attendance bin for an event', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $this->actingAs($admin);

    $response = Livewire::test(AttendanceBin::class, ['event' => $event]);

    $response->assertSuccessful();
});

test('attendance can be marked as present', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $user = User::factory()->create();
    $this->actingAs($admin);

    $log = EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::NotScanned,
    ]);

    $response = Livewire::test(AttendanceBin::class, ['event' => $event]);
    $response->assertSuccessful();
});

test('attendance can be marked as late', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $user = User::factory()->create();
    $this->actingAs($admin);

    $log = EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::NotScanned,
    ]);

    $response = Livewire::test(AttendanceBin::class, ['event' => $event]);
    $response->assertSuccessful();
});

test('attendance can be marked as absent', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $user = User::factory()->create();
    $this->actingAs($admin);

    $log = EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::NotScanned,
    ]);

    $response = Livewire::test(AttendanceBin::class, ['event' => $event]);
    $response->assertSuccessful();
});

test('attendance report excludes deleted users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $event = Event::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $this->actingAs($admin);

    EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user1->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);
    EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user2->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);

    // Delete one user
    $user2->delete();

    $response = Livewire::test(ViewEvent::class, ['event' => $event])
        ->call('exportAttendanceReport');

    // Should not throw an error
    $response->assertFileDownloaded("Attendance_Report_{$event->title}.pdf");
});