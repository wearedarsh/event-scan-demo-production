@props([
    'text',
    'href',
    'linkText',
])

<p class="text-xs text-[var(--color-text-light)]">
    {{ $text }}

    <x-link-arrow
        :href="$href"
        target="_blank"
        size="xs"
    >
        {{ $linkText }}
    </x-admin.link-arrow>
</p>
