<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Manage Students</flux:heading>
        {{-- Breadcrumbs --}}
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" wire:navigate>Students
                </flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('manage_students')" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">Student List<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div>

    @script
    <script>
        setInterval(() => {
            $wire.$refresh()
        }, 5000)
    </script>
    @endscript

    {{-- Table --}}
    <div class="mt-10">
        <livewire:management.filter-table />
    </div>

</div>