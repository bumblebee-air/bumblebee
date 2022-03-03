@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/bootstrap-slider.css')}}">
<!-- <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Responsive-Touch-Friendly-jQuery-Range-Slider-Plugin/rangeslider.css?v3"> -->
<link rel="stylesheet" href="{{asset('css/mdtimepicker.css')}}">
<link rel="stylesheet" href="{{asset('css/jquery-steps_doorder.css')}}">
<style>
div[data-toggle='collapse'] {
	cursor: pointer;
}

.deliverers-container .deliverer-card {
	margin-top: 0;
	margin-bottom: 15px;
	cursor: pointer;
	background-color: #F5F8FA;
}

.deliverers-container .deliverer-card.selected {
	background-color: #F3ECCE;
	box-shadow: none;
}

.card-category {
	margin-top: -5px !important;
	font-family: Quicksand;
	font-size: 10px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: normal;
	color: #b1b1b1 !important;
	margin-left: 95px !important;
}

.statusSpan {
	color: #656565 !important;
	font-weight: 700;
}

.recommendDriverNameH6 {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 500;
	font-size: 16px;
	line-height: 18px;
	letter-spacing: normal;
	color: #4D4D4D;
	margin-bottom: 0;
	text-transform: capitalize;
}

#assign-deliverer-modal .recommendDriverNameH6 {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 600;
	font-size: 18px;
	line-height: 20px;
	color: #E9C218;
	text-transform: capitalize;
}

.recommendDriverDataP {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 500;
	font-size: 16px;
	line-height: 18px;
	text-align: right;
	color: #979797;
	margin-bottom: 0;
	display: inline-block;
	text-transform: capitalize;
}

#assign-deliverer-modal .recommendDriverDataP {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 500;
	font-size: 18px;
	line-height: 20px;
	color: #656565;
}

.recommendDriverDotP {
	font-size: 4px;
	line-height: 8px;
	color: #F7DC69;
	margin-bottom: 0;
	display: inline-block;
}

.recommendDriverDataKmP {
	font-family: Montserrat;
	font-style: normal;
	font-weight: normal;
	font-size: 15px;
	line-height: 18px;
	color: #656565;
	margin-bottom: 0;
	display: inline-block;
	text-align: right;
}

#assign-deliverer-modal .recommendDriverDataKmP {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 500;
	font-size: 18px;
	line-height: 20px;
	color: #656565;
}

.recommendDriverDataKmP span {
	position: inherit !important;
	display: inline-block !important;
}

.colCheckCircleDiv i {
	font-size: 22px;
	margin: 0;
	position: inherit;
	top: 50%;
	-ms-transform: translateY(-50%);
	transform: translateY(-50%);
	margin: 0;
}

input[type="radio"], input[type="checkbox"] {
	display: none;
}

input[type="checkbox"]:checked+label div i, .assignedDriverChecked i {
	color: #e8ca49;
}

.form-check-label-select-all {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 600;
	font-size: 16px;
	line-height: 20px;
	color: #23314B;
}

@media ( min-width :768px) and ( max-width :991.5px) {
	.form-check-label-select-all {
		font-weight: 500;
		font-size: 15px;
	}
}

.form-check .form-check-label .form-check-sign {
	top: 25% !important;
	left: 1px;
	margin-left: 5px;
	margin-right: 5px;
	margin-left: 5px;
}

.form-check .form-check-label-select-all .form-check-sign {
	left: 1px !important;
	top: 0 !important;
}

.form-check .form-check-label .form-check-sign:before, .form-check .form-check-label .form-check-sign .check
	{
	border-radius: 3px;
	width: 18px;
	height: 18px
}

.form-check .form-check-label .form-check-input:checked ~.form-check-sign .check
	{
	background: #E9C218 !important;
	border-radius: 5px !important;
	border: 1px solid #E9C218 !important;
}

.form-check .form-check-label .form-check-sign .check {
	border-radius: 5px;
	background: #efefef !important;
	border-color: #efefef !important;
}

.form-check .form-check-label .form-check-input:checked ~.form-check-sign .check:before
	{
	color: #f6e7a3;
	top: 0;
}

button.disabled, button:disabled {
	background-color: #b1b1b1 !important;
	opacity: 1 !important;
	border: none;
}

#customerAddressSpan {
	font-family: Quicksand;
	font-size: 15px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.2;
	letter-spacing: normal;
	color: #656565;
}

.slider.slider-horizontal {
	width: 100% !important;
}

.slider {
	background: none !important;
}

.slider.slider-horizontal .slider-track {
	height: 15px;
	border-radius: 10px;
}

.slider-track-high {
	background: #F5F8FA !important;
}

.slider-selection {
	background-color: #f7dc69;
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f7dc69),
		to(#f7dc69));
	background-image: -webkit-linear-gradient(top, #f7dc69, #f7dc69);
	background-image: -o-linear-gradient(top, #f7dc69, #f7dc69);
	background-image: linear-gradient(to bottom, #f7dc69, #f7dc69);
	box-shadow: none;
	border-radius: 15px;
}

.slider-track-low, .slider-track-high {
	border-radius: 15px;
}

.slider-handle {
	transform: rotate(90deg);
	border: 5px solid #E9C218;
	background-color: #FFF2BB;
	background-image: none !important;
	width: 30px;
	height: 30px;
}

.slider .tooltip {
	z-index: 1000 !important;
}

.slider .tooltip.bs-tooltip-bottom {
	margin-top: -8px;
	background: transparent;
}

.slider .arrow {
	display: none;
}

.slider .tooltip-inner {
	padding: 5px;
	min-width: auto;
	width: auto;
	font-family: Quicksand;
	font-size: 10px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.8;
	letter-spacing: normal;
	color: #656565;
	box-shadow: none;
}

.gm-style .gm-style-iw-d {
	overflow: auto !important;
	max-height: 818px;
	height: 60px;
	width: 150px;
}

.orderSubmitButton {
	font-size: 16px !important;
	letter-spacing: 0.88px !important;
}

/* #printButton { */
/* 	font-size: 14px; */
/* 	font-weight: 600; */
/* 	font-stretch: normal; */
/* 	font-style: normal; */
/* 	line-height: normal; */
/* 	letter-spacing: 0.72px; */
/* 	color: #ffffff; */
/* 	border-radius: 12px 0; */
/* 	text-transform: inherit !important; */
/* 	height: auto; */
/* 	padding: 10px; */
/* } */
#printDiv {
	background-color: #f6f7fa;
	display: none;
}

#printDiv .col-md-12 {
	text-align: center;
}

#printDiv img {
	margin-top: 20px
}

.mdtp__wrapper[data-theme='blue'] .mdtp__time_holder {
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__digit.active span,
	.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__digit span:hover
	{
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__digit.active:before {
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__clock_dot {
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__am.active,
	.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__pm.active {
	background-color: #F7DC69 !important;
	border-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__button {
	color: #F7DC69;
}

.mdtp__button:hover {
	color: white !important;
}

.mdtp__wrapper {
	bottom: 0 !important;
	top: 10%;
	box-shadow: none !important;
}
</style>
@endsection @section('title','DoOrder | View Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				{{csrf_field()}}
				<div class="card card-profile-page-title">
					<div class="card-header row">
						<div class="col-12 p-0">
							<h4 class="card-title my-md-4 mt-4 mb-1">Order Details</h4>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="wrapper h-auto">
					<div id="wizard">
						<div class="row">
							<div class="col-sm-6">

								@php $status=''; $statusClass=''; if($order->status ==
								'pending'){ $status = 'Pending fullfilment'; $statusClass =
								'pendingStatus'; } elseif($order->status == 'ready'){ $status =
								'Ready to Collect'; $statusClass = 'readyStatus'; }
								elseif($order->status == 'matched' || $order->status ==
								'assigned'){ $status = 'Matched'; $statusClass =
								'matchedStatus'; } elseif($order->status == 'on_route_pickup'){
								$status = 'On-route to Pickup'; $statusClass =
								'onRoutePickupStatus'; } elseif($order->status == 'picked_up'){
								$status = 'Picked up'; $statusClass = 'pickedUpStatus'; }
								elseif($order->status == 'on_route'){ $status = 'On-route';
								$statusClass = 'onRouteStatus'; } elseif($order->status ==
								'delivery_arrived'){ $status = 'Arrived to location';
								$statusClass = 'deliveredArrivedStatus'; } elseif($order->status
								== 'delivered'){ $status = 'Delivered'; $statusClass =
								'deliveredStatus'; } elseif($order->status == 'not_delivered'){
								$status = 'Not delivered'; $statusClass = 'notDeliveredStatus';
								} @endphp

								<form method="POST" id="assign-driver" class="m-0"
									action="{{url('doorder/order/assign')}}">
									@csrf <input type="hidden" id="order-id" name="order_id"
										value="{{$order->id}}" />
									<!-- SECTION 1 -->
									<h4 class="wizardH4"></h4>
									<section class="wizardSection">
										<div class="card my-0">
											<div class="card-header card-header-profile-border ">
												<div class="row">
													<div class="col-6 pl-3">
														<h4>Order Number</h4>
													</div>
													<div class="col-6 text-right">
														<h4 class="orderNumber">#{{$order->order_id}}</h4>
														<span class="orderStatusSpan {{$statusClass}}">{{$status}}</span>
													</div>
												</div>
											</div>
											<div id="customer-details">
												<div class="card-body">
													<div class="container">
														<div class="row">
															<div class="col-12">
																<div class="form-group">
																	<label for="first_name" class="control-label">First
																		name</label> <input id="first_name" type="text"
																		class="form-control" value="{{$order->first_name}}"
																		name="first_name" required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="last_name" class="control-label">Last name</label>
																	<input id="last_name" type="text" class="form-control"
																		value="{{$order->last_name}}" name="last_name"
																		required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="email" class="control-label">Email</label>
																	<input id="email" type="email" class="form-control"
																		value="{{$order->customer_email}}" name="email">
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="customer_phone" class="control-label">Contact
																		number</label> <input id="customer_phone" type="tel"
																		class="form-control"
																		value="{{$order->customer_phone}}"
																		name="customer_phone" required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="customer_address" class="control-label">Address</label>
																	<input id="customer_address" type="text"
																		class="form-control"
																		value="{{$order->customer_address}}"
																		name="customer_address" required> <input type="hidden"
																		name="customer_lat" id="customer_lat"
																		value="{{$order->customer_address_lat}}"> <input
																		type="hidden" name="customer_lon" id="customer_lon"
																		value="{{$order->customer_address_lon}}">
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="eircode" class="control-label">Eircode</label>
																	<input id="eircode" type="text" class="form-control"
																		value="{{$order->eircode}}" name="eircode">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
									<!-- SECTION 2 -->
									<h4 class="wizardH4"></h4>
									<section class="wizardSection">
										<div class="card my-0">
											<div class="card-header card-header-profile-border ">
												<div class="row">
													<div class="col-6 pl-3">
														<h4>Order Number</h4>
													</div>
													<div class="col-6 text-right">
														<h4 class="orderNumber">#{{$order->order_id}}</h4>
														<span class="orderStatusSpan {{$statusClass}}">{{$status}}</span>
													</div>
												</div>
											</div>
											<div id="package-details">
												<div class="card-body">
													<div class="container">
														<div class="row">
															<div class="col-12">
																<div class="form-group">
																	<label for="pick_address" class="control-label">Pickup
																		address</label> <input id="pick_address"
																		name="pickup_address" type="text" class="form-control"
																		value="{{$order->pickup_address}}" required>
																	<!--<select id="pick_address" name="pickup_address" data-style="select-with-transition" class="form-control selectpicker">
                                                    <option value="88 - 95 Grafton Street Dublin , Dublin Ireland">88 - 95 Grafton Street Dublin , Dublin Ireland </option>
                                                    <option value="12 Brook Lawn, Lehenagh More, Cork, Ireland">12 Brook Lawn, Lehenagh More, Cork, Ireland</option>
                                                </select>-->
																	<input type="hidden" name="pickup_lat" id="pickup_lat"
																		value="{{$order->pickup_lat}}"> <input type="hidden"
																		name="pickup_lon" id="pickup_lon"
																		value="{{$order->pickup_lon}}">
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="fulfilment" class="control-label">Order
																		fulfilment</label> <input id="fulfilment" type="text"
																		name="fulfilment_date" class="form-control"
																		value="{{ $order->fulfilment_date ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->fulfilment_date)->format('m/d/Y H:i A'): NULL}}"
																		required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="weight" class="control-label">Package
																		weight </label> <input id="weight" type="text"
																		class="form-control" name="weight"
																		value="{{$order->weight}}" required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="dimensions" class="control-label">Package
																		dimensions</label> <input id="dimensions" type="text"
																		name="dimensions" class="form-control"
																		value="{{$order->dimensions}}" required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="notes" class="control-label">Other details</label>
																	<input id="notes" type="text" name="notes"
																		class="form-control" value="{{$order->notes}}">
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="notes" class="control-label">QR scan status</label>
																	<span id="qr_scan_status" class="form-control">{{$order->qr_scan_status}}
																	</span>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="deliver_by" class="control-label">Deliver
																		by</label> <select id="deliver_by" name="deliver_by"
																		data-style="select-with-transition"
																		class="form-control form-control-select selectpicker">
																		<option value="car" @if($order->deliver_by=='car')
																			selected @endif>Car</option>
																		<option value="scooter" @if($order->deliver_by=='scooter')
																			selected @endif>Scooter</option>
																	</select>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="fragile" class="control-label">Fragile
																		package?</label>
																	<div class="radio-container row">
																		<div
																			class="form-check form-check-radio form-check-inline d-flex justify-content-between">
																			<label class="form-check-label"> <input type="radio"
																				name="fragile" id="inlineRadio1" value="1"
																				class="form-check-input" required @if($order->fragile==1)
																				checked @endif> Yes <span class="circle"> <span
																					class="check"></span>
																			</span>
																			</label>
																		</div>

																		<div
																			class="form-check form-check-radio form-check-inline d-flex justify-content-between">
																			<label class="form-check-label"> <input type="radio"
																				name="fragile" id="inlineRadio1" value="0"
																				class="form-check-input" required @if($order->fragile==0)
																				checked @endif> No <span class="circle"> <span
																					class="check"></span>
																			</span>
																			</label>
																		</div>
																	</div>
																</div>
															</div>
															{{-- Available QR Codes --}}
															@if(count($order->available_qr_codes) > 0)
															<div class="col-12">
																<div class="form-group">
																	<label class="control-label">Available QR codes</label>
																		@foreach($order->available_qr_codes as $qr_code)
																			<p><a href="{{asset('uploads/pdfs/'.$qr_code.'.pdf')}}" target="_blank">{{$qr_code}}</a></p>
																		@endforeach
																</div>
															</div>
															@endif
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
								</form>
								@if(auth()->user()->user_role != 'retailer')

								<div>
									<!-- SECTION 3 -->
									<h4 class="wizardH4"></h4>
									<section class="wizardSection">
										@if($order->status == 'delivered' || $order->is_archived)
										<div class="card my-0">
											<div class="card-header card-header-profile-border ">
												<div class="row">
													<div class="col-6 pl-3">
														<h4>Order Number</h4>
													</div>
													<div class="col-6 text-right">
														<h4 class="orderNumber">#{{$order->order_id}}</h4>
														<span class="orderStatusSpan {{$statusClass}}">{{$status}}</span>
													</div>
												</div>
											</div>
											<div id="order-deliverer-details">
												<div class="card-body" style="padding-top: 20px !important;">
													<div class="container">
														<div class="row">
															<!-- 									<div class="col-12 text-center"> -->
															<!--  <p class="control-label" style="font-weight: normal">Order has -->
															<!-- 											already been delivered</p> -->
															<!-- 									</div> -->
															<div class="col-12">
																<div class="form-group">
																	<label for="fulfilment" class="control-label">Driver
																		name</label> <input id="fulfilment" type="text"
																		name="fulfilment" class="form-control"
																		value="@if($order->orderDriver) {{$order->orderDriver->name}}
																				@else N/A @endif"
																		required>
																</div>
															</div>
															<div class="col-12">
																<div class="form-group">
																	<label for="fulfilment" class="control-label">Delivery
																		status</label> <input id="fulfilment" type="text"
																		name="fulfilment" class="form-control"
																		value="{{$order->delivery_confirmation_status && $order->delivery_confirmation_status == 'confirmed' ? 'The customer has confirmed the delivery' : 'The deliverer has skipped the confirmation'}}"
																		required>
																</div>
															</div>
															@if($order->delivery_confirmation_status != 'confirmed')
															<div class="col-12">
																<div class="form-group">
																	<label for="fulfilment" class="control-label">Delivery
																		skip reason</label> <input id="fulfilment" type="text"
																		name="fulfilment" class="form-control"
																		value="{{$order->delivery_confirmation_skip_reason ? $order->delivery_confirmation_skip_reason : 'N/A'}}"
																		required>
																</div>
															</div>
															@endif
														</div>
													</div>
												</div>
											</div>
										</div>
										@else
										<div class="card mt-0">
											<div class="card-header card-header-profile-border ">
												<div class="row">
													<div class="col-6 pl-3">
														<h4>Order Number</h4>
													</div>
													<div class="col-6 text-right">
														<h4 class="orderNumber">#{{$order->order_id}}</h4>
														<span class="orderStatusSpan {{$statusClass}}">{{$status}}</span>
													</div>
												</div>
											</div>


											<div class="card-body">
												<div class="container">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label class="control-label">Location</label> <span
																	class="form-control">{{$order->customer_address}} </span>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 ">
															<div class="form-group">
																<label class="control-label w-100">Drivers within radius
																	<span id="kmAwaySpan"
																	class="float-right font-weight-normal"> </span>
																</label> <input id="kmAwayInput"
																	data-slider-id='kmAwayInputSlider' type="text"
																	data-slider-min="0" data-slider-max="60"
																	data-slider-step="1" data-slider-value="0" />
																<!-- <input id="kmAwayInput" type="range" data-rangeslider/>	 -->
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card m-0">
											<div class="card-header  ">
												<div class="row mt-2">
													<div class="col-lg-6 pl-4">
														<label class="control-label" style="color: #E9C218">Select
															driver</label>
													</div>
													<div class="col-lg-6 text-right justify-content-end">
														<div class="form-check">
															<label
																class="form-check-label form-check-label-select-all notifyAllLabel"
																for="notify-all-drivers"> <input type="checkbox"
																class="form-check-input" id="notify-all-drivers" />
																Notify all drivers <span class="form-check-sign"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="card-body pl-2">
												<div class="container">
													<div class="row " data-spy="scroll"
														data-target=".deliverers-container" data-offset="50">
														<div class="col-12 deliverers-container overflow-auto"
															style="max-height: 330px">
															@foreach($available_drivers as $driver)
															<div id="driver-{{$driver->user_id}}"
																class="card deliverer-card selectedDriverDiv"
																data-driverkmaway="0">
																<div class="form-check">

																	<label class="form-check-label w-100 px-0"
																		for="radioInputDriver-{{$driver->user_id}}"> <input
																		type="checkbox"
																		class="driverCheckbox form-check-input"
																		id="radioInputDriver-{{$driver->user_id}}"
																		value="{{$driver->user_id}}"
																		data-driver-id="{{$driver->user_id}}"
																		data-driver-name="{{$driver->user->name}}"
																		data-driver-transport="{{$driver->transport}}"
																		data-driver-away="0"> <span class="form-check-sign"> <span
																			class="check"></span>
																	</span>
																		<div class="card-header deliverer-details row ml-1">
																			<div
																				class="col-6 justify-content-center align-self-center">
																				<h6
																					class="recommendDriverNameH6 deliverer-name my-auto">{{$driver->first_name}}
																					{{$driver->last_name}}</h6>

																			</div>
																			<div class="col-6 pl-0 text-right">
																				<p class="recommendDriverDataP">{{$driver->transport}}</p>
																				<p class="recommendDriverDotP">
																					<i class="fas fa-circle"></i>
																				</p>
																				<p class="recommendDriverDataKmP"
																					id="km-away-{{$driver->user_id}}">
																					<span></span> away
																				</p>
																			</div>
																			<!-- 																		<div class="col-6 colCheckCircleDiv"  style="text-align: right">-->
																			<!-- 																			<i class="fas fa-check-circle"></i> -->
																			<!-- 																		</div> -->
																		</div>
																	</label>
																</div>
															</div>
															@endforeach
														</div>
													</div>

													<div class="row justify-content-center mt-3">
														<div
															class="col-xl-4 col-lg-6  col-md-8 col-sm-12 px-md-1 text-center">
															<button type="button" id="assignDriverButton"
																class="btnDoorder btn-doorder-primary  mb-1"
																onclick="showAssignDriverModal()" disabled="disabled">Assign
																Deliverer</button>
														</div>
													</div>
												</div>
											</div>

										</div>

										@endif
									</section>
								</div>
								@endif @if(auth()->user()->user_role != 'retailer')
								<div>
									<!-- SECTION 4 -->
									<h4 class="wizardH4"></h4>
									<section class="wizardSection">
										<div class="card my-0">
											@if(!$order->is_archived)
											<form method="POST" id="update-order-status"
												action="{{url('doorder/order/update')}}">
												@endif @csrf <input type="hidden" id="order-id"
													name="order_id" value="{{$order->id}}" />
												<div class="card-header card-header-profile-border ">
													<div class="row">
														<div class="col-6 pl-3">
															<h4>Order Number</h4>
														</div>
														<div class="col-6 text-right">
															<h4 class="orderNumber">#{{$order->order_id}}</h4>
															<span class="orderStatusSpan {{$statusClass}}">{{$status}}</span>
														</div>
													</div>
												</div>

												<div id="deliverer-details">
													<div class="card-body">
														<div class="container">
															<div class="row">
																<div class="col-12">
																	<div class="form-group">
																		<label class="control-label">Driver assigned </label>
																		<span class="form-control"
																			style="display: block; font-weight: 600">
																			@if($order->orderDriver)
																			{{$order->orderDriver->name}} @else N/A @endif </span>
																	</div>
																</div>

																<div class="col-12">
																	<div class="form-group">
																		<label for="order_status" class="control-label">Order
																			status</label> <select id="order_status"
																			name="order_status" @if($order->is_archived) disabled
																			@endif data-style="select-with-transition"
																			class="form-control form-control-select
																			selectpicker">
																			<option value="matched" @if($order->status=='matched')
																				selected @endif> Matched</option>
																			<option value="on_route_pickup" @if($order->status=='on_route_pickup')
																				selected @endif> On-route to pickup</option>
																			<option value="picked_up" @if($order->status=='picked_up')
																				selected @endif> Picked up</option>
																			<option value="on_route" @if($order->status=='on_route')
																				selected @endif> On-route</option>
																			<option value="delivery_arrived" @if($order->status=='delivery_arrived')
																				selected @endif> Arrived to location</option>
																			<option value="delivered" @if($order->status=='delivered')
																				selected @endif> Delivered</option>
																			<option value="not_delivered" @if($order->status=='not_delivered')
																				selected @endif> Not delivered</option>
																		</select>
																	</div>
																</div>

																<div class="col-12">
																	<div class="form-group">
																		<label for="comment" class="control-label">Comment</label>
																		<textarea rows="5" cols="" name="comment" @if($order->is_archived) disabled @endif
													class="form-control">@if($order->is_archived && count($order->comments) > 0){{ $order->comments[count($order->comments)-1]->comment }}@endif</textarea>
																	</div>
																</div>
															</div>
															@if(!$order->is_archived)
															<div class="row justify-content-center mt-3">
																<div
																	class="col-xl-4 col-lg-6  col-md-8 col-sm-12 px-md-1 text-center">
																	<button type="submit" id="submitChangeSatus"
																		class="btnDoorder btn-doorder-primary  mb-1">Submit</button>
																</div>
															</div>
															@endif
														</div>
													</div>
												</div>

												@if(!$order->is_archived)
											</form>
											@endif
										</div>

									</section>
								</div>
								@endif
							</div>
							<div class="col-12 col-sm-6" id="map-container">
								<div id="map"
									style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
							</div>
						</div>

					</div>


					<div class="row justify-content-center mt-5">
						<div
							class="col-xl-2 col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
							<button class="btnDoorder btn-doorder-primary  mb-1 backward">Back</button>
						</div>
						<div
							class="col-xl-2 col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
							<button class="btnDoorder btn-doorder-primary  mb-1 forward">Next</button>
						</div>
						@if(auth()->user()->user_role != 'retailer' &&
						!$order->is_archived)
						<div
							class="col-xl-2 col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
							<button class="btnDoorder btn-doorder-danger-outline  mb-1"
								type="button" data-toggle="modal"
								data-target="#delete-order-modal">Delete Order</button>
						</div>
						@endif @if(auth()->user()->user_role == 'retailer')
						@if($order->status != 'delivered' && !$order->is_archived)
						<div
							class="col-xl-2 col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
							<button id="printButton" onclick="printDiv()"
								class="btnDoorder btn-doorder-primary  mb-1"
								style="float: right">Print label</button>
						</div>
						@endif @endif

					</div>
				</div>
			</div>


		</div>



	</div>
</div>

<!-- Assign deliverer modal -->
<div class="modal fade" id="assign-deliverer-modal" tabindex="-1"
	role="dialog" aria-labelledby="assign-deliverer-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="assign-driver"
				action="{{url('doorder/order/assign')}}">
				@csrf <input type="hidden" id="order-id" name="order_id"
					value="{{$order->id}}" />
				<div class="modal-body">
					<div class="modal-dialog-header modalHeaderMessage">
						This deliverers are successfully selected <br> and ready to be
						assigned
					</div>

					<div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div
										class="col-lg-8 offset-lg-2 col-md-12 deliverers-container"
										style="max-height: 330px; overflow-y: auto">
										<div id="assignedDriversDiv" class=""></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class=" row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="submit" class="btnDoorder btn-doorder-primary mb-1">Assign</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">

						<button type="button"
							class="btnDoorder btn-doorder-danger-outline mb-1"
							data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-order-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-order-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="delete-retailer"
				action="{{url('doorder/order/delete')}}"
				style="margin-bottom: 0 !important;">
				@csrf
				<div class="modal-body">
					<div class="modal-dialog-header modalHeaderMessage">Are you sure
						you want to delete this order?</div>
					<div>
						<input type="hidden" id="orderId" name="orderId"
							value="{{$order->id}}" />

					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="submit" class="btnDoorder btn-doorder-primary mb-1">Yes</button>
					</div>

					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-danger-outline mb-1"
							data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- warning modal -->
<div class="modal fade" id="warning-address-modal" tabindex="-1"
	role="dialog" aria-labelledby="warning-address--label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="col-md-12">

						<div class="text-center">
							<img
								src="{{asset('images/doorder-new-layout/warning-icon.png')}}"
								style="" alt="warning">
						</div>
						<div class="text-center mt-3">
							<label class="warning-label">Please enter Eircode to continue
								(select drop down suggestion)</label>

						</div>
					</div>
				</div>

				<div class="row justify-content-center mt-3">

					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-primary mb-1"
							data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div id="printDiv">
	<div class="row"
		style="background-color: #ededed; height: 100px; -webkit-print-color-adjust: exact; color-adjust: exact;">
		<div class="col-md-12 text-center py-3">
			<img src="{{asset('images/doorder-logo2.png')}}" height="80px"
				width="250px">
		</div>
	</div>
	<div class="row mx-auto" style="background-color: #f6f7fa;">

		<div class="col-12  ">
			<div class="form-group  mx-auto">
				<label class="control-label  ">Name </label> <span
					class="control-label  " style="display: block; font-weight: 600">
					{{$order->customer_name}} </span>
			</div>
		</div>
		<div class="col-12">
			<div class="form-group ">
				<label class="control-label">Eircode </label> <span
					class="control-label" style="display: block; font-weight: 600">
					{{$order->eircode}}</span>
			</div>
		</div>
		<div class="col-12">
			<div class="form-group ">
				<label class="control-label ">Address </label> <span
					class="control-label " style="display: block; font-weight: 600">
					{{$order->customer_address}}</span>
			</div>
		</div>
		<div class="col-12">
			<div class="form-group ">
				<label class="control-label ">Phone number </label> <span
					class="control-label " style="display: block; font-weight: 600">
					{{$order->customer_phone}}</span>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')
<script src="{{asset('js/jquery.steps_doorder.js')}}"></script>
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="{{asset('js/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('js/print.min.js')}}"></script>
<script src="{{asset('js/mdtimepicker.js')}}"></script>

<script>
	
	let user_role = '{!! auth()->user()->user_role  !!}';
	let order_is_archived = {!! $order->is_archived !!};
	
	//console.log(user_role +" "+order_is_archived)
										
	
	let autocomp_countries = JSON.parse('{!!$google_auto_comp_countries!!}');
        // var input = document.getElementById('customer_address');
        // var autocomplete = '';
        // var place = '';
        // function submitForm(e) {
        //     e.preventDefault();
        //     place = autocomplete.getPlace();
        //     console.log(place);
        //     if (!place.geometry) {
        //         // User entered the name of a Place that was not suggested and
        //         // pressed the Enter key, or the Place Details request failed.
        //         window.alert("No details available for input: '" + place.name + "'");
        //         return;
        //     } else {
        //         var place_lat = place.geometry.location.lat();
        //         var place_lon = place.geometry.location.lng();
        //         document.getElementById("lat").value = place_lat.toFixed(5);
        //         document.getElementById("lon").value = place_lon.toFixed(5);
        //
        //         // check distance if location is available
        //         a_latlng = place.geometry.location;
        //         if(b_latlng != null){
        //             var request = {
        //                 origin : a_latlng,
        //                 destination : b_latlng,
        //                 travelMode : 'DRIVING'
        //             };
        //         }
        //
        //     }
        // }
        
        
        function printDiv() {
           /*  var divContents = document.getElementById("printDiv").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print(); */
            printJS({ printable: 'printDiv', 
            		type: 'html',
            		style: '#printDiv .col-md-12 { text-align: center;}',
            		css: '{{asset('css/material-dashboard.min.css')}}'
            		})
        }

        $(document).ready(function(){
        
        	////////// steps 
        	
                $("#wizard").steps({
                    headerTag: ".wizardH4",
                    bodyTag: ".wizardSection",
                    transitionEffect: "fade",
                    enableAllSteps: true,
                    enableFinishButton: false,
                    enableNextButton: false,
                    enablePreviousButton: false,
                    transitionEffectSpeed: 300,
                    labels: {
                        next: "Continue",
                        previous: "Back",
                        finish: 'Proceed to checkout'
                    },
                    onStepChanging: function (event, currentIndex, newIndex) { 
            			//console.log(currentIndex+" "+newIndex)
            			
            			if ( newIndex === 0){
                            $('.steps ul li:first-child a img').attr('src',"{{asset('images/doorder-new-layout/order-customer-active.png')}}");
            		 		$('.forward').removeClass("disabled");
            			 	$('.backward').addClass("disabled");
            			}
            			if ( newIndex === 1 ) {
                            $('.steps ul li:nth-child(2) a img').attr('src',"{{asset('images/doorder-new-layout/order-package-active.png')}}");
                            
                            if(user_role!='retailer'){
                		 		$('.forward').removeClass("disabled");
                			 	$('.backward').removeClass("disabled");
                			 }else{
                		 		$('.forward').addClass("disabled");
                			 	$('.backward').removeClass("disabled");
                			 }	
                        } else {
                            $('.steps ul li:nth-child(2) a img').attr('src',"{{asset('images/doorder-new-layout/order-package.png')}}");
                        }
            
            if(user_role!='retailer'){
                        if ( newIndex === 2 ) {
                            $('.steps ul li:nth-child(3) a img').attr('src',"{{asset('images/doorder-new-layout/order-driver-active.png')}}");
                            
            		 		$('.forward').removeClass("disabled");
            			 	$('.backward').removeClass("disabled");
                        } else {
                            $('.steps ul li:nth-child(3) a img').attr('src',"{{asset('images/doorder-new-layout/order-driver.png')}}");
                        }
            
                        if ( newIndex === 3 ) {
                            $('.steps ul li:nth-child(4) a img').attr('src',"{{asset('images/doorder-new-layout/order-delivery-active.png')}}");
                            $('.actions ul').addClass('step-4');
                            
            		 		$('.forward').addClass("disabled");
            			 	$('.backward').removeClass("disabled");
                        } else {
                            $('.steps ul li:nth-child(4) a img').attr('src',"{{asset('images/doorder-new-layout/order-delivery.png')}}");
                            $('.actions ul').removeClass('step-4');
                        }
            }			
                        if ( newIndex >= 1 ) {
                            $('.steps ul li:first-child a img').attr('src',"{{asset('images/doorder-new-layout/order-customer-done.png')}}");
                        }
             if(user_role!='retailer'){           
            			if ( newIndex >= 2 ) {
                            $('.steps ul li:nth-child(2) a img').attr('src',"{{asset('images/doorder-new-layout/order-package-done.png')}}");
                        }
            			if ( newIndex >= 3 ) {
                            $('.steps ul li:nth-child(3) a img').attr('src',"{{asset('images/doorder-new-layout/order-driver-done.png')}}");
                        }
            }
                        
                        return true; 
                    }
            });
             $('.backward').addClass('disabled')
            // Custom Button Jquery Steps
            $('.forward').click(function(){
            	
            	$("#wizard").steps('next');
            	if(user_role!='retailer'){
                	if($("#wizard").steps("getCurrentIndex") == 3){
                		 $('.forward').addClass("disabled");
                	}else{
                		 $('.forward').removeClass("disabled");
                	}
            	}
            	else{
                	if($("#wizard").steps("getCurrentIndex") == 1){
                		 $('.forward').addClass("disabled");
                	}else{
                		 $('.forward').removeClass("disabled");
                	}
            	}
            	if($("#wizard").steps("getCurrentIndex") >0){
            		 $('.backward').removeClass("disabled");
            	}
            })
            $('.backward').click(function(){
                $("#wizard").steps('previous');
                //if(user_role!='retailer'){
                	if($("#wizard").steps("getCurrentIndex") == 0){
                		 $('.backward').addClass("disabled");
                	}else{
                		 $('.backward').removeClass("disabled");
                	}
                //}	
            	
            	if($("#wizard").steps("getCurrentIndex") < 3){
            		 $('.forward').removeClass("disabled");
            	}
            })
            // Create Steps Image
            $('.steps ul').addClass('row justify-content-center');
            $('.steps li').addClass('col-xl-2 col-3 text-lg-left text-center');
            
            if(user_role!='retailer'){
                $('.steps ul li:first-child').append('<img src="{{asset('images/doorder-new-layout/arrow-next.png')}}" alt="" class="step-arrow">')
                		.find('a').append('<div class="row"> <div class="col-lg-2  p-0"> <img src="{{asset('images/doorder-new-layout/order-customer-active.png')}}" alt=""> </div> <div class="col-lg-10 "> <p class="step-order step-order-title">Customer</p><span class="step-order step-order-subtitle">Customer Info </span> </div></div>');
                $('.steps ul li:nth-child(2)').append('<img src="{{asset('images/doorder-new-layout/arrow-next.png')}}" alt="" class="step-arrow">')
                		.find('a').append('<div class="row"> <div class="col-lg-2  p-0"> <img src="{{asset('images/doorder-new-layout/order-package.png')}}" alt=""> </div> <div class="col-lg-10 "> <p class="step-order step-order-title">Package</p><span class="step-order step-order-subtitle">Package Details </span> </div></div>');
                $('.steps ul li:nth-child(3)').append('<img src="{{asset('images/doorder-new-layout/arrow-next.png')}}" alt="" class="step-arrow">')
                		.find('a').append('<div class="row"> <div class="col-lg-2  p-0"> <img src="{{asset('images/doorder-new-layout/order-driver.png')}}" alt=""> </div> <div class="col-lg-10 "> <p class="step-order step-order-title">Deliverers</p><span class="step-order step-order-subtitle">Select Your Deliverer </span> </div></div>');
                $('.steps ul li:last-child a').append('<div class="row"> <div class="col-lg-2  p-0"> <img src="{{asset('images/doorder-new-layout/order-delivery.png')}}" alt=""> </div> <div class="col-lg-10 "> <p class="step-order step-order-title">Delivery Details</p><span class="step-order step-order-subtitle">Review Delivery Status</span> </div></div>');
            }
            else{
            	$('.steps ul li:first-child').append('<img src="{{asset('images/doorder-new-layout/arrow-next.png')}}" alt="" class="step-arrow">')
                		.find('a').append('<div class="row"> <div class="col-lg-2  p-0"> <img src="{{asset('images/doorder-new-layout/order-customer-active.png')}}" alt=""> </div> <div class="col-lg-10 "> <p class="step-order step-order-title">Customer</p><span class="step-order step-order-subtitle">Customer Info </span> </div></div>');
                $('.steps ul li:last-child a').append('<div class="row"> <div class="col-lg-2  p-0"> <img src="{{asset('images/doorder-new-layout/order-package.png')}}" alt=""> </div> <div class="col-lg-10 "> <p class="step-order step-order-title">Package</p><span class="step-order step-order-subtitle">Package Details </span> </div></div>');
               
            }
            
            $('#wizard .actions').html("")
            
            if(user_role!='retailer'){
            	if(order_is_archived == 1){
                	$("#wizard").steps('next');
                	$("#wizard").steps('next');
                	$("#wizard").steps('next');  
                	 $('.forward').addClass("disabled");
                	  $('.backward').removeClass("disabled");          	
                }
            }    
        	
        	////////// end steps 
        
        
        	$("#fulfilment").datetimepicker({
                     icons: { time: "fa fa-clock",
								date: "fa fa-calendar",
								up: "fa fa-chevron-up",
								down: "fa fa-chevron-down",
								previous: 'fa fa-chevron-left',
								next: 'fa fa-chevron-right',
								today: 'fa fa-screenshot',
								clear: 'fa fa-trash',
								close: 'fa fa-remove'
							},
            });
        	
        	$('#minimizeSidebar').trigger('click');
        
        	$("#notify-all-drivers").click(function () {
                 $('.selectedDriverDiv .form-check label .driverCheckbox').not(this).prop('checked', this.checked);
                 
                 $('.selectedDriverDiv .form-check label .driverCheckbox').each(function(i, obj) {
                        //console.log($(this))
                        if($(this)[0].checked){
                     	  	$(this).parent().parent().parent().addClass('selected');
                     	}else{
                     	  	$(this).parent().parent().parent().removeClass('selected');
                     	}
                  });
                 
                  if ($('.driverCheckbox:checked').length) {
                    $("#assignDriverButton").removeAttr('disabled');
                  } else {
                  	$('#assignDriverButton').attr('disabled', 'disabled');
                  }
             });
             //$("#notify-all-drivers").click(function () {
             
             $(".selectedDriverDiv .form-check label .driverCheckbox").on("change", function(){
             		//console.log( ":D" )	
             	  if($(this)[0].checked){
             	  	$(this).parent().parent().parent().addClass('selected');
             	  }	else{
             	  	$(this).parent().parent().parent().removeClass('selected');
             	  }
             			
                  if ($('.driverCheckbox:checked').length) {
                    $("#assignDriverButton").removeAttr('disabled');
                  } else {
                  	$('#assignDriverButton').attr('disabled', 'disabled');
                  	$("#notify-all-drivers").prop('checked', false);
                  }
             });
             
            
            
            var slider = new Slider("#kmAwayInput", {
            	tooltip: 'hide',
            	tooltip_position:"bottom",
            	formatter: function(value) {
            		$("#kmAwaySpan").text(value+' km')
					return  value+' km';
				},
            });
            slider.on("slideStop",function(){
            	//console.log("stop");
            	var valKm = $("#kmAwayInput").val();
            	//console.log("change km "+valKm);
            	$("#kmAwaySpan").text(valKm+' km')
            	
            	$('.deliverer-card').each(function(i, obj) {
//                     console.log(i );
//                     console.log($(obj).data('driverkmaway'));
//                     console.log($(obj).find('.driverCheckbox').data('driver-away'));
//                     console.log('----');
//                     console.log(typeof valKm )
                    if($(obj).data('driverkmaway') <= parseFloat(valKm) || parseFloat(valKm)===0){	
                         $(obj).css("display","block");
                         $(obj).addClass("selectedDriverDiv");
                         $(obj).removeClass("notselectedDriverDiv");
                         // console.log($(obj).find('.driverCheckbox'))
                    	$(obj).find('.driverCheckbox').prop('checked', true);
                    }else{
                    	$(obj).css("display","none");
                         $(obj).addClass("notselectedDriverDiv");
                         $(obj).removeClass("selectedDriverDiv");
                    	$(obj).find('.driverCheckbox').prop('checked', false);
                    }
                    
                });
                $(".driverCheckbox").trigger("change");
                
                
                 let customer_address_lat = $("#customer_lat").val();
                 let customer_address_lon = $("#customer_lon").val();
                 home_address_circle.setRadius(parseInt(valKm) * 1000);
            });
            
            
        });
                
        
        let map;
        let customer_marker;
        let customer_latlng = null;
        let pickup_marker;
        let pickup_latlng = null;
        let home_address_circle;

		function initMap(){
			 var existCondition = setInterval(function() {
             if ($('#map-container').length && $('#map').length) {
               // console.log("Exists!");
                clearInterval(existCondition);
                doInitMap();
             }
            }, 500); // check every 100ms
		}
		
        function doInitMap() {
        	var directionsService = new google.maps.DirectionsService();
        	
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });
            
            
            
           
            let customer_address = document.getElementById('customer_address');
            //Mutation observer hack for chrome address autofill issue
            let observerHackAddress = new MutationObserver(function() {
                observerHackAddress.disconnect();
                customer_address.setAttribute("autocomplete", "new-password");
            });
            observerHackAddress.observe(customer_address, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete = new google.maps.places.Autocomplete(customer_address);
            autocomplete.setComponentRestrictions({'country': autocomp_countries});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                // console.log(place);
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                    var place_lat = place.geometry.location.lat();
                    var place_lon = place.geometry.location.lng();
                    document.getElementById("customer_lat").value = place_lat.toFixed(5);
                    document.getElementById("customer_lon").value = place_lon.toFixed(5);

                    // // check distance if location is available
                    // a_latlng = place.geometry.location;
                    // if(b_latlng != null){
                    //     var request = {
                    //         origin : a_latlng,
                    //         destination : b_latlng,
                    //         travelMode : 'DRIVING'
                    //     };
                    // }

                }
            });

            customer_marker = new google.maps.Marker({
                map: map,
                 anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/doorder_driver_assets/customer-address-pin.png')}}", // url
                            scaledSize: new google.maps.Size(40, 45), // scaled size
                        },
            });
            customer_marker.setVisible(false);
            let customer_address_lat = $("#customer_lat").val();
            let customer_address_lon = $("#customer_lon").val();
            if(customer_address_lat!=null && customer_address_lat!='' &&
                customer_address_lon!=null && customer_address_lon!=''){
                customer_marker.setPosition({lat: parseFloat(customer_address_lat),lng: parseFloat(customer_address_lon)});
                map.setCenter({lat: parseFloat(customer_address_lat),lng: parseFloat(customer_address_lon)});
                customer_marker.setVisible(true);
            }

            pickup_marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29), icon: {
                            url:"{{asset('images/doorder_driver_assets/pickup-address-pin-grey.png')}}", // url
                            scaledSize: new google.maps.Size(40, 45), // scaled size
                        },
            });
            pickup_marker.setVisible(false);
            let pickup_address_lat = $("#pickup_lat").val();
            let pickup_address_lon = $("#pickup_lon").val();
            // console.log(pickup_address_lat,pickup_address_lon);
            if(pickup_address_lat!=null && pickup_address_lat!='' &&
                pickup_address_lon!=null && pickup_address_lon!=''){
                pickup_marker.setPosition({lat: parseFloat(pickup_address_lat),lng: parseFloat(pickup_address_lon)});
                pickup_marker.setVisible(true);
            }
            
             home_address_circle = new google.maps.Circle({
                    center: {lat: parseFloat(pickup_address_lat), lng: parseFloat(pickup_address_lon)},
                    map: map,
                    radius: 0,
                    strokeColor: "#f5da68",
                    strokeOpacity: 0.8,
                    strokeWeight: 1,
                    fillColor: "#f5da68",
                    fillOpacity: 0.4,
            	});
            
			let drivers = {!! $available_drivers !!};
            // console.log(drivers);
            for(let i=0; i<drivers.length; i++){
            	if(drivers[i].latest_coordinates!=null) {
					let driver_coordinates = JSON.parse(drivers[i].latest_coordinates);
					// console.log(driver_coordinates);

					let driver_marker = new google.maps.Marker({
						map: map,
						icon: {
							url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}", // url
							scaledSize: new google.maps.Size(40, 45), // scaled size
						},
					});
					driver_marker.setPosition({
						lat: parseFloat(driver_coordinates.lat),
						lng: parseFloat(driver_coordinates.lng)
					});
					driver_marker.setVisible(true);

					//getDriverKmAway(directionsService,JSON.parse(drivers[i].latest_coordinates),drivers[i].user_id);
// 					console.log(google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(parseFloat(pickup_address_lat), parseFloat(pickup_address_lon)),
// 							new google.maps.LatLng(parseFloat(driver_coordinates.lat), parseFloat(driver_coordinates.lng))))
					var distance = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(parseFloat(pickup_address_lat), parseFloat(pickup_address_lon)),
							new google.maps.LatLng(parseFloat(driver_coordinates.lat), parseFloat(driver_coordinates.lng)));
					$("#km-away-" + drivers[i].user_id + " span").html(parseFloat(distance / 1000).toFixed(2) + " km");
					$('#driver-' + drivers[i].user_id).data('driverkmaway', parseFloat(distance / 1000).toFixed(2)); //setter
					$('#driver-' + drivers[i].user_id + ' .driverCheckbox').data('driver-away', parseFloat(distance / 1000).toFixed(2));

					var infowindow = new google.maps.InfoWindow();

					var content = '<div> <h6 class="recommendDriverNameH6 deliverer-name">' + drivers[i].first_name + ' ' + drivers[i].last_name
							+ ' </h6> <p class="recommendDriverDataP"> ' + drivers[i].transport + ' ('
							+ parseFloat(distance / 1000).toFixed(2) + 'km away) </p> </div>'
					var winLatLng = new google.maps.LatLng(parseFloat(driver_coordinates.lat), parseFloat(driver_coordinates.lng));

					google.maps.event.addListener(driver_marker, 'click', (function (driver_marker, content, infowindow, winLatLng) {
						return function () {
							infowindow.setContent(content);
							//infowindow.setPosition(winLatLng);
							infowindow.open(map, driver_marker);
						};
					})(driver_marker, content, infowindow, winLatLng));
					//   google.maps.event.trigger(driver_marker, 'click');
				} else {
					$("#km-away-" + drivers[i].user_id + " span").html("N/A" + " km");
					$('#driver-' + drivers[i].user_id).data('driverkmaway', '999999'); //setter
					$('#driver-' + drivers[i].user_id + ' .driverCheckbox').data('driver-away', '999999');
				}
            }
        }  

        function showAssignDriverModal(){
        
        	
                 let customer_address_lat = $("#customer_lat").val();
                 let customer_address_lon = $("#customer_lon").val();
                 
                 if(customer_address_lat!=null && customer_address_lat!='' &&
                        customer_address_lon!=null && customer_address_lon!=''){
                	
                	//console.log($("input[name=selected-driver]").val())
                	var assignedDriversHtml ='';
                	$(".driverCheckbox:checked").each(function(){
//                 		console.log($(this));
//                 		console.log($(this).val());
                		
                					
                		assignedDriversHtml += '<div id="driver-'+ $(this).data("driver-id") +'" class="card deliverer-card selectedDriverDiv " '
                							+ ' data-driverkmaway="' +$(this).data("driver-away")
                							+'"> <input type="hidden" name="selected-driver[]" value="'
                							+$(this).data("driver-id")
                							+'"> <div class="card-header deliverer-details row"> '
                							+' <div class="col-12 text-center"> <h6 class="recommendDriverNameH6 deliverer-name">'+ $(this).data("driver-name")
                							+'</h6></div>  <div class="col-12 text-center mt-2"> <p class="recommendDriverDataP mr-1">'
                							+ $(this).data("driver-transport")
                							+'</p><p class="recommendDriverDotP"> 	<i class="fas fa-circle"></i> 	</p>'
                							+'<p class="recommendDriverDataKmP ml-1" > '
                							+$(this).data("driver-away") +' km away	</p> </div>  </div>  </div>'
                	});
                	
                	$("#assignedDriversDiv").html(assignedDriversHtml);
                	$('#assign-deliverer-modal').modal('show');
                   /*  let driver_card = $('#driver-'+driver_id);
                    let driver_name = driver_card.data('driver-name');
                    $('#deliverer-modal-name').html(driver_name);
                    $('#driver-id').val(driver_id);
                    $('#assign-deliverer-modal').modal('show') */
                }else{
                	$('#warning-address-modal').modal('show');
                }
        }

		$('#notify-all-drivers-modal').on('hidden.bs.modal', function () {
			$('#notify-all-drivers').prop('checked',false);
		});

        function showNotifyAllDrivers(){
        	if($('#notify-all-drivers').is(':checked')){
        		$('#driver-id').val('all');
				$('#notify-all-drivers-modal').modal('show');
			}
		}
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
