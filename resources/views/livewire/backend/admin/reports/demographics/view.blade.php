<div>
	<div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
		<h2 class="fs-4 text-brand-dark p-0 m-0">
			Demographics Report
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
				<li class="breadcrumb-item active" aria-current="page">Demographics</li>
			</ol>
		</nav>
	</div>

	<div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
		<div class="col-12">
			<h5>Tools</h5>
			<a href="{{ route('admin.events.reports.demographics.pdf.export', [$event->id]) }}"
			   class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
				<span class="cil-arrow-right me-2"></span>
				<span class="text-brand-light">Export PDF</span>
			</a>
		</div>
	</div>

	<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
		<h5 class="mb-3">Medical attendeeType</h5>
		<div class="row mt-2">
			<div class="col-md-6">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<span></span>
					<div class="d-flex gap-2">
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center"
						   onclick="downloadChartJPG('chart-attendeeType','attendeeType.jpg')">
							<span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span>
						</a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center"
						   onclick="downloadChartPNG('chart-attendeeType','attendeeType.png')">
							<span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span>
						</a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center"
						   onclick="downloadChartPDF('chart-attendeeType','attendeeType.pdf')">
							<span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span>
						</a>
					</div>
				</div>
				<div class="chart-container" style="max-width:560px; height:340px;">
					<canvas id="chart-attendeeType"></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<ul class="mb-0">
					@php $sp = $report['attendeeType']; @endphp
					@foreach($sp['labels'] as $i => $label)
						<li class="font-m d-flex justify-content-between">
							<span>{{ $label }}</span>
							<span><strong>{{ $sp['counts'][$i] ?? 0 }}</strong>
								<small class="text-muted">({{ $sp['percentages'][$i] ?? 0 }}%)</small></span>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>

	<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3 mb-5">
		<h5 class="mb-3">Country</h5>
		<div class="row mt-2">
			<div class="col-md-6">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<span></span>
					<div class="d-flex gap-2">
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center"
						   onclick="downloadChartJPG('chart-country','country.jpg')">
							<span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span>
						</a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center"
						   onclick="downloadChartPNG('chart-country','country.png')">
							<span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span>
						</a>
						<a href="javascript:void(0)" class="btn bg-brand-secondary d-inline-flex align-items-center"
						   onclick="downloadChartPDF('chart-country','country.pdf')">
							<span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span>
						</a>
					</div>
				</div>
				<div class="chart-container" style="max-width:560px; height:340px;">
					<canvas id="chart-country"></canvas>
				</div>
			</div>
			<div class="col-md-6">
				<ul class="mb-0">
					@php $ct = $report['country']; @endphp
					@foreach($ct['labels'] as $i => $label)
						<li class="font-m d-flex justify-content-between">
							<span>{{ $label }}</span>
							<span><strong>{{ $ct['counts'][$i] ?? 0 }}</strong>
								<small class="text-muted">({{ $ct['percentages'][$i] ?? 0 }}%)</small></span>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
	<script>
		function renderCharts(){
			if(!window.demoCharts){ window.demoCharts = {}; }
			const chartConfigs = @json($charts, JSON_UNESCAPED_UNICODE);
			chartConfigs.forEach(c => {
				const el = document.getElementById(c.id);
				if(!el) return;
				if(window.demoCharts[c.id]) window.demoCharts[c.id].destroy();
				const cfg = {
					type: c.type,
					data: {
						labels: c.labels,
						datasets: [{ label: 'Attendees', data: c.data }]
					},
					options: {
						responsive: true,
						maintainAspectRatio: false,
						plugins: { legend: { display: false }, tooltip: { enabled: true } },
						scales: {
							y: { beginAtZero: true, ticks: { precision: 0, stepSize: 1 }, suggestedMax: Math.max(5, Math.max.apply(null, c.data) || 0) },
							x: { ticks: { autoSkip: true, maxRotation: 45, minRotation: 0 } }
						}
					}
				};
				window.demoCharts[c.id] = new Chart(el, cfg);
			});
		}
		function downloadChartPNG(id,f='chart.png'){const e=document.getElementById(id);if(!e)return;const a=document.createElement('a');a.href=e.toDataURL('image/png',1.0);a.download=f;a.click();}
		function downloadChartJPG(id,f='chart.jpg'){const s=document.getElementById(id);if(!s)return;const c=document.createElement('canvas');c.width=s.width;c.height=s.height;const x=c.getContext('2d');x.fillStyle='#ffffff';x.fillRect(0,0,c.width,c.height);x.drawImage(s,0,0);const a=document.createElement('a');a.href=c.toDataURL('image/jpeg',0.92);a.download=f;a.click();}
		async function downloadChartPDF(id,f='chart.pdf'){const e=document.getElementById(id);if(!e)return;const { jsPDF }=window.jspdf;const pdf=new jsPDF({orientation:'landscape',unit:'pt',format:'a4'});const img=e.toDataURL('image/png',1.0);const pw=pdf.internal.pageSize.getWidth();const ph=pdf.internal.pageSize.getHeight();const m=24;const mw=pw-m*2;const mh=ph-m*2;const r=e.width/e.height;let w=mw,h=w/r;if(h>mh){h=mh;w=h*r}pdf.addImage(img,'PNG',(pw-w)/2,(ph-h)/2,w,h);pdf.save(f);}
		document.addEventListener('DOMContentLoaded', renderCharts);
		document.addEventListener('livewire:load', renderCharts);
		document.addEventListener('livewire:navigated', renderCharts);
	</script>
</div>
