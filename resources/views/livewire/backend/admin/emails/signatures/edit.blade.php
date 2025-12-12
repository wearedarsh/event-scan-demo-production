<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email Signatures', 'href' => route('admin.emails.signatures.index')],
        ['label' => 'Edit Signature'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit email signature"
        subtitle="Update the title and HTML content of this email signature."
    />


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">
            <form wire:submit.prevent="update" class="space-y-6">

                <!-- Title -->
                <x-admin.input-label for="title">
                    Title
                </x-admin.input-label>
                <x-admin.input-text
                    model="title"
                    class="w-full"
                />

                <!-- HTML Editor -->
                <div class="space-y-2">
                    <x-admin.input-label for="html_content">
                            HTML Content
                        </x-admin.input-label>
                        <x-admin.help-link
                        text="Need help using the editor?"
                        link-text="view our guide"
                        href="https://guide.eventscan.co.uk/guide-content-editor"
                        />
                    <div wire:ignore>
                        
                        <x-admin.editor
                            model="html_content"
                        />
                    </div>

                </div>

                <!-- Buttons -->
                <x-admin.form-actions
                    submit-text="Update signature"
                    :cancel-href="route('admin.emails.signatures.index')"
                />

            </form>

        </x-admin.card>

    </div>

</div>
