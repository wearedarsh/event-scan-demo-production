<!doctype html>
<html lang="en">
    <head>
        @include('partials.head')
        <style>
            body {
                display: flex;
                height: 100vh;
                justify-content: center;
                align-items: center;
            }
        </style>
        <title>Login</title>
    </head>
    <body class="p-3 bg-brand-secondary">
        <div class="login-card">
            {{ $slot }}
        </div>
    </body>
</html>
