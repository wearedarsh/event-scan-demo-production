<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendee Groups', 'href' => route('admin.events.attendees.groups.index', $event->id)],
        ['label' => 'Edit Group'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit attendee group"
        subtitle="Modify the group's name, badge colours, and label styling."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form Wrapper -->
    <div class="px-6">
        <form wire:submit.prevent="update" class="space-y-6">

            <x-admin.section-title title="Group name" />

            <!-- Group Name -->
            <div class="grid md:grid-cols-2 gap-6">
                <x-admin.input-text
                    id="title"
                    model="title"
                    placeholder="e.g. Faculty, Speakers, VIP"
                />

                @error('title')
                    <x-admin.input-error :message="$message" />
                @enderror
            </div>

            <x-admin.section-title title="Badge appearance" />

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Background colour -->
                <x-admin.card hover="false" class="p-6 space-y-4">
                    <x-admin.color-picker
                        id="colour"
                        label="Badge background colour"
                        help="This sets the background colour for the badge label applied to attendees."
                        wire:model.live="colour"
                    />

                </x-admin.card>


                <!-- Text colour -->
                <x-admin.card hover="false" class="p-6 space-y-4">
                    <x-admin.color-picker
                        id="colour"
                        label="Badge text colour"
                        help="This sets the background colour for the badge label applied to attendees."
                        wire:model.live="label_colour"
                    />

                </x-admin.card>

            </div>

            <x-admin.card hover="false" class="p-6 space-x-4">

                <x-admin.button type="submit" variant="outline">
                    Update group
                </x-admin.button>

                <x-admin.button
                    href="{{ route('admin.events.attendees.groups.index', $event->id) }}"
                    variant="secondary">
                    Cancel
                </x-admin.button>

            </x-admin.card>

        </form>
    </div>

</div>
