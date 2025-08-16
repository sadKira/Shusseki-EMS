<div>
    <flux:navlist.item icon="lock-closed" :href="route('user_password')" wire:navigate
    :current="$currentRoute === 'user_password'">
        {{ __('Password') }}
    </flux:navlist.item>
</div>