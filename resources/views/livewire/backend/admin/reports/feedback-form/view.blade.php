<div>
	<div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
		<h2 class="fs-4 text-brand-dark p-0 m-0">Feedback Report<br><span class="font-m">{{ $report['form']['title'] }}</span></h2>
	</div>

	<div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mt-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb d-flex flex-row align-items-center">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{ $event->title }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.reports.index', $event->id) }}">Reports</a></li>
				<li class="breadcrumb-item"><a href="{{ route('admin.events.reports.feedback.index', ['event'=>$event->id]) }}">Feedback</a></li>
				<li class="breadcrumb-item active" aria-current="page">View</li>
			</ol>
		</nav>
	</div>

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3 mb-3">
        <div class="col-12">
            <h5>Tools</h5>
            <a href="{{ route('admin.events.reports.feedback.pdf.export', [$event->id, $feedback_form->id]) }}"
               class="btn bg-brand-secondary d-inline-flex align-items-center mb-2">
                <span class="cil-arrow-right me-2"></span>
                <span class="text-brand-light">Export PDF</span>
            </a>
        </div>
    </div>

    <div class="row g-3 flex-1 bg-white rounded-2 p-3 mt-3 mb-3">
        <div class="col-sm-3">
            <div class="p-3 bg-body-tertiary border rounded-2">
                <div class="font-s text-muted">In progress</div>
                <div class="fs-3">{{ $report['totals']['in_progress'] }}</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="p-3 bg-body-tertiary border rounded-2">
                <div class="font-s text-muted">Completed</div>
                <div class="fs-3">{{ $report['totals']['complete'] }}</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="p-3 bg-body-tertiary border rounded-2">
                <div class="font-s text-muted">Completion rate</div>
                <div class="fs-3">{{ $report['totals']['completion_rate'] }}%</div>
            </div>
        </div>
    </div>

	<div class="flex-column d-flex p-3 bg-white rounded-2 mt-3 mb-5">
        @forelse($report['groups'] as $group)
            <h3 class="fs-5 mt-4 mb-3">{{ $group['title'] }}</h3>

            @forelse($group['questions'] as $q)
                <div class="border rounded-2 p-3 mb-3">
                    <div class="fw-semibold">{{ $q['question'] }}</div>
                    <div class="font-s text-muted mt-1">Responses: {{ $q['total_answers'] }}</div>

                    @if(!empty($q['labels']))
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span></span>
                                    <div class="d-flex gap-2">
                                        <a href="javascript:void(0)"
                                           class="btn bg-brand-secondary d-inline-flex align-items-center"
                                           onclick="downloadChartJPG('chart-q-{{ $q['id'] }}','q{{ $q['id'] }}.jpg')">
                                            <span class="cil-cloud-download me-2"></span><span class="text-brand-light">JPG</span>
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="btn bg-brand-secondary d-inline-flex align-items-center"
                                           onclick="downloadChartPNG('chart-q-{{ $q['id'] }}','q{{ $q['id'] }}.png')">
                                            <span class="cil-cloud-download me-2"></span><span class="text-brand-light">PNG</span>
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="btn bg-brand-secondary d-inline-flex align-items-center"
                                           onclick="downloadChartPDF('chart-q-{{ $q['id'] }}','q{{ $q['id'] }}.pdf')">
                                            <span class="cil-cloud-download me-2"></span><span class="text-brand-light">PDF</span>
                                        </a>
                                    </div>
                                </div>

                                {{-- Auto-height canvas: 28px per label (min 180px) --}}
                                @php $h = max(180, count($q['labels']) * 28); @endphp
                                <div class="chart-container" style="max-width:520px;">
                                    <canvas id="chart-q-{{ $q['id'] }}" height="{{ $h }}"></canvas>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <ul class="mb-0">
                                    @foreach($q['labels'] as $i => $label)
                                        <li class="font-m d-flex justify-content-between">
                                            <span>{{ $label }}</span>
                                            <span>
                                                <strong>{{ $q['counts'][$i] ?? 0 }}</strong>
                                                <small class="text-muted">({{ $q['percentages'][$i] ?? 0 }}%)</small>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        @if(!empty($q['samples']))
                            <ul class="mt-2 mb-0">
                                @foreach($q['samples'] as $s)
                                    <li class="font-m">{{ $s }}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="mt-2 font-m text-muted">No responses.</div>
                        @endif
                    @endif
                </div>
            @empty
                <div class="text-muted font-m">No questions in this group.</div>
            @endforelse
        @empty
            <div class="text-muted font-m">No groups or questions found.</div>
        @endforelse
    </div>

    {{-- Chart.js + jsPDF --}}
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

    <script>
        function renderCharts(){
            if(!window.feedbackCharts){ window.feedbackCharts = {}; }

            // Take your existing $charts, but we’ll force them to horizontal bars
            const chartConfigs = @json($charts, JSON_UNESCAPED_UNICODE);

            chartConfigs.forEach(c => {
                const id = 'chart-q-' + c.question_id;
                const el = document.getElementById(id);
                if(!el) return;

                // Destroy if re-rendering
                if(window.feedbackCharts[id]) window.feedbackCharts[id].destroy();

                // Determine max for clean integer ticks
                const maxVal = Math.max(1, ...(c.data || [0]));

                const cfg = {
                    type: 'bar',
                    data: {
                        labels: c.labels,
                        datasets: [{
                            label: 'Responses',
                            data: c.data
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y', // horizontal bars (linear)
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    stepSize: 1
                                },
                                suggestedMax: Math.max(5, maxVal)
                            },
                            y: {
                                ticks: { autoSkip: false }
                            }
                        },
                        layout: { padding: 4 }
                    }
                };

                window.feedbackCharts[id] = new Chart(el, cfg);
            });
        }

        function downloadChartPNG(canvasId, filename='chart.png'){
            const el = document.getElementById(canvasId);
            if(!el) return;
            const link = document.createElement('a');
            link.href = el.toDataURL('image/png', 1.0);
            link.download = filename;
            link.click();
        }

        function downloadChartJPG(canvasId, filename='chart.jpg'){
            const src = document.getElementById(canvasId);
            if(!src) return;

            const tmp = document.createElement('canvas');
            tmp.width = src.width;
            tmp.height = src.height;
            const ctx = tmp.getContext('2d');

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, tmp.width, tmp.height);
            ctx.drawImage(src, 0, 0);

            const link = document.createElement('a');
            link.href = tmp.toDataURL('image/jpeg', 0.92);
            link.download = filename;
            link.click();
        }

        async function downloadChartPDF(canvasId, filename='chart.pdf'){
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

            const canvasRatio = el.width / el.height;
            let drawW = maxW, drawH = drawW / canvasRatio;
            if (drawH > maxH) { drawH = maxH; drawW = drawH * canvasRatio; }

            pdf.addImage(imgData, 'PNG', (pageWidth - drawW)/2, (pageHeight - drawH)/2, drawW, drawH);
            pdf.save(filename);
        }

        document.addEventListener('DOMContentLoaded', renderCharts);
        document.addEventListener('livewire:load', renderCharts);
        document.addEventListener('livewire:navigated', renderCharts);
    </script>
</div>
