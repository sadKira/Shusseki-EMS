<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 lg:py-10">

    <flux:heading size="xl" class="max-lg:hidden font-bold whitespace-nowrap">My QR Code</flux:heading>

    {{-- Mobile view --}}
    <div class="flex items-center justify-between lg:hidden whitespace-nowrap">
        <flux:heading size="xl" class="font-bold">My QR Code</flux:heading>

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

    <!-- QR Code Section -->
    <div class="flex flex-col items-center justify-center text-center p-6">
        
        <div class="space-y-5">

            <!-- Shusseki Image Placeholder -->
            <div class="w-full flex items-center justify-center rounded-lg overflow-hidden">
                <img src="{{ asset('images/Side_White.svg') }}" 
                    alt="shusseki logo" 
                    class="max-h-20 max-w-full object-contain">
            </div>

            <!-- QR Image Placeholder -->
            <div class="w-53 h-53 flex items-center justify-center rounded-lg overflow-hidden">
                <img src="https://quickchart.io/qr?text={{ auth()->user()->student_id }}&margin=2&size=640&format=svg" alt="My QR Code" class="w-full h-full object-cover">
            </div>
        </div>


        <!-- User details -->
        <div class="mt-4">
            <h3 class="text-2xl font-semibold text-zinc-50">
                {{ auth()->user()->name }}
            </h3>
            <p class="text-lg text-zinc-50">
                Student ID: {{ auth()->user()->student_id }}
            </p>
        </div>


    </div>
</div>