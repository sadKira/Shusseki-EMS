<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    <flux:heading size="xl" class="max-lg:hidden font-bold">Event calendar {{ $selectedSchoolYear }}</flux:heading>

    {{-- Mobile view --}}
    <div class="flex items-center justify-between gap-20 lg:hidden whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">Event calendar {{ $selectedSchoolYear }}</flux:heading>

        <!-- Desktop User Menu -->
        <flux:dropdown position="top" align="end">
            <flux:profile circle class="cursor-pointer" :initials="auth()->user()->initials()" avatar:color="auto"
                avatar:color:seed="{{ auth()->user()->id }}" />

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


    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach($groupedEvents as $monthYear => $events)
            <!-- Month-Year Header -->
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                {{ \Carbon\Carbon::parse($monthYear . '-01')->format('F Y') }}
            </h2>

            <!-- Timeline -->
            <div>
                @foreach($events as $event)
                    <div class="flex gap-x-3">
                        <!-- Left Content (Year of the month) -->
                        <div class="min-w-14 text-end">
                            <span class="text-2xl text-gray-500 dark:text-neutral-400">
                                {{ \Carbon\Carbon::parse($monthYear . '-01')->format('Y') }}
                            </span>
                        </div>

                        <!-- Icon with vertical line -->
                        <div
                            class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                            <div class="relative z-10 size-7 flex justify-center items-center">
                                <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                            </div>
                        </div>

                        <!-- Right Content (Event Title only) -->
                        <div class="grow pt-0.5 pb-8">
                            <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                <svg class="shrink-0 size-4 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" x2="8" y1="13" y2="13"></line>
                                    <line x1="16" x2="8" y1="17" y2="17"></line>
                                    <line x1="10" x2="8" y1="9" y2="9"></line>
                                </svg>
                                {{ $event->title }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>





</div>