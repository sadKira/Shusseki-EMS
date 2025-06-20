@php
    $titles = [
        'admin_dashboard' => 'Admin Dashboard',
        'manage_events' => 'Manage Events',
        'manage_students' => 'Manage Students',
        'coverage_events' => 'Events Coverage',
    ];
    $title = collect($titles)->first(fn ($label, $route) => request()->routeIs($route)) ?? 'Dashboard';
@endphp


<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
