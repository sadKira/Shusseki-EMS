<div class="">
    <div class="py-10 flex flex-col space-y-1 items-center justify-center metallic-updown-soft rounded-xl">

        <!-- Shusseki Image Placeholder -->
        <div class="w-full flex items-center justify-center rounded-lg overflow-hidden mb-2">
            <img src="{{ asset('images/Side_White.svg') }}" 
                alt="shusseki logo" 
                class="max-h-20 max-w-full object-contain">
        </div>

        {{-- PC --}}
        <div class="max-lg:hidden flex items-center gap-3">
            <!-- QR Image Placeholder -->
            <div class="w-40 h-40 flex items-center justify-center rounded-lg overflow-hidden">
                <img src="https://quickchart.io/qr?text={{ auth()->user()->student_id }}&margin=2&size=640&format=svg" alt="My QR Code" class="w-full h-full object-cover">
            </div>

            <div class="flex flex-col items-center justify-center mt-1">
                <flux:heading size="xl">{{ auth()->user()->name }}</flux:heading>
                {{-- <flux:heading size="xl">Student ID: {{ auth()->user()->student_id }}</flux:heading> --}}
                <flux:heading size="lg" class="text-zinc-50 font-light">Student ID: {{ auth()->user()->student_id }}</flux:heading>
                {{-- <flux:heading size="lg">{{ auth()->user()->email }}</flux:heading> --}}
            </div>
        </div>

        {{-- Mobile --}}
        <div class="lg:hidden">
            <!-- QR Image Placeholder -->
            <div class="w-53 h-53 flex items-center justify-center rounded-lg overflow-hidden">
                <img src="https://quickchart.io/qr?text={{ auth()->user()->student_id }}&margin=2&size=640&format=svg" alt="My QR Code" class="w-full h-full object-cover">
            </div>

            <div class="flex flex-col items-center justify-center mt-1">
                {{-- <flux:heading size="xl">{{ auth()->user()->name }}</flux:heading> --}}
                <flux:heading size="xl" class="mt-2">Student ID: {{ auth()->user()->student_id }}</flux:heading>
                {{-- <flux:heading size="lg" class="text-zinc-50 font-light">Student ID: {{ auth()->user()->student_id }}</flux:heading> --}}
                {{-- <flux:heading size="lg">{{ auth()->user()->email }}</flux:heading> --}}
            </div>
        </div>

        {{-- <flux:separator class="mt-3 mb-3" variant="subtle" /> --}}


        <div class="grid grid-cols-2">
            <div>

            </div>
        </div>

    </div>
    
</div>