<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
        @include('workshop::dependencies')

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script src="{{ asset('js/app.js') }}"></script>

        <title>Workshop - Preview</title>
    </head>

    <body>
        {!! $preview !!}

        @yield('workshop.body')
    </body>
</html>
