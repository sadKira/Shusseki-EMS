<?php

namespace App\Livewire;

use App\Enums\UserRole;
use App\Livewire\Actions\Logout;
use App\Livewire\Auth\Approval;
use App\Livewire\Auth\Denied;
use App\Livewire\landing\Welcome;

use App\Livewire\Management\AdminDashboard;
use App\Livewire\Management\ManageEvents;
use App\Livewire\Management\ManageStudents;
use App\Livewire\Management\ManageApproval;
use App\Livewire\Management\CoverageEvents;
use App\Livewire\Management\CreateEvent;
use App\Livewire\Management\ViewEvent;
use App\Livewire\Management\EditEvent;

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

// Token refreshing
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
})->name('refresh-csrf');

// User Approval
Route::middleware(['auth', 'verified', 'user', 'pending'])->group(function () {
    // Protected routes
    Route::get('user/approval-pending', Approval::class)->name('approval_pending'); 
    Route::post('logout', Logout::class)->name('logout');  
});

// Management
// Super // Admin
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->group(function () {
    // Protected routes
    Route::get('admin/dashboard', AdminDashboard::class)->name('admin_dashboard');
    Route::get('admin/events', ManageEvents::class)->name('manage_events');
    Route::get('admin/events/{event}', ViewEvent::class)->name('view_event');
    Route::get('admin/students', ManageStudents::class)->name('manage_students');
    Route::get('admin/students-approval', ManageApproval::class)->name('manage_approval');
    Route::get('admin/events-coverage', CoverageEvents::class)->name('coverage_events');

    Route::get('admin/create-event', CreateEvent::class)->name('create_event');
    Route::get('admin/edit-event/{event}', EditEvent::class)->name('edit_event');
});

// User (Active)
Route::middleware(['auth', 'verified', 'user', 'approved', 'active'])->group(function () {
    // Protected routes
    Route::get('user/dashboard', Dashboard::class)->name('dashboard');
    Route::get('user/events', Events::class)->name('events');
   
});

// User (Inactve)
Route::middleware(['auth', 'verified', 'user', 'approved', 'inactive'])->group(function () {
    // Protected routes
    Route::get('user/access-denied', Denied::class)->name('access_denied'); 
    Route::post('logout', Logout::class)->name('logout'); 
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
