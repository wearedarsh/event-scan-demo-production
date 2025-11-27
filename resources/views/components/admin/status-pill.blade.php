@props([
    'status' => 'neutral', // success, danger, warning, neutral
])

@php
    $colors = [
        'success' => [
            'text'   => 'var(--color-success)',
            'border' => 'color-mix(in srgb, var(--color-success) 30%, transparent)',
            'bg'     => 'color-mix(in srgb, var(--color-success) 12%, transparent)',
        ],
        'danger' => [
            'text'   => 'var(--color-danger)',
            'border' => 'color-mix(in srgb, var(--color-danger) 30%, transparent)',
            'bg'     => 'color-mix(in srgb, var(--color-danger) 12%, transparent)',
        ],
        'warning' => [
            'text'   => 'var(--color-warning)',
            'border' => 'color-mix(in srgb, var(--color-warning) 30%, transparent)',
            'bg'     => 'color-mix(in srgb, var(--color-warning) 12%, transparent)',
        ],
        'neutral' => [
            'text'   => 'var(--color-text-light)',
            'border' => 'var(--color-border)',
            'bg'     => 'var(--color-surface-hover)',
        ],
    ];

    $c = $colors[$status] ?? $colors['neutral'];
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium"
      style="color: {{ $c['text'] }}; border: 1px solid {{ $c['border'] }}; background: {{ $c['bg'] }};">
    {{ $slot }}
</span>
