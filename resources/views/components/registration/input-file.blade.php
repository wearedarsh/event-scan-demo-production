@props([
    'id' => null,
    'model' => null,
    'accept' => '.pdf,.doc,.docx,.jpg,.jpeg,.png',
    'label' => 'Select file',
])

<div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
    <input
        type="file"
        @if($id) id="{{ $id }}" @endif
        @if($model) wire:model="{{ $model }}" @endif
        class="hidden"
        accept="{{ $accept }}"
    />

    <label
        @if($id) for="{{ $id }}" @endif
        class="cursor-pointer inline-flex items-center justify-center bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-4 py-2 rounded-lg mt-2 transition hover:opacity-90"
    >
        {{ $label }}
    </label>

    @if($model)
        <span class="text-[var(--color-text-light)] text-sm truncate max-w-[200px]">
            @if(isset($$model)) {{-- e.g. registration_uploads[groupId] --}}
                {{ $$model->getClientOriginalName() }}
            @endif
        </span>

        <div wire:loading wire:target="{{ $model }}" class="text-xs text-[var(--color-text-light)]">
            Uploading…
        </div>
    @endif
</div>
