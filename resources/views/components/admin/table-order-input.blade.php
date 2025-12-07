@props([
    'step' => 1,
])

<div class="space-y-1 w-12">
    <input
        step="{{ $step }}"
        {{ $attributes->merge(['class' => 'w-12 border border-[var(--color-border)] text-xs px-2 py-1 text-center']) }}
    />

    @error($attributes->wire('model'))
        <x-admin.input-error :message="$message" />
    @enderror
</div>
