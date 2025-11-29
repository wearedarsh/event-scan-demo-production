@props([
    'href' => null,
    'icon',
    'right' => false, // icon on the right instead of left
    'target' => null,
])

@php
    $tag = $href ? 'a' : 'button';

    $commonClasses = 
        'text-[var(--color-primary)] hover:underline text-xs font-medium 
         inline-flex items-center gap-1 transition-colors duration-150';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if($target) target="{{ $target }}" @endif
    {{ $attributes->merge(['class' => $commonClasses]) }}
>
    @unless($right)
        <x-dynamic-component :component="$icon" class="w-4 h-4" />
    @endunless

    {{ $slot }}

    @if($right)
        <x-dynamic-component :component="$icon" class="w-4 h-4" />
    @endif
</{{ $tag }}>
