<?php

use App\Enums\UserRole;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Testing
Route::get('/test', function () {
    return view('buffer');
});

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'user'])
    ->name('dashboard');

Route::view('super_admin/dashboard', 'super_admin.dashboard')
    ->middleware(['auth', 'verified', 'super_admin'])
    ->name('super_admin.dashboard');

Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

Route::view('tsuushin/dashboard', 'tsuushin.dashboard')
    ->middleware(['auth', 'verified', 'tsuushin'])
    ->name('tsuushin.dashboard');

// Management
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->group(function () {
    // Protected routes
    Route::view('/events', 'management.manage_events')->name('management.manage_events');
    Route::view('/students', 'management.manage_students')->name('management.manage_students');
    Route::view('/event-coverage', 'management.coverage_events')->name('management.coverage_events');
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
