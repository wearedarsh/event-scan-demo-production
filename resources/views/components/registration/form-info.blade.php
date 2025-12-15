@props([
    'type' => 'info', // could extend later to 'warning', 'success', etc.
])

<div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg">
    <p class="text-[var(--color-secondary)] text-sm">
        {{ $slot }}
    </p>
</div>
