<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shusseki - MKD Event Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/assets/app-2KYTgWL1.css') }}">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body class="font-display bg-white">
    <!-- Navigation -->
    <nav class="bg-blue text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/MKDSide_White.svg') }}" alt="MKD Logo"
                        class="h-12 w-auto sm:h-16 md:h-20">
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button"
                        class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-gold hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <!-- Desktop menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gold transition-colors duration-200">Events</a>
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gold transition-colors duration-200">About
                            us</a>
                        <a href="#"
                            class="px-3 py-2 rounded-md text-sm font-medium bg-gold text-white hover:bg-gold/90 transition-colors duration-200">Login</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gold transition-colors duration-200">Events</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gold transition-colors duration-200">About
                    us</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium bg-gold text-white hover:bg-gold/90 transition-colors duration-200">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-blue text-white">
        <div
            class="container flex flex-col justify-center p-6 mx-auto sm:py-12 lg:py-24 lg:flex-row lg:justify-between">
            <div class="flex flex-col justify-center p-6 text-center rounded-sm lg:max-w-md xl:max-w-lg lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-none whitespace-nowrap">
                    <span class="block">Manage smarter,</span>
                    <span class="block text-gold mt-2">Join seamlessly</span>
                </h1>
                <p class="mt-6 mb-8 text-base sm:text-lg lg:text-xl sm:mb-12 text-gray-300 max-w-2xl">
                    Empowering organizers and students through modern, intuitive tools. With—SHUSSEKI
                </p>

                <div
                    class="flex flex-col space-y-4 sm:items-center sm:justify-center sm:flex-row sm:space-y-0 sm:space-x-4 lg:justify-start">
                    <a href="#"
                        class="px-8 py-3 text-lg font-semibold rounded bg-gold text-white hover:bg-gold/90 transition-colors duration-200">Get
                        Started</a>
                </div>
            </div>
            <div class="flex items-center justify-center p-6 mt-8 lg:mt-0 h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
                <img src="{{ asset('images/MKDWSeal_White.svg') }}" alt="MKD Logo"
                    class="object-contain h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
            </div>
        </div>
    </div>

    <!-- Mobile menu JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('#mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>