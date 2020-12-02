<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=0.9, maximum-scale=1.0, minimum-scale=0.8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Axios CSRf Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DoOrder | Driver App</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>
        .access_location {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100%;
            background: #fefefe;
            z-index: 1000;
            display: none;
        }
        .access_location_text {
            position: absolute;
            width: 100px;
            height: 50px;
            top: 50%;
            left: 50%;
            margin-left: -100px;
            margin-top: -25px;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="access_location" class="access_location">
            <div class="access_location_text">Can't access your location</div>
        </div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

{{--    @if(config('app.env') == 'local')--}}
{{--        <script src="{{env('MIX_LOADER_URL')}}:35729/livereload.js"></script>--}}
{{--    @endif--}}
</body>
</html>
