<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Send email to all attendees - {{ $event->title }}</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Send email to all attendees - {{ $event->title }}</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">

            @if($errors->any())
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <span class="font-m">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        <span class="font-m">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="send" class="row g-3">



                <div class="col-12">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" wire:model.defer="custom_subject" >
                </div>

                <div class="col-12">
                    <label for="custom_html_content" class="form-label">Content</label>
                    <span class="font-s"> (Need help with the content editor? <a href="https://guide.eventscan.co.uk/guide-content-editor" target="_blank">View our guide</a>)</span>
                    <div wire:ignore>
                        <textarea name="editor1" id="editor" wire:model="custom_html_content"></textarea>
                    </div>

                    <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>
                    <script>
                        const {
                            ClassicEditor,
                            Essentials,
                            Bold,
                            Italic,
                            Font,
                            Paragraph,
                            Link,
                            List,
                            Heading
                        } = CKEDITOR;

                        ClassicEditor
                            .create(document.querySelector('#editor'), {
                                licenseKey: '{{ $ck_apikey }}',
                                plugins: [ Essentials, Bold, Paragraph, Link, List, Heading ],
                                toolbar: [
                                    'undo', 'redo', '|', 'heading', '|', 'bold', '|', 'link', '|', 'numberedList', 'bulletedList'
                                ],
                                heading: {
                                    options: [
                                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                        { model: 'heading', view: 'h3', title: 'Heading', class: 'ck-heading_heading' },
                                    ]
                                },
                                initialData: @js($custom_html_content)
                            })
                            .then(editor => {
                                editor.model.document.on('change:data', () => {
                                    @this.set('custom_html_content', editor.getData())
                                });
                            })
                            .catch(error => {
                                alert(error);
                            });
                    </script>
                </div>

                <div class="col-md-6">
                    <label for="signature" class="form-label">Would you like to use a signature?</label>
                    <select wire:model.live="signature" class="form-select" id="signature">
                        <option value="">No signature</option>
                        @foreach ($signatures as $signature)
                            <option value="{{ $signature->id }}">{{ $signature->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Send Email</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light"><span class="text-brand-dark">Cancel</span></a>
                </div>
            </form>
        </div>
    </div>
</div>
