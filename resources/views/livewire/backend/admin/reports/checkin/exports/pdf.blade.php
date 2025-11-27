<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
	@page { margin: 24mm 16mm 20mm 16mm; size: A4 portrait; }
	@page:first { margin: 0; }

	* { box-sizing: border-box; }
	html, body { font-family: DejaVu Sans, Arial, sans-serif; color:#111; }

	.page-header { position: fixed; top: -14mm; left: 0; right: 0; height: 10mm; font-size: 8pt; color: #666; }
	.page-footer { position: fixed; bottom: -12mm; left: 0; right: 0; height: 10mm; font-size: 8pt; color: #666; }
	.page-footer .pageno:before { content: counter(page); }

	h1 { font-size: 18pt; margin: 0 0 6mm; }
	h2 { font-size: 14pt; margin: 10mm 0 4mm; border-bottom: 1px solid #ddd; padding-bottom: 2mm; }
	h3 { font-size: 12pt; margin: 8mm 0 3mm; color:#142B54; }

	.muted { color:#666; }
	.small { font-size: 9pt; }

	/* COVER */
	.cover {
		background: {{ $brand_color ?? '#142B54' }};
		color: #fff;
		width: 100%;
		height: 297mm;
		display: flex;
		align-items: center;
		justify-content: center;
		text-align: center;
		page-break-after: always;
	}
	.cover-inner { padding-top:50mm; }
	.cover-logo { height: 16mm; margin-bottom: 8mm; }
	.cover-title { font-size: 18pt; font-weight: 700; margin: 0 0 6mm; }
	.cover-subtitle { font-size: 14pt; margin: 0 0 4mm; }
	.cover-meta { font-size: 10pt; opacity: .85; margin-top: 10mm; }

	/* Tables */
	table { width:100%; border-collapse: collapse; margin-top:3mm; }
	th, td { border:1px solid #e5e5e5; padding:3mm; font-size:10pt; }
	th { background:#f8f8f8; text-align:left; }
	tfoot td { font-weight: 700; }

	/* Sections */
	.section { margin-bottom: 20mm; }
</style>
</head>
<body>

{{-- COVER PAGE --}}
<section class="cover">
	<div class="cover-inner">
		@if(!empty($logo_path) && file_exists($logo_path))
			<img class="cover-logo" src="file://{{ $logo_path }}" alt="Logo">
		@endif
		<div class="cover-title">{{ $report['title'] ?? 'Check-ins Report' }}</div>
		<div class="cover-subtitle">{{ $event->title }}</div>
		@if(!empty($exported_at))
			<div class="cover-meta">Exported {{ $exported_at }}</div>
		@endif
	</div>
</section>

<div class="page-header">
	<span class="muted">
		{{ $event->title }} — {{ $report['title'] ?? 'Check-ins Report' }} • Exported {{ $exported_at ?? '' }}
	</span>
</div>

<div class="page-footer">
	<span class="muted">Check-ins Report</span>
	<span style="float:right" class="muted">Page <span class="pageno"></span></span>
</div>

<main>
	<h1>Overview</h1>
	<div class="small muted">{{ $event->title }} — {{ $report['title'] ?? 'Check-ins Report' }}</div>

	<table style="margin-top:6mm; width:60%;">
		<tbody>
			<tr>
				<td style="width:70%;">Total paid attendees</td>
				<td style="width:30%; font-weight:700;">{{ $report['totals']['attendees'] ?? 0 }}</td>
			</tr>
			<tr>
				<td>Total check-ins recorded</td>
				<td style="font-weight:700;">{{ $report['totals']['checkins'] ?? 0 }}</td>
			</tr>
		</tbody>
	</table>

	{{-- BY ROUTE --}}
	<section class="section">
		<h2>Check-ins by route</h2>
		<table>
			<thead>
				<tr>
					<th style="width:70%">Route</th>
					<th style="width:30%">Check-ins</th>
				</tr>
			</thead>
			<tbody>
				@forelse(($report['by_route'] ?? []) as $route => $count)
					<tr>
						<td>{{ ucfirst($route) }}</td>
						<td>{{ $count }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" class="muted">No check-ins recorded.</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</section>

	{{-- BY USER --}}
	<section class="section">
		<h2>Check-ins by user</h2>
		<table>
			<thead>
				<tr>
					<th style="width:70%">User</th>
					<th style="width:30%">Check-ins</th>
				</tr>
			</thead>
			<tbody>
				@forelse(($report['by_user'] ?? []) as $row)
					<tr>
						<td>{{ $row['label'] }}</td>
						<td>{{ $row['count'] }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="2" class="muted">No check-ins found.</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</section>

	{{-- BY SESSION GROUP --}}
	@foreach(($report['by_groups'] ?? []) as $group)
		<section class="section">
			<h2>{{ $group['group'] }}</h2>
			<table>
				<thead>
					<tr>
						<th style="width:60%">Session</th>
						<th style="width:20%">Check-ins</th>
						<th style="width:20%">% of all attendees</th>
					</tr>
				</thead>
				<tbody>
					@forelse(($group['rows'] ?? []) as $row)
						<tr>
							<td>{{ $row['session'] }}</td>
							<td>{{ $row['count'] }}</td>
							<td>{{ $row['pct'] }}%</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="muted">No sessions in this group.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div class="small muted" style="margin-top:2mm;">
				Percentage uses total paid attendees on this event ({{ $report['totals']['attendees'] ?? 0 }}).
			</div>
		</section>
	@endforeach

	@if(empty($report['by_groups']))
		<section class="section">
			<div class="small muted">No session groups found.</div>
		</section>
	@endif
</main>
</body>
</html>
