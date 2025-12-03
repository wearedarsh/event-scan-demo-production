<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 0; size: A4; }
    html, body { margin: 0; padding: 0; }

    /* -------------------------
       FONTS (load from resources/fonts)
       ------------------------- */
    @font-face {
        font-family: 'NotoSans';
        font-style: normal;
        font-weight: 400;
        src: url("file://{{ resource_path('fonts/NotoSans-Regular.ttf') }}") format("truetype");
    }

    @font-face {
        font-family: 'NotoSans';
        font-style: normal;
        font-weight: 700;
        src: url("file://{{ resource_path('fonts/NotoSans-Bold.ttf') }}") format("truetype");
    }

    body { font-family: NotoSans, sans-serif; }

    .sheet {
        position: relative;
        width: 210mm;
        height: 297mm;
    }

    /* Positioned label box */
    .label {
        position: absolute;
        left: {{ $offset_x }}mm;
        top:  {{ $offset_y }}mm;
        width: {{ $label_w }}mm;
        height: {{ $label_h }}mm;
        box-sizing: border-box;
        overflow: hidden;
        border: 0.1mm solid transparent;
        text-align: center;
        padding-top: 2mm;
    }

    /* Main content */
    .name {
        font-size: {{ $label_h > 100 ? '18pt' : '14pt' }};
        font-weight: 700;
        line-height: 1.05;
    }

    .country {
        font-size: {{ $label_h > 100 ? '12pt' : '10pt' }};
        margin-top: 1mm;
    }

    .qr {
        width: 30mm;
        height: 30mm;
        margin: 3mm auto 0 auto;
    }

    .band {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 12mm;
        background: {{ $vm->group_color }};
        color: {{ $vm->group_text_color }};
        font-weight: bold;
        font-size: 14pt;
        line-height: 12mm;
        letter-spacing: .5px;
    }
</style>
</head>

<body>
<div class="sheet">

    <div class="label" style="border:1px solid #000000;">

        <div class="name">
            {{ $vm->first_name }}<br>
            {{ $vm->last_name }}
        </div>

        @if($vm->country)
            <div class="country">{{ $vm->country }}</div>
        @endif

        @if(!empty($vm->qr_data))
            <div>
                <img class="qr"
                     src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(600)->generate($vm->qr_data)) }}">
            </div>
        @endif

        <div class="band">
            {{ strtoupper($vm->group_label ?: 'GROUP') }}
        </div>

    </div>

</div>
</body>
</html>
