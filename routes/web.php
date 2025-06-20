<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Management\AdminDashboard;
use App\Livewire\Management\ManageEvents;
use App\Livewire\Management\ManageStudents;
use App\Livewire\Management\CoverageEvents;
use App\Livewire\User\Dashboard;
use App\Livewire\Tsuushin\Dashboard as TsuushinDashboard;
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

// Management
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->group(function () {
    // Protected routes
    Route::get('admin/dashboard', AdminDashboard::class)->name('admin_dashboard');
    Route::get('admin/events', ManageEvents::class)->name('manage_events');
    Route::get('admin/students', ManageStudents::class)->name('manage_students');
    Route::get('admin/events/coverage', CoverageEvents::class)->name('coverage_events');
});


// User
Route::middleware(['auth', 'verified', 'user', 'approved'])->group(function () {
    // Protected routes
    Route::get('user/dashboard', Dashboard::class)->name('dashboard');
   
});


// Tsuushin
Route::middleware(['auth', 'verified', 'tsuushin'])->group(function () {
    // Protected routes
    Route::get('tsuushin/dashboard', TsuushinDashboard::class)->name('tsuushin_dashboard');
   
});

Route::middleware(['auth', 'approved'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
