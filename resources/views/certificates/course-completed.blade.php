<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Certificate</title>
<style>
  @page { size: A4; margin: 0; }
  html, body { margin: 0; padding: 0; font-family: Arial, sans-serif; }

  @font-face {
      font-family: 'NotoSans';
      font-weight:400;
      font-style: normal;
      src: url("{{ resource_path('fonts/NotoSans-Regular.ttf') }}") format('truetype');
  }

  @font-face {
      font-family: 'NotoSans';
      font-weight:700;
      font-style: normal;
      src: url("{{ resource_path('fonts/NotoSans-Bold.ttf') }}") format('truetype');
  }

  .page-bg {
    position: fixed;
    top: 0; left: 0;
    width: 210mm; height: 297mm;
    z-index: 0;
  }

  .name, .paragraph, .afterparagraph {
    position: absolute;
    left: 25mm;
    width: 160mm;
    text-align: center;
    z-index: 1;
  }

  .name {
    top: 128mm;
    font-weight: 700; font-size: 18pt; font-family: 'NotoSans', sans-serif; 
  }

  .paragraph {
    top: 87mm;
    font-size: 11pt;
    line-height: 1.6;
  }

  .afterparagraph {
    top: 150mm;
    font-size: 11pt;
    line-height: 1.6;
  }
</style>
</head>
<body>
  <img class="page-bg" src="file://{{ $img_url }}" alt="background" />

  <div class="name">{{ $user_name }}</div>

  <div class="paragraph">
    {!! nl2br(e($body_text)) !!}
  </div>

  <div class="afterparagraph">
    {!! nl2br(e($after_text)) !!}
  </div>
</body>
</html>
