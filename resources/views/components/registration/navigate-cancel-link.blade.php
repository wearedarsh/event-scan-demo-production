<div class="text-center pt-3">
    <a
        href="#"
        {{ $attributes->merge([
            'class' => 'font-bold text-[var(--color-accent)] hover:text-[var(--color-primary)]'
        ]) }}
    >
        {{ $slot ?? 'Cancel' }}
    </a>
</div>
