<div>
    <flux:navlist.item :href="route('user_password')" wire:navigate
    :current="$currentRoute === 'user_password'">
        {{ __('Password') }}
    </flux:navlist.item>
</div>