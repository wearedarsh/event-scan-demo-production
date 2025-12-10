@props([
    'id' => null,      // the group ID
    'method' => 'updateSessionGroupOrder', // default Livewire method
])

<button
    type="button"
    wire:click="{{ $method }}({{ $id }})"
    {{ $attributes->merge([
        'class' => 'rounded-sm p-1 bg-[var(--color-primary)]/5 text-[var(--color-primary)]/80'
    ]) }}
>
    <x-heroicon-o-arrow-turn-down-left class="w-4 h-4" />
</button>
