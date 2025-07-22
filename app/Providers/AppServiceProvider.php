<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Shusseki Gates
         */

        // Management
        Gate::define(
            'manage',
            fn(User $user) =>
            $user->role === UserRole::Super_Admin || $user->role === UserRole::Admin
        );

        // Management Specific
        // Super admin capabilities
        Gate::define('SA', fn(User $user) => $user->role == UserRole::Super_Admin);

        // Admin capabilities
        Gate::define('A', fn(User $user) => $user->role == UserRole::Admin);


        // Tsuushin & User
        Gate::define('tsuushin_dashboard', fn(User $user) => $user->role == UserRole::Tsuushin);
        Gate::define('dashboard', fn(User $user) => $user->role == UserRole::User);





        // Dark Mode
        // Gate::define(
        //     'dark_mode',
        //     fn(User $user) =>
        //     $user->role === UserRole::Super_Admin || $user->role === UserRole::Admin
        // );

        // // No Dark Mode
        // Gate::define(
        //     'no_dark_mode',
        //     fn(User $user) =>
        //     $user->role === UserRole::Tsuushin || $user->role === UserRole::User
        // );

        // Default CSS Paginator
        Paginator::useTailwind();
        // Paginator::useBootstrapFour();

        // Prevent lazy loading
        Model::preventLazyLoading();


        /**
         * Notification badges
         */

        View::composer(['components.layouts.app.sidebar', 'livewire.management.manage-approval'], function ($view) {
            $pendingCount = User::where('status', 'pending')->count();
            $view->with('pendingCount', $pendingCount);
        });


        /**
         * Dynamic Titles
         */
        View::composer('*', function ($view) {
            $user = Auth::user();

            // Handle case when user is not authenticated
            if (!$user) {
                $view->with('title', config('app.name'));
                return;
            }

            $titles = match ($user->role) {
                UserRole::Admin, UserRole::Super_Admin, UserRole::Tsuushin, UserRole::User  => [
                    // Management
                    'admin_dashboard' => 'Admin Dashboard',
                    'manage_events' => 'Events',
                    'manage_students' => 'Students',
                    'manage_approval' => 'Student Approval',
                    'coverage_events' => 'Events Coverage',
                    'create_event' => 'Create Event',
                    'view_event' => 'View Event',
                    'edit_event' => 'Edit Event',
                    'attendance_bin' => 'Attendance Bin',
                    'settings.profile' => 'Settings',
                    'settings.password' => 'Settings',
                    'settings.schoolyear' => 'Settings',
                    'event_list' => 'Event List',
                    'student_records' => 'Student Records',
                    'generate_report' => 'Generate Report',


                    'buffer_view' => 'Buffer View',

                    //Tsuushin
                    'tsuushin_dashboard' => 'Tsuushin Dashboard',

                    //User
                    'dashboard' => 'Dashboard',
                    'events' => 'Events',
                ],
                default => [
                    'error' => "error",
                ],
            };

            $title = collect($titles)
                ->first(fn($label, $route) => request()->routeIs($route)) ?? 'Dashboard';

            $view->with('title', $title);
        });
    }
}
