<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="position-relative min-vh-100 d-flex flex-column align-items-center justify-content-center">
            @if (Route::has('login'))
                <div class="position-fixed top-0 end-0 p-3 text-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="fw-bold text-decoration-none text-dark">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-dark">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ms-4 fw-bold text-decoration-none text-dark">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Welcome') }}</div>

                            <div class="card-body">
                                {{ __('This is the welcome page.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>