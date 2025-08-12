<div>
    <flux:navlist.item :href="route('user_main_profile')" wire:navigate
    :current="$currentRoute === 'user_main_profile'">
        {{ __('Profile') }}
    </flux:navlist.item>
</div>