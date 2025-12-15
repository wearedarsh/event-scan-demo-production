@props([
    'id' => null,
    'label' => '',
])

<div class="flex items-start gap-3">
    <input
        type="checkbox"
        @if($id) id="{{ $id }}" @endif
        {{ $attributes->merge([
            'class' => 'w-5 h-5 text-[var(--color-primary)] border-[var(--color-border)] rounded focus:ring-[var(--color-accent)] focus:ring-2'
        ]) }}
    />
    @if($label)
        <label for="{{ $id }}" class="text-[var(--color-text)] text-sm leading-snug">
            {{ $label }}
        </label>
    @endif
</div>
