<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Event Sessions', 'href' => route('admin.events.event-sessions.index', $event->id)],
        ['label' => $group->friendly_name, 'href' => route('admin.events.event-sessions.manage', [$event->id, $group->id])],
        ['label' => 'Create Session']
    ]" />

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            {{ $group->friendly_name }}
        </h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Add a new session to this group.
        </p>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <x-admin.alert type="danger" :message="$errors->first()" />
        </div>
    @endif

    @if(session()->has('success'))
        <div class="px-6">
            <x-admin.alert type="success" :message="session('success')" />
        </div>
    @endif

    <!-- Form wrapper -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Session details" />

            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <x-admin.input-text
                        label="Title"
                        model="title"
                    />

                    <!-- Start Time -->
                    <x-admin.input-time
                        label="Start Time"
                        model="start_time"
                    />

                    <!-- End Time -->
                    <x-admin.input-time
                        label="End Time"
                        model="end_time"
                    />

                    <!-- CME Points -->
                    <x-admin.input-text
                        label="CME Points"
                        model="cme_points"
                        type="text"
                    />

                    <!-- Display Order -->
                    <x-admin.input-text
                        label="Display Order"
                        model="display_order"
                        type="number"
                    />

                    <!-- Session Type -->
                    <div>
                        <x-admin.input-label>Session Type</x-admin.input-label>
                        <x-admin.select wire:model.live="event_session_type_id">
                            <option value="">Select a type</option>
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

                    <x-admin.button type="submit" variant="outline">
                        <x-heroicon-o-plus class="h-4 w-4 mr-1.5" />
                        Create Session
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
