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

	/* Bar visual (CSS-only, DomPDF safe) */
	.bars { margin-top:3mm; }
	.bar-row { display:flex; align-items:center; gap:3mm; margin:2mm 0; page-break-inside: avoid; }
	.bar-label { width:45%; font-size:10pt; }
	.bar-track { flex:1; background:#f0f3f8; border-radius:3px; height:8px; overflow:hidden; }
	.bar-fill { height:8px; background:#d64227; }

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
		<div class="cover-title">{{ $report['title'] ?? 'Demographics Report' }}</div>
		<div class="cover-subtitle">{{ $event->title }}</div>
		@if(!empty($exported_at))
			<div class="cover-meta">Exported {{ $exported_at }}</div>
		@endif
	</div>
</section>

<div class="page-header">
	<span class="muted">
		{{ $event->title }} — {{ $report['title'] ?? 'Demographics Report' }} • Exported {{ $exported_at ?? '' }}
	</span>
</div>

<div class="page-footer">
	<span class="muted">Demographics Report</span>
	<span style="float:right" class="muted">Page <span class="pageno"></span></span>
</div>

<main>
	<h1>Overview</h1>
	<div class="small muted">{{ $event->title }} — {{ $report['title'] ?? 'Demographics Report' }}</div>

	<table style="margin-top:6mm; width:60%;">
		<tbody>
			<tr>
				<td style="width:70%;">Total attendees</td>
				<td style="width:30%; font-weight:700;">{{ $report['total_attendees'] ?? 0 }}</td>
			</tr>
		</tbody>
	</table>

	{{-- Medical attendeeType --}}
	<section class="section">
		<h2>Medical attendeeType</h2>
		@php $sp = $report['attendeeType'] ?? ['labels'=>[], 'counts'=>[], 'percentages'=>[]]; @endphp

		@if(!empty($sp['labels']))
			<table>
				<thead>
					<tr>
						<th style="width:55%">attendeeType</th>
						<th style="width:15%">Count</th>
						<th style="width:15%">Percent</th>
					</tr>
				</thead>
				<tbody>
					@foreach($sp['labels'] as $i => $label)
						<tr>
							<td>{{ $label }}</td>
							<td>{{ $sp['counts'][$i] ?? 0 }}</td>
							<td>{{ $sp['percentages'][$i] ?? 0 }}%</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td>Total</td>
						<td>{{ array_sum($sp['counts'] ?? []) }}</td>
						<td>100%</td>
					</tr>
				</tfoot>
			</table>

			<div class="bars">
				@php $maxCount = max(1, max($sp['counts'] ?: [0])); @endphp
				@foreach($sp['labels'] as $i => $label)
					@php
						$count = $sp['counts'][$i] ?? 0;
						$pctTrack = $maxCount ? round(($count / $maxCount) * 100) : 0;
					@endphp
					<div class="bar-row">
						<div class="bar-label">{{ $label }}</div>
						<div class="bar-track"><div class="bar-fill" style="width: {{ $pctTrack }}%;"></div></div>
						<div class="small">Count: {{ $count }}</div>
					</div>
				@endforeach
			</div>
		@else
			<div class="small muted">No data.</div>
		@endif
	</section>

	{{-- Country --}}
	<section class="section">
		<h2>Country</h2>
		@php $ct = $report['country'] ?? ['labels'=>[], 'counts'=>[], 'percentages'=>[]]; @endphp

		@if(!empty($ct['labels']))
			<table>
				<thead>
					<tr>
						<th style="width:55%">Country</th>
						<th style="width:15%">Count</th>
						<th style="width:15%">Percent</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ct['labels'] as $i => $label)
						<tr>
							<td>{{ $label }}</td>
							<td>{{ $ct['counts'][$i] ?? 0 }}</td>
							<td>{{ $ct['percentages'][$i] ?? 0 }}%</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td>Total</td>
						<td>{{ array_sum($ct['counts'] ?? []) }}</td>
						<td>100%</td>
					</tr>
				</tfoot>
			</table>

			<div class="bars">
				@php $maxCount = max(1, max($ct['counts'] ?: [0])); @endphp
				@foreach($ct['labels'] as $i => $label)
					@php
						$count = $ct['counts'][$i] ?? 0;
						$pctTrack = $maxCount ? round(($count / $maxCount) * 100) : 0;
					@endphp
					<div class="bar-row">
						<div class="bar-label">{{ $label }}</div>
						<div class="bar-track"><div class="bar-fill" style="width: {{ $pctTrack }}%;"></div></div>
						<div class="small">Count: {{ $count }}</div>
					</div>
				@endforeach
			</div>
		@else
			<div class="small muted">No data.</div>
		@endif
	</section>
</main>
</body>
</html>
