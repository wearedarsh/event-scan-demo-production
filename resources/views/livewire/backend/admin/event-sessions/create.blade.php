<div class="space-y-4">

    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Event Sessions', 'href' => route('admin.events.event-sessions.index', $event->id)],
        ['label' => $group->friendly_name, 'href' => route('admin.events.event-sessions.manage', [$event->id, $group->id])],
        ['label' => 'Create Session']
    ]" />

    <x-admin.page-header
        title="{{ $group->friendly_name }}"
        subtitle="Add a new session to this group."
    />

    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <div class="px-6">
        <form wire:submit.prevent="store" class="space-y-4">

            <x-admin.card hover="false" class="p-6 space-y-6">

                <x-admin.section-title title="Session details" />

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
                        model="cme_points"
                        type="text"
                    />

                    <x-admin.input-text
                        label="Display Order"
                        model="display_order"
                        type="number"
                    />

                    <div>
                        <x-admin.input-label for="event_session_type_id">Session Type</x-admin.input-label>
                        <x-admin.select id="event_session_type_id" wire:model.live="event_session_type_id">
                            <option value="">Select a type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->friendly_name }}</option>
                            @endforeach
                        </x-admin.select>
                        <x-admin.input-error for="event_session_type_id" />
                    </div>

                </div>

            </x-admin.card>

            <x-admin.form-actions
                submit-text="Create Session"
                :cancel-href="route('admin.events.event-sessions.manage', [$event->id, $group->id])"
            >
                <x-slot:submit-icon>
                    <x-heroicon-o-plus class="h-4 w-4 mr-1.5" />
                </x-slot:submit-icon>
            </x-admin.form-actions>

        </form>
    </div>

</div>