<div>
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">
        {{-- Breadcrumbs
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                <flux:breadcrumbs.item :href="route('view_event', $event)" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">View Event<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:heading size="xl" level="1">View Event</flux:heading> --}}
        <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('manage_events')" wire:navigate>Return</flux:button>
    </div>


    {{-- Event content --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-7">
        <!-- Event Image -->
        <div class="lg:col-span-3 px-10 py-6">
            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                class="w-full h-70 object-cover shadow-md">
        </div>

        
        
        <!-- Event Details -->
        <div class="lg:col-span-2 px-10 py-6 flex justify-content">
            <div class="flex items-center gap-x-6">

                <flux:separator class="my-4" vertical />

                <div class="space-y-3 text-balance">
                    <flux:text class="mb-4" variant="strong">Academic Year <span class="text-[var(--color-accent)]">{{ $event->school_year }}</span></flux:text>
                    <flux:heading size="xl">{{ $event->title }}</flux:heading>

                    <div class="flex items-center gap-2 mt-4">
                        <flux:icon.calendar class="text-zinc-50" />
                        <flux:heading>
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}, 
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - 
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                        </flux:heading>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:icon.map-pin class="text-zinc-50" />
                        <flux:heading>{{ $event->location }}</flux:heading>
                    </div>
                    

                    <flux:heading class="flex items-center gap-2 mt-4">
                        Time In: {{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}

                        <flux:tooltip position="bottom" toggleable>
                            <flux:button icon="information-circle" variant="ghost" />
                            <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                <p>Failure to scan their QRs during</p>
                                <p>time-in will be marked as "Late".</p>
                            </flux:tooltip.content>
                        </flux:tooltip>
                    </flux:heading>
                </div>
            </div>
        
        </div>
        
        <!-- Event Description -->
        <div class="lg:col-span-3 px-10 py-4 text-balance">
            <flux:heading size="xl" class="">Event <span class="text-[var(--color-accent)]">Description</span></flux:heading>
            <flux:separator class="mt-2" />
            <flux:text class="text-base leading-relaxed mt-4 text-zinc-50">{{ $event->description }}</flux:text>
        </div>

        <!-- Admin Tools -->
        <div class="lg:col-span-2 px-10 py-4 justify-content">
            <div class="flex flex-col gap-2">
                <flux:button variant="primary" icon:trailing="arrow-up-right" color="amber" :href="route('attendance_bin', $event)" wire:navigate>View Attendance Bin</flux:button>
                <flux:button variant="filled" icon:trailing="pencil-square" :href="route('edit_event', $event)" wire:navigate>Edit Event</flux:button>
            </div>
        </div>
    </div>


</div>