@extends('templates.doorder_dashboard') @section('page-styles')

<link rel="stylesheet" href="{{asset('css/jquery.businessHours.css')}}">
<style>
.verificationDocs .form-group {
	margin: 8px -15px 8px -15px !important;
}
</style>
@endsection @section('title','DoOrder | Driver ' . $driver->first_name .
' ' . $driver->last_name) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)
					<form id="save-driver" method="POST"
						action="{{route('post_doorder_drivers_edit_driver', ['doorder', $driver->id])}}">
						@endif {{csrf_field()}} <input type="hidden" name="driver_id"
							value="{{$driver->id}}" />
						<div class="card card-profile-page-title">
							<div class="card-header row">
								<div class="col-12 col-md-8 p-0">
									<h4 class="card-title my-md-4 mt-4 mb-1">{{$driver->first_name}}
										{{$driver->last_name}}</h4>
								</div>
								@if($readOnly==1)
								<div class="col-12 col-md-4 ">
									<div class="row justify-content-end float-sm-right">
										<a class="editLinkA btn  btn-link btn-primary-doorder  edit"
											href="{{url('doorder/drivers/')}}/{{$driver->id}}">
											<p>Edit deliverer</p>
										</a>
									</div>
								</div>
								@endif
							</div>
						</div>

						<div class="card">
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<h4>Deliverer Details</h4>
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
													class="form-control phoneInputType" name="contact_number"
													value="{{$driver->user->phone}}"
													placeholder="Contact number" required>
											</div>
										</div>

<!-- 										<div class="col-sm-6"> -->
<!-- 											<div class="form-group bmd-form-group"> -->
<!-- 												<label>Contact through</label> <input type="text" -->
<!-- 													class="form-control" name="contact_channel" -->
<!-- 													value="{{$driver->contact_channel}}" -->
<!-- 													placeholder="Contact through" required> -->
<!-- 											</div> -->
<!-- 										</div> -->

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Date of birth</label> <input type="text"
													class="form-control dateInput" name="birthdate"
													value="{{$driver->dob}}" placeholder="Date of birth"
													required>
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
												<label>Address</label>
												<textarea class="form-control" name="address" id="driver_address"
											  		rows="5" placeholder="Address" required>{{$driver->address}}</textarea>
												<input type="hidden" class="form-control" name="address_coordinates"
											   		id="driver_address_coordinates" value="{{$driver->address_coordinates}}">
												<input type="hidden" name="address_country" id="driver_address_country" />
												<input type="hidden" name="address_city" id="driver_address_city" />
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Postcode/Eircode</label> <input type="text"
													class="form-control" name="postcode"
													id="driver_postcode"
													value="{{$driver->postcode}}"
													placeholder="Postcode/Eircode" required>
											</div>
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
													type="text" class="form-control phoneInputType"
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

											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Transport type</label> 
															 <select name="transport" class="form-control form-control-select selectpicker"
															 data-style="select-with-transition" required>
                                                                <option selected disabled>Select transport type</option>
                                                                <option value="car" @if($driver->transport == 'car' ) selected @endif>Car</option>
                                                                <option value="scooter" @if($driver->transport == 'scooter' ) selected @endif>Scooter</option>
                                                                <option value="bicycle" @if($driver->transport == 'bicycle' ) selected @endif>Bicycle</option>
                                                            </select>
                                                            
													</div>

													<div class="form-group bmd-form-group">
														<label>Max package size</label> 
															<select name="max_package_size"  class="form-control form-control-select selectpicker"
															 data-style="select-with-transition" required>
                                                                <option selected disabled>Select max package size</option>
                                                                <option value="Very Light" @if($driver->max_package_size == 'Very Light' ) selected @endif>Very light</option>
                                                                <option value="Light" @if($driver->max_package_size == 'Light' ) selected @endif>light</option>
                                                                <option value="Medium Weight" @if($driver->max_package_size == 'Medium Weight' ) selected @endif>Medium weight</option>
                                                                <option value="Very Heavy" @if($driver->max_package_size == 'Very Heavy' ) selected @endif>Very heavy</option>
                                                            </select>
													</div>

													<div class="form-group bmd-form-group">
														<label>Work location</label> <input class="form-control"
															name="work_location"
															value="{{json_decode($driver->work_location)->name}}"
															placeholder="Work location" required>
													</div>

													<div class="form-group bmd-form-group">
														<label>Radius</label> <input class="form-control"
															id="work_radius" type="number"
															name="work_radius" value="{{$driver->work_radius}}"
															placeholder="Radius" onchange="changeRadiusValue()">
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

						<div class="card verificationDocs">
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<h4>Verification Documents</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
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
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download
																file</p>
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
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download
																file</p>
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
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">License
																front</p>
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
															<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Download
																file</p>
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
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<h4>Work Type</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Work type</label>
												<select name="work_type" class="form-control form-control-select selectpicker"
															 data-style="select-with-transition" required>
                                                                <option selected disabled>Select work type</option>
                                                                <option value="full_time" @if($driver->work_type == 'full_time' ) selected @endif>Full time</option>
                                                                <option value="freelance" @if($driver->work_type == 'freelance' ) selected @endif>Freelance</option>
                                                            </select>	
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Working days/hours</label>
												<textarea class="form-control" name="working_days_hours"
													id="working_days_hours" placeholder="Working days/hours"
													rows="6" data-toggle="modal"
													data-target="#businessHoursModal">{{$driver->business_hours}}</textarea>

												<input type="hidden" id="working_days_hours_json"
													name="working_days_hours_json" value="{{$driver->business_hours}}">

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if($readOnly==0)
						<div class="card"
							style="background-color: transparent; box-shadow: none;">
							<div class="card-body p-0">
								<div class="container w-100" style="max-width: 100%">

									<div class="row justify-content-center">
										<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
											<button class="btnDoorder btn-doorder-primary  mb-1">Save</button>
										</div>
										<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
											<button class="btnDoorder btn-doorder-danger-outline  mb-1"
												type="button" data-toggle="modal"
												data-target="#delete-driver-modal">Delete</button>
										</div>
									</div>
								</div>
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
									<div class="modal-dialog-header modalHeaderMessage">Are you
										sure you want to delete this account?</div>
									<div>
										<form method="POST" id="delete-driver"
											action="{{url('doorder/driver/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="driverId" name="driverId"
												value="{{$driver->id}}" />
										</form>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-primary mb-1"
											onclick="$('form#delete-driver').submit()">Yes</button>
									</div>

									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-danger-outline mb-1"
											data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- end delete driver modal -->

					<!-- Workig Hours Modal -->
					<div class="modal fade" id="businessHoursModal" tabindex="-1"
						role="dialog" aria-labelledby="#businessHoursLabel"
						aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button"
										class="close d-flex justify-content-center"
										data-dismiss="modal" aria-label="Close">
										<i class="fas fa-times"></i>
									</button>
								</div>

								<div class="modal-body">
									<div class="modal-dialog-header modalHeaderMessage mb-4">Select
										Working Days and Hours </div>
										
									<div class="row justify-content-center">
										<div id="business_hours_container" class="row"></div>
									</div>

									<div class="row justify-content-center mt-4">
										<div class="col-lg-4 col-md-6 text-center">
											<button type="button"
												class="btnDoorder btn-doorder-primary mb-1"
												onclick="serializeBusinessHours()" data-dismiss="modal"
												aria-label="Close">Save changes</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--  end working hours modal -->
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')

<script src="{{asset('js/jquery.businessHours.min.js')}}"></script>
<script>
	let autocomp_countries = JSON.parse('{!! $google_auto_comp_countries !!}');
	let business_hours_initial_array = [
		{"isActive":true,"timeFrom":null,"timeTill":null},
		{"isActive":true,"timeFrom":null,"timeTill":null},
		{"isActive":true,"timeFrom":null,"timeTill":null},
		{"isActive":true,"timeFrom":null,"timeTill":null},
		{"isActive":true,"timeFrom":null,"timeTill":null},
		{"isActive":true,"timeFrom":null,"timeTill":null},
		{"isActive":true,"timeFrom":null,"timeTill":null}
	];
 
	let map;
	let home_address_circle;
	let bounds;

$( document ).ready(function() {
    var readonly = {!! $readOnly !!};
    if(readonly==1){
        $("input").prop('disabled', true);
        $("textarea").prop('disabled', true);
        $("select").prop('disabled', true);
    }
    
    addIntlPhoneInput();
    
    var driverBusinessHoursJson = '{!! $driver->business_hours_json !!}';
    console.log(business_hours_initial_array)
    console.log(driverBusinessHoursJson)
    if(driverBusinessHoursJson != ''){
    	business_hours_initial_array = JSON.parse(driverBusinessHoursJson);
    }
    console.log(business_hours_initial_array)
    console.log(driverBusinessHoursJson)
    
    $(".dateInput").datetimepicker({
    				format:'YYYY-MM-DD',
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
    
    window['business_hours_container'] = $('#business_hours_container').businessHours({
                    operationTime: business_hours_initial_array,
                    checkedColorClass: "workingBusinssDay", // optional
                    uncheckedColorClass: "dayOff",          // optional
                    
                    dayTmpl:'<div class="dayContainer col-md-3 col-4 mt-1" style="">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                        '<div class="weekday text-center"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" class="mini-time form-control operationTimeFrom" name="startTime" value=""></div>' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" class="mini-time form-control operationTimeTill" name="endTime" value=""></div>' +
                        '</div></div>',
                })
});

function serializeBusinessHours(){
	console.log(business_hours_initial_array)
	let businessHoursoutput = window['business_hours_container'].serialize()
                    let businessHoursText = '';
                    let businessHours = [];
                    let weekDays = {
                        0:'Monday',
                        1:'Tuesday',
                        2:'Wednesday',
                        3:'Thursday',
                        4:'Friday',
                        5:'Saturday',
                        6:'Sunday',
                    }
                    for (let item of businessHoursoutput) {
                        if (item.isActive) {
                            businessHoursText += weekDays[businessHoursoutput.indexOf(item)] + ': From:' + item.timeFrom + ', To: ' + item.timeTill + '/'
                        }
                        let key = weekDays[businessHoursoutput.indexOf(item)]
                        businessHours.push(item);
                    }
                    console.log(businessHoursText)
                    console.log(businessHours)
                    $('#working_days_hours').val(businessHoursText)
                    $('#working_days_hours_json').val(JSON.stringify(businessHours))
}

function addIntlPhoneInput(){
	var phoneInputs = document.getElementsByClassName("phoneInputType");
	for(var i=0; i<phoneInputs.length; i++){
		//console.log(phoneInputs[i])
		intlTelInput(phoneInputs[i], {
				   initialCountry: 'IE',
				   separateDialCode: true,
				   preferredCountries: ['IE', 'GB'],
				   utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
			   });
	}
}
function  changeRadiusValue() {
                    if ($("#work_radius").val() != 0) {
                        home_address_circle.setRadius(parseInt($("#work_radius").val()) * 1000);
                        map.fitBounds(bounds);
                    }
                }

        function initMap() {
            let address_coordinates = JSON.parse({!! json_encode($driver->address_coordinates) !!});
            let work_location_coordinates = JSON.parse({!! json_encode($driver->work_location) !!});
            map = new google.maps.Map(document.getElementById('driver_map'), {
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

            home_address_circle = new google.maps.Circle({
                center: {lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)},
                map: map,
                radius: parseInt({!! $driver->work_radius ? $driver->work_radius : 0 !!}) * 1000,
                strokeColor: "#f5da68",
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: "#f5da68",
                fillOpacity: 0.4,
            });
            bounds = new google.maps.LatLngBounds();
            bounds.extend({lat: parseFloat(work_location_coordinates.coordinates.lat), lng: parseFloat(work_location_coordinates.coordinates.lng)})
            bounds.extend({lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)})
            map.fitBounds(bounds);
            
            //////////////////////////////////////////////////
            //Autocomplete Initialization
            let driver_address_input = document.getElementById('driver_address');
			let driver_postcode_input = document.getElementById('driver_postcode');
            //Mutation observer hack for chrome address autofill issue
            let observerHackDriverAddress = new MutationObserver(function() {
                observerHackDriverAddress.disconnect();
                driver_postcode_input.setAttribute("autocomplete", "new-password");
            });
            observerHackDriverAddress.observe(driver_postcode_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete_driver_address = new google.maps.places.Autocomplete(driver_postcode_input);
            autocomplete_driver_address.setComponentRestrictions({
				'country': autocomp_countries
			});
            autocomplete_driver_address.addListener('place_changed', () => {
                let place = autocomplete_driver_address.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                	let eircode_value = place.address_components.find((x) => {
						if (x.types.includes("postal_code")) {
							return x;
						}
						return undefined;
					});
					 console.log(eircode_value)
					 //if (eircode_value != undefined) {
						let place_lat = place.geometry.location.lat();
						let place_lon = place.geometry.location.lng();
						document.getElementById("driver_address_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) +'}';
						driver_postcode_input.value = eircode_value.long_name;
						driver_address_input.value = place.formatted_address;

						homeAddressMarker.setPosition({lat: place_lat, lng: place_lon});
						homeAddressMarker.setVisible(true)
						home_address_circle.setCenter({lat: place_lat, lng: place_lon});
						if ($('input#work_radius').val() != '' && $('input#work_radius').val() != null) {
							home_address_circle.setRadius(parseInt($('input#work_radius').val()) * 1000);
						}
						bounds = new google.maps.LatLngBounds();
						bounds.extend({lat: place_lat, lng: place_lon})
						map.fitBounds(bounds);
					 //}
					//Extract city and country from address
					let address_components = place.address_components;
					let city=null, country=null;
					address_components.forEach(function(component) {
						let types = component.types;
						if(types.indexOf('city') > -1) {
							city = component.long_name;
						}
						if(types.indexOf('locality') > -1 && city==null) {
							city = component.long_name;
						}
						if(types.indexOf('administrative_area_level_1') > -1 && city==null) {
							city = component.long_name;
						}
						if(types.indexOf('postal_town') > -1 && city==null) {
							city = component.long_name;
						}
						if(types.indexOf('country') > -1) {
							country = component.long_name;
						}
					});
					$('#driver_address_city').val(city);
					$('#driver_address_country').val(country);
                }
            });
        }
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
