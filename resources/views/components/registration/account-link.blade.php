@props([
    'active' => false,
])

<a
    href="#"
    {{ $attributes->merge([
        'class' => $active
            ? 'font-semibold underline text-[var(--color-secondary)]'
            : 'text-gray-500 hover:text-[var(--color-secondary)]'
    ]) }}
>
    {{ $slot }}
</a>
