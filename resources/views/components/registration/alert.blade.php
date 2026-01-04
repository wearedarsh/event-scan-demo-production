@props([
    'type' => 'info',   // info | success | warning | danger | neutral
    'message' => null,
])

@php
    $colors = [
        'info'    => 'var(--color-info)',
        'success' => 'var(--color-success)',
        'warning' => 'var(--color-warning)',
        'danger'  => 'var(--color-danger)',
        'neutral' => 'var(--color-text-light)',
    ];

    $color = $colors[$type] ?? $colors['info'];
@endphp

<div>
    <div
        class="rounded-lg border-l-4 py-4"
        style="border-left-color: {{ $color }}; background-color: color-mix(in srgb, {{ $color }} 10%, transparent);"
    >
        <div class="text-sm md:text-m font-medium text-center" style="color: {{ $color }}">
            {{ $message ?? $slot }}
        </div>
    </div>
</div>

