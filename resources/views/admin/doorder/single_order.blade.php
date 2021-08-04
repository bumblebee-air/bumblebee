@extends('templates.dashboard') @section('page-styles')

<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.css">
<style>
div[data-toggle='collapse'] {
	cursor: pointer;
}

.deliverers-container .deliverer-card {
	margin-top: 0;
	margin-bottom: 15px;
	cursor: pointer;
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
	font-family: Quicksand;
	font-size: 15px;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.2;
	letter-spacing: normal;
	font-weight: 500;
	color: #bfa436;
	margin-bottom: 0;
}

.recommendDriverDataP, .notifyAllLabel {
	font-family: Quicksand;
	font-size: 15px;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.2;
	letter-spacing: normal;
	font-weight: normal;
	color: #656565;
	margin-bottom: 0;
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

.form-check .form-check-sign .check {
	border-radius: 5px;
	border: solid 2px #979797;
}

.form-check .form-check-input:checked ~.form-check-sign .check {
	background: #e8ca49;
	border: solid 2px #e8ca49;
}

.btn.disabled, .btn:disabled {
	background-color: #b1b1b1 !important;
	opacity: 1 !important;
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

.slider-track-high {
	background: rgba(247, 220, 105, 0.4) !important;
}

.slider-selection {
	background-color: #f7dc69;
	background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f7dc69),
		to(#f7dc69));
	background-image: -webkit-linear-gradient(top, #f7dc69, #f7dc69);
	background-image: -o-linear-gradient(top, #f7dc69, #f7dc69);
	background-image: linear-gradient(to bottom, #f7dc69, #f7dc69);
}

.slider-handle {
	transform: rotate(90deg);
	border: solid 2px #eeeeee;
	background-color: #ffffff;
	background-image: none !important;
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
</style>
@endsection @section('title','DoOrder | View Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">

		<div class="row">
			<div class="col-12 col-sm-6" id="details-container">
				<div class="card">
					<div class="card-header card-header-icon card-header-rose">
						<div class="card-icon">
							<img class="page_icon"
								src="{{asset('images/doorder_icons/orders_table_white.png')}}">
						</div>
						<h4 class="card-title ">Order Number {{$order->order_id}}</h4>
						<h5 class="card-category ">
							Order Status @if($order->status == 'pending') <img
								class="status_icon"
								src="{{asset('images/doorder_icons/order_status_pending.png')}}"
								alt="pending"> <span class="statusSpan"> Pending order
								fulfilment</span> @elseif($order->status == 'ready') <img
								class="status_icon"
								src="{{asset('images/doorder_icons/order_status_ready.png')}}"
								alt="ready"> <span class="statusSpan"> Ready to collect</span>
							@elseif($order->status == 'matched' || $order->status ==
							'assigned') <img class="status_icon"
								src="{{asset('images/doorder_icons/order_status_matched.png')}}"
								alt="matched"> <span class="statusSpan"> Matched </span>
							@elseif($order->status == 'on_route_pickup') <img
								class="status_icon"
								src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}"
								alt="matched"> <span class="statusSpan"> On-route to pickup </span>
							@elseif($order->status == 'picked_up') <img class="status_icon"
								src="{{asset('images/doorder_icons/order_status_picked_up.png')}}"
								alt="picked up"> <span class="statusSpan"> Picked up </span>
							@elseif($order->status == 'on_route') <img class="status_icon"
								src="{{asset('images/doorder_icons/order_status_on_route.png')}}"
								alt="on route"> <span class="statusSpan"> On-route </span>
							@elseif($order->status == 'delivery_arrived') <img
								class="status_icon"
								src="{{asset('images/doorder_icons/order_status_delivery_arrived.png')}}"
								alt="on route"> <span class="statusSpan"> Arrived to location </span>
							@elseif($order->status == 'delivered') <img class="status_icon"
								src="{{asset('images/doorder_icons/order_status_delivered.png')}}"
								alt="delivered"> <span class="statusSpan"> Delivered </span>
							@endif
						</h5>
					</div>
					<div style="padding: 10px 0;"></div>
				</div>
				<form method="POST" id="assign-driver"
					action="{{url('doorder/order/assign')}}">
					@csrf <input type="hidden" id="order-id" name="order_id"
						value="{{$order->id}}" />
					<div class="card">
						<div class="card-header" data-toggle="collapse"
							id="customer-details-header" data-target="#customer-details"
							aria-expanded="true" aria-controls="customer-details">
							<div class="d-flex form-head">
								<span>1</span> Customer Details
							</div>
						</div>
						<div id="customer-details" class="collapse show"
							aria-labelledby="customer-details-header"
							data-parent="#details-container">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label for="first_name" class="control-label">First Name:</label>
												<input id="first_name" type="text" class="form-control"
													value="{{$order->first_name}}" name="first_name" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="last_name" class="control-label">Last Name:</label>
												<input id="last_name" type="text" class="form-control"
													value="{{$order->last_name}}" name="last_name" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="email" class="control-label">Email:</label> <input
													id="email" type="email" class="form-control"
													value="{{$order->customer_email}}" name="email">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="customer_phone" class="control-label">Contact
													Number:</label> <input id="customer_phone" type="tel"
													class="form-control" value="{{$order->customer_phone}}"
													name="customer_phone" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="customer_address" class="control-label">Address:</label>
												<input id="customer_address" type="text"
													class="form-control" value="{{$order->customer_address}}"
													name="customer_address" required> <input type="hidden"
													name="customer_lat" id="customer_lat"
													value="{{$order->customer_address_lat}}"> <input
													type="hidden" name="customer_lon" id="customer_lon"
													value="{{$order->customer_address_lon}}">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="eircode" class="control-label">Eircode:</label>
												<input id="eircode" type="text" class="form-control"
													value="{{$order->eircode}}" name="eircode">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header" data-toggle="collapse"
							id="package-details-header" data-target="#package-details"
							aria-expanded="true" aria-controls="package-details">
							<div class="d-flex form-head">
								<span>2</span> Package Details
							</div>
						</div>
						<div id="package-details" class="collapse"
							aria-labelledby="package-details-header"
							data-parent="#details-container">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label for="pick_address" class="control-label">Pickup
													Address</label> <input id="pick_address"
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
													Fulfilment</label> <input id="fulfilment" type="text"
													name="fulfilment" class="form-control"
													value="{{$order->fulfilment}}" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="weight" class="control-label">Package Weight in
													Kg</label> <input id="weight" type="text"
													class="form-control" name="weight"
													value="{{$order->weight}}" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="dimensions" class="control-label">Package
													Dimensions in cm</label> <input id="dimensions" type="text"
													name="dimensions" class="form-control"
													value="{{$order->dimensions}}" required>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="notes" class="control-label">Other Details</label>
												<input id="notes" type="text" name="notes"
													class="form-control" value="{{$order->notes}}">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="deliver_by" class="control-label">Deliver By:</label>
												<select id="deliver_by" name="deliver_by"
													data-style="select-with-transition"
													class="form-control selectpicker">
													<option value="car" @if($order->deliver_by=='car') selected
														@endif>Car</option>
													<option value="scooter" @if($order->deliver_by=='scooter')
														selected @endif>Scooter</option>
												</select>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="fragile" class="control-label">Fragile Package?</label>
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
									</div>
								</div>
							</div>
						</div>
					</div>

				</form>
				@if(auth()->user()->user_role != 'retailer') @if($order->status ==
				'delivered')
				<div class="card">
					<div class="card-header" data-toggle="collapse"
						id="order-deliverer-details-header"
						data-target="#order-deliverer-details" aria-expanded="true"
						aria-controls="order-deliverer-details">
						<div class="d-flex form-head">
							<span>3</span> Order's Deliverer Details
						</div>
					</div>
					<div id="order-deliverer-details" class="collapse"
						aria-labelledby="order-deliverer-details-header"
						data-parent="#details-container">
						<div class="card-body" style="padding-top: 20px !important;">
							<div class="container">
								<div class="row">
									<div class="col-12 text-center">
										<p class="control-label" style="font-weight: normal">Order has
											already been delivered</p>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label for="fulfilment" class="control-label">Driver Name</label>
											<input id="fulfilment" type="text" name="fulfilment"
												class="form-control" value="{{$order->orderDriver->name}}"
												required>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label for="fulfilment" class="control-label">Delivery Status</label>
											<input id="fulfilment" type="text" name="fulfilment"
												class="form-control"
												value="{{$order->delivery_confirmation_status && $order->delivery_confirmation_status == 'confirmed' ? 'The customer has confirmed the delivery' : 'The deliverer has skipped the confirmation'}}"
												required>
										</div>
									</div>
									@if($order->delivery_confirmation_status != 'confirmed')
									<div class="col-12">
										<div class="form-group">
											<label for="fulfilment" class="control-label">Delivery Skip
												Reason</label> <input id="fulfilment" type="text"
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
				<div class="card">
					<div class="card-header" data-toggle="collapse"
						id="deliverer-assign-header" data-target="#deliverer-assign"
						aria-expanded="true" aria-controls="deliverer-assign">
						<div class="d-flex form-head">
							<span>3</span> Deliverers
						</div>
					</div>

					<div id="deliverer-assign" class="collapse"
						aria-labelledby="deliverer-assign-header"
						data-parent="#details-container">
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-7 ">

										<img class=""
											src="{{asset('images/doorder_driver_assets/customer-address-pin.png')}}"
											style="width: 13px; height: 15px"> <span
											id="customerAddressSpan">{{$order->customer_address}}</span>
									</div>
									<div class="col-md-5 ">
										<input id="kmAwayInput" data-slider-id='kmAwayInputSlider'
											type="text" data-slider-min="0" data-slider-max="60"
											data-slider-step="1" data-slider-value="0" />
									</div>
								</div>
								<div class="row mt-2" data-spy="scroll"
									data-target=".deliverers-container" data-offset="50">
									<div class="col-12 deliverers-container overflow-auto"
										style="max-height: 330px">
										<div class="card-header row">
											<div class="form-check">
												<label class="form-check-label notifyAllLabel"
													for="notify-all-drivers"> <input type="checkbox"
													class="form-check-input" id="notify-all-drivers" /> Notify
													all drivers <span class="form-check-sign"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>

										@foreach($available_drivers as $driver)
										<div id="driver-{{$driver->user_id}}"
											class="card deliverer-card selectedDriverDiv"
											data-driverkmaway="0">

											<input type="checkbox" class="driverCheckbox"
												id="radioInputDriver-{{$driver->user_id}}"
												value="{{$driver->user_id}}"
												data-driver-id="{{$driver->user_id}}"
												data-driver-name="{{$driver->user->name}}"
												data-driver-transport="{{$driver->transport}}"
												data-driver-away="0"> <label
												class="form-check-label w-100 px-0"
												for="radioInputDriver-{{$driver->user_id}}">
												<div class="card-header deliverer-details row">
													<div class="col-6">
														<h6 class="recommendDriverNameH6 deliverer-name">{{$driver->first_name}}
															{{$driver->last_name}}</h6>
														<p class="recommendDriverDataP">{{$driver->transport}}</p>
														<p class="recommendDriverDataP"
															id="km-away-{{$driver->user_id}}">
															<span></span> away
														</p>
													</div>
													<div class="col-6 colCheckCircleDiv"
														style="text-align: right">
														<i class="fas fa-check-circle"></i>
													</div>
												</div>
											</label>
										</div>
										@endforeach
									</div>
								</div>

								<div class="row mt-3">
									<div class="col-sm-12 text-center">

										<button type="button" id="assignDriverButton"
											class="btn bt-submit  w-50 orderSubmitButton"
											onclick="showAssignDriverModal()" disabled="disabled">Assign
											Deliverer</button>
									</div>
								</div>


							</div>
						</div>
					</div>
				</div>

				@endif @endif @if(auth()->user()->user_role != 'retailer')
				<div class="card">
					<form method="POST" id="update-order-status"
						action="{{url('doorder/order/update')}}">
						@csrf <input type="hidden" id="order-id" name="order_id"
							value="{{$order->id}}" />
						<div class="card-header" data-toggle="collapse"
							id="deliverer-details-header" data-target="#deliverer-details"
							aria-expanded="true" aria-controls="deliverer-details">
							<div class="d-flex form-head">
								<span>4</span> Delivery Details
							</div>
						</div>

						<div id="deliverer-details" class="collapse"
							aria-labelledby="deliverer-details-header"
							data-parent="#details-container">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label class="control-label">Driver assigned </label> <span
													class="control-label"
													style="display: block; font-weight: 600">
													@if($order->orderDriver) {{$order->orderDriver->name}}
													@else N/A @endif </span>
											</div>
										</div>

										<div class="col-12">
											<div class="form-group">
												<label for="order_status" class="control-label">Order status</label>
												<select id="order_status" name="order_status"
													data-style="select-with-transition"
													class="form-control selectpicker">
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
												<textarea rows="" cols="" name="comment"
													class="form-control"></textarea>
											</div>
										</div>
									</div>

									<div class="row mt-3">
										<div class="col-sm-12 text-center">

											<button type="submit" id="submitChangeSatus"
												class="btn bt-submit  w-50 orderSubmitButton">Submit</button>
										</div>
									</div>
								</div>
							</div>
						</div>


					</form>
				</div>
				@endif

			</div>
			<div class="col-12 col-sm-6" id="map-container">
				<div id="map"
					style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
			</div>
		</div>

		@if(auth()->user()->user_role != 'retailer')
		<div class="row mt-5">

			<div class="col-sm-6 offset-sm-3 text-center">
				<button class="btn bt-submit btn-danger" type="button"
					data-toggle="modal" data-target="#delete-order-modal">Delete Order</button>
			</div>
		</div>
		@endif

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
					<div class="modal-dialog-header">
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
				<div class=" row">
					<div class="col-sm-6">
						<button type="submit"
							class="btn btn-primary doorder-btn-lg doorder-btn">Assign</button>
					</div>
					<div class="col-sm-6">

						<button type="button"
							class="btn btn-danger doorder-btn-lg doorder-btn"
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
					<div class="modal-dialog-header deleteHeader">Are you sure you want
						to delete this order?</div>
					<div>
						<input type="hidden" id="orderId" name="orderId"
							value="{{$order->id}}" />

					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<button type="sub"
							class="btn btn-primary doorder-btn-lg doorder-btn">Yes</button>
					</div>
					<div class="col-sm-6">
						<button type="button"
							class="btn btn-danger doorder-btn-lg doorder-btn"
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
				<div class="col-md-12">

					<div class="text-center">
						<img src="{{asset('images/doorder_icons/warning_icon.png')}}"
							style="width: 120px" alt="warning">
					</div>
					<div class="text-center mt-3">
						<label class="warning-label">Please ensure to select drop down
							address suggestion to move forward</label>

					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
<script>
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
        
        

        $(document).ready(function(){
        	
        	$('#minimizeSidebar').trigger('click')
        
        	$("#notify-all-drivers").click(function () {
                 $('.selectedDriverDiv .driverCheckbox').not(this).prop('checked', this.checked);
                 
                  if ($('.driverCheckbox:checked').length) {
                    $("#assignDriverButton").removeAttr('disabled');
                  } else {
                  	$('#assignDriverButton').attr('disabled', 'disabled');
                  }
             });
             
             $(".driverCheckbox").on("change", function(){
                  if ($('.driverCheckbox:checked').length) {
                    $("#assignDriverButton").removeAttr('disabled');
                  } else {
                  	$('#assignDriverButton').attr('disabled', 'disabled');
                  	$("#notify-all-drivers").prop('checked', false);
                  }
             });
             
            
            
            var slider = new Slider("#kmAwayInput", {
            	tooltip: 'always',
            	tooltip_position:"bottom",
            	formatter: function(value) {
					return  value+' km';
				},
            });
            slider.on("slideStop",function(){
            	console.log("stop");
            	var valKm = $("#kmAwayInput").val();
            	console.log("change km "+valKm);
            	
            	$('.deliverer-card').each(function(i, obj) {
                    console.log(i );
                    console.log($(obj).data('driverkmaway'));
                    console.log($(obj).find('.driverCheckbox').data('driver-away'));
                    console.log('----');
                    console.log(typeof valKm )
                    if($(obj).data('driverkmaway') <= parseFloat(valKm) || parseFloat(valKm)===0){	
                         $(obj).css("display","block");
                         $(obj).addClass("selectedDriverDiv");
                         $(obj).removeClass("notselectedDriverDiv");
                         console.log($(obj).find('.driverCheckbox'))
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

        function initMap() {
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
            autocomplete.setComponentRestrictions({'country': ['ie','gb']});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                console.log(place);
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
            console.log(pickup_address_lat,pickup_address_lon);
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
            console.log(drivers);
            for(let i=0; i<drivers.length; i++){
            	if(drivers[i].latest_coordinates!=null) {
					let driver_coordinates = JSON.parse(drivers[i].latest_coordinates);
					console.log(driver_coordinates);

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
					console.log(google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(parseFloat(pickup_address_lat), parseFloat(pickup_address_lon)),
							new google.maps.LatLng(parseFloat(driver_coordinates.lat), parseFloat(driver_coordinates.lng))))
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
                	
                	console.log($("input[name=selected-driver]").val())
                	var assignedDriversHtml ='';
                	$(".driverCheckbox:checked").each(function(){
                		console.log($(this));
                		console.log($(this).val());
                		
                		assignedDriversHtml += '<div id="driver-'+ $(this).data("driver-id") +'" class="card deliverer-card" data-driverkmaway="'
                							+$(this).data("driver-away")+'"> <input type="hidden" name="selected-driver[]" value="'
                							+$(this).data("driver-id")
                							+'"> <div class="card-header deliverer-details row"> '
                							+' <div class="col-6"> <h6 class="recommendDriverNameH6 deliverer-name">'+ $(this).data("driver-name")
                							+'</h6> <p class="recommendDriverDataP">'
                							+ $(this).data("driver-transport")
                							+'</p> <p class="recommendDriverDataP" > '
                							+$(this).data("driver-away") +' km away	</p> </div> <div class="col-6 colCheckCircleDiv assignedDriverChecked" '
                							+' style="text-align: right"> <i class="fas fa-check-circle"></i> </div> </div> </label> </div>'
                	});
                	
                	$("#assignedDriversDiv").html(assignedDriversHtml);
                	 $('#assign-deliverer-modal').modal('show')
                	
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
