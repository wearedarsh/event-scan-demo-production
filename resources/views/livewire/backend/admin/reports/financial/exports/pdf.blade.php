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
	.cover { background: {{ $brand_color ?? '#142B54' }}; color:#fff; width:100%; height:297mm; display:flex; align-items:center; justify-content:center; text-align:center; page-break-after:always; }
	.cover-inner { padding-top:50mm; }
	.cover-logo { height:16mm; margin-bottom:8mm; }
	.cover-title { font-size: 18pt; font-weight:700; margin:0 0 6mm; }
	.cover-subtitle { font-size: 14pt; margin:0 0 4mm; }
	.cover-meta { font-size:10pt; opacity:.85; margin-top:10mm; }
	table { width:100%; border-collapse:collapse; margin-top:3mm; }
	th, td { border:1px solid #e5e5e5; padding:3mm; font-size:10pt; }
	th { background:#f8f8f8; text-align:left; }
	tfoot td { font-weight:700; }
	.kpi-row { display:flex; gap:6mm; margin:6mm 0 6mm; }
	.kpi { flex:1; border:1px solid #e5e5e5; border-radius:4px; padding:4mm; }
	.kpi .label { font-size:9pt; color:#666; }
	.kpi .value { font-size:16pt; font-weight:700; }
	.bars { margin-top:3mm; }
	.bar-row { display:flex; align-items:center; gap:3mm; margin:2mm 0; page-break-inside: avoid; }
	.bar-label { width:45%; font-size:10pt; }
	.bar-track { flex:1; background:#f0f3f8; border-radius:3px; height:8px; overflow:hidden; }
	.bar-fill { height:8px; background:#d64227; }
	.section { margin-bottom: 20mm; }
</style>
</head>
<body>

<section class="cover">
	<div class="cover-inner">
		@if(!empty($logo_path) && file_exists($logo_path))
			<img class="cover-logo" src="file://{{ $logo_path }}" alt="Logo">
		@endif
		<div class="cover-title">{{ $report['title'] ?? 'Financial Report' }}</div>
		<div class="cover-subtitle">{{ $event->title }}</div>
		@if(!empty($report['totals']['date_from']) || !empty($report['totals']['date_to']))
			@if(!empty($date_from_uk) || !empty($date_to_uk))
			<div class="cover-meta">
				@if(!empty($date_from_uk)) From {{ $date_from_uk }} @endif
				@if(!empty($date_to_uk)) to {{ $date_to_uk }} @endif
			</div>
			@endif
		@endif
		@if(!empty($exported_at))
			<div class="cover-meta">Exported {{ $exported_at }}</div>
		@endif
	</div>
</section>

<div class="page-header">
	<span class="muted">
		{{ $event->title }} — {{ $report['title'] ?? 'Financial Report' }}
		@if(!empty($date_from_uk) || !empty($date_to_uk))
		• @if(!empty($date_from_uk)) From {{ $date_from_uk }} @endif
			@if(!empty($date_to_uk)) to {{ $date_to_uk }} @endif
		@endif
		• Exported {{ $exported_at ?? '' }}
	</span>
</div>

<div class="page-footer">
	<span class="muted">Financial Report</span>
	<span style="float:right" class="muted">Page <span class="pageno"></span></span>
</div>

<main>
	<h1>Overview</h1>
	<div class="small muted">{{ $event->title }} — {{ $report['title'] ?? 'Financial Report' }}</div>

	<div class="kpi-row">
		<div class="kpi">
			<div class="label">Paid attendees</div>
			<div class="value">{{ $report['totals']['attendees'] ?? 0 }}</div>
		</div>
		<div class="kpi">
			<div class="label">Registrations (completed, unpaid)</div>
			<div class="value">{{ $report['totals']['registrations'] ?? 0 }}</div>
		</div>
		<div class="kpi">
			<div class="label">Total revenue</div>
			<div class="value">€{{ number_format($report['totals']['revenue'] ?? 0, 2) }}</div>
		</div>
	</div>

	<section class="section">
		<h2>Tickets</h2>
		@php $tk = $report['tickets'] ?? ['labels'=>[], 'counts'=>[], 'totals'=>[], 'percentages'=>[]]; @endphp
		@if(!empty($tk['labels']))
			<table>
				<thead>
					<tr>
						<th style="width:55%">Ticket</th>
						<th style="width:15%">Quantity</th>
						<th style="width:15%">Value (€)</th>
						<th style="width:15%">%</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tk['labels'] as $i => $label)
						<tr>
							<td>{{ $label }}</td>
							<td>{{ $tk['counts'][$i] ?? 0 }}</td>
							<td>{{ number_format($tk['totals'][$i] ?? 0, 2) }}</td>
							<td>{{ $tk['percentages'][$i] ?? 0 }}%</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						@php $sumQty = array_sum($tk['counts'] ?? []); $sumVal = array_sum($tk['totals'] ?? []); @endphp
						<td>Total</td>
						<td>{{ $sumQty }}</td>
						<td>{{ number_format($sumVal, 2) }}</td>
						<td>100%</td>
					</tr>
				</tfoot>
			</table>

			<div class="bars">
				@php $maxVal = max(1, max($tk['totals'] ?: [0])); @endphp
				@foreach($tk['labels'] as $i => $label)
					@php
						$val = $tk['totals'][$i] ?? 0;
						$pctTrack = $maxVal ? round(($val / $maxVal) * 100) : 0;
					@endphp
					<div class="bar-row">
						<div class="bar-label">{{ $label }}</div>
						<div class="bar-track"><div class="bar-fill" style="width: {{ $pctTrack }}%;"></div></div>
						<div class="small">€{{ number_format($val, 2) }}</div>
					</div>
				@endforeach
			</div>
		@else
			<div class="small muted">No data.</div>
		@endif
	</section>

	<section class="section">
		<h2>Payment methods</h2>
		@php $pm = $report['payments'] ?? ['labels'=>[], 'counts'=>[], 'totals'=>[], 'percentages'=>[]]; @endphp
		@if(!empty($pm['labels']))
			<table>
				<thead>
					<tr>
						<th style="width:55%">Method</th>
						<th style="width:15%">Transactions</th>
						<th style="width:15%">Value (€)</th>
						<th style="width:15%">%</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pm['labels'] as $i => $label)
						<tr>
							<td>{{ $label }}</td>
							<td>{{ $pm['counts'][$i] ?? 0 }}</td>
							<td>{{ number_format($pm['totals'][$i] ?? 0, 2) }}</td>
							<td>{{ $pm['percentages'][$i] ?? 0 }}%</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						@php $sumTx = array_sum($pm['counts'] ?? []); $sumVal = array_sum($pm['totals'] ?? []); @endphp
						<td>Total</td>
						<td>{{ $sumTx }}</td>
						<td>{{ number_format($sumVal, 2) }}</td>
						<td>100%</td>
					</tr>
				</tfoot>
			</table>

			<div class="bars">
				@php $maxVal = max(1, max($pm['totals'] ?: [0])); @endphp
				@foreach($pm['labels'] as $i => $label)
					@php
						$val = $pm['totals'][$i] ?? 0;
						$pctTrack = $maxVal ? round(($val / $maxVal) * 100) : 0;
					@endphp
					<div class="bar-row">
						<div class="bar-label">{{ $label }}</div>
						<div class="bar-track"><div class="bar-fill" style="width: {{ $pctTrack }}%;"></div></div>
						<div class="small">€{{ number_format($val, 2) }}</div>
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
