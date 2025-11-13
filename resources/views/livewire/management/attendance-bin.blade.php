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

            {{-- Card Content --}}
            <div class="relative grid min-h-50 md:min-h-64 max-w-md sm:max-w-full flex-col items-center justify-between overflow-hidden rounded-xl bg-zinc-950
                    border border-transparent 
                    ">
                <div class="absolute inset-0 m-0 h-full w-full overflow-hidden rounded-none bg-transparent bg-cover bg-center"
                    style="background-image: url('{{ asset('storage/' . $event->image) }}');" {{--
                    style="background-image: url('https://picsum.photos/seed/{{ rand(0, 100000) }}/1080/566');" --}}>

                    <div
                        class="absolute inset-0 h-full w-full bg-gradient-to-r from-black/80 via-black/60 to-transparent">
                    </div>
                </div>
                <div class="relative space-y-3 p-6 px-6 py-10 md:px-12">
                    <flux:text class="font-medium text-zinc-300">
                        {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                    </flux:text>
                    <h2
                        class="text-2xl font-medium text-white leading-7 group-hover:text-[var(--color-accent)] transition-colors duration-300">
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
                <flux:modal.trigger name="scan-qr">
                    <flux:button variant="primary" color="amber" icon:trailing="qr-code" class="mt-3">
                        Scan QR Code</flux:button>
                </flux:modal.trigger>
                <div class="flex items-center justify-between gap-2 mt-2">
                    <flux:button variant="filled" icon:trailing="arrow-uturn-left" :href="route('view_event', $event)" class="w-full">
                        Leave Attendance Bin</flux:button>
                    <flux:modal.trigger name="close-AB">
                        <flux:button variant="primary" color="green" icon:trailing="shield-check" class="w-full">Close
                            Attendance Bin</flux:button>
                    </flux:modal.trigger>
                </div>

                {{-- Scan QR modal --}}
                <flux:modal name="scan-qr" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            
                            {{-- Dynamic Label --}}
                            <div x-data="{ shown: false }" x-init="
                                    @this.on('scan-label', () => {
                                        shown = true;
                                        setTimeout(() => { shown = false }, 3000);
                                    })
                                " 
                                class="mt-3 mb-3">

                                 <!-- Button (default, shown when callout is hidden) -->
                                <template x-if="!shown">
                                    
                                    <div class="flex flex-col items-center justify-center gap-2 mt-5 w-full h-full">
                                        <flux:icon.user variant="solid" class="w-24 h-24 text-white"  />

                                        <div class="flex items-center gap-2">
                                            <flux:icon.qr-code class="text-white" variant="mini" />
                                            <flux:heading size="lg">Scan QR Code</flux:heading>
                                        </div>
                                    </div>

                                </template>

                                <!-- Callout (shown temporarily when event fires) -->
                                <template x-if="shown">
                                    
                                    <div class="flex flex-col items-center justify-center gap-1 mt-5 w-full h-full">
                                        {{-- <flux:icon.user variant="solid" class="w-16 h-16 text-white"  /> --}}
                                        <flux:profile circle class="" 
                                            avatar:name="{{ $name }}"
                                            avatar:color="auto"
                                            :chevron="false"
                                            {{-- color:seed="{{ auth()->user()->id }}" --}}
                                            />

                                        <div class="flex flex-col justify-center items-center">

                                            @php
                                                $course = $this->course;

                                                $output = match (true) {
                                                    $course == 'Bachelor of Arts in International Studies' => 'ABIS',
                                                    $course == 'Bachelor of Science in Information Systems' => 'BSIS',
                                                    $course == 'Bachelor of Human Services' => 'BHS',
                                                    $course == 'Bachelor of Secondary Education' => 'BSED',
                                                    $course == 'Bachelor of Elementary Education' => 'ECED',
                                                    $course == 'Bachelor of Special Needs Education' => 'SNED',
                                                    default => 'Course',
                                                };
                                            @endphp

                                            <flux:heading size="lg">{{ $name }}</flux:heading>
                                            <flux:heading size="lg">{{ $year_level }} - {{ $output }}</flux:heading>

                                        </div>
                                    </div>

                                </template>

                            </div>

                            {{-- Scan Callouts (Success) --}}
                            <div x-data="{ shown: false }" x-init="
                                    @this.on('scan-success', () => {
                                        shown = true;
                                        setTimeout(() => { shown = false }, 3000);
                                    })
                                " 
                                class="mt-5">

                                <!-- Callout (shown temporarily when event fires) -->
                                <template x-if="shown">
                                    <flux:callout variant="success" icon="check-circle" heading="Scan Successful" />
                                </template>

                            </div>

                            {{-- Scan Callouts (Inactive) --}}
                            <div x-data="{ shown: false }" x-init="
                                    @this.on('scan-notActive', () => {
                                        shown = true;
                                        setTimeout(() => { shown = false }, 3000);
                                    })
                                " 
                                class="mt-5">

                                <!-- Callout (shown temporarily when event fires) -->
                                <template x-if="shown">
                                    <flux:callout variant="warning" icon="exclamation-circle" heading="Account is not Active" />
                                </template>

                            </div>

                            {{-- Scan Callouts (Not Approved) --}}
                            <div x-data="{ shown: false }" x-init="
                                    @this.on('scan-notApproved', () => {
                                        shown = true;
                                        setTimeout(() => { shown = false }, 3000);
                                    })
                                " 
                                class="mt-5">

                                <!-- Callout (shown temporarily when event fires) -->
                                <template x-if="shown">
                                    <flux:callout variant="danger" icon="x-circle" heading="Account is not Approved" />
                                </template>

                            </div>

                            {{-- Scan Callouts (Unknown) --}}
                            <div x-data="{ shown: false }" x-init="
                                    @this.on('scan-notFound', () => {
                                        shown = true;
                                        setTimeout(() => { shown = false }, 3000);
                                    })
                                " 
                                class="mt-5">

                                <!-- Callout (shown temporarily when event fires) -->
                                <template x-if="shown">
                                    <flux:callout variant="secondary" icon="information-circle" heading="Account not Found" />
                                </template>

                            </div>
                            
                            {{-- Value receiver --}}
                            <div class="mt-5">
                                <flux:input type="text" wire:model.live="studentIdInput" {{--x-ref="qrInput"--}} autofocus mask="9999999">
                                </flux:input>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Close</flux:button>
                            </flux:modal.close>
                        </div>
                    </div>
                </flux:modal>

                {{-- Close AB modal --}}
                <flux:modal name="close-AB" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Close Attendance Bin?</flux:heading>
                            <flux:text class="mt-2">
                                <p class="text-neutral-300">You're about to close the attendance bin.</p>
                                <p class="text-neutral-300">Only the Moderator can re-open the bin.</p>
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
            <div class="mt-10 relative overflow-x-auto shadow-md sm:rounded-lg" wire:scroll>
                <table class="w-full text-sm text-left rtl:text-right text-zinc-600 dark:text-zinc-50 ">
                    <thead class="text-xs text-zinc-700 uppercase dark:bg-zinc-950 dark:text-zinc-50">
                        <tr>
                            <th scope="col" class="px-2 py-3 whitespace-nowrap">
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
                                <flux:dropdown position="bottom" align="end">

                                    <flux:button variant="ghost" size="xs" icon="wrench-screwdriver"
                                        tooltip="Bulk Override"></flux:button>

                                    <flux:menu>

                                        <flux:modal.trigger name="bulk-present">
                                            <flux:menu.item>
                                                Mark All Present
                                            </flux:menu.item>
                                        </flux:modal.trigger>

                                    </flux:menu>
                                    
                                </flux:dropdown>
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($users as $user)
                            <tr wire:key="attendance-log-{{ $user->id }}"
                                class="bg-white border-b dark:bg-zinc-950 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">

                                {{-- Name --}}
                                <th scope="row"
                                    class="px-2 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
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

                                    @if ($user->user)
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

                                                <flux:modal.trigger :name="'remove-timeout-'.$user->id">
                                                    <flux:menu.item variant="danger">
                                                        Remove Time-Out
                                                    </flux:menu.item>
                                                </flux:modal.trigger>

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
                                                    <p class="text-neutral-300">You're about to mark
                                                        {{ $user->user?->name ?? 'Student' }} as
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
                                    <flux:modal :name="'mark-late-'.$user->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Late?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-neutral-300">You're about to mark
                                                        {{ $user->user?->name ?? 'Student' }} as Late.
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger"
                                                    wire:click="markLate({{ $user->user_id }})">
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
                                                    <p class="text-neutral-300">You're about to mark
                                                        {{ $user->user?->name ?? 'Student' }} as
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
                                    <flux:modal :name="'mark-absent-'.$user->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Mark Student as Absent?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-neutral-300">You're about to mark
                                                        {{ $user->user?->name ?? 'Student' }} as Absent.
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger"
                                                    wire:click="markAbsent({{ $user->user_id }})">
                                                    Mark Absent</flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>

                                    {{-- Remove Time-out modal --}}
                                    <flux:modal :name="'remove-timeout-'.$user->id" class="min-w-[22rem]"
                                        :dismissible="false">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Remove Student Time-Out?</flux:heading>
                                                <flux:text class="mt-2">
                                                    <p class="text-neutral-300">You're about to remove
                                                        {{ $user->user?->name ?? 'Student' }}'s
                                                    </p>
                                                    <p class="text-neutral-300">time-out record
                                                    </p>
                                                </flux:text>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:spacer />
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancel</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger"
                                                    wire:click="removeTimeOut({{ $user->user_id }})">
                                                    Remove Time-Out</flux:button>
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
                                                    <p class="text-neutral-300">You're about to remove
                                                        {{ $user->user?->name ?? 'Student' }}'s
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

            <div class="mt-4 text-white">
                {{ $users->links('pagination::tailwind') }}
            </div>

        </div>
    </div>

    {{-- Bulk present modal --}}
    <flux:modal name="bulk-present" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark All as Present?</flux:heading>
                <flux:text class="mt-2">
                    <p class="text-neutral-300">You're about to mark ALL students as present.</p>
                    <p class="text-neutral-300">This will fill in all empty time-out fields.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="amber"
                    wire:click="markAllPresent">Mark All Present
                </flux:button>
            </div>
        </div>
    </flux:modal>

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
                <div="opacity-100" wire:target="verifyAdminKey" class="opacity-0 transition-opacity duration-300"
                    wire:loading.class>
                    <flux:icon.loading class="text-zinc-50" />
                </div>
            </div>
        </div>
    </flux:modal>

    {{-- Attendance bin functionality --}}

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