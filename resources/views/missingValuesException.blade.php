<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
        @include('workshop::resources')

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script src="{{ asset('js/app.js') }}"></script>

        <title>Workshop - Error</title>
    </head>

    <body>
        <h1>Missing values in pattern</h1>
        <p><b>{{ $message }}</b></p>
        <p>
            You can define used variables in pattern templates in the corresponding markdown file.
            Use the frontmatter part to define a <code>values</code> property.
            See the following example:
        </p>
        <p>
            <code>
                ---<br>
                status: todo<br>
                values:<br>
                    &nbsp;&nbsp;&nbsp;todos:<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- eat<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- code<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- sleep<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- repeat<br>
                ---
            </code>
        </p>

        <p>For more information see <a href="https://oloid.ion2s.com/usage/use-pattern.html#replacing-dynamic-content" target="_blank">our documentation</a>.</p>

        @yield('workshop.scripts')
    </body>
</html>
