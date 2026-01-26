@props([
    'action' => null,
    'type' => 'button',
])

<button
    type="{{ $type }}"
    @if($action)
        wire:click="{{ $action }}"
    @endif
    {{ $attributes->merge([
    'class' => 'w-full flex items-center justify-center gap-2
                bg-[var(--color-primary)] text-[var(--color-surface)]
                font-semibold px-6 py-3 rounded-lg cursor-pointer disabled:cursor-not-allowed disabled:opacity-60 transition hover:opacity-90'
    ]) }}
>
    {{ $slot }}
</button>
