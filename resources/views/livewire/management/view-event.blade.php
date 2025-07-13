<div>
    {{-- App Header
    <div class=" relative mb-10 w-full">
        Breadcrumbs
        <div class="mt-2 flex">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                <flux:breadcrumbs.item :href="route('view_event', $event)" :accent="true" wire:navigate>
                    <span class="text-[var(--color-accent)]">View Event<span>
                </flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
        <flux:heading size="xl" level="1">View Event</flux:heading>
    </div> --}}


    {{-- Event content --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-3">
        <!-- Event Image -->
        <div class="lg:col-span-3 px-10 py-6">
            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                class="rounded-xl w-full h-70 object-cover shadow-md">
        </div>

        
        
        <!-- Event Details -->
        <div class="lg:col-span-2 px-10 py-6 flex justify-content">
            <div class="flex items-center gap-x-6">

                <flux:separator class="my-10" vertical />

                <div class="space-y-3 text-balance">
                    <flux:text class="mb-4" variant="strong">Academic Year {{ $event->school_year }}</flux:text>
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
        <div class="lg:col-span-5 px-10 py-6 border">
            <div class="border">
                 <flux:heading size="xl">Event Description</flux:heading>
                <p class="text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $event->description }}</p>
            </div>
        </div>
    </div>


</div>