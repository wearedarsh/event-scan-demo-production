<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email Templates', 'href' => route('admin.emails.templates.index')],
        ['label' => 'Edit Template'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit email template"
        subtitle="Update the HTML used in this system email template." />

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

            <form wire:submit.prevent="update" class="space-y-6">

                <!-- Editor -->
                <div class="space-y-2">
                    <x-admin.input-label for="html_content">HTML Content</x-admin.input-label>
                    <div wire:ignore>
                        <x-admin.editor
                            model="html_content" />
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">
                    <x-admin.form-actions
                        submit-text="Update template"
                        :cancel-href="route('admin.emails.templates.index')" />
                </div>

            </form>

        </x-admin.card>

    </div>

</div>