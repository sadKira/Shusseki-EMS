<!DOCTYPE html>


<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-950 font-display">

    {{-- Main content --}}
    {{ $slot }}

    {{-- Reinitialization --}}

    {{-- Luxon --}}
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.6.1/build/global/luxon.min.js"></script>

    {{-- Pikaday --}}
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

    <!-- Preline -->
    <script src="https://unpkg.com/preline@latest/dist/preline.js"></script>

    <!-- WebRTC -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/9.0.3/adapter.min.js"></script>

    <!-- Vue -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.5.17/vue.global.prod.min.js"></script>

    {{-- Date time converter --}}
    <script>
        // DateTime is globally accessible only once
        if (!window.DateTime) {
            window.DateTime = luxon.DateTime;
        }
    </script>

    {{-- Initiate Date picker --}}
    <script>
        window.initDatePicker = function() {
            const field = document.getElementById('datepicker');
            if (!field || field.dataset.pikaday === 'initialized') return;

            const { DateTime } = luxon;

            const picker = new Pikaday({
                field,
                onSelect: function (date) {
                    const luxonDate = DateTime.fromJSDate(date);
                    field.value = luxonDate.toFormat('LLLL dd, yyyy');
                    field.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });

            field.dataset.pikaday = 'initialized';
        }
    </script>

    {{-- Navigation Initialization --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
            console.log('Livewire navigated — reinitializing scripts');

            // Re-run Pikaday initialization
            initDatePicker();

            if (window.HSDropdown && typeof window.HSDropdown.autoInit === 'function') {
                window.HSDropdown.autoInit();
            }

            if (typeof window.attachTimePickerListeners === 'function') {
                window.attachTimePickerListeners();
            }

            if (typeof window.attachTimePickerListeners2 === 'function') {
                window.attachTimePickerListeners2();
            }

            if (typeof window.attachTimePickerTimeInListeners === 'function') {
                window.attachTimePickerTimeInListeners();
            }

            // File Upload
            if (window.HSFileUpload && typeof window.HSFileUpload.autoInit === 'function') {
                window.HSFileUpload.autoInit();
            }

        });
    </script>

    
    @fluxScripts
    @livewireScripts


</body>

</html>