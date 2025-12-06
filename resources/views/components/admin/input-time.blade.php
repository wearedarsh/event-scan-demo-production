@props([
    'label' => null,
    'model' => null,
])

<div class="space-y-1">
    @if($label)
        <label class="form-label-custom">{{ $label }}</label>
    @endif

    <input
        type="time"
        @if($model) wire:model.live="{{ $model }}" @endif
        {{ $attributes->merge(['class' => 'input-text']) }}
    />

    @if($model)
        @error($model)
            <x-admin.input-error :message="$message" />
        @enderror
    @endif
</div>
