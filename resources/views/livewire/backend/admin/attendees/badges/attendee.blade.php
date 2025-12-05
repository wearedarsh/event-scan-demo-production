<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

  @page { margin: 0; size: 86mm 126mm; }
  html, body { margin: 0; padding: 0; }

  @font-face {
      font-family: 'NotoSans';
      font-weight:400;
      font-style: normal;
      src: url("file://{{ resource_path('fonts/NotoSans-Regular.ttf') }}") format('truetype');
  }

  @font-face {
      font-family: 'NotoSans';
      font-weight:700;
      font-style: normal;
      src: url("file://{{ resource_path('fonts/NotoSans-Bold.ttf') }}") format('truetype');
  }

  .badge__punch {
    position: absolute;
    top: 6mm; /* 3mm bleed + 3mm from top */
    left: 50%;
    transform: translateX(-50%);
    width: 5mm;
    height: 5mm;
    border-radius: 50%;
    background: #fff;  /* white hole */
    /* Optional: thin outline for proofing; remove for print 
    box-shadow: 0 0 0 0.2mm rgba(255,255,255,0.9), 0 0 0 0.3mm rgba(0,0,0,0.35);*/
    z-index: 2;
  }


  .badge {
    position: relative;
    width: 85.9mm; height: 125.9mm;
    page-break-after: always;
    font-family: Arial, sans-serif;
    color: #000; text-align: center;
  }

  .badge__header {
    position: absolute; left: 0; top: 0; width: 100%;
    height: 40mm; background: #142B54; color: #fff;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    z-index: 1;
  }

  .badge__logo { height: 16mm; margin-top: 10mm;margin-left:-2mm}
  .badge__event { font-size: 16pt; line-height: 1; margin-top:-1mm;}
  .badge__location { font-size: 12pt; line-height: 0.7; margin-top:-3mm;}

  .badge__groupband {
    position: absolute; left: 0; bottom: 0; width: 100%; height: 18mm;
    display: flex;align-items: center; justify-content: center;
    z-index: 1;
  }

  .badge__groupband p {
    vertical-align: middle;
    margin: 0; margin-top:2mm; font-weight: 700; font-size: 18pt; letter-spacing: .4px;
  }
 
  .badge__nameblock { padding-top: 42mm; }
  .badge__name    { font-weight: 700; font-size: 19pt; font-family: 'NotoSans', sans-serif; }

  .badge__name .name-line {
    display: block;
    margin: 0;
    line-height: 0.75;
  }
  .badge__country { font-size: 14pt; margin-top: .5mm; }

  .badge__qrwrap   { margin: 4mm auto 0; width: 35mm; height: 35mm; }
  .badge__qrwrap img { width: 35mm; height: 35mm; display: block; margin: 0 auto; }

</style>
</head>
<body>

@foreach ($badges as $attendee)
  <div class="badge" style="background: {{ $attendee->bg_color }};">
    <div class="badge__header">
      <!-- <div class="badge__punch"></div> -->
      <img class="badge__logo" src="file://{{ $header_logo_url }}" alt="EVF HOW" />
      <p class="badge__event">{{ $event_title }}</p>
      <p class="badge__location">{{ $event_location }}</p>
    </div>

      <div class="badge__nameblock">
        <div class="badge__name">
          <span class="name-line">{{ $attendee->first_name }}</span>
          <span class="name-line">{{ $attendee->last_name }}</span>
        </div>
        <div class="badge__country">{{ $attendee->country }}</div>
      </div>

      <div class="badge__qrwrap">
        <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(600)->generate($attendee->qr_data)) }}" alt="QR" />
      </div>

    <div class="badge__groupband" style="background-color:{{$attendee->group_color}}">
      <p style="color:{{$attendee->group_text_color}}">{{ strtoupper($attendee->group_label) }}</p>
    </div>
  </div>
@endforeach

</body>
</html>
