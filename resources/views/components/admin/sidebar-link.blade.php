@props([
    'label',
    'href' => '#',
    'icon' => null,
    'active' => false,
])

@php
    $isActive = $active ? 'active' : '';
@endphp

<a href="{{ $href }}"
   class="group relative flex items-center px-3 py-2 text-sm
          transition
          {{ $active
                ? 'text-[var(--color-primary)] bg-[var(--color-primary)]/10'
                : 'text-[var(--color-text-light)] hover:bg-[var(--color-primary)]/10 hover:text-[var(--color-primary)]'
          }}">

    <!-- Active bar -->
    <span class="absolute left-0 top-0 h-full w-[3px] 
        {{ $active ? 'bg-[var(--color-primary)]' : 'group-hover:bg-[var(--color-primary)]' }}">
    </span>

    <!-- Icon -->
    @if ($icon)
        <x-dynamic-component :component="'heroicon-o-' . $icon"
            class="w-5 h-5 mr-2 opacity-70 group-hover:opacity-100 transition" />
    @endif

    {{ $label }}
</a>
