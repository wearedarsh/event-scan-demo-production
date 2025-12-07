@props(['label', 'model'])

<div class="space-y-1 w-full">
    <label class="form-label-custom">{{ $label }}</label>

    <input
        type="date"
        wire:model.live="{{ $model }}"
        {{ $attributes->merge([
            'class' => 'w-full form-input'
        ]) }}
    >
</div>
