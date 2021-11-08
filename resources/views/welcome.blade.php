<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tabitantei 2</title>


    </head>
    <body>

        <div class="main_app" id="app">
            {{-- <router-link :to="{ name: 'main.index' }" class="text-sm font-medium">Login</router-link> --}}
            <router-view />
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>

    <style>
        body{
            background: url({{ URL::asset('images/green_bg.png') }}) no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</html>
