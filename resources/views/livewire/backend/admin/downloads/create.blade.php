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
        title="Create event download"
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
                    <div>
                        <x-admin.input-label for="title">
                            Title
                        </x-admin.input-label>
                        <x-admin.input-text
                            model="title"
                            class="w-full"
                        />
                    </div>

                    <!-- Display Order -->
                    <div>
                        <x-admin.input-label for="display_order">
                            Display order
                        </x-admin.input-label>
                        <x-admin.input-text
                            model="display_order"
                            type="number"
                            class="w-full"
                        />
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

                <!-- File Upload -->
                <div class="space-y-2">
                    <x-admin.input-label for="file">
                        File upload
                    </x-admin.input-label>

                    <input
                        type="file"
                        wire:model="file"
                        class="input-text p-2"
                    />

                    @error('file')
                        <x-admin.input-error :message="$message" />
                    @enderror
                </div>

                <!-- Buttons -->
                <x-admin.form-actions
                    submit-text="Create download"
                    :cancel-href="route('admin.events.content.index', $event->id)"
                />
                

            </form>

        </x-admin.card>
    </div>

</div>
