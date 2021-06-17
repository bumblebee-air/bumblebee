@extends('templates.dashboard') @section('page-styles')
<style>
.verificationDocs .form-group{
margin: 8px -15px 8px -15px !important;
}
</style>
 @endsection
@section('title','DoOrder | Driver ' . $driver->first_name . ' ' .
$driver->last_name) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)<form id="save-driver" method="POST"
						action="{{route('post_doorder_drivers_edit_driver', ['doorder', $driver->id])}}">
					@endif	
						{{csrf_field()}}
						<input type="hidden" name="driver_id" value="{{$driver->id}}"/>
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-md-8">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/doorder_icons/Deliverers-white.png')}}">
									</div>
									<h4 class="card-title ">{{$driver->first_name}}
										{{$driver->last_name}}</h4>
								</div>
 								@if($readOnly==1)
								<div class="col-12 col-md-4 mt-md-5">
									<div class="row justify-content-end float-sm-right">
										<a class="editLinkA btn  btn-link btn-primary-doorder  edit" href="{{url('doorder/drivers/')}}/{{$driver->id}}">
											<p>Edit deliverer</p>
										</a>
									</div>
								</div>
								@endif
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
											<span> 1 </span>
											<h5 class="singleViewSubTitleH5">Deliverer Details</h5>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label for="first_name">First name</label> <input
													type="text" class="form-control" id="first_name"
													name="first_name" value="{{$driver->first_name}}"
													placeholder="First name" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Last name</label> <input type="text"
													class="form-control" name="last_name"
													value="{{$driver->last_name}}" placeholder="Last name"
													required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Email address</label> <input type="email"
													class="form-control" name="email"
													value="{{$driver->user->email}}"
													placeholder="Email address" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Contact number</label> <input type="text"
													class="form-control" name="contact_number"
													value="{{$driver->user->phone}}"
													placeholder="Contact number" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Contact through</label> <input type="text"
													class="form-control" name="contact_channel"
													value="{{$driver->contact_channel}}"
													placeholder="Contact through" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Date of birth</label> <input type="text"
													class="form-control" name="birthdate"
													value="{{$driver->dob}}" placeholder="Date of birth"
													required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Address</label>
												<textarea class="form-control" name="address"
													placeholder="Address" required>{{$driver->address}}</textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Postcode/Eircode</label> <input type="text"
													class="form-control" name="postcode"
													value="{{$driver->postcode}}"
													placeholder="Postcode/Eircode" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Country</label> <input type="text"
													class="form-control" name="country"
													value="{{$driver->country}}" placeholder="Country">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>PPS number</label> <input type="text"
													class="form-control" name="pps_number"
													value="{{$driver->pps_number}}" placeholder="PPS number"
													required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Emergency contact name</label> <input type="text"
													class="form-control" name="emergency_contact_name"
													value="{{$driver->emergency_contact_name}}"
													placeholder="Emergency contact name">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Emergency contact phone number</label> <input
													type="text" class="form-control"
													name="emergency_contact_number"
													value="{{$driver->emergency_contact_number}}"
													placeholder="Emergency contact phone number">
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
											{{-- <label v-if="locations.length > 1">Location @{{ index +
												1 }}</label>--}}
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Transport type</label> <input class="form-control"
															value="{{$driver->transport}}" name="transport"
															placeholder="Transport type" required>
													</div>

													<div class="form-group bmd-form-group">
														<label>Max package size</label> <input
															class="form-control" name="max_package_size"
															value="{{$driver->max_package_size}}"
															placeholder="Max package size" required>
													</div>

													<div class="form-group bmd-form-group">
														<label>Work location</label> <input class="form-control"
															name="work_location"
															value="{{json_decode($driver->work_location)->name}}"
															placeholder="Work location" required>
													</div>

													<div class="form-group bmd-form-group">
														<label>Radius</label> <input class="form-control"
															name="work_radius" value="{{$driver->work_radius}}"
															placeholder="Radius">
													</div>

												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														{{-- <label>Address</label>--}} {{--
														<textarea class="form-control" rows="14"
															placeholder="Address" required></textarea>
														--}}
														<div id="driver_map" style="height: 320px;"></div>
													</div>
												</div>

											</div>

											<!-- Workig Hours Modal -->
											<div class="modal fade" :id="'exampleModal' + index"
												tabindex="-1" role="dialog"
												aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Select
																Working Days and Hours</h5>
															<button type="button" class="close" data-dismiss="modal"
																aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="row justify-content-center">
																<div :id="'business_hours_container' + (index + 1)"></div>
															</div>
														</div>
														<div class="modal-footer d-flex justify-content-center">
															<button type="button" class="btn btn-submit"
																@click="serializeBusinessHours(index + 1)"
																data-dismiss="modal" aria-label="Close">Save changes</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="card verificationDocs">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 d-flex form-head pl-3">
											<span> 2 </span>

											<h5 class="singleViewSubTitleH5">Verification Documents</h5>
										</div>

										<div class="col-md-6">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Evidence You Can Legally Work
														In Ireland</h5>
												</div>
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($driver->legal_word_evidence)}}"
														style="color: #333">
														<div class="file-url-container d-flex ">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Proof of Address</h5>
												</div>
												<div class="col-md-6">
													<a target="_blank" href="{{asset($driver->address_proof)}}"
														style="color: #333">
														<div class="file-url-container d-flex">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download file</p>
														</div>
													</a>
												</div>
											</div>
										</div>


										@if($driver->driver_license || $driver->driver_license_back)

										<div class="col-md-6">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Driving License</h5>
												</div>
												@if($driver->driver_license)
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($driver->driver_license)}}"
														style="color: #333">
														<div class="file-url-container d-flex">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">License front</p>
														</div>
													</a>
												</div>
												@endif @if($driver->driver_license_back)
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($driver->driver_license_back)}}"
														style="color: #333">
														<div class="file-url-container d-flex">
															<i class="fas fa-file"></i>
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">License back</p>
														</div>
													</a>
												</div>
												@endif
											</div>
										</div>
										@endif @if($driver->insurance_proof)
										<div class="col-md-6">
											<div class="form-group bmd-form-group row">
												<div class="col-md-12">
													<h5 class="downloadFilesH5">Proof Of Insurance</h5>
												</div>
												<div class="col-md-6">
													<a target="_blank"
														href="{{asset($driver->insurance_proof)}}"
														style="color: #333">
														<div class="file-url-container d-flex">
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

						<div class="card">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 d-flex form-head pl-3">
											<span> 3 </span>

											<h5 class="singleViewSubTitleH5">Work Type</h5>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Work type</label> <input type="text"
													class="form-control" name="work_type" value=""
													placeholder="Work type">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Working days/hours</label>
												<textarea class="form-control" name="working_days_hours"
													placeholder="Working days/hours"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if($readOnly==0)
						<div class="row">
							<div class="col-sm-6 text-center">

								<button class="btn bt-submit">Save</button>
							</div>
							<div class="col-sm-6 text-center">
								<button class="btn bt-submit btn-danger" type="button"
									data-toggle="modal" data-target="#delete-driver-modal">Delete</button>
							</div>
						</div>
						

					</form>
					@endif

					<!-- Delete driver modal -->
					<div class="modal fade" id="delete-driver-modal" tabindex="-1"
						role="dialog" aria-labelledby="delete-deliverer-label"
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
									<div class="modal-dialog-header deleteHeader">Are you sure you
										want to delete this account?</div>
									<div>
										<form method="POST" id="delete-driver"
											action="{{url('doorder/driver/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="driverId" name="driverId"
												value="{{$driver->id}}" />
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
					<button type="button"
										class="btn btn-primary doorder-btn-lg doorder-btn"
										onclick="$('form#delete-driver').submit()">Yes</button></div>
									<div class="col-sm-6">
					<button type="button"
										class="btn btn-danger doorder-btn-lg doorder-btn"
										data-dismiss="modal">Cancel</button></div>
								</div>
							</div>
						</div>
					</div>
					<!-- end delete driver modal -->
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')
<script>
$( document ).ready(function() {

var readonly = {!! $readOnly !!};
if(readonly==1){
$("input").prop('disabled', true);
$("textarea").prop('disabled', true);
}
});

        function initMap() {
            let address_coordinates = JSON.parse({!! json_encode($driver->address_coordinates) !!});
            let work_location_coordinates = JSON.parse({!! json_encode($driver->work_location) !!});
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
                radius: parseInt({!! $driver->work_radius ? $driver->work_radius : 0 !!}) * 1000,
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
