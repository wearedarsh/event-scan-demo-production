<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Send Email'],
    ]" />

    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            Send Email
        </h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Communicate with attendees and send event-related updates.
        </p>
    </div>


    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif



    <!-- ============================================================= -->
    <!-- MAIN CARD -->
    <!-- ============================================================= -->
    <div class="soft-card p-6 mx-6 space-y-6">

        <x-admin.section-title title="Email Details" />

        <form 
            wire:submit.prevent="send"
            wire:confirm="Are you sure you want to send this email to {{ $preview_count }} {{ $this->audienceLabel }}?"
            class="space-y-6"
        >


            <!-- Audience -->
            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="form-label-custom">Audience</label>

                    <x-admin.select wire:model.live="audience" :disabled="$lock_audience">

                        <optgroup label="Paid attendees">
                            <option value="attendees_paid">All paid attendees</option>

                            @foreach($tickets as $ticket)
                                <option value="ticket:{{ $ticket->id }}">
                                    {{ $currency_symbol }}{{ $ticket->price }} — {{ $ticket->name }} ticket
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="Other">
                            <option value="registrations_unpaid_complete">
                                Registrations not paid
                            </option>
                            <option value="attendees_incomplete_feedback">
                                Attendees missing feedback
                            </option>
                        </optgroup>

                    </x-admin.select>

                    <p class="mt-2 text-xs text-[var(--color-text-light)]">
                        Will send to: 
                        <span class="font-semibold text-[var(--color-text)]">
                            {{ $preview_count }}
                        </span>
                        {{ $this->audienceLabel }}
                    </p>
                </div>

            </div>



            <!-- Subject -->
            <div>
                <label class="form-label-custom">Subject</label>
                <input 
                    type="text"
                    wire:model.defer="custom_subject"
                    class="input-text"
                    placeholder="Email subject"
                />
            </div>



            <!-- Content -->
            <div>
                <label class="form-label-custom">Content</label>
                <p class="text-xs text-[var(--color-text-light)] mb-2">
                    Need help writing emails? 
                    <a href="https://guide.eventscan.co.uk/guide-content-editor" 
                       target="_blank"
                       class="underline hover:text-[var(--color-primary)]">
                        View our guide
                    </a>
                </p>

                <div wire:ignore>
                    <textarea id="editor" wire:model="custom_html_content"></textarea>
                </div>

                <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js"></script>
                <script>
                    const { ClassicEditor, Essentials, Bold, Paragraph, Link, List, Heading } = CKEDITOR;

                    ClassicEditor
                        .create(document.querySelector('#editor'), {
                            licenseKey: '{{ $ck_apikey }}',
                            plugins: [ Essentials, Bold, Paragraph, Link, List, Heading ],
                            toolbar: [
                                'undo', 'redo', '|', 'heading', '|', 'bold', '|',
                                'link', '|', 'numberedList', 'bulletedList'
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
                                @this.set('custom_html_content', editor.getData());
                            });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            </div>



            <!-- Signature -->
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label-custom">Signature</label>

                    <x-admin.select wire:model.live="signature">
                        <option value="">No signature</option>

                        @foreach ($signatures as $signature)
                            <option value="{{ $signature->id }}">
                                {{ $signature->title }}
                            </option>
                        @endforeach
                    </x-admin.select>
                </div>
            </div>



            <!-- Actions -->
            <div class="flex items-center gap-3 pt-4">

                <button 
                    type="submit"
                    class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                           border border-[var(--color-primary)] text-[var(--color-primary)]
                           hover:bg-[var(--color-primary)] hover:text-white
                           transition">
                    Send Email
                </button>

                <a href="{{ route('admin.events.manage', $event->id) }}" class="btn-secondary">
                    Cancel
                </a>

            </div>


        </form>

    </div>

</div>
