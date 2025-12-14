@props(['id' => null])

@php
    $iframeId = $id ?? 'email-preview-' . uniqid();
@endphp

<iframe
    id="{{ $iframeId }}"
    class="w-full border rounded"
    sandbox
    style="min-height: 400px; width: 100%; border: 1px solid #ccc;"
    src="{{ route('admin.emails.preview', $id) }}"
></iframe>

@once
<script>
document.addEventListener('DOMContentLoaded', function() {
    function resizeIframe(iframe) {
        try {
            iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
        } catch(e) {
            console.warn('Cannot resize iframe', e);
        }
    }

    document.querySelectorAll('iframe[id^="email-preview-"]').forEach(iframe => {
        iframe.onload = () => resizeIframe(iframe);
    });
});
</script>
@endonce
