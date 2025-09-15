<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head_auth')
    @if (request()->routeIs('login'))
        <title>Shusseki Login</title>
    @elseif ((request()->routeIs('register')))
        <title>Shusseki Register</title>
    @elseif ((request()->routeIs('password.request')))
        <title>Forgot Password</title>
     @elseif ((request()->routeIs('password.reset')))
        <title>Password Reset</title>
    @else
        <title>Pending Approval</title>
    @endif
</head>


<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        <div class="flex w-full max-w-sm flex-col gap-2">
            <div class="flex flex-col items-center gap-2 font-medium">
                
                @auth
                    <span class="flex h-20 w-auto mb-1 items-center justify-center rounded-md">
                    {{-- <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" /> --}}
                        <img src="{{ asset('Images/Side_White.svg') }}" class="h-20 w-auto" alt="Shusseki Seal Approval">
                    </span>
                @else
                    <span class="flex h-15 w-15 mb-1 items-center justify-center rounded-md">
                    {{-- <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" /> --}}
                        <img src="{{ asset('images/Seal_White.svg') }}" alt="Shusseki Seal">
                    </span>
                @endauth
            </div>
            <div class="flex flex-col gap-6 mt-5">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
    {{-- <script src="https://unpkg.com/@livewire/flux@^2/dist/flux.min.js"></script> --}}
    @livewireScripts
</body>

</html>