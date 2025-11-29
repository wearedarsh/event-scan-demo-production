@props([
    'label' => null,
    'model' => null,
    'rows' => 4,
])

<div class="space-y-1">
    @if($label)
        <label class="form-label-custom">{{ $label }}</label>
    @endif

    <textarea
        rows="{{ $rows }}"
        @if($model) wire:model.live="{{ $model }}" @endif
        {{ $attributes->merge(['class' => 'input-textarea']) }}
    ></textarea>

    @if($model)
        @error($model)
            <p class="text-sm text-[var(--color-danger)]">{{ $message }}</p>
        @enderror
    @endif
</div>
