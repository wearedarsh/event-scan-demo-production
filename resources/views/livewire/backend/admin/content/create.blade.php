<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Content', 'href' => route('admin.events.content.index', $event->id)],
        ['label' => 'Create Content'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create content section"
        subtitle="Add new content to appear on the event information page." />

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
            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <div>
                        <x-admin.input-label for="title">
                            Title
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
                        <x-admin.input-label for="active">
                            Active?
                        </x-admin.input-label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <!-- Content Editor -->
                <div class="space-y-2">
                    <x-admin.input-label for="active">
                        HTML content
                    </x-admin.input-label>
                    <div wire:ignore>
                        <x-admin.editor
                            model="html_content" />
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">
                    <x-admin.form-actions
                        submit-text="Create event"
                        :cancel-href="route('admin.events.content.index', $event->id)"
                    />
                </div>

            </form>

        </x-admin.card>

    </div>

</div>