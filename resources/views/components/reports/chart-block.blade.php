@props([
    'id',          // required: chart canvas ID
    'label' => '', // chart title text
    'height' => 340,
])

<div class="space-y-3">

    <div class="flex items-center justify-between">
        <span class="text-sm text-[var(--color-text-light)]">
            {{ $label }}
        </span>

        <div class="flex items-center gap-2">

            <x-admin.icon-link
                icon="heroicon-o-arrow-down-tray"
                onclick="downloadChartJPG('{{ $id }}', '{{ $id }}.jpg')"
            >
                JPG
            </x-admin.icon-link>

            <x-admin.icon-link
                icon="heroicon-o-arrow-down-tray"
                onclick="downloadChartPNG('{{ $id }}', '{{ $id }}.png')"
            >
                PNG
            </x-admin.icon-link>

            <x-admin.icon-link
                icon="heroicon-o-arrow-down-tray"
                onclick="downloadChartPDF('{{ $id }}', '{{ $id }}.pdf')"
            >
                PDF
            </x-admin.icon-link>

        </div>
    </div>

    <div class="chart-container h-[{{ $height }}px]">
        <canvas id="{{ $id }}" wire:ignore></canvas>
    </div>

</div>
