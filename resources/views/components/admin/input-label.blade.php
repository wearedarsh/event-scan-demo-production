@props([
    'for' => null,
    'required' => false,
])

<label
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => 'form-label-custom flex items-center gap-1']) }}
>
    <p class="text-xs text-[var(--color-text)]/60">{{ $slot }}</p>

    @if($required)
        <span class="text-[var(--color-danger)]">*</span>
    @endif
</label>
