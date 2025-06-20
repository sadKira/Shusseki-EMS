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

        Gate::define('tsuushin.dashboard', fn(User $user) => $user->role == UserRole::Tsuushin);
        Gate::define('dashboard', fn(User $user) => $user->role == UserRole::User);

        Gate::define(
            'manage_dashboard',
            fn(User $user) =>
            $user->role === UserRole::Super_Admin || $user->role === UserRole::Admin
        );

        Gate::define(
            'manage_events',
            fn(User $user) =>
            $user->role === UserRole::Super_Admin || $user->role === UserRole::Admin
        );

        Gate::define(
            'manage_students',
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
            $titles = match ($user->role ?? null) {
                UserRole::Admin, UserRole::Super_Admin => [
                    'admin_dashboard' => 'Admin Dashboard',
                    'manage_events' => 'Manage Events',
                    'manage_students' => 'Manage Students',
                    'coverage_events' => 'Events Coverage',
                ],
                default => [
                    'dashboard' => "Welcome {$user->name}!",
                ],
            };

            $title = collect($titles)
                ->first(fn($label, $route) => request()->routeIs($route)) ?? 'Dashboard';

            $view->with('title', $title);
        });
    }
}
