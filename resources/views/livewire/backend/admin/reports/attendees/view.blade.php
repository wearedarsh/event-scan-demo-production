<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">
            Attendee Report
            <br>
            <span class="font-m">{{ $event->title }}</span>
        </h2>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.reports.index', $event->id) }}">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Attendees</li>
            </ol>
        </nav>
    </div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
        <div class="col-12">
            <h5>Tools</h5>
            <a href="{{ route('admin.events.reports.attendees.pdf.export', $event->id) }}"
               class="btn bg-brand-secondary d-inline-flex align-items-center mb-2 me-2">
                <span class="cil-arrow-right me-2"></span>
                <span class="text-brand-light">Export PDF</span>
            </a>
            <a href="{{ route('admin.events.reports.attendees.export', $event->id) }}"
               class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
                <span class="cil-spreadsheet me-2"></span>
                <span class="text-brand-light">Export XLSX</span>
            </a>
        </div>
    </div>


    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row g-3 mt-1">
            <div class="col-sm-4">
                <div class="p-3 bg-body-tertiary border rounded-2">
                    <div class="font-s text-muted">Total paid attendees</div>
                    <div class="fs-3">{{ $total }}</div>
                </div>
            </div>
        </div>

        <h5 class="mt-4 mb-3">Ticket breakdown</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m">
                <thead class="table-light">
                    <tr>
                        <th>Ticket</th>
                        <th style="width:18%">Attendees</th>
                        <th style="width:18%">% of total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ticket_breakdown as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['attendees_count'] }}</td>
                            <td>{{ number_format($row['percent'], 1) }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No ticket data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h5 class="mt-4 mb-3">Attendees</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m">
                <thead class="table-light">
                    <tr>
                        <th style="width:10%">Title</th>
                        <th style="width:18%">First name</th>
                        <th style="width:18%">Surname</th>
                        <th style="width:18%">Country</th>
                        <th style="width:18%">Group</th>
                        <th style="width:18%">Ticket(s)</th>
                        <th style="width:10%">Value</th>
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
                        <tr>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->first_name }}</td>
                            <td>{{ $d->last_name }}</td>
                            <td>{{ optional($d->country)->name ?? '—' }}</td>
                            <td>{{ optional($d->attendeeGroup)->title ?? '—' }}</td>
                            <td>{{ $ticket_labels ?: '—' }}</td>
                            <td>
                                @if($total_value > 0)
                                    {{ $currency_symbol }}{{ number_format($total_value, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No attendees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
