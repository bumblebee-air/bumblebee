@extends('templates.dashboard') @section('page-styles')
<style>
.select2-container {
	padding: 5px;
	border-radius: 10px;
	box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
	background-color: #ffffff;
	font-size: 14px !important;
	font-weight: normal !important;
}

.select2-container--default .select2-selection--multiple,
	.select2-container .select2-selection--single {
	width: 100% !important;
	height: auto;
}

.select2-container--default .select2-selection--single {
	border: none !important;
}

.select2-results__option {
	font-family: 'Futura', Fallback, sans-serif !important;;
	font-size: 14px !important;
	font-weight: normal !important;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
}

.select2-results__option:hover {
	font-family: 'Futura', Fallback, sans-serif !important;;
	font-size: 14px !important;
	font-weight: normal !important;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.32px;
	color: #4d4d4d;
	background-color: grey;
}

.select2-container .select2-selection--single {
	border-bottom: none !important;
}

.select2-container .select2-selection--single .select2-selection__rendered
	{
	color: #4d4d4d !important;
	font-size: 14px !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple,
	.select2-container--default .select2-selection--multiple {
	border: none !important;
}

.iti {
	width: 100%
}

.form-control {
	border-radius: 10px;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
}

.form-control:focus {
	border-color: #d176e1;
	background-image: linear-gradient(0deg, #d176e1 2px, rgba(209, 118, 225, 0)
		0), linear-gradient(0deg, #d2d2d2 1px, hsla(0, 0%, 82%, 0) 0)
}

.main-panel>.content {
	margin-top: 40px !important;
}

form .form-group select.form-control {
	top: 55px;
	left: 50%;
}
</style>

<style>
.custom-file-label {
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
	border-radius: 10px;
	line-height: 2 !important;
}

.custom-file-label:after {
	background: #e9ecef;
	padding-top: 0.8rem;
	height: 100%;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_beneficiary')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Beneficiary</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="name">* Name</label> <input
										name="name" type="text" class="form-control"
										id="name" placeholder="Enter name" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="address"> Address</label> <input name="address"
										type="text" class="form-control" id="address"
										placeholder="Enter address" > <input type="hidden"
										name="address_lat" id="address_lat" value=""> <input
										type="hidden" name="address_lon" id="address_lon" value="">
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="share">* Share</label> <input
										name="share" type="number" step="any" class="form-control"
										id="share" placeholder="Enter share"
										required>
								</div>
							</div>
						</div>

					</div>

				</div>

				<div class="row text-center">
					<div class="col-md-12">
						<button type="submit" id="saveButton"
							class="btn btn-fill btn-rose">Save</button>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
  

$(document).ready(function() {
});

               
        function initMap() {
            let address_input = document.getElementById('address');
            //Mutation observer hack for chrome address autofill issue
            let observerHackAddress = new MutationObserver(function() {
                observerHackAddress.disconnect();
				address_input.setAttribute("autocomplete", "new-password");
            });
            observerHackAddress.observe(address_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete = new google.maps.places.Autocomplete(address_input);
            autocomplete.setComponentRestrictions({'country': ['ie']});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                	
					console.log(place)
						let place_lat = place.geometry.location.lat();
						let place_lon = place.geometry.location.lng();
						document.getElementById("address_lat").value = place_lat.toFixed(5);
						document.getElementById("address_lon").value = place_lon.toFixed(5);
						//address_input.value = eircode_value.long_name;
						// if (customer_address_input.value != '') {
						//	address_input.value = place.formatted_address;
						// }
					
                }
            });

           
           
        }
</script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>


@endsection
