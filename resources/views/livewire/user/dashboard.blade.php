<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <flux:heading size="xl" class="max-lg:hidden font-bold">Events this {{ $selectedMonth }}</flux:heading>

    {{-- Mobile view --}}
    <div class="flex items-center justify-between gap-20 lg:hidden">
        <flux:heading size="xl" class="font-bold">Events this Events this {{ $selectedMonth }}</flux:heading>

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
            <a href="{{ route('user_viewevent', $event) }}" wire:navigate
                class="relative grid h-[20rem] max-w-md sm:max-w-full flex-col items-start justify-between overflow-hidden rounded-xl bg-zinc-950
                     border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                    ">
                <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                    {{-- style="background-image: url('{{ asset('storage/' . $event->image) }}');" --}}
                    style="background-image: url('https://picsum.photos/seed/{{ rand(0, 100000) }}/1080/566');"
                    >
                    
                    <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                    </div>
                </div>
                <div class="relative space-y-4 p-6 px-6 py-14 md:px-12">
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

            </a>

        @endforeach

    </div>



</div>