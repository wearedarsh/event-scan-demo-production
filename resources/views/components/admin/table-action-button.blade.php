@props([
    'type' => 'button',     // button | link
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
    'border border-[var(--color-border)]',
    $danger
        ? 'text-[var(--color-danger)] hover:bg-[var(--color-danger)] hover:text-white'
        : 'bg-[var(--color-surface)] hover:bg-[var(--color-primary)] hover:text-white',
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
