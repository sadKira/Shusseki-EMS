<div>
    <flux:navlist.item :href="route('settings.profile')" wire:navigate
    :current="$currentRoute === 'settings.profile'">
        {{ __('Profile') }}
    </flux:navlist.item>
</div>