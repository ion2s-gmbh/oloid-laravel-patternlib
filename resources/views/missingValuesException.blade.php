<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

        <!-- Styles -->
        <link href='{{ asset('vendor/workshop/css/app.css') }}' rel='stylesheet' type='text/css'>

        <title>Workshop - Error</title>

    </head>

    <body class="preview-message">

        <p class="error">{{ $message }}</p> 
        
        <p>
            This error might occur when you are calling a variable that has not been defined yet. 
        </p>        

        <p>
            You can define variables directly in the corresponding markdown file of a pattern-template.
            <br>Use the frontmatter part to define a <code class="codeblock--inline">$values</code> property.
            See the following example:
        </p>

        <code class="codeblock">
            
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

        <p>For more information see <a href="https://oloid.ion2s.com/usage/use-pattern.html#replacing-dynamic-content" target="_blank" rel="external">our documentation</a>.</p>

    </body>
</html>
