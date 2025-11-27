<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendees']
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <!-- Left: Title -->
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Attendees</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage attendees, groups, communication and reports.
            </p>
        </div>

        <!-- Right: Add attendee + count -->
        <div class="flex items-center gap-4">

            <!-- Stat -->
            <div class="soft-card px-4 py-2 flex flex-col items-center">
                <span class="text-xs text-[var(--color-text-light)]">Total attendees</span>
                <span class="text-sm font-semibold">{{ $event->attendees->count() }}</span>
            </div>

        </div>

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
<!-- COMMUNICATION (full width) -->
<!-- ============================================================= -->
<div class="px-6">
    <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
        <h3 class="font-medium mb-2">Communication</h3>
        <p class="text-sm text-[var(--color-text-light)] mb-4">
            Send targeted emails to attendees based on filters.
        </p>

        <x-link-arrow href="{{ route('admin.events.emails.send-email', [
            'event' => $event->id,
            'audience' => 'attendees_paid'
        ]) }}">
            Email attendees
        </x-link-arrow>
    </div>
</div>


<!-- ============================================================= -->
<!-- THREE-COLUMN ROW -->
<!-- ============================================================= -->
<div class="px-6 grid md:grid-cols-3 gap-6">

    <!-- Groups -->
    <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
        <h3 class="font-medium mb-2">Groups</h3>
        <p class="text-sm text-[var(--color-text-light)] mb-4">
            Create and edit attendee groups.
        </p>

        <x-link-arrow href="{{ route('admin.events.attendees.groups.index', $event->id) }}">
            Manage groups
        </x-link-arrow>
    </div>

    <!-- Tools -->
    <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
        <h3 class="font-medium mb-2">Tools</h3>
        <p class="text-sm text-[var(--color-text-light)] mb-4">
            Export key attendee datasets and view reports.
        </p>

        <x-link-arrow href="#" wire:click.prevent="exportAttendeeSpecialRequirements">
            Special requirements XLSX
        </x-link-arrow>

        <x-link-arrow class="mt-1" href="{{ route('admin.events.reports.payments.export', $event->id) }}">
            Payment data XLSX
        </x-link-arrow>

        <x-link-arrow class="mt-1" href="{{ route('admin.events.reports.attendees.view', $event->id) }}">
            Attendee reports
        </x-link-arrow>
    </div>

    <!-- Badges -->
    <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
        <h3 class="font-medium mb-2">Badges</h3>
        <p class="text-sm text-[var(--color-text-light)] mb-4">
            Export print-ready attendee badges.
        </p>

        <x-link-arrow href="{{ route('admin.events.attendees.badges.export', $event->id) }}">
            Print badges
        </x-link-arrow><br>

        <x-link-arrow class="mt-1" href="{{ route('admin.events.attendees.blank-badge.export', $event->id) }}">
            Blank badge
        </x-link-arrow>
    </div>

</div>




    <!-- ============================================================= -->
    <!-- ATTENDEES -->
    <!-- ============================================================= -->
    <div class="px-6">

        <div class="soft-card p-6 space-y-4">

            <!-- Section Title -->
            <x-admin.section-title title="Attendees" />

            <!-- Filters: Payment Method Pills -->
            <div class="flex flex-wrap items-center gap-2 mb-2">

                <x-admin.filter-pill
                    :active="$paymentMethod === ''"
                    wire:click="$set('paymentMethod', '')">
                    All Payment Methods
                </x-admin.filter-pill>

                <x-admin.filter-pill
                    :active="$paymentMethod === 'stripe'"
                    wire:click="$set('paymentMethod', 'stripe')">
                    Stripe
                </x-admin.filter-pill>

                <x-admin.filter-pill
                    :active="$paymentMethod === 'bank_transfer'"
                    wire:click="$set('paymentMethod', 'bank_transfer')">
                    Bank Transfer
                </x-admin.filter-pill>

            </div>

            <!-- Filters: Groups -->
            @if($has_groups)
            <div class="flex flex-wrap items-center gap-2 mb-2">

                <x-admin.filter-pill
                    :active="$groupFilter === ''"
                    wire:click="$set('groupFilter', '')">
                    All Groups
                </x-admin.filter-pill>

                <x-admin.filter-pill
                    :active="$groupFilter === 'none'"
                    wire:click="$set('groupFilter', 'none')">
                    No Group
                </x-admin.filter-pill>

                @foreach($all_attendee_groups as $g)
                <x-admin.filter-pill
                    :active="$groupFilter == $g->id"
                    wire:click="$set('groupFilter', {{ $g->id }})">
                    {{ $g->title }}
                </x-admin.filter-pill>
                @endforeach

            </div>
            @endif

            <!-- Filters: Tickets -->
            <div class="flex flex-wrap items-center gap-2 mb-2">

                <x-admin.filter-pill
                    :active="$ticketFilter === ''"
                    wire:click="$set('ticketFilter', '')">
                    All Tickets
                </x-admin.filter-pill>

                @foreach($tickets as $ticket)
                <x-admin.filter-pill
                    :active="$ticketFilter == $ticket->id"
                    wire:click="$set('ticketFilter', {{ $ticket->id }})">
                    {{ $currency_symbol }}{{ $ticket->price }} — {{ $ticket->name }}
                </x-admin.filter-pill>
                @endforeach

            </div>

            <!-- Search -->
            <div class="mb-2">
                <div class="relative">
                    <x-heroicon-o-magnifying-glass
                        class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Search attendee name, email or phone"
                        class="w-full pl-10 pr-3 py-2 text-sm rounded-lg
                            bg-[var(--color-surface)] border border-[var(--color-border)]
                            focus:border-[var(--color-primary)]
                            focus:ring-2 focus:ring-[var(--color-primary)]/20
                            outline-none transition" />
                </div>
            </div>

            <!-- Table Wrapper -->
            <div class="relative">

                <!-- Right fade -->
                <div class="pointer-events-none absolute top-0 right-0 h-full w-8 
                            bg-gradient-to-l from-[var(--color-surface)] to-transparent"></div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead>
                            <tr class="uppercase text-xs text-[var(--color-text-light)] border-b border-[var(--color-border)]">

                                @if ($this->roleKey === 'developer')
                                <th class="px-4 py-3">ID</th>
                                @endif

                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Group</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Phone</th>

                                <!-- Country + Payment removed -->

                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                            @forelse($attendees as $attendee)

                            <!-- ======================= -->
                            <!-- MAIN TABLE ROW -->
                            <!-- ======================= -->
                            <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                @if ($this->roleKey === 'developer')
                                <td class="px-4 py-3">{{ $attendee->id }}</td>
                                @endif

                                <!-- Name -->
                                <td class="px-4 py-3 font-medium">
                                    {{ $attendee->title }} {{ $attendee->last_name }}
                                </td>

                                <!-- Group -->
                                <td class="px-4 py-3">
                                    @if($attendee->attendeeGroup)
                                    <span class="px-2 py-0.5 rounded text-xs font-medium shadow-sm"
                                        style="
                                                    background-color: {{ $attendee->attendeeGroup->colour }};
                                                    color: {{ $attendee->attendeeGroup->label_colour }};
                                                ">
                                        {{ $attendee->attendeeGroup->title }}
                                    </span>
                                    @else
                                    <span class="text-[var(--color-text-light)] text-xs">No group</span>
                                    @endif
                                </td>

                                <!-- Email -->
                                <td class="px-4 py-3">
                                    <a href="mailto:{{ $attendee->user->email }}"
                                        class="underline-offset-2 hover:underline">
                                        {{ $attendee->user->email }}
                                    </a>
                                </td>

                                <!-- Phone -->
                                <td class="px-4 py-3">
                                    {{ $attendee->mobile_country_code }}{{ $attendee->mobile_number }}
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.attendees.manage', [$event->id, $attendee->id])"
                                            icon="arrow-right-circle"
                                            label="Manage" />

                                        <x-admin.table-actions-toggle :row-id="$attendee->id" />

                                    </div>
                                </td>

                            </tr>

                            <!-- ======================= -->
                            <!-- EXPANDED ACTION BAR -->
                            <!-- ======================= -->
                            <tr x-cloak
                                x-show="openRow === {{ $attendee->id }}"
                                x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                <td colspan="{{ $this->roleKey === 'developer' ? 6 : 5 }}"
                                    class="px-4 py-4">

                                    <div class="flex flex-wrap items-center justify-end gap-3">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.attendees.edit', [$event->id, $attendee->id])"
                                            icon="pencil-square"
                                            label="Edit" />

                                        <x-admin.table-action-button
                                            type="button"
                                            danger="true"
                                            confirm="Soft delete this attendee? This will deactivate their account."
                                            wireClick="delete({{ $attendee->id }})"
                                            icon="trash"
                                            label="Soft delete" />

                                    </div>

                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="8"
                                    class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No attendees found.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>
            </div>


            <!-- Pagination -->
            <div class="pt-2">
                {{ $attendees->links('pagination::tailwind') }}
            </div>

        </div>
    </div>



</div>