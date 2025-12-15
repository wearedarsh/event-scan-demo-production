@props([
    'action',
])

<div class="text-center pt-3">
    <a
        href="#"
        wire:click.prevent="{{ $action }}"
        class="font-bold text-[var(--color-accent)] hover:text-[var(--color-primary)] transition"
    >
        {{ $slot ?? 'Cancel' }}
    </a>
</div>
