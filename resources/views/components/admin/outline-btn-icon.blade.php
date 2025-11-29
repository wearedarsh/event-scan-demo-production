@props([
    'href' => '#',
    'icon' => null, // e.g. "heroicon-o-plus"
])

<a href="{{ $href }}"
   {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-md border border-[var(--color-primary)]
                    bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                    text-[var(--color-primary)]
                    hover:bg-[var(--color-primary)] hover:text-white
                    transition-colors duration-150'
    ]) }}
>
    @if ($icon)
        <x-dynamic-component 
            :component="$icon" 
            class="h-4 w-4 md:mr-1.5"
        />
    @endif

    <span class="hidden md:inline">
        {{ $slot }}
    </span>
</a>
