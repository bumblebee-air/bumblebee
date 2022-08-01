@extends('templates.doorder_dashboard') @section('page-styles') 
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
					<div class="card card-profile-page-title">
    						<div class="card-header row">
    							<div class="col-12 p-0">
									<h4 class="card-title my-md-4 mt-4 mb-1">Driver Application NO. {{$singleRequest->id}}</h4>
    							</div>    							
    						</div>
					</div>
					<div class="card">
						<div class="card-header card-header-profile-border ">
							<div class="col-md-12 pl-3">
								<h4 >Deliverer Details </h4>
							</div>
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

									

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>First Name</label>
											<span class="form-control">{{$singleRequest->first_name}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Last Name</label>
											<span class="form-control">{{$singleRequest->last_name}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Email Address</label>
											<span class="form-control">{{$singleRequest->user->email}}</span> 
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Contact Number</label>
											<span class="form-control">{{$singleRequest->user->phone}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Contact Through</label>
											<span class="form-control">{{$singleRequest->contact_channel}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Date of Birth</label>
											<span class="form-control">{{$singleRequest->dob}}</span> 
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Address</label>
											<span class="form-control" style="height: 135px">{{$singleRequest->address}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>PPS Number</label> 
											<span class="form-control">{{$singleRequest->pps_number}}</span>
										</div>
										<div class="form-group bmd-form-group">
											<label>Emergency Contact Name</label>
											<span class="form-control">{{$singleRequest->emergency_contact_name}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Emergency Contact Phone Number</label>
											<span class="form-control">{{$singleRequest->emergency_contact_number}}</span> 
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
													<label>Transport Type</label> 
													<span class="form-control">{{$singleRequest->transport}}</span>
												</div>

												<div class="form-group bmd-form-group">
													<label>Max package size</label>
													<span class="form-control">{{$singleRequest->max_package_size}}</span>
												</div>

												<div class="form-group bmd-form-group">
													<label>Work Location</label>
													<span class="form-control">{{json_decode($singleRequest->work_location)->name}}</span>
												</div>

												<div class="form-group bmd-form-group">
													<label>Radius</label>
													<span class="form-control">{{$singleRequest->work_radius}}</span> 
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
						<div class="card-header card-header-profile-border ">
							<div class="col-md-12 pl-3">
								<h4 >Verification Documents </h4>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-6 p-0">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Evidence You Can Legally Work
														In Ireland</h5>
												</div>
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($singleRequest->legal_word_evidence)}}">
														<div class="file-url-container d-flex ">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
											</div>
									</div>
									<div class="col-md-6 p-0">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Proof of Address</h5>
												</div>
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($singleRequest->address_proof)}}">
														<div class="file-url-container d-flex ">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
											</div>
									</div>
									
									@if($singleRequest->driver_license || $singleRequest->driver_license_back)
									<div class="col-md-6 p-0">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Driving License front</h5>
												</div>
												@if($singleRequest->driver_license)
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($singleRequest->driver_license)}}">
														<div class="file-url-container d-flex ">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
												@endif
												@if($singleRequest->driver_license_back)
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($singleRequest->driver_license_back)}}">
														<div class="file-url-container d-flex ">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
												@endif
											</div>
									</div>
									@endif
									@if($singleRequest->insurance_proof)
									<div class="col-md-6 p-0">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Proof of Insurance</h5>
												</div>
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($singleRequest->insurance_proof)}}">
														<div class="file-url-container d-flex ">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
											</div>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6 text-center">
							
						</div>
						<div class="col-sm-6 text-center">
							
						</div>
					</div>
					
				<div class="card"
					style="background-color: transparent; box-shadow: none;">
					<div class="card-body p-0">
						<div class="container w-100" style="max-width: 100%">

							<div class="row justify-content-center">
								<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
									<form id="order-form" method="POST"
        								action="{{route('post_doorder_drivers_single_request', ['doorder', $singleRequest->id])}}">
        								{{csrf_field()}}
        								<button class="btnDoorder btn-doorder-primary  mb-1">Accept</button>
        							</form>
								</div>
								<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
									<button class="btnDoorder btn-doorder-danger-outline  mb-1" data-toggle="modal"
											data-target="#rejection-reason-modal">Reject</button>
								</div>	
							</div>
						</div>
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
									<div class="text-center">
										<form id="request-rejection" method="POST"
											action="{{route('post_doorder_drivers_single_request', ['doorder', $singleRequest->id])}}">
											{{csrf_field()}}
											<img src="{{asset('images/doorder-new-layout/reject-img.png')}}" alt="Reject driver">
											<div class="modal-dialog-header modalHeaderMessage">Rejected</div>
											<div class="form-group bmd-form-group">
												<label class="modal-dialog-header modalSubHeaderMessage">Please add reason for rejection</label>
												<textarea class="form-control" name="rejection_reason"
													rows="4" required></textarea>
											</div>
										</form>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-primary mb-1"
											onclick="$('form#request-rejection').submit()">Send</button>
									</div>
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-danger-outline mb-1"
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
