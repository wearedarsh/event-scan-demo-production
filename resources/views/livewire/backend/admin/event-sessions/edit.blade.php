<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Event Sessions', 'href' => route('admin.events.event-sessions.index', $event->id)],
        ['label' => $group->friendly_name, 'href' => route('admin.events.event-sessions.manage', [$event->id, $group->id])],
        ['label' => 'Edit Session']
    ]" />

    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            Edit Session – {{ $group->friendly_name }}
        </h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Update the details for this event session.
        </p>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" class="px-6" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" class="px-6" />
    @endif

    <!-- Form -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Session details" />

            <form wire:submit.prevent="update" class="space-y-6">

                <!-- Grid -->
                <div class="grid md:grid-cols-2 gap-6">

                    <x-admin.input-text
                        label="Title"
                        model="title"
                    />

                    <x-admin.input-time
                        label="Start Time"
                        model="start_time"
                    />

                    <x-admin.input-time
                        label="End Time"
                        model="end_time"
                    />

                    <x-admin.input-text
                        label="CME Points"
        type="number"
                        model="cme_points"
                    />

                    <x-admin.input-text
                        label="Display Order"
                        type="number"
                        model="display_order"
                    />

                    <div>
                        <x-admin.input-label for="event_session_type_id">Session Type</x-admin.input-label>
                        <x-admin.select id="event_session_type_id" wire:model.live="event_session_type_id">
                            <option value="">Select type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->friendly_name }}</option>
                            @endforeach
                        </x-admin.select>
                        @error('event_session_type_id')
                            <x-admin.input-error :message="$message" />
                        @enderror
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">

                    <x-admin.button variant="outline" type="submit">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Update Session
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.event-sessions.manage', [$event->id, $group->id]) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>

            </form>

        </x-admin.card>
    </div>

</div>
