<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('vendor/workshop/js/app.js') }}" defer></script>
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/prism.min.js"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif:700|Roboto+Mono" rel="stylesheet"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"
              integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">


        <!-- Styles -->
        <link href='{{ asset('vendor/workshop/css/app.css') }}' rel='stylesheet' type='text/css'>

        <script>
            const workshopUri = '{{ config('workshop.uri') }}'
        </script>

    </head>

    <body>

        <workshop-gui id="workshop"></workshop-gui>

    </body>

</html>