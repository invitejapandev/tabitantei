<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tabitantei 2</title>


    </head>
    <body>

        <div  id="app">
            {{-- <router-link :to="{ name: 'main.index' }" class="text-sm font-medium">Login</router-link> --}}
            <router-view />
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
