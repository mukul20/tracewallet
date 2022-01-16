<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trace Wallet</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="{{ mix('/js/app.js') }}" defer></script>
        <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('/css/style.css') }}">
    </head>
    <body class="container">
        <div id="app">
            <h3>Trace Wallet</h3>
            <tracewallet-component></tracewallet-component>
        </div>
    </body>
</html>
