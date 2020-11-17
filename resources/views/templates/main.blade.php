<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bumblebee</title>

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    @yield('page-styles')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- favicon -->
    <!--<link rel="icon" type="image/jpeg" href="{{asset('images/bumblebee_favicon.jpg')}}">-->
    <link rel="icon" type="image/jpeg" href="{{asset('images/doorder-favicon.svg')}}">
</head>

<body>

<!-- Navigation -->
@include('partials.nav')

<!-- Page Content -->
<div class="container">
    @include('partials.flash')

    @yield('page-content')
</div>

<!-- Scripts -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
@yield('page-scripts')
</body>
</html>