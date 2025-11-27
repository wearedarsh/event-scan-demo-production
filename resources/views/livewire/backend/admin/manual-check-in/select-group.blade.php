<div class="space-y-6">

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Manual Check-In</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            {{ $event->title }}
        </p>
    </div>

    <!-- Session Groups -->
    <div class="px-6">
        <div class="soft-card p-5 space-y-4">

            <h3 class="font-medium">Select a Session Group</h3>

            <div class="space-y-2">

                @forelse($groups as $group)
                    <a href="{{ route('admin.events.manual-check-in.sessions', ['event' => $event->id, 'group' => $group->id]) }}"
                       class="soft-card p-4 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition">
                        <span class="font-medium">{{ $group->friendly_name }}</span>
                        <x-heroicon-o-arrow-right class="w-5 h-5 text-[var(--color-primary)]" />
                    </a>
                @empty
                    <p class="text-sm text-[var(--color-text-light)]">No session groups found for this event.</p>
                @endforelse

            </div>

        </div>
    </div>

</div>
