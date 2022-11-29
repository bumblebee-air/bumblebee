@extends('templates.doorder_dashboard') @section('page-styles')

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	</link>

	<link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">

	<style>
		div[data-toggle='collapse'] {
			cursor: pointer;
		}

		.select2-container--default .select2-selection--multiple,
		.select2-container .select2-selection--single {
			padding: 13px 14px 11px 14px;
			border: none !important;
			border-radius: 5px;
			box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
			background-color: #ffffff;
			font-size: 14px;
			font-weight: normal;
			font-stretch: normal;
			font-style: normal;
			line-height: normal;
			letter-spacing: 0.66px;
			color: #656565;
			width: 100%;
			height: auto !important;
		}

		.select2-container .select2-selection--single {
			padding: 11px 14px 11px 14px;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 1.2 !important;
		}

		.select2-container--default.select2-container--disabled .select2-selection--multiple {
			background-color: #fff !important;
		}

		#add-orders-modal .modal-dialog,
		#edit-order-modal .modal-dialog {
			min-height: 70%;
			width: 75%;
			margin-top: 40px
		}

		#add-orders-modal .modal-content,
		#add-orders-modal .modal-body,
		#edit-order-modal .modal-content,
		#edit-order-modal .modal-body {
			padding-right: 10px;
			padding-left: 10px;
			padding-top: 15px;
			padding-bottom: 10px
		}

		#add-orders-modal .modal-dialog .modal-header .close,
		#edit-order-modal .modal-dialog .modal-header .close {
			margin-right: 20px;
			right: 0;
		}

		#add-orders-modal input[type=checkbox],
		#edit-order-modal input[type=checkbox] {
			display: none
		}

		#add-orders-modal #ordersTable thead th:first-child,
		#add-orders-modal #ordersTable tbody td:first-child,
		#edit-order-modal #ordersTable thead th:first-child,
		#edit-order-modal #ordersTable tbody td:first-child {
			width: 20px
		}

		#add-orders-modal .modal-header .modal-dialog-header,
		#edit-order-modal .modal-header .modal-dialog-header {
			font-family: Montserrat;
			font-style: normal;
			font-weight: 600;
			font-size: 22px;
			line-height: 30px;
			text-align: center;
			color: #e9c218;
			margin-top: 10px;
			margin-bottom: 15px;
			margin-left: 20px
		}

		#add-orders-modal .modal-header,
		#edit-order-modal .modal-header {
			border-bottom: 1px solid #D8D8D8;
			/* padding-bottom: 10px */
		}

		#add-orders-modal div.dataTables_wrapper div.dataTables_filter input,
		#edit-order-modal div.dataTables_wrapper div.dataTables_filter input {
			height: 40px
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

		.recommendDriverDataKmP span {
			position: inherit !important;
			display: inline-block !important;
		}
	</style>
	@endsection @section('title', 'DoOrder | Map Routes')
@section('page-content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12" id="map-container">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-lg-7 col-md-6 col-sm-6">

								<h4 class="card-title my-4">Route Optimization Map</h4>
							</div>
							<div class="col-12 col-lg-5 col-md-6 col-sm-6 justify-content-end">

								<button class="btnDoorder btn-doorder-green  mb-1 mt-3 w-auto float-right" id="" type="button"
									@click="clickAddOrders">Add
									orders</button>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-xl-9 col-md-8 pr-0">
							<div class="card mt-1 mb-0" style="background: transparent; box-shadow: none">

								<div class="card-body p-0">
									<div id="map" style="width: 100%; height: 100%; min-height: 550px; margin-top: 0; border-radius: 6px;">
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-md-4  " id="driversListContrainer">
							<div class="card mt-1 h-100" style="max-height: 550px; overflow-y: auto;">
								<div class="card-body p-0">

									<div v-for="(route, index) in map_routes" class="card card-driver-map-route">
										<div class="card-header collapsed" data-toggle="collapse" :id="'driver-header-' + (route[0].deliverer_id)"
											:data-target="'#driver-routes-' + (route[0].deliverer_id)"
											:aria-controls="'driver-routes-' + (route[0].deliverer_id)">
											<div class="row">
												<div class="col-2 p-0 pl-1">
													<div class="card-icon card-icon-driver-profile text-center">@{{ route[0].deliverer_first_letter }}</div>
												</div>
												<div class="col-6">
													<h3 class="my-2">@{{ route[0].deliverer_name }}</h3>
												</div>

												<div class="col-2 p-0">
													<span class="collapse-arrow"></span>
												</div>
												<div class="col-2 pr-0 pl-1">
													<button type="button" class="remove btnActions btnActionsMapRoutes "
														@click="clickDeleteDriver(event,route[0].deliverer_id,index)">

														<img src="{{ asset('images/doorder-new-layout/delete-icon.png') }}">
													</button>
												</div>
											</div>
										</div>

										<div :id="'driver-routes-' + (route[0].deliverer_id)" class="collapse"
											:aria-labelledby="'driver-header-' + (route[0].deliverer_id)" data-parent="#driversListContrainer">
											<div class="card-body p-0">
												<div class="container pb-0">
													<br />
													<ul class="timeline mb-0 pr-0" v-if="route.slice(1).length>0">
														<li class="timeline-item" v-for="(driver_route, indexO) in route.slice(1)"
															:id="'order-' + driver_route.type + '-' + driver_route.order_id">
															<div class="timeline-badge"></div>
															<div class="timeline-panel">
																<div class="timeline-heading">
																	<h4 class="timeline-title">
																		<div class="row">
																			<div class="col-7">
																				Order #@{{ driver_route.order_id }}
																			</div>
																			<div class=" col-1 px-1"> <span v-if="driver_route.type=='dropoff'" class="float-right dropoffPin"> <i
																						class="fas fa-map-marker-alt"></i>
																				</span> <span v-if="driver_route.type=='pickup'" class="float-right pickupPin"> <i
																						class="fas fa-map-marker-alt"></i>
																				</span>
																			</div>
																			<div class=" col-2 px-1 text-center">
																				<button type="button" class="remove btnActions btnActionsMapRoutes mt-0"
																					@click="clickEditOrder( event, driver_route.order_id, indexO, index)">

																					<img src="{{ asset('images/doorder-new-layout/edit-icon.png') }}">
																				</button>
																			</div>
																			<div class=" col-2 px-1"><button type="button" class="remove btnActions btnActionsMapRoutes mt-0"
																					@click="clickDeleteOrder( event, driver_route.order_id, index)">

																					<img src="{{ asset('images/doorder-new-layout/delete-icon.png') }}">
																				</button>
																			</div>
																		</div>

																	</h4>

																</div>
															</div>
														</li>

													</ul>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<!-- end div row -->
					<div class="card" v-if="map_routes.length != 0" style="background-color: transparent; box-shadow: none;">
						<div class="card-body p-0">
							<div class="container w-100" style="max-width: 100%">

								<div class="row justify-content-center ">
									<div id="confirmRouteDiv" class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
										{{-- <a href="{{ url('doorder/confirm_route_optimization_map') }}" type="submit" id="confirmRoutesButton"
											class="btnDoorder btn-doorder-primary  mb-1">Confirm</a> --}}

										<button type="button" @click="confirmRouteOptimization()" id="confirmRoutesButton"
											class="btnDoorder btn-doorder-primary  mb-1">Confirm</button>
									</div>
									<div id="startRouteDiv" class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center" style="display: none">
										<button type="button" @click="startRouteOptimization()"
											class="btnDoorder btn-doorder-primary  mb-1">Reoptimise</button>
									</div>
									<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">

										<button class="btnDoorder btn-doorder-danger-outline  mb-1" type="button"
											onclick="cancelResultRouteOptimization()">Cancel</button>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- cancel route optimization modal -->
	<div class="modal fade" id="cancel-routes-modal" tabindex="-1" role="dialog"
		aria-labelledby="cancel-routes-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="modal-dialog-header modalHeaderMessage">Are you sure you
						want to cancel the route optimization?</div>

				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-primary mb-1"
							onclick="confirmCancelRouteOptimization()">Yes</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end cancel route optimization modal -->

	<!-- delete driver modal -->
	<div class="modal fade" id="delete-driver-modal" tabindex="-1" role="dialog"
		aria-labelledby="delete-driver-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="modal-dialog-header modalHeaderMessage">This will remove
						the driver and redistribute their orders after you click reoptimise.</div>

					<input type="hidden" id="driverId" value="" /> <input type="hidden" id="index" value="" />
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-primary mb-1"
							@click="confirmDeleteDriver()">Proceed</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end delete driver modal -->

	<!-- confirm route optimization modal  -->
	<div class="modal fade" id="confirm-route-optimization-modal" tabindex="-1" role="dialog"
		aria-labelledby="confirm-route-optimization-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="text-center">
						<img src="{{ asset('images/doorder-new-layout/confirm-img.png') }}" style="" alt="confirm">
					</div>
					<div class="modal-dialog-header modalHeaderMessage">Starting Route
						Optimization</div>
					<div class="modal-dialog-header modalSubHeaderMessage">This will restart the route optimization including any newly
						added or removed orders or drivers</div>

					<div v-if="is_order_assigned_to_other" class="modal-dialog-header modalSubHeaderMessage alert alert-warning">
						<strong>Warning!</strong> One or more orders have been manually reassigned to drivers. This action will overwrite
						this.
					</div>


				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-primary mb-1"
							@click="clickConfirmStartRouteOptimization()">Ok</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end confirm route optimization modal  -->

	<!-- warning modal -->
	<div class="modal fade" id="warning-route-modal" tabindex="-1" role="dialog"
		aria-labelledby="warning-route-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<div class="col-md-12">

							<div class="text-center">
								<img src="{{ asset('images/doorder-new-layout/warning-icon.png') }}" style="" alt="warning">
							</div>
							<div class="text-center mt-3">
								<label class="warning-label" id="routeErrorMessage">The route
									optimization algorithm was unable to find optimal routes for the
									selected orders and deliverers </label>

							</div>
						</div>
					</div>

					<div class="row justify-content-center mt-3">

						<div class="col-lg-4 col-md-6 text-center">
							<button type="button" class="btnDoorder btn-doorder-primary mb-1" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end warning modal -->


	<!-- warning no routes modal -->
	<div class="modal fade" id="warning-no-route-modal" tabindex="-1" role="dialog"
		aria-labelledby="warning-route-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<div class="col-md-12">

							<div class="text-center">
								<img src="{{ asset('images/doorder-new-layout/warning-icon.png') }}" style="" alt="warning">
							</div>
							<div class="text-center mt-3">
								<label class="warning-label">No routes found</label>

							</div>
						</div>
					</div>

					<div class="row justify-content-center mt-3">

						<div class="col-lg-4 col-md-6 text-center">
							<a class="btnDoorder btn-doorder-primary mb-1" href="{{ route('doorder_ordersTable', 'doorder') }}">Back to
								orders
							</a>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end warning no route modal -->

	<!-- delete order modal -->
	<div class="modal fade" id="delete-order-modal" tabindex="-1" role="dialog" aria-labelledby="delete-order-label"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="modal-dialog-header modalHeaderMessage">Are you sure you want to remove this order from the optimized
						list?</div>
					{{-- <div class="modal-dialog-header modalHeaderMessage">This will remove
						the driver and redistribute their orders after you click start.</div> --}}

					<input type="hidden" id="orderId" value="" /> <input type="hidden" id="index" value="" />
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-primary mb-1" @click="confirmDeleteOrder()">Yes</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end delete order modal -->

	<!-- add orders modal -->
	<div class="modal fade" id="add-orders-modal" tabindex="-1" role="dialog" aria-labelledby="add-orders-label"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-dialog-header ">Add Orders</div>

					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" id="delete-driver" action="{{ url('doorder/assign_orders') }}"
						style="margin-bottom: 0 !important;">
						{{ csrf_field() }}
						<div class="float-right"></div>
						<div v-if="invalid_not_selected_orders">
							<p class="errorMessage">Please
								select at least one order</p>
						</div>
						<div class="table-responsive">
							<table class="table table-no-bordered table-hover doorderTable ordersListTable" id="ordersTable"
								width="100%">
								<thead>
									<tr>
										@if (auth()->user()->user_role == 'client' || auth()->user()->user_role == 'admin')
											<th width="5%"></th>
										@endif
										<th>Date/Time</th>
										<th>Order Number</th>
										<th>Order Time</th>
										<th>Retailer</th>
										<th>Status</th>
										<th>Deliverer</th>
										<th>Location</th>
									</tr>
								</thead>

								<tbody>

									<tr v-for="order in orders" v-if="orders.length > 0" class="order-row" :data-orderId="order.id">

										@if (auth()->user()->user_role == 'client' || auth()->user()->user_role == 'admin')
											<td class="p-3">
												<input type="checkbox" name="newOrders[]" v-bind:value="order.id">

											</td>
										@endif
										<td class="text-left orderDateTimeTd">@{{ order.time }}</td>
										<td class="text-left">@{{ order.order_id.includes('#') ? order.order_id : '#' + order.order_id }}</td>
										<td class="text-left">@{{ order.fulfilment_date }}</td>
										<td class="text-left">@{{ order.retailer_name }} </td>
										<td class="text-left"><span v-if="order.status == 'pending'" class="orderStatusSpan pendingStatus">Pending
												fullfilment</span>
											<span v-if="order.status == 'ready'" class="orderStatusSpan readyStatus">Ready to Collect</span>
											<span v-if="order.status == 'matched' || order.status == 'assigned'"
												class="orderStatusSpan matchedStatus">Matched</span> <span v-if="order.status == 'on_route_pickup'"
												class="orderStatusSpan onRoutePickupStatus">On-route to
												Pickup</span> <span v-if="order.status == 'picked_up'" class="orderStatusSpan pickedUpStatus">Picked
												up</span> <span v-if="order.status == 'on_route'" class="orderStatusSpan onRouteStatus">On-route</span>
											<span v-if="order.status == 'delivery_arrived'" class="orderStatusSpan deliveredArrivedStatus">Arrived to
												location</span> <span v-if="order.status == 'delivered'"
												class="orderStatusSpan deliveredStatus">Delivered</span>
											<span v-if="order.status == 'not_delivered'" class="orderStatusSpan notDeliveredStatus">Not
												delivered</span>

											<!--                                                 	<img class="order_status_icon"  -->
											<!--                                                 	:src="'{{ asset('/') }}images/doorder_icons/order_status_' + (order.status === 'assigned' ? 'matched' : order
											    .status) + '.png'" :alt="order.status"> -->

										</td>

										<td class="text-left">@{{ order.driver != null ? order.driver : 'N/A' }}</td>
										<td class="text-left">
											<p style="" class="tablePinSpan tooltipC mb-0">
												<span> <i class="fas fa-map-marker-alt" style="color: #747474"></i> <span
														style="width: 20px; height: 0; display: inline-block; border-top: 2px solid #979797"></span>
													<i class="fas fa-map-marker-alt" style="color: #60A244"></i></span>
												<span class="tooltiptextC"> <i class="fas fa-circle" style="color: #747474"></i> @{{ order.pickup_address }}
													<br>
													<i class="fas fa-circle" style="color: #60A244"></i>
													@{{ order.customer_address }}
												</span>
											</p>

										</td>

									</tr>

									<tr v-else>
										<td colspan="8" class="text-center"><strong>No data found.</strong>
										</td>
									</tr>
								</tbody>
							</table>

						</div>
						<div class="row justify-content-center mt-3">
							<div class="col-lg-4 col-md-6 text-center">
								<button type="submit" class="btnDoorder btn-doorder-primary mb-1" @click="clickConfirmAddOrders">Add</button>
							</div>
							<div class="col-lg-4 col-md-6 text-center">
								<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
							</div>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>
	<!-- end add orders modal -->


	<!-- edit order modal -->
	<div class="modal fade" id="edit-order-modal" tabindex="-1" role="dialog" aria-labelledby="edit-order-label"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row w-100">
						<div class="col-6 pl-3">
							<div class="modal-dialog-header text-left">Order Number
								<span class="orderNumber ml-3" style="color: #4d4d4d">@{{ selected_order_number }}</span>
							</div>
						</div>
						<div class="col-6 text-right pt-2">
							<span v-bind:class="'orderStatusSpan mr-4 '+ selected_order_status_class"
								style="font-size: 14px">@{{ selected_order_status }}</span>
						</div>
					</div>
					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" style="margin-bottom: 0 !important;">
						{{ csrf_field() }}
						<div class="float-right"></div>
						<div v-if="invalid_not_selected_driver">
							<p class="errorMessage">Please
								select one driver</p>
						</div>
						<div class="table-responsive">
							<table class="table table-no-bordered table-hover doorderTable ordersListTable" id="driversTable"
								width="100%">

								<thead class="d-none">
									<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</thead>
								<tbody>

									<tr v-for="driver in available_drivers" v-if="available_drivers.length > 0" class="order-row"
										:data-driverId="driver.id">
										<td class="p-3">
											<input type="checkbox" name="driver_id[]" v-bind:value="driver.id">

										</td>
										<td class="text-left">
											<h6 class="recommendDriverNameH6 deliverer-name my-auto">
												@{{ driver.first_name }} @{{ driver.last_name }}</h6>
										</td>
										<td class="text-right">
											<p class="recommendDriverDataP">@{{ driver.transport }}</p>
											<p class="recommendDriverDotP">
												<i class="fas fa-circle"></i>
											</p>
											<p class="recommendDriverDataKmP" :id="'km-away-' + driver.id">
												<span>@{{driver.km_away}}</span> KM away
											</p>
										</td>

									</tr>

									<tr v-else>
										<td colspan="8" class="text-center"><strong>No data found.</strong>
										</td>
									</tr>
								</tbody>
							</table>

						</div>
						<input type="hidden" id="orderId" value="" />
						<input type="hidden" id="orderIndex" value="" />
						<input type="hidden" id="driverIndex" value="" />
						<div class="row justify-content-center mt-3">
							<div class="col-lg-4 col-md-6 text-center">
								<button type="submit" class="btnDoorder btn-doorder-primary mb-1" @click="clickConfirmEditOrder">Save
									changes</button>
							</div>
							<div class="col-lg-4 col-md-6 text-center">
								<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
							</div>
						</div>

					</form>

					{{-- <div class="card mt-0">
						<div class="card-header card-header-profile-border ">
							<div class="row">
								<div class="col-6 pl-3">
									<h4>Order Number</h4>
								</div>
								<div class="col-6 text-right">
									<h4 class="orderNumber">#20</h4>
									<span class="orderStatusSpan readyStatus">Ready</span>
								</div>
							</div>
						</div>
					</div> --}}
					{{-- <div class="modal-dialog-header modalHeaderMessage">This will remove
						the driver and redistribute their orders after you click start.</div> --}}

				</div>
				{{-- <div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-primary mb-1" @click="confirmEditOrder()">Yes</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button" class="btnDoorder btn-doorder-danger-outline mb-1" data-dismiss="modal">Cancel</button>
					</div>
				</div> --}}

			</div>
		</div>
	</div>
	<!-- end edit order modal -->


	<!-- success confirm routes modal -->
	<div class="modal fade" id="success-confirm-routes-modal" tabindex="-1" role="dialog"
		aria-labelledby="success-confirm-routes-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row justify-content-center">
						<div class="col-md-12">

							{{-- <div class="text-center">
								<img src="{{ asset('images/doorder-new-layout/warning-icon.png') }}" style="" alt="warning">
							</div> --}}
							<div class="text-center mt-3">
								<label class="warning-label">@{{ confirm_routes_message }}</label>

							</div>
						</div>
					</div>

					<div class="row justify-content-center mt-3">

						<div class="col-lg-4 col-md-6 text-center">
							<a class="btnDoorder btn-doorder-primary mb-1" href="{{ route('doorder_ordersTable', 'doorder') }}">Back to
								orders
							</a>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- end success confirm route modal -->

	@endsection @section('page-scripts')
	<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
	<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
	<script>
		var token = '{{ csrf_token() }}';
		$(document).ready(function() {

			if ($(window).width() > 768) {
				$('#minimizeSidebar').trigger('click');
			}

			$("#driverSelect").select2({});
		});
		var table, tableDriver;
		var userRole = '{!! auth()->user()->user_role !!}';

		var app = new Vue({
			el: '#app',
			data: {
				driversIds: {!! json_encode($selectedDrivers) !!},
				selectedOrders: {!! json_encode($selectedOrders) !!},
				map_routes: {!! isset($map_routes) ? $map_routes : '[]' !!},
				orders: [],
				available_drivers: {!! json_encode($available_drivers) !!},
				invalid_not_selected_orders: false,
				invalid_not_selected_driver: false,
				selected_order_number: '#',
				selected_order_status: '',
				selected_order_status_class: "",
				is_order_assigned_to_other: false,
				confirm_routes_message: ""
			},
			mounted() {
				// init orders table
				//this.initOrdersTable()
				console.log(this.driversIds)
				console.log(this.selectedOrders)
				console.log(this.orders)
				console.log(this.map_routes)
				console.log(this.available_drivers)
				console.log("end mounted")
			},

			methods: {
				initOrdersTable() {
					//init orders table
					if (userRole == 'client' || userRole == 'admin') {
						table = $('#ordersTable').DataTable({

							fixedColumns: true,
							"lengthChange": true,
							"searching": true,
							"info": true,
							"ordering": false,
							"paging": true,
							"responsive": true,
							"language": {
								search: '',
								"searchPlaceholder": "Search order ",
							},
							'columnDefs': [{
								orderable: false,
								className: 'select-checkbox',
								targets: 0,
							}],
							'select': {
								'style': 'multi',
								selector: 'td:first-child'
							},

							scrollX: true,
							scrollCollapse: true,
							fixedColumns: {
								leftColumns: 0,
							},
							"scrollY": "50vh",
							// "paging": false

						});
						table.on('selectItems', function(e, dt, items) {
							console.log('Items to be selected are now: ', items);
						});
						table.on('user-select', function(e, dt, type, cell, originalEvent) {
							var row = dt.row(cell.index().row);
							//console.log(row.data()[6])
							// console.log(e)
							// console.log(dt)
							// console.log(type)
							// console.log(cell)
							// console.log(originalEvent)
							// console.log($(originalEvent.target).children())
							// console.log($(originalEvent.target))
							// console.log($(originalEvent.target).parent().hasClass('selected'))
							// console.log($(originalEvent.target).parent().children())
							// console.log($(originalEvent.target).parent().children()[0])
							// console.log("------------------------------")
							// $(originalEvent.target).children().attr('checked', 'true')
							if (row.data()[6] === 'N/A') {
								// if ($(originalEvent.target).children().is(':checked')) {
								if ($(originalEvent.target).parent().hasClass('selected')) {
									$($(originalEvent.target).parent().children()[0]).children().attr(
										'checked', false)
								} else {
									$($(originalEvent.target).parent().children()[0]).children().attr(
										'checked', 'true')
								}
							} else {
								e.preventDefault();
							}


							// var selectedOrders = $('input[name="newOrders[]"]:checked');
							// if (selectedOrders.length >= 2) {
							// 	$("#submitAssignOrderBtn").removeClass('disabled');
							// } else {
							// 	$("#submitAssignOrderBtn").addClass('disabled');
							// }
						});

					} else {
						table = $('#ordersTable').DataTable({

							fixedColumns: true,
							"lengthChange": true,
							"searching": true,
							"info": false,
							"ordering": false,
							"paging": false,
							"responsive": true,
							"language": {
								search: '',
								"searchPlaceholder": "Search ",
							},

							scrollX: true,
							scrollCollapse: true,
							fixedColumns: {
								leftColumns: 0,
							},
							"scrollY": "50vh",

						});

					}
				},
				initDriversTable() {
					tableDriver = $('#driversTable').DataTable({

						fixedColumns: true,
						"lengthChange": true,
						"searching": true,
						"info": true,
						"ordering": false,
						"paging": true,
						"responsive": true,
						"language": {
							search: '',
							"searchPlaceholder": "Search driver ",
						},
						'columnDefs': [{
							orderable: false,
							className: 'select-checkbox',
							targets: 0,
						}],
						'select': {
							'style': 'os',
							selector: 'td:first-child'
						},

						scrollX: true,
						scrollCollapse: true,
						fixedColumns: {
							leftColumns: 0,
						},
						"scrollY": "50vh",
						// "paging": false

					});
					tableDriver.on('selectItems', function(e, dt, items) {
						console.log('Items to be selected are now: ', items);
					});
					tableDriver.on('user-select', function(e, dt, type, cell, originalEvent) {
						var row = dt.row(cell.index().row);

						if ($(originalEvent.target).parent().hasClass('selected')) {
							$($(originalEvent.target).parent().children()[0]).children().attr(
								'checked', false)
						} else {
							$("input[name='driver_id[]']:checked").each(function() {
								$(this).attr(
									'checked', false)
							});
							$($(originalEvent.target).parent().children()[0]).children().attr(
								'checked', 'true')
						}

					});
				},

				submitForm(e) {
					//e.preventDefault();

				},
				clickDeleteDriver(e, driverId, index) {
					e.stopPropagation();
					e.preventDefault()
					//console.log("delete driver "+driverId + " "+index)
					$('#delete-driver-modal').modal('show');
					$('#delete-driver-modal #driverId').val(driverId);
					$('#delete-driver-modal #index').val(index);
				},
				confirmDeleteDriver() {
					//console.log("confirm delete driver "+$('#delete-driver-modal #driverId').val() +" "+$('#delete-driver-modal #index').val() +" "+this.driversIds.indexOf($('#delete-driver-modal #driverId').val()))
					var indexRoute = $('#delete-driver-modal #index').val();
					this.map_routes.splice(indexRoute, 1);

					var index = this.driversIds.indexOf($('#delete-driver-modal #driverId').val());
					this.driversIds.splice(index, 1);

					$('#delete-driver-modal').modal('toggle');

					$("#confirmRouteDiv").css('display', 'none');
					$("#startRouteDiv").css('display', 'block');
				},
				clickDeleteOrder(e, orderId, driver_index) {
					e.stopPropagation();
					e.preventDefault()
					console.log("delete order " + orderId + " " + driver_index)
					$('#delete-order-modal').modal('show');
					$('#delete-order-modal #orderId').val(orderId);
					$('#delete-order-modal #index').val(driver_index);
				},
				confirmDeleteOrder() {
					let orderid = $('#delete-order-modal #orderId').val()
					console.log("confirm delete order", orderid)
					console.log(this.selectedOrders)
					var index = this.selectedOrders.indexOf(orderid);
					this.selectedOrders.splice(index, 1);
					console.log(this.selectedOrders)

					var driver_index = $('#delete-order-modal #index').val();
					console.log(driver_index, orderid)
					console.log(this.map_routes[driver_index].slice(1))
					let tt1 = this.map_routes[driver_index].map(object => object.order_id).indexOf(orderid);
					console.log(tt1)
					let tt2 = this.map_routes[driver_index].map(object => object.order_id).lastIndexOf(orderid);
					console.log(tt2)

					this.map_routes[driver_index].splice(tt2, 1);
					this.map_routes[driver_index].splice(tt1, 1);

					console.log(this.map_routes)

					$('#delete-order-modal').modal('toggle');

					$("#confirmRouteDiv").css('display', 'none');
					$("#startRouteDiv").css('display', 'block');
				},
				clickAddOrders() {
					console.log("in click add orders")
					console.log(this.driversIds)
					console.log(this.selectedOrders)
					console.log(this.orders)
					console.log(this.map_routes)
					this.invalid_not_selected_orders = false
					this.getOrdersRouteOptimization()
				},
				clickConfirmAddOrders(e) {
					console.log("in confirm add orders")
					e.preventDefault();
					var selectedOrders = $('input[name="newOrders[]"]:checked')
					console.log(selectedOrders)
					console.log(selectedOrders.length)

					console.log(table.column(0, {
						selected: true
					}).data())

					var newOrders = [];
					$("input[name='newOrders[]']:checked").each(function() {
						newOrders.push($(this).val());
					});
					console.log(newOrders);
					if (newOrders.length > 0) {
						this.invalid_not_selected_orders = false
						console.log(this.selectedOrders)
						this.selectedOrders = this.selectedOrders.concat(newOrders)
						console.log(this.selectedOrders)

						$('#add-orders-modal').modal('toggle');
						$("#confirmRouteDiv").css('display', 'none');
						$("#startRouteDiv").css('display', 'block');
					} else {
						this.invalid_not_selected_orders = true
					}

				},
				getOrdersRouteOptimization() {
					$('#add-orders-modal').modal('show');
					// $('#ordersTable').DataTable().clear().destroy();
					if (table != null) {
						table.clear();
						table.destroy();
					}
					this.orders = []


					$.ajax({
						type: 'POST',
						url: '{{ url('doorder/get_orders_route_optimization') }}',
						data: {
							_token: token,
						},
						success: function(data) {
							console.log(data.orders)
							app.orders = data.orders

							console.log(app.selectedOrders)

							for (let i = app.orders.length - 1; i >= 0; i--) {
								let ii = app.selectedOrders.indexOf('' + app.orders[i].id)
								console.log(ii, app.orders[i].id, app.selectedOrders)
								if (ii != -1) {
									app.orders.splice(i, 1)
								}
							}

							// this.initOrdersTable()
							this.timer = setTimeout(() => {
								//console.log("hahahaha");
								app.initOrdersTable()
							}, 1000)
						}
					});
				},
				clickEditOrder(e, orderId, order_index, driver_index) {
					console.log("in click edit order", orderId, order_index, driver_index)

					this.getOrderDataRequest(orderId);

					$('#edit-order-modal').modal('show');

					$('#edit-order-modal #orderId').val(orderId);
					$('#edit-order-modal #orderIndex').val(order_index);
					$('#edit-order-modal #driverIndex').val(driver_index);

					if (tableDriver != null) {
						tableDriver.destroy();
					}

					// this.initOrdersTable()
					this.timer = setTimeout(() => {
						//console.log("hahahaha");
						app.initDriversTable()
					}, 1000)

				},
				clickConfirmEditOrder(e) {
					console.log("in confirm add orders")
					e.preventDefault();
					console.log(this.available_drivers)
					$('#edit-order-modal').modal('toggle');

					let orderId = $('#edit-order-modal #orderId').val(),
						order_index = $('#edit-order-modal #orderIndex').val(),
						driver_index = $('#edit-order-modal #driverIndex').val();

					var driverId = [];
					$("input[name='driver_id[]']:checked").each(function() {
						console.log($(this).val())
						driverId.push($(this).val());
					});
					console.log(driverId);
					if (driverId.length > 0) {
						driverId = driverId[0]
						console.log(driverId);
						let driverObject = null
						for (let i = 0; i < app.available_drivers.length; i++) {
							if (driverId == app.available_drivers[i].id) {
								driverObject = app.available_drivers[i]
								break;
							}
						}
						console.log(driverObject)
						console.log(this.map_routes[0])
						console.log(this.driversIds.indexOf(driverId), driver_index)

						this.is_order_assigned_to_other = true

						if (this.driversIds.indexOf(driverId) == -1) { // if driver not in optimized list
							this.driversIds.push(driverId)
							let address = null;
							if (driverObject.latest_coordinates != null) {
								address = JSON.parse(driverObject.latest_coordinates)
							} else {
								address = JSON.parse(driverObject.address_coordinates)
							}
							console.log(address)
							let driver_route = {
								"coordinates": address.lat + "," + address.lon,
								"deliverer_first_letter": driverObject.first_name[0] + driverObject.last_name[0],
								"deliverer_id": driverId,
								"deliverer_name": driverObject.first_name + " " + driverObject.last_name
							}
							let full_route = []
							full_route.push(driver_route)
							// app.map_routes.push(full_route)
							// for (let i = 0; i < app.map_routes.length; i++) {
							// 	console.log(app.map_routes[i])
							// }
							let tt1 = this.map_routes[driver_index].map(object => object.order_id).indexOf(orderId);
							console.log(tt1)
							let tt2 = this.map_routes[driver_index].map(object => object.order_id).lastIndexOf(
								orderId);
							console.log(tt2)

							let pickup_object = this.map_routes[driver_index][tt1]
							let dropoff_object = this.map_routes[driver_index][tt2]

							console.log(pickup_object)
							console.log(dropoff_object)

							full_route.push(pickup_object)
							full_route.push(dropoff_object)
							app.map_routes.push(full_route)
							for (let i = 0; i < app.map_routes.length; i++) {
								console.log(app.map_routes[i])
							}

							this.map_routes[driver_index].splice(tt2, 1);
							this.map_routes[driver_index].splice(tt1, 1);

						} else { // driver in optimized list
							let tt1 = this.map_routes[driver_index].map(object => object.order_id).indexOf(orderId);
							console.log(tt1)
							let tt2 = this.map_routes[driver_index].map(object => object.order_id).lastIndexOf(
								orderId);
							console.log(tt2)

							let toDriverIndex = -1
							for (let i = 0; i < app.map_routes.length; i++) {
								console.log("==>", app.map_routes[i][0].deliverer_id)
								if (driverId + '' == app.map_routes[i][0].deliverer_id + '') {
									toDriverIndex = i
								}
							}
							console.log(toDriverIndex)

							let pickup_object = this.map_routes[driver_index][tt1]
							let dropoff_object = this.map_routes[driver_index][tt2]

							console.log(pickup_object)
							console.log(dropoff_object)

							this.map_routes[driver_index].splice(tt2, 1);
							this.map_routes[driver_index].splice(tt1, 1);

							this.map_routes[toDriverIndex].push(pickup_object)
							this.map_routes[toDriverIndex].push(dropoff_object)

						}
					}

					console.log("--", orderId, order_index, driver_index, driverId)
				},
				getOrderDataRequest(order_id) {
					console.log("in get order data request", order_id)
					$.ajax({
						type: 'POST',
						url: '{{ url('doorder/get_order_data_route_optimization') }}',
						data: {
							_token: token,
							order_id: order_id
						},
						success: function(data) {
							console.log(data.order)
							app.selected_order_number = '#' + data.order.order_id
							app.selected_order_status = data.order.status
							app.getOrderStatusClass(data.order.status)

							app.getDriversAwayKM(data.order.pickup_lat, data.order.pickup_lon)
						}
					});
				},
				getOrderStatusClass(status) {
					if (status == 'pending') {
						app.selected_order_status = 'Pending fullfilment';
						app.selected_order_status_class =
							'pendingStatus';
					} else if (status == 'ready') {
						app.selected_order_status =
							'Ready to Collect';
						app.selected_order_status_class = 'readyStatus';
					} else if (status == 'matched' || status ==
						'assigned') {
						app.selected_order_status_ = 'Matched';
						app.selected_order_status_class =
							'matchedStatus';
					} else if (status == 'on_route_pickup') {
						app.selected_order_status = 'On-route to Pickup';
						app.selected_order_status_class =
							'onRoutePickupStatus';
					} else if (status == 'picked_up') {
						app.selected_order_status = 'Picked up';
						app.selected_order_status_class = 'pickedUpStatus';
					} else if (status == 'on_route') {
						app.selected_order_status = 'On-route';
						app.selected_order_status_class = 'onRouteStatus';
					} else if (status ==
						'delivery_arrived') {
						app.selected_order_status = 'Arrived to location';
						app.selected_order_status_class = 'deliveredArrivedStatus';
					} else if (status ==
						'delivered') {
						app.selected_order_status = 'Delivered';
						app.selected_order_status_class =
							'deliveredStatus';
					} else if (status == 'not_delivered') {
						app.selected_order_status = 'Not delivered';
						app.selected_order_status_class = 'notDeliveredStatus';
					}
				},
				getDriversAwayKM(pickup_address_lat, pickup_address_lon) {
					console.log("in get drivers away km", pickup_address_lat, pickup_address_lon)
					for (let i = 0; i < app.available_drivers.length; i++) {
						if (app.available_drivers[i].latest_coordinates != null) {
							let driver_coordinates = JSON.parse(app.available_drivers[i].latest_coordinates);
							var distance = google.maps.geometry.spherical.computeDistanceBetween(new google.maps
								.LatLng(parseFloat(pickup_address_lat), parseFloat(pickup_address_lon)),
								new google.maps.LatLng(parseFloat(driver_coordinates.lat), parseFloat(
									driver_coordinates.lng)));
							distance = parseFloat(distance / 1000).toFixed(2)		
							console.log(app.available_drivers[i].id, distance)
							app.available_drivers[i].km_away = distance

						} else {
							let distance = 'N/A'
							app.available_drivers[i].km_away = distance
						}

					}
				},
				startRouteOptimization() {
					//                 	console.log("start route modal");
					//                 	console.log(this.selectedOrders);
					//                 	console.log(this.driversIds);

					$('#confirm-route-optimization-modal').modal('show')
				},
				clickConfirmStartRouteOptimization() {
					//                 	console.log(this.driversIds)
					//                 	console.log(this.selectedOrders)
					$('#confirm-route-optimization-modal').modal('toggle')


					$("#confirmRouteDiv").css('display', 'block');
					$("#startRouteDiv").css('display', 'none');

					$("#confirmRoutesButton").removeAttr('onclick');
					$("#confirmRoutesButton").prop("disabled", true);
					$("#confirmRoutesButton").removeClass("btn-doorder-primary");
					$("#confirmRoutesButton").addClass("btn-doorder-grey");
					//   add spinner to button
					$("#confirmRoutesButton").html(
						' Wait for a few minutes  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
					);

					$.ajax({
						type: 'POST',
						url: '{{ url('doorder/assign_orders_drivers') }}',
						data: {
							_token: token,
							selectedOrders: app.selectedOrders.toString(),
							selectedDrivers: app.driversIds
						},
						success: function(data) {
							//                                       console.log(data);
							//                                       console.log(data.mapRoutes);
							//                                       console.log(data.selectedOrders);
							//                                       console.log(data.selectedDrivers);

							//                                       console.log(this.map_routes)
							app.map_routes = JSON.parse(data.mapRoutes);
							//                                       console.log(this.map_routes)
							$("#map_routes").val(data.mapRoutes);
							app.selectedOrders = data.selectedOrders;
							app.driversIds = data.selectedDrivers;
							//                                       $("#selectedOrdersMap").val(data.selectedOrders)
							//                                       $("#selectedDriversMap").val(data.selectedDrivers)

							routesOpt = JSON.parse(data.mapRoutes);
							for (var i = 0; i < dirRendCount; i++) {
								directionsRendererArr[i].setMap(null)
							}
							for (var i = 0; i < markerRoutesCount; i++) {
								markersRoutesArr[i].setMap(null)
							}
							for (var i = 0; i < markerRoutesColorCount; i++) {
								markersRoutesColorArr[i].setMap(null)
							}
							markersRoutesArr = [];
							markerRoutesCount = 0;
							directionsRendererArr = [];
							dirRendCount = 0;
							markersRoutesColorArr = [];
							markerRoutesColorCount = 0;

							for (var i = 0; i < stepPolylinesDraw.length; i++) {
								stepPolylinesDraw[i].setMap(null);
							}
							for (var i = 0; i < polylinesO.length; i++) {
								polylinesO[i].setMap(null);
							}

							polylinePaths = [];
							polylineDrivers = [];
							stepPolylinesDraw = [];
							polylinesO = [];

							if (JSON.parse(data.mapRoutes).length > 0) {
								getAndDrawRoutes();

								$("#confirmRoutesButton").prop("disabled", false);
								$("#confirmRoutesButton").html('Confirm');
								$("#confirmRoutesButton").removeClass("btn-doorder-grey");
								$("#confirmRoutesButton").addClass("btn-doorder-primary");

								console.log("after route optimization")
								console.log(app.driversIds)
								console.log(app.orders)
								console.log(app.selectedOrders)
								console.log(app.map_routes)
								console.log("lllllo", app.orders.length)
								for (let i = app.orders.length - 1; i >= 0; i--) {
									let ii = app.selectedOrders.indexOf('' + app.orders[i].id)
									console.log(ii, app.orders[i].id, app.selectedOrders)
									if (ii != -1) {
										app.orders.splice(i, 1)
									}
								}
								app.is_order_assigned_to_other = false

							} else {

								$("#enableRouteOptimizationBtn").prop("disabled", false);
								$("#enableRouteOptimizationBtn").html('Enable route optimization');
								$("#enableRouteOptimizationBtn").removeClass("btn-doorder-grey");
								$("#enableRouteOptimizationBtn").addClass("btn-doorder-primary");


								$('#warning-route-modal').modal('show');
								$('#warning-route-modal #routeErrorMessage').html(
									'The route optimization algorithm was unable to find optimal routes for the selected orders and deliverers'
								);
							}
						}
					});
				},
				confirmRouteOptimization() {
					console.log("in confirm route optimization and send orders to drivers")
					console.log(this.map_routes)

					$.ajax({
						type: 'POST',
						url: '{{ url('doorder/confirm_route_optimization_map') }}',
						data: {
							_token: token,
							mapRoutes: app.map_routes
						},
						success: function(data) {
							console.log(data)
							if (data.msg == "Done") {
								app.confirm_routes_message = data.message
								$('#success-confirm-routes-modal').modal('show')
							}

						}
					});
				}
			}
		});

		function cancelResultRouteOptimization() {
			$('#cancel-routes-modal').modal('show')
		}

		function confirmCancelRouteOptimization() {
			window.location.href = "{{ url('doorder/orders') }}";
		}


		////////////////// map
		let map;
		var routes = [];
		// var colors=['#D2691E','#4682b4','#FF8C00','#a9a9a9','#DAA520','#696969','#778899','#5e70e6','#6a5acd','#9acd32'];
		var colors = ['#4C97A1', '#f5a505', '#656565', '#FF8C00', '#30BB30', '#60A244', '#56BDA3', '#CC4B4C', '#F56D6D',
			'#E8CA49', '#D2B431', '#FF9F43'
		];
		var icons;
		let markerAddress, markerPickup, markerDriver;
		let directionsService

		var routesOpt = {!! isset($map_routes) ? $map_routes : '[]' !!};
		if (routesOpt.length == 0) {
			//console.log('not found routes');
			$('#warning-no-route-modal').modal('show')
		}

		//console.log(routesOpt)

		var directionsRendererArr = [],
			markersRoutesArr = [],
			markersRoutesColorArr = [];
		var dirRendCount = 0,
			markerRoutesCount = 0,
			markerRoutesColorCount = 0;

		var greyScaleStyle = [{
				elementType: "geometry",
				stylers: [{
					color: "#f5f5f5"
				}],
			},
			{
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}],
			},
			{
				elementType: "labels.text.fill",
				stylers: [{
					color: "#616161"
				}],
			},
			{
				elementType: "labels.text.stroke",
				stylers: [{
					color: "#f5f5f5"
				}],
			},
			{
				featureType: "administrative.land_parcel",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#bdbdbd"
				}],
			},
			{
				featureType: "poi",
				elementType: "geometry",
				stylers: [{
					color: "#eeeeee"
				}],
			},
			{
				featureType: "poi",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#757575"
				}],
			},
			{
				featureType: "poi.park",
				elementType: "geometry",
				stylers: [{
					color: "#e5e5e5"
				}],
			},
			{
				featureType: "poi.park",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#9e9e9e"
				}],
			},
			{
				featureType: "road",
				elementType: "geometry",
				stylers: [{
					color: "#ffffff"
				}],
			},
			{
				featureType: "road.arterial",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#757575"
				}],
			},
			{
				featureType: "road.highway",
				elementType: "geometry",
				stylers: [{
					color: "#dadada"
				}],
			},
			{
				featureType: "road.highway",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#616161"
				}],
			},
			{
				featureType: "road.local",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#9e9e9e"
				}],
			},
			{
				featureType: "transit.line",
				elementType: "geometry",
				stylers: [{
					color: "#e5e5e5"
				}],
			},
			{
				featureType: "transit.station",
				elementType: "geometry",
				stylers: [{
					color: "#eeeeee"
				}],
			},
			{
				featureType: "water",
				elementType: "geometry",
				stylers: [{
					color: "#c9c9c9"
				}],
			},
			{
				featureType: "water",
				elementType: "labels.text.fill",
				stylers: [{
					color: "#9e9e9e"
				}],
			},
		];

		var polylinePaths = [];
		var polylineDrivers = [];

		function initMap() {
			directionsService = new google.maps.DirectionsService();

			markerAddress = {
				url: "{{ asset('images/doorder_driver_assets/customer-address-pin.png') }}", // url
				scaledSize: new google.maps.Size(50, 50), // scaled size
			};
			markerPickup = {
				url: "{{ asset('images/doorder_driver_assets/pickup-address-pin-grey.png') }}", // url
				scaledSize: new google.maps.Size(50, 50), // scaled size
			};
			markerDriver = {
				url: "{{ asset('images/doorder_driver_assets/deliverer-location-pin.png') }}", // url
				scaledSize: new google.maps.Size(50, 50), // scaled size
			};
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 12,
				center: {
					lat: 53.346324,
					lng: -6.258668
				},
				mapTypeControl: false,
				//	mapTypeId: google.maps.MapTypeId.ROADMAP,
			});
			map.setOptions({
				styles: greyScaleStyle
			});

			getAndDrawRoutes();


		}

		function getAndDrawRoutes() {
			for (var i = 0; i < routesOpt.length; i++) {
				var routeTemp = routesOpt[i];
				//console.log(routeTemp)
				if (routeTemp.length > 1) {
					var waypoints = [];
					var destination;
					for (var j = 1; j < routeTemp.length; j++) {
						//                 			console.log(routeOpt[j])
						//                 			console.log("point "+j +" "+routeTemp[j]['coordinates'])
						if (j == routeTemp.length - 1) {
							destination = new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0], routeTemp[j][
								'coordinates'
							].split(",")[1])
						} else {
							waypoints.push({
								location: new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0], routeTemp[
									j]['coordinates'].split(",")[1]),
								stopover: true
							});
						}
					}
					//                 		console.log(waypoints)
					route = {
						origin: new google.maps.LatLng(routeTemp[0]['coordinates'].split(",")[0], routeTemp[0][
							'coordinates'
						].split(",")[1]),
						destination: destination,
						waypoints: waypoints,
						travelMode: google.maps.TravelMode.DRIVING,
					};
					//                     		console.log(route)
					//                     		console.log("------=====-----");


					directionsRendererArr[dirRendCount] = new google.maps.DirectionsRenderer({
						polylineOptions: {
							strokeColor: colors[i % colors.length],
							strokeOpacity: 0.25,
							clickable: true
						},
						suppressMarkers: true
					});
					directionsRendererArr[dirRendCount].setMap(map);
					calculateAndDisplayRoute(directionsService, directionsRendererArr[dirRendCount], route, routeTemp[0][
							'deliverer_name'
						],
						routeTemp[0]['deliverer_first_letter'], routeTemp, i % colors.length);
					dirRendCount++;
				} else {
					var polylines = new google.maps.Polyline({
						path: [],
					});
					polylinePaths.push(polylines);


					polylineDrivers.push(routeTemp[0]['deliverer_name']);
				}
			}

		}
		var stepPolylinesDraw = [];

		function calculateAndDisplayRoute(directionsService, directionsRenderer, route, driver_name, driver_first_letters,
			routeTemp, color_index) {
			directionsService.route(route, function(result, status) {

				var polylines = new google.maps.Polyline({
					path: [],
				});

				//        	console.log(result);
				//             	console.log(status)
				if (status == 'OK') {
					//                 		directionsRenderer.setOptions({
					//                            polylineOptions: {
					//                            		strokeColor: colors[color_index],  strokeOpacity: 1
					//                            }
					//                         });
					directionsRenderer.setDirections(result);

					var leg = result.routes[0].legs[0];
					makeMarker(leg.start_location, markerDriver, "title", map, driver_name, driver_first_letters,
						null);
					makeMarkerForRoute(leg.start_location, color_index, driver_name, null, 1)

					leg = result.routes[0].legs[result.routes[0].legs.length - 1];
					makeMarker(leg.end_location, markerAddress, 'title', map, null, null, routeTemp[result.routes[0]
						.legs.length]['order_id']);

					var opacityChangeStep = (0.8 - 0.2) / (result.routes[0].legs.length - 1);
					// console.log(opacityChangeStep)

					/* 
					   var polylinePaths = [];
					   var polylineDrivers = []; */

					polylineDrivers.push(driver_name);

					for (var i = 0; i < result.routes[0].legs.length; i++) {
						//console.log(leg.start_location.lat()+","+leg.start_location.lng())
						//console.log(routeTemp[i+1]['type'])

						leg = result.routes[0].legs[i];

						//console.log(routeTemp[i+1]['order_id'])
						//                        		if(routeTemp[i+1]['type']==='pickup'){
						//                       			makeMarker(leg.end_location, markerPickup, "title", map,driver_name,null,routeTemp[i+1]['order_id']);
						//                       		}
						//                       		else if(routeTemp[i+1]['type']==='dropoff'){
						//                       			makeMarker(leg.end_location, markerAddress, "title", map,driver_name,null,routeTemp[i+1]['order_id']);
						//                       		}	
						makeMarkerForRoute(leg.end_location, color_index, driver_name, routeTemp[i + 1]['order_id'],
							i + 2);

						// change route opacity
						var steps = result.routes[0].legs[i].steps;
						for (j = 0; j < steps.length; j++) {
							var nextSegment = steps[j].path;
							var stepPolyline = new google.maps.Polyline({
								strokeOpacity: 1 - (i * opacityChangeStep),
							});
							//console.log(color_index +" "+colors[color_index] + " "+(0.8-(i*opacityChangeStep)))
							stepPolyline.setOptions({
								strokeColor: colors[color_index],
								strokeWeight: 6,
								zindex: 2
							})
							for (k = 0; k < nextSegment.length; k++) {
								stepPolyline.getPath().push(nextSegment[k]);
								polylines.getPath().push(nextSegment[k]);
								//bounds.extend(nextSegment[k]);
							}
							// polylines.push(stepPolyline);
							stepPolyline.setMap(map);
							stepPolylinesDraw.push(stepPolyline);
							// route click listeners, different one on each step

							//                                   const infowindow = new google.maps.InfoWindow();
							//                                   google.maps.event.addListener(stepPolyline,'click', function(evt) {
							//                                      infowindow.setContent(driver_name + " you clicked on the route<br>"+evt.latLng.toUrlValue(6));
							//                                      infowindow.setPosition(evt.latLng);
							//                                      infowindow.open(map);
							//                                   })	
						}
					}

					polylinePaths.push(polylines);
				}
				//                 			console.log(polylines)
				//                 			console.log(polylinePaths)
				//                         	console.log(polylineDrivers)
				//                         	console.log(polylinePaths.length +" "+routesOpt.length)
				if (polylinePaths.length === routesOpt.length) {

					this.timer = setTimeout(() => {
						//console.log("hahahaha");
						getPolylineIntersection();
					}, 1000)
				}
			});

		}
		var polylinesO = [];

		function getPolylineIntersection() {
			//console.log("    " +polylinePaths.length +" "+routesOpt.length)
			if (polylinePaths.length === routesOpt.length) {
				for (var p = 0; p < polylinePaths.length - 1; p++) {
					for (var s = p + 1; s < polylinePaths.length; s++) {
						//console.log("===="+p)         	 
						var polyline1 = polylinePaths[p];
						var polyline2 = polylinePaths[s];
						//                     	console.log(polylineDrivers[p] +" "+polylineDrivers[s])
						// console.log(polyline1.getPath().getLength() +" -- "+polyline2.getPath().getLength())

						if ((polyline2.getPath().getLength() > polyline1.getPath().getLength())) {
							polyline1 = polylinePaths[s];
							polyline2 = polylinePaths[p];
						}
						var driver1 = polylineDrivers[p];
						var driver2 = polylineDrivers[s];

						var commonPts = [];
						var commonPtsInd = [];
						var commonPtsInd2 = [];
						// console.log(polyline1.getPath().getLength() +" -- "+polyline2.getPath().getLength())
						for (var i = 0; i < polyline1.getPath().getLength(); i++) {
							//                             for (var j = 0; j < polyline2.getPath().getLength(); j++) {
							//                             	//console.log(polyline1.getPath().getAt(i))
							//                                 if (polyline1.getPath().getAt(i).equals(polyline2.getPath().getAt(j))) {
							//                                     commonPts.push({
							//                                         lat: polyline1.getPath().getAt(i).lat(),
							//                                         lng: polyline1.getPath().getAt(i).lng(),
							//                                         route1idx: i
							//                                     });
							//                                     commonPtsInd.push(i)
							//                                     console.log( google.maps.geometry.poly.isLocationOnEdge(polyline1.getPath().getAt(i), polyline2,1e-3));
							//                                 }

							//                             }

							if (google.maps.geometry.poly.isLocationOnEdge(polyline1.getPath().getAt(i), polyline2, 1e-12)) {
								//console.log(i+" sssssss ")
								//commonPtsInd2.push(i);
								commonPts.push({
									lat: polyline1.getPath().getAt(i).lat(),
									lng: polyline1.getPath().getAt(i).lng(),
									route1idx: i
								});
							}
						}
						var path = [];
						//                         console.log(p+"  "+s)
						//                         console.log(commonPts)
						//                         console.log(commonPtsInd)
						//                         console.log(commonPtsInd2)

						if (commonPts.length > 0) {
							var prevIdx = commonPts[0].route1idx;
							for (var i = 0; i < commonPts.length; i++) {
								//console.log(">>>>>>>> "+prevIdx+" "+commonPts[i].route1idx)
								if (commonPts[i].route1idx <= prevIdx + 1) {
									path.push(commonPts[i]);
									prevIdx = commonPts[i].route1idx;
								} else {
									//console.log("draw "+prevIdx+" "+commonPts[i].route1idx)
									var polyline = new google.maps.Polyline({
										map: map,
										path: path,
										strokeWeight: 10,
										strokeColor: "#ff0000",
										zIndex: 1000,
										strokeOpacity: 0.6
									});
									const infowindow = new google.maps.InfoWindow({
										content: (driver1 + " & " + driver2),
										maxWidth: '350px'
									});
									google.maps.event.addListener(polyline, 'click', function(evt) {
										infowindow.setPosition(evt.latLng);
										infowindow.open(map, this);
										var driversNames = getDriversNameOfOverlappedRoute(evt.latLng);
										infowindow.setContent(driversNames);
									})

									stepPolylinesDraw.push(polyline);
									path = [];
									prevIdx = commonPts[i].route1idx;
								}
							}
							const infowindow = new google.maps.InfoWindow({
								content: (driver1 + " & " + driver2),
								maxWidth: '350px'
							});

							var polylineO = new google.maps.Polyline({
								map: map,
								path: path,
								strokeWeight: 10,
								strokeColor: "#ff0000",
								strokeOpacity: 0.6,
								zIndex: 1000,
								//title:driver1 +" -- "+driver2
							});
							google.maps.event.addListener(polylineO, 'click', function(evt) {
								infowindow.setPosition(evt.latLng);
								infowindow.open(map, this);

								var driversNames = getDriversNameOfOverlappedRoute(evt.latLng);
								infowindow.setContent(driversNames);
							})
							//                                       google.maps.event.addListenerOnce( polylineO, "visible_changed", function() {
							//                                             infowindow.close();
							//                                         });
							polylinesO.push(polylineO)

							//                                   const infowindow = new google.maps.InfoWindow();
							//                                   google.maps.event.addListener(stepPolyline,'click', function(evt) {
							//                                      infowindow.setContent(driver_name + " you clicked on the route<br>"+evt.latLng.toUrlValue(6));
							//                                      infowindow.setPosition(evt.latLng);
							//                                      infowindow.open(map);
							//                                   })	
						}
					}
				}
			}

		}

		function getDriversNameOfOverlappedRoute(latlng) {
			//console.log("hello ")
			var driversNames = '<h3 class="pickup-name mapPickupName" >';
			for (var i = 0; i < polylinePaths.length; i++) {
				var isFound = google.maps.geometry.poly.isLocationOnEdge(latlng, polylinePaths[i], 1e-3);
				if (isFound) {
					//console.log(isFound,i)
					if (i === polylinePaths.length - 1) {
						driversNames += polylineDrivers[i];
					} else {
						driversNames += polylineDrivers[i] + ', ';
					}
				}
			}
			driversNames += '</h3';

			return driversNames;
		}

		function createPin(color) {
			return {
				path: 'M 0,0 c -2,-20 -10,-22 -10,-30 a 10,10 0 1 1 20,0 c 0,8 -8,10 -10,30 z',
				fillColor: color,
				fillOpacity: 1,
				strokeColor: '#fff',
				strokeWeight: 1,
				scale: 1.12,
				labelOrigin: new google.maps.Point(0, -29),
				size: new google.maps.Size(40, 50),
			};
		}

		function makeMarkerForRoute(position, color_index, driver_name, order_number, label) {
			//console.log("make marker for route ",color_index)
			var image = {
				//url: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+"%7C0000FF",
				url: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&outline_color=fff&chld=' + 'a|' + colors[
					color_index].substring(1) + '|fff',
				// This marker is 27 pixels wide by 40 pixels tall.
				size: new google.maps.Size(70, 90),
				// The origin for this image is 0,0.
				//origin: new google.maps.Point(0, 0),
				// The anchor for this image is the base of the icon at 14, 39.
				anchor: new google.maps.Point(10, 35)
			};
			var shape = {
				coords: [1, 1, 1, 20, 18, 20, 18, 1],
				type: 'poly'
			};
			var marker = new google.maps.Marker({
				position: position,
				map: map,
				icon: createPin(colors[color_index]),
				//shape: shape,
				//zIndex: i
				//scaledSize: new google.maps.Size(50, 70), // scaled size
				label: {
					text: '' + label,
					color: "#fff",
					fontSize: "12px",
					fontWeight: "500"
				},
			});

			if (driver_name != null) {
				var content = driver_name;
				//console.log(order_number)
				if (order_number != null) {
					content += '<br> Order #' + order_number;
				}
				const infowindow = new google.maps.InfoWindow({
					content: content,
				});

				marker.addListener("click", () => {
					infowindow.open({
						anchor: marker,
						map,
						shouldFocus: false,
					});
				});
			}

			markersRoutesColorArr[markerRoutesColorCount] = marker;
			markerRoutesColorCount++;
		}

		function makeMarker(position, icon, title, map, driver_name, driver_first_letters, order_number) {
			//console.log(order_number)
			var marker = new google.maps.Marker({
				position: position,
				anchorPoint: new google.maps.Point(0, -29),
				map: map,
				icon: icon,
				title: driver_first_letters,
				//label:'a'
			});

			if (driver_name != null) {
				var content = driver_name;
				//	console.log(order_number)
				if (order_number != null) {
					content += '<br> Order #' + order_number;
				}
				const infowindow = new google.maps.InfoWindow({
					content: content,
				});

				//   marker.setLabel(driver_first_letters);

				marker.addListener("click", () => {
					infowindow.open({
						anchor: marker,
						map,
						shouldFocus: false,
					});
				});
			}

			markersRoutesArr[markerRoutesCount] = marker;
			markerRoutesCount++;
			//             console.log(markersRoutesArr);
			//             console.log(markerRoutesCount)
		}

		function clickFilter() {
			var driverId = $("#driverSelect").val();
			console.log("click filter " + driverId);

			$.ajax({
				type: 'GET',
				url: '{{ url('doorder/get_route_driver') }}' + '?driverId=' + driverId,
				success: function(data) {
					console.log(data);
					var routeTemp = data.route;

					for (var i = 0; i < dirRendCount; i++) {
						directionsRendererArr[i].setMap(null)
					}
					for (var i = 0; i < markerRoutesCount; i++) {
						markersRoutesArr[i].setMap(null)
					}
					markersRoutesArr = [];
					markerRoutesCount = 0;
					directionsRendererArr = [];
					dirRendCount = 0;

					var waypoints = [];
					var destination;
					for (var j = 1; j < routeTemp.length; j++) {
						//                 			console.log(routeTemp[j])
						//                 			console.log("point "+j +" "+routeTemp[j]['coordinates'])
						if (j == routeTemp.length - 1) {
							destination = new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0],
								routeTemp[j]['coordinates'].split(",")[1])
						} else {
							waypoints.push({
								location: new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0],
									routeTemp[j]['coordinates'].split(",")[1]),
								stopover: true
							});
						}
					}
					//                 		console.log(waypoints)
					var route = {
						origin: new google.maps.LatLng(routeTemp[0]['coordinates'].split(",")[0], routeTemp[0][
							'coordinates'
						].split(",")[1]),
						destination: destination,
						waypoints: waypoints,
						travelMode: google.maps.TravelMode.DRIVING,
					};
					console.log(route)
					console.log("------=====-----");


					directionsRendererArr[dirRendCount] = new google.maps.DirectionsRenderer({
						polylineOptions: {
							strokeColor: colors[6]
						},
					});
					directionsRendererArr[dirRendCount].setMap(map);
					calculateAndDisplayRoute(directionsService, directionsRendererArr[dirRendCount], route);
					dirRendCount++;

				}
			});
		}
	</script>

	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap">
	</script>
@endsection
