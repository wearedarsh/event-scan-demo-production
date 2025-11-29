@props([
    'title',
    'description' => null,
])

<x-admin.card class="p-5">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        
        <div>
            <h3 class="font-medium">{{ $title }}</h3>

            @if($description)
                <p class="text-sm text-[var(--color-text-light)]">
                    {{ $description }}
                </p>
            @endif
        </div>

        <div class="flex flex-wrap md:flex-nowrap gap-3">
            {{ $slot }}
        </div>

    </div>

</x-admin.card>
