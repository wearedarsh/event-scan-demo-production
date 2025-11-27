<!DOCTYPE html>
<html lang="en">
<head>
    @include('livewire.auth.partials.head')
</head>
<body 
  class="min-h-screen flex flex-col items-center justify-center bg-[var(--color-bg)] text-[var(--color-text)] bg-cover bg-center px-4" 
  style="background-image:url('{{ asset('images/frontend/header-bg.jpg') }}');"
>
    {{ $slot }}
</body>
</html>
