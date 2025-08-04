<div>
    <flux:navlist.item :href="route('settings.schoolyear')" wire:navigate
    :current="$currentRoute === 'settings.schoolyear'">
        {{ __('Academic Year') }}
    </flux:navlist.item>
</div>