<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">
 
    {{-- NAVBAR mobile only --}}
    <mary-nav sticky class="lg:hidden">
        <mary-slot:brand>
            <div class="ml-5 pt-5">App</div>
        </mary-slot:brand>
        <mary-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </mary-slot:actions>
    </mary-nav>
 
    {{-- MAIN --}}
    <mary-main full-width>
        {{-- SIDEBAR --}}
        <mary-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">
 
            {{-- BRAND --}}
            <div class="ml-5 pt-5">App</div>
 
            {{-- MENU --}}
            <mary-menu activate-by-route>
 
                {{-- User --}}
                @if($user = auth()->user())
                    <mary-menu-separator />
 
                    <mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mmary-2 !-my-2 rounded">
                        <mary-slot:actions>
                            <mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                        </mary-slot:actions>
                    </mary-list-item>
 
                    <mary-menu-separator />
                @endif
 
                <mary-menu-item title="Hello" icon="o-sparkles" link="/" />
                <mary-menu-sub title="Settings" icon="o-cog-6-tooth">
                    <mary-menu-item title="Wifi" icon="o-wifi" link="####" />
                    <mary-menu-item title="Archives" icon="o-archive-box" link="####" />
                </mary-menu-sub>
            </mary-menu>
        </mary-slot:sidebar>
 
        {{-- The `$slot` goes here --}}
        <mary-slot:content>
            {{ $slot }}
        </mary-slot:content>
    </mary--main>
 
    {{-- Toast --}}
    <mary-toast />
</body>


</html>