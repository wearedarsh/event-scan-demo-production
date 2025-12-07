@props([
    'id' => null,      // the group ID
    'method' => 'updateOrder', // default Livewire method
])

<button
    type="button"
    wire:click="{{ $method }}({{ $id }})"
    {{ $attributes->merge([
        'class' => 'text-[var(--color-text-light)] hover:text-[var(--color-text)]'
    ]) }}
>
    <x-heroicon-o-arrow-turn-down-left class="w-4 h-4" />
</button>
