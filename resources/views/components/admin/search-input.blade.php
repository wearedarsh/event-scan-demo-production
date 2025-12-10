@props([
    'placeholder' => 'Search…',
])

<div>
    <div class="relative w-full">

    <!-- Icon -->
    <x-heroicon-o-magnifying-glass
        class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

    <!-- Input -->
    <input
        {{ $attributes->merge([
            'class' => 'w-full pl-10 pr-10 py-2 text-sm rounded-lg
                       bg-[var(--color-surface)] border border-[var(--color-border)]
                       focus:border-[var(--color-primary)]
                       focus:ring-2 focus:ring-[var(--color-primary)]/20
                       outline-none transition'
        ]) }}
        type="text"
        placeholder="{{ $placeholder }}"
    />

    <!-- Right slot (for clear button) -->
    @if(isset($clear))
        <div class="absolute right-3 top-2">
            {{ $clear }}
        </div>
    @endif

</div>
</div>
