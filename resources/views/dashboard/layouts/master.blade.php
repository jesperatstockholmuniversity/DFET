<!DOCTYPE html>
<html>
    <head>
        <title>
            DFet - Frontend
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/style.default.css') }}
        
    </head>

    <body class="signin pace-done">
        <!-- Container -->
        <div class="container">

            <section id="content">

            <!-- Content -->
            @yield('content')

        </div>

        {{ HTML::script('js/jquery-1.11.1.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}

    </body>
</html>