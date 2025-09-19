<div>
    {{-- App Header --}}
    <div class=" relative mb-10 w-full">

        <flux:button variant="ghost" icon="arrow-uturn-left" :href="route('attendance_records')" wire:navigate>Return
        </flux:button>

    </div>

    {{-- Event content --}}
    <div class="grid grid-cols-5 gap-2 content-center">

        <!-- User Details -->
        <div class="col-span-2 px-10 py-6 flex justify-content">
            <div class="flex items-center gap-x-6">

                {{-- Event details content --}}
                <div class="space-y-3 whitespace-nowrap">
                    <flux:text class="mb-4" variant="strong">Academic Year <span
                            class="text-[var(--color-accent)]">{{ $selectedSchoolYear }}</span></flux:text>

                    <div class="flex items-center whitespace-nowrap gap-2">
                        <flux:heading size="xl">{{ $user->name }}</flux:heading>
                        @if ($user->late_count > 0 || $user->absent_count > 0)
                            <flux:badge variant="solid" size="sm" color="red">Sanctioned</flux:badge>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <div class="flex items-center gap-1">
                            <flux:icon.user variant="mini" class="text-white" />
                            <flux:heading class="text-bold">
                                <strong>Student ID -</strong>
                            </flux:heading>
                        </div>
                        <flux:text class="text-white underline">
                            {{ $user->student_id }}
                        </flux:text>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <flux:icon.envelope variant="mini" class="text-white" />
                            <flux:heading class="text-bold">
                                <strong>Email -</strong>
                            </flux:heading>
                        </div>
                        <flux:text class="text-white">
                            {{ $user->email }}
                        </flux:text>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <flux:icon.numbered-list variant="mini" class="text-white" />
                            <flux:heading class="text-bold">
                                <strong>Year -</strong>
                            </flux:heading>
                        </div>
                        <flux:text class="text-white">{{ $user->year_level }}</flux:text>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <flux:icon.academic-cap variant="mini" class="text-white" />
                            <flux:heading class="text-bold">
                                <strong>Course -</strong>
                            </flux:heading>
                        </div>
                        <flux:text class="text-white">{{ $user->course }}</flux:text>
                    </div>

                    <flux:button wire:click="generateStampCard" class="w-full mt-5" variant="primary" color="amber"
                        icon="arrow-down-on-square">Download as PDF</flux:button>

                </div>

                <flux:separator class="" vertical />

            </div>

        </div>

        <!-- Attendance Record -->


        <div
            class="col-span-3 px-10 py-6 content-center space-y-3
            h-100 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-zinc-900 dark:[&::-webkit-scrollbar-thumb]:bg-zinc-700">

            @forelse ($events as $event)
                {{-- Event Card --}}
                <div class="mr-3 relative z-50 w-auto h-auto">

                    {{-- Card Content --}}
                    <div class="relative min-h-45 md:min-h-17 lg:min-h-17 max-w-md sm:max-w-full overflow-hidden rounded-xl bg-zinc-950
                                        border border-transparent hover:border-[var(--color-accent)] group transition-colors duration-300
                                        {{-- cursor-pointer --}}
                                        ">
                        <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                            style="background-image: url('{{ asset('storage/' . $event->image) }}');">

                            <!-- Gradientt -->
                            <div class="absolute inset-0 h-full w-full"
                                style="background: linear-gradient(to right, rgba(0,0,0,0.5) 0%, rgba(0,0,0,1) 70%, rgba(0,0,0,1) 100%);">
                            </div>

                        </div>

                        {{-- Content --}}
                        <div class="relative w-full space-y-1 p-6 px-6 py-5 md:px-7 sm:flex items-center justify-between">

                            <div class="max-w-[300px]">
                                <flux:text class="font-semibold text-zinc-300">
                                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                </flux:text>
                                <h2
                                    class="text-xl truncate font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
                                    {{ $event->title }}
                                </h2>
                            </div>

                            <div class="relative mt-3 sm:mt-0 md:flex flex-col items-center justify-end h-full">

                                <div class="flex items-center gap-2">
                                    {{-- Badge Logic --}}
                                    <div class="">
                                        @php
                                            $log = $attendanceLogs->get($event->id);
                                        @endphp


                                        @if ($log)

                                            @php
                                                $status = $log->attendance_status?->label() ?? 'Unknown';
                                                $color = match ($log->attendance_status) {
                                                    \App\Enums\AttendanceStatus::Scanned => 'zinc',
                                                    \App\Enums\AttendanceStatus::Late => 'amber',
                                                    \App\Enums\AttendanceStatus::Present => 'green',
                                                    default => 'red',
                                                };

                                                $timezone = 'Asia/Manila';
                                                $now = now()->timezone($timezone);

                                                // Combine date and time into Carbon instances
                                                $start = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time, $timezone);
                                                $end = \Carbon\Carbon::parse($event->date . ' ' . $event->end_time, $timezone);
                                            @endphp

                                            @if ($event->status == \App\Enums\EventStatus::Finished)
                                                <flux:badge color="{{ $color }}" variant="solid">
                                                    {{ $status }}
                                                </flux:badge>
                                            @elseif($event->status == \App\Enums\EventStatus::NotFinished)
                                                @if ($now->between($start, $end))
                                                    <flux:badge color="amber" class="" variant="solid">
                                                        <span class="text-black">In Progress</span>
                                                    </flux:badge>
                                                @else
                                                    <flux:badge color="zinc" variant="solid">
                                                        Upcoming
                                                    </flux:badge>
                                                @endif
                                            @elseif($event->status == \App\Enums\EventStatus::Postponed)
                                                <flux:badge color="red" variant="solid">
                                                    <span class="text-white">Event Postponed</span>
                                                </flux:badge>
                                            @endif

                                        @else
                                            @if($event->status == \App\Enums\EventStatus::NotFinished)
                                                @if ($now->between($start, $end))
                                                    <flux:badge color="amber" class="" variant="solid">
                                                        <span class="text-black">In Progress</span>
                                                    </flux:badge>
                                                @else
                                                    <flux:badge color="zinc" variant="solid">
                                                        Upcoming
                                                    </flux:badge>
                                                @endif
                                            @elseif($event->status == \App\Enums\EventStatus::Postponed)
                                                <flux:badge color="red" variant="solid">
                                                    <span class="text-white">Event Postponed</span>
                                                </flux:badge>
                                            @else
                                                <flux:badge color="red" variant="solid">
                                                    Absent
                                                </flux:badge>
                                            @endif

                                        @endif

                                    </div>

                                    @if ($log)
                                        <flux:dropdown position="left" align="end">

                                            <flux:button variant="filled" size="sm" icon="ellipsis-horizontal"
                                                tooltip="Override Status"></flux:button>

                                            <flux:menu>

                                                <flux:modal.trigger :name="'mark-present-'.$user->id.'-'.$event->id">
                                                    <flux:menu.item>
                                                        Present
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger :name="'mark-late-'.$user->id.'-'.$event->id">
                                                    <flux:menu.item>
                                                        Late
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger :name="'mark-absent-'.$user->id.'-'.$event->id">
                                                    <flux:menu.item>
                                                        Absent
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                            </flux:menu>

                                        </flux:dropdown>
                                    @else
                                        <flux:tooltip content="No log">
                                            <div>
                                                <flux:button disabled variant="filled" size="sm" icon="x-mark"></flux:button>
                                            </div>
                                        </flux:tooltip>
                                    @endif

                                    {{-- Mark late modal --}}
                                    <flux:modal :name="'mark-late-'.$user->id.'-'.$event->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Late?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->name ?? 'Student' }} as Late.
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger"
                                                    wire:click="markLate({{ $user->id }}, {{ $event->id }})">
                                                    Mark Late</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Mark present modal --}}
                                    <flux:modal :name="'mark-present-'.$user->id.'-'.$event->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Present?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->name ?? 'Student' }} as
                                                        Present.</p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="primary" color="green"
                                                    wire:click="markPresent({{ $user->id }}, {{ $event->id }})">Mark Present
                                                </flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Mark absent modal --}}
                                    <flux:modal :name="'mark-absent-'.$user->id.'-'.$event->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Absent?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->name ?? 'Student' }} as Absent.
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger"
                                                    wire:click="markAbsent({{ $user->id }}, {{ $event->id }})">
                                                    Mark Absent</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                </div>
                            </div>


                        </div>

                    </div>



                </div>
            
            @empty

                {{-- Empty state for sanctioned students --}}
                <div class="p-5 h-full flex flex-col justify-center items-center text-center">
                    {{-- Card/ID icon illustration --}}
                    <svg class="w-48 mx-auto mb-1" width="178" height="120" viewBox="0 0 178 120" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        {{-- Background card --}}
                        <rect x="27" y="70.5" width="124" height="49" rx="7.5"
                            class="fill-white dark:fill-neutral-800 stroke-gray-50 dark:stroke-neutral-700/10"
                            stroke="currentColor" />

                        {{-- Middle card --}}
                        <rect x="19.5" y="48.5" width="139" height="49" rx="7.5"
                            class="fill-white dark:fill-neutral-800 stroke-gray-100 dark:stroke-neutral-700/30"
                            stroke="currentColor" />

                        {{-- Foreground card with shadow --}}
                        <g filter="url(#student-card-shadow)">
                            <rect x="12" y="26" width="154" height="50" rx="8"
                                class="fill-white dark:fill-neutral-800 stroke-gray-100 dark:stroke-neutral-700/60"
                                stroke="currentColor" shape-rendering="crispEdges" />

                            {{-- Card header strip --}}
                            <rect x="12" y="26" width="154" height="14" rx="8"
                                class="fill-gray-200 dark:fill-neutral-700" />

                            {{-- Placeholder profile circle --}}
                            <circle cx="38" cy="52" r="10" class="fill-gray-300 dark:fill-neutral-600" />

                            {{-- Placeholder text lines --}}
                            <rect x="58" y="44" width="70" height="6" rx="3" class="fill-gray-200 dark:fill-neutral-700" />
                            <rect x="58" y="56" width="50" height="6" rx="3" class="fill-gray-200 dark:fill-neutral-700" />
                        </g>

                        {{-- Shadow filter definition --}}
                        <defs>
                            <filter id="student-card-shadow" x="0" y="20" width="178" height="94"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="6" />
                                <feGaussianBlur stdDeviation="6" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                            </filter>
                        </defs>
                    </svg>

                    {{-- Content --}}
                    <div class="max-w-sm mx-auto">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            No Records
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                            Attendance records will show up here.
                        </p>
                    </div>
                </div>

            @endforelse



        </div>





    </div>

    {{-- Admin key modal --}}
    <flux:modal name="admin-key" class="min-w-[22rem] min-h-[10rem]" :dismissible="false">
        <div class="space-y-6">

            {{-- Current Admin Key --}}
            <div class="mt-5">
                <flux:heading class="mb-5 flex justify-center">Input Admin Key</flux:heading>
                <div class="flex gap-x-5 justify-center" id="pin-current" wire:ignore data-hs-pin-input='{
                    "availableCharsRE": "^[0-9]+$"

                    }'>
                    <input
                        class="block size-11 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        type="password" placeholder="○" data-hs-pin-input-item="" autofocus>
                    <input
                        class="block size-11 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        type="password" placeholder="○" data-hs-pin-input-item="">
                    <input
                        class="block size-11 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        type="password" placeholder="○" data-hs-pin-input-item="">
                    <input
                        class="block size-11 text-center border-gray-200 rounded-md sm:text-sm focus:scale-110 focus:border-[var(--color-accent)] focus:ring-[var(--color-accent)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        type="password" placeholder="○" data-hs-pin-input-item="">

                </div>

                @error('current_admin_key')
                    <p class="mt-4 text-sm  text-red-600 flex justify-center">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-center">
                <div wire:loading.class="opacity-100" wire:target="verifyAdminKey"
                    class="opacity-0 transition-opacity duration-300">
                    <flux:icon.loading class="text-zinc-50" />
                </div>
            </div>
        </div>
    </flux:modal>

    {{-- Confirmation Pin --}}
    <script>
        function initAdminPinInputs() {
            const bindings = [
                { id: 'pin-current', model: 'current_admin_key' },

            ];

            if (!window.HSPinInput || typeof window.HSPinInput.autoInit !== 'function') {
                console.error("❌ Preline HSPinInput is not available.");
                return;
            }

            window.HSPinInput.autoInit();

            bindings.forEach(({ id, model }) => {
                const instance = window.HSPinInput.getInstance(`#${id}`);
                if (!instance) {
                    console.warn(`⚠️ Could not find HSPinInput instance for #${id}`);
                    return;
                }

                instance.on('completed', ({ currentValue }) => {
                    const pinValue = Array.isArray(currentValue)
                        ? currentValue.join('')
                        : currentValue;

                    @this.set(model, pinValue).then(() => {
                        @this.call('verifyAdminKey');
                    });


                });
            });

            // Listen for Livewire-triggered reset
            window.addEventListener('admin-key-updated', () => {
                bindings.forEach(({ id }) => {
                    const container = document.getElementById(id);
                    if (!container) return;

                    const inputs = container.querySelectorAll('input[data-hs-pin-input-item]');
                    inputs.forEach(input => input.value = '');
                    if (inputs[0]) inputs[0].focus();
                });
            });

        }

        // Initial load
        document.addEventListener('DOMContentLoaded', initAdminPinInputs);

        // Re-init after Livewire navigation or DOM updates
        document.addEventListener('livewire:navigated', initAdminPinInputs);
        document.addEventListener('livewire:load', initAdminPinInputs);

    </script>



</div>