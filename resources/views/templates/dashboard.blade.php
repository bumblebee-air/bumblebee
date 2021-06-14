<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">

<title>@yield('title', 'Bumblebee')</title>

<!-- Styles -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
<link href="{{asset('css/main.css')}}" rel="stylesheet">
<link href="{{asset('css/material-dashboard.min.css')}}"
	rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('css/chartist.min.css')}}">
<link rel="stylesheet"
	href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

<!--Sweet Alert-->
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
@if(Auth::guard('garden-help')->check())
<link rel="icon" type="image/jpeg"
	href="{{asset('images/garden-help-fav.png')}}">
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
	rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
	rel="stylesheet">
<link href="{{asset('css/gardenhelp-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/gardenhelp_dashboard.css')}}" rel="stylesheet">
<link href="{{asset('css/gaedenhelp-butttons-styles.css')}}"
	rel="stylesheet">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet">

@endif
<!--DoOrder Custom Style-->
@if(Auth::guard('doorder')->check())
<link href="{{asset('css/doorder-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/doorder_dashboard.css')}}" rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
	rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
	rel="stylesheet">
<link rel="icon" type="image/jpeg"
	href="{{asset('images/doorder-favicon.svg')}}">
<!--         <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet"> -->
@endif
<!--DoomYoga Custom Style-->
@if(Auth::guard('doom-yoga')->check())
<link href="{{asset('css/doom-yoga-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/doom-yoga-butttons-styles.css')}}"
	rel="stylesheet">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
<!-- Fonts -->
<link
	href="https://fonts.googleapis.com/css2?family=Arbutus+Slab&display=swap"
	rel="stylesheet">

<!-- favicon -->
<link rel="icon" type="image/jpeg"
	href="{{asset('images/doom-yoga/doom-yoga-logo.png')}}">
@endif @if(Auth::guard('unified')->check())

<link href="{{asset('css/unified-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/unified-butttons-styles.css')}}"
	rel="stylesheet">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
<!-- Fonts -->
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
	rel="stylesheet">
<!-- favicon -->
<link rel="icon" type="image/jpeg"
	href="{{asset('images/unified/Slider-logo.png')}}">
@endif @yield('page-styles')

<!-- Fonts -->
@if(Auth::guard('web')->check())
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<!-- favicon -->
<link rel="icon" type="image/jpeg"
	href="{{asset('images/bumblebee_favicon.jpg')}}">
@endif
</head>

<body class="menu-on-left">

	@include('sweet::alert')

	<!-- Navigation -->


	<!-- Page Content -->
	<div class="wrapper" id="app">
		@include('partials.flash') @include('partials.admin_sidebar')
		<div class="main-panel">
			{{--navbar--}}
			<nav
				class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
				<div class="container-fluid">
					<div class="navbar-wrapper">
						<div class="navbar-minimize">
							<button id="minimizeSidebar"
								class="btn btn-just-icon btn-white btn-fab btn-round">
								<i
									class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
								<i
									class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
							</button>
						</div>
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse"
						aria-controls="navigation-index" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="sr-only">Toggle navigation</span> <span
							class="navbar-toggler-icon icon-bar"></span> <span
							class="navbar-toggler-icon icon-bar"></span> <span
							class="navbar-toggler-icon icon-bar"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end">
						<form class="navbar-form">
							<div class="input-group">
								<div class="">
									<button type="button" class="btn btn-default btnSearchDropdownNavbar dropdown-toggle"
										data-toggle="dropdown">
										<span id="search_concept">All</span> <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<!-- <li><a></a></li> -->
									</ul>
								</div>
								<div class="form-outline">
									<input type="search" id="form1"
										class="form-control inputSearchNavbar" placeholder="Search" />
								</div>
								<button type="button" class="btn btn-default btnSearchNavbar">
									<i class="fas fa-search"></i>
								</button>
							</div>
						</form>
						<ul class="navbar-nav">

							<li class="nav-item dropdown"><a class="nav-link" href=""
								id="navbarDropdownMenuLink" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false"> <i
									class="material-icons">notifications</i> <!-- <span class="notification"></span> -->
									<!-- <p class="d-lg-none d-md-block">Some Actions</p> -->
							</a> <!-- <div class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="#">Mike John responded to your
										email</a> <a class="dropdown-item" href="#">You have 5 new
										tasks</a> <a class="dropdown-item" href="#">You're now friend
										with Andrew</a> <a class="dropdown-item" href="#">Another
										Notification</a> <a class="dropdown-item" href="#">Another One</a>
								</div> --></li>
							<li class="nav-item dropdown"><a class="nav-link"
								href="javascript:;" id="navbarDropdownProfile"
								data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false"> <i class="material-icons">person</i>
										<p class="profileNameNavbar">{{$user->name}}</p>
							</a> <!-- <div class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdownProfile">
									<a class="dropdown-item" href="#">Profile</a> <a
										class="dropdown-item" href="#">Settings</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Log out</a>
								</div> --></li>
						</ul>
					</div>
				</div>
			</nav>
			{{--navbar--}} @yield('page-content')
		</div>
	</div>

	<!-- Scripts -->
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('js/popper.min.js')}}"></script>
	<!-- 	<script src="{{asset('js/ct-material/bootstrap-material-design.min.js')}}"></script>-->
	<script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
	<script src="{{asset('js/moment.min.js')}}"></script>
	<script src="{{asset('js/moment-timezone.min.js')}}"></script>
	<!-- 	<script src="{{asset('js/ct-material/material-dashboard.min.js')}}"></script> -->
	<script src="{{asset('js/chartist.min.js')}}"></script>
	<script src="{{asset('js/jquery-ui.js')}}"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
	<script src="{{asset('js/select2.min.js')}}"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>

	{{--Socket & Vue server --}}
	<script src="{{asset('js/socket.io-3.0.1.min.js')}}"></script>
	<audio id="alert-audio" src="{{asset('audio/update.mp3')}}"></audio>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
	<link
		href="https://cdn.jsdelivr.net/npm/vue-toast-notification/dist/theme-sugar.css"
		rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/vue-toast-notification"></script>
	<script>
	md = {
      misc: {
        navbar_menu_visible: 0,
        active_collapse: true,
        disabled_collapse_init: 0,
      },
       	initMinimizeSidebar: function() {

   		$('#minimizeSidebar').click(function() {
              var $btn = $(this);
        
              if (md.misc.sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                $("#adminNavLogoImg").css('width','100px!important');
                md.misc.sidebar_mini_active = false;
              } else {
                $('body').addClass('sidebar-mini');
                $("#adminNavLogoImg").css('width','40px!important');
                md.misc.sidebar_mini_active = true;
              }
        
              // we simulate the window Resize so the charts will get updated in realtime.
              var simulateWindowResize = setInterval(function() {
                window.dispatchEvent(new Event('resize'));
              }, 180);
        
              // we stop the simulation of Window Resize after the animations are completed
              setTimeout(function() {
                clearInterval(simulateWindowResize);
              }, 1000);
            });
  		},
  	}
    $(document).ready(function () {
      md.initMinimizeSidebar();
    
        $('.navbar-toggler').click(function () {
            // $('body').toggleClass('menu-on-left');
            // $(this).toggleClass('toggled');
            var mobile_menu_visible;
            var e;
            $toggle = $(this), mobile_menu_visible = 1 == mobile_menu_visible ? ($("html").removeClass("nav-open"), $(".close-layer").remove(), setTimeout(function() {
                $toggle.removeClass("toggled");
                $('body').removeClass('menu-on-left');
            }, 400), 0) : (setTimeout(function() {
                $toggle.addClass("toggled");
            }, 430), e = $('<div class="close-layer"></div>'), 0 != $("body").find(".main-panel").length ? e.appendTo(".main-panel") : $("body").hasClass("off-canvas-sidebar") && e.appendTo(".wrapper-full-page"), setTimeout(function() {
                e.addClass("visible")
            }, 100), e.click(function() {
                $("html").removeClass("nav-open"), mobile_menu_visible = 0, e.removeClass("visible"), setTimeout(function() {
                    e.remove(), $toggle.removeClass("toggled");
                }, 400)
            }), $("html").addClass("nav-open"), 1)
        });
    })
    let updateAudio = new Audio('{{asset("audio/update.mp3")}}');
    let notificationAudio = new Audio('{{asset("audio/notification.mp3")}}');
</script>

	@if(Auth::guard('doorder')->check() && auth()->user() &&
	auth()->user()->user_role != "retailer")
	<script>
        let socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');
        Vue.use(VueToast);

        socket.on('doorder-channel:new-order'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
            let decodedData = JSON.parse(data);
            let text = "There is a new order! with order No# " + decodedData.data.order_id;
            Vue.$toast.info('There is a new order.', {
                // optional options Object
                position: 'top-right',
                duration: 3600000,
                onClick: () => this.onClickToast(decodedData)
            });
            notificationAudio.play();
        });

        socket.on('doorder-channel:update-order-status'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
            let decodedData = JSON.parse(data);
            let text = "There is an order delivered No# " + decodedData.data.order_id;
            if (decodedData.data.status === 'delivery_arrived') {
                Vue.$toast.success('Delivery arrived.', {
                    // optional options Object
                    position: 'top-right',
                    duration: 3600000,

                    onClick: () => this.onClickToast(decodedData, text)
                });
            }
            notificationAudio.play();
        });
        function onClickToast(decodedData, text) {
            swal({
                // title: "Good job!",
                text: text,
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

        socket.on('garden-help-channel:new-customer-request'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
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
        socket.on('garden-help-channel:new-booked-service'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
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

        socket.on('garden-help-channel:new-contractor-request'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
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

        socket.on('garden-help-channel:update-job-status'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
            let decodedData = JSON.parse(data);
            console.log(decodedData)
            if (decodedData.data.status === 'ready' || decodedData.data.status === 'matched') {
                Vue.$toast.info(decodedData.data.toast_text, {
                    // optional options Object
                    position: 'top-right',
                    duration: 3600000,

                    onClick: () => this.onClickToast(decodedData)
                });
                notificationAudio.play();
            }
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
	@endif @yield('page-scripts')
</body>
</html>
