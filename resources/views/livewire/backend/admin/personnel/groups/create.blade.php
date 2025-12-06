<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Personnel Groups', 'href' => route('admin.events.personnel.index', $event->id)],
        ['label' => 'Create Group'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create personnel group"
        subtitle="Add a new personnel group for organising badges and categories."
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
            <form wire:submit.prevent="store" class="space-y-6">

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

                        <!-- Background colour -->
                        <div>
                            <x-admin.input-label for="label_background_colour">
                                Label background
                            </x-admin.input-label>

                            <input type="color"
                                   id="label_background_colour"
                                   wire:model.live="label_background_colour"
                                   class="h-16 w-16 rounded-md border border-[var(--color-border)] p-0 cursor-pointer" />
                        </div>

                        <!-- Text colour -->
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


                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-2">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-plus class="h-4 w-4" />
                        </x-slot:icon>
                        Create group
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
