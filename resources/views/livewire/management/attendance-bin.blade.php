<div>
    <flux:header container >

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


    <div class="grid grid-cols-6 gap-10 border">
        {{-- Video --}}
        <div class="col-span-3 px-10 py-6 border">
            <video id="preview" width="100%" autoplay muted playsinline></video>
            <div id="camera-error" class="hidden text-red-600 mt-2">
                <p>Camera access denied or not available. Please check your camera permissions.</p>
            </div>
        </div>
        <div class="col-span-3 px-10 py-6 border">
            <flux:input type="text" id="text" name="text" label="Scan QR Code" readonly ></flux:input>
        </div>
    </div>

    <script>
        // Wait for Instascan library to be loaded, then initialize
        function waitForInstascan() {
            if (typeof Instascan !== 'undefined') {
                initializeScanner();
            } else {
                setTimeout(waitForInstascan, 100);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            waitForInstascan();
        });

        function initializeScanner() {
            const videoElement = document.getElementById('preview');
            const errorDiv = document.getElementById('camera-error');
            if (!videoElement) return;

            try {
                // Create new scanner instance
                let scanner = new Instascan.Scanner({ 
                    video: videoElement,
                    mirror: false
                });

                // Get available cameras
                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        // Prefer back camera if available
                        let selectedCamera = cameras[0];
                        for (let camera of cameras) {
                            if (camera.name.toLowerCase().includes('back') || 
                                camera.name.toLowerCase().includes('rear') ||
                                camera.name.toLowerCase().includes('environment')) {
                                selectedCamera = camera;
                                break;
                            }
                        }
                        scanner.start(selectedCamera);
                        if (errorDiv) errorDiv.classList.add('hidden');
                    } else {
                        if (errorDiv) {
                            errorDiv.classList.remove('hidden');
                            errorDiv.innerHTML = '<p>No cameras found. Please connect a camera and try again.</p>';
                        }
                    }
                }).catch(function(e) {
                    if (errorDiv) {
                        errorDiv.classList.remove('hidden');
                        errorDiv.innerHTML = '<p>Error accessing camera: ' + e.message + '</p>';
                    }
                });

                // Handle QR code scans
                scanner.addListener('scan', function(content) {
                    const textInput = document.getElementById('text');
                    if (textInput) {
                        textInput.value = content;
                        textInput.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });

                // Store scanner reference for cleanup
                window.currentScanner = scanner;
            } catch (error) {
                if (errorDiv) {
                    errorDiv.classList.remove('hidden');
                    errorDiv.innerHTML = '<p>Error initializing QR scanner: ' + error.message + '</p>';
                }
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (window.currentScanner) {
                window.currentScanner.stop();
                window.currentScanner = null;
            }
        });
    </script>
</div>
