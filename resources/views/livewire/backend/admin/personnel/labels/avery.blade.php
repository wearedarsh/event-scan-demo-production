<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  @page { margin: 0; size: A4; }
  html, body { margin: 0; padding: 0; }

  @font-face {
      font-family: 'NotoSans';
      font-weight: 400;
      font-style: normal;
      src: url("file://{{ resource_path('fonts/NotoSans-Regular.ttf') }}");
  }
  @font-face {
      font-family: 'NotoSans';
      font-weight: 700;
      font-style: normal;
      src: url("file://{{ resource_path('fonts/NotoSans-Bold.ttf') }}");
  }

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
    overflow: hidden;
    box-sizing: border-box;
  }

  .a6full {
    position: relative;
    width: 100%; height: 100%;
    text-align: center;
    color: #000;
    font-family: Arial, sans-serif;
  }
  .a6full__header {
    position: absolute; left: 0; top: 0; width: 100%;
    height: 31mm; background: #142b54; color: #fff;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    z-index: 1;
  }

  .a6full__logo { height: 16mm; margin-top: 8mm;margin-left:-2mm}
  .a6full__event { font-size: 16pt; line-height: 1; margin-top:-1mm;}

  .a6full__nameblock { padding-top: 34mm; }
  .a6full__name { font-family: 'NotoSans', sans-serif; font-weight: 700; font-size: 16pt; line-height: 1; }
  .a6full__name .line { display: block; line-height: 0.88; }

  .a6full__country { font-size: 12pt; margin-top: 1mm; }

  .a6full__qrwrap { margin: 6mm auto 0; width: 35mm; height: 35mm; }
  .a6full__qrwrap img { width: 35mm; height: 35mm; display: block; margin: 0 auto; }

  .a6full__band {
    position: absolute; left: 0; bottom: 0; width: 100%; height: 21mm;
    display: flex;align-items: center; justify-content: center;
    z-index: 1;
  }
  .a6full__band p {
    vertical-align: middle;
    margin: 0; margin-top:6mm; font-weight: 700; font-size: 18pt; letter-spacing: .4px;
  }
  .overlay {
    position: relative;
    width: 100%; height: 100%;
    text-align: center;
    color: #000;
    font-family: Arial, sans-serif;
    border: 0.1mm solid #ffffff;
  }
  .overlay__name { font-family: 'NotoSans', sans-serif; font-weight: 700; font-size: 16pt; margin-top:28mm;}
  .overlay__name .line { display: block; line-height: 0.88; }

  .overlay__country { font-size: 12pt; margin-top: 1mm; }

  .overlay__qrwrap { margin: 6mm auto 0; width: 35mm; height: 35mm; }
  .overlay__qrwrap img { width: 35mm; height: 35mm; display: block; margin: 0 auto; }

  .overlay__band {
    position: absolute; left: 0; bottom: 0; width: 100%; height: 21mm;
    display: flex;align-items: center; justify-content: center;
    z-index: 1;
  }
  .overlay__band p {
    vertical-align: middle;
    margin: 0; margin-top:6mm; font-weight: 700; font-size: 18pt; letter-spacing: .4px;
  }
</style>
</head>
<body>
  <div class="sheet">

    <div class="label">
      @if ($mode === 'a6_full')
        <div class="a6full" style="background:#fff;">
          <div class="a6full__header">
            <img class="a6full__logo" src="file://{{ $header_logo_url }}" alt="Logo" />
            <div class="a6full__event">{{$event_title}}</div>
          </div>

          <div class="a6full__nameblock">
            <div class="a6full__name">
              <span class="line">{{ $vm->first_name }}</span>
              <span class="line">{{ $vm->last_name }}</span>
            </div>
            <div class="a6full__country">{{ $vm->country }}</div>
          </div>

          <div class="a6full__qrwrap">
            @if(!empty($vm->qr_data))
              <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(600)->generate($vm->qr_data)) }}" alt="QR" />
            @endif
          </div>

          <div class="a6full__band" style="background: {{ $vm->group_color }}; color: {{ $vm->group_text_color }};">
            <p>{{ strtoupper($vm->group_label ?: 'GROUP') }}</p>
          </div>
        </div>

      @else
        <div class="overlay" style="background: #fff;">
          <div class="overlay__name">
            <span class="line">{{ $vm->line_1 }}</span>
            <span class="line">{{ $vm->line_2 }}</span>
            <span class="line">{{ $vm->line_3 }}</span>
          </div>

          <div class="overlay__band" style="background: {{ $vm->group_color }}; color: {{ $vm->group_text_color }};">
            <p>{{ strtoupper($vm->group_label ?: 'GROUP') }}</p>
          </div>
        </div>
      @endif
    </div>

  </div>
</body>
</html>
