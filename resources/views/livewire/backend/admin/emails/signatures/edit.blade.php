<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email signatures', 'href' => route('admin.emails.signatures.index')],
        ['label' => 'Edit signature'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">
                Edit email signature
            </h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Update the HTML signature that appears in outgoing emails.
            </p>
        </div>
    </div>


    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">
                    {{ $errors->first() }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif


    <!-- ============================================================= -->
    <!-- MAIN EDIT FORM -->
    <!-- ============================================================= -->
    <div class="px-6">

        

        <form wire:submit.prevent="update" class="soft-card p-6 space-y-6">
            <x-admin.section-title title="Signature content" />
            <!-- Content Editor -->
            <div>
                <p class="text-xs text-[var(--color-text-light)] mb-2">
                    Need help using the editor?
                    <a href="https://guide.eventscan.co.uk/guide-content-editor"
                       class="text-[var(--color-primary)] underline"
                       target="_blank">View our guide</a>
                </p>

                <div wire:ignore>
                    <textarea id="editor" wire:model="html_content"></textarea>
                </div>

                <!-- CKEditor -->
                <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>

                <script>
                    const {
                        ClassicEditor,
                        Essentials,
                        Bold,
                        Paragraph,
                        Link,
                        List,
                        Heading
                    } = CKEDITOR;

                    ClassicEditor
                        .create(document.querySelector('#editor'), {
                            licenseKey: '{{ $ck_apikey }}',
                            plugins: [
                                Essentials,
                                Bold,
                                Paragraph,
                                Link,
                                List,
                                Heading
                            ],
                            toolbar: [
                                'undo', 'redo', '|',
                                'heading', '|',
                                'bold', '|',
                                'link', '|',
                                'numberedList', 'bulletedList'
                            ],
                            heading: {
                                options: [
                                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                    { model: 'heading', view: 'h3', title: 'Heading', class: 'ck-heading_heading' },
                                ]
                            },
                            initialData: @js($html_content)
                        })
                        .then(editor => {
                            editor.model.document.on('change:data', () => {
                                @this.set('html_content', editor.getData())
                            })
                        })
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                border border-[var(--color-primary)] text-[var(--color-primary)]
                                hover:bg-[var(--color-primary)] hover:text-white
                                transition">
                    Update signature
                </button>

                <a href="{{ route('admin.emails.signatures.index') }}"
                   class="btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>
