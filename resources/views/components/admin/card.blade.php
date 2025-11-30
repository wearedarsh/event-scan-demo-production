@props([
    'hover' => true,     // enables hover:shadow + lift
])

@php
    $base = 'soft-card rounded-lg bg-[var(--color-surface)] border border-[var(--color-border)] transition';
    $hover = filter_var($hover, FILTER_VALIDATE_BOOLEAN);
    $hoverClass = $hover 
        ? 'hover:shadow-md hover:-translate-y-0.5' 
        : '';
@endphp

<div {{ $attributes->merge(['class' => "$base $hoverClass"]) }}>
    {{ $slot }}
</div>
