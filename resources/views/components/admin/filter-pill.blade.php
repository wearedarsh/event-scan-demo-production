@props([
    'active' => false,
])

<button
    {{ $attributes->merge(['class' =>
        'px-3 py-1.5 text-xs font-medium rounded-md border transition
        ' . ($active
            ? 'bg-[var(--color-primary)]/10 text-[var(--color-primary)] border-[var(--color-primary)]/30'
            : 'bg-[var(--color-surface)] text-[var(--color-text-light)] border-[var(--color-border)] hover:bg-[var(--color-surface-hover)]')
    ]) }}
>
    {{ $slot }}
</button>
