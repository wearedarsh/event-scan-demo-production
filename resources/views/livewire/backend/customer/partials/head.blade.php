<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
{!! branding_css('backend_customer') !!}
@vite(['resources/sass/backend_customer/app.scss', 'resources/js/backend/app.js'])

<link href="https://cdn.jsdelivr.net/npm/@coreui/icons/css/all.min.css" rel="stylesheet">

@livewireStyles
<title>{{client_setting('general.customer_friendly_name')}}</title>

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