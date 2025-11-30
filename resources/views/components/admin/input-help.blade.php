<p {{ $attributes->merge([
    'class' => 'text-xs text-[var(--color-text-light)] mt-1'
]) }}>
    {{ $slot }}
</p>