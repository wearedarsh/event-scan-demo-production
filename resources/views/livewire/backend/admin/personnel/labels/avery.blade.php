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

    .name {
        font-size: 18pt;
        font-weight: 700;
        line-height: 1.05;
        margin-top: 2mm;
    }

    .company {
        font-size: 14pt;
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
    height: 18mm;

    background: {{ $personnel->group_color }};
    color: {{ $personnel->group_text_color }};
    font-weight: 700;
    font-size: 16pt;
    line-height: 1;

    display: flex;
    align-items: center;
    justify-content: center;

    padding-top: 0; /* no need for padding when vertically centered */
}
</style>
</head>

<body>
<div class="sheet">

    <div class="label">

        <div class="name">
            @if($personnel->line_1) {{ $personnel->line_1 }}<br>@endif
            @if($personnel->line_2) {{ $personnel->line_2 }}<br>@endif
        </div>

        <div class="company">
            @if($personnel->line_3) {{ $personnel->line_3 }} @endif
        </div>

        @if(!empty($personnel->qr_data))
            <div>
                <img class="qr"
                     src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(600)->generate($personnel->qr_data)) }}">
            </div>
        @endif

        @if(!empty($personnel->group_label))
            <div class="band">
                {{ strtoupper($personnel->group_label) }}
            </div>
        @endif

    </div>

</div>
</body>
</html>
