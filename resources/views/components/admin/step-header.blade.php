@props([
    'step' => null,     // e.g. "Step 1"
    'title',            // Main title (Choose your device)
    'icon' => null,     // e.g. 'heroicon-o-device-phone-mobile'
])

<div class="space-y-1">

    @if($step)
        <div class="uppercase text-[11px] tracking-wide text-gray-400 font-medium">
            {{ strtoupper($step) }}
        </div>
    @endif

    <h3 class="font-medium flex items-center gap-2">
        @if($icon)
            <x-dynamic-component :component="$icon" class="w-4 h-4 text-gray-500" />
        @endif
        {{ $title }}
    </h3>

</div>
