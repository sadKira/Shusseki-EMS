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

    <template x-teleport="body">

        <div 
            x-show="fullscreenModal"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex fixed inset-0 z-[99] w-screen h-screen bg-zinc-950"
            >
            
            {{-- Main content --}}
            <div class="w-full h-full flex flex-col bg-zinc-950">

                <!-- Image section with overlayed return button -->
                <div class="relative w-full flex-shrink-0" style="height: 30vh; min-height: 220px;">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                        class="w-full h-full object-cover object-center" />
                    <button @click="fullscreenModal=false" class="absolute top-4 left-4 z-10 bg-zinc-900/70 hover:bg-zinc-900/90 text-white rounded-full p-2 shadow-md backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-accent flex items-center">
                        <flux:icon.arrow-uturn-left class="w-5 h-5" />
                    </button>
                    <!-- Top gradient for text contrast -->
                    <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-transparent pointer-events-none"></div>
                    <!-- Bottom gradient for fade into bg-zinc-950 -->
                    <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-b from-transparent to-zinc-950 pointer-events-none"></div>
                </div>
                
                <!-- Details section -->
                <div class="flex-1 w-full max-w-2xl mx-auto px-4 py-6 overflow-y-auto">
                    <h2 class="font-bold text-3xl text-zinc-50">{{ $event->title }}</h2>

                    <div class="space-y-3 mt-5 grid lg:grid-cols-2">
                        <div class="flex flex-col gap-4">
                            <div class="gap-2">
                                <div class="flex items-center gap-2">
                                    <flux:icon.calendar class="text-zinc-50 size-4" />
                                    <flux:heading size="lg">Date and Time</flux:heading>
                                </div>
                                <div class="flex items-center gap-2">
                                    <flux:icon.calendar class="size-4 opacity-0" />
                                    <flux:text class="text-zinc-300">
                                        {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }},
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                    </flux:text>
                                </div>
                                
                            </div>

                            <div class="gap-2">
                                <div class="flex items-center gap-2">
                                    <flux:icon.map-pin class="text-zinc-50 size-4" />
                                    <flux:heading size="lg">Location</flux:heading>
                                </div>
                                <div class="flex items-center gap-2">
                                    <flux:icon.calendar class="size-4 opacity-0" />
                                    <flux:text class="text-zinc-300">
                                        {{ $event->location }}
                                    </flux:text>
                                </div>
                                
                            </div>

                            <div class="gap-2">
                                <div class="flex items-center gap-2">
                                    <flux:icon.clock class="text-zinc-50 size-4" />
                                    <flux:heading size="lg">End of Attendance</flux:heading>
                                </div>
                                <div class="flex items-center gap-2">
                                    <flux:icon.calendar class="size-4 opacity-0" />
                                    <flux:text class="text-zinc-300">
                                        <span class="text-[var(--color-accent)] underline">
                                            {{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}
                                        </span>
                                    </flux:text>
                                </div>
                                
                            </div>
                            
                        </div>

                        <div class="gap-2">
                            <div class="flex items-center gap-2">
                                <flux:icon.information-circle class="text-zinc-50 size-4" />
                                <flux:heading size="lg">Description</flux:heading>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon.calendar class="size-4 opacity-0" />
                                <div x-data="{ showFullText: false }" class="w-full">
                                    <p :class="{ 'truncate overflow-hidden text-ellipsis': !showFullText }" class="text-zinc-300 inline-block w-full">
                                        {{ $event->description }}
                                    </p>
                                    <button @click="showFullText = !showFullText" class="text-accent hover:underline ml-1 text-xs mt-2" type="button">
                                        <span x-text="showFullText ? 'Read Less' : 'Read More'"></span>
                                    </button>
                                        
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Add event description or other details here if needed -->
                </div>
            </div>
        </div>
        
    </template>
</div>