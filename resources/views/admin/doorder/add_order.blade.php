@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/mdtimepicker.css')}}">
<style>
/* #importButton { */
/* 	font-size: 14px; */
/* 	font-weight: 600; */
/* 	font-stretch: normal; */
/* 	font-style: normal; */
/* 	line-height: normal; */
/* 	letter-spacing: 0.72px; */
/* 	color: #ffffff; */
/* 	border-radius: 12px 0; */
/* 	text-transform: inherit !important; */
/* 	height: auto; */
/* 	padding: 10px; */
/* } */
.mdtp__wrapper[data-theme='blue'] .mdtp__time_holder {
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__digit.active span,
	.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__digit span:hover
	{
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__digit.active:before {
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__clock_dot {
	background-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__am.active,
	.mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__pm.active {
	background-color: #F7DC69 !important;
	border-color: #F7DC69 !important;
}

.mdtp__wrapper[data-theme='blue'] .mdtp__button {
	color: #F7DC69;
}

.mdtp__button:hover {
	color: white !important;
}

.mdtp__wrapper {
	bottom: 0 !important;
	top: 10%;
	box-shadow: none !important;
}
</style>
@endsection @section('title','DoOrder | Add New Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">
								<h4 class="card-title my-md-4 mt-4 mb-1">New Order</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">

								<div class="row justify-content-end mb-1 mt-2 mt-xs-0"
									id="dashboardFilterRowDiv">

									<div class="col-xl-5 col-sm-6 px-md-1">
										<a id="importButton"
											class=" btn-doorder-filter btn-doorder-filter-grey w-100"
											href="{{url('doorder/orders/upload_orders')}}">Upload mass
											order</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<form id="order-form" method="POST"
						action="{{route('doorder_saveNewOrder', 'doorder')}}">
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<h4>Customer Details</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email" class="control-label"> First name <span
													style="color: red">*</span>
												</label> <input id="first_name" type="text"
													class="form-control" value="{{old('first_name')}}"
													name="first_name" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email" class="control-label"> Last name<span
													style="color: red">*</span>
												</label> <input id="last_name" type="text"
													class="form-control" value="{{old('last_name')}}"
													name="last_name" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="email" class="control-label">Email</label> <input
													id="email" type="email" class="form-control"
													value="{{old('email')}}" name="email">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="customer_phone" class="control-label">Contact
													number<span style="color: red">*</span>
												</label>
												<div>
													<input id="customer_phone" type="tel" class="form-control"
														value="{{old('customer_phone')}}" required>
												</div>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="customer_address" class="control-label">Address
													<span style="color: red">*</span> <span
													style="font-size: smaller">(please fill in Eircode first)</span>
												</label> <input id="customer_address" type="text"
													class="form-control" value="{{old('customer_address')}}"
													name="customer_address" required> <input type="hidden"
													name="customer_lat" id="customer_lat"
													value="{{old('customer_lat')}}"> <input type="hidden"
													name="customer_lon" id="customer_lon"
													value="{{old('customer_lon')}}">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="eircode" class="control-label">Eircode <span
													style="color: red">*</span> <span
													style="font-size: smaller">(choose Eircode in drop down)</span>
												</label> <input id="eircode" type="text"
													class="form-control" value="{{old('eircode')}}"
													name="eircode" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<h4>Package Details</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pick_address" class="control-label">Pickup
													address<span style="color: red">*</span>
												</label> <select id="pick_address" name="pickup_address"
													data-style="select-with-transition"
													class="form-control form-control-select selectpicker"
													required>
													<option value="">Select pickup address</option>
													@foreach($pickup_addresses as $address)
													<option value="{{$address['address']}}"
														@if(count($pickup_addresses)==1) selected @endif>{{$address['address']}}</option>
													@endforeach {{--
													<option value="Other">Other</option>--}}
												</select> <input type="hidden" name="pickup_lat"
													id="pickup_lat"> <input type="hidden" name="pickup_lon"
													id="pickup_lon"> <input id="pickup_address_alt" type="text"
													class="form-control" value="{{old('pickup_address_alt')}}"
													name="pickup_address_alt" placeholder="Enter address"
													style="display: none; margin-top: 10px;">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="fulfilment_date" class="control-label">Time
													order is ready for collection</label> <input
													id="fulfilment" type="text" name="fulfilment_date"
													class="form-control" value="{{old('fulfilment_date')}}"
													required>
												<!-- 												 <input -->
												<!-- 													id="fulfilment" type="number" name="fulfilment" -->
												<!-- 													class="form-control" value="{{old('fulfilment')}}" required> -->
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="weight" class="control-label">Package weight<span
													style="color: red">*</span></label> <select id="weight"
													name="weight" data-style="select-with-transition"
													class="form-control form-control-select selectpicker"
													required>
													<option value="">Select package weight</option>
													<option value="Very Light">Very Light</option>
													<option value="Light">Light</option>
													<option value="Medium">Medium</option>
													<option value="Very Heavy">Very Heavy</option>
													<option value="Max(20kg)">Max 20kg</option>
												</select>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="dimensions" class="control-label">Package
													dimensions<span style="color: red">*</span>
												</label> <select id="dimensions" name="dimensions"
													data-style="select-with-transition"
													class="form-control form-control-select selectpicker"
													required>
													<option value="">Select package size</option>
													<option value="Small Bag">Small Bag</option>
													<option value="Medium Bag">Medium Bag</option>
													<option value="Large Bag">Large Bag</option>
													<option value="Shoe Box">Shoe Box</option>
													<option value="Large Box">Large Box</option>
												</select>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="notes" class="control-label">Other details</label>
												<input id="notes" type="text" name="notes"
													class="form-control" value="{{old('notes')}}">
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label for="deliver_by" class="control-label">Deliver by</label>
												<select id="deliver_by" name="deliver_by"
													data-style="select-with-transition"
													class="form-control form-control-select selectpicker">
													<option value="car">Car</option>
													<option value="scooter">Scooter</option>
													<option value="bicycle">Bicycle</option>
												</select>
											</div>
										</div>

										<div class="col-sm-12">
											<div class="form-group">
												<label for="deliver_by" class="control-label">Fragile
													package?<span style="color: red">*</span> <br> <span
													style="font-size: smaller; font-weight: 500">Package will
														be delivered with extra care</span>
												</label>
												<p id="fragileErrorMessage"
													style="color: red; font-weight: 500; display: none; margin-bottom: 0">Please
													select one of these options</p>
												<div class="radio-container row">
													<div
														class="form-check form-check-radio form-check-inline d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="fragile" id="inlineRadio1" value="1"
															class="form-check-input"> Yes <span class="circle"> <span
																class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="form-check form-check-radio form-check-inline d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="fragile" id="inlineRadio1" value="0"
															class="form-check-input"> No <span class="circle"> <span
																class="check"></span>
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
						<div class="row justify-content-center">
							<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
								<button type="submit"
									class="btnDoorder btn-doorder-primary  mb-1">Submit</button>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- warning modal -->
<div class="modal fade" id="warning-address-modal" tabindex="-1"
	role="dialog" aria-labelledby="warning-address--label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="col-md-12">

						<div class="text-center">
							<img
								src="{{asset('images/doorder-new-layout/warning-icon.png')}}"
								style="" alt="warning">
						</div>
						<div class="text-center mt-3">
							<label class="warning-label">Please enter Eircode to continue
								(select drop down suggestion)</label>

						</div>
					</div>
				</div>

				<div class="row justify-content-center mt-3">
					
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-primary mb-1"
							data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script src="{{asset('js/mdtimepicker.js')}}"></script>
<script>
	let autocomp_countries = JSON.parse('{!!$google_auto_comp_countries!!}');
        // var input = document.getElementById('customer_address');
        // var autocomplete = '';
        // var place = '';
        // function submitForm(e) {
        //     e.preventDefault();
        //     place = autocomplete.getPlace();
        //     console.log(place);
        //     if (!place.geometry) {
        //         // User entered the name of a Place that was not suggested and
        //         // pressed the Enter key, or the Place Details request failed.
        //         window.alert("No details available for input: '" + place.name + "'");
        //         return;
        //     } else {
        //         var place_lat = place.geometry.location.lat();
        //         var place_lon = place.geometry.location.lng();
        //         document.getElementById("lat").value = place_lat.toFixed(5);
        //         document.getElementById("lon").value = place_lon.toFixed(5);
        //
        //         // check distance if location is available
        //         a_latlng = place.geometry.location;
        //         if(b_latlng != null){
        //             var request = {
        //                 origin : a_latlng,
        //                 destination : b_latlng,
        //                 travelMode : 'DRIVING'
        //             };
        //         }
        //
        //     }
        // }
        function initMap() {
            let eircode_input = document.getElementById('eircode');
            let customer_address_input = document.getElementById('customer_address');
            //Mutation observer hack for chrome address autofill issue
            let observerHackAddress = new MutationObserver(function() {
                observerHackAddress.disconnect();
				eircode_input.setAttribute("autocomplete", "new-password");
            });
            observerHackAddress.observe(eircode_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete = new google.maps.places.Autocomplete(eircode_input);
            autocomplete.setComponentRestrictions({'country': autocomp_countries});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
					swal({
						icon: 'error',
						text: 'No details available for this address: "' + place.name + '"'
					});
                } else {
                	//check if place has eircode
					let eircode_value = place.address_components.find((x) => {
						if (x.types.includes("postal_code")) {
							return x;
						}
						return undefined;
					});
					let place_lat = place.geometry.location.lat();
					let place_lon = place.geometry.location.lng();
					document.getElementById("customer_lat").value = place_lat.toFixed(5);
					document.getElementById("customer_lon").value = place_lon.toFixed(5);
					// if (customer_address_input.value != '') {
						customer_address_input.value = place.formatted_address;
					// }
					if (eircode_value != undefined) {
						eircode_input.value = eircode_value.long_name;
					} else {
						/*document.getElementById("customer_lat").value = '';
						document.getElementById("customer_lon").value = '';*/
						eircode_input.value = '';
						// customer_address_input.value = '';
						swal({
							icon: 'info',
							text: 'This address doesn\'t include an Eircode, please add it manually to the field'
						});
					}
                }
            });

            let pickup_address_input = document.getElementById('pickup_address_alt');
            //Mutation observer hack for chrome address autofill issue
            let observerHackPickupAddress = new MutationObserver(function() {
                observerHackPickupAddress.disconnect();
                pickup_address_input.setAttribute("autocomplete", "new-password");
            });
            observerHackPickupAddress.observe(pickup_address_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete_pickup = new google.maps.places.Autocomplete(pickup_address_input);
            autocomplete_pickup.setComponentRestrictions({'country': autocomp_countries});
            autocomplete_pickup.addListener('place_changed', function () {
                let place = autocomplete_pickup.getPlace();
                console.log(place);
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                    let place_lat = place.geometry.location.lat();
                    let place_lon = place.geometry.location.lng();
                    document.getElementById("pickup_lat").value = place_lat.toFixed(5);
                    document.getElementById("pickup_lon").value = place_lon.toFixed(5);
                }
            });
        }

        $(document).ready(function(){
        	$("#fulfilment").datetimepicker({
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

			let pickup_address_field = $('#pick_address')
            pickup_address_field.on('change',function(){
                let picked_address = $(this).val();
                let pickup_lat_field = $('#pickup_lat');
                let pickup_lon_field = $('#pickup_lon');
                let pickup_address_alt = $('#pickup_address_alt');
                pickup_address_alt.removeAttr('required').hide();
                pickup_lat_field.val('');
                pickup_lon_field.val('');
               if(picked_address=='Other'){
                    pickup_address_alt.attr('required','required').show();
                } else {
                   let pickup_addresses = {!! json_encode($pickup_addresses) !!};
                   console.log('pickup_address', pickup_addresses);
                   for (let address of pickup_addresses) {
                       if (picked_address == address.address) {
                           address_coordinates = address.coordinates;
                           address_coordinates = address_coordinates.replaceAll("lon", '"lon"');
                           address_coordinates = address_coordinates.replaceAll("lat", '"lat"');
                           address_coordinates = JSON.parse(address_coordinates);

                           pickup_lat_field.val(address_coordinates.lat);
                           pickup_lon_field.val(address_coordinates.lon);
                           console.log('Yes')
                       }
                   }
               }
            });
			//check if a pickup address is already selected
			if(pickup_address_field.val()!=null && pickup_address_field.val()!=''){
				pickup_address_field.change();
			}

            let customer_phone_input = document.querySelector("#customer_phone");
            window.intlTelInput(customer_phone_input, {
                hiddenInput: 'customer_phone',
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
            
           $('#order-form').submit(function( event ) {
           	// event.preventDefault();
            	
                 var pickup_lat_field = $('#pickup_lat').val();
                 var pickup_lon_field = $('#pickup_lon').val();
                 var customer_address_lat = $("#customer_lat").val();
                 var customer_address_lon = $("#customer_lon").val();
                 
                 if(customer_address_lat!=null && customer_address_lat!='' &&
                            customer_address_lon!=null && customer_address_lon!='' && 
                            pickup_lat_field !=null && pickup_lat_field !='' &&
                            pickup_lon_field!=null && pickup_lon_field!=''){
                           
                           //	alert($("input[name=fragile]:checked").val());
                            if( $("input[name=fragile]:checked").val()==null ){
                            	$('#fragileErrorMessage').css("display","block")
                            	return false;
                            }else{
                            	$('#fragileErrorMessage').css("display","none");
                            	return true;
                            	//$('#order-form').submit();
                            }
                  } else{
                  
                    	$('#warning-address-modal').modal('show');
                    	return false;
                  }    
           });
          
        });
          function submitForm(event) {
            	 console.log("submit")
         	
                  return true; 
              }
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
