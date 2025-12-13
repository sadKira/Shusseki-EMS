<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shusseki EMS</title>

    {{-- Later --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/Seal_White.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    {{-- @fluxAppearance() --}}
    
</head>

<body class="min-h-screen bg-zinc-50 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 font-display">
    
    <flux:header container class="" >

        <div>
            <img src="{{ asset('images/MKDSide_White.svg') }}" alt="MKD Logo" class="h-16 mt-1 w-auto md:h-20 md:mt-0">
        </div>

        <flux:spacer />


        <flux:navbar class="-mb-px">

            <flux:button variant="ghost" size="sm" href="https://www.facebook.com/mindanaointernationalcollege/" icon:trailing="arrow-up-right" target="_blank">Learn about MKD</flux:button>
            
        </flux:navbar>
        

    </flux:header>

    
    <flux:main container>

        <div class="video-bg-wrapper">
            <video autoplay loop muted playsinline class="background-clip">
                <source src="{{ asset('videos/mkdintro_4k_latest.mp4') }}" type="video/mp4">
            </video>
            <svg class="video-svg-mask" width="100vw" height="100vh" style="position:absolute;top:0;left:0;pointer-events:none;z-index:1;">
                <defs>
                    <linearGradient id="fadeMask" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#18181b" stop-opacity="1"/>
                        <stop offset="60%" stop-color="#18181b" stop-opacity="0.7"/>
                        <stop offset="100%" stop-color="#18181b" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <rect x="0" y="0" width="100vw" height="100vh" fill="url(#fadeMask)" />
            </svg>
        </div>
        
        <div class="flex flex-col justify-center p-6 mx-auto lg:flex-row lg:justify-between">
            <div class="flex flex-col justify-center p-6 text-center rounded-sm lg:max-w-md xl:max-w-lg lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-none whitespace-nowrap">
                    <span class="block text-zinc-50">Manage smarter,</span>
                    <span class="block text-zinc-50 mt-2">join seamlessly</span>
                </h1>
                <p class="mt-6 mb-8 text-base sm:text-lg lg:text-xl sm:mb-12 text-zinc-50 max-w-2xl">
                    Shusseki Events Management System — Simplifying event organization and engagement with modern, intuitive tools.
                </p>
                <div class="flex flex-col  sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start gap-3 lg:gap-0">

                    @php
                        $user = auth()->user();
                        $dashboardRoute = route('login'); // default for guests
                        if ($user) {
                            $dashboardRoute = match($user->role) {
                                \App\Enums\UserRole::Super_Admin, \App\Enums\UserRole::Admin => route('admin_dashboard'),
                                \App\Enums\UserRole::Tsuushin => route('dashboard'),
                                default => route('dashboard'),
                            };
                        }

                    @endphp

                    @auth
                        
                        <a href="{{ $dashboardRoute }}" class="inline-flex items-center justify-center px-7 py-3 text-sm font-bold hover:font-medium tracking-wide text-amber-500 hover:text-black transition-colors duration-200 border border-amber-500 bg-black-10 rounded-md hover:bg-amber-500 focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 focus:shadow-outline focus:outline-none">
                            Return to Home
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="min-w-40 inline-flex items-center justify-center px-7 py-3 text-sm font-medium tracking-wide text-black border border-amber-500 hover:border-amber-600 transition-colors duration-200 bg-amber-500 rounded-md hover:bg-amber-600 focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 focus:shadow-outline focus:outline-none">
                            Get Started
                        </a>
                        <a href="{{ $dashboardRoute }}" class="min-w-40 inline-flex items-center justify-center px-7 py-3 text-sm font-bold hover:font-medium tracking-wide text-amber-500 hover:text-black transition-colors duration-200 border border-amber-500 bg-black-10 rounded-md hover:bg-amber-500 focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 focus:shadow-outline focus:outline-none">
                            Login
                        </a>
                    @endauth
                   
                </div>
                
            </div>
            
        </div>

        <div class="w-full flex items-center justify-center lg:justify-end">
            <flux:button variant="subtle" >© Video From MKD Facebook Page</flux:button>
        </div>

    </flux:main>

    @fluxScripts

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>