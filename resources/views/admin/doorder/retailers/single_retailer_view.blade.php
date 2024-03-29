@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

<link rel="stylesheet" href="{{asset('css/jquery.businessHours.css')}}">
<style>
.workingBusinssDay {
	background-color: #e8ca49;
	border-radius: 2px !important;
	border: none !important;
	max-height: 21px !important;
}

.dayOff {
	background-color: #eeeeee;
	border-radius: 2px;
	border: none !important;
	max-height: 21px !important;
}

textarea {
	height: auto !important;
}

.dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item:hover,
	.dropdown-menu a:active, .dropdown-menu a:focus, .dropdown-menu a:hover
	{
	box-shadow: none !important;
}

.business_day_switch {
	width: 75px;
	height: 31px;
	margin: 45px 18px 10px 85px;
	border-radius: 2px;
	background-color: #eeeeee;
}

.business_day_switch_checked {
	background-color: #e8ca49;
}

.workingBusinssDay {
	background-color: #e8ca49;
	border-radius: 2px !important;
	border: none !important;
	max-height: 21px !important;
}

.dayOff {
	background-color: #eeeeee;
	border-radius: 2px;
	border: none !important;
	max-height: 21px !important;
}

.my-check-box {
	display: inline-block;
	width: 20px;
	height: 20px;
	color: #c3c7d2;
	padding-right: 20px;
	cursor: pointer;
}

.my-check-box-checked {
	color: #f7dc69;
}

.my-check-box i {
	font-size: 18px
}
</style>
@endsection @section('title','DoOrder | Retailer ' . $retailer->name)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)
					<form id="order-form" method="POST"
						action="{{route('post_doorder_retailers_single_retailer', ['doorder', $retailer->id])}}"
						v-on:submit="checkPaymentCard">
						@endif {{csrf_field()}} <input type="hidden" name="retailer_id"
							value="{{$retailer->id}}">
						
						<div class="card card-profile-page-title">
    						<div class="card-header row">
    							<div class="col-12 col-md-8 p-0">
    								<h4 class="card-title my-md-4 mt-4 mb-1">Retailer Profile: {{$retailer->name}}</h4>
    							</div>
    							@if($readOnly==1)
								<div class="col-12 col-md-4 ">
									<div class="row justify-content-end float-sm-right">
										<a class="btn-doorder-link"
											href="{{url('doorder/retailers/')}}/{{$retailer->id}}">
											<p>Edit retailer</p>
										</a>
									</div>
								</div>
								@endif
    						</div>
						</div>
						
						<div class="card">
    						<div class="card-header card-header-profile-border">
    							<div class="col-md-12 pl-3">
    								<h4>Company Details</h4>
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
												<label>Company name</label> <input type="text"
													class="form-control" name="company_name"
													value="{{$retailer->name}}" placeholder="Company name"
													required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Company website</label> <input type="text"
													class="form-control" name="company_website"
													value="{{$retailer->company_website}}"
													placeholder="Company website" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Business type</label> <input type="text"
													class="form-control" name="business_type"
													value="{{$retailer->business_type}}"
													placeholder="Business type" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Number of business locations</label> <input
													type="text" class="form-control"
													name="number_business_locations"
													value="{{$retailer->nom_business_locations}}"
													placeholder="Number of business locations" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Retailer invoice reference number</label> <input
													type="text" class="form-control"
													name="invoice_reference_number"
													value="{{$retailer->invoice_reference_number}}"
													placeholder="Retailer invoice reference number" required>
											</div>
										</div><div class="col-sm-6 ">
													<div>
														<div class="form-group bmd-form-group p-0"
															style="display: inline-block;">
															<label>QR label scan required</label>
															<div class="toggleButtonGeneralSettings ml-2"
															>
															<input type="checkbox" data-toggle="toggle"
																data-size="small" data-width="80" data-height="30"
																id="qr_scan_required" value="1" name="qr_scan_required"
																{{$retailer->qr_scan_required == 1 ? 'checked':''}} >

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
    								<h4>Locations Details</h4>
    							</div>
    						</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 my-2 profile-border-div mb-4" v-for="(location, index) in locations">
											<h5 class="locationLabel card-title">Location @{{ index + 1 }}</h5> 
											<span v-if="index==0"> <i
												class="fas fa-plus-circle addCircle" @click="addLocation()"></i>
											</span> <span v-else> <i
												class="fas fa-minus-circle removeCircle"
												@click="removeLocation(index)"></i>
											</span>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Address</label>
														<textarea :id="'location' + (index +1)"
															class="form-control" rows="5"
															:name="'address' + (index + 1)" placeholder="Address"
															v-model="location.address" required></textarea>
														<input :id="'location_'+ (index+1) +'_coordinates'"
															:name="'address_coordinates_' + (index + 1)"
															v-model="location.coordinates" type="hidden">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Eircode</label> <input type="text"
															class="form-control" :name="'eircode' + (index + 1)"
															:id="'eircode' + (index + 1)" value=""
															v-model="location.eircode" placeholder="Postcode/Eircode"
															required>
													</div>
													<div class="form-group bmd-form-group">
														<label>Country</label> <input type="text"
															class="form-control" :id="'country' + (index + 1)"
															:name="'country' + (index + 1)" value="Ireland"
															placeholder="Country" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Working days and hours</label> <input type="text"
															class="form-control" :id="'business_hours' + (index + 1)"
															:name="'business_hours' + (index + 1)" value=""
															v-model="location.business_hours"
															placeholder="Working Days and Hours" data-toggle="modal"
															:data-target="'#exampleModal' + index" required> <input
															type="hidden" :id="'business_hours_json' + (index + 1)"
															:name="'business_hours_json' + (index + 1)"
															v-model="location.business_hours_json">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>County</label> <input type="text"
															class="form-control" :id="'county' + (index + 1)"
															:name="'county' + (index + 1)" value="Dublin"
															placeholder="County" required>
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

						<div class="card">
        					<div class="card-header card-header-profile-border ">
        						<div class="col-md-12 pl-3">
        							<h4>Contact Details</h4>
        						</div>
        					</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 my-2 profile-border-div mb-4" v-for="(contact, index) in contacts">
											<h5 class="locationLabel card-title" v-if="contacts.length > 1">Contact Details @{{ index +
											1 }}</h5> <span v-if="index==0"> <i
												class="fas fa-plus-circle addCircle" @click="addContact()"></i>
											</span> <span v-else> <i
												class="fas fa-minus-circle removeCircle"
												@click="removeContact(index)"></i>
											</span>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact name</label> <input type="text"
															class="form-control" :id="'contact_name' + (index + 1)"
															:name="'contact_name' + (index + 1)" value=""
															v-model="contact.contact_name" placeholder="Contact name"
															required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact number</label> <input type="text"
															class="form-control" :id="'contact_number' + (index + 1)"
															:name="'contact_number' + (index + 1)" value=""
															v-model="contact.contact_phone"
															placeholder="Contact number" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact email</label> <input type="email"
															class="form-control" :id="'contact_email' + (index + 1)"
															:name="'contact_email' + (index + 1)" value=""
															v-model="contact.contact_email"
															placeholder="Contact email address" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Location</label>
														<!-- <input type="text"
															class="form-control" value=""
															v-model="contact.contact_location"
															:name="'contact_location' + (index + 1)"
															:id="'contact_location' + (index + 1)"
															placeholder="Location" required> -->
														<select class="form-control form-control-select selectpicker"
															data-style="select-with-transition"
															:id="'contact_location' + (index + 1)"
															:name="'contact_location' + (index + 1)"
															v-model="contact.contact_location">
															<option selected disabled>Location</option>
															<option v-for="(location, index) of locations"
																:value="'location'+ (index +1)">Location @{{ index +1 }}</option>
															<option value="all" v-if="locations.length > 1">All</option>
														</select>
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
								<h4>Shopify Details</h4>
							</div>
						</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Shop URL</label> <input type="text"
															class="form-control" name="shopify_store_domain"
															value="{{$retailer->shopify_store_domain}}"
															placeholder="Shop URL">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>App API key</label> <input type="text"
															class="form-control" name="shopify_app_api_key"
															value="{{$retailer->shopify_app_api_key}}"
															placeholder="App API key">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>App password</label> <input type="text"
															class="form-control" name="shopify_app_password"
															value="{{$retailer->shopify_app_password}}"
															placeholder="App password">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>App secret</label> <input type="text"
															class="form-control" name="shopify_app_secret"
															value="{{$retailer->shopify_app_secret}}"
															placeholder="App secret">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						@if($readOnly==0)
						<div class="card">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 d-flex form-head pl-3">
											<span> 5 </span>
											<h5 class="singleViewSubTitleH5">Payment Details</h5>
										</div>

										<div class="col-md-12">
											<div class="row">
												<div class="col-12">
													<div class="form-group pl-2">
														<div class="d-flex form-group bmd-form-group"
															@click="requireCardDetails()">
															<label><div id="check"
																	:class="require_card ? 'my-check-box my-check-box-checked' : 'my-check-box'">
																	<i class="fas fa-check-square"></i>
																</div> Add card details?</label>
														</div>
													</div>
												</div>
												<div class="col-md-12" v-if="require_card===true">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group bmd-form-group">
																<label>Card number</label><input type="text"
																	class="form-control" id="card_number"
																	value="{{old('payment_card_number')}}"
																	placeholder="Card number" required>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group bmd-form-group">
																<label>CVC number</label> <input type="text"
																	class="form-control" id="cvc"
																	value="{{old('payment_cvc_number')}}"
																	placeholder="CVC Number" required>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group bmd-form-group">
																<label>Expiry date (MM/YY)</label><input type="text"
																	class="form-control" id="payment_exp_date"
																	value="{{old('payment_exp_date')}}"
																	placeholder="Expiry date (MM/YY)" required>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group bmd-form-group">
																<img src="{{asset('images/stripelogo.png')}}"
																	style="max-width: 100%; max-height: 70px"
																	alt="Pay With Stripe">
															</div>
														</div>
													</div>
												</div>
												<input type='hidden' name='stripeToken'
													v-model="stripeToken" />

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>@endif 
						
						@if($readOnly==0)
						<div class="row">
							<div class="col-sm-6 text-center">

								<button class="btn bt-submit">Save</button>
							</div>
							<div class="col-sm-6 text-center">
								<button class="btn bt-submit btn-danger" type="button"
									data-toggle="modal" data-target="#delete-retailer-modal">Delete</button>
							</div>
						</div>
						<input type='hidden' id="locations_details"
							name='locations_details' /> <input type='hidden'
							id='contacts_details' name='contacts_details' />
					</form>
					@endif
					<!-- Delete modal -->
					<div class="modal fade" id="delete-retailer-modal" tabindex="-1"
						role="dialog" aria-labelledby="delete-retailer-label"
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
										<form method="POST" id="delete-retailer"
											action="{{url('doorder/retailer/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="retailerId" name="retailerId"
												value="{{$retailer->id}}" />
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<button type="button"
											class="btn btn-primary doorder-btn-lg doorder-btn"
											onclick="$('form#delete-retailer').submit()">Yes</button>
									</div>
									<div class="col-sm-6">
										<button type="button"
											class="btn btn-danger doorder-btn-lg doorder-btn"
											data-dismiss="modal">Cancel</button>
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
<script src="{{asset('js/jquery.businessHours.min.js')}}"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<link
	href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
	rel="stylesheet">
<script
	src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=places"></script>

<script>
	let autocomp_countries = JSON.parse('{!!$google_auto_comp_countries!!}');
	$(document).ready(function() {
		var readonly = {!! $readOnly !!};
		if(readonly==1){
			$("input").prop('disabled', true);
			$("textarea").prop('disabled', true);
			$("select").prop('disabled', true);
			$(".inputSearchNavbar").prop('disabled', false);
			$('.addCircle,.removeCircle').css("display","none")
		}
	});

        let business_hours_initial_array = [
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null}
        ];
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    locations: {!! isset($retailer->locations_details) ? $retailer->locations_details : '[]' !!},
                    contacts: {!!  isset($retailer->contacts_details) ? $retailer->contacts_details : '[]'  !!},
                   	itn_inputs: [],
					counties: [],
                    business_hours: {},
                    counties: [],
                    stripeToken: '',
                    require_card: false,
                    readOnly : {!! $readOnly !!},
                    disabled:''
				}
            },
			mounted() {
				for (let location of this.locations) {
					let index = this.locations.indexOf(location) + 1;
					//Google MAp autocomplete
					let retailer_address_input = document.getElementById('location'+index);
					let retailer_eircode_input = document.getElementById('eircode'+index);
					//Mutation observer hack for chrome address autofill issue
					let observerHackDriverAddress = new MutationObserver(function() {
						observerHackDriverAddress.disconnect();
						retailer_eircode_input.setAttribute("autocomplete", "new-password");
					});
					observerHackDriverAddress.observe(retailer_eircode_input, {
						attributes: true,
						attributeFilter: ['autocomplete']
					});
					let autocomplete_retailer_address = new google.maps.places.Autocomplete(retailer_eircode_input);
					autocomplete_retailer_address.setComponentRestrictions({'country': autocomp_countries});
					autocomplete_retailer_address.addListener('place_changed', function () {
						let place = autocomplete_retailer_address.getPlace();
						if (!place.geometry) {
							// User entered the name of a Place that was not suggested and
							// pressed the Enter key, or the Place Details request failed.
							window.alert("No details available for this address: '" + place.name + "'");
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
							// document.getElementById("location_"+index+"_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
							app.locations[index-1].coordinates = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
							app.locations[index-1].address = place.formatted_address;
							// if (retailer_address_input.value != '') {
							// retailer_address_input.value = place.formatted_address;
							// }
							if (eircode_value != undefined) {
								retailer_eircode_input.value = eircode_value.long_name;
							} else {
								//document.getElementById("location_"+index+"_coordinates").value = '';
								retailer_eircode_input.value = '';
								//retailer_address_input.value = '';
								swal({
									icon: 'info',
									text: 'This address doesn\'t include an Eircode, please add it manually to the field'
								});
							}
						}
					});
					
					

					 window['business_hours_container'+index] = $('#business_hours_container'+index).businessHours({
                    	operationTime: this.locations[this.locations.indexOf(location)].business_hours_json,
                    	dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                        '<div class="weekday"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" class="mini-time form-control operationTimeFrom" name="startTime" value=""></div>' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" class="mini-time form-control operationTimeTill" name="endTime" value=""></div>' +
                        '</div></div>',
                    checkedColorClass: 'workingBusinssDay',
                    uncheckedColorClass: 'dayOff',
                })
					
				}
				
				for (let contact of this.contacts){
					let index = this.contacts.indexOf(contact) + 1;
					let driver_phone_input = document.querySelector("#contact_number" + index);
					//console.log("#contact_number" + index);
					this.itn_inputs["contact_number" + index] = window.intlTelInput(driver_phone_input, {
						hiddenInput: "contact_number" + index,
						initialCountry: 'IE',
						separateDialCode: true,
						preferredCountries: ['IE', 'GB'],
						utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
					});
				}
				
				{{--let iresh_counties_json = jQuery.getJSON('{{asset('iresh_counties.json')}}', data => {--}}
				{{--	console.log(data)--}}
				{{--	for (let county of data) {--}}
				{{--		if(county.city.toLowerCase() == 'dublin') {--}}
				{{--			this.counties.push({name: county.city, coordinates: {lat: county.lat, lng: county.lng}});--}}
				{{--		}--}}
				{{--	}--}}
				{{--});--}}
				
				
			},
			methods: {
				addLocation(){
					this.locations.push({});
					this.timer = setTimeout(() => {
                        this.addAutoCompleteInput();
                        this.addBusinessHoursContainer();
                    }, 500)
				},
                removeLocation(index){
					this.locations.splice(index, 1);
                },
                addContact() {
               		// console.log(this.itn_inputs)
					for (let item of this.contacts) {
						let intl_tel_input_value = this.itn_inputs['contact_number' + (this.contacts.indexOf(item) + 1)]
						//console.log(item);
						intl_tel_input_value.destroy();
					}
                    this.contacts.push({});
                    this.timer = setTimeout(() => {
                        this.addIntelInput();
                    }, 200)
                },
                removeContact(index){
					this.contacts.splice(index, 1);
                },
				submitForm(){
					//e.preventDefault();
					let location_details = [];
					let contacts_details = [];
					//Make Location Details Input
					for (let item of this.locations) {
						//console.log($('#business_hours' + (this.locations.indexOf(item) + 1)).val());
						//console.log($('#business_hours_json' + (this.locations.indexOf(item) + 1)).val());
						//console.log("sssss")
						if ($('#location_' + (this.locations.indexOf(item) + 1) + '_coordinates').val() == null || $('#location_' + (this.locations.indexOf(item) + 1) + '_coordinates').val() == '' || $('#location_' + (this.locations.indexOf(item) + 1) + '_coordinates').val() == undefined) {
							swal({
								// title: 'Validation errors',
								text: 'Location address #'+ (this.locations.indexOf(item) + 1) +' coordinates are not available, please make sure to select an address from the Google suggestions',
								icon: 'error',
							});
							return false;
						}
						location_details.push({
							address: $('#location' + (this.locations.indexOf(item) + 1)).val(),
							coordinates: $('#location_' + (this.locations.indexOf(item) + 1) + '_coordinates').val(),
							eircode: $('#eircode' + (this.locations.indexOf(item) + 1)).val(),
							country: this.locations[this.locations.indexOf(item)].country,
							business_hours: $('#business_hours' + (this.locations.indexOf(item) + 1)).val(),
							//this.locations[this.locations.indexOf(item)].business_hours,
							business_hours_json:  $('#business_hours_json' + (this.locations.indexOf(item) + 1)).val(),
							//this.locations[this.locations.indexOf(item)].business_hours_json,
							county: this.locations[this.locations.indexOf(item)].county
						});
						console.log(this.locations.indexOf(item) + 1);
					}
					for (let item of this.contacts) {
						let intl_tel_input_value = this.itn_inputs['contact_number' + (this.contacts.indexOf(item) + 1)]
						contacts_details.push({
							contact_name: $('#contact_name' + (this.contacts.indexOf(item) + 1)).val(),
							contact_phone: intl_tel_input_value.getNumber(),
							contact_email: $('#contact_email' + (this.contacts.indexOf(item) + 1)).val(),
							contact_location: $('#contact_location' + (this.contacts.indexOf(item) + 1)).val()
						});
					}
					$('#locations_details').val(JSON.stringify(location_details));
					$('#contacts_details').val(JSON.stringify(contacts_details));
					var $form = $("#order-form");
					setTimeout(() => {
						$form.get(0).submit();
					}, 300);
				},
				
                addAutoCompleteInput() {
                    let latest_key = this.locations.length;
                    let retailer_address_input = document.getElementById('location'+latest_key);
                    let retailer_eircode_input = document.getElementById('eircode'+latest_key);
                    //Mutation observer hack for chrome address autofill issue
                    let observerHackAddress = new MutationObserver(function() {
                        observerHackAddress.disconnect();
                        retailer_address_input.setAttribute("autocomplete", "new-password");
                    });
                    observerHackAddress.observe(retailer_eircode_input, {
                        attributes: true,
                        attributeFilter: ['autocomplete']
                    });
                    let autocomplete_retailer_address = new google.maps.places.Autocomplete(retailer_eircode_input);
                    autocomplete_retailer_address.setComponentRestrictions({'country': autocomp_countries});
                    autocomplete_retailer_address.addListener('place_changed', function () {
                        let place = autocomplete_retailer_address.getPlace();
                        if (!place.geometry) {
                            // User entered the name of a Place that was not suggested and
                            // pressed the Enter key, or the Place Details request failed.
                            window.alert("No details available for this address: '" + place.name + "'");
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
							document.getElementById("location_"+latest_key+"_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
							// if (retailer_address_input.value != '') {
							retailer_address_input.value = place.formatted_address;
							// }
							if (eircode_value != undefined) {
								retailer_eircode_input.value = eircode_value.long_name;
							} else {
								//document.getElementById("location_"+latest_key+"_coordinates").value = '';
								retailer_eircode_input.value = '';
								//retailer_address_input.value = '';
								swal({
									icon: 'info',
									text: 'This address doesn\'t include an Eircode, please add it manually to the field'
								});
							}
                        }
                    });
                },
				addIntelInput() {
					
				
					for (let contact of this.contacts){
    					let index = this.contacts.indexOf(contact) + 1;
    					let driver_phone_input = document.querySelector("#contact_number" + index);
    					//console.log("#contact_number" + index);
    					this.itn_inputs["contact_number" + index] = window.intlTelInput(driver_phone_input, {
    						hiddenInput: "contact_number" + index,
    						initialCountry: 'IE',
    						separateDialCode: true,
    						preferredCountries: ['IE', 'GB'],
    						utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
    					});
					}
// 					let latest_key = this.contacts.length;
// 					let driver_phone_input = document.querySelector("#contact_number" + latest_key);
// 					this.itn_inputs["contact_number" + latest_key] = window.intlTelInput(driver_phone_input, {
// 						hiddenInput: "contact_number" + latest_key,
// 						initialCountry: 'IE',
// 						separateDialCode: true,
// 						preferredCountries: ['IE', 'GB'],
// 						utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
// 					});
				},
				serializeBusinessHours(index) {
					let businessHoursoutput = window['business_hours_container' + index].serialize()
					let businessHoursText = '';
					let businessHours = {};
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
						businessHours[key] = item;
					}
					$('#business_hours' + index).val(businessHoursText)
					$('#business_hours_json' + index).val(JSON.stringify(businessHours))
				},
				addBusinessHoursContainer() {
					let latest_key = this.locations.length;
					window['business_hours_container' + latest_key] = $('#business_hours_container' + latest_key).businessHours({
						operationTime: business_hours_initial_array,
						dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
								'<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
								'<div class="weekday"></div>' +
								'<div class="operationDayTimeContainer">' +
								'<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
								'<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
								'</div></div>',
						checkedColorClass: 'workingBusinssDay',
						uncheckedColorClass: 'dayOff',
					})
				},
				
                requireCardDetails(){
                    this.require_card = (this.require_card === false)? true : false;
                },
                
                checkPaymentCard(e) {
                    e.preventDefault();
                    if(this.require_card===true) {
                        let exp_date = $('#payment_exp_date').val();
                        let exp_month = exp_date.split('/')[0];
                        let exp_year = exp_date.split('/')[1];
                        Stripe.setPublishableKey('{{env('STRIPE_PUBLIC_KEY')}}');
                        Stripe.createToken({
                            number: $('#card_number').val(),
                            cvc: $('#cvc').val(),
                            exp_month: exp_month,
                            exp_year: exp_year
                        }, this.stripeResponseHandler);
                        return false;
                    }else{
                       this.submitForm();
                       //this.validateEmailAndPhone();
                    }
                },
                stripeResponseHandler(status, response) {
                    if (response.error) {
                        alert(response.error.message);
                    } else {
                        // token contains id, last4, and card type
                        this.stripeToken = response['id'];
                        this.submitForm();
                        //this.validateEmailAndPhone();
                    }
                },
			}
        });
        Vue.config.devtools = true
        
    </script>
@endsection
