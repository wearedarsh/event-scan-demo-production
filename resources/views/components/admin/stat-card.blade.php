@props([
    'label',
    'value' => null,
    'type' => 'default', // default | success | warning | danger
])

@php
    // Map type → color variable
    $colors = [
        'default' => 'var(--color-text)',
        'success' => 'var(--color-success)',
        'warning' => 'var(--color-warning)',
        'danger'  => 'var(--color-danger)',
    ];

    $color = $colors[$type] ?? $colors['default'];
@endphp

<div class="soft-card px-4 py-2 flex flex-col items-center">

    <!-- Label -->
    <span class="text-xs text-[var(--color-text-light)]">
        {{ $label }}
    </span>

    <!-- Value or custom slot -->
    <div class="flex items-center gap-2 mt-1">

        @if($value !== null)
            <span class="text-sm font-semibold"
                  style="color: {{ $color }}">
                {{ $value }}
            </span>
        @else
            {{ $slot }}
        @endif

    </div>

</div>
