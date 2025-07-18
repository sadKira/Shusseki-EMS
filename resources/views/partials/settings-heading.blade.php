{{-- App Header --}}
<div class=" relative mb-10 w-full">
    {{-- Breadcrumbs --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="mt-2">
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                    <flux:breadcrumbs.item :href="route('settings.profile')" :accent="true" wire:navigate>
                        <span class="text-[var(--color-accent)]">Settings<span>
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:heading size="xl" level="1">Settings</flux:heading>
        </div>
    </div>
</div>
