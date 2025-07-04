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

    <div class="flex items-center justify-between">
        {{-- Month--}}
        <div class="mt-10">
            <flux:heading size="xl" level="1">Monday, July 12</flux:heading>
            <flux:heading size="lg" level="1">A.Y. 2024-25</flux:heading>


        </div>
        {{-- Upcoming events --}}
        <div>
            <flux:heading size="xl" level="1">No Upcoming Events</flux:heading>
        </div>
    </div>

    {{-- Events --}}

    <section class="mt-10">
        <flux:dropdown>
            <flux:button variant="filled" icon:trailing="chevron-down">July</flux:button>
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>January</flux:menu.radio>
                    <flux:menu.radio>February</flux:menu.radio>
                    <flux:menu.radio>March</flux:menu.radio>
                    <flux:menu.radio>April</flux:menu.radio>
                    <flux:menu.radio>May</flux:menu.radio>
                    <flux:menu.radio>June</flux:menu.radio>
                    <flux:menu.radio>July</flux:menu.radio>
                    <flux:menu.radio>August</flux:menu.radio>
                    <flux:menu.radio>September</flux:menu.radio>
                    <flux:menu.radio>October</flux:menu.radio>
                    <flux:menu.radio>November</flux:menu.radio>
                    <flux:menu.radio>December</flux:menu.radio>
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>
        <flux:button variant="ghost">Filter</flux:button>
    </section>
    


</div>