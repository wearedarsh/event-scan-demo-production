@props([
    'title',
    'description' => null,
])

<x-admin.card class="p-5">

    <h3 class="font-medium mb-2">{{ $title }}</h3>

    @if($description)
        <p class="text-sm text-[var(--color-text-light)] mb-4">
            {{ $description }}
        </p>
    @endif


    <div class="space-y-1">
        {{ $slot }}
    </div>

</x-admin.card>
