<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Event Sessions', 'href' => route('admin.events.event-sessions.index', $event->id)],
        ['label' => 'Manage Sessions']
    ]" />

    <!-- Header -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">
                Sessions — {{ $group->friendly_name }}
            </h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage this session group’s sessions.
            </p>
        </div>

        <!-- Add Session (outline button) -->
        <a href="{{ route('admin.events.event-sessions.create', [$event->id, $group->id]) }}"
           class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                  bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                  text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white
                  transition-colors duration-150">
            <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
            <span class="hidden md:inline">Add Session</span>
        </a>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif


    <!-- ============================================================= -->
    <!-- TABLE OF SESSIONS -->
    <!-- ============================================================= -->
    <div class="px-6">
        <div class="soft-card p-6 space-y-4">

            <x-admin.section-title title="Sessions in {{ $group->friendly_name }}" />

            <div class="relative overflow-x-auto">
                <div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-[var(--color-surface)] pointer-events-none"></div>

                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)]
                                   border-b border-[var(--color-border)]">

                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">CME Points</th>
                            <th class="px-4 py-3">Display Order</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($event_sessions as $session)

                            <tr class="border-b border-[var(--color-border)]
                                       hover:bg-[var(--color-surface-hover)] transition">

                                <td class="px-4 py-3 font-medium">
                                    {{ $session->title }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $session->cme_points }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $session->display_order }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $session->type->friendly_name }}
                                </td>

                                <td class="px-4 py-3 text-right">

                                    <div class="flex items-center justify-end gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.event-sessions.edit', [
                                                'event' => $event->id,
                                                'group' => $group->id,
                                                'event_session' => $session->id
                                            ])"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

                                        <x-admin.table-action-button
                                            type="button"
                                            danger="true"
                                            confirm="Delete this session?"
                                            wireClick="delete({{ $session->id }})"
                                            icon="trash"
                                            label="Delete"
                                        />

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No sessions found.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
