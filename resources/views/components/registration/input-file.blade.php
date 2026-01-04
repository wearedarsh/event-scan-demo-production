@props([
    'id',
    'model',
    'accept' => '.pdf,.doc,.docx,.jpg,.jpeg,.png',
    'label' => 'Select file',
    'filename' => null,
    'download_copy' => null,
])

@php
    $highlightColor = 'var(--color-warning)';
@endphp

<div
    class="rounded-lg p-3 space-y-2 transition"
    style="background-color: color-mix(in srgb, {{ $highlightColor }} 10%, transparent);"
>

    @if($download_copy)
        <p class="text-sm font-medium text-[var(--color-text)]">
            {{ $download_copy }}
        </p>
    @endif

    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">

        <input
            type="file"
            id="{{ $id }}"
            wire:model="{{ $model }}"
            accept="{{ $accept }}"
            class="hidden"
        />

        <label
            for="{{ $id }}"
            class="cursor-pointer inline-flex items-center justify-center
                   bg-[var(--color-primary)]
                   text-[var(--color-surface)]
                   font-semibold px-4 py-2 rounded-lg
                   transition hover:opacity-90"
        >
            {{ $label }}
        </label>

        @if($filename)
            <span class="text-sm font-medium truncate max-w-[220px]"
                  style="color: {{ $highlightColor }}">
                {{ $filename }}
            </span>
        @else
            <span class="text-[var(--color-text-light)] text-sm">
                No file selected
            </span>
        @endif

        <div
            wire:loading
            wire:target="{{ $model }}"
            class="text-xs text-[var(--color-text-light)]"
        >
            Uploading…
        </div>

    </div>

</div>
