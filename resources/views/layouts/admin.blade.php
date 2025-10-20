<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/console-bsb.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css">
</head>
<body>
    @include('layouts.admin.header')

    <main id="main">
        @yield('content')
    </main>

    @include('layouts.admin.sidebar')
    @include('layouts.admin.footer')

    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world-merc.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.9/index.global.min.js"></script>
    <script src="{{ asset('assets/controller/console-bsb.js') }}"></script>
    <script src="{{ asset('assets/controller/chart-1.js') }}"></script>
    <script src="{{ asset('assets/controller/chart-3.js') }}"></script>
    <script src="{{ asset('assets/controller/chart-4.js') }}"></script>
    <script src="{{ asset('assets/controller/map-2.js') }}"></script>
    <script src="{{ asset('assets/controller/calendar-1.js') }}"></script>
</body>
</html>
