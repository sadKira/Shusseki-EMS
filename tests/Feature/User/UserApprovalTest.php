<?php

use App\Livewire\Management\ManageApproval;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserApproval;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Mail::fake();
    Cache::flush();
});

test('admin can view pending user approvals', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUser = User::factory()->create(['status' => UserApproval::Pending->value, 'role' => UserRole::User]);

    $this->actingAs($admin);

    $response = Livewire::test(ManageApproval::class);

    $response->assertSuccessful();
    $users = $response->get('users')->items();
    $userIds = collect($users)->pluck('id')->toArray();
    expect($userIds)->toContain($pendingUser->id);
});

test('admin can approve a pending user', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUser = User::factory()->create(['status' => UserApproval::Pending->value]);

    $this->actingAs($admin);

    Livewire::test(ManageApproval::class)
        ->call('approve', $pendingUser->id);

    $pendingUser->refresh();
    expect($pendingUser->status->value)->toBe(UserApproval::Approved->value);
    Mail::assertQueued(\App\Mail\AccountApprove::class);
});

test('admin can reject a pending user', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUser = User::factory()->create(['status' => UserApproval::Pending->value]);

    $this->actingAs($admin);

    Livewire::test(ManageApproval::class)
        ->set('rejectionReason', 'Invalid information')
        ->call('reject', $pendingUser->id);

    $this->assertDatabaseMissing('users', ['id' => $pendingUser->id]);
    Mail::assertQueued(\App\Mail\AccountRejected::class);
});

test('admin can bulk approve selected users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUsers = User::factory()->count(3)->create(['status' => UserApproval::Pending->value]);

    $this->actingAs($admin);

    Livewire::test(ManageApproval::class)
        ->set('selected', $pendingUsers->pluck('id')->map(fn($id) => (string) $id)->toArray())
        ->call('bulkApprove');

    foreach ($pendingUsers as $user) {
        $user->refresh();
        expect($user->status->value)->toBe(UserApproval::Approved->value);
    }
    
    Mail::assertQueued(\App\Mail\AccountApprove::class, 3);
});

test('admin can bulk reject selected users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUsers = User::factory()->count(2)->create(['status' => UserApproval::Pending->value, 'role' => UserRole::User]);

    $this->actingAs($admin);

    Livewire::test(ManageApproval::class)
        ->set('selected', $pendingUsers->pluck('id')->map(fn($id) => (string) $id)->toArray())
        ->set('bulkRejectionReason', 'Invalid information')
        ->call('bulkReject');

    foreach ($pendingUsers as $user) {
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
    
    Mail::assertQueued(\App\Mail\AccountRejected::class, 2);
});

test('admin can approve all pending users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUsers = User::factory()->count(3)->create(['status' => UserApproval::Pending->value, 'role' => UserRole::User]);

    $this->actingAs($admin);

    Livewire::test(ManageApproval::class)
        ->call('totalbulkApprove');

    foreach ($pendingUsers as $user) {
        $user->refresh();
        expect($user->status->value)->toBe(UserApproval::Approved->value);
    }
    
    Mail::assertQueued(\App\Mail\AccountApprove::class, 3);
});

test('admin can reject all pending users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUsers = User::factory()->count(2)->create(['status' => UserApproval::Pending->value, 'role' => UserRole::User]);

    $this->actingAs($admin);

    Livewire::test(ManageApproval::class)
        ->set('bulkRejectionReason', 'Invalid information')
        ->call('totalbulkReject');

    foreach ($pendingUsers as $user) {
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
    
    Mail::assertQueued(\App\Mail\AccountRejected::class, 2);
});

test('search filters pending users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $user1 = User::factory()->create(['status' => UserApproval::Pending->value, 'name' => 'John Doe', 'role' => UserRole::User]);
    $user2 = User::factory()->create(['status' => UserApproval::Pending->value, 'name' => 'Jane Smith', 'role' => UserRole::User]);

    $this->actingAs($admin);

    $response = Livewire::test(ManageApproval::class)
        ->set('search', 'John');

    $users = $response->get('users')->items();
    $userIds = collect($users)->pluck('id')->toArray();
    expect($userIds)->toContain($user1->id);
    expect($userIds)->not->toContain($user2->id);
});

test('select page selects all users on current page', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin, 'status' => UserApproval::Approved->value]);
    $pendingUsers = User::factory()->count(5)->create(['status' => UserApproval::Pending->value, 'role' => UserRole::User]);

    $this->actingAs($admin);

    $response = Livewire::test(ManageApproval::class)
        ->set('selectPage', true);

    // Should select all pending users on the page (pagination default is 10)
    // The selected count should match the number of pending users
    $selected = $response->get('selected');
    expect($selected)->toHaveCount(5);
    // Verify all selected IDs are in the pending users
    $pendingUserIds = $pendingUsers->pluck('id')->map(fn($id) => (string) $id)->toArray();
    foreach ($selected as $selectedId) {
        expect($pendingUserIds)->toContain($selectedId);
    }
});

test('cancel selection clears selected users', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $pendingUsers = User::factory()->count(3)->create(['status' => UserApproval::Pending->value, 'role' => UserRole::User]);

    $this->actingAs($admin);

    $response = Livewire::test(ManageApproval::class)
        ->set('selected', $pendingUsers->pluck('id')->map(fn($id) => (string) $id)->toArray())
        ->call('cancelSelection');

    expect($response->get('selected'))->toBeEmpty();
    expect($response->get('selectPage'))->toBeFalse();
    expect($response->get('selectAll'))->toBeFalse();
});

