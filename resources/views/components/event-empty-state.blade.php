@props(['schoolYear'])

{{-- Empty state for events --}}
<div class="p-5 h-full mt-4 flex flex-col justify-center items-center text-center">
    {{-- Calendar/Event icon illustration --}}
    <svg class="w-48 mx-auto mb-4" width="178" height="120" viewBox="0 0 178 120" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        {{-- Background calendars --}}
        <rect x="27" y="70.5" width="124" height="49" rx="7.5" fill="currentColor"
            class="fill-white dark:fill-neutral-800" />
        <rect x="27" y="70.5" width="124" height="49" rx="7.5" stroke="currentColor"
            class="stroke-gray-50 dark:stroke-neutral-700/10" />
        {{-- Calendar header --}}
        <rect x="27" y="70.5" width="124" height="12" rx="7.5" fill="currentColor"
            class="fill-gray-100 dark:fill-neutral-700/30" />
        {{-- Calendar grid dots --}}
        <circle cx="45" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
        <circle cx="60" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
        <circle cx="75" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
        <circle cx="90" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
        <circle cx="105" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
        <circle cx="120" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />
        <circle cx="135" cy="95" r="2" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30" />

        {{-- Second calendar --}}
        <rect x="19.5" y="48.5" width="139" height="49" rx="7.5" fill="currentColor"
            class="fill-white dark:fill-neutral-800" />
        <rect x="19.5" y="48.5" width="139" height="49" rx="7.5" stroke="currentColor"
            class="stroke-gray-100 dark:stroke-neutral-700/30" />
        {{-- Calendar header --}}
        <rect x="19.5" y="48.5" width="139" height="12" rx="7.5" fill="currentColor"
            class="fill-gray-100 dark:fill-neutral-700/70" />
        {{-- Calendar grid dots --}}
        <circle cx="37" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="52" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="67" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="82" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="97" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="112" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="127" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />
        <circle cx="142" cy="73" r="2" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70" />

        {{-- Main calendar with shadow --}}
        <g filter="url(#event-empty-state-shadow)">
            <rect x="12" y="26" width="154" height="50" rx="8" fill="currentColor"
                class="fill-white dark:fill-neutral-800" shape-rendering="crispEdges" />
            <rect x="12.5" y="26.5" width="153" height="49" rx="7.5" stroke="currentColor"
                class="stroke-gray-100 dark:stroke-neutral-700/60" shape-rendering="crispEdges" />
            {{-- Calendar header --}}
            <rect x="12" y="26" width="154" height="14" rx="8" fill="currentColor"
                class="fill-gray-200 dark:fill-neutral-700" />
            {{-- Calendar binding holes --}}
            <circle cx="35" cy="19" r="3" fill="currentColor" class="fill-gray-300 dark:fill-neutral-600" />
            <circle cx="89" cy="19" r="3" fill="currentColor" class="fill-gray-300 dark:fill-neutral-600" />
            <circle cx="143" cy="19" r="3" fill="currentColor" class="fill-gray-300 dark:fill-neutral-600" />
            {{-- Calendar grid --}}
            <circle cx="30" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="45" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="60" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="75" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="90" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="105" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="120" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="135" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="150" cy="51" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            
            <circle cx="30" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="45" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="60" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="75" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="90" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="105" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="120" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="135" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
            <circle cx="150" cy="63" r="2" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700" />
        </g>
        
        {{-- Shadow filter definition --}}
        <defs>
            <filter id="event-empty-state-shadow" x="0" y="20" width="178" height="94" filterUnits="userSpaceOnUse"
                color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                    result="hardAlpha" />
                <feOffset dy="6" />
                <feGaussianBlur stdDeviation="6" />
                <feComposite in2="hardAlpha" operator="out" />
                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0" />
                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810" />
                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810" result="shape" />
            </filter>
        </defs>
    </svg>
    
    {{-- Content --}}
    <div class="max-w-sm mx-auto">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            No Events
        </h3>
        <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
            There are no events scheduled<br>
            for the <span class="font-medium text-gray-900 dark:text-white">{{ $schoolYear }}</span> academic year.
        </p>

        <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
            Create your first event.
        </p>

        <flux:button variant="filled" href="{{route('create_event')}}" icon="plus" wire:navigate>Create Event
        </flux:button>
    
    </div>
</div>
