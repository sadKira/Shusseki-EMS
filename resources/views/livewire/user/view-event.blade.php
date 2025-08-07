<div class="max-w-4xl mx-auto px-2 sm:px-4 lg:px-8 py-6">
    {{-- <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('dashboard')" wire:navigate>Return</flux:button> --}}
    <div class="w-full">
        <!-- Event Image -->
        <div class="w-full overflow-hidden rounded-lg mb-4">
            <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                class="w-full h-auto max-h-[250px] object-cover object-center mx-auto" />
        </div>
        <flux:heading size="xl" class="font-bold text-lg sm:text-2xl mb-2">{{ $event->title }}</flux:heading>
        <div class="space-y-2 mb-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 text-sm text-gray-700 dark:text-zinc-50">
                <div class="flex items-center gap-2">
                    <flux:icon.calendar class="text-zinc-500 dark:text-zinc-50" />
                    <span>
                        {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }},
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <flux:icon.map-pin class="text-zinc-500 dark:text-zinc-50" />
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>
        <!-- Add event description or other details here if needed -->
    </div>
</div>