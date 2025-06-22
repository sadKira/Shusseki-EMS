<?php

namespace App\Livewire;

use App\Enums\UserRole;

use App\Livewire\landing\Welcome;

use App\Livewire\Management\AdminDashboard;
use App\Livewire\Management\ManageEvents;
use App\Livewire\Management\ManageStudents;
use App\Livewire\Management\ManageApproval;
use App\Livewire\Management\CoverageEvents;

use App\Livewire\User\Dashboard;
use App\Livewire\User\Events;

use App\Livewire\Tsuushin\TsuushinDashboard;

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/', Welcome::class)->name('home');

// Testing
Route::get('/test', function () {
    return view('buffer');
});
Route::get('/error', function () {
    return view('error');
});

// Management
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->group(function () {
    // Protected routes
    Route::get('admin/dashboard', AdminDashboard::class)->name('admin_dashboard');
    Route::get('admin/events', ManageEvents::class)->name('manage_events');
    Route::get('admin/students', ManageStudents::class)->name('manage_students');
    Route::get('admin/students-approval', ManageApproval::class)->name('manage_approval');
    Route::get('admin/events-coverage', CoverageEvents::class)->name('coverage_events');
});


// User
Route::middleware(['auth', 'verified', 'user', 'approved'])->group(function () {
    // Protected routes
    Route::get('user/dashboard', Dashboard::class)->name('dashboard');
     Route::get('user/events', Events::class)->name('events');
   
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
