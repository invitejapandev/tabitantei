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
        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent.woff") format('woff');
        }

        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent-Bold.woff") format('woff');
            font-weight: bold;
        }

        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent-Bold-Italic.woff") format('woff');
            font-weight: bold;
            font-style: italic;
        }

        @font-face {
            font-family: "CA-Geheimagent";
            src: url("fonts/CA-Geheimagent-Italic.woff") format('woff');
            font-style: italic;
        }


        body{
            background: url({{ URL::asset('images/green_bg.png') }}) no-repeat center center fixed;
            background-size: cover;
            font-family: CA-Geheimagent
        }
    </style>
</html>
