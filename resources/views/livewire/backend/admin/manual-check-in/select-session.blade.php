<div class="space-y-6">

    <!-- Header -->
    <x-admin.page-header
        title="Manual Check-In"
        subtitle="{{ $event->title }} / {{ $group->friendly_name }}"
    />

    <!-- Back Link -->
    <div class="px-6 mt-4">
        <x-admin.icon-link
            :href="route('admin.events.manual-check-in.groups', $event->id)"
            icon="heroicon-o-arrow-left"
        >
            Back to groups
        </x-admin.icon-link>
    </div>


    <!-- Sessions -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Select a session" />

        @if($sessions->isEmpty())
            <p class="text-sm text-[var(--color-text-light)]">
                No sessions found in this group.
            </p>
        @else

            <x-admin.link-list>

                @foreach($sessions as $session)
                    <x-admin.link-tile
                        :href="route('admin.events.manual-check-in.guestlist', [
                            'event' => $event->id,
                            'group' => $group->id,
                            'session' => $session->id
                        ])"
                        icon="heroicon-o-arrow-right"
                    >
                        {{ $session->title }}
                    </x-admin.link-tile>
                @endforeach

            </x-admin.link-list>

        @endif

        <div class="pt-4">
            <x-admin.icon-link
                :href="route('admin.events.manual-check-in.groups', $event->id)"
                icon="heroicon-o-arrow-left"
            >
                Back to groups
            </x-admin.icon-link>
        </div>

    </div>

</div>
