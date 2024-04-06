<htm1>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ratings</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        @session('message')
            {{ session('message') }}
        @endsession
        {{ $slot }}
    </body>
</htm1>
