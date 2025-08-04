<div>
    <flux:navlist.item :href="route('settings.sakey')" wire:navigate
    :current="$currentRoute === 'settings.sakey'">
        {{ __('Admin Key') }}
    </flux:navlist.item>
</div>
