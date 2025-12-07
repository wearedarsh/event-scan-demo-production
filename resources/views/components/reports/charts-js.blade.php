@props(['charts' => [], 'event' => null])

<script>
queueMicrotask(() => {
    if (window.ReportCharts) {
        window.ReportCharts.render(@json($charts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT));
    }
});
</script>

@if($event)
<script>
window.addEventListener('{{ $event }}', e => {
    queueMicrotask(() => {
        if (window.ReportCharts) {
            window.ReportCharts.render(e.detail.charts || []);
        }
    });
});
</script>
@endif
