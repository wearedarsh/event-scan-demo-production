<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Create Session Type'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create session type"
        subtitle="Define a reusable type for your event sessions."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6 space-y-6">

        <x-admin.section-title title="Session type details" />

        <x-admin.card hover="false" class="p-6 space-y-6">

            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Friendly Name -->
                    <div>
                        <x-admin.input-label for="friendly_name">
                            Friendly Name
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="friendly_name"
                            model="friendly_name"
                        />
                    </div>

                    <!-- Active -->
                    <div>
                        <x-admin.input-label for="active">
                            Active
                        </x-admin.input-label>

                        <x-admin.select id="active" wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-plus class="h-4 w-4" />
                        </x-slot:icon>
                        Create session type
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.event-sessions.index', $event->id) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>

            </form>

        </x-admin.card>

    </div>

</div>
