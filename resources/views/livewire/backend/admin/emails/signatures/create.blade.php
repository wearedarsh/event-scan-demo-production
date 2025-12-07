<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email Signatures', 'href' => route('admin.emails.signatures.index')],
        ['label' => 'Create Signature'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create Email Signature"
        subtitle="Add a new reusable signature for outgoing emails." 
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

            <x-admin.section-title title="Signature Details" />

            <form wire:submit.prevent="store" class="space-y-6">

                <!-- Title -->
                <x-admin.input-text
                    label="Title"
                    model="title"
                    class="w-full"
                />

                <!-- HTML Editor -->
                <div class="space-y-2">

                    <p class="text-xs text-[var(--color-text-light)]">
                        Need help using the editor?
                        <a href="https://guide.eventscan.co.uk/guide-content-editor"
                           target="_blank"
                           class="text-[var(--color-primary)] underline">
                            View our guide
                        </a>
                    </p>

                    <div wire:ignore>
                        <x-admin.editor
                            model="html_content"
                            label="Signature HTML"
                        />
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Create Signature
                    </x-admin.button>

                    <a href="{{ route('admin.emails.signatures.index') }}" class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </x-admin.card>

    </div>

</div>
