<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nómina de Representantes</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/payroll.png')}}" >


</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top" style="background-color: #2d4373">

        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <img src="{{URL::asset('img/logotigo.png')}}" style="width: 80%">

            </div>


        </div>
    </nav>

    @yield('content')

</div>


<!-- Bootstrap 3.3.5 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('js/app.min.js')}}"></script>

<!-- Scripts -->
<!--<script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
