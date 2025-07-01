<div>
    {{-- App Header --}}
    <div class=" relative mb-6 w-full">
        <flux:heading size="xl" level="1">Manage Events</flux:heading>
        {{-- Breadcrumbs --}}
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_events')" wire:navigate>Events
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_events')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Manage Events<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div>


</div>