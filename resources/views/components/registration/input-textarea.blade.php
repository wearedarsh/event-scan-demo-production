@props([
    'id' => null,
    'rows' => 4, {{-- default rows --}}
])

<textarea
    @if($id) id="{{ $id }}" @endif
    rows="{{ $rows }}"
    {{ $attributes->merge([
        'class' => 'w-full border border-[var(--color-border)] rounded-lg px-3 py-3
                    focus:ring-2 focus:ring-[var(--color-accent)] focus:outline-none resize-none'
    ]) }}
></textarea>
