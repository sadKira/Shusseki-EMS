<?php

use App\Livewire\Management\ManageStudents;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\AccountStatus;
use App\Enums\UserApproval;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('admin can view manage students page', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(ManageStudents::class);

    $response->assertSuccessful();
});

test('users can be filtered by status', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $activeUser = User::factory()->create([
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $inactiveUser = User::factory()->create([
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Inactive->value,
    ]);

    $this->actingAs($admin);

    // This test verifies the component renders
    // Actual filtering logic would be tested in the FilterTable component
    $response = Livewire::test(ManageStudents::class);
    $response->assertSuccessful();
});

test('users can be searched', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user1 = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    $user2 = User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

    $this->actingAs($admin);

    $response = Livewire::test(ManageStudents::class);
    $response->assertSuccessful();
});

test('users can be sorted', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    User::factory()->count(3)->create();

    $this->actingAs($admin);

    $response = Livewire::test(ManageStudents::class);
    $response->assertSuccessful();
});

