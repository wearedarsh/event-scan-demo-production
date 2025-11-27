@props([
    'rowId' => null,
])

<button
    @click.stop="openRow = openRow === {{ $rowId }} ? null : {{ $rowId }}"
    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium
           rounded-md border border-[var(--color-border)]
           bg-[var(--color-surface)]
           hover:bg-[var(--color-surface-hover)]
           text-[var(--color-text-light)]
           hover:text-[var(--color-text)]
           transition"
>
    <x-heroicon-o-ellipsis-horizontal class="h-4 w-4" />
</button>
