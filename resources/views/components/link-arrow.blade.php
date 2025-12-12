@props([
    'href' => '#',
    'target' => null,
    'size' => 'sm',
])

@php
    $sizes = [
        'xs' => [
            'text' => 'text-xs font-medium',
            'icon' => 'h-3 w-3 ml-0.5',
            'translate' => 'group-hover:translate-x-[3px]',
        ],
        'sm' => [
            'text' => 'text-sm font-regular',
            'icon' => 'h-3 w-3 ml-1',
            'translate' => 'group-hover:translate-x-[4px]',
        ],
    ];

    $sizeConfig = $sizes[$size] ?? $sizes['md'];
@endphp


<a href="{{ $href }}"
   @if($target) target="{{ $target }}" @endif
   {{ $attributes->merge([
        'class' =>
            'group inline-flex items-center 
             text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]
             transition-colors duration-200 ' . $sizeConfig['text']
   ]) }}>

    <span>{{ $slot }}</span>

    <x-heroicon-o-arrow-right
        class="{{ $sizeConfig['icon'] }} opacity-80
               transition-all duration-200 ease-out
               group-hover:opacity-100 {{ $sizeConfig['translate'] }}" />
</a>
