<div>
    <flux:navlist.item :href="route('user_edit_profile')" wire:navigate
    :current="$currentRoute === 'user_edit_profile'">
        {{ __('Edit Profile') }}
    </flux:navlist.item>
</div>