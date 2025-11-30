@props([
    'icon',    // heroicon string
    'href' => null,
    'size' => '5',   // tailwind h-5 w-5 etc.
])

@php
$baseClass = "text-[var(--color-text-light)] hover:text-[var(--color-primary)] transition";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClass]) }}>
        <x-dynamic-component :component="$icon" class="h-{{ $size }} w-{{ $size }}" />
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $baseClass]) }}>
        <x-dynamic-component :component="$icon" class="h-{{ $size }} w-{{ $size }}" />
    </button>
@endif
