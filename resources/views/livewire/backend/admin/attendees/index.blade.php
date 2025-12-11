<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendees'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Attendees"
        subtitle="Manage attendees, groups, communication and reports.">
        <x-admin.stat-card
            label="Total attendees"
            :value="$event->attendees->count()" />
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Communication -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Communication" />

        <x-admin.action-card
            title="Email"
            icon="heroicon-o-envelope"
            description="Send targeted emails to attendees.">
            <x-link-arrow href="{{ route('admin.events.emails.send-email', [
                'event' => $event->id,
                'audience' => 'attendees_paid'
            ]) }}">
                Email attendees
            </x-link-arrow>
        </x-admin.action-card>


        <!-- Primary actions -->
        <x-admin.section-title title="Primary actions" />

        <div class="grid md:grid-cols-3 gap-6">

            <!-- Groups -->
            <x-admin.tile-card
                title="Groups"
                icon="heroicon-o-users"
                description="Create and edit attendee groups."
                :micro="['title' => 'Primary Actions']">
                <x-link-arrow
                    href="{{ route('admin.events.attendees.groups.index', $event->id) }}">
                    Manage groups
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Tools -->
            <x-admin.tile-card
                title="Tools"
                icon="heroicon-o-wrench"
                :micro="['title' => 'Primary actions']"
                description="Export datasets and view reports.">
                <x-link-arrow
                    href="#"
                    wire:click.prevent="exportAttendeeSpecialRequirements">
                    Special requirements XLSX
                </x-link-arrow><br>

                <x-link-arrow
                    class="mt-1"
                    href="{{ route('admin.events.reports.payments.export', $event->id) }}">
                    Payment data XLSX
                </x-link-arrow><br>

                <x-link-arrow
                    class="mt-1"
                    href="{{ route('admin.events.reports.attendees.view', $event->id) }}">
                    Attendee reports
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Badges -->
            <x-admin.tile-card
                title="Badges"
                icon="heroicon-o-identification"
                :micro="['title' => 'Primary actions']"
                description="Print badges and blank templates.">
                <x-link-arrow href="{{ route('admin.events.attendees.badges.export', $event->id) }}">
                    Print badges
                </x-link-arrow><br>

                <x-link-arrow
                    class="mt-1"
                    href="{{ route('admin.events.attendees.blank-badge.export', $event->id) }}">
                    Blank badge
                </x-link-arrow>
            </x-admin.tile-card>

        </div>


        <!-- Attendees table -->
        <x-admin.section-title title="Attendees" />


        <x-admin.card hover="false" class="p-6 space-y-4">
            @if(session()->has('group'))
            <x-admin.alert type="success" :message="session('group')" />
            @endif

            <!-- Payment method filters -->
            <div class="flex flex-wrap items-center gap-2 mb-2">

                <x-admin.filter-pill :active="$paymentMethod === ''" wire:click="$set('paymentMethod','')">
                    All Payment Methods ({{ $counts['payment_methods']['all'] }})
                </x-admin.filter-pill>

                @if($counts['payment_methods']['stripe'] > 0)
                    <x-admin.filter-pill :active="$paymentMethod === 'stripe'" wire:click="$set('paymentMethod','stripe')">
                        Stripe ({{ $counts['payment_methods']['stripe']}})
                    </x-admin.filter-pill>
                @endif

                @if($counts['payment_methods']['bank_transfer'] > 0)
                <x-admin.filter-pill :active="$paymentMethod === 'bank_transfer'" wire:click="$set('paymentMethod','bank_transfer')">
                    Bank Transfer ({{ $counts['payment_methods']['bank_transfer'] ?? $counts['payment_methods']['bank']}})
                </x-admin.filter-pill>
                @endif

            </div>

            <!-- Group filter pills -->
            @if($has_groups)
            <div class="flex flex-wrap items-center gap-2 mb-2">

                @if($counts['groups']['all'] > 0)
                    <x-admin.filter-pill :active="$groupFilter === ''" wire:click="$set('groupFilter','')">
                        All Groups ({{ $counts['groups']['all'] }})
                    </x-admin.filter-pill>

                    @if($counts['groups']['none'] > 0)
                        <x-admin.filter-pill :active="$groupFilter === 'none'" wire:click="$set('groupFilter','none')">
                            No Group ({{ $counts['groups']['none'] }})
                        </x-admin.filter-pill>
                    @endif

                    @foreach($all_attendee_groups as $g)
                        @if($counts['groups'][$g->id] > 0)
                        <x-admin.filter-pill
                            :active="$groupFilter == $g->id"
                            wire:click="$set('groupFilter', {{ $g->id }})">
                            {{ $g->title }} ({{ $counts['groups'][$g->id] }})
                        </x-admin.filter-pill>
                        @endif
                    @endforeach
                @endif

            </div>
            @endif

            <!-- Ticket filter pills -->
            <div class="flex flex-wrap items-center gap-2 mb-2">

                <x-admin.filter-pill :active="$ticketFilter === ''" wire:click="$set('ticketFilter','')">
                    All Tickets ({{ $counts['tickets']['all'] }})
                </x-admin.filter-pill>

                @foreach($tickets as $ticket)
                    @if($counts['tickets'][$ticket->id] > 0)
                        <x-admin.filter-pill
                            :active="$ticketFilter == $ticket->id"
                            wire:click="$set('ticketFilter', {{ $ticket->id }})">
                            {{ $currency_symbol }}{{ $ticket->price }} — {{ $ticket->name }} ({{ $counts['tickets'][$ticket->id] }})
                        </x-admin.filter-pill>
                    @endif
                @endforeach

                @if($counts['tickets']['none'] > 0)
                    <x-admin.filter-pill :active="$ticketFilter === 'none'" wire:click="$set('ticketFilter','none')">
                        None ({{ $counts['tickets']['none'] }})
                    </x-admin.filter-pill>
                @endif
            
            </div>


            <!-- Search -->
            <x-admin.search-input
                wire:model.live.debounce.300ms="search"
                placeholder="Search attendee name, email or phone" />


            <!-- Table -->
            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">

                            @if ($this->roleKey === 'developer')
                            <th class="px-4 py-3">ID</th>
                            @endif

                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Group</th>
                            <th class="px-4 py-3">Contact</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($attendees as $attendee)

                        <!-- Main row -->
                        <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            @if ($this->roleKey === 'developer')
                            <td class="px-4 py-3">{{ $attendee->id }}</td>
                            @endif

                            <td class="px-4 py-3 font-medium">
                                {{ $attendee->title }} {{ $attendee->last_name }}
                            </td>

                            <td class="px-4 py-3 w-80">
                                <x-admin.select
                                    wire:model.live="groupSelections.{{ $attendee->id }}"
                                    wire:change="updateGroup({{ $attendee->id }}, $event.target.value)">
                                    <option value="">No group</option>
                                    @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                                    @endforeach
                                </x-admin.select>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm text-[var(--color-text)]">
                                    <x-link-arrow href="mailto:{{ $attendee->user->email }}">
                                        {{ $attendee->user->email }}
                                    </x-link-arrow><br>
                                    <p class="text-[var(--color-text-light)] text-xs">
                                        {{ $attendee->mobile_country_code }}{{ $attendee->mobile_number }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.attendees.manage', [$event->id, $attendee->id])"
                                        icon="arrow-right-circle"
                                        primary
                                        label="Manage" />

                                    <x-admin.table-actions-toggle :row-id="$attendee->id" />

                                </div>
                            </td>

                        </tr>

                        <!-- Expanded actions -->
                        <tr x-cloak x-show="openRow === {{ $attendee->id }}" x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="{{ $this->roleKey === 'developer' ? 6 : 5 }}" class="px-4 py-4">

                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.attendees.edit', [$event->id, $attendee->id])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <x-admin.table-action-button
                                        type="button"
                                        danger="true"
                                        confirm="Soft delete this attendee?"
                                        wireClick="delete({{ $attendee->id }})"
                                        icon="trash"
                                        label="Soft delete" />

                                </div>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No attendees found.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

            <!-- Pagination -->
            <x-admin.pagination :paginator="$attendees" />

        </x-admin.card>

    </div>

</div>