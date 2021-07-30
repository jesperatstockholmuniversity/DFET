<!DOCTYPE html>
<html>
    <head>
        <title>
            DFet - Frontend
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        {{ Html::style('css/bootstrap.css') }}
        {{ Html::style('css/style.default.css') }}
        
    </head>

    <body class="signin pace-done">
        <!-- Container -->
        <div class="container">

            <section id="content">

            <!-- Content -->
            @yield('content')

        </div>

        {{ Html::script('js/jquery-1.11.1.min.js') }}
        {{ Html::script('js/bootstrap.min.js') }}

    </body>
</html>
