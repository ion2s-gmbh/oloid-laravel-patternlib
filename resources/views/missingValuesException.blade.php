<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

        <!-- Styles -->
        <link href='{{ asset('vendor/workshop/css/app.css') }}' rel='stylesheet' type='text/css'>

        <title>Workshop - Error</title>
    </head>

    <body>
        <h1>Missing values in pattern</h1>
        <p class="error">{{ $message }}</p>
        <p>
            You can define used variables in pattern templates in the corresponding markdown file.
            Use the frontmatter part to define a <code>values</code> property.
            See the following example:
        </p>
        <p>
            <code class="code">
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
    </body>
</html>
