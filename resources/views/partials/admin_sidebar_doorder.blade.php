<div class="sidebar" data-color="black" data-background-color="white">
	<!--
						Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
						Tip 2: you can also add an image using data-image tag
				-->
	@if (($user_type == 'client' ||
	    $user_type == 'retailer' ||
	    $user_type == 'driver_manager' ||
	    $user_type == 'investor' ||
	    $user_type == 'admin') &&
	    $admin_nav_logo != null)
		<div class="user" style="z-index: 3">
			<div class="photo photo-full text-center mb-3">
				<img src="{{ asset('images/doorder-new-layout/Logo.png') }}" title="{{ $admin_client_name }}"
					alt="{{ $admin_client_name }}" id="adminNavLogoImg" />
			</div>
		</div>
	@else
		<div class="logo">
			<a href="{{ url('/') }}" class="simple-text logo-mini">
				@if ($user_type == 'client' ||
				    $user_type == 'retailer' ||
				    $user_type == 'driver_manager' ||
				    $user_type == 'investor' ||
				    $user_type == 'admin')
					{{ $admin_client_name[0] }}
				@else
					BB
				@endif
			</a> <a href="{{ url('/') }}" class="simple-text logo-normal">
				@if ($user_type == 'client' ||
				    $user_type == 'retailer' ||
				    $user_type == 'driver_manager' ||
				    $user_type == 'investor' ||
				    $user_type == 'admin')
					{{ $admin_client_name }}
				@else
					Bumblebee
				@endif
			</a>
		</div>
	@endif
	<div class="sidebar-wrapper">

		@if (Auth::guard('doorder')->check())
			<ul class="nav">
				@if (auth()->user()->user_role == 'client' || auth()->user()->user_role == 'admin')
					<!--                 <li class="nav-item"><a class="nav-link d-flex" -->
					<!--                     href="{{ route('doorder_adminMap', 'doorder') }}"> <img -->
					<!--                         class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder_icons/Map.png') }}" -->
					<!--                         alt="Map"> <img class="my-nav-icon my-nav-icon-top" -->
					<!--                         src="{{ asset('images/doorder_icons/Map-yellow.png') }}" alt="Map"> -->
					<!--                         <p>Map</p> -->
					<!--                 </a></li> -->
					<li class="nav-item"><a class="nav-link d-flex" href="{{ url('/') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/dashboard-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/dashboard-yellow.png') }}" alt="">
							<p>Dashboard</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_ordersTable', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/orders-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/orders-yellow.png') }}" alt="">
							<p>Orders Table</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_retailers', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/retailers-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/retailers-yellow.png') }}" alt="">
							<p>Retailers</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_drivers', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/drivers-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/drivers-yellow.png') }}"
								alt="">
							<p>Deliverers</p>
						</a></li>

					<li class="nav-item "><a class="nav-link collapsed d-flex" data-toggle="collapse" href="#componentsExamples"
							aria-expanded="false"> <img class="my-nav-icon my-nav-icon-grey"
								src="{{ asset('images/doorder-new-layout/requests-grey.png') }}" alt=""> <img
								class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/requests-yellow.png') }}"
								alt="">
							<p>
								Requests <i class="fas fa-angle-down"></i>
							</p>
						</a>
						<div class="collapse" id="componentsExamples">
							<ul class="nav">
								<li class="nav-item "><a class="nav-link" href="{{ route('doorder_retailers_requests', 'doorder') }}"> <span
											class="sidebar-mini">RR</span> <span class="sidebar-normal">
											Retailers Requests </span>
									</a></li>
								<li class="nav-item "><a class="nav-link" href="{{ route('doorder_drivers_requests', 'doorder') }}"> <span
											class="sidebar-mini">DR</span> <span class="sidebar-normal">
											Drivers Requests </span>
									</a></li>
							</ul>
						</div>
					</li>



					<li class="nav-item "><a class="nav-link collapsed d-flex" data-toggle="collapse" href="#componentsInvoice"
							aria-expanded="false">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/invoice-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/invoice-yellow.png') }}"
								alt="">
							<p>
								Invoice <i class="fas fa-angle-down"></i>
							</p>
						</a>
						<div class="collapse" id="componentsInvoice">
							<ul class="nav">
								<li class="nav-item "><a class="nav-link" href="{{ route('doorder_getInvoiceList', 'doorder') }}"> <span
											class="sidebar-mini">RI</span> <span class="sidebar-normal">
											Retailers </span>
									</a></li>
								<li class="nav-item "><a class="nav-link" href="{{ route('doorder_getDriversInvoiceList', 'doorder') }}">
										<span class="sidebar-mini">DI</span> <span class="sidebar-normal">
											Drivers </span>
									</a></li>
							</ul>
						</div>
					</li>

					<li class="nav-item">
						<a class="nav-link d-flex" href="#"> <img class="my-nav-icon my-nav-icon-grey"
								src="{{ asset('images/doorder-new-layout/whatsapp-grey.png') }}" alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/whatsapp-yellow.png') }}"
								alt="">
							<p>WhatsApp</p>
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link d-flex" href="{{ route('doorder_ordersHistoryTable', 'doorder') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/history-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/history-yellow.png') }}" alt="">
							<p>History</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex" href="{{ route('doorder_metrics_dashboard', 'doorder') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/metrics-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/metrics-yellow.png') }}" alt="">
							<p>Metrics</p>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link d-flex" href="{{ route('doorder_paymentLogsIndex', 'doorder') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/payment-log-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/payment-log-yellow.png') }}"
								alt="">
							<p>Payment logs</p>
						</a>
					</li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_getSettings', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/settings-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/settings-yellow.png') }}"
								alt="">
							<p>Settings</p>
						</a></li>
				@elseif(auth()->user()->user_role == 'retailer')
					<li class="nav-item"><a class="nav-link d-flex" href="{{ url('/') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/dashboard-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/dashboard-yellow.png') }}" alt="">
							<p>Dashboard</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_addNewOrder', 'doorder') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/add-order-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/add-order-yellow.png') }}"
								alt="">
							<p>New Order</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_ordersTable', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/orders-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/orders-yellow.png') }}" alt="">
							<p>Order Table</p>
						</a></li>
					<li class="nav-item">
						<a class="nav-link d-flex" href="{{ route('doorder_ordersHistoryTable', 'doorder') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/history-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/history-yellow.png') }}" alt="">
							<p>History</p>
						</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link d-flex" href="{{ route('doorder_getInvoiceList', 'doorder') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/invoice-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/invoice-yellow.png') }}"
								alt="">
							<p> Invoice </p>
						</a>
					</li>
				@elseif(auth()->user()->user_role == 'driver_manager')
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_drivers', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/drivers-grey.png') }}"
								alt="">
							<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/drivers-yellow.png') }}"
								alt="">
							<p>Deliverers</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_drivers_requests', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/requests-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/requests-yellow.png') }}" alt="">
							<p>Deliverer Requests</p>
						</a></li>
					<li class="nav-item"><a class="nav-link d-flex" href="{{ route('doorder_ordersTable', 'doorder') }}"> <img
								class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/orders-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/orders-yellow.png') }}" alt="">
							<p>Order Table</p>
						</a></li>
				@elseif(auth()->user()->user_role == 'investor')
					<li class="nav-item"><a class="nav-link d-flex" href="{{ url('doorder/metrics_dashboard') }}">
							<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/metrics-grey.png') }}"
								alt=""> <img class="my-nav-icon my-nav-icon-top"
								src="{{ asset('images/doorder-new-layout/metrics-yellow.png') }}" alt="">
							<p>Metrics</p>
						</a></li>
				@endif
				<li class="nav-item "><a class="nav-link d-flex" href="{{ url('logout') }}">
						<img class="my-nav-icon my-nav-icon-grey" src="{{ asset('images/doorder-new-layout/logout-grey.png') }}"
							alt="">
						<img class="my-nav-icon my-nav-icon-top" src="{{ asset('images/doorder-new-layout/logout-yellow.png') }}"
							alt="">
						<p>Logout</p>
					</a></li>
			</ul>

		@endif

	</div>
	<div class="filter-navbar" id="filternavbar">

		<div class="form-group bmd-form-group" id="countryFilterFormGroup">

			<label for="country_filter">City </label>
			<treeselectfilter v-model="country_filter" name="country_filter" id="country_filter" placeholder="Select country"
				:multiple="false" :options="options_country" :clearable="false" :searchable="true"
				:openOnClick="true" :disable-branch-nodes="true" :closeOnSelect="true" :flat="true"
				:open-on-focus="true" :always-open="false" @input="changeCountryFilterSidebar()">
			</treeselectfilter>
		</div>
	</div>
	<!-- 	@if ($admin_nav_background_image != null)
-->
	<!-- 	<div class="sidebar-background" style="background-image: url('{{ asset($admin_nav_background_image) }}')"> -->
	<!-- 	</div> -->
	<!--
@endif -->
</div>
