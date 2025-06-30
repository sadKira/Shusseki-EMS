<div wire:poll.5s>
    <flux:navlist.item icon="shield-check" badge="{{ $count }}" :href="route('manage_approval')"
        wire:navigate>
        {{ __('Student Approval') }}
    </flux:navlist.item>
</div>