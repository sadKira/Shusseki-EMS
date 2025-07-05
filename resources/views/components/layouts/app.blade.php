<x-layouts.app.sidebar :title="$title ?? null" >
    {{-- dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 --}}
    {{-- dark:bg-zinc-900 --}}
    <flux:main class="dark:bg-zinc-950">

        {{ $slot }}

    </flux:main>
    
</x-layouts.app.sidebar>
 