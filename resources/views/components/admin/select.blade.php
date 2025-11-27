@props([
    'class' => '',
])

<div class="relative">
    <select
        {{ $attributes->merge([
            'class' =>
                'w-full bg-[var(--color-surface)] border border-[var(--color-border)] rounded-lg 
                 pl-3 pr-10 py-2 text-sm text-[var(--color-text)]
                 focus:border-[var(--color-primary)] focus:ring-2 focus:ring-[var(--color-primary)]/20
                 outline-none transition appearance-none ' . $class
        ]) }}
    >
        {{ $slot }}
    </select>

    <!-- Chevron Icon -->
    <x-heroicon-o-chevron-down
        class="h-4 w-4 absolute right-3 top-1/2 -translate-y-1/2
               text-[var(--color-text-light)] pointer-events-none"
    />
</div>
