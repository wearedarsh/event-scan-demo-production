<div class="space-y-4">

    <!-- Header -->
    <x-admin.page-header
        title="Manual Check-In"
        subtitle="{{ $event->title }}"
    />

    <!-- Session Groups -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Select a group" />

        @if($groups->isEmpty())
            <p class="text-sm text-[var(--color-text-light)]">
                No session groups found for this event.
            </p>
        @else

            <x-admin.link-list>

                @foreach($groups as $group)
                    <x-admin.link-tile
                        :href="route('admin.events.manual-check-in.sessions', [
                            'event' => $event->id,
                            'group' => $group->id
                        ])"
                        icon="heroicon-o-arrow-right"
                    >
                        {{ $group->friendly_name }}
                    </x-admin.link-tile>
                @endforeach

            </x-admin.link-list>

        @endif

    </div>

</div>
