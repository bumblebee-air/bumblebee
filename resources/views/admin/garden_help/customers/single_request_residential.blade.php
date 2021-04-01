@extends('templates.dashboard') @section('title', 'GardenHelp | Customer
Request') @section('page-styles')
<style>
.main-panel>.content {
	margin-top: 0px;
}

.modal-content {
	/*padding: 51px 51px 112px 51px;*/
	border-radius: 30px !important;
	border: solid 1px #979797 !important;
	background-color: #ffffff;
}

@media ( min-width : 576px) {
	.modal-dialog {
		max-width: 972px !important;
		margin-left: 16.75rem !important;
		margin-right: 16.75rem !important;
	}
}

@media ( max-width : 767px) {
	.container-fluid {
		padding-left: 0px !important;
		padding-right: 0px !important;
	}
	.col-12 {
		padding-left: 5px !important;
		padding-right: 5px !important;
	}
	.form-group label {
		margin-left: 0 !important;
	}
	.btn-register {
		float: none !important;
	}
}

.modal-header .close {
	width: 15px;
	height: 15px;
	margin: 39px 37px 95px 49px;
	background-color: #e8ca49;
	border-radius: 30px;
	color: white !important;
	top: -20px !important;
	padding: 0.6rem;
}

.modal-header .close i {
	font-size: 10px !important;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose">
							<div class="card-icon">
								{{-- <i class="material-icons">home_work</i>--}} <img
									class="page_icon"
									src="{{asset('images/gardenhelp_icons/Requests-white.png')}}">
							</div>
							<h4 class="card-title ">Customer Request Job {{$customer_request->id}}</h4>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-7 col-sm-6 col-12">
										<div class="row">
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Location: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->work_location}}
													</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Type of work: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->type_of_work}}</span></label>
												</div>
											</div>


											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Personal Details</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Name: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->name}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Email: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->email}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Contact through: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->contact_through}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row ">
													<label class="requestLabel  col-12">Phone number: <span
														class="form-control customerRequestSpan  col-12">{{$customer_request->phone_number}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Service Details</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Service type: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->service_types}}</span></label>
												</div>
											</div>

											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Property Information</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Address: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->location}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Property Image</label>
													<div class="col">
														<img src="{{asset($customer_request->property_photo)}}"
															style="width: 200px; height: 200px">
													</div>
												</div>
											</div>


											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Property size: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->property_size}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Is this the first time
														you do service for your property?: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->is_first_time
															? 'Yes' : 'No'}}</span>
													</label>
												</div>
											</div>
											@if($customer_request->is_first_time != 1)
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">When Was the last
														Service?: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->last_service}}</span>
													</label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Site details: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->site_details}}</span></label>
												</div>
											</div>
											@endif
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Is there a parking
														access on site?: <span
														class="form-control customerRequestSpan col-12">{{$customer_request->is_parking_access
															? 'Yes' : 'No'}}</span>
													</label>
												</div>
											</div>
										</div>

									</div>
									<div class="col-md-5 col-sm-6 col-12">
										<div id="map" style="height: 100%; margin-top: 0"></div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-body" style="padding-top: 0 !important;">
							<div class="container" style="padding-bottom: 10px !important;">
								<div class="row">
									<div class="col-12">
										<div class=" row">
											<div class="col-12">
												<h5 class="cardTitleGreen requestSubTitle ">Estimated Price Quotation</h5>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="row" v-for="type in services_types">
											<div class="col-md-3 col-6">
												<label class="requestLabelGreen">@{{ type.title }}</label>
											</div>
											<div class="col-md-3 col-6">
												<span class="requestSpanGreen">€@{{ getPropertySizeRate(type) }}</span>
											</div>
										</div>

										<div class="row" style="margin-top: 15px">
											<div class="col-md-3 col-6">
												<label class="requestSpanGreen">Total</label>
											</div>
											<div class="col-md-3 col-6">
												<span class="requestSpanGreen">€@{{ getTotalPrice() }}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6 text-center">
							<form id="order-form" method="POST" action="">
								{{csrf_field()}}
								<button class="btn btn-register btn-gardenhelp-green"
									style="float: right;">Send quotation</button>
							</form>
						</div>
						<div class="col-sm-6 text-center">
							<button class="btn btn-register btn-gardenhelp-danger"
								style="float: left" data-toggle="modal"
								data-target="#rejection-reason-modal">Reject</button>
						</div>
					</div>

					<!-- Rejection Reason modal -->
					<div class="modal fade" id="rejection-reason-modal" tabindex="-1"
						role="dialog" aria-labelledby="assign-deliverer-label"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									{{--
									<h5 class="modal-title" id="assign-deliverer-label">Assign
										deliverer</h5>
									--}} {{--
									<button type="button"
										class="close d-flex justify-content-center"
										data-dismiss="modal" aria-label="Close">
										--}} {{-- <i class="fas fa-times"></i>--}} {{--
									</button>
									--}}
								</div>
								<div class="modal-body">
									<div class="col-md-12">
										<form id="request-rejection" method="POST"
											action="{{route('garden_help_postCustomerSingleRequest', ['garden-help', $customer_request->id])}}">
											{{csrf_field()}}
											<div class="text-center"
												style="font-family: Roboto; font-size: 30px; font-weight: bold; font-stretch: normal; font-style: normal; line-height: normal; letter-spacing: normal; color: #414141;">
												<img src="{{asset('images/doorder_icons/red-tick.png')}}"
													style="width: 160px" alt="Reqject"> <br> Rejected
											</div>
											<div class="form-group ">
												<label class="">Please add reason for rejection</label>
												<textarea class="form-control" name="rejection_reason"
													rows="4" required></textarea>
											</div>
										</form>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-around ">
									<div class="row">
										<div class="col-sm-6 col-12">
											<button type="button"
												class="btn btn-register btn-gardenhelp-green "
												onclick="$('form#request-rejection').submit()">Send</button>
										</div>

										<div class="col-sm-6 col-12">
											<button type="button"
												class="btn btn-register btn-gardenhelp-danger  "
												data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section('page-scripts')
	<script>
		function initMap() {
			//Map Initialization
			this.map = new google.maps.Map(document.getElementById('map'), {
				zoom: 12,
				center: {lat: 53.346324, lng: -6.258668},
				mapTypeId: "terrain",
				mapTypeId: 'hybrid'
			});

			// Define the LatLng coordinates for the polygon's path.
			let area_coordinates = {!!$customer_request->area_coordinates!!};
			const polygonCoords = [area_coordinates];
			// Construct the polygon.
			const polygon = new google.maps.Polygon({
				paths: polygonCoords,
				strokeColor: "#0068b8",
				strokeOpacity: 0.26,
				strokeWeight: 2,
				fillColor: "#0068b8",
				fillOpacity: 0.35,
			});
			polygon.setMap(map);
			// Create the bounds object
			var bounds = new google.maps.LatLngBounds();

			// Get paths from polygon and set event listeners for each path separately
			polygon.getPath().forEach(function (path, index) {

				bounds.extend(path);
			});

			// Fit Polygon path bounds
			map.fitBounds(bounds);
		}

		new Vue({
			el: '#app',
			data: {
				services_types: {!! $customer_request->services_types_json !!},
			},
			mounted() {

			},
			methods: {
				getPropertySizeRate(type) {
					let property_size = "{{$customer_request->property_size}}";
					property_size = property_size.replace(' Square Meters', '');
					let rate_property_sizes = JSON.parse(type.rate_property_sizes);
					for (let rate of rate_property_sizes) {
						console.log(rate)
						let size_from = rate.max_property_size_from;
						let size_to = rate.max_property_size_to;
						let rate_per_hour = rate.rate_per_hour;
						console.log('ss')
						if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
							let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
							console.log(this.total_price, service_price);
							this.total_price += service_price;
							return service_price;
						}
					}
				},
				getTotalPrice() {
					let property_size = "{{$customer_request->property_size}}";
					property_size = property_size.replace(' Square Meters', '');
					let total_price = 0
					for (let type of this.services_types) {
						let rate_property_sizes = JSON.parse(type.rate_property_sizes);
						for (let rate of rate_property_sizes) {
							console.log(rate)
							let size_from = rate.max_property_size_from;
							let size_to = rate.max_property_size_to;
							let rate_per_hour = rate.rate_per_hour;
							if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
								let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
								total_price += service_price;
							}
						}
					}
					return total_price;
				}
			}
		});
	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>
@endsection
