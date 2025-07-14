<div>
    <flux:header container>

        <div>
            <img src="{{ asset('images/MKDSide_White.svg') }}" alt="MKD Logo" class="h-12 w-auto sm:h-16 md:h-20">
        </div>

        <flux:spacer />

        <flux:sidebar.toggle class="lg:hidden " icon="bars-2" inset="left" />

        <flux:navbar class="-mb-px">
            <flux:separator vertical variant="subtle" class="my-2" />


            <flux:separator vertical class="my-2" />
        </flux:navbar>

    </flux:header>


    <div class="grid grid-cols-5 gap-10">
        {{-- Video --}}
        <div class="col-span-2 px-10 py-6 border">

            <video id="preview" width="400" height="300"
                style="width:400px; height:300px; object-fit:cover; background:#111; display:block; margin:0 auto;"
                autoplay muted playsinline></video>
            <div id="camera-error" class="hidden text-red-600 mt-2">
                <p>Camera access denied or not available. Please check your camera permissions.</p>
            </div>
            <div class="flex items-center mt-4 gap-3">
                <flux:select id="camera-select" placeholder="Select Camera"></flux:select>
                {{-- <flux:button id="toggle-scanner" variant="primary">Enable Scanner</flux:button> --}}
            </div>
            <flux:input type="text" id="text" name="text" label="" readonly></flux:input>
        </div>


        {{-- Attendance Display --}}
        <div class="col-span-3 px-10 py-6 border">

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
                        Time In: {{ \Carbon\Carbon::parse($event->time_in)->format('h:i A') }}

                        <flux:tooltip position="bottom" toggleable>
                            <flux:button icon="information-circle" variant="ghost" />
                            <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                <p>Failure to scan their QRs during</p>
                                <p>time-in will be marked as "Late".</p>
                            </flux:tooltip.content>
                        </flux:tooltip>
                    </flux:heading>
                </div>
            </div>

            {{-- Table --}}
            <div class="mt-5 relative overflow-x-auto shadow-md sm:rounded-lg">
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
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key="user-{{ $user->id }} "
                                class="bg-white border-b dark:bg-zinc-950 dark:border-zinc-700 border-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-zinc-100">
                                    {{ $user->user->name ?? '-' }}
                                </th>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ $user->user->year_level ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ $user->time_in ? \Carbon\Carbon::parse($user->time_in)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ $user->time_out ? \Carbon\Carbon::parse($user->time_out)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                    {{ $user->attendance_status->label() ?? '-' }}
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

    {{-- Attendance bin functionality --}}

    <!-- Instascan CDN -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script>
        function startQRScanner() {
            const videoElement = document.getElementById('preview');
            const select = document.getElementById('camera-select');
            if (!videoElement) return;

            // Prevent double init
            if (window.currentScanner) return;

            window.currentScanner = new Instascan.Scanner({ video: videoElement, mirror: false });

            Instascan.Camera.getCameras().then(cameras => {
                if (cameras.length === 0) {
                    alert("No cameras found.");
                    return;
                }

                // Fill dropdown
                select.innerHTML = '';
                cameras.forEach((camera, idx) => {
                    const option = document.createElement('option');
                    option.textContent = camera.name || `Camera ${idx + 1}`;
                    option.value = camera.id;
                    select.appendChild(option);
                });

                // Choose back cam if available
                let preferred = cameras.find(c => /back|rear|environment/i.test(c.name));
                let selectedCamera = preferred || cameras[0];

                // Start camera
                window.currentScanner.start(selectedCamera);

                // Dropdown switch
                select.onchange = () => {
                    const cam = cameras.find(c => c.id === select.value);
                    if (cam) {
                        window.currentScanner.stop().then(() => {
                            window.currentScanner.start(cam);
                        });
                    }
                };
            });

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

        // Init on first load
        document.addEventListener('DOMContentLoaded', startQRScanner);

        // Re-init on Livewire SPA nav
        document.addEventListener('livewire:navigated', () => {
            stopQRScanner();       // Clean up if navigating *to* a new page
            startQRScanner();      // Reinit on this new page
        });

        // Stop on hard page leave
        window.addEventListener('beforeunload', stopQRScanner);
    </script>









</div>