<!DOCTYPE html>
<html lang="en">

<head>
    @include('livewire.frontend.registration-form.partials.head')
</head>

<body class="text-center">
    @include('livewire.frontend.registration-form.partials.nav')

    <div class="content">
       {{ $slot }}
    </div>

    @include('livewire.frontend.partials.footer')
    @livewireScripts
</body>

</html>
