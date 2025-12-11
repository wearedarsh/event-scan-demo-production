<p {{ $attributes->merge([
    'class' => 'text-xs text-[var(--color-text-light)]/80 font-regular mt-1'
]) }}>
    {{ $slot }}
</p>