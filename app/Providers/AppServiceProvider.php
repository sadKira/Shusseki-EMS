<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
        Gate::define(
            'dark_mode',
            fn(User $user) =>
            $user->role === UserRole::Super_Admin || $user->role === UserRole::Admin
        );

        // No Dark Mode
        Gate::define(
            'no_dark_mode',
            fn(User $user) =>
            $user->role === UserRole::Tsuushin || $user->role === UserRole::User
        );



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
                    'manage_approval' => 'Students',
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
        // View::composer('*', function ($view) {
        //     $user = Auth::user();

        //     if (!$user) {
        //         $view->with('title', config('app.name'));
        //         return;
        //     }

        //     $titles = match (true) {
        //         in_array($user->role, [UserRole::Admin, UserRole::Super_Admin]) => [
        //             'admin_dashboard' => 'Admin Dashboard',
        //             'manage_events' => 'Manage Events',
        //             'manage_students' => 'Manage Students',
        //             'coverage_events' => 'Events Coverage',
        //             'tsuushin_dashboard' => 'Tsuushin Dashboard',
        //         ],
        //         $user->role === UserRole::Tsuushin => [
        //             'tsuushin_dashboard' => 'Tsuushin Dashboard',
        //         ],
        //         default => [
        //             'dashboard' => "Welcome {$user->name}!",
        //         ],
        //     };

        //     $currentRoute = request()->route()?->getName();
        //     $title = collect($titles)->get($currentRoute) ?? config('app.name');

        //     $view->with('title', $title);
        // });
    }
}
