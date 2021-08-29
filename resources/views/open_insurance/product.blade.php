@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
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
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_product')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Product</h4>
					</div>

					<div class="card-body ">


						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="product_catalog_select">* Line of business</label>
									<select id="line_of_business_select" name="line_of_business" 
										class="form-control" required>
										<option value="">Select line of business</option>
										@foreach($productCatalogs as $productCatalog)
										<option value="{{$productCatalog->id}}">
											{{$productCatalog->name}}</option> @endforeach

									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="product_model_select">* Product model</label> <select
										id="product_model_select" name="product_model"
										class="form-control" required><option value="">Select model</option>
										@foreach($productModels as $productModel)
										<option value="{{$productModel->id}}">
											{{$productModel->name}}</option> @endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="contract_type_select">* Contract type</label> <select
										id="contract_type_select" name="contract_type"
										class="form-control" required>
										<option value="">Select contract type 
										</option>
										@foreach($contractTypes as $contractType)
										<option value="{{$contractType->id}}">
											{{$contractType->name}}</option> @endforeach

									</select>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="grace_period">* Grace period</label> <input
										name="grace_period" type="text" class="form-control"
										id="grace_period" placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="currency_select">* Currency </label> <select
										id="currency_select" name="currency"
										class="form-control" required>
										<option value="">Select currency
										</option>
										@foreach($currencies as $currency)
										<option value="{{$currency->id}}">
											{{$currency->name}}</option> @endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="policyWording">* Policy wording</label> <input
										name="policy_wording" type="text" class="form-control"
										id="policyWording" placeholder="Enter policy wording" required>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="payment_method_select"> Payment method</label> <select
										id="payment_method_select" name="payment_method"
										class="form-control" >
										<option value="">Select payment method
										</option>
										@foreach($paymentMethods as $paymentMethod)
										<option value="{{$paymentMethod->id}}">
											{{$paymentMethod->name}}</option> @endforeach

									</select>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="coverage_select">* Coverage</label> <select
										id="coverage_select" name="coverage"
										class="form-control" required>
										<option value="">Select coverage
										</option>
										@foreach($coverages as $coverage)
										<option value="{{$coverage->id}}">
											{{$coverage->name}}</option> @endforeach

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
    $("#line_of_business_select").select2({ 
        allowClear: true,placeholder:'Select line of business' }).trigger('change');
     $("#product_model_select").select2({ 
        allowClear: true,placeholder:'Select product model' }).trigger('change');    
     $("#contract_type_select").select2({ 
        allowClear: true,placeholder:'Select contract type' }).trigger('change');    
     $("#currency_select").select2({ 
        allowClear: true,placeholder:'Select currency' }).trigger('change');         
     $("#payment_method_select").select2({ 
        allowClear: true,placeholder:'Select payment method' }).trigger('change');     
     $("#coverage_select").select2({ 
        allowClear: true,placeholder:'Select coverage' }).trigger('change');    
        
        
        
    $("#grace_period").datetimepicker({
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
