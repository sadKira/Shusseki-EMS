<div>
    <flux:navlist.item :href="route('settings.password')" wire:navigate
    :current="$currentRoute === 'settings.password'">
        {{ __('Password') }}
    </flux:navlist.item>
</div>
