<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    <flux:heading size="xl" class="max-lg:hidden font-bold">Events this {{ $selectedMonth }}</flux:heading>

    {{-- Mobile view --}}
    <div class="flex items-center justify-between gap-20 lg:hidden whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Events this {{ $selectedMonth }}</flux:heading>

        <!-- Desktop User Menu -->
        <flux:dropdown position="top" align="end">
            <flux:profile circle class="cursor-pointer" :initials="auth()->user()->initials()" avatar:color="auto"
                avatart:color:seed="{{ auth()->user()->id }}" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-zinc-50 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </div>

    {{-- Events for the month --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-8 mt-5">

        @foreach ($events as $event)

            {{-- Event Card --}}
            <div 

                x-data="{ fullscreenModal: false }"
                x-init="
                $watch('fullscreenModal', function(value){
                        if(value === true){
                            document.body.classList.add('overflow-hidden');
                        }else{
                            document.body.classList.remove('overflow-hidden');
                        }
                    })
                "
                @keydown.escape="fullscreenModal=false"
                class="cursor-pointer"
                >

                {{-- Card Content --}}
                <div 
                    @click="fullscreenModal=true"
                    class="relative grid min-h-64 max-w-md sm:max-w-full flex-col items-center justify-between overflow-hidden rounded-xl bg-zinc-950
                        border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                        ">
                    <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                        {{-- style="background-image: url('{{ asset('storage/' . $event->image) }}');" --}}
                        style="background-image: url('https://picsum.photos/seed/{{ rand(0, 100000) }}/1080/566');"
                        >
                        
                        <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                        </div>
                    </div>
                    <div class="relative space-y-3 p-6 px-6 py-10 md:px-12">
                        <flux:text class="font-medium text-zinc-300">
                            {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                        </flux:text>
                        <h2 class="text-2xl font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
                            {{ $event->title }}
                        </h2>

                        <div class="space-y-1">
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

                        <div class="flex items-end">

                            {{-- Tags --}}
                            @php
                                $timezone = 'Asia/Manila';
                                $now = \Carbon\Carbon::now()->timezone($timezone);

                                // Combine the actual date with the time strings
                                $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                            @endphp

                            @if ($event->status ==  \App\Enums\EventStatus::NotFinished)
                                <flux:heading size="sm" class="flex items-center gap-2">
                                    End of Attendance: <span
                                        class="text-[var(--color-accent)] underline">{{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>
                                </flux:heading>
                            @endif

                            {{-- Event status --}}
                            @if ($event->status != \App\Enums\EventStatus::Postponed)
                                @if ($now->between($start, $end))
                                    <flux:badge color="amber" class="" variant="solid"><span class="text-black">
                                        Event In Progress</span></flux:badge>
                                @endif
                            @endif
                            @if ($event->status == \App\Enums\EventStatus::Finished)
                                <flux:badge color="green" class="" variant="solid"><span
                                        class="text-black">Event Ended</span></flux:badge>
                            @endif
                            @if ($event->status == \App\Enums\EventStatus::Postponed)
                                <flux:badge color="red" class="" variant="solid"><span
                                        class="text-white">Event Postponed</span></flux:badge>
                            @endif
                            
                        </div>
                    </div>

                </div>

                {{-- Modal Content --}}
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
        @endforeach

    </div>



</div>