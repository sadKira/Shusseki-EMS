@props(['selectedSchoolYear'])

{{-- Empty state for attendance trend chart --}}
<div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6">
    {{-- Chart-themed SVG illustration (bigger and more prominent) --}}
    <svg class="w-48 mx-auto mb-4" width="192" height="120" viewBox="0 0 192 120" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        {{-- Chart background grid --}}
        <g opacity="0.3">
            {{-- Horizontal grid lines --}}
            <line x1="30" y1="25" x2="162" y2="25" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="30" y1="40" x2="162" y2="40" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="30" y1="55" x2="162" y2="55" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="30" y1="70" x2="162" y2="70" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="30" y1="85" x2="162" y2="85" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            
            {{-- Vertical grid lines --}}
            <line x1="45" y1="20" x2="45" y2="90" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="70" y1="20" x2="70" y2="90" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="95" y1="20" x2="95" y2="90" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="120" y1="20" x2="120" y2="90" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
            <line x1="145" y1="20" x2="145" y2="90" stroke="currentColor" class="stroke-gray-300 dark:stroke-neutral-600" stroke-width="0.8"/>
        </g>
        
        {{-- Chart axes --}}
        <line x1="30" y1="20" x2="30" y2="90" stroke="currentColor" class="stroke-gray-400 dark:stroke-neutral-500" stroke-width="2"/>
        <line x1="30" y1="90" x2="162" y2="90" stroke="currentColor" class="stroke-gray-400 dark:stroke-neutral-500" stroke-width="2"/>
        
        {{-- Dotted trend lines (ghost/placeholder) --}}
        <g opacity="0.5">
            {{-- Present line (green) --}}
            <path d="M 45 70 Q 70 50, 95 60 Q 120 45, 145 40" 
                  stroke="#22c55e" 
                  stroke-width="3" 
                  fill="none" 
                  stroke-dasharray="6,6" 
                  stroke-linecap="round"/>
            
            {{-- Late line (amber) --}}
            <path d="M 45 75 Q 70 73, 95 78 Q 120 70, 145 65" 
                  stroke="#f59e0b" 
                  stroke-width="3" 
                  fill="none" 
                  stroke-dasharray="5,5" 
                  stroke-linecap="round"/>
            
            {{-- Absent line (red) --}}
            <path d="M 45 82 Q 70 80, 95 75 Q 120 78, 145 75" 
                  stroke="#ef4444" 
                  stroke-width="3" 
                  fill="none" 
                  stroke-dasharray="6,6" 
                  stroke-linecap="round"/>
        </g>
        
        {{-- Chart data points (ghost/placeholder) --}}
        <g opacity="0.4">
            {{-- Present points --}}
            <circle cx="45" cy="70" r="3.5" fill="#22c55e"/>
            <circle cx="95" cy="60" r="3.5" fill="#22c55e"/>
            <circle cx="145" cy="40" r="3.5" fill="#22c55e"/>
            
            {{-- Late points --}}
            <circle cx="45" cy="75" r="3.5" fill="#f59e0b"/>
            <circle cx="95" cy="78" r="3.5" fill="#f59e0b"/>
            <circle cx="145" cy="65" r="3.5" fill="#f59e0b"/>
            
            {{-- Absent points --}}
            <circle cx="45" cy="82" r="3.5" fill="#ef4444"/>
            <circle cx="95" cy="75" r="3.5" fill="#ef4444"/>
            <circle cx="145" cy="75" r="3.5" fill="#ef4444"/>
        </g>
        
        {{-- X-axis labels (bigger and more spaced) --}}
        <g class="text-xs" fill="currentColor" class="fill-gray-400 dark:fill-neutral-500">
            <text x="45" y="105" text-anchor="middle" font-size="11">Jul</text>
            <text x="70" y="105" text-anchor="middle" font-size="11">Aug</text>
            <text x="95" y="105" text-anchor="middle" font-size="11">Sep</text>
            <text x="120" y="105" text-anchor="middle" font-size="11">Oct</text>
            <text x="145" y="105" text-anchor="middle" font-size="11">Nov</text>
        </g>
        
        {{-- Y-axis labels (added for more realism) --}}
        <g class="text-xs" fill="currentColor" class="fill-gray-400 dark:fill-neutral-500">
            <text x="25" y="85" text-anchor="end" font-size="9">0</text>
            <text x="25" y="70" text-anchor="end" font-size="9">25</text>
            <text x="25" y="55" text-anchor="end" font-size="9">50</text>
            <text x="25" y="40" text-anchor="end" font-size="9">75</text>
            <text x="25" y="25" text-anchor="end" font-size="9">100</text>
        </g>
        
        {{-- Magnifying glass indicating "no data" (bigger) --}}
        <g opacity="0.7" transform="translate(155, 25)">
            <circle cx="0" cy="0" r="12" stroke="currentColor" class="stroke-gray-400 dark:stroke-neutral-500" stroke-width="2" fill="none"/>
            <line x1="8" y1="8" x2="16" y2="16" stroke="currentColor" class="stroke-gray-400 dark:stroke-neutral-500" stroke-width="2" stroke-linecap="round"/>
            {{-- No data indicator inside magnifying glass --}}
            <line x1="-4" y1="-4" x2="4" y2="4" stroke="currentColor" class="stroke-gray-400 dark:stroke-neutral-500" stroke-width="1.5" stroke-linecap="round"/>
            <line x1="4" y1="-4" x2="-4" y2="4" stroke="currentColor" class="stroke-gray-400 dark:stroke-neutral-500" stroke-width="1.5" stroke-linecap="round"/>
        </g>
    </svg>
    
    {{-- Content --}}
    <div class="max-w-sm mx-auto">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            No Attendance Data
        </h4>        
    </div>
</div>
