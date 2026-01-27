<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<style>
  {!! branding_css('backend_admin') !!}
</style>

@vite(['resources/css/backend_admin/app.css', 'resources/js/backend/app.js'])

<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" />


@livewireStyles
<title>Eventscan demo platform</title>

@if(Route::is('login'))
<style>
    body {
        display: flex;
        height: 100vh;
        justify-content: center;
        align-items: center;
    }
</style>
@endif