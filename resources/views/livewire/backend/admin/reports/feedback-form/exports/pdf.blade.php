<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 24mm 16mm 20mm 16mm; size: A4 portrait; }

    @page:first {
        margin: 0;
    }

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
    .cover-inner { padding: 0;padding-top:50mm; }
    .cover-logo { height: 16mm; margin-bottom: 8mm; }
    .cover-title { font-size: 18pt; font-weight: 700; margin: 0 0 6mm; }
    .cover-subtitle { font-size: 14pt; margin: 0 0 4mm;}
    .cover-meta { font-size: 10pt; opacity: .85; margin-top: 10mm; }

    /* KPIs */
    .kpi-row { display: flex; gap: 6mm; margin: 4mm 0 8mm; }
    .kpi { flex: 0 0 45mm; border:1px solid #e5e5e5; border-radius:4px; padding:3mm; }
    .kpi .label { font-size:9pt; color:#666; }
    .kpi .value { font-size:16pt; font-weight:700; }

    /* Grouping & blocks */
    .group { page-break-before: always; }
    .group:first-of-type { page-break-before: auto; }

    .question-block {
        border:1px solid #eee; border-radius:4px; padding:4mm; margin-bottom:5mm;
        page-break-inside: avoid;
    }
    .q-head { display:flex; justify-content:space-between; gap:4mm; }
    .q-title { font-weight:700; }
    .q-meta { font-size:9pt; color:#666; white-space: nowrap; }

    /* Tables */
    table { width:100%; border-collapse: collapse; margin-top:3mm; }
    th, td { border:1px solid #e5e5e5; padding:3mm; font-size:10pt; }
    th { background:#f8f8f8; text-align:left; }

    /* Bar visual (CSS-only, DomPDF safe) */
    .bars { margin-top:3mm; }
    .bar-row { display:flex; align-items:center; gap:3mm; margin:2mm 0; }
    .bar-label { width:45%; font-size:10pt; }
    .bar-track { flex:1; background:#f0f3f8; border-radius:3px; height:8px; overflow:hidden; }
    .bar-fill { height:8px; background:#d64227; }

    /* Text answers */
    .answers { margin-top:3mm; }
    .answers li { margin:1.5mm 0; font-size:10pt }
</style>
</head>
<body>

{{-- COVER PAGE --}}
<section class="cover">
    <div class="cover-inner">
        @if(!empty($logo_path))
            <img class="cover-logo" src="file://{{ $logo_path }}" alt="Logo">
        @endif
        <div class="cover-title">Feedback Report</div>
        <div class="cover-subtitle">{{ $report['form']['title'] }}</div>
        <div class="cover-subtitle">{{ $event->title }}</div>
    </div>
</section>

<div class="page-header">
    <span class="muted">
        {{ $event->title }} — {{ $report['form']['title'] }} • Exported {{ $exported_at ?? '' }}
    </span>
</div>

<div class="page-footer">
    <span class="muted">Feedback Report</span>
    <span style="float:right" class="muted">Page <span class="pageno"></span></span>
</div>



<main>
    <h1>Overview</h1>
    <div class="small muted">{{ $event->title }} — {{ $report['form']['title'] }}</div>

    <div class="kpi-row">
        <div class="kpi">
            <div class="label">In progress</div>
            <div class="value">{{ $report['totals']['in_progress'] }}</div>
        </div>
        <div class="kpi">
            <div class="label">Completed</div>
            <div class="value">{{ $report['totals']['complete'] }}</div>
        </div>
        <div class="kpi">
            <div class="label">Completion rate</div>
            <div class="value">{{ $report['totals']['completion_rate'] }}%</div>
        </div>
    </div>

    @foreach($report['groups'] as $group)
        <section class="group">
            <h2>{{ $group['title'] }}</h2>

            @forelse($group['questions'] as $q)
                <div class="question-block">
                    <div class="q-head">
                        <div class="q-title">{{ $q['question'] }}</div>
                        <div class="q-meta">Responses: {{ $q['total_answers'] }}</div>
                    </div>

                    @if(!empty($q['labels']))
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:55%">Option</th>
                                    <th style="width:15%">Count</th>
                                    <th style="width:15%">Percent</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($q['labels'] as $i => $label)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td>{{ $q['counts'][$i] ?? 0 }}</td>
                                    <td>{{ $q['percentages'][$i] ?? 0 }}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="bars">
                            @php $maxCount = max(1, max($q['counts'] ?: [0])); @endphp
                            @foreach($q['labels'] as $i => $label)
                                @php
                                    $count = $q['counts'][$i] ?? 0;
                                    $pctTrack = $maxCount ? round(($count / $maxCount) * 100) : 0;
                                @endphp
                                <div class="bar-row">
                                    <div class="bar-label">{{ $label }}</div>
                                    <div class="bar-track">
                                        <div class="bar-fill" style="width: {{ $pctTrack }}%;"></div>
                                    </div>
                                    <div class="small">Count: {{ $count }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        @if(!empty($q['samples']))
                            <ul class="answers">
                                @foreach($q['samples'] as $s)
                                    <li>{{ $s }}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="small muted">No responses.</div>
                        @endif
                    @endif
                </div>
            @empty
                <div class="small muted">No questions in this group.</div>
            @endforelse
        </section>
    @endforeach

</main>
</body>
</html>
