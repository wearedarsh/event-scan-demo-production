<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports', 'href' => route('admin.events.reports.index', $event->id)],
        ['label' => 'Attendees'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Attendee Report"
        subtitle="{{ $event->title }}"
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Tools -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Tools" />

            <div class="flex flex-wrap items-center gap-3">

                <x-admin.outline-btn-icon
                    :href="route('admin.events.reports.attendees.pdf.export', $event->id)"
                    icon="heroicon-o-arrow-down-tray">
                    Export PDF
                </x-admin.outline-btn-icon>

                <x-admin.outline-btn-icon
                    :href="route('admin.events.reports.attendees.export', $event->id)"
                    icon="heroicon-o-arrow-down-tray">
                    Export XLSX
                </x-admin.outline-btn-icon>

            </div>

        </x-admin.card>
    </div>


    <!-- Totals -->
    <div class="px-6">
        <x-admin.card class="p-6">

            <x-admin.section-title title="Overview" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <x-admin.stat-card
                    label="Total paid attendees"
                    :value="$total"
                />

            </div>

        </x-admin.card>
    </div>


    <!-- Ticket Breakdown -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Ticket breakdown" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Ticket</th>
                            <th class="px-4 py-3">Attendees</th>
                            <th class="px-4 py-3">% of total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($ticket_breakdown as $row)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)]">
                                <td class="px-4 py-3">{{ $row['name'] }}</td>
                                <td class="px-4 py-3">{{ $row['attendees_count'] }}</td>
                                <td class="px-4 py-3">{{ number_format($row['percent'], 1) }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No ticket data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-admin.table>

        </x-admin.card>
    </div>


    <!-- Attendee List -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Attendees" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">First name</th>
                            <th class="px-4 py-3">Surname</th>
                            <th class="px-4 py-3">Country</th>
                            <th class="px-4 py-3">Group</th>
                            <th class="px-4 py-3">Ticket(s)</th>
                            <th class="px-4 py-3">Value</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($attendees as $d)

                            @php
                                $ticket_labels = $d->registrationTickets
                                    ->map(fn($rt) => trim(($rt->ticket->name ?? '—').' x'.$rt->quantity))
                                    ->filter()
                                    ->implode(', ');

                                $total_value = $d->registrationTickets
                                    ->sum(fn($rt) => (float) $rt->quantity * (float) $rt->price_at_purchase);
                            @endphp

                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)]">
                                <td class="px-4 py-3">{{ $d->title }}</td>
                                <td class="px-4 py-3">{{ $d->first_name }}</td>
                                <td class="px-4 py-3">{{ $d->last_name }}</td>
                                <td class="px-4 py-3">{{ optional($d->country)->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ optional($d->attendeeGroup)->title ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $ticket_labels ?: '—' }}</td>

                                <td class="px-4 py-3">
                                    @if($total_value > 0)
                                        {{ $currency_symbol }}{{ number_format($total_value, 2) }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No attendees found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>
    </div>

</div>
