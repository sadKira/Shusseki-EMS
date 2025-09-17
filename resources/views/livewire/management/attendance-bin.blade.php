<div>
    <flux:header container>

        <div>
            <img src="{{ asset('images/MKDSide_White.svg') }}" alt="MKD Logo" class="h-12 w-auto sm:h-16 md:h-20">
        </div>

        <flux:spacer />

    </flux:header>


    <div class="grid grid-cols-5">

        {{-- Left side --}}
        <div class="col-span-2 px-10 py-6 space-y-5">

            {{-- Instascan --}}
            {{-- <div class="">
                Video feed
                <video id="preview" width="400" height="300"
                    style="width:600px; height:300px; object-fit:cover; background:#111; display:block; margin:0 auto;"
                    autoplay muted playsinline></video>
            </div> --}}

            {{-- Camera devices --}}
            {{-- <div wire:ignore class="mt-5">
                <flux:select id="camera-select" placeholder="Select Camera" label="Camera Devices"></flux:select>
            </div> --}}

            {{-- Card Content --}}
            <div 
                class="relative grid min-h-50 md:min-h-64 max-w-md sm:max-w-full flex-col items-center justify-between overflow-hidden rounded-xl bg-zinc-950
                    border border-transparent 
                    ">
                <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                    style="background-image: url('{{ asset('storage/' . $event->image) }}');"
                    {{-- style="background-image: url('https://picsum.photos/seed/{{ rand(0, 100000) }}/1080/566');" --}}
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

                        <flux:heading size="sm" class="flex items-center gap-2 mt-3">
                            End of Attendance: <span
                                class="text-[var(--color-accent)] underline">{{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>
                        </flux:heading>
                    </div>



                </div>

            </div>

            {{-- Close attendance bin --}}
            <div class="grid">
                <flux:button variant="filled" icon:trailing="arrow-uturn-left" :href="route('view_event', $event)">
                    Leave Attendance Bin</flux:button>
                <flux:modal.trigger name="close-AB">
                    <flux:button variant="primary" color="amber" icon:trailing="shield-check" class="mt-3">Close
                        Attendance Bin</flux:button>
                </flux:modal.trigger>

                {{-- Close AB modal --}}
                <flux:modal name="close-AB" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Close Attendance Bin?</flux:heading>
                            <flux:text class="mt-2">
                                <p class="text-white">You're about to close the attendance bin.</p>
                                <p class="text-white">Only the Moderator can re-open the bin.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button variant="danger" wire:click="markEventAsFinished">Close Bin</flux:button>
                        </div>
                    </div>
                </flux:modal>
                <div class="flex items-center justify-center gap-1 mt-3">
                    <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                    <flux:text class="text-xs">Closing the bin logs all absentees.</flux:text>
                </div>
            </div>

            {{-- Value receiver --}}
            <div class="pointer-events-none opacity-0">
                <flux:input 
                    type="text"
                    wire:model.live="studentIdInput" 
                    x-ref="qrInput"
                    autofocus
                    
                    >
                </flux:input>
            </div>

        </div>


        {{-- Attendance Display --}}
        <div class="col-span-3 px-7 py-6">

            {{-- Bin Stats --}}
            <div class="flex items-center justify-between gap-2">
                
                <flux:heading size="xl">Attendance Bin</flux:heading>

                <div class="flex items-center">

                    {{-- Attendess Count --}}
                    <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">
                        <flux:text>Total Attendees</flux:text>
                        <div class="flex items-center gap-2">

                            <flux:heading size="xl" level="1">

                                @if ($totalAttendees > 1)
                                    {{ $totalAttendees }} Students
                                @elseif ($totalAttendees == 0)
                                    {{ $totalAttendees }} Students
                                @else
                                    {{ $totalAttendees }} Student
                                @endif

                            </flux:heading>
                        
                        </div>

                    </div>

                    {{-- Present Students Count --}}
                    <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">
                        <flux:text>Present Students</flux:text>
                        <div class="flex items-center gap-2">
                            
                            <span class="w-3 h-3 bg-green-500 rounded-sm"></span>
                            <flux:heading size="xl" level="1">{{ $presentCount }}
                            </flux:heading>
                        
                        </div>

                    </div>

                    {{-- Late Students Count --}}
                    <div class="px-7 py-6 whitespace-nowrap grid justify-items-center">
                        <flux:text>Late Students</flux:text>
                        <div class="flex items-center gap-2">
                            
                            <span class="w-3 h-3 bg-[var(--color-accent)] rounded-sm"></span>
                            <flux:heading size="xl" level="1">{{ $lateCount }}
                            </flux:heading>
                        
                        </div>

                    </div>
                </div>

                
            </div>

            {{-- Table --}}
            <div class="mt-10 relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-50 ">
                    <thead class="text-xs text-zinc-700 uppercase dark:bg-zinc-950 dark:text-zinc-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Student Name
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Year Level
                            </th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                Time-in
                            </th>
                            <th scope="col" class="px-5 py-3 whitespace-nowrap">
                                Time-out
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-3 py-3">
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key="attendance-log-{{ $user->id }}"
                                class="bg-white border-b dark:bg-zinc-950 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">

                                {{-- Name --}}
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->user?->name ?? 'Deleted User' }}
                                </th>

                                {{-- Year Level --}}
                                <td class="px-6 py-4 text-zinc-600 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->user?->year_level ?? '-' }}
                                </td>

                                {{-- Time In --}}
                                <td class="px-6 py-4 text-zinc-600 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->time_in ? \Carbon\Carbon::parse($user->time_in)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                                </td>

                                {{-- Time Out --}}
                                <td class="px-6 py-4 text-zinc-600 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->time_out ? \Carbon\Carbon::parse($user->time_out)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                                </td>

                                {{-- Attendance Status --}}
                                <td class="px-6 py-4 text-zinc-600 whitespace-nowrap dark:text-zinc-100">
                                    @php
                                        $status = $user->attendance_status?->label() ?? 'Unknown';
                                        $color = match ($user->attendance_status) {
                                            \App\Enums\AttendanceStatus::Scanned => 'zinc',
                                            \App\Enums\AttendanceStatus::Late => 'amber',
                                            \App\Enums\AttendanceStatus::Present => 'green',
                                            default => 'red',
                                        };
                                    @endphp
                                    <flux:badge variant="solid" color="{{ $color }}">{{ $status }}</flux:badge>
                                </td>

                                {{-- Override --}}
                                <td class="px-3 py-4 text-zinc-600 whitespace-nowrap dark:text-zinc-100">

                                    @if ($user0>user) 
                                        <flux:dropdown position="left" align="end">

                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                                tooltip="Override Status"></flux:button>

                                            <flux:menu>

                                                <flux:modal.trigger :name="'mark-scanned-'.$user->id">
                                                    <flux:menu.item>
                                                        Scanned
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger :name="'mark-late-'.$user->id">
                                                    <flux:menu.item>
                                                        Late
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger :name="'mark-present-'.$user->id">
                                                    <flux:menu.item>
                                                        Present
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger :name="'mark-absent-'.$user->id">
                                                    <flux:menu.item>
                                                        Absent
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                                <flux:menu.separator />

                                                <flux:modal.trigger :name="'remove-record-'.$user->id">
                                                    <flux:menu.item variant="danger">
                                                        Remove Record
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

                                            </flux:menu>

                                        </flux:dropdown>
                                    @endif

                                    {{-- Mark scanned modal --}}
                                    <flux:modal :name="'mark-scanned-'.$user->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Scanned?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->user?->name ?? 'Student' }} as
                                                        Scanned.</p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="primary" color="amber"
                                                    wire:click="markScanned({{ $user->user_id }})">Mark Scanned
                                                </flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Mark late modal --}}
                                    <flux:modal :name="'mark-late-'.$user->id" class="min-w-[22rem]" :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Late?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->user?->name ?? 'Student' }} as Late.
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" wire:click="markLate({{ $user->user_id }})">
                                                    Mark Late</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Mark present modal --}}
                                    <flux:modal :name="'mark-present-'.$user->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Present?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->user?->name ?? 'Student' }} as
                                                        Present.</p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="primary" color="green"
                                                    wire:click="markPresent({{ $user->user_id }})">Mark Present
                                                </flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Mark absent modal --}}
                                    <flux:modal :name="'mark-absent-'.$user->id" class="min-w-[22rem]" :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Absent?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to mark {{ $user->user?->name ?? 'Student' }} as Absent.
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" wire:click="markAbsent({{ $user->user_id }})">
                                                    Mark Absent</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Remove record modal --}}
                                    <flux:modal :name="'remove-record-'.$user->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Remove Attendance Record?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-white">You're about to remove {{ $user->user?->name ?? 'Student' }}'s
                                                        attendance record.</p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" color="amber"
                                                    wire:click="removeLogRecord({{ $user->user_id }})">Remove Record
                                                </flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8">
                                    <div class="flex justify-center items-center gap-2 w-full">
                                        <flux:icon.queue-list variant="solid" class="text-zinc-50" />
                                        <flux:heading size="lg">No Attendance Logs</flux:heading>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

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
                <div ="opacity-100" wire:target="verifyAdminKey" class="opacity-0 transition-opacity duration-300"wire:loading.class>
                    <flux:icon.loading class="text-zinc-50" />
                </div>
            </div>
        </div>
    </flux:modal>

    {{-- Attendance bin functionality --}}

    <!-- Instascan CDN -->
    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}


    {{-- Attendance Logic --}}
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('message.processed', () => {
                document.querySelector('[x-ref="qrInput"]')?.focus();
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const qrInput = document.querySelector('[x-ref="qrInput"]');

            // Keep refocusing when the input loses focus
            qrInput.addEventListener('blur', () => {
                setTimeout(() => qrInput.focus(), 0);
            });

            // Also re-focus after each Livewire update
            document.addEventListener('livewire:init', () => {
                Livewire.hook('message.processed', () => {
                    qrInput.focus();
                });
            });
        });
    </script>


    {{-- Toast notication --}}
    <script>
        const successIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-green-500">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
            </svg>
        `;

        const inactiveIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-red-500">
            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
            </svg>
        `;

        const pendingIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-amber-500">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
        `;

        const notFoundIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-zinc-50">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
        `;

        const errorIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-red-500">
            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
        `;

        function tostifyCustomClose(el) {
            const parent = el.closest('.toastify');
            const close = parent.querySelector('.toast-close');

            close.click();
        }

        window.addEventListener('scanned-student', event => {
            let data = event.detail;
            if (Array.isArray(data)) {
                data = data[0];
            }

            let message = '';
            let icon = '';

            if (data.errorType) {
                switch (data.errorType) {
                    case 'inactive':
                        message = 'Student account is not Active';
                        icon = inactiveIcon;
                        break;
                    case 'pending':
                        message = 'Student account is not Approved';
                        icon = pendingIcon;
                        break;
                    case 'not_found':
                        message = 'Student account not Found';
                        icon = notFoundIcon;
                        break;
                    default:
                        message = 'Unknown error';
                        icon = errorIcon;
                }
            } else {
                message = 'Scan successful';
                icon = successIcon;
            }

            const toastMarkup = `
                <div class="flex items-center p-4">
                    <span class="mr-2">${icon}</span>
                    <p class="text-sm text-zinc-50">${message}</p>
                </div>
            `;

            Toastify({
                text: toastMarkup,
                duration: 10000,
                gravity: "bottom",
                position: "left",
                close: true,
                escapeMarkup: false,
                stopOnFocus: true,
                className: "hs-toastify-on:opacity-100 opacity-0 fixed -bottom-10 start-10 z-90 transition-all duration-300 w-72 bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg [&>.toast-close]:hidden dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400"
            }).showToast();
        });

    </script>
    {{-- -top-10 end-10 to display top right --}}

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

    {{-- Instascan (Camera scannner) --}}
    {{-- <script>
        function startQRScanner() {
            const videoElement = document.getElementById('preview');
            const select = document.getElementById('camera-select');
            if (!videoElement || window.currentScanner) return;

            window.currentScanner = new Instascan.Scanner({ video: videoElement, mirror: false });

            Instascan.Camera.getCameras().then(cameras => {
                if (cameras.length === 0) {
                    alert("No cameras found.");
                    return;
                }

                // Populate dropdown
                select.innerHTML = '';
                cameras.forEach((camera, idx) => {
                    const option = document.createElement('option');
                    option.textContent = camera.name || `Camera ${idx + 1}`;
                    option.value = camera.id;
                    select.appendChild(option);
                });

                // Select preferred or first
                let preferred = cameras.find(c => /back|rear|environment/i.test(c.name));
                let selectedCamera = preferred || cameras[0];

                // Start scanner safely
                if (!window.currentScanner._scanner || window.currentScanner._scanner.state !== 'started') {
                    window.currentScanner.start(selectedCamera);
                }

                // Allow camera switch
                select.onchange = () => {
                    const cam = cameras.find(c => c.id === select.value);
                    if (cam) {
                        window.currentScanner.stop().then(() => {
                            window.currentScanner.start(cam);
                        });
                    }
                };
            });

            // On successful scan
            window.currentScanner.addListener('scan', content => {
                document.getElementById('text').value = content;

                const root = document.querySelector('[wire\\:id]');
                const component = Livewire.find(root?.getAttribute('wire:id'));
                if (component && typeof component.scanStudent === 'function') {
                    component.scanStudent(content);
                }
            });

        }

        function stopQRScanner() {
            if (window.currentScanner) {
                window.currentScanner.stop();
                window.currentScanner = null;
            }

            const video = document.getElementById('preview');
            if (video && video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
        }

        // Load safely even if Instascan loads late
        function tryInitScanner() {
            if (typeof Instascan !== 'undefined') {
                startQRScanner();
            } else {
                const fallback = setInterval(() => {
                    if (typeof Instascan !== 'undefined') {
                        clearInterval(fallback);
                        startQRScanner();
                    }
                }, 100);
            }
        }

        // Init on first load
        document.addEventListener('DOMContentLoaded', tryInitScanner);

        // Reinit on Livewire SPA nav
        document.addEventListener('livewire:navigated', () => {
            stopQRScanner();
            tryInitScanner();
        });

        // Stop on full page leave
        window.addEventListener('beforeunload', stopQRScanner);

        // 
        // Livewire.hook('message.processed', () => {
        //     populateCameraDropdown(); // re-populate your camera select
        // });
    </script> --}}

</div>