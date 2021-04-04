<div class="sidebar" data-color="rose" data-background-color="black">
	<!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
    -->
	@if(($user_type == 'client' || $user_type == 'retailer') &&
	$admin_nav_logo!=null)
	<div class="user" style="z-index: 3">
		<div class="photo photo-full text-center">
			<img src="{{asset($admin_nav_logo)}}" title="{{$admin_client_name}}"
				alt="{{$admin_client_name}}" id="adminNavLogoImg" />
		</div>
		<div class="user-info">
			<a href="{{url('/')}}" class="username"> <span> </span>
			</a>
		</div>
	</div>
	@else
	<div class="logo">
		<a href="{{url('/')}}" class="simple-text logo-mini"> @if($user_type
			== 'client' || $user_type == 'retailer') {{$admin_client_name[0]}}
			@else BB @endif </a> <a href="{{url('/')}}"
			class="simple-text logo-normal"> @if($user_type == 'client' ||
			$user_type == 'retailer') {{$admin_client_name}} @else Bumblebee
			@endif </a>
	</div>
	@endif
	<div class="sidebar-wrapper">
		<!--<div class="user">
            <div class="photo">
                <img src="../assets/img/faces/avatar.jpg" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                Tania Andrew
                <b class="caret"></b>
              </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> My Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> Edit Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> S </span>
                                <span class="sidebar-normal"> Settings </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>-->
		@if(Auth::guard('web')->check())
		<ul class="nav">
			<li class="nav-item"><a class="nav-link" href="{{url('/')}}"> <i
					class="fas fa-chart-bar"></i>
					<p>Dashboard</p>
			</a></li>
			<!--<li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                        <i class="material-icons">image</i>
                        <p> Pages
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="pagesExamples">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="../examples/pages/pricing.html">
                                    <span class="sidebar-mini"> P </span>
                                    <span class="sidebar-normal"> Pricing </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="../examples/pages/rtl.html">
                                    <span class="sidebar-mini"> RS </span>
                                    <span class="sidebar-normal"> RTL Support </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>-->
			@if(!empty(Auth::user()) && Auth::user()->user_role == 'client')
			<li class="nav-item "><a class="nav-link"
				href="{{url('whatsapp-templates')}}"> <i
					class="fab fa-whatsapp-square"></i>
					<p>WhatsApp Templates</p>
			</a></li>
			<li class="nav-item "><a class="nav-link"
				href="{{url('general-enquiry')}}"> <i class="fas fa-question-circle"></i>
					<p>General Enquiries</p>
			</a></li> @else

			<li class="nav-item "><a class="nav-link" data-toggle="collapse"
				href="#customer"> <i class="fas fa-user"></i>
					<p>
						Customers <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="customer">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link"
							href="{{url('create-customer')}}"> <i class="fas fa-user"></i>
								<p>Add Customer</p>
						</a></li>
						<li class="nav-item "><a class="nav-link" href="#"> <i
								class="fas fa-user-alt"></i>
								<p>View Customers</p>
						</a></li>
					</ul>
				</div></li>
			<li class="nav-item "><a class="nav-link" data-toggle="collapse"
				href="#client-companies"> <i class="fas fa-building"></i>
					<p>
						Client companies <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="client-companies">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link" href="{{url('#')}}"> <i
								class="fas fa-truck"></i>
								<p>Add Tookan merchant</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('client/add')}}"> <i class="fas fa-building"></i>
								<p>Add Client company</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('clients')}}"> <i class="far fa-building"></i>
								<p>View Client companies</p>
						</a></li>
					</ul>
				</div></li>
			<li class="nav-item "><a class="nav-link" data-toggle="collapse"
				href="#service-types"> <i class="fas fa-tools"></i>
					<p>
						Service Types <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="service-types">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link"
							href="{{url('service-type/add')}}"> <i class="fas fa-tools"></i>
								<p>Add Service Type</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('service-types')}}"> <i class="fas fa-tools"></i>
								<p>View Service Types</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('whatsapp-template/create')}}"> <i
								class="fab fa-whatsapp-square"></i>
								<p>Add Whatsapp Template</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('whatsapp-templates')}}"> <i
								class="fab fa-whatsapp-square"></i>
								<p>View Whatsapp Templates</p>
						</a></li>
						<li class="nav-item "><a class="nav-link" href="#"> <i
								class="fas fa-phone-volume"></i>
								<p>Add Programmable Voice Call</p>
						</a></li>
						<li class="nav-item "><a class="nav-link" data-toggle="collapse"
							href="#email-templates"> <i class="far fa-envelope"></i>
								<p>
									Email Templates <b class="caret"></b>
								</p>
						</a>
							<div class="collapse" id="email-templates">
								<ul class="nav">
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-envelope"></i>
											<p>Add Email Template</p>
									</a></li>
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-envelope"></i>
											<p>View Email Templates</p>
									</a></li>
								</ul>
							</div></li>
						<li class="nav-item "><a class="nav-link" data-toggle="collapse"
							href="#sms-templates"> <i class="fas fa-sms"></i>
								<p>
									SMS Templates <b class="caret"></b>
								</p>
						</a>
							<div class="collapse" id="sms-templates">
								<ul class="nav">
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-sms"></i>
											<p>Add SMS Template</p>
									</a></li>
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-sms"></i>
											<p>View SMS Templates</p>
									</a></li>
								</ul>
							</div></li>
					</ul>
				</div></li>
			<li class="nav-item "><a class="nav-link" data-toggle="collapse"
				href="#support-types"> <i class="far fa-question-circle"></i>
					<p>
						Support Types <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="support-types">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link"
							href="{{url('support-type/add')}}"> <i
								class="fas fa-question-circle"></i>
								<p>Add Support Type</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('support-types')}}"> <i
								class="fas fa-question-circle"></i>
								<p>View Support Types</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('keywords')}}"> <i class="fas fa-tags"></i>
								<p>Keywords</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('responses')}}"> <i class="fas fa-reply-all"></i>
								<p>Responses</p>
						</a></li>
						<li class="nav-item "><a class="nav-link" data-toggle="collapse"
							href="#email-notifications"> <i class="far fa-envelope"></i>
								<p>
									Email Notifications <b class="caret"></b>
								</p>
						</a>
							<div class="collapse" id="email-notifications">
								<ul class="nav">
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-envelope"></i>
											<p>Email Keywords</p>
									</a></li>
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-envelope"></i>
											<p>Email Responses</p>
									</a></li>
								</ul>
							</div></li>
						<li class="nav-item "><a class="nav-link" data-toggle="collapse"
							href="#sms-notifications"> <i class="fas fa-sms"></i>
								<p>
									SMS Notifications <b class="caret"></b>
								</p>
						</a>
							<div class="collapse" id="sms-notifications">
								<ul class="nav">
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-sms"></i>
											<p>SMS Keywords</p>
									</a></li>
									<li class="nav-item "><a class="nav-link" href="#"> <i
											class="fas fa-sms"></i>
											<p>SMS Responses</p>
									</a></li>
								</ul>
							</div></li>
					</ul>
				</div></li>
			<li class="nav-item "><a class="nav-link" data-toggle="collapse"
				href="#car-sync-prototypes"> <i class="fas fa-puzzle-piece"></i>
					<p>
						Car Sync Prototypes <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="car-sync-prototypes">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link"
							href="{{url('obd-admin')}}"> <i class="fas fa-car-crash"></i>
								<p>Emergency Crash Detection</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('tyres-batteries')}}"> <i class="fas fa-car-battery"></i>
								<p>AutoData Tyres & Batteries</p>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{url('customer/health-check')}}"> <i class="fas fa-car"></i>
								<p>Vehicle Health Check</p>
						</a></li>
					</ul>
				</div></li>
			<li class="nav-item "><a class="nav-link"
				href="{{url('whatsapp-conversations')}}"> <i class="fab fa-whatsapp"></i>
					<p>Whatsapp</p>
			</a></li>
			<li class="nav-item "><a class="nav-link"
				href="{{url('general-enquiry')}}"> <i class="fas fa-question-circle"></i>
					<p>General Enquiries</p>
			</a></li> @endif
			<li class="nav-item "><a class="nav-link" href="{{url('logout')}}"> <i
					class="fas fa-sign-out-alt"></i>
					<p>Logout</p>
			</a></li>
		</ul>
		@elseif(Auth::guard('doorder')->check()) @if(auth()->user()->user_role
		== 'client')
		<ul class="nav">
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('doorder_adminMap', 'doorder')}}"> <img
					class="my-nav-icon" src="{{asset('images/doorder_icons/Map.png')}}"
					alt="Map"> <img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Map-yellow.png')}}" alt="Map">
					<p>Map</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex" href="{{url('/')}}">
					<img class="my-nav-icon"
					src="{{asset('images/doorder_icons/dashboard.png')}}" alt=""> <img
					class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Dashboard-yellow.png')}}" alt="">
					<p>Dashboard</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('doorder_ordersTable', 'doorder')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/doorder_icons/orders_table_white.png')}}"
					alt=""> <img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/orders_table.png')}}" alt="">
					<p>Orders Table</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('doorder_retailers', 'doorder')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/doorder_icons/Retailer.png')}}" alt=""> <img
					class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Retailer-yellow.png')}}" alt="">
					<p>Retailers</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('doorder_drivers', 'doorder')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/doorder_icons/Deliverers-white.png')}}" alt="">
					<img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Deliverers-yellow.png')}}"
					alt="">
					<p>Deliverers</p>
			</a></li>

			<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsExamples"
				aria-expanded="false"> <img class="my-nav-icon"
					src="{{asset('images/doorder_icons/Requests.png')}}" alt=""
					style="width: 20px"> <img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Requests-yellow.png')}}" alt=""
					style="width: 20px">
					<p style="padding-right: 30px;">
						Requests <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="componentsExamples">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link"
							href="{{route('doorder_retailers_requests', 'doorder')}}"> <span
								class="sidebar-mini">RR</span> <span class="sidebar-normal">
									Retailers Requests </span>
						</a></li>
						<li class="nav-item "><a class="nav-link"
							href="{{route('doorder_drivers_requests', 'doorder')}}"> <span
								class="sidebar-mini">DR</span> <span class="sidebar-normal">
									Drivers Requests </span>
						</a></li>
					</ul>
				</div></li>

			<li class="nav-item"><a class="nav-link d-flex" href="#"> <img
					class="my-nav-icon"
					src="{{asset('images/doorder_icons/Whatsapp.png')}}" alt="whatsapp">
					<img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Whatsapp-yellow.png')}}"
					alt="whatsapp">
					<p>WhatsApp</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex" href="#"> <img
					class="my-nav-icon"
					src="{{asset('images/doorder_icons/History-white.png')}}"
					alt="whatsapp"> <img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/History-yellow.png')}}"
					alt="whatsapp">
					<p>History</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex" href="#"> <img
					class="my-nav-icon"
					src="{{asset('images/doorder_icons/Settings.png')}}" alt="whatsapp">
					<img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/Settings-yellow.png')}}"
					alt="whatsapp">
					<p>Settings</p>
			</a></li>


			<li class="nav-item "><a class="nav-link d-flex"
				href="{{url('logout')}}"> <img class="my-nav-icon"
					src="{{asset('images/doorder_icons/logout-outline.png')}}"
					alt="whatsapp"> <img class="my-nav-icon my-nav-icon-top"
					src="{{asset('images/doorder_icons/logout-outline-yellow.png')}}"
					alt="whatsapp">
					<p>Logout</p>
			</a></li>
		</ul>
		@elseif(auth()->user()->user_role == 'retailer')
		<ul class="nav">
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('doorder_addNewOrder', 'doorder')}}"> {{-- <i
					class="fas fa-plus-circle"></i>--}} <img class="my-nav-icon"
					src="{{asset('images/doorder_icons/add-plus-outline.png')}}" alt="">
					<p>Add New Order</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex" href="{{url('/')}}">
					{{-- <i class="fas fa-chart-bar"></i>--}} <img class="my-nav-icon"
					src="{{asset('images/doorder_icons/dashboard.png')}}" alt="">
					<p>Dashboard</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('doorder_ordersTable', 'doorder')}}"> {{-- <i
					class="fas fa-chart-bar"></i>--}} <img class="my-nav-icon"
					src="{{asset('images/doorder_icons/orders_table_white.png')}}"
					alt="">
					<p>Order Table</p>
			</a></li>
			<li class="nav-item "><a class="nav-link d-flex"
				href="{{url('logout')}}"> {{-- <i class="fas fa-sign-out-alt"></i>--}}
					<img class="my-nav-icon"
					src="{{asset('images/doorder_icons/logout-outline.png')}}" alt="">
					<p>Logout</p>
			</a></li>
		</ul>
		@endif @elseif(Auth::guard('garden-help')->check())
		<ul class="nav">
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{url('garden-help/home')}}"> {{-- <i
					class="fas fa-plus-circle"></i>--}} <img class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Dashboard-white.png')}}"
					alt="Dashboard">
					<p>Dashboard</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getJobsTable', 'garden-help')}}"><img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Job-Table-white.png')}}"
					alt="Dashboard">
					<p>Jobs Table</p> </a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_addNewJob', 'garden-help')}}"> <i
					class="fas fa-plus-circle"></i>
					<p>Add New Job</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{url('garden-help/home')}}"> <img
					class="my-nav-icon my-nav-icon-cutomer"
					src="{{asset('images/gardenhelp_icons/Customers-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">Customers</p>
			</a></li>

			<!-- 	<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsCustomersExamples"
				aria-expanded="false"> <img 
					class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Customers-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">
						Customers <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="componentsCustomersExamples">
					<ul class="nav">
						
					</ul>
				</div></li> -->

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getContractorsRoster', 'garden-help')}}"> <i class="fas fa-calendar-alt"></i>
					<p style="padding-right: 30px;">Contractors Roster</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getContractorsList', 'garden-help')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Contractors-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">Contractors</p>
			</a></li>
			<!-- 	<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsContractorsExamples"
				aria-expanded="false"> <img 
					class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Contractors-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">
						Contractors <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="componentsContractorsExamples">
					<ul class="nav">
						
					</ul>
				</div></li>-->

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getServiceTypes', 'garden-help')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Service-types-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">Service Types</p>
			</a></li>

			<!-- <li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsServiceTypesExamples"
				aria-expanded="false"> <img 
					class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Service-types-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">
						Service Types <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="componentsServiceTypesExamples">
					<ul class="nav">
						
					</ul>
				</div></li>		-->

			<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsExamples"
				aria-expanded="false"> <img class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/Requests-white.png')}}"
					alt="">
					<p style="padding-right: 30px;">
						Requests <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="componentsExamples">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link d-flex"
							href="{{route('garden_help_getContractorsRequests', 'garden-help')}}">
								<p class="sidebar-mini">CR</p>
								<p class="sidebar-normal">Contractors Requests</p>
						</a></li>
						<li class="nav-item"><a class="nav-link d-flex"
							href="{{route('garden_help_getCustomerssRequests', 'garden-help')}}">
								<p class="sidebar-mini">CR</p>
								<p class="sidebar-normal">Customers Requests</p>
						</a></li>
					</ul>
				</div></li>


			<li class="nav-item"><a class="nav-link d-flex" href="#"> {{-- <i
					class="fas fa-plus-circle"></i>--}} <img class="my-nav-icon"
					src="{{asset('images/gardenhelp_icons/WhatsApp-white.png')}}"
					alt="Dashboard">
					<p>WhatsApp</p>
			</a></li>


			<li class="nav-item "><a class="nav-link d-flex"
				href="{{url('logout')}}"> <i class="fas fa-sign-out-alt"></i>
					<p>Logout</p>
			</a></li>
		</ul>
		@elseif(Auth::guard('doom-yoga')->check())
		<ul class="nav">
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('getNewEventDoomYoga', 'doom-yoga')}}">  <img class="my-nav-icon"
					src="{{asset('images/doom-yoga/New-Event.png')}}"
					alt="Dashboard">
					<p>New Event </p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="">  <img class="my-nav-icon"
					src="{{asset('images/doom-yoga/My-Events.png')}}"
					alt="Dashboard">
					<p>My Events </p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="">  <img class="my-nav-icon"
					src="{{asset('images/doom-yoga/Dashboard.png')}}"
					alt="Dashboard">
					<p>Dashboard </p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('getCustomersRegistrations', 'doom-yoga')}}">  <img class="my-nav-icon"
					src="{{asset('images/doom-yoga/Registrations.png')}}"
					alt="Dashboard">
					<p>Registrations </p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="">  <img class="my-nav-icon"
					src="{{asset('images/doom-yoga/WhatsApp.png')}}"
					alt="Dashboard">
					<p>Whatsapp </p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="">  <img class="my-nav-icon"
					src="{{asset('images/doom-yoga/Settings.png')}}"
					alt="Dashboard">
					<p>Settings </p>
			</a></li>
			<li class="nav-item "><a class="nav-link d-flex"
				href="{{url('logout')}}"> 
					<img class="my-nav-icon"
					src="{{asset('images/doom-yoga/Logout.png')}}" alt="">
					<p>Logout</p>
			</a></li>
		</ul>	
		@endif
	</div>
	@if($admin_nav_background_image!=null)
	<div class="sidebar-background"
		style="background-image: url('{{asset($admin_nav_background_image)}}')">
	</div>
	@endif
</div>
