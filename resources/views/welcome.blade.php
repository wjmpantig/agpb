<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>


        <link rel="stylesheet" type="text/css" href="css/app.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body >
        <div id="app">
            <section class="hero is-dark is-fullheight">
                <div class="hero-body">
                    <div class="container">
                        <h1 class="title">Hello world!</h1>
                    </div>
                </div>
            </section>

        </div>
      
        <script src="js/app.js"></script>
     
    </body>
</html>
