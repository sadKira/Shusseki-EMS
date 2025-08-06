<div>
    {{-- App Header --}}
    <div class="relative mb-10">
        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="mt-2">
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                        <flux:breadcrumbs.item :href="route('buffer_view')" :accent="true" wire:navigate>
                            <span class="text-[var(--color-accent)]">Buffer View<span>
                        </flux:breadcrumbs.item>
                    </flux:breadcrumbs>
                </div>
                <flux:heading size="xl" level="1">Buffer View</flux:heading>
            </div>
        </div>
    </div>

    <div class="min-h-screen bg-zinc-900 text-white">
        <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <!-- Header -->
            <header class="mb-8 text-center">
                <h1 class="text-3xl font-bold tracking-tight mb-2">💡 Centered Layout Demo</h1>
                <p class="text-zinc-400 max-w-md mx-auto">
                    That’s the secret behind most modern, centered layouts you see on websites.
                </p>
            </header>

            <!-- Static Idea List -->
            <section class="space-y-4">
                @foreach ($ideas as $idea)
                    <div class="bg-zinc-800 border border-zinc-700 rounded-lg p-4 shadow-md hover:shadow-lg transition">
                        {{ $idea }}
                    </div>
                @endforeach
            </section>

            <!-- Footer note -->
            <footer class="mt-10 text-sm text-zinc-500 text-center">
                Built with the TALL stack & Tailwind’s layout tricks.
            </footer>
        </main>
    </div>








</div>