<!DOCTYPE html>
<html lang="en">

<head>
    @include('livewire.frontend.partials.head')
</head>

<body class="text-center">

    <div class="content">
        @yield('content')
    </div>

    <!-- FOOTER SECTION -->
    @include('livewire.frontend.partials.footer')

</body>

</html>
@livewireScripts
<script>
    Livewire.on('storeToLocalStorage', ([payload]) => {
        const {
            registration_id,
            user_id
        } = payload;
        if (registration_id) {
            localStorage.setItem('registration_id', registration_id);
        }

        if (user_id) {
            localStorage.setItem('user_id', user_id);
        }
    });

    Livewire.on('removeFromLocalStorageAndRedirect', () => {

        localStorage.removeItem('registration_id');
        localStorage.removeItem('user_id');

        window.location.href = "{{ route('home') }}";
    });
</script>
<script>
    Livewire.hook('commit', ({ component, succeed }) => {
        succeed(() => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>