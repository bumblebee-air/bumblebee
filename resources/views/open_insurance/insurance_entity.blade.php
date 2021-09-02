@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('open_insurance/save_insurance_entity')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Insurance Entity</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="name">* Name</label> <input name="name" type="text"
										class="form-control" id="name" placeholder="Enter name"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="trade_name">* Trade name</label> <input
										name="trade_name" type="text" class="form-control"
										id="trade_name" placeholder="Enter trade name" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="entity_type_select">* Type</label> <select
										id="entity_type_select" name="entity_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($entityTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="classification_select">* Classification</label> <select
										id="classification_select" name="classification"
										class="form-control" required><option value="">Select
											classification</option> @foreach($classifications as
										$classification)
										<option value="{{$classification->id}}">
											{{$classification->name}}</option> @endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="registration_number">* Registration number</label>
									<input name="registration_number" type="text"
										class="form-control" id="registration_number"
										placeholder="Enter registration number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="year_established">* Year established</label> <input
										name="year_established" type="text" class="form-control"
										id="year_established" placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="address">* Address</label> <input name="address"
										type="text" class="form-control" id="address"
										placeholder="Enter address" required> <input type="hidden"
										name="address_lat" id="address_lat" value=""> <input
										type="hidden" name="address_lon" id="address_lon" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="website">* Website</label> <input name="website"
										type="text" class="form-control" id="website"
										placeholder="Enter website" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="telephone">* Telephone</label> <input
										name="telephone" type="tel" class="form-control"
										id="telephone" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="credit_rating">* Credit rating</label> <input
										name="credit_rating" type="text" class="form-control"
										id="credit_rating" placeholder="Enter credit rating" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="developer_portal">* Developer portal</label> <input
										name="developer_portal" type="text" class="form-control"
										id="developer_portal" placeholder="Enter developer portal"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="product_catalog_select">* Product catalog</label> <select
										id="product_catalog_select" name="product_catalog"
										class="form-control" required><option value="">Select catalog</option>
										@foreach($productCatalogs as $productCatalog)
										<option value="{{$productCatalog->id}}">
											{{$productCatalog->name}}</option> @endforeach

									</select>
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
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script type="text/javascript">
  

$(document).ready(function() {
    $("#entity_type_select, #classification_select,#product_catalog_select").select2({ 
        allowClear: true,placeholder:'Select level' }).trigger('change');
    $("#year_established").datetimepicker({
    		format: 'YYYY-MM-DD ',
    });
    
     let phone_input = document.querySelector("#telephone");
                window.intlTelInput(phone_input, {
                    hiddenInput: 'telephone',
                    initialCountry: 'IE',
                    separateDialCode: true,
                    preferredCountries: ['IE', 'GB'],
                    utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
                });

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
