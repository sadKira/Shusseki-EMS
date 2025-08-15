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
use App\Livewire\Management\CreateEvent;
use App\Livewire\Management\ViewEvent;
use App\Livewire\Management\EditEvent;
use App\Livewire\Management\AttendanceBin;
use App\Livewire\Management\BufferView;
use App\Livewire\Management\EventList;
use App\Livewire\Management\StudentRecord;
use App\Livewire\Management\GenerateReport;
use App\Livewire\Management\ViewStudentRecord;

use App\Livewire\User\Dashboard;
use App\Livewire\User\Events;
use App\Livewire\User\AttendanceRecord;
use App\Livewire\User\ViewEvent as UserViewEvent;
use App\Livewire\User\MainProfile;
use App\Livewire\User\Password as UserPassword;
use App\Livewire\User\EditProfile;

use App\Livewire\Tsuushin\TsuushinDashboard;

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\SchoolYear;
use App\Livewire\Settings\SuperadminPin;
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
    Route::get('admin/event-timeline/{event}', ViewEvent::class)->name('view_event_timeline');
    Route::get('admin/attendance-record/{user}', ViewStudentRecord::class)->name('view_student_record');
    
    Route::get('admin/event-timeline', EventList::class)->name('event_timeline');

    Route::get('admin/students', ManageStudents::class)->name('manage_students');
    Route::get('admin/student-approval', ManageApproval::class)->name('manage_approval');
    Route::get('admin/attendance-bin/{event}', AttendanceBin::class)->name('attendance_bin');
    Route::get('admin/attendance-record',StudentRecord::class)->name('attendance_records');
    
    Route::get('admin/generate-report', GenerateReport::class)->name('generate_report');

    Route::get('admin/create-event', CreateEvent::class)->name('create_event');
    Route::get('admin/edit-event/{event}', EditEvent::class)->name('edit_event');

    Route::get('admin/buffer-view', BufferView::class)->name('buffer_view');
});

// User (Active)
Route::middleware(['auth', 'verified', 'user', 'approved', 'active'])->group(function () {
    // Protected routes
    Route::get('user/home', Dashboard::class)->name('dashboard');
    Route::get('user/event-calendar', Events::class)->name('events');
    Route::get('user/attendance-record', AttendanceRecord::class)->name('attendance_record');

    // Profile
    Route::get('user/my-profile', MainProfile::class)->name('user_main_profile');
    Route::get('user/password', UserPassword::class)->name('user_password');
    Route::get('user/edit-profile', EditProfile::class)->name('user_edit_profile');

    Route::get('user/view-event/{event}', UserViewEvent::class)->name('user_viewevent');
   
});

// User (Inactive)
Route::middleware(['auth', 'verified', 'user', 'approved', 'inactive'])->group(function () {
    // Protected routes
    Route::get('user/access-denied', Denied::class)->name('access_denied'); 
    Route::post('logout', Logout::class)->name('logout'); 
});


// // Tsuushin
// Route::middleware(['auth', 'verified', 'tsuushin'])->group(function () {
//     // Protected routes
//     Route::get('tsuushin/dashboard', Dashboard::class)->name('dashboard');
//     Route::get('tsuushin/event-calendar', Events::class)->name('events');
//     Route::get('tsuushin/attendance-record', AttendanceRecord::class)->name('attendance_record');
//     Route::get('tsuushin/qr-code', QCode::class)->name('qr_code');

//     Route::get('tsuushin/view-event/{event}', UserViewEvent::class)->name('user_viewevent');
   
// });

// Admin Settings
Route::middleware(['auth', 'approved', 'role:super_admin,admin'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('admin/settings/profile', Profile::class)->name('settings.profile');
    Route::get('admin/settings/password', Password::class)->name('settings.password');
    Route::get('admin/settings/school-year', SchoolYear::class)->name('settings.schoolyear');
    Route::get('admin/settings/admin-key', SuperadminPin::class)->name('settings.sakey');

    Route::get('admin/settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
