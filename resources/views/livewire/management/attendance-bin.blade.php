<div>
    <flux:header container>

        <div>
            <img src="{{ asset('images/MKDSide_White.svg') }}" alt="MKD Logo" class="h-12 w-auto sm:h-16 md:h-20">
        </div>

        <flux:spacer />

        <flux:navbar class="-mb-px">
             <flux:navbar.item icon:trailing="arrow-uturn-left" :href="route('view_event', $event)" wire:navigate >Leave Attendance Bin</flux:navbar.item>
        </flux:navbar>

    </flux:header>


    <div class="grid grid-cols-5 gap-10">
        {{-- Video --}}
        <div class="col-span-2 px-10 py-6">

            {{-- Confirmation --}}
            <div 
                x-data="{ visible: false }"
                x-init="
                    window.addEventListener('scanned-student', event => {
                        const data = event.detail;
                        $refs.label.textContent = `${data.student_id} - ${data.name}`;
                        visible = false;
                        setTimeout(() => {
                            visible = true;
                            setTimeout(() => visible = false, 2000);
                        }, 10);
                    });
                "
            >
                <div 
                    x-ref="container"
                    :class="visible ? 'opacity-100' : 'opacity-0'"
                    class="transition-opacity duration-500 flex items-center gap-2 whitespace-nowrap mb-5"
                >
                    <flux:icon.check-circle class="text-green-500" variant="mini" />
                    <flux:heading size="lg" x-ref="label">Scanned</flux:heading>
                </div>
            </div>


            <div class="">
                {{-- Video feed --}}
                <video id="preview" width="400" height="300"
                    style="width:600px; height:300px; object-fit:cover; background:#111; display:block; margin:0 auto;"
                    autoplay muted playsinline></video>
            </div>

                {{-- Camera devices --}}
            <div wire:ignore class="mt-5">
                <flux:select id="camera-select" placeholder="Select Camera" label="Camera Devices"></flux:select>
            </div>
                
            {{-- Value receiver --}}
            <div class="opacity-0 pointer-events-none">
                <flux:input type="text" id="text" name="text" label="" readonly></flux:input>
            </div>
            
        </div>


        {{-- Attendance Display --}}
        <div class="col-span-3 px-10 py-6">

            {{-- Confirmation --}}
            <div class="flex items-center gap-2 whitespace-nowrap mb-5 opacity-0 pointer-events-none">
                <flux:icon.check-circle class="text-green-500" variant="mini" />
                <flux:heading size="lg">2202360 - Noblefranca, Latrell Andre</flux:heading>                    
            </div>

            {{-- Bin Details --}}
            <div class="flex items-start justify-between">
                {{-- Event Details --}}
                <div class="flex items-center gap-x-6">

                    <flux:separator class="" vertical />

                    {{-- Event details content --}}
                    <div class="space-y-3 text-balance">
                        <flux:text class="mb-4" variant="strong">Academic Year <span
                                class="text-[var(--color-accent)]">{{ $event->school_year }}</span></flux:text>
                        <flux:heading size="xl">{{ $event->title }}</flux:heading>

                        <div class="flex items-center gap-2 mt-4">
                            <flux:icon.calendar class="text-zinc-50" />
                            <flux:heading>
                                {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }},
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            </flux:heading>
                        </div>

                        <div class="flex items-center gap-2">
                            <flux:icon.map-pin class="text-zinc-50" />
                            <flux:heading>{{ $event->location }}</flux:heading>
                        </div>


                        <flux:heading class="flex items-center gap-2 mt-4">
                            End of Time In Period: <span class="text-[var(--color-accent)]">{{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}</span>

                            <flux:tooltip position="right" toggleable>
                                <flux:button icon="information-circle" variant="ghost" />
                                <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                    <p>Students are expected to scan their</p>
                                    <p>QR codes before the end of the time in period.</p>
                                </flux:tooltip.content>
                            </flux:tooltip>
                        </flux:heading>
                    </div>
                </div>

                <div class="grid justify-items-end">
                    <flux:button variant="primary" color="amber"  icon:trailing="shield-check">Close Attendance Bin</flux:button>
                    <div class="flex items-center gap-1 mt-3">
                        <flux:icon.information-circle class="text-zinc-400" variant="micro" />
                        <flux:text class="text-xs">Closing the Bin cannot be undone.</flux:text>
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
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- @forelse ($users as $user)
                            <tr wire:key="user-{{ $user->id }} "
                                class="bg-white border-b dark:bg-zinc-950 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->user->name ?? '-' }}
                                </th>
                                <td class="px-6 py-4 text-zinc-600  whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->user->year_level ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600  whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->time_in ? \Carbon\Carbon::parse($user->time_in)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600  whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->time_out ? \Carbon\Carbon::parse($user->time_out)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600  whitespace-nowrap dark:text-zinc-100">
                                    @if ( $user->attendance_status == \App\Enums\AttendanceStatus::Scanned )
                                        <flux:badge variant="solid" color="zinc">{{ $user->attendance_status->label() ?? '-' }}</flux:badge>
                                    @elseif ( $user->attendance_status == \App\Enums\AttendanceStatus::Late )
                                        <flux:badge variant="solid" color="amber">{{ $user->attendance_status->label() ?? '-' }}</flux:badge>
                                    @elseif ( $user->attendance_status == \App\Enums\AttendanceStatus::Present )
                                        <flux:badge variant="solid" color="green">{{ $user->attendance_status->label() ?? '-' }}</flux:badge>
                                    @else
                                        <flux:badge variant="solid" color="red">{{ $user->attendance_status->label() ?? '-' }}</flux:badge>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-lg text-zinc-400 font-semibold">
                                    No Attendance Logs
                                </td>
                            </tr>
                        @endforelse --}}
                        @forelse ($users as $user)
                            <tr wire:key="user-{{ $user->id }}"
                                class="bg-white border-b dark:bg-zinc-950 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">

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
                                        $color = match($user->attendance_status) {
                                            \App\Enums\AttendanceStatus::Scanned => 'zinc',
                                            \App\Enums\AttendanceStatus::Late => 'amber',
                                            \App\Enums\AttendanceStatus::Present => 'green',
                                            default => 'red',
                                        };
                                    @endphp
                                    <flux:badge variant="solid" color="{{ $color }}">{{ $status }}</flux:badge>
                                </td>

                                {{-- Override --}}
                                <td class="px-6 py-4 text-zinc-600 whitespace-nowrap dark:text-zinc-100">
                                    
                                    <flux:dropdown position="left" align="end">

                                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" tooltip="Override Status"></flux:button>

                                        <flux:menu>
                                            
                                            <flux:menu.item wire:click="markAsScanned({{ $user->user_id }})">
                                                    Scanned
                                            </flux:menu.item>

                                            <flux:menu.item wire:click="markAsLate({{ $user->user_id }})">
                                                    Late
                                            </flux:menu.item>

                                            <flux:menu.item wire:click="markAsPresent({{ $user->user_id }})">
                                                    Present
                                            </flux:menu.item>

                                            <flux:menu.item wire:click="markAsAbsent({{ $user->user_id }})">
                                                    Absent
                                            </flux:menu.item>

                                            <flux:menu.separator />

                                            <flux:menu.item wire:click="removeRecord({{ $user->user_id }})" variant="danger">
                                                    Scanned
                                            </flux:menu.item>
                                        </flux:menu>

                                    </flux:dropdown>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-lg text-zinc-400 font-semibold">
                                    No Attendance Logs
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Mark scanned modal --}}
    <flux:modal name="mark-scanned" class="min-w-[22rem]" :dismissible="false" wire:model.self="selectedUserId">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark Student as Scanned?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark {{ \App\Models\User::find($scannedUserId)?->name ?? 'Student' }} as Scanned.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="amber" wire:click="confirmMarkScanned">Mark Scanned</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Mark late modal --}}
    <flux:modal name="mark-late" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark Student as Late?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark {{ \App\Models\User::find($lateUserId)?->name ?? 'Student' }} as Late.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="amber">Mark Late</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Mark present modal --}}
    <flux:modal name="mark-present" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark Student as Present?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark {{ \App\Models\User::find($presentUserId)?->name ?? 'Student' }} as Present.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="amber">Mark Present</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Mark absent modal --}}
    <flux:modal name="mark-absent" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Mark Student as Absent?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to mark {{ \App\Models\User::find($absentUserId)?->name ?? 'Student' }} as Absent.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="amber">Mark Absent</flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Remove record modal --}}
    <flux:modal name="remove-record" class="min-w-[22rem]" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Remove Attendance Record?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to remove {{ \App\Models\User::find($removeUserId)?->name ?? 'Student' }}'s attendance record.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" color="amber">Remove Record</flux:button>
            </div>
        </div>
    </flux:modal>

   

    {{-- Attendance bin functionality --}}

    <!-- Instascan CDN -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
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
    </script>








</div>