<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Edit Event Content</h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Event Content</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="container mt-2">
            <h4 class="mb-3">Edit Content Section</h4>

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

            <form wire:submit.prevent="update" class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Section Title</label>
                    <input wire:model="title" type="text" class="form-control" id="title">
                </div>

                <div class="col-md-6">
                    <label for="order" class="form-label">Display Order</label>
                    <input wire:model="order" type="number" class="form-control" id="order">
                </div>

                <div class="col-md-6">
                    <label for="active" class="form-label">Active</label>
                    <select wire:model="active" class="form-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="html_content" class="form-label mb-2">Content</label>
                    <span class="font-s"> (Need help with the content editor? <a href="https://guide.eventscan.co.uk/guide-content-editor" target="_blank">View our guide</a>)</span>
                    
                    <div wire:ignore>
                        <textarea name="editor1" id="editor" wire:model="html_content"></textarea>
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
                                initialData: @js($html_content)
                            })
                            .then(editor => {
                                editor.model.document.on('change:data', () => {
                                    @this.set('html_content', editor.getData())
                                })
                            })
                            .catch(error => {
                                alert(error);
                            });
                    </script>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn bg-brand-secondary">Update Content Section</button>
                    <a href="{{ route('admin.events.content.index', $event->id) }}" class="btn btn-light"><span class="text-brand-dark">Cancel</span></a>
                </div>
            </form>
        </div>
    </div>
</div>
