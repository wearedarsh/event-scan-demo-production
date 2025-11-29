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
    <div class="soft-card p-4 border-l-4" style="border-color: {{ $color }}">

        <div class="text-sm font-medium"
             style="color: {{ $color }}">
            {{ $message ?? $slot }}
        </div>

    </div>
</div>
