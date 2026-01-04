@props([
    'message' => null,
    'ticket' => null
])

<div>
    <div
        class="rounded-lg border-l-4 py-4"
        style="border-left-color: var(--color-success); background-color: color-mix(in srgb, var(--color-success) 10%, transparent);"
    >
        <div class="text-sm md:text-m flex flex-row font-medium justify-between px-4">
            <span style="color: var(--color-success)">{{ $message ?? $slot }}</span>
            <a href="#" style="color: var(--color-text)" wire:click="$set('replace_document.{{ $ticket->id }}', true)">
                Remove document
            </a>
        </div>
    </div>
</div>

