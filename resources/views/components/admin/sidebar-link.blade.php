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
                ? 'text-[var(--color-primary)]/80 bg-[var(--color-primary)]/5'
                : 'text-[var(--color-text-light)] hover:bg-[var(--color-primary)]/10 hover:text-[var(--color-primary)]'
          }}">

    <!-- Icon -->
    @if ($icon)
        <x-dynamic-component :component="$icon"
            class="w-5 h-5 mr-2 opacity-70 group-hover:opacity-100 transition" />
    @endif

    {{ $label }}
</a>
