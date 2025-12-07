@props([
    'pdf' => null,
    'xlsx' => null,
])

<div class="flex flex-wrap items-center gap-3">

    @if($pdf)
        <x-admin.outline-btn-icon
            icon="heroicon-o-arrow-down-tray"
            :href="$pdf">
            Export PDF
        </x-admin.outline-btn-icon>
    @endif

    @if($xlsx)
        <x-admin.outline-btn-icon
            icon="heroicon-o-arrow-down-tray"
            :href="$xlsx">
            Export XLSX
        </x-admin.outline-btn-icon>
    @endif

</div>
