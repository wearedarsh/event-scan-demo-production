@props([
    'label',
    'value',
    'color' => 'var(--color-primary)'
])

<div class="soft-card px-0.5 py-0.5 rounded-sm flex flex-col items-center min-w-[90px]">
    
    <span class="text-[10px] uppercase tracking-wide text-[var(--color-text-light)]">
        {{ $label }}
    </span>

    <span class="text-xs font-semibold mt-1" style="color: {{ $color }}">
        {{ $value }}
    </span>

</div>
