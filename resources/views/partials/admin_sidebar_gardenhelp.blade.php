<div class="sidebar" data-color="black" data-background-color="white">
	<!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
    -->
	@if(($user_type == 'client' || $user_type == 'retailer' || $user_type
	== 'driver_manager' || $user_type == 'investor' || $user_type ==
	'admin') && $admin_nav_logo!=null)
	<div class="user" style="z-index: 3">
		<div class="photo photo-full text-center mb-1">
			<img src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
				title="{{$admin_client_name}}" alt="{{$admin_client_name}}"
				id="adminNavLogoImg" />
		</div>
	</div>
	@else
	<div class="logo">
		<a href="{{url('/')}}" class="simple-text logo-mini"> @if($user_type
			== 'client' || $user_type == 'retailer' || $user_type ==
			'driver_manager' || $user_type == 'investor' || $user_type ==
			'admin') {{$admin_client_name[0]}} @else BB @endif </a> <a
			href="{{url('/')}}" class="simple-text logo-normal"> @if($user_type
			== 'client' || $user_type == 'retailer' || $user_type ==
			'driver_manager' || $user_type == 'investor' || $user_type ==
			'admin') {{$admin_client_name}} @else Bumblebee @endif </a>
	</div>
	@endif
	<div class="sidebar-wrapper">

		@if(Auth::guard('garden-help')->check())
		<ul class="nav">
			@if(auth()->user()->user_role == 'client')
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{url('garden-help/garden_help_dashboard')}}"> <img class="my-nav-icon"
					src="{{asset('images/gardenhelp/dashboard-icon.png')}}"
					alt="Dashboard">
					<p>Dashboard</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getJobsTable', 'garden-help')}}"><img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/jobs-icon.png')}}" alt="Jobs">
					<p>Jobs Table</p> </a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_addNewJob', 'garden-help')}}"> <img
					class="my-nav-icon my-nav-icon-grey"
					src="{{asset('images/gardenhelp/add-icon.png')}}" alt="Add job">
					<img
                        class="my-nav-icon my-nav-icon-top"
                        src="{{asset('images/gardenhelp/add-icon-green.png')}}" alt="">
					<p>Add New Job</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{url('garden-help/home')}}"> <img class="my-nav-icon my-nav-icon-grey"
					src="{{asset('images/gardenhelp/customers-icon.png')}}"
					alt="Customers">
					<img
                        class="my-nav-icon my-nav-icon-top"
                        src="{{asset('images/gardenhelp/customers-icon-green.png')}}" alt="">
					<p>Customers</p>
			</a></li>

			<!-- 	<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsCustomersExamples"
				aria-expanded="false"> <img 
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/Customers-white.png')}}"
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
				href="{{route('garden_help_getContractorsRoster', 'garden-help')}}">
					<img class="my-nav-icon"
					src="{{asset('images/gardenhelp/jobs-icon.png')}}" alt="Jobs"><p>Contractors
					Roster
					</p>
			</a></li>

			<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#contractors-collapse"
				aria-expanded="false"> <img class="my-nav-icon my-nav-icon-grey"
					src="{{asset('images/gardenhelp/contractors-icon.png')}}" alt="">
					<img
                        class="my-nav-icon my-nav-icon-top"
                        src="{{asset('images/gardenhelp/contractors-icon-green.png')}}" alt="">
					<p>
						Contractors<b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="contractors-collapse">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link d-flex"
							href="{{route('garden_help_getContractorsList', 'garden-help')}}">
								<img class="my-nav-icon"
					src="{{asset('images/gardenhelp/contractor-list-icon.png')}}" alt="List">
								<p class="">Contractors List</p>
						</a></li>
						<li class="nav-item"><a class="nav-link d-flex"
							href="{{route('garden_help_getContractorsFee', 'garden-help')}}">
								<img class="my-nav-icon"
					src="{{asset('images/gardenhelp/fees-icon.png')}}" alt="Fees">
								<p class="">Contractors Fees</p>
						</a></li>
					</ul>
				</div></li>

			<!-- 	<li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsContractorsExamples"
				aria-expanded="false"> <img 
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/Contractors-white.png')}}"
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
					src="{{asset('images/gardenhelp/service-type-icon.png')}}" alt="Service type">
					<p >Service Types</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getInvoiceList', 'garden-help')}}"> <img
					class="my-nav-icon my-nav-icon-grey"
					src="{{asset('images/gardenhelp/invoice-icon.png')}}" alt="Invoice">
					<img
                        class="my-nav-icon my-nav-icon-top"
                        src="{{asset('images/gardenhelp/invoice-icon-green.png')}}" alt="">
					<p >Invoice</p>
			</a></li>

			<!-- <li class="nav-item "><a class="nav-link collapsed d-flex"
				data-toggle="collapse" href="#componentsServiceTypesExamples"
				aria-expanded="false"> <img 
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/Service-types-white.png')}}"
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
				aria-expanded="false"> <img class="my-nav-icon my-nav-icon-grey"
					src="{{asset('images/gardenhelp/requests-icon.png')}}" alt="Requests">
					<img
                        class="my-nav-icon my-nav-icon-top"
                        src="{{asset('images/gardenhelp/requests-icon-green.png')}}" alt="">
					<p>
						Requests <b class="caret"></b>
					</p>
			</a>
				<div class="collapse" id="componentsExamples">
					<ul class="nav">
						<li class="nav-item "><a class="nav-link d-flex"
							href="{{route('garden_help_getContractorsRequests', 'garden-help')}}">
								 <img class="my-nav-icon"
					src="{{asset('images/gardenhelp/contractor-list-icon.png')}}" alt="Requests">
								<p class="">Contractors Requests</p>
						</a></li>
						<li class="nav-item"><a class="nav-link d-flex"
							href="{{route('garden_help_getCustomerssRequests', 'garden-help')}}">
								 <img class="my-nav-icon"
					src="{{asset('images/gardenhelp/customer-list-icon.png')}}" alt="Requests">
								<p class="">Customers Requests</p>
						</a></li>
					</ul>
				</div></li>


			<li class="nav-item "><a class="nav-link  d-flex"
				href="{{route('garden_help_getTermsPrivacy', 'garden-help')}}">  <img class="my-nav-icon"
					src="{{asset('images/gardenhelp/terms-icon.png')}}" alt="Terms">
					<p style="padding-right: 30px;">Terms & Privacy</p>
			</a></li>


			<li class="nav-item"><a class="nav-link d-flex" href="#"> 
				 <img class="my-nav-icon"
					src="{{asset('images/gardenhelp/whatsapp-icon.png')}}"
					alt="whatsapp">
					<p>WhatsApp</p>
			</a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getSetting', 'garden-help')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/notifications-icon.png')}}"
					alt="Notifications">
					<p>Notification</p>
			</a></li> 
			@elseif(auth()->user()->user_role == 'customer')

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_addNewJob', 'garden-help')}}"> <i
					class="fas fa-plus-circle"></i>
					<p>Book New Job</p>
			</a></li>
			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getJobsTable', 'garden-help')}}"><img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/Job-Table-white.png')}}"
					alt="Dashboard">
					<p>My Bookings</p> </a></li>

			<li class="nav-item"><a class="nav-link d-flex"
				href="{{route('garden_help_getProperties', 'garden-help')}}"> <img
					class="my-nav-icon"
					src="{{asset('images/gardenhelp/property-icon-white.png')}}"
					alt="Dashboard">
					<p style="padding-right: 30px;">My Properties</p>

			</a></li> @endif

			<li class="nav-item "><a class="nav-link d-flex"
				href="{{url('logout')}}">  <img class="my-nav-icon"
					src="{{asset('images/gardenhelp/logout-icon.png')}}" alt="Logout">
					<p>Logout</p>
			</a></li>
		</ul>
		@endif
	</div>
	<!-- 	@if($admin_nav_background_image!=null) -->
	<!-- 	<div class="sidebar-background" style="background-image: url('{{asset($admin_nav_background_image)}}')"> -->
	<!-- 	</div> -->
	<!-- 	@endif -->
</div>

