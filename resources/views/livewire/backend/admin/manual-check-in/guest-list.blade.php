<div class="space-y-6">

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Check-In Attendees</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            {{ $event->title }} • {{ $session->group?->friendly_name }} • {{ $session->title }}
        </p>

        <a href="{{ route('admin.events.manual-check-in.sessions', [
            'event' => $event->id,
            'group' => $session->event_session_group_id
        ]) }}"
           class="inline-flex items-center text-sm text-[var(--color-primary)] hover:underline mt-3">
            ← Back to sessions
        </a>
    </div>


    <!-- Guestlist -->
    <div class="px-6">
        <div class="soft-card p-5 space-y-5">

            <!-- Title + Totals -->
            <div class="flex flex-wrap items-center justify-between">
                <h3 class="font-medium">Attendees</h3>
                <div class="text-sm text-[var(--color-text-light)]">
                    Total: <strong>{{ $totals['total'] }}</strong> • Checked in:
                    <strong>{{ $totals['checked_in'] }}</strong>
                </div>
            </div>

            <!-- Search -->
            <div class="flex items-center max-w-md gap-2">
                <input
                    type="text"
                    placeholder="Start typing surname (A–Z)"
                    wire:model.live.debounce.300ms="search"
                    class="flex-1 soft-input px-4 py-3"
                />

                @if($search !== '')
                    <button
                        wire:click="clearSearch"
                        class="soft-card p-3 text-[var(--color-primary)] font-bold"
                        title="Clear"
                    >
                        &times;
                    </button>
                @endif
            </div>

            <!-- List -->
            <div class="space-y-2">
                @forelse($attendees as $d)
                    @php $isIn = isset($checkedIn[$d->id]); @endphp

                    <button
                        wire:click="toggleCheckIn({{ $d->id }})"
                        class="w-full p-4 rounded-lg flex items-center justify-between transition
                            {{ $isIn ? 'bg-[var(--color-success)] text-white' : 'soft-card' }}
                        "
                    >
                        <span>
                            <strong>{{ $d->last_name }}</strong>, {{ $d->first_name }}
                            @if($d->title)
                                <span class="text-xs opacity-70">{{ $d->title }}</span>
                            @endif
                        </span>

                        @if($isIn)
                            <x-heroicon-o-check-circle class="w-6 h-6" />
                        @else
                            <x-heroicon-o-circle class="w-6 h-6 text-[var(--color-primary)]" />
                        @endif
                    </button>

                @empty
                    <p class="text-sm text-[var(--color-text-light)]">No attendees found.</p>
                @endforelse
            </div>

            <a href="{{ route('admin.events.manual-check-in.sessions', [
                'event' => $event->id,
                'group' => $session->event_session_group_id
            ]) }}"
               class="inline-flex items-center text-sm text-[var(--color-primary)] hover:underline">
                ← Back to sessions
            </a>

        </div>
    </div>

</div>
