@props([
    'type' => 'button',
    'href' => null,
    'variant' => 'primary', // primary | secondary | outline | danger
])

@php
    $base =
        'inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-md
         transition-colors duration-150';

    $variants = [
        'primary' => 'bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-hover)]',
        'secondary' => 'bg-[var(--color-surface)] border border-[var(--color-border)]
                        text-[var(--color-text)] hover:bg-[var(--color-surface-hover)]',
        'outline' => 'bg-[var(--color-primary)]/5 text-[var(--color-primary)] border border-[var(--color-primary)]/40 hover:bg-[var(--color-primary)]/20',
        'danger' => 'bg-[var(--color-danger)] text-white hover:bg-red-700',
    ];

    $classes = $base.' '.$variants[$variant];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif