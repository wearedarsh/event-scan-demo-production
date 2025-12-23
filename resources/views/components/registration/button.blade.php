@props([
    'action' => null,   // Livewire method
    'type' => 'button',
])

<button
    type="{{ $type }}"
    @if($action)
        wire:click="{{ $action }}"
    @endif
    {{ $attributes->merge([
        'class' => 'w-full bg-[var(--color-primary)] text-[var(--color-surface)]
                    font-semibold px-4 py-2 rounded-lg transition hover:opacity-90'
    ]) }}
>
    {{ $slot }}
</button>
