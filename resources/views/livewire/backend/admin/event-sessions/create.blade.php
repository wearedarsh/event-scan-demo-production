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

                    <div>
                        <x-admin.input-label for="title">Title</x-admin.input-label>
                        <x-admin.input-text
                            id="title"
                            model="title"
                        />
                    </div>

                    <div>
                        <x-admin.input-label for="start_time">Start Time</x-admin.input-label>
                        <x-admin.input-time
                            id="start_time"
                            model="start_time"
                        />
                    </div>

                    <div>
                        <x-admin.input-label for="end_time">End Time</x-admin.input-label>
                        <x-admin.input-time
                            id="end_time"
                            model="end_time"
                        />
                    </div>

                    <div>
                        <x-admin.input-label for="cme_points">CME Points</x-admin.input-label>
                        <x-admin.input-text
                            id="cme_points"
                            model="cme_points"
                            type="text"
                        />
                    </div>

                    <div>
                        <x-admin.input-label for="display_order">Display Order</x-admin.input-label>
                        <x-admin.input-text
                            id="display_order"
                            model="display_order"
                            type="number"
                        />
                    </div>

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