<div class="space-y-6">

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Manual Check-In</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            {{ $event->title }} – {{ $group->friendly_name }}
        </p>

        <a href="{{ route('admin.events.manual-check-in.groups', $event->id) }}"
           class="inline-flex items-center text-sm text-[var(--color-primary)] hover:underline mt-3">
            ← Back to groups
        </a>
    </div>


    <!-- Session List -->
    <div class="px-6">
        <div class="soft-card p-5 space-y-4">

            <h3 class="font-medium">Select a Session</h3>

            <div class="space-y-2">

                @forelse($sessions as $s)
                    <a href="{{ route('admin.events.manual-check-in.guestlist', [
                        'event' => $event->id,
                        'group' => $group->id,
                        'session' => $s->id
                    ]) }}"
                       class="soft-card p-4 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition">
                        <span class="font-medium">{{ $s->title }}</span>
                        <x-heroicon-o-arrow-right class="w-5 h-5 text-[var(--color-primary)]" />
                    </a>
                @empty
                    <p class="text-sm text-[var(--color-text-light)]">No sessions found in this group.</p>
                @endforelse

            </div>

            <a href="{{ route('admin.events.manual-check-in.groups', $event->id) }}"
               class="inline-flex items-center text-sm text-[var(--color-primary)] hover:underline">
                ← Back to groups
            </a>

        </div>
    </div>

</div>
