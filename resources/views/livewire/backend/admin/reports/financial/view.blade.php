<div>
	<div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
		<h2 class="fs-4 text-brand-dark p-0 m-0">
			Financial Report
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
				<li class="breadcrumb-item active" aria-current="page">Financial</li>
			</ol>
		</nav>
	</div>

    

	<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3 ">
		<div class="row g-3 align-items-end mb-1">
			<div class="col-sm-3">
				<h5>Date from</h5>
				<input type="date" wire:model.live="date_from" class="form-control">
			</div>
			<div class="col-sm-3">
				<h5>Date to</h5>
				<input type="date" wire:model.live="date_to" class="form-control">
			</div>
		</div>

		<div class="flex-row d-flex flex-1 bg-white rounded-2">
			<div class="col-12">
				<h5>Tools</h5>
				<a href="{{ route('admin.events.reports.financial.pdf.export', [$event->id]) }}?date_from={{ $date_from }}&date_to={{ $date_to }}"
				class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
					<span class="cil-arrow-right me-2"></span>
					<span class="text-brand-light">Export PDF</span>
				</a>
				<a href="{{ route('admin.events.reports.payments.export', $event->id) }}?date_from={{ $date_from }}&date_to={{ $date_to }}"
					class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
						<span class="cil-spreadsheet me-2"></span> Export all payment data (XLSX)
				</a>
			</div>
		</div>

		<div class="row g-3 mt-2">
			<div class="col-sm-4">
				<div class="p-3 bg-body-tertiary border rounded-2">
					<div class="font-s text-muted">Paid attendees</div>
					<div class="fs-3">{{ $report['totals']['attendees'] ?? 0 }}</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="p-3 bg-body-tertiary border rounded-2">
					<div class="font-s text-muted">Registrations (Completed but unpaid)</div>
					<div class="fs-3">{{ $report['totals']['registrations'] ?? 0 }}</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="p-3 bg-body-tertiary border rounded-2">
					<div class="font-s text-muted">Total revenue</div>
					<div class="fs-3">€{{ number_format($report['totals']['revenue'] ?? 0, 2) }}</div>
				</div>
			</div>
		</div>
	</div>

	<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
		<h5 class="mb-3">Tickets</h5>
		<div class="row mt-2">
			<div class="col-md-6">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<span class="font-s text-muted">Quantity</span>
					<div class="d-flex gap-2">
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartJPG('chart-tickets-count','tickets-count.jpg')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPNG('chart-tickets-count','tickets-count.png')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPDF('chart-tickets-count','tickets-count.pdf')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span></a>
					</div>
				</div>
				<div class="chart-container" style="max-width:560px; height:340px;">
					<canvas id="chart-tickets-count" wire:ignore></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<ul class="mb-0">
					@php $tk = $report['tickets'] ?? ['labels'=>[],'counts'=>[],'totals'=>[]]; @endphp
					@foreach($tk['labels'] as $i => $label)
						<li class="font-m d-flex justify-content-between">
							<span>{{ $label }}</span>
							<span>
								<strong>{{ $tk['counts'][$i] ?? 0 }}</strong>
								<small class="text-muted"> • €{{ number_format($tk['totals'][$i] ?? 0, 2) }}</small>
							</span>
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-md-6">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<span class="font-s text-muted">Value</span>
					<div class="d-flex gap-2">
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartJPG('chart-tickets-value','tickets-value.jpg')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPNG('chart-tickets-value','tickets-value.png')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPDF('chart-tickets-value','tickets-value.pdf')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span></a>
					</div>
				</div>
				<div class="chart-container" style="max-width:560px; height:340px;">
					<canvas id="chart-tickets-value" wire:ignore></canvas>
				</div>
			</div>
		</div>
	</div>

	<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3 mb-5">
		<h5 class="mb-3">Payment methods</h5>
		<div class="row mt-2">
			<div class="col-md-6">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<span class="font-s text-muted">Total value</span>
					<div class="d-flex gap-2">
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartJPG('chart-payments-value','payments-value.jpg')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPNG('chart-payments-value','payments-value.png')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPDF('chart-payments-value','payments-value.pdf')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span></a>
					</div>
				</div>
				<div class="chart-container" style="max-width:560px; height:340px;">
					<canvas id="chart-payments-value" wire:ignore></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<ul class="mb-0">
					@php $pm = $report['payments'] ?? ['labels'=>[],'counts'=>[],'totals'=>[]]; @endphp
					@foreach($pm['labels'] as $i => $label)
						<li class="font-m d-flex justify-content-between">
							<span>{{ $label }}</span>
							<span>
								<strong>€{{ number_format($pm['totals'][$i] ?? 0, 2) }}</strong>
								<small class="text-muted"> • {{ $pm['counts'][$i] ?? 0 }}</small>
							</span>
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-md-6">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<span class="font-s text-muted">Count</span>
					<div class="d-flex gap-2">
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartJPG('chart-payments-count','payments-count.jpg')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPNG('chart-payments-count','payments-count.png')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span></a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center" onclick="downloadChartPDF('chart-payments-count','payments-count.pdf')"><span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span></a>
					</div>
				</div>
				<div class="chart-container" style="max-width:560px; height:340px;">
					<canvas id="chart-payments-count" wire:ignore></canvas>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
	<script>
	(function(){
		if(!window.demoCharts){ window.demoCharts = {}; }

		function renderChartsWith(chartConfigs){
			if(!Array.isArray(chartConfigs)) return;
			chartConfigs.forEach(c => {
				const el = document.getElementById(c.id);
				if(!el) return;
				if(window.demoCharts[c.id]) {
					window.demoCharts[c.id].destroy();
					delete window.demoCharts[c.id];
				}
				const cfg = {
					type: c.type,
					data: { labels: c.labels, datasets: [{ label: c.title, data: c.data }] },
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: { legend: { display: false }, tooltip: { enabled: true } },
						scales: {
							y: { beginAtZero: true, ticks: { precision: 0 }, suggestedMax: Math.max(5, Math.max.apply(null, c.data) || 0) },
							x: { ticks: { autoSkip: true, maxRotation: 45, minRotation: 0 } }
						}
					}
				};
				window.demoCharts[c.id] = new Chart(el, cfg);
			});
		}

		// Initial render on first load
		document.addEventListener('DOMContentLoaded', function(){
			renderChartsWith(@json($charts, JSON_UNESCAPED_UNICODE));
		});

		// Livewire v3 browser event on every rebuild
		window.addEventListener('financial-charts:update', function(e){
			// defer to allow DOM patching to settle (belt & braces)
			setTimeout(function(){
				renderChartsWith(e.detail && e.detail.charts ? e.detail.charts : []);
			}, 0);
		});

		// download helpers unchanged
		window.downloadChartPNG = function(canvasId, filename='chart.png'){
			const el = document.getElementById(canvasId);
			if(!el) return;
			const a = document.createElement('a');
			a.href = el.toDataURL('image/png', 1.0);
			a.download = filename;
			a.click();
		}
		window.downloadChartJPG = function(canvasId, filename='chart.jpg'){
			const src = document.getElementById(canvasId);
			if(!src) return;
			const tmp = document.createElement('canvas');
			tmp.width = src.width; tmp.height = src.height;
			const ctx = tmp.getContext('2d');
			ctx.fillStyle = '#ffffff'; ctx.fillRect(0,0,tmp.width,tmp.height);
			ctx.drawImage(src, 0, 0);
			const a = document.createElement('a');
			a.href = tmp.toDataURL('image/jpeg', 0.92);
			a.download = filename;
			a.click();
		}
		window.downloadChartPDF = async function(canvasId, filename='chart.pdf'){
			const el = document.getElementById(canvasId);
			if(!el) return;
			const { jsPDF } = window.jspdf;
			const pdf = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
			const imgData = el.toDataURL('image/png', 1.0);
			const pageWidth = pdf.internal.pageSize.getWidth();
			const pageHeight = pdf.internal.pageSize.getHeight();
			const margin = 24;
			const maxW = pageWidth - margin*2;
			const maxH = pageHeight - margin*2;
			const ratio = el.width / el.height;
			let w = maxW, h = w / ratio;
			if (h > maxH) { h = maxH; w = h * ratio; }
			pdf.addImage(imgData, 'PNG', (pageWidth - w)/2, (pageHeight - h)/2, w, h);
			pdf.save(filename);
		}
	})();
	</script>

</div>
