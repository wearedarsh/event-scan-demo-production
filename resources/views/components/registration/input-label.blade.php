@props([
    'for' => null,
    'required' => false,
])

<label
    @if($for) for="{{ $for }}" @endif
    class="block text-sm font-semibold text-[var(--color-secondary)] mb-1"
>
    {{ $slot }}

    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>
