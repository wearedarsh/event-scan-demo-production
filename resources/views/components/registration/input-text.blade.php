@props([
    'id' => null,
    'type' => 'text',
])

<input
    @if($id) id="{{ $id }}" @endif
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'w-full border border-[var(--color-border)] rounded-lg px-3 py-3
                    focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none'
    ]) }}
/>
