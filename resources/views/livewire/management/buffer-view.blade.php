<div>
    {{-- App Header --}}
    <div class="relative">
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
</div>