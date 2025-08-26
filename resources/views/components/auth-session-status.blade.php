@props([
    'status',
])

@if ($status)
    {{-- <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div> --}}
    
    <flux:callout variant="success" icon="check-circle" heading="Your password has been reset" />
@endif
