<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Personnel Groups', 'href' => route('admin.events.personnel.index', $event->id)],
        ['label' => 'Edit Group'],
    ]" />


    <!-- Page Header -->
    <x-admin.page-header
        title="Edit personnel group"
        subtitle="Update group name and label styles for personnel badges."
    />


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6 space-y-6">

        <x-admin.section-title title="Group details" />

        <x-admin.card hover="false" class="p-6">
            <form wire:submit.prevent="update" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Group name -->
                    <div>
                        <x-admin.input-label for="title">
                            Group name
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="title"
                            model="title"
                        />
                    </div>

                    <!-- Colours -->
                    <div class="grid grid-cols-2 gap-6">

                        <div>
                            <x-admin.input-label for="label_background_colour">
                                Label background
                            </x-admin.input-label>

                            <input type="color"
                                id="label_background_colour"
                                wire:model.live="label_background_colour"
                                class="h-16 w-16 rounded-md border border-[var(--color-border)] p-0 cursor-pointer" />
                        </div>

                        <div>
                            <x-admin.input-label for="label_colour">
                                Label text colour
                            </x-admin.input-label>

                            <input type="color"
                                id="label_colour"
                                wire:model.live="label_colour"
                                class="h-16 w-16 rounded-md border border-[var(--color-border)] p-0 cursor-pointer" />
                        </div>

                    </div>

                </div>


                <!-- Action buttons -->
                <div class="flex items-center gap-3 pt-2">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Update group
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.personnel.index', $event->id) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>

            </form>
        </x-admin.card>

    </div>

</div>
