<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">
            Check-ins Report
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
                <li class="breadcrumb-item active" aria-current="page">Check-ins</li>
            </ol>
        </nav>
    </div>

	<div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
		<div class="col-12">
			<h5>Tools</h5>
			<a href="{{ route('admin.events.reports.checkin.pdf.export', [$event->id]) }}"
			   class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
				<span class="cil-arrow-right me-2"></span>
				<span class="text-brand-light">Export PDF</span>
			</a>
		</div>
	</div>

    {{-- BY ROUTE --}}
    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <h5 class="mb-3">Check-ins by route</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m">
                <thead class="table-light">
                    <tr>
                        <th>Route</th>
                        <th class="text-end">Check-ins</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($report['by_route'] ?? []) as $route => $count)
                        <tr>
                            <td>{{ ucfirst($route) }}</td>
                            <td class="text-end">{{ $count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No check-ins recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- BY USER --}}
    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <h5 class="mb-3">Check-ins by user</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th class="text-end">Check-ins</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($report['by_user'] ?? []) as $row)
                        <tr>
                            <td>{{ $row['label'] }}</td>
                            <td class="text-end">{{ $row['count'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No check-ins found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @foreach(($report['by_groups'] ?? []) as $group)
        <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
            <h5 class="mb-3">{{ $group['group'] }}</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle font-m">
                    <thead class="table-light">
                        <tr>
                            <th>Session</th>
                            <th class="text-end">Check-ins</th>
                            <th class="text-end">% of all attendees</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($group['rows'] ?? []) as $row)
                            <tr>
                                <td>{{ $row['session'] }}</td>
                                <td class="text-end">{{ $row['count'] }}</td>
                                <td class="text-end">{{ $row['pct'] }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No sessions found in this group.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    @if(empty($report['by_groups']))
        <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
            <span class="font-m">No session groups found.</span>
        </div>
    @endif
</div>
