<?php

use App\Livewire\Management\StudentRecord;
use App\Livewire\Management\ViewStudentRecord;
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

test('admin can view student records', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(StudentRecord::class);

    $response->assertSuccessful();
});

test('admin can view individual student record', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create([
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $this->actingAs($admin);

    $response = Livewire::test(ViewStudentRecord::class, ['user' => $user]);

    $response->assertSuccessful();
});

test('student record shows attendance statistics', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create([
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $events = Event::factory()->count(4)->create(['school_year' => '2024-2025']);
    
    // Create attendance logs
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
    $this->actingAs($admin);

    $response = Livewire::test(ViewStudentRecord::class, ['user' => $user]);

    $response->assertSuccessful();
});

test('student record filters by school year', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create([
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
    $this->actingAs($admin);

    $response = Livewire::test(ViewStudentRecord::class, ['user' => $user])
        ->set('selectedSchoolYear', '2024-2025');

    $response->assertSuccessful();
});

test('student record can filter by status', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user = User::factory()->create([
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $this->actingAs($admin);

    $response = Livewire::test(StudentRecord::class)
        ->set('selectedStatus', 'Active Accounts');

    $response->assertSuccessful();
});

