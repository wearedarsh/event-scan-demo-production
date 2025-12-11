@props([
'id' => null,
'label' => null,
'help' => null,
])

<div class="space-y-2">

    @if($label)
    <x-admin.input-label :for="$id">{{ $label }}</x-admin.input-label>
    @endif

    @if($help)
    <x-admin.input-help>{{ $help }}</x-admin.input-help>
    @endif

    <div class="relative w-16 h-8 rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] overflow-hidden">

        <div
            class="absolute inset-0 rounded-lg z-0"
            style="background: {{ $attributes->wire('model')->value() ? $this->{$attributes->wire('model')->value()} : '#000' }};"></div>

        <input
            type="color"
            id="{{ $id }}"
            {{ $attributes->merge([
            'class' => 'absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10'
        ]) }} />

    </div>


    @error($attributes->wire('model')->value())
    <x-admin.input-error :message="$message" />
    @enderror

</div>