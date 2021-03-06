<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/material-dashboard.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/gardenhelp-styles.css')}}" rel="stylesheet">
    <link href="{{asset('css/gaedenhelp-butttons-styles.css')}}" rel="stylesheet">
     <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
   

    <!--Sweet Alert-->
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <!--Sweet Alert-->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
<!--     <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> -->
    
    <!-- favicon -->
    <link rel="icon" type="image/jpeg" href="{{asset('images/garden-help-fav.png')}}">

{{--    <link rel="stylesheet" href="{{asset('css/bootstrap-4-datetimepicker.css')}}"/>--}}

    @yield('styles')
</head>
<body>
@include('sweet::alert')

<div id="app">
    @yield('content')
</div>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/ct-material/bootstrap-material-design.min.js')}}"></script>
<script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/moment-timezone.min.js')}}"></script>
<script src="{{asset('js/ct-material/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('js/ct-material/material-dashboard.min.js')}}"></script>
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script src="{{asset('js/select2.min.js')}}"></script>

{{--<script src="http://demos.creative-tim.com/material-kit/assets/js/material.min.js"></script>--}}
{{--<script src="http://demos.creative-tim.com/material-kit/assets/js/material-kit.js"></script>--}}
@yield('scripts')
</body>
</html>
