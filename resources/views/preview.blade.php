<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        @include('workshop::resources')

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script src="{{ asset('js/app.js') }}"></script>

        <title>Workshop - Preview</title>
    </head>

    <body>
        {!! $preview !!}

        @yield('workshop.scripts')
    </body>
</html>
