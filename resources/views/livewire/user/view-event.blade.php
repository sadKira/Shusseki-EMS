<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('dashboard')" wire:navigate>Return
    </flux:button> --}}

    <div class="px-10">
        <!-- Event Image -->
        <div class="relative w-full sm:h-full md:h-full lg:h-70 overflow-hidden">
            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                class="absolute inset-0 w-full h-full object-cover object-center" />
        </div>

        <flux:heading size="xl" class="font-bold">{{ $event->title }}</flux:heading>

        <div class="space-y-1">
            <div class="flex items-center gap-2">
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
        </div>

    </div>

</div>