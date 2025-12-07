@props(['title'])

<x-admin.card class="p-6 space-y-6">
    <x-admin.section-title :title="$title" />
    {{ $slot }}
</x-admin.card>
