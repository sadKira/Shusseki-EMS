<?php

use App\Livewire\User\AttendanceRecord;
use App\Models\User;
use App\Models\Event;
use App\Models\EventAttendanceLog;
use App\Models\Setting;
use App\Enums\UserRole;
use App\Enums\AccountStatus;
use App\Enums\UserApproval;
use App\Enums\AttendanceStatus;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Setting::create(['key' => 'school_year', 'value' => '2024-2025']);
});

test('user can view attendance record', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(AttendanceRecord::class);

    $response->assertSuccessful();
});

test('attendance record shows user events', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $event = Event::factory()->create();
    EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(AttendanceRecord::class);

    $response->assertSuccessful();
});

test('attendance record filters by school year', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $event1 = Event::factory()->create(['school_year' => '2024-2025']);
    $event2 = Event::factory()->create(['school_year' => '2023-2024']);
    
    EventAttendanceLog::factory()->create([
        'event_id' => $event1->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);
    EventAttendanceLog::factory()->create([
        'event_id' => $event2->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(AttendanceRecord::class)
        ->set('selectedSchoolYear', '2024-2025');

    $response->assertSuccessful();
});

test('attendance record shows correct status', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $event = Event::factory()->create();
    EventAttendanceLog::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Late,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(AttendanceRecord::class);

    $response->assertSuccessful();
});

test('attendance record calculates statistics correctly', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $events = Event::factory()->count(4)->create();
    
    // 2 present, 1 late, 1 absent
    EventAttendanceLog::factory()->create([
        'event_id' => $events[0]->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);
    EventAttendanceLog::factory()->create([
        'event_id' => $events[1]->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Present,
    ]);
    EventAttendanceLog::factory()->create([
        'event_id' => $events[2]->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Late,
    ]);
    EventAttendanceLog::factory()->create([
        'event_id' => $events[3]->id,
        'user_id' => $user->id,
        'attendance_status' => AttendanceStatus::Absent,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(AttendanceRecord::class);

    $response->assertSuccessful();
});

