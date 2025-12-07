@props([
    'step' => 1,
])

<div class="space-y-1 w-12">
    <input
        step="{{ $step }}"
        {{ $attributes->merge(['class' => 'rounded-sm text-xs text-center p-0.5 border border-[var(--color-border)] bg-white']) }}
    />

    @error($attributes->wire('model'))
        <x-admin.input-error :message="$message" />
    @enderror
</div>
