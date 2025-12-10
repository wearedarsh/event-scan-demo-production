@props([
    'order',
    'id',
])

<div class="flex flex-col items-center gap-1">

    @if($order > 0)
        <button 
            class="text-[var(--color-primary)]/80 bg-[var(--color-primary)]/5 rounded-sm p-0.5"
            type="button"
            wire:click="moveUp({{ $id }})"
            title="Move Up">
            <x-heroicon-o-chevron-up class="w-3 h-3" />
        </button>
    @endif

    <button 
        type="button"
        wire:click="moveDown({{ $id }})"
        class="text-[var(--color-primary)]/80 bg-[var(--color-primary)]/5 rounded-sm p-0.5"
        title="Move Down">
        <x-heroicon-o-chevron-down class="w-3 h-3" />
    </button>

</div>
