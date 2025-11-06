<?php

use App\Livewire\User\EditProfile;
use App\Livewire\User\MainProfile;
use App\Livewire\User\Password as UserPassword;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\AccountStatus;
use App\Enums\UserApproval;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can view profile', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(MainProfile::class);

    $response->assertSuccessful();
});

test('user can view edit profile page', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
    ]);
    $this->actingAs($user);

    $response = Livewire::test(EditProfile::class);

    $response->assertSuccessful();
    expect($response->get('name'))->toBe($user->name);
    expect($response->get('email'))->toBe($user->email);
});

test('user can update profile information', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
        'email' => 'old@example.com',
    ]);
    $this->actingAs($user);

    $response = Livewire::test(EditProfile::class)
        ->set('email', 'new@example.com')
        ->set('year_level', '2nd Year')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();
    expect($user->email)->toBe('new@example.com');
    expect($user->year_level)->toBe('2nd Year');
    expect($user->email_verified_at)->toBeNull(); // Should be null when email changes
});

test('user cannot use duplicate email', function () {
    $user1 = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
        'email' => 'user1@example.com',
    ]);
    $user2 = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
        'email' => 'user2@example.com',
    ]);
    $this->actingAs($user1);

    $response = Livewire::test(EditProfile::class)
        ->set('email', 'user2@example.com')
        ->set('year_level', '2nd Year')
        ->call('updateProfileInformation');

    $response->assertHasErrors(['email']);
});

test('user can update password', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
        'password' => Hash::make('old-password'),
    ]);
    $this->actingAs($user);

    $response = Livewire::test(UserPassword::class)
        ->set('current_password', 'old-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $response->assertHasNoErrors();

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('user must provide correct current password to update', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
        'password' => Hash::make('old-password'),
    ]);
    $this->actingAs($user);

    $response = Livewire::test(UserPassword::class)
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $response->assertHasErrors(['current_password']);
});

test('password confirmation must match', function () {
    $user = User::factory()->create([
        'role' => UserRole::User,
        'status' => UserApproval::Approved->value,
        'account_status' => AccountStatus::Active->value,
        'password' => Hash::make('old-password'),
    ]);
    $this->actingAs($user);

    $response = Livewire::test(UserPassword::class)
        ->set('current_password', 'old-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'different-password')
        ->call('updatePassword');

    $response->assertHasErrors(['password']);
});

