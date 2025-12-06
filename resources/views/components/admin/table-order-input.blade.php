@props([
    'model' => null, // wire:model target like "orders.5"
    'min' => 1,
    'max' => null,
    'step' => 1,
])

<div class="space-y-1 w-20">
    <input
        type="number"
        min="{{ $min }}"
        @if($max) max="{{ $max }}" @endif
        step="{{ $step }}"
        @if($model) wire:model.lazy="{{ $model }}" @endif
        {{ $attributes->merge(['class' => 'input-text text-center p-1']) }}
    />

    @if($model)
        @error($model)
            <x-admin.input-error :message="$message" />
        @enderror
    @endif
</div>
