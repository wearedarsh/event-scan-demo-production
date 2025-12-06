<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Sessions'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Sessions"
        subtitle="Manage session groups and types for {{ $event->title }}." />

    <!-- Alerts -->
    @if($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Session Groups -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Session Groups" />

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <p class="text-sm text-[var(--color-text-light)]">
                    Manage all groups of sessions that belong to this event.
                </p>

                <x-admin.outline-btn-icon
                    :href="route('admin.events.event-sessions.groups.create', ['event' => $event->id])"
                    icon="heroicon-o-plus">
                    Add Group
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3 w-24">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($event_session_groups as $group)

                        <!-- Main Row -->
                        <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <td class="px-4 py-3 font-medium">
                                {{ $group->friendly_name }}
                            </td>

                            <td class="px-4 py-3">
                                <x-admin.table-order-input
                                    model="orders.{{ $group->id }}"
                                    wire:change="updateSessionGroupOrder({{ $group->id }}, $event.target.value)"
                                />
                            </td>

                            <td class="px-4 py-3">
                                @if ($group->active)
                                <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                @else
                                <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- Priority CTA: Manage Sessions -->
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.event-sessions.manage', [
                                            'event' => $event->id,
                                            'group' => $group->id
                                        ])"
                                        icon="rectangle-stack"
                                        label="Manage sessions" />

                                    <!-- Toggle for advanced actions -->
                                    <x-admin.table-actions-toggle :row-id="$group->id" />

                                </div>
                            </td>

                        </tr>

                        <!-- Hidden Expanded Row -->
                        <tr x-cloak
                            x-show="openRow === {{ $group->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="4" class="px-4 py-4">

                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <!-- Edit -->
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.event-sessions.groups.edit', [
                                            'event' => $event->id,
                                            'group' => $group->id
                                        ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <!-- Delete -->
                                    @if($group->sessions->isEmpty())
                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="deleteGroup({{ $group->id }})"
                                        confirm="Delete this session group?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true" />
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
            </x-admin.table>

        </x-admin.card>

    </div>



    <!-- Session Types -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Session Types" />

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <p class="text-sm text-[var(--color-text-light)]">
                    Manage available types of sessions for this event.
                </p>

                <x-admin.outline-btn-icon
                    :href="route('admin.events.event-sessions.types.create', ['event' => $event->id])"
                    icon="heroicon-o-plus">
                    Add Type
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
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
                                        :href="route('admin.events.event-sessions.types.edit', [
                                                'event' => $event->id,
                                                'type' => $type->id
                                            ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    @if($type->sessions->isEmpty())
                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="deleteType({{ $type->id }})"
                                        confirm="Delete this session type?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true" />
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
            </x-admin.table>

        </x-admin.card>

    </div>

</div>