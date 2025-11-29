@props([
    'placeholder' => 'Search…',
])

<div class="mb-2">
    <div class="relative">

        <!-- Icon -->
        <x-heroicon-o-magnifying-glass
            class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

        <!-- Input -->
        <input
            {{ $attributes->merge([
                'class' => 'w-full pl-10 pr-3 py-2 text-sm rounded-lg
                           bg-[var(--color-surface)] border border-[var(--color-border)]
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20
                           outline-none transition'
            ]) }}
            type="text"
            placeholder="{{ $placeholder }}"
        />

    </div>
</div>
