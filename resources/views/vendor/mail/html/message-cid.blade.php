<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
@php
    $logoPath = public_path('images/Side_400_200.png');
    $logoExists = file_exists($logoPath);
@endphp
@if($logoExists)
<img src="cid:logo.png" class="logo" alt="{{ config('app.name', 'Shusseki New') }}" style="max-height: 100px; max-width: 200px; height: auto; width: auto; display: block; margin: 0 auto;">
@else
<div style="text-align: center; padding: 20px; font-size: 24px; font-weight: bold; color: #3d4852;">{{ config('app.name', 'Shusseki New') }}</div>
@endif
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
