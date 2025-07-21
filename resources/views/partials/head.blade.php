<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/Seal_White.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- Hanken Grotesk --}}
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

{{-- Arimo --}}
<link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">



{{-- <link rel="stylesheet" href="{{ asset('build/assets/app-2KYTgWL1.css') }}"> --}}

{{-- <script src="https://unpkg.com/preline@latest/dist/preline.js"></script> --}}

{{-- @fluxAppearance --}}
@livewireStyles
@vite(['resources/css/app.css', 'resources/js/app.js'])
