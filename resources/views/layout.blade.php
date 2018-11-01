<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('vendor/ion2s/laratomics-workshop/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    {{--<link href="{{ asset('vendor/ion2s/laratomics-workshop/css/app.css') }}" rel="stylesheet">--}}
    {{--<link href='{{mix('app.css', 'vendor/laratomics-workshop')}}' rel='stylesheet' type='text/css'>--}}
    <link href='{{ asset('vendor/ion2s/laratomics-workshop/css/app.css') }}' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
