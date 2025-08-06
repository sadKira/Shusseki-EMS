<x-layouts.app.header :title="$title ?? null">
    <flux:main class="">
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
