<div class="space-y-4">

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



        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Session Groups" />
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
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3 w-28">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @foreach ($event_session_groups as $group)

                        <tr
                            wire:key="group-row-{{ $group->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders[$group->id]"
                                    :id="$group->id" />
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $group->friendly_name }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-admin.table-order-input
                                        wire:model.defer="orders.{{ $group->id }}"
                                        wire:keydown.enter="updateOrder({{ $group->id }})"
                                        class="rounded-sm text-xs" />

                                    <x-admin.table-order-input-enter
                                        :id="$group->id"
                                        method="updateOrder" />
                                </div>
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

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.event-sessions.manage', [
                                'event' => $event->id,
                                'group' => $group->id
                            ])"
                                        icon="rectangle-stack"
                                        label="Manage sessions" />

                                    <x-admin.table-actions-toggle :row-id="$group->id" />

                                </div>
                            </td>
                        </tr>

                        <tr
                            wire:key="group-row-expanded-{{ $group->id }}"
                            x-cloak
                            x-show="openRow === {{ $group->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">
                            <td colspan="5" class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.event-sessions.groups.edit', [
                                'event' => $event->id,
                                'group' => $group->id
                            ])"
                                        icon="pencil-square"
                                        label="Edit" />

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

                        @endforeach

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>

    </div>



    <!-- Session Types -->
    <div class="px-6 space-y-4">



        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Session Types" />
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

                    <tbody wire:sortable="reorderSessionGroups">
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