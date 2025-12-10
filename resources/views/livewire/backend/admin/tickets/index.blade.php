<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Tickets'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Tickets for {{ $event->title }}"
        subtitle="Manage ticket groups and individual tickets for this event.">
        <x-admin.stat-card
            label="Total tickets"
            :value="$event->allTickets->count()" />
    </x-admin.page-header>

    <!-- Alerts -->
    @if ($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif

    <!-- Ticket Groups -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Ticket Groups" />
                <x-admin.outline-btn-icon
                    :href="route('admin.events.tickets.groups.create', $event->id)"
                    icon="heroicon-o-plus">
                    Add Ticket Group
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Group name</th>
                            <th class="px-4 py-3 w-24">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse ($event_ticket_groups as $group)

                        <tr
                            wire:key="ticket-group-row-{{ $group->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                            <!-- Up/Down buttons -->
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders['groups'][$group->id]"
                                    :id="$group->id"
                                    upMethod="moveGroupUp"
                                    downMethod="moveGroupDown" />
                            </td>

                            <!-- Name -->
                            <td class="px-4 py-3 font-medium">
                                {{ $group->name }}
                            </td>

                            <!-- Order input -->
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">

                                    <x-admin.table-order-input
                                        wire:model.defer="orders.groups.{{ $group->id }}"
                                        wire:keydown.enter="updateGroupOrder({{ $group->id }})"
                                        class="rounded-sm text-xs" />

                                    <x-admin.table-order-input-enter
                                        :id="$group->id"
                                        method="updateGroupOrder" />
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                @if ($group->active)
                                <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                @else
                                <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.tickets.groups.edit', [
                                    'event' => $event->id,
                                    'ticket_group' => $group->id
                                ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <x-admin.table-actions-toggle :row-id="$group->id" />
                                </div>
                            </td>
                        </tr>

                        <!-- Expanded row -->
                        <tr
                            wire:key="ticket-group-row-expanded-{{ $group->id }}"
                            x-cloak
                            x-show="openRow === {{ $group->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">
                            <td colspan="5" class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    @if ($group->tickets->flatMap->registrationTickets->count() === 0)
                                    <x-admin.table-action-button
                                        type="button"
                                        danger="true"
                                        confirm="Delete this ticket group? This will delete all tickets belonging to it."
                                        wireClick="deleteTicketGroup({{ $group->id }})"
                                        icon="trash"
                                        label="Delete" />
                                    @else
                                    <span class="text-xs text-[var(--color-text-light)]">
                                        This group cannot be deleted as its tickets have purchases.
                                    </span>
                                    @endif

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No ticket groups found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>


    </div>


    <!-- Tickets -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Tickets" />
                <x-admin.outline-btn-icon
                    :href="route('admin.events.tickets.create', $event->id)"
                    icon="heroicon-o-plus">
                    Add Ticket
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Group</th>
                            <th class="px-4 py-3 w-24">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse ($event_tickets as $ticket)

                        <tr
                            wire:key="ticket-row-{{ $ticket->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                            <!-- Up/Down -->
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders['tickets'][$ticket->id]"
                                    :id="$ticket->id"
                                    upMethod="moveTicketUp"
                                    downMethod="moveTicketDown" />
                            </td>

                            <!-- Title -->
                            <td class="px-4 py-3 font-medium">
                                {{ $ticket->name }}
                            </td>

                            <!-- Price -->
                            <td class="px-4 py-3">
                                {{ $currency_symbol }}{{ number_format($ticket->price, 2) }}
                            </td>

                            <!-- Group -->
                            <td class="px-4 py-3">
                                {{ $ticket->ticketGroup->name ?? '—' }}
                            </td>

                            <!-- Order Input -->
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">

                                    <x-admin.table-order-input
                                        wire:model.defer="orders.tickets.{{ $ticket->id }}"
                                        wire:keydown.enter="updateTicketOrder({{ $ticket->id }})"
                                        class="rounded-sm text-xs" />

                                    <x-admin.table-order-input-enter
                                        :id="$ticket->id"
                                        method="updateTicketOrder" />
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                @if ($ticket->active)
                                <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                @else
                                <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.tickets.edit', [
                                    'event' => $event->id,
                                    'ticket' => $ticket->id
                                ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <x-admin.table-actions-toggle :row-id="$ticket->id" />

                                </div>
                            </td>
                        </tr>

                        <!-- Expanded row -->
                        <tr
                            wire:key="ticket-row-expanded-{{ $ticket->id }}"
                            x-cloak
                            x-show="openRow === {{ $ticket->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">
                            <td colspan="7" class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    @if (!$ticket->registrationTickets()->exists())
                                    <x-admin.table-action-button
                                        type="button"
                                        danger="true"
                                        confirm="Delete this ticket?"
                                        wireClick="deleteTicket({{ $ticket->id }})"
                                        icon="trash"
                                        label="Delete" />
                                    @else
                                    <span class="text-xs text-[var(--color-text-light)]">
                                        This ticket cannot be deleted as it has purchases.
                                    </span>
                                    @endif

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No tickets found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>


    </div>

</div>