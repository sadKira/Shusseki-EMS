<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shusseki</title>

    {{-- Later --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/Seal_White.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    {{--
    <link rel="stylesheet" href="{{ asset('build/assets/app-2KYTgWL1.css') }}"> --}}

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    {{-- @fluxAppearance() --}}
</head>

<body class="min-h-screen bg-zinc-50 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 font-display">
    {{-- border-b border-zinc-200 dark:border-zinc-700 --}}
    {{-- class="bg-zinc-50 dark:bg-zinc-800" --}}
    <flux:header container >

        <div>
            <img src="{{ asset('images/MKDSide_White.svg') }}" alt="MKD Logo" class="h-12 w-auto sm:h-16 md:h-20">
        </div>

        <flux:spacer />

        <flux:sidebar.toggle class="lg:hidden " icon="bars-2" inset="left" />

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:separator vertical variant="subtle" class="my-2" />

            @php
                $user = auth()->user();
                $dashboardRoute = route('login'); // default for guests
                if ($user) {
                    $dashboardRoute = match($user->role) {
                        \App\Enums\UserRole::Super_Admin, \App\Enums\UserRole::Admin => route('admin_dashboard'),
                        \App\Enums\UserRole::Tsuushin => route('tsuushin_dashboard'),
                        default => route('dashboard'),
                    };
                }
            @endphp

            @auth
                <flux:navlist.item href="{{ $dashboardRoute }}" current>Return to Dashboard</flux:navlist.item>
            @else
                <flux:navbar.item href="#">Events</flux:navbar.item>
                <flux:navbar.item href="#">About us</flux:navbar.item>
                <flux:navbar.item href="{{ $dashboardRoute }}" current>Login</flux:navbar.item>
            @endauth

            <flux:separator vertical class="my-2" />
        </flux:navbar>

    </flux:header>

    <flux:sidebar stashable sticky
        class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <div>
            <img src="{{ asset('images/MKDSide.svg') }}" alt="MKD Logo" class="h-12 w-auto sm:h-16 md:h-20">
        </div>

        <flux:navlist>
            @auth
                <flux:navlist.item href="#">Login</flux:navlist.item>
            @else
                <flux:navlist.item href="#" current>Events</flux:navlist.item>
                <flux:navlist.item href="#">About us</flux:navlist.item>
                <flux:navlist.item href="#">Login</flux:navlist.item>
            @endauth
            
            {{-- <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item> --}}
        </flux:navlist>

        <flux:spacer />

    </flux:sidebar>

    <flux:main container>
        <div class="flex flex-col justify-center p-6 mx-auto lg:flex-row lg:justify-between">
            <div class="flex flex-col justify-center p-6 text-center rounded-sm lg:max-w-md xl:max-w-lg lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-none whitespace-nowrap">
                    <span class="block text-zinc-50">Manage smarter,</span>
                    <span class="block text-zinc-50 mt-2">Join seamlessly</span>
                </h1>
                <p class="mt-6 mb-8 text-base sm:text-lg lg:text-xl sm:mb-12 text-zinc-50 max-w-2xl">
                    Empowering organizers and students through modern, intuitive tools. With—SHUSSEKI
                </p>
                <div class="flex flex-col  sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-3 text-lg font-semibold rounded bg-gold text-white hover:bg-gold/90 transition-colors duration-200">
                        Get Started</a>
                </div>
            </div>
            <div class="flex items-center justify-center p-6 mt-8 lg:mt-0 h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
                <img src="{{ asset('images/MKDWSeal_White.svg') }}" alt="MKD Logo"
                    class="object-contain h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
            </div>
        </div>

    </flux:main>

    @fluxScripts

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>