@props([
    'type' => 'button',     // button | link
    'primary' => false,
    'href' => null,
    'icon' => null,
    'label' => null,
    'wireClick' => null,
    'confirm' => null,
    'danger' => false,
])

@php
$baseClasses = implode(' ', [
    'flex items-center gap-2 px-3 py-2 rounded-md font-medium text-xs transition',

    // Primary button styling
    $primary
        ? 'bg-[var(--color-primary)]/5 text-[var(--color-primary)] border border-[var(--color-primary)]/40'
        : (
            $danger
                ? 'text-[var(--color-danger)] border border-[var(--color-danger)] hover:bg-[var(--color-danger)] hover:text-white'
                : 'text-[var(--color-text)] bg-[var(--color-surface)] border border-[var(--color-border)] hover:bg-[var(--color-primary)] hover:text-white'
        )
]);

@endphp

@if ($type === 'link')
    <a
        href="{{ $href }}"
        class="{{ $baseClasses }}"
    >
        <x-dynamic-component :component="'heroicon-o-'.$icon" class="h-4 w-4" />
        <span class="hidden md:inline">{{ $label }}</span>
    </a>
@else
    <button
        type="button"
        @if ($wireClick) wire:click.prevent="{{ $wireClick }}" @endif
        @if ($confirm) wire:confirm="{{ $confirm }}" @endif
        class="{{ $baseClasses }}"
    >
        <x-dynamic-component :component="'heroicon-o-'.$icon" class="h-4 w-4" />
        <span class="hidden md:inline">{{ $label }}</span>
    </button>
@endif
