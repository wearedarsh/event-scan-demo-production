<!DOCTYPE html>
<html lang="en">

<head>
    @include('livewire.frontend.registration-form.partials.head', ['page_title' => page_title])
</head>

<body class="text-center">

    <div class="content">
        @yield('content')
    </div>

    @include('livewire.frontend.registration-form.partials.footer')
    @livewireScripts
</body>

</html>
