<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
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

        Gate::define('tsuushin_dashboard', fn(User $user) => $user->role == UserRole::Tsuushin);
        Gate::define('dashboard', fn(User $user) => $user->role == UserRole::User);



        Gate::define(
            'manage',
            fn(User $user) =>
            $user->role === UserRole::Super_Admin || $user->role === UserRole::Admin
        );

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
                    'manage_students' => 'Manage Students',
                    'manage_approval' => 'Student Approval',
                    'coverage_events' => 'Events Coverage',

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
