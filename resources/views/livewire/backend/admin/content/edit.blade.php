<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Content', 'href' => route('admin.events.content.index', $event->id)],
        ['label' => 'Edit Content'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit content section"
        subtitle="Update the website content displayed on the event page." />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <form wire:submit.prevent="update" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <div>
                        <x-admin.input-label for="title">
                            Section title
                        </x-admin.input-label>
                        <x-admin.input-text
                            model="title"
                            class="w-full" />
                    </div>

                    <!-- Display Order -->
                    <div>
                        <x-admin.input-label for="order">
                            Display order
                        </x-admin.input-label>
                        <x-admin.input-text
                            model="order"
                            type="number"
                            class="w-full" />
                    </div>
                    <!-- Active -->
                    <div>
                        <x-admin.input-label for="order">
                            Active?
                        </x-admin.input-label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>


                <!-- Content Editor -->
                <div>
                    <x-admin.input-label for="order">
                            Active?
                        </x-admin.input-label>
                    <x-admin.editor
                        label="Content"
                        model="html_content"
                    />

                </div>


                <!-- Buttons -->
                <x-admin.form-actions
                    submit-text="Update event"
                    :cancel-href="route('admin.events.content.index', $event->id)"
                />

            </form>

        </x-admin.card>

    </div>

</div>
