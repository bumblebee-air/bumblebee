<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Bumblebee')</title>

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/material-dashboard.min.css')}}" rel="stylesheet">
    <!--Sweet Alert-->
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    @if(Auth::user()->user_role == 'client' && Auth::user()->client && Auth::user()->client->name == 'GardenHelp')
        <link href="{{asset('css/gardenhelp_dashboard.css')}}" rel="stylesheet">
    @endif
    <!--DoOrder Custom Style-->
    @if(Auth::guard('doorder')->check())
        <link href="{{asset('css/doorder_dashboard.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand" />
    @endif
    <!--DoOrder Custom Style-->

    @yield('page-styles')
    <!-- Fonts -->
    @if(Auth::guard('web')->check())
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <!-- favicon -->
        <link rel="icon" type="image/jpeg" href="{{asset('images/bumblebee_favicon.jpg')}}">
    @endif
</head>

<body>

@include('sweet::alert')

<!-- Navigation -->


<!-- Page Content -->
<div class="wrapper">
    @include('partials.flash')
    @include('partials.admin_sidebar')
    <div class="main-panel">
        @yield('page-content')
    </div>
</div>

<!-- Scripts -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!--<script src="{{asset('js/popper.min.js')}}"></script>-->
<!--<script src="{{asset('js/ct-material/bootstrap-material-design.min.js')}}"></script>-->
<script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/moment-timezone.min.js')}}"></script>
<!--<script src="{{asset('js/ct-material/material-dashboard.min.js')}}"></script>-->
@yield('page-scripts')
</body>
</html>
