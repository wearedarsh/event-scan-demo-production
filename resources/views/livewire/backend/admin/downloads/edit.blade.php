<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Content', 'href' => route('admin.events.content.index', $event->id)],
        ['label' => 'Edit Download'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit event download"
        subtitle="Update the details for this downloadable file."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <form wire:submit.prevent="update" class="space-y-6">

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


                <!-- Upload New File -->
                <div class="space-y-2">

                    <x-admin.input-label for="new_file">
                        Replace file
                    </x-admin.input-label>

                    <input
                        type="file"
                        wire:model="new_file"
                        class="input-text p-2"
                    />

                    @error('new_file')
                        <x-admin.input-error :message="$message" />
                    @enderror

                    @if ($new_file)
                        <p class="text-xs text-[var(--color-text-light)]">
                            New file selected: <strong>{{ $new_file->getClientOriginalName() }}</strong>
                        </p>
                    @endif

                </div>


                <!-- Buttons -->
                <x-admin.form-actions
                    submit-text="Update download"
                    :cancel-href="route('admin.events.content.index', $event->id)"
                />

            </form>

        </x-admin.card>
    </div>

</div>
