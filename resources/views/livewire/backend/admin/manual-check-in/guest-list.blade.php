<div class="space-y-6">

    <!-- Header -->
    <x-admin.page-header
        title="Check-In Attendees"
        subtitle="{{ $event->title }} • {{ $session->group?->friendly_name }} • {{ $session->title }}" />

    <!-- Back Link -->
    <div class="px-6 -mt-4">
        <x-admin.icon-link
            :href="route('admin.events.manual-check-in.sessions', [
                'event' => $event->id,
                'group' => $session->event_session_group_id
            ])"
            icon="heroicon-o-arrow-left">
            Back to sessions
        </x-admin.icon-link>
    </div>


    <!-- Guest List -->
    <div class="px-6 space-y-2">

        <!-- Totals -->
        <div class="flex items-center justify-between">
            <div class="max-w-md flex items-center gap-2">

                <x-admin.search-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search surname"
                    class="mb-0"
                    />

                    @if($search !== '')
                    <x-admin.button
                        variant="outline"
                        wire:click="clearSearch"
                        >
                        <x-slot:icon>
                        <heroicon-o-x-mark class="w-4 h-4" />
                        </x-slot:icon>
                    </x-admin.button>
                    @endif

            </div>


            <div class="text-sm text-[var(--color-text-light)]">
                Total: <strong>{{ $totals['total'] }}</strong> • Checked in:
                <strong>{{ $totals['checked_in'] }}</strong>
            </div>
        </div>


        <!-- Attendee Tiles -->
        <div class="space-y-2">

            @forelse($attendees as $d)
            @php $isIn = isset($checkedIn[$d->id]); @endphp

            <button
                wire:click="toggleCheckIn({{ $d->id }})"
                class="w-full flex items-center justify-between px-4 py-4 rounded-xl text-left transition-all

                        {{ $isIn
                            ? 'bg-[var(--color-success)] text-white shadow-sm active:scale-[0.99]'
                            : 'bg-white border border-[var(--color-border)] shadow-sm hover:shadow-md hover:-translate-y-0.5 active:scale-[0.98]' }}
                    ">
                <!-- Name + Optional Fields -->
                <div>
                    <strong>{{ $d->last_name }}</strong>, {{ $d->first_name }}

                    @if($d->title)
                    <span class="text-xs opacity-70">{{ $d->title }}</span>
                    @endif

                    @if($d->company)
                    <div class="text-xs mt-1 opacity-80 tracking-tight">
                        {{ $d->company }}
                    </div>
                    @endif
                </div>

                <!-- Icon -->
                @if($isIn)
                <x-heroicon-o-check-circle class="w-6 h-6" />
                @endif
            </button>

            @empty
            <p class="text-sm text-[var(--color-text-light)]">
                No attendees found.
            </p>
            @endforelse

        </div>

        <!-- Bottom Back Link -->
        <div class="pt-2">
            <x-admin.icon-link
                :href="route('admin.events.manual-check-in.sessions', [
                    'event' => $event->id,
                    'group' => $session->event_session_group_id
                ])"
                icon="heroicon-o-arrow-left">
                Back to sessions
            </x-admin.icon-link>
        </div>

    </div>

</div>