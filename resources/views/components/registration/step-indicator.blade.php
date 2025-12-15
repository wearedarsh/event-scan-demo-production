@props([
    'current',
    'total',
    'label',
])

<div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
    <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">
        {{ $current }} of {{ $total }}
    </span>

    <span class="font-semibold text-[var(--color-secondary)]">
        {{ $label }}
    </span>
</div>
