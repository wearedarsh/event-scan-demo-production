@props(['id' => null])

@php
    $iframeId = $id ?? 'email-preview-' . uniqid();
@endphp

<iframe
    id="{{ $iframeId }}"
    class="w-full rounded-lg"
    sandbox
    style="min-height: 600px; width: 100%; border: 1px solid #ccc;"
    src="{{ route('admin.emails.preview', ['email_send' => $id]) }}"
></iframe>