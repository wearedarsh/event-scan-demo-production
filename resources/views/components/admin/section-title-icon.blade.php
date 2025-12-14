@props([
    'title',
    'icon' => null,
])

<h3 class="font-medium mb-1 -mt-2 flex items-center gap-2">
    @if($icon)
        <x-dynamic-component :component="$icon" class="w-4 h-4 text-gray-500" />
    @endif
    {{ $title }}
</h3>
