@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.iti {
	width: 100%;
}

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}

.card-title.customerProfile {
	display: inline-block;
}

.addContactDetailsCircle {
	color: #d58242;
	font-size: 18px;
}

.removeContactDetailsCircle {
	color: #df5353;
	font-size: 18px;
}
</style>
@endsection @section('title','Unified | Add Engineer ')
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<form id="customer-form" method="POST"
						action="{{route('unified_postAddEngineer', ['unified'])}}"
						>
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Engineers.png')}}">
									</div>
									<h4 class="card-title customerProfile">Engineer Details</h4>
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
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>First name</label> <input type="text"
													class="form-control" name="first_name"
													placeholder="First name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Last name</label> <input type="text"
													class="form-control" name="last_name"
													placeholder="Last name" required>
											</div>
										</div>

									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Phone number</label> <input type="tel"
													class="form-control" name="phone" id="phone"
													placeholder="Phone number" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Email</label> <input type="email" class="form-control"
													name="email" placeholder="Email" required>
											</div>
										</div>
									</div>

									<div class="row">

										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Address</label>
												<textarea class="form-control" name="address" id="address"
													placeholder="Address" required></textarea>
											</div>
										</div>
										<div class="col-md-6">
											<div class="" style="margin-top: 15px">
												<label class="labelRadio col-12" for="">Job type</label>
												<div class="col-12 row">
													<div class="col">
														<div class="form-check form-check-radio">
															<label class="form-check-label"> <input
																class="form-check-input" type="radio"
																id="exampleRadios2" name="job_type" value="full_time" required>
																Full time <span class="circle"> <span class="check"></span>
															</span>
															</label>
														</div>
													</div>
													<div class="col">
														<div class="form-check form-check-radio">
															<label class="form-check-label"> <input
																class="form-check-input" type="radio"
																id="exampleRadios1" name="job_type" value="contract" required >
																Contract <span class="circle"> <span class="check"></span>
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


						

						<div class="row ">
							<div class="col-md-12 text-center">

								<button class="btn btn-unified-primary singlePageButton">Add</button>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts')

<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script>

	var app = new Vue({
		el: '#app',
		data: {

		},
		methods: {
		}
	});

$( document ).ready(function() {

	
	addIntelInput('phone','phone');

});

function addIntelInput(input_id, input_name) {
            let phone_input = document.querySelector("#" + input_id);
            window.intlTelInput(phone_input, {
                hiddenInput: input_name,
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
        }  
  //Map Js
		window.initAutoComplete = function initAutoComplete() {
			//Autocomplete Initialization
			let location_input = document.getElementById('address');
			//Mutation observer hack for chrome address autofill issue
			let observerHackAddress = new MutationObserver(function() {
				observerHackAddress.disconnect();
				location_input.setAttribute("autocomplete", "new-password");
			});
			observerHackAddress.observe(location_input, {
				attributes: true,
				attributeFilter: ['autocomplete']
			});
			let autocomplete_location = new google.maps.places.Autocomplete(location_input);
			autocomplete_location.setComponentRestrictions({'country': ['ie']});
			autocomplete_location.addListener('place_changed', () => {
				let place = autocomplete_location.getPlace();
				if (!place.geometry) {
					// User entered the name of a Place that was not suggested and
					// pressed the Enter key, or the Place Details request failed.
					window.alert("No details available for input: '" + place.name + "'");
				} else {
					let place_lat = place.geometry.location.lat();
					let place_lon = place.geometry.location.lng();

					//document.getElementById("address_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
				}
			});
		}
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initAutoComplete"></script>

@endsection
