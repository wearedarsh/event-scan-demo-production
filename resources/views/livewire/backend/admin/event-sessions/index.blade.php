<div class="space-y-6">

    <!-- ============================================================= -->
    <!-- BREADCRUMBS -->
    <!-- ============================================================= -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Sessions'],
    ]" />


    <!-- ============================================================= -->
    <!-- PAGE HEADER -->
    <!-- ============================================================= -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Sessions</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage session groups and types for {{ $event->title }}.
            </p>
        </div>
    </div>


    <!-- ============================================================= -->
    <!-- ALERTS -->
    <!-- ============================================================= -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)] font-medium">
                    {{ $errors->first() }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)] font-medium">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif


    <!-- ============================================================= -->
    <!-- SESSION GROUPS -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Session Groups" />

        <div class="soft-card p-6 space-y-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-[var(--color-text-light)]">
                    Manage all groups of sessions that belong to this event.
                </p>

                <a href="{{ route('admin.events.event-sessions.groups.create', ['event' => $event->id]) }}"
                   class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                          bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                          text-[var(--color-primary)]
                          hover:bg-[var(--color-primary)] hover:text-white
                          transition-colors duration-150">
                    <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
                    <span class="hidden md:inline">Add Group</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Display Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($event_session_groups as $group)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">
                                <td class="px-4 py-3 font-medium">{{ $group->friendly_name }}</td>
                                <td class="px-4 py-3">{{ $group->display_order }}</td>
                                <td class="px-4 py-3">
                                    @if ($group->active)
                                        <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                    @else
                                        <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.event-sessions.manage', ['event' => $event->id, 'group' => $group->id])"
                                            icon="rectangle-stack"
                                            label="Manage Sessions"
                                        />

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.event-sessions.groups.edit', ['event' => $event->id, 'group' => $group->id])"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

                                        @if($group->sessions->isEmpty())
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="deleteGroup({{ $group->id }})"
                                                confirm="Are you sure you want to delete this session group?"
                                                icon="trash"
                                                label="Delete"
                                                danger="true"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No session groups found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ============================================================= -->
    <!-- SESSION TYPES -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">
        <x-admin.section-title title="Session Types" />

        <div class="soft-card p-6 space-y-4">
            <div class="flex items-center justify-between">
                <p class="text-sm text-[var(--color-text-light)]">
                    Manage available types of sessions for this event.
                </p>

                <a href="{{ route('admin.events.event-sessions.types.create', ['event' => $event->id]) }}"
                   class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                          bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                          text-[var(--color-primary)]
                          hover:bg-[var(--color-primary)] hover:text-white
                          transition-colors duration-150">
                    <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
                    <span class="hidden md:inline">Add Type</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Type Name</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($event_session_types as $type)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">
                                <td class="px-4 py-3 font-medium">{{ $type->friendly_name }}</td>
                                <td class="px-4 py-3">
                                    @if ($type->active)
                                        <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                    @else
                                        <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.event-sessions.types.edit', ['event' => $event->id, 'type' => $type->id])"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

                                        @if($type->sessions->isEmpty())
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="deleteType({{ $type->id }})"
                                                confirm="Are you sure you want to delete this session type?"
                                                icon="trash"
                                                label="Delete"
                                                danger="true"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No session types found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
