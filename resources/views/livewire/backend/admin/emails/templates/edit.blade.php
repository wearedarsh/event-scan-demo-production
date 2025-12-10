<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email Templates', 'href' => route('admin.emails.templates.index')],
        ['label' => 'Edit Template'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit Email Template"
        subtitle="Update the HTML used in this system email template."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Main Form -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Template content" />

            <form wire:submit.prevent="update" class="space-y-6">



                <!-- Editor -->
                <div class="space-y-2">

                    <div wire:ignore>
                        <x-admin.editor
                            model="html_content"
                        />
                    </div>
                </div>


                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Update Template
                    </x-admin.button>

                    <a href="{{ route('admin.emails.templates.index') }}" class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </x-admin.card>

    </div>

</div>
