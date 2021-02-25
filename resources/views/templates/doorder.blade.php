<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=0.9, maximum-scale=1.0, minimum-scale=0.8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Axios CSRf Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#f7dc69">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#f7dc69">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#f7dc69">
    <link rel="icon" type="image/jpeg" href="{{asset('images/doorder-favicon.svg')}}">
    <title>DoOrder | @yield('title')</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome/all.css')}}">

    <!--Sweet Alert-->
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <!--Sweet Alert-->

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <style>
        body {
            font-family: Quicksand;
        }
    </style>
    @yield('styles')
</head>
<body>
@include('sweet::alert')
@yield('content')

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
{{--<script src="{{asset('js/popper.min.js')}}"></script>--}}
<script src="https://unpkg.com/@popperjs/core@2"></script>
@yield('scripts')
</body>
</html>
