<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

  @page { margin: 0; size: 86mm 126mm; }
  html, body { margin: 0; padding: 0; }

  .badge__punch {
    position: absolute;
    top: 6mm; /* 3mm bleed + 3mm from top */
    left: 50%;
    transform: translateX(-50%);
    width: 5mm;
    height: 5mm;
    border-radius: 50%;
    background: #fff;  /* white hole */
    /* Optional: thin outline for proofing; remove for print */
    box-shadow: 0 0 0 0.2mm rgba(255,255,255,0.9), 0 0 0 0.3mm rgba(0,0,0,0.35);
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
    height: 40mm; background: #142b54; color: #fff;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    z-index: 1;
  }

  .badge__logo { height: 14mm; margin-top: 10mm;margin-left:-2mm}
  .badge__event { text-align:center; font-size: 14pt; line-height: 1; margin-top:-0.5mm;color:#00C7B7;}
  .badge__location { font-size: 12pt; line-height: 0.7; margin-top:-3mm;}

</style>
</head>
<body>

  <div class="badge" style="background: {{ $bg_color }};">
    <div class="badge__header">
      <!-- <div class="badge__punch"></div> -->
      <img class="badge__logo" src="file://{{ $header_logo_url }}" alt="Logo" />
      <p class="badge__event">{{ $event_title }}</p>
      <!-- <p class="badge__location">{{ $event_location }}</p> -->
    </div>
  </div>

</body>
</html>
