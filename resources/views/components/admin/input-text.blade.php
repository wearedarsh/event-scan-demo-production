@props([
    'label' => null,
    'model' => null, // wire:model target
    'type' => 'text',
])

<div class="space-y-1">
    @if($label)
        <label class="form-label-custom">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        @if($model) wire:model.live="{{ $model }}" @endif
        {{ $attributes->merge(['class' => 'input-text']) }}
    />

    @if($model)
        @error($model)
            <p class="text-sm text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    @endif
</div>
