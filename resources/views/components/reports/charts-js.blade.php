@props([
    'charts' => [],
    'event' => null,
])

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    window.ReportCharts.render(@json($charts));
});

@if($event)
    window.addEventListener('{{ $event }}', (e) => {
        setTimeout(() => {
            window.ReportCharts.render(e.detail.charts || []);
        }, 0);
    });
@endif
</script>
