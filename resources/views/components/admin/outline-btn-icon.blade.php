@props([
    'href' => '#',
    'icon' => null, // e.g. "heroicon-o-plus"
    'soft' => false,
])

@php
$classes = 'inline-flex items-center rounded-md px-2.5 py-1.5 text-xs font-medium transition-colors duration-150';

$classes .= $soft
    ? ' bg-[var(--color-primary)]/5 text-[var(--color-primary)] border border-[var(--color-primary)]/40 hover:bg-[var(--color-primary)]/20'
    : ' bg-[var(--color-surface)] text-[var(--color-primary)] border border-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white';
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge([
        'class' => $classes
   ]) }}
>
    @if ($icon)
        <x-dynamic-component 
            :component="$icon" 
            class="h-4 w-4 md:mr-1.5"
        />
    @endif

    <span>{{ $slot }}</span>
</a>

