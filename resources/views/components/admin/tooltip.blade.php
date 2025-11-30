@props([
    'text' => '',
    'position' => 'top', // top, right, bottom, left
])

<div x-data="{ open: false }" class="relative inline-block">
    <div 
        @mouseenter="open = true" 
        @mouseleave="open = false"
        @focus="open = true"
        @blur="open = false"
    >
        {{ $slot }}
    </div>

    <div 
        x-cloak
        x-show="open"
        x-transition.opacity
        class="absolute z-20 whitespace-nowrap
               bg-[var(--color-text)] text-white text-xs 
               px-2 py-1 rounded-md shadow 
               top-full mt-1"
        :class="{
            'top-full left-1/2 -translate-x-1/2 mt-1': '{{ $position }}' === 'top',
            'right-full top-1/2 -translate-y-1/2 mr-2': '{{ $position }}' === 'left',
            'left-full top-1/2 -translate-y-1/2 ml-2': '{{ $position }}' === 'right',
            'bottom-full left-1/2 -translate-x-1/2 mb-1': '{{ $position }}' === 'bottom',
        }"
    >
        {{ $text }}
    </div>
</div>
