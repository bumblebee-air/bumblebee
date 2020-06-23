<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bumblebee - @yield('title')</title>

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/material-kit.min.css')}}" rel="stylesheet">
    @yield('page-styles')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <!-- favicon -->
    <link rel="icon" type="image/jpeg" href="{{asset('images/bumblebee_favicon.jpg')}}">
</head>

<body>

<!-- Navigation -->
@include('partials.bumblebee_public_nav')

<!-- Page Content -->
<div class="container">
    @include('partials.flash')

    @yield('page-content')
</div>

<!-- Scripts -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap-material-design.min.js')}}"></script>
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/moment-timezone.min.js')}}"></script>
@yield('page-scripts')
</body>
</html>