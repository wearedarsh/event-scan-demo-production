<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 0; size: A4; }
    html, body { margin: 0; padding: 0; }

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
        text-align: center;
        position: relative;
    }

    /* Main content */
    .name {
        font-size: 18pt;
        font-weight: 700;
        line-height: 1.05;
    }

    .country {
        font-size: 14pt;
        margin-top: 1mm;
    }

    .qr {
        width: 30mm;
        height: 30mm;
        margin: 3mm auto 0 auto;
    }

    .band {
        margin-top:5mm;
        width: 100%;
        height: 18mm;
        background: {{ $attendee->group_color }};
        color: {{ $attendee->group_text_color }};
        font-weight: bold;
        font-size: 16pt;
        line-height: 1;
        padding-top:2mm;
    }
</style>
</head>

<body>
<div class="sheet">

    <div class="label">

        <div class="name">
            {{ $attendee->first_name }}<br>
            {{ $attendee->last_name }}
        </div>

        @if($attendee->country)
            <div class="country">{{ $attendee->country }}</div>
        @endif

        @if(!empty($attendee->qr_data))
            <div>
                <img class="qr"
                     src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(600)->generate($attendee->qr_data)) }}">
            </div>
        @endif

        @if(!empty($attendee->group_label))
            <div class="band">
                {{ strtoupper($attendee->group_label) }}
            </div>
        @endif
        
    </div>

</div>
</body>
</html>
