<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Content', 'href' => route('admin.events.content.index', $event->id)],
        ['label' => 'Create Download'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create Event Download"
        subtitle="Upload a downloadable file for {{ $event->title }}."
    />

    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Download Details" />

            <form wire:submit.prevent="store" class="space-y-6" enctype="multipart/form-data">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <x-admin.input-text
                        label="Title"
                        model="title"
                        class="w-full"
                    />

                    <!-- Display Order -->
                    <x-admin.input-text
                        label="Display Order"
                        type="number"
                        model="display_order"
                        class="w-full"
                    />

                    <!-- Active? -->
                    <div>
                        <label class="form-label-custom">Active?</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <!-- File Upload -->
                <div>
                    <label class="form-label-custom">File Upload</label>
                    <input
                        wire:model="file"
                        type="file"
                        class="input-text p-2"
                    />
                    @error('file')
                        <x-admin.input-error :message="$message" />
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">
                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Create Download
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
