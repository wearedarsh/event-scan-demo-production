@props(['paginator'])

@if ($paginator->hasPages())
    <div class="mt-4 flex items-center justify-between">

        <!-- Showing X–Y of Z -->
        <div class="text-xs text-[var(--color-text-light)] ms-4">
            Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
            of {{ $paginator->total() }}
        </div>

        <!-- Navigation -->
        <div class="flex items-center gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <button disabled
                    class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs
                           bg-[var(--color-surface)] border border-[var(--color-border)]
                           text-[var(--color-text-light)] opacity-60 cursor-not-allowed">
                    <x-heroicon-o-chevron-left class="w-4 h-4" />
                </button>
            @else
                <button wire:click="previousPage"
                    class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs
                           border border-[var(--color-primary)] text-[var(--color-primary)]
                           hover:bg-[var(--color-primary)] hover:text-white transition">
                    <x-heroicon-o-chevron-left class="w-4 h-4" />
                </button>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage"
                    class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs
                           border border-[var(--color-primary)] text-[var(--color-primary)]
                           hover:bg-[var(--color-primary)] hover:text-white transition">
                    <x-heroicon-o-chevron-right class="w-4 h-4" />
                </button>
            @else
                <button disabled
                    class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs
                           bg-[var(--color-surface)] border border-[var(--color-border)]
                           text-[var(--color-text-light)] opacity-60 cursor-not-allowed">
                    <x-heroicon-o-chevron-right class="w-4 h-4" />
                </button>
            @endif

        </div>
    </div>
@endif
