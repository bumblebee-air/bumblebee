@extends('templates.dashboard') @section('page-styles') 
<style>

.form-head {
	padding-top: 20px;
	padding-bottom: 20px;
}
</style>
@endsection @section('title','DoOrder | Driver Application NO. ' .
$singleRequest->id) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					{{csrf_field()}}
					<div class="card">
						<div class="card-header card-header-icon card-header-rose">
							<div class="card-icon"><img
									class="page_icon"
									src="{{asset('images/doorder_icons/drivers_requests.png')}}">
							</div>
							<h4 class="card-title ">Driver Application NO.
								{{$singleRequest->id}}</h4>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										@if(count($errors))
										<div class="alert alert-danger" role="alert">
											<ul>
												@foreach ($errors->all() as $error)
												<li>{{$error}}</li> @endforeach
											</ul>
										</div>
										@endif
									</div>

									<div class="col-md-12 d-flex form-head pl-3">
										<span> 1 </span> Deliverer Details
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>First Name</label> <input type="text"
												class="form-control" name="first_name"
												value="{{$singleRequest->first_name}}"
												placeholder="First Name" required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Last Name</label> <input type="text"
												class="form-control" name="last_name"
												value="{{$singleRequest->last_name}}"
												placeholder="Last Name" required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Email Address</label> <input type="email"
												class="form-control" name="email"
												value="{{$singleRequest->user->email}}"
												placeholder="Email Address" required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Contact Number</label> <input type="text"
												class="form-control" name="contact_number"
												value="{{$singleRequest->user->phone}}"
												placeholder="Contact Number" required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Contact Through</label> <input type="text"
												class="form-control" name="contact_channel"
												value="{{$singleRequest->contact_channel}}"
												placeholder="Contact Through" required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Date of Birth</label> <input type="text"
												class="form-control" name="birthdate"
												value="{{$singleRequest->dob}}" placeholder="Date of Birth"
												required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Address</label>
											<textarea class="form-control" name="address"
												placeholder="Address" rows="5" required>{{$singleRequest->address}}</textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>PPS Number</label> <input type="text"
												class="form-control" name="pps_number"
												value="{{$singleRequest->pps_number}}"
												placeholder="PPS Number" required>
										</div>
										<div class="form-group bmd-form-group">
											<label>Emergency Contact Name</label> <input type="text"
												class="form-control" name="emergency_contact_name"
												value="{{$singleRequest->emergency_contact_name}}"
												placeholder="Emergency Contact Name" required>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Emergency Contact Phone Number</label> <input
												type="text" class="form-control"
												name="emergency_contact_number"
												value="{{$singleRequest->emergency_contact_number}}"
												placeholder="Emergency Contact Phone Number" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card">
						
						<div class="card-body">
							<div class="container">
								<div class="row">
									

									<div class="col-md-12">
										
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Transport Type</label> <input class="form-control"
														value="{{$singleRequest->transport}}"
														placeholder="Transport Type" required>
												</div>

												<div class="form-group bmd-form-group">
													<label>Max package size</label> <input class="form-control"
														value="{{$singleRequest->max_package_size}}"
														placeholder="Max package size" required>
												</div>

												<div class="form-group bmd-form-group">
													<label>Work Location</label> <input class="form-control"
														value="{{json_decode($singleRequest->work_location)->name}}"
														placeholder="Work Location" required>
												</div>

												<div class="form-group bmd-form-group">
													<label>Radius</label> <input class="form-control"
														value="{{$singleRequest->work_radius}}"
														placeholder="Radius" required>
												</div>

											</div>

											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													
													<div id="driver_map" style="height: 320px;"></div>
												</div>
											</div>

										</div>

									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-12 d-flex form-head pl-3">
										<span> 3 </span> Verification Documents
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<a target="_blank"
												href="{{asset($singleRequest->legal_word_evidence)}}"
												style="color: #333">
												<div class="file-url-container d-flex">
													<i class="fas fa-file"></i>
													<p class="mt-xl-3 pl-xl-3 pl-2 my-auto">Evidence you can legally work in
														Ireland</p>
												</div>
											</a>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<a target="_blank"
												href="{{asset($singleRequest->address_proof)}}"
												style="color: #333">
												<div class="file-url-container d-flex">
													<i class="fas fa-file"></i>
													<p class="mt-xl-3 pl-xl-3 pl-2 my-auto">Proof of Address</p>
												</div>
											</a>
										</div>
									</div>

									@if($singleRequest->driver_license)
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<a target="_blank"
												href="{{asset($singleRequest->driver_license)}}"
												style="color: #333">
												<div class="file-url-container d-flex">
													<i class="fas fa-file"></i>
													<p class="mt-xl-3 pl-xl-3 pl-2 my-auto">Driving License front</p>
												</div>
											</a>
										</div>
									</div>
									@endif @if($singleRequest->driver_license_back)
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<a target="_blank"
												href="{{asset($singleRequest->driver_license_back)}}"
												style="color: #333">
												<div class="file-url-container d-flex">
													<i class="fas fa-file"></i>
													<p class="mt-xl-3 pl-xl-3 pl-2 my-auto">Driving License back</p>
												</div>
											</a>
										</div>
									</div>
									@endif @if($singleRequest->insurance_proof)
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<a target="_blank"
												href="{{asset($singleRequest->insurance_proof)}}"
												style="color: #333">
												<div class="file-url-container d-flex">
													<i class="fas fa-file"></i>
													<p class="mt-xl-3 pl-xl-3 pl-2 my-auto">Proof of Insurance</p>
												</div>
											</a>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6 text-center">
							<form id="order-form" method="POST"
								action="{{route('post_doorder_drivers_single_request', ['doorder', $singleRequest->id])}}">
								{{csrf_field()}}
								<button class="btn bt-submit">Accept</button>
							</form>
						</div>
						<div class="col-sm-6 text-center">
							<button class="btn bt-submit btn-danger" data-toggle="modal"
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
									
									<button type="button"
										class="close d-flex justify-content-center"
										data-dismiss="modal" aria-label="Close">
										<i class="fas fa-times"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="col-md-12">
										<form id="request-rejection" method="POST"
											action="{{route('post_doorder_drivers_single_request', ['doorder', $singleRequest->id])}}">
											{{csrf_field()}}
											<div class="text-center"
												style="font-size: 30px; font-weight: bold; font-stretch: normal; font-style: normal; line-height: normal; letter-spacing: normal; color: #414141;">
												<img src="{{asset('images/doorder_icons/red-tick.png')}}"
													style="width: 160px" alt="Reqject"> <br> Rejected
											</div>
											<div class="form-group bmd-form-group">
												<label>Please add reason for rejection</label>
												<textarea class="form-control" name="rejection_reason"
													rows="4" required></textarea>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<button type="button"
											class="btn btn-primary doorder-btn-lg doorder-btn"
											onclick="$('form#request-rejection').submit()">Send</button>
									</div>
									<div class="col-sm-6">
										<button type="button"
											class="btn btn-danger doorder-btn-lg doorder-btn"
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
@endsection @section('page-scripts')
<script>
        function initMap() {
            let address_coordinates = JSON.parse({!! json_encode($singleRequest->address_coordinates) !!});
            let work_location_coordinates = JSON.parse({!! json_encode($singleRequest->work_location) !!});
            let map = new google.maps.Map(document.getElementById('driver_map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });

            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
            };

            window.workLocationMarker = new google.maps.Marker({
                map: map,
                icon: marker_icon,
                // anchorPoint: new google.maps.Point(0, -29)
                position: {lat: parseFloat(work_location_coordinates.coordinates.lat), lng: parseFloat(work_location_coordinates.coordinates.lng)}
            });

            window.homeAddressMarker = new google.maps.Marker({
                map: map,
                icon: marker_icon,
                position: {lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)}
            });

            let home_address_circle = new google.maps.Circle({
                center: {lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)},
                map: map,
                radius: parseInt({!! $singleRequest->work_radius ? $singleRequest->work_radius : 0 !!}) * 1000,
                strokeColor: "#f5da68",
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: "#f5da68",
                fillOpacity: 0.4,
            });
            let bounds = new google.maps.LatLngBounds();
            bounds.extend({lat: parseFloat(work_location_coordinates.coordinates.lat), lng: parseFloat(work_location_coordinates.coordinates.lng)})
            bounds.extend({lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)})
            map.fitBounds(bounds);
        }
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
