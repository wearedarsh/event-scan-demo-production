@props([
    'href' => '#',
    'icon' => null,
])

<a href="{{ $href }}"
   class="flex items-center justify-between p-4 rounded-xl bg-white border border-[var(--color-border)] shadow-sm
          hover:shadow-md hover:-translate-y-0.5 transition-all active:scale-[0.98]">

    <div class="font-medium text-sm text-[var(--color-text)]">
        {{ $slot }}
    </div>

    @if($icon)
        <x-dynamic-component :component="$icon" class="w-5 h-5 text-[var(--color-primary)]" />
    @else
        <x-heroicon-o-chevron-right class="w-5 h-5 text-[var(--color-primary)]" />
    @endif
</a>
