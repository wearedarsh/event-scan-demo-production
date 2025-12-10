<div class="space-y-4">

    <!-- Header -->
    <x-admin.page-header
        title="Check-In Attendees"
        subtitle="{{ $event->title }} / {{ $session->group?->friendly_name }} / {{ $session->title }}" />

    <!-- Back Link -->
    <div class="px-6 mt-4">
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

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <!-- Search -->
            <div class="w-full md:max-w-md">
                <x-admin.search-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search surname">

                    @if($search !== '')
                    <x-slot:clear>
                        <button
                            wire:click="clearSearch"
                            class="text-[var(--color-primary)] hover:text-[var(--color-primary-hover)]">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </x-slot:clear>
                    @endif

                </x-admin.search-input>
            </div>

            <!-- Stat -->
            <div class="flex justify-start md:justify-end">
                <x-admin.stat-mini
                    label="Checked in"
                    value="{{ $totals['checked_in'] }} of {{ $totals['total'] }}"
                    color="var(--color-success)" />
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
                <div class="text-sm">
                    <strong>{{ $d->last_name }}</strong>, {{ $d->first_name }}

                    @if($d->title)
                    <span class="text-xs opacity-60 italic">{{ $d->title }}</span>
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
        <div class="pt-6">
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