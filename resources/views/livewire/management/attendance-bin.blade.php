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
                <flux:button id="toggle-scanner" variant="primary">Enable Scanner</flux:button>
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
   <script>
    if (!window.scannerApp) {
        window.scannerApp = {
            scanner: null,
            scannerInitialized: false,
            availableCameras: [],
            selectedCameraId: null,

            init() {
                document.addEventListener('DOMContentLoaded', () => this.waitForInstascan());
                document.addEventListener('livewire:navigated', () => {
                    this.stopScanner();
                    this.waitForInstascan();
                });

                if (window.Livewire && typeof window.Livewire.hook === 'function') {
                    Livewire.hook('message.processed', () => {
                        setTimeout(() => {
                            this.setupToggleButton();
                        }, 100);
                    });
                }

                window.addEventListener('beforeunload', () => this.stopScanner());
            },

            waitForInstascan() {
                if (typeof Instascan !== 'undefined') {
                    this.setupToggleButton();
                    this.populateCameraDropdown();
                } else {
                    setTimeout(() => this.waitForInstascan(), 100);
                }
            },

            populateCameraDropdown() {
                Instascan.Camera.getCameras().then((cameras) => {
                    this.availableCameras = cameras;
                    const select = document.getElementById('camera-select');
                    if (!select) return;
                    select.innerHTML = '';
                    if (cameras.length === 0) {
                        select.innerHTML = '<option value="">No cameras found</option>';
                        select.disabled = true;
                    } else {
                        cameras.forEach((camera, idx) => {
                            const option = document.createElement('option');
                            option.textContent = camera.name || `Camera ${idx + 1}`;
                            option.value = camera.id;
                            select.appendChild(option);
                        });
                        select.disabled = false;
                        if (!this.selectedCameraId) {
                            let preferred = cameras.find(cam => cam.name && /(back|rear|environment)/i.test(cam.name));
                            this.selectedCameraId = preferred ? preferred.id : cameras[0].id;
                        }
                        select.value = this.selectedCameraId;
                    }
                });
            },

            setupToggleButton() {
                const toggleBtn = document.getElementById('toggle-scanner');
                const select = document.getElementById('camera-select');
                if (!toggleBtn) return;

                toggleBtn.onclick = () => {
                    if (this.scanner) {
                        this.stopScanner();
                    } else {
                        this.initializeScanner();
                    }
                    this.updateToggleButton();
                };

                if (select) {
                    select.onchange = () => {
                        this.selectedCameraId = select.value;
                        if (this.scanner) {
                            this.stopScanner();
                            this.initializeScanner();
                        }
                    };
                }

                this.updateToggleButton();
            },

            updateToggleButton() {
                const toggleBtn = document.getElementById('toggle-scanner');
                if (toggleBtn) {
                    toggleBtn.textContent = this.scanner ? 'Disable Scanner' : 'Enable Scanner';
                }
            },

            initializeScanner() {
                const videoElement = document.getElementById('preview');
                const errorDiv = document.getElementById('camera-error');
                if (!videoElement || this.scannerInitialized) return;

                try {
                    if (this.scanner) {
                        this.scanner.stop();
                        this.scanner = null;
                    }

                    this.scanner = new Instascan.Scanner({ video: videoElement, mirror: false });

                    Instascan.Camera.getCameras().then((cameras) => {
                        this.availableCameras = cameras;
                        let selectedCamera = cameras.find(cam => cam.id === this.selectedCameraId) || cameras[0];
                        this.selectedCameraId = selectedCamera ? selectedCamera.id : null;

                        if (selectedCamera) {
                            this.scanner.start(selectedCamera);
                            this.scannerInitialized = true;
                            if (errorDiv) errorDiv.classList.add('hidden');
                        } else if (errorDiv) {
                            errorDiv.classList.remove('hidden');
                            errorDiv.innerHTML = '<p>No cameras found. Please connect a camera and try again.</p>';
                        }
                    });

                    this.scanner.addListener('scan', (content) => {
                        document.getElementById('text').value = content;
                        if (window.Livewire) {
                            if (window.$wire && typeof $wire.scanStudent === 'function') {
                                $wire.scanStudent(content);
                            } else {
                                const roots = document.querySelectorAll('[wire\\:id]');
                                if (roots.length > 0) {
                                    const id = roots[0].getAttribute('wire:id');
                                    const component = Livewire.find(id);
                                    if (component && typeof component.scanStudent === 'function') {
                                        component.scanStudent(content);
                                    }
                                }
                            }
                        }
                    });

                } catch (error) {
                    if (errorDiv) {
                        errorDiv.classList.remove('hidden');
                        errorDiv.innerHTML = '<p>Error initializing QR scanner: ' + error.message + '</p>';
                    }
                }

                this.updateToggleButton();
            },

            stopScanner() {
                if (this.scanner) {
                    this.scanner.stop();
                    this.scanner = null;
                }

                const videoElement = document.getElementById('preview');
                if (videoElement && videoElement.srcObject) {
                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                    videoElement.srcObject = null;
                }

                this.scannerInitialized = false;
                this.updateToggleButton();
            }
        };

        window.scannerApp.init();
    }
</script>









</div>