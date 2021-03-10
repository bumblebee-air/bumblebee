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
 	<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/chartist.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    
    <!--Sweet Alert-->
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
    @if(Auth::guard('garden-help')->check())
        <link href="{{asset('css/gardenhelp_dashboard.css')}}" rel="stylesheet">
        <link rel="icon" type="image/jpeg" href="{{asset('images/garden-help-fav.png')}}">    
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="{{asset('css/gardenhelp-styles.css')}}" rel="stylesheet">
    <link href="{{asset('css/gaedenhelp-butttons-styles.css')}}" rel="stylesheet">
     <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
        
    @endif
    <!--DoOrder Custom Style-->
    @if(Auth::guard('doorder')->check())
        <link href="{{asset('css/doorder-styles.css')}}" rel="stylesheet">
        <link href="{{asset('css/doorder_dashboard.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <link rel="icon" type="image/jpeg" href="{{asset('images/doorder-favicon.svg')}}">
<!--         <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet"> -->
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
<div class="wrapper" id="app">
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
<script src="{{asset('js/chartist.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

{{--Socket & Vue server --}}
<script src="{{asset('js/socket.io-3.0.1.min.js')}}"></script>
<audio id="alert-audio" src="{{asset('audio/update.mp3')}}"></audio>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-toast-notification/dist/theme-sugar.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/vue-toast-notification"></script>
<script>
    let updateAudio = new Audio('{{asset("audio/update.mp3")}}');
    let notificationAudio = new Audio('{{asset("audio/notification.mp3")}}');
</script>

@if(Auth::guard('doorder')->check() && auth()->user() && auth()->user()->user_role != "retailer")
    <script>
        let socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');
        Vue.use(VueToast);

        socket.on('doorder-channel:new-order', (data) => {
            let decodedData = JSON.parse(data);
            Vue.$toast.info('There is a new order.', {
                // optional options Object
                position: 'top-right',
                duration: 3600000,

                onClick: () => this.onClickToast(decodedData)
            });
            notificationAudio.play();
        });
        function onClickToast(decodedData) {
            swal({
                // title: "Good job!",
                text: "There is a new order! with order No# " + decodedData.data.order_id,
                icon: "info",
                buttons: {
                    accept: {
                        text: "View order",
                        value: "view",
                        className: 'btn btn-primary'
                    },
                    reject: {
                        text: "Close",
                        value: "cancel",
                        className: 'btn btn-default'
                    }
                }
            }).then(function (input) {
                if (input === 'view') {
                    console.log('View Page');
                }
            });
        }
    </script>
@elseif(Auth::guard('garden-help')->check())
    <script>
        $('.sidebar').attr('data-background-color', 'white');
        //Socket Script
        let socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');
        // let socket = io.connect('http://localhost:8890');
        Vue.use(VueToast);

        socket.on('garden-help-channel:new-customer-request', (data) => {
            let decodedData = JSON.parse(data);
            console.log(decodedData);
            Vue.$toast.info(decodedData.data.toast_text, {
                // optional options Object
                position: 'top-right',
                duration: 3600000,

                onClick: () => this.onClickToast(decodedData)
            });
            notificationAudio.play();
        });
        socket.on('garden-help-channel:new-booked-service', (data) => {
            let decodedData = JSON.parse(data);
            console.log(decodedData);
            Vue.$toast.info(decodedData.data.toast_text, {
                // optional options Object
                position: 'top-right',
                duration: 3600000,

                onClick: () => this.onClickToast(decodedData)
            });
            notificationAudio.play();
        });

        socket.on('garden-help-channel:new-contractor-request', (data) => {
            let decodedData = JSON.parse(data);
            console.log(decodedData);
            Vue.$toast.info(decodedData.data.toast_text, {
                // optional options Object
                position: 'top-right',
                duration: 3600000,

                onClick: () => this.onClickToast(decodedData)
            });
            notificationAudio.play();
        });

        function onClickToast(decodedData) {
            swal({
                text: decodedData.data.alert_text,
                icon: "info",
                buttons: {
                    accept: {
                        text: "View",
                        value: "view",
                        className: 'btn btn-primary'
                    },
                    reject: {
                        text: "Close",
                        value: "cancel",
                        className: 'btn btn-default'
                    }
                }
            }).then(function (input) {
                if (input === 'view') {
                    window.location = decodedData.data.click_link
                }
            });
        }
    </script>
@endif

@yield('page-scripts')
</body>
</html>
