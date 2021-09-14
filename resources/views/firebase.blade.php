<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Firebase consulta</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}"/>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div id="app">
            <firebase-component></firebase-component>
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
<script>
    import FirebaseComponent from "../js/components/FirebaseComponent";
    export default {
        components: { FirebaseComponent }
    }
</script>
