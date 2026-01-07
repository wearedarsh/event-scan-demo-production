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

<div class="px-6">
    <div
        class="rounded-lg p-4"
        style="background-color: color-mix(in srgb, {{ $color }} 10%, transparent);"
    >
        <div class="text-xs font-regular" style="color: {{ $color }}">
            {{ $message ?? $slot }}
        </div>
    </div>
</div>
