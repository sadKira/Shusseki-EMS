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

    <!-- Event Modal -->
                            <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
                                <div class="relative max-w-xl w-full rounded-xl overflow-hidden shadow-2xl">
                                    
                                    <!-- Background Image -->
                                    <div class="relative h-96">
                                        <img src="{{ asset('storage/' . $event->image) }}" 
                                            alt="Event Image"
                                            class="absolute inset-0 w-full h-full object-cover">

                                        <!-- Gradient Details Panel -->
                                        <div class="absolute inset-0 flex justify-end">
                                            <!-- Close button -->
                                            <button @click="modalOpen=false" 
                                                class="absolute top-4 right-4 flex items-center justify-center w-8 h-8 text-zinc-50 bg-black rounded-full hover:text-black hover:bg-zinc-50 z-10">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>  
                                            </button>

                                            <!-- Wider gradient, but text still in narrow area -->
                                            <div class="w-3/5 h-full bg-gradient-to-l from-zinc-950/95 via-zinc-950/80 to-transparent flex justify-end  ">
                                                <div class="space-y-3 p-4 flex flex-col justify-center">
                                                    <h2 class="font-bold text-2xl text-zinc-50">{{ $event->title }}</h2>
                                                    <div class="flex items-center gap-1">
                                                        <flux:icon.clock variant="solid" class="text-zinc-300 size-4" />
                                                        <flux:heading size="sm" class="text-zinc-300">
                                                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                                        </flux:heading>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <flux:icon.map-pin variant="solid" class="text-zinc-300 size-4" />
                                                        <flux:heading size="sm" class="text-zinc-300">
                                                            {{ $event->location }}
                                                        </flux:heading>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
</div>