<div>

    {{-- App Header --}}
    <div class="relative mb-10 w-full">
        {{-- Breadcrumbs --}}
        <div class="mt-2    ">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Student List<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        @can('SA')
            <flux:heading size="xl" level="1">Manage Students</flux:heading>
        @endcan
        @can('A')
            <flux:heading size="xl" level="1">Student List</flux:heading>
        @endcan
    </div>

    {{-- Table --}}
    <div>
        <livewire:management.filter-table />
    </div>

</div>