@props([
    'title',
    'description' => null,
    'icon' => null, // optional icon
])

<x-admin.card class="p-5">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        
        <div>
            <h3 class="font-medium flex items-center gap-2">
                @if($icon)
                    <x-dynamic-component 
                        :component="$icon" 
                        class="w-4 h-4 text-gray-500" 
                    />
                @endif
                {{ $title }}
            </h3>

            @if($description)
                <p class="text-sm text-[var(--color-text-light)] font-light">
                    {{ $description }}
                </p>
            @endif
        </div>

        <div class="flex flex-wrap md:flex-nowrap gap-3">
            {{ $slot }}
        </div>

    </div>

</x-admin.card>
