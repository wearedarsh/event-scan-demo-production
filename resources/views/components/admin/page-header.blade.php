@props([
    'title',
    'subtitle' => null,
])

<div class="px-6 flex flex-col md:flex-row md:items-center justify-between gap-4 ml-0.5">

    <!-- Left: Title + Subtitle -->
    <div>
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            {{ $title }}
        </h1>

        @if ($subtitle)
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    <!-- Right: Actions Slot -->
    @if (trim($slot))
        <div class="flex items-center gap-3">
            {{ $slot }}
        </div>
    @endif

</div>
