@if(config('app.env') === 'production')
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-69TZZC5BK1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-69TZZC5BK1');
  </script>
@endif

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  {!! branding_css('frontend') !!}
</style>
@vite(['resources/css/frontend/app.css', 'resources/js/frontend/app.js'])

<meta property="og:site_name" content="Eventscan demo site" />
<meta property="og:title" content="{{$og_title ?? 'Eventscan courses' }}" />
<meta property="og:description" content="{{$og_description  ?? 'Our upcoming courses'}}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="{{ asset('images/frontend/og-image.jpg') }}" />
<meta property="og:url" content="{{config('app.url')}}" />
<meta name="twitter:card" content="summary_large_image" />

<link rel="icon" type="image/svg+xml" href="{{ client_setting('branding.frontend.favicon.path') }}">

@livewireStyles
<title>{{ $page_title }}</title>