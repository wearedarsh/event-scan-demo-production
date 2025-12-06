<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Event Sessions', 'href' => route('admin.events.event-sessions.index', $event->id)],
        ['label' => 'Manage Sessions'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="{{ $group->friendly_name }}"
        subtitle="Manage this session group’s sessions."
    >
        <x-admin.outline-btn-icon
            :href="route('admin.events.event-sessions.create', [$event->id, $group->id])"
            icon="heroicon-o-plus">
            Add Session
        </x-admin.outline-btn-icon>
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Sessions Table -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Sessions in {{ $group->friendly_name }}" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">CME Points</th>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($event_sessions as $session)

                            <!-- Main Row -->
                            <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <td class="px-4 py-3 font-medium">
                                    {{ $session->title }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $session->cme_points }}
                                </td>

                                <td class="px-4 py-3">
                                    <x-admin.table-order-input
                                        model="orders.{{ $session->id }}"
                                        wire:change="updateSessionOrder({{ $session->id }}, $event.target.value)"
                                    />
                                </td>

                                <td class="px-4 py-3">
                                    {{ $session->type->friendly_name }}
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">

                                        <!-- Edit as primary action -->
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

                                        <x-admin.table-actions-toggle :row-id="$session->id" />

                                    </div>
                                </td>

                            </tr>

                            <!-- Hidden Expanded Row -->
                            <tr x-cloak
                                x-show="openRow === {{ $session->id }}"
                                x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                <td colspan="5" class="px-4 py-4">

                                    <div class="flex flex-wrap items-center justify-end gap-3">

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
                                <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No sessions found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>
    </div>

</div>
