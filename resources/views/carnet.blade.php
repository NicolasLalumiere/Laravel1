<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME') }}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #2769b0;
            color: rgb(255, 255, 255);
            text-align: center;
        }

        body {
            background-color: hsl(0, 0%, 96%)
        }
    </style>
</head>

<body>

    @if (Auth::check())
        @php
            $user_auth_data = [
                'isLoggedin' => true,
                'user' => Auth::user(),
            ];
        @endphp
    @else
        @php
            $user_auth_data = [
                'isLoggedin' => false,
            ];
        @endphp
    @endif
    <script>
        window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
    </script>

    <div id="app">
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

    <div class="text-center footer">
        <h6>Site monopage créé avec Laravel 8 et Vue js</h6>
        <h6>Cours: Applications Web trensactionnelles</h6>
        <h6>Crée par: Nicolas Lalumiere</h6>
    </div>
</body>

</html>
