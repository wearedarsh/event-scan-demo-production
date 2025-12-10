@props([
    'title',
    'description' => null,
    'icon' => null, 
    'micro' => null,
])

<x-admin.card class="p-5">

    <h3 class="font-medium mb-1 -mt-2 flex items-center gap-2">
        @if($icon)
            <x-dynamic-component :component="$icon" class="w-4 h-4 text-gray-500" />
        @endif
        {{ $title }}
    </h3>

    @if($description)
        <p class="text-sm text-[var(--color-text-light)] mb-4 font-light">
            {{ $description }}
        </p>
    @endif

    @if($micro)
        <div class="uppercase text-[11px] tracking-wide text-gray-400 mb-1 font-medium flex items-center gap-1">
            @if(isset($micro['icon']))
                <x-dynamic-component :component="$micro['icon']" class="w-3 h-3 text-gray-400" />
            @endif
            {{ $micro['title'] }}
        </div>
    @endif

    <div class="space-y-1">
        {{ $slot }}
    </div>

</x-admin.card>
