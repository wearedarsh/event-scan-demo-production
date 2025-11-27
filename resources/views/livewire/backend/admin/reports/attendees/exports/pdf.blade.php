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
		color:#fff; width:100%; height:297mm;
		display:flex; align-items:center; justify-content:center; text-align:center;
		page-break-after:always;
	}
	.cover-inner { padding-top:50mm; }
	.cover-logo { height:16mm; margin-bottom:8mm; }
	.cover-title { font-size: 18pt; font-weight:700; margin:0 0 6mm; }
	.cover-subtitle { font-size: 14pt; margin:0 0 4mm; }
	.cover-meta { font-size:10pt; opacity:.85; margin-top:10mm; }

	/* Tables */
	table { width:100%; border-collapse:collapse; margin-top:3mm; }
	th, td { border:1px solid #e5e5e5; padding:3mm; font-size:10pt; }
	th { background:#f8f8f8; text-align:left; }
	tfoot td { font-weight:700; }

	/* KPI */
	.kpi-row { display:flex; gap:6mm; margin:6mm 0 6mm; }
	.kpi { flex:1; border:1px solid #e5e5e5; border-radius:4px; padding:4mm; }
	.kpi .label { font-size:9pt; color:#666; }
	.kpi .value { font-size:16pt; font-weight:700; }

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
		<div class="cover-title">{{ $report['title'] ?? 'Attendee Report' }}</div>
		<div class="cover-subtitle">{{ $event->title }}</div>
		@if(!empty($exported_at))
			<div class="cover-meta">Exported {{ $exported_at }}</div>
		@endif
	</div>
</section>

<div class="page-header">
	<span class="muted">
		{{ $event->title }} — {{ $report['title'] ?? 'Attendee Report' }} • Exported {{ $exported_at ?? '' }}
	</span>
</div>

<div class="page-footer">
	<span class="muted">Attendee Report</span>
	<span style="float:right" class="muted">Page <span class="pageno"></span></span>
</div>

<main>
	<h1>Overview</h1>
	<div class="small muted">{{ $event->title }} — {{ $report['title'] ?? 'Attendee Report' }}</div>

	<div class="kpi-row" style="margin-top:6mm;">
		<div class="kpi">
			<div class="label">Total paid attendees</div>
			<div class="value">{{ $report['totals']['attendees'] ?? 0 }}</div>
		</div>
	</div>

	<section class="section">
		<h2>Attendees</h2>
		<table>
			<thead>
				<tr>
					<th style="width:12%">Title</th>
					<th style="width:24%">First name</th>
					<th style="width:24%">Surname</th>
					<th style="width:22%">Country</th>
					<th style="width:18%">Group</th>
				</tr>
			</thead>
			<tbody>
				@forelse($attendees as $d)
					<tr>
						<td>{{ $d->title }}</td>
						<td>{{ $d->first_name }}</td>
						<td>{{ $d->last_name }}</td>
						<td>{{ optional($d->country)->name ?? '—' }}</td>
						<td>{{ optional($d->attendeeGroup)->title ?? '—' }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="muted">No attendees found.</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</section>
</main>
</body>
</html>
