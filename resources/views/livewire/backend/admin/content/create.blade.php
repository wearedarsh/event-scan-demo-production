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
        title="Create Content Section"
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

            <x-admin.section-title title="Content Details" />

            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <x-admin.input-text
                        label="Section Title"
                        model="title"
                        class="w-full" />

                    <!-- Display Order -->
                    <x-admin.input-text
                        label="Display Order"
                        model="order"
                        type="number"
                        class="w-full" />

                    <!-- Active -->
                    <div>
                        <label class="form-label-custom">Active?</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <!-- Content Editor -->
                <div class="space-y-2">

                    <div wire:ignore>
                        <x-admin.editor
                            label="Content"
                            model="html_content" />
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">
                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Create Content Section
                    </x-admin.button>

                    <a href="{{ route('admin.events.content.index', $event->id) }}"
                        class="btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </x-admin.card>

    </div>

</div>
