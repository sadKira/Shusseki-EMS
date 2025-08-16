<div>
    <flux:navlist.item icon="qr-code" :href="route('user_main_profile')"  wire:navigate
    :current="$currentRoute === 'user_main_profile'">
        {{ __('QR Code') }}
    </flux:navlist.item>
</div>