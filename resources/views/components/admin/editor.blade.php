@props([
    'model',           // wire:model target
    'label' => null,
    'placeholder' => '',
    'id' => 'editor-' . uniqid(),
    'guide' => null,   // URL to help guide
])

<div class="space-y-2" wire:ignore>

    @if($label)
        <label class="form-label-custom">{{ $label }}</label>
    @endif

    @if($guide)
        <p class="text-xs text-[var(--color-text-light)] -mt-1 mb-2">
            Need help?
            <a href="{{ $guide }}" target="_blank"
               class="text-[var(--color-primary)] underline">
               View our guide
            </a>
        </p>
    @endif

    <textarea id="{{ $id }}" placeholder="{{ $placeholder }}"></textarea>
</div>

@php
    $ck_key = config('services.ckeditor.api_key');
@endphp

@once
<script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>
@endonce

<script>
document.addEventListener('livewire:navigated', () => {

    const el = document.querySelector('#{{ $id }}');

    // Prevent multiple instances on DOM patch
    if (el && el.dataset.initialised) return;

    const {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Paragraph,
        Link,
        List,
        Heading
    } = CKEDITOR;

    ClassicEditor
        .create(el, {
            licenseKey: '{{ $ck_key }}',
            plugins: [ Essentials, Bold, Paragraph, Link, List, Heading ],
            toolbar: [
                'undo', 'redo', '|',
                'heading', '|',
                'bold', '|',
                'link', '|',
                'numberedList', 'bulletedList'
            ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph' },
                    { model: 'heading3', view: 'h3', title: 'Heading' },
                ]
            }
        })
        .then(editor => {
            el.dataset.initialised = true;

            // Set initial value from Livewire
            editor.setData(@this.get('{{ $model }}'));

            // Update Livewire on change
            editor.model.document.on('change:data', () => {
                @this.set('{{ $model }}', editor.getData());
            });

            // Keep Livewire → Editor sync
            Livewire.hook('message.processed', () => {
                if (editor.getData() !== @this.get('{{ $model }}')) {
                    editor.setData(@this.get('{{ $model }}'));
                }
            });
        })
        .catch(error => console.error(error));

});
</script>
