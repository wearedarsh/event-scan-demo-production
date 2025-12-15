@props([
    'event',
    'spacesRemaining' => null,
])

<div
    x-data="{ open: false }"
    class="mt-6 bg-[var(--color-surface)] border border-[var(--color-border)] rounded-xl shadow-sm p-4 md:p-6"
>
    <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
        <h2 class="text-lg text-left font-bold text-[var(--color-secondary)]">
            {{ $event->title }}
        </h2>

        <button type="button" class="text-[var(--color-primary)] font-semibold text-xs">
            <span x-text="open ? 'Hide details' : 'Show details'"></span>
        </button>
    </div>

    <div
        x-show="open"
        x-transition
        class="mt-2 text-sm text-left text-[var(--color-text-light)] space-y-1"
    >
        <p>{{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}</p>

        @if($event->location)
            <p>{{ $event->location }}</p>
        @endif

        @if(!is_null($spacesRemaining))
            <p>{{ $spacesRemaining }} spaces remaining</p>
        @endif
    </div>
</div>
