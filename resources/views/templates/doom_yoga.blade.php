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
    <link href="{{asset('css/doom-yoga-styles.css')}}" rel="stylesheet">
    <link href="{{asset('css/doom-yoga-butttons-styles.css')}}" rel="stylesheet">
     <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
   

    <!--Sweet Alert-->
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    <!--Sweet Alert-->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Arbutus+Slab&display=swap" rel="stylesheet">
    
    <!-- favicon -->
    <link rel="icon" type="image/jpeg" href="{{asset('images/doom-yoga/doom-yoga-logo.png')}}">


    @yield('styles')
</head>
<body>
@include('sweet::alert')
<div class="container-fluid h-100 p-0" id="containerPageBackgrundDiv">
@yield('content')
</div>
<!-- Scripts -->
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

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-toast-notification@0.6.2/dist/theme-sugar.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/vue-toast-notification@0.6.2"></script>

@yield('scripts')
</body>
</html>
