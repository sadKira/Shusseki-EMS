<div wire:poll.5s>
    <flux:navlist.item icon="shield-check" :badge="$count > 0 ? $count : null" :href="route('manage_approval')"
        :current="$currentRoute === 'manage_approval'" wire:navigate>
        {{ __('Student Approval') }}
    </flux:navlist.item>
</div>