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
            <x-admin.input-error :message="$message" />
        @enderror
    @endif
</div>
