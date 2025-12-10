<p {{ $attributes->merge([
    'class' => 'text-xs text-[var(--color-text-light)] font-regular mt-1'
]) }}>
    {{ $slot }}
</p>