@props([
    'submitText' => 'Save',
    'cancelHref' => null,
    'cancelText' => 'Cancel',
])

<div class="flex items-center gap-3">
    <x-admin.button type="submit" variant="outline">
        {{ $submitText }}
    </x-admin.button>

    @if ($cancelHref)
        <x-admin.button
            href="{{ $cancelHref }}"
            variant="secondary"
        >
            {{ $cancelText }}
        </x-admin.button>
    @endif
</div>