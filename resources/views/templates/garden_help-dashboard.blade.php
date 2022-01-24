<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">

<title>@yield('title', 'GardenHelp')</title>

<!-- Styles -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
<link href="{{asset('css/material-dashboard.min.css')}}"
	rel="stylesheet">
<link href="{{asset('css/main.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<!-- <link rel="stylesheet" href="{{asset('css/chartist.min.css')}}"> -->
<link rel="stylesheet"
	href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

<!--Sweet Alert-->
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
@if(Auth::guard('garden-help')->check())
<link rel="icon" type="image/jpeg"
	href="{{asset('images/garden-help-fav.png')}}">

<link
	href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap|Material+Icons"
	rel="stylesheet">

<link href="{{asset('css/gardenhelp-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/gardenhelp_dashboard.css')}}" rel="stylesheet">
<link href="{{asset('css/gaedenhelp-butttons-styles.css')}}"
	rel="stylesheet">

<link href="{{asset('css/gardenhelp-new-layout-styles.css')}}"
	rel="stylesheet">

<link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

@endif @yield('page-styles')

<link
	href="https://cdn.datatables.net/fixedcolumns/3.3.3/css/fixedColumns.dataTables.min.css"
	rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css">
</head>

<body class="menu-on-left">

	@include('sweet::alert')

	<!-- Navigation -->


	<!-- Page Content -->
	<div class="wrapper" id="app">
		@include('partials.flash')
		@include('partials.admin_sidebar_gardenhelp')
		<div class="main-panel">
			{{--navbar--}}
			<nav id="navbarTop"
				class="navbar navbar-expand-lg  navbar-absolute fixed-top">
				<div class="container-fluid">
					<div class="navbar-wrapper col-md-1">
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
					<div class="collapse navbar-collapse justify-content-end col-md-11">
						<div class="searchFormContainerDiv mr-auto" style="">
							<form class="form-inline navbar-form" style="">
								<div class="input-group input-group-search mx-auto">
									<div class="input-group-prepend">
										<button type="button"
											class="btn btn-default btnSearchDropdownNavbar dropdown-toggle font-weight-normal"
											data-toggle="dropdown">
											<span id="search_concept">All</span> <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<!-- <li><a></a></li> -->
										</ul>
									</div>
									<div class="form-outline">
										<input type="search" id="form1" class="form-control "
											placeholder="Search" aria-label="Search"
											aria-describedby="search-button-addon" />
									</div>
									<div class="input-group-append">
										<button type="button" class="btn btn-default btnSearchNavbar">
											<i class="fas fa-search"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item dropdown nav-item-icon-dropdown"><a
								class="nav-link navbarDropdownMenuLink" href=""
								id="navbarDropdownMenuLinkNotification" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false"> <img
									src="{{asset('images/gardenhelp/notification-nav-icon.png')}}" /> <span
									class="badge badge-light">4</span>
							</a>
								<div class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdownMenuLink" style="width: 300px">
									<ul class="list-group  list-group-flush">
										<li class="dropdown-item p-1  list-group-item"><a
											class=" mx-0 p-1 " href="#">
												<div class="row">
													<div class="col-2">
														<img
															src="{{asset('images/gardenhelp/notification-details-icon.png')}}"
															width="40px" />
													</div>
													<div class="col-10">
														<h5 class="notificationDetailNavH5">Job number #3849</h5>
														<p class="notificationDetailNavP">hasn’t been responded to
															in two days</p>
													</div>
												</div>
										</a></li>
										<li class="dropdown-item p-1 list-group-item"><a
											class=" mx-0 p-1 " href="#">
												<div class="row">
													<div class="col-2">
														<img
															src="{{asset('images/gardenhelp/notification-details-icon.png')}}"
															width="40px" />
													</div>
													<div class="col-10">
														<h5 class="notificationDetailNavH5">Job number #3849</h5>
														<p class="notificationDetailNavP">hasn’t been responded to
															in two days</p>
													</div>
												</div>
										</a></li>
									</ul>

									<!-- 									<a class="dropdown-item" href="#">Notification 1</a> <a -->
									<!-- 										class="dropdown-item" href="#">Notification 2</a> <a -->
									<!-- 										class="dropdown-item" href="#">Notification 3</a> -->
								</div></li>

							<li class="nav-item dropdown nav-item-icon-dropdown"><a
								class="nav-link navbarDropdownMenuLink" href=""
								id="navbarDropdownMenuLinkInbox" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false"> <img
									src="{{asset('images/gardenhelp/message-icon.png')}}" /> <span
									class="badge badge-light">2</span>
							</a>
								<div class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="#">Inbox 1</a>
								</div></li>

							<li class="nav-item dropdown nav-item-icon-dropdown"><a
								class="nav-link navbarDropdownMenuLink" href=""
								id="navbarDropdownMenuLinkCalendar" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false"> <img
									src="{{asset('images/gardenhelp/calendar-icon.png')}}" /> <span
									class="badge badge-light">60</span>
							</a>
								<div class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="#">order 1</a> <a
										class="dropdown-item" href="#">order 2</a> <a
										class="dropdown-item" href="#">order 3</a>
								</div></li>
							<li class="nav-item dropdown"><a href="#" class="nav-link"
								data-toggle="dropdown" id="navbarDropdownProfile">
									@if($user->logo)
									<div class="userLogoNavbarImg">
										<img class="rounded-circle article-img"
											src="{{asset('images/doorder-new-layout/calendar-grey.png')}}" />
									</div> @else
									<div class="userLogoNavbar">
										<span>{{explode(' ', $user->name)[0][0]}}</span>
									</div> @endif <!-- <div class="userLogoNavbar">{{explode(' ', $user->name)[0][0]}}</div> -->
									<p class="profileNameNavbar">{{$user->name}}</p>
									<p class="profileUserTypeNavbar">{{$user->user_role}}</p>
							</a>
								<div class="dropdown-menu dropdown-menu-right"
									aria-labelledby="navbarDropdownProfile">
									<a class="dropdown-item" href="{{url($guard_name.'/profile')}}">Edit
										Password</a> @if(auth()->user()->user_role == 'retailer') <a
										class="dropdown-item"
										href="{{url($guard_name.'/profile/edit')}}">Edit Profile</a>
									@endif
								</div></li>
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
<!-- 	<script src="{{asset('js/chartist.min.js')}}"></script> -->
	<script src="{{asset('js/jquery-ui.js')}}"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
	<script src="{{asset('js/select2.min.js')}}"></script>
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
	<script
		src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
	<!-- 	<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
 -->
 
	<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
	
    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
    
	{{--Socket & Vue server --}}
	<script src="{{asset('js/socket.io-3.0.1.min.js')}}"></script>
	<audio id="alert-audio" src="{{asset('audio/update.mp3')}}"></audio>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
	<link
		href="https://cdn.jsdelivr.net/npm/vue-toast-notification@0.6.2/dist/theme-sugar.css"
		rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/vue-toast-notification@0.6.2"></script>
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

	@if(Auth::guard('garden-help')->check() && Auth::user()->user_role !=
	'customer')
	<script>
        $('.sidebar').attr('data-background-color', 'white');
        //Socket Script
        let socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');
        // let socket = io.connect('http://localhost:8890');
        Vue.use(VueToast);

		socket.on('garden-help-channel:custom-notification'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
			let decodedData = JSON.parse(data);
			console.log(decodedData)
			let toast_title = decodedData.data.title;
			let url = decodedData.data.url;
			let user_id = parseInt("{{ auth()->user()->id }}");
			if(user_id == decodedData.data.id){
				Vue.$toast.success(toast_title, {
					// optional options Object
					position: 'top-right',
					duration: 3600000,

					onClick: () => {
						swal({
							// title: "Good job!",
							text: toast_title,
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
						}).then((input) => {
							if (input === 'view') {
								window.location.href = url;
							}
						});
					}
				});
				notificationAudio.play();
			}
		});

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
