<?php

use App\Livewire\Settings\SchoolYear;
use App\Models\User;
use App\Models\Setting;
use App\Models\SchoolYear as SchoolYearModel;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Cache::flush();
    Setting::updateOrCreate(['key' => 'current_school_year'], ['value' => '2024-2025']);
});

test('admin can view school year settings', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(SchoolYear::class);

    $response->assertSuccessful();
});

test('admin can update school year', function () {
    $admin = User::factory()->create(['role' => UserRole::Super_Admin]);
    SchoolYearModel::create(['year' => '2024-2025']);
    SchoolYearModel::create(['year' => '2025-2026']);
    $this->actingAs($admin);

    // Setting the property will automatically trigger updatedSelectedSchoolYear lifecycle hook
    $response = Livewire::test(SchoolYear::class)
        ->set('selectedSchoolYear', '2025-2026');

    $response->assertRedirect(route('admin_dashboard'));
    
    // Clear cache to get fresh value
    Cache::forget('settings:current_school_year');
    expect(Setting::getSchoolYear())->toBe('2025-2026');
});

test('admin can add new school year', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(SchoolYear::class)
        ->set('newSchoolYear', '2025-2026')
        ->call('addSchoolYear');

    $response->assertHasNoErrors();
    
    $this->assertDatabaseHas('school_years', ['year' => '2025-2026']);
});

test('school year must be in correct format', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->actingAs($admin);

    $response = Livewire::test(SchoolYear::class)
        ->set('newSchoolYear', 'invalid-format')
        ->call('addSchoolYear');

    $response->assertHasErrors(['newSchoolYear']);
});

test('school year must be unique', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    SchoolYearModel::create(['year' => '2025-2026']);
    $this->actingAs($admin);

    $response = Livewire::test(SchoolYear::class)
        ->set('newSchoolYear', '2025-2026')
        ->call('addSchoolYear');

    $response->assertHasErrors(['newSchoolYear']);
});

test('school year list is cached', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);
    SchoolYearModel::create(['year' => '2024-2025']);
    $this->actingAs($admin);

    $response = Livewire::test(SchoolYear::class);
    
    expect(Cache::has('school_years:list'))->toBeTrue();
});

