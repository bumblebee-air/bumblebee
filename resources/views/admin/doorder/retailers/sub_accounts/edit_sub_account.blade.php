@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/jquery.businessHours.css')}}">

<style>
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

textarea {
	height: auto;
}
</style>
<script
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=places"></script>
@endsection @section('title','DoOrder | Bussines Account: '. $account->name)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					{{csrf_field()}}

					<div class="card card-profile-page-title">
						<div class="card-header row">
							<div class="col-12 p-0">
								<h4 class="card-title my-md-4 mt-4 mb-1">
									Bussines Account <span class="titleNameSpan ml-2">
										@{{account.name}} </span>
								</h4>
							</div>
						</div>
					</div>
					<form id="order-form" method="POST"
						action="{{url('doorder/retailer/subaccount/edit')}}">
						{{csrf_field()}}
						<input type="hidden" name="retailer_id" value="{{$retailer_id}}">
						<input type="hidden" name="account_id" value="{{$account->id}}">
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
													placeholder="Company name" :value="account.name" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Company website</label> <input type="text"
													class="form-control" name="company_website"
													placeholder="Company website"
													:value="account.company_website" required>

											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Business type</label> <input type="text"
													class="form-control" name="business_type"
													placeholder="Business type" :value="account.business_type"
													required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Number of business locations</label> <input
													type="text" class="form-control"
													name="nom_business_locations"
													:value="account.nom_business_locations"
													placeholder="Number of business locations" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label>Retailer invoice reference number</label> <input
													type="text" class="form-control"
													name="invoice_reference_number"
													:value="account.invoice_reference_number"
													placeholder="Retailer invoice reference number" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<div class="row">
										<div class="col-7 col-lg-7 col-md-6 ">
											<h4>Locations Details</h4>
										</div>
										<div class="col-5 col-lg-5 col-md-6 ">
											<div class=" justify-content-right float-sm-right">
												<button type="button"
													class=" btn-doorder-filter btn-doorder-add-item mt-0"
													@click="addLocation()">Add location</button>

											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">

										<div class="col-md-12 my-2 profile-border-div mb-4"
											v-for="(location, index) in locations"
											>
											<div class="row mb-2">
												<div class="col-10 col-lg-7 col-md-6 ">
													<h5 class="locationLabel card-title">Location @{{ index + 1
														}}</h5>
												</div>
												<div class="col-2 col-lg-5 col-md-6">
													<div class=" justify-content-right float-sm-right">
														<span v-if="index!=0"> <img class="remove-icon"
															src="{{asset('images/doorder-new-layout/remove-icon.png')}}"
															@click="removeLocation(index)" />
														</span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Address</label>
														<textarea :id="'location' + (index +1)"
															class="form-control" rows="3"
															:name="'address' + (index + 1)" placeholder="Address"
															v-model="location.address"
															required></textarea>
														<input :id="'location_'+ (index+1) +'_coordinates'"
															:name="'address_coordinates_' + (index + 1)"
															v-model="location.coordinates"
															value=""
															type="hidden">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Eircode</label> <input type="text"
															class="form-control" :name="'eircode' + (index + 1)"
															:id="'eircode' + (index + 1)"
															v-model="location.eircode"
															value=""
															placeholder="Postcode/Eircode" required>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Country</label> <select
															class="form-control form-control-select selectpicker"
															data-style="select-with-transition"
															:id="'country' + (index + 1)"
															:name="'country' + (index + 1)"
															v-model="location.country" required>
															<option disabled>Select Country</option>
															<option value="Ireland" selected>Ireland</option>
														</select>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>County</label> <select
															class="form-control form-control-select selectpicker"
															data-style="select-with-transition"
															:id="'county' + (index + 1)"
															:name="'county' + (index + 1)"
															v-model="location.county" required>
															<option selected disabled>Select County</option>
															<option v-for="county in counties"
																:value="JSON.stringify(county)">@{{county.name}}</option>
														</select>
													</div>
												</div>

												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Working Days and Hours</label>
														<textarea class="form-control" rows="4"
															:id="'business_hours' + (index + 1)"
															:name="'business_hours' + (index + 1)"
															v-model="location.business_hours"
															placeholder="Working Days and Hours" data-toggle="modal"
															:data-target="'#exampleModal' + index" required></textarea>
														<input type="hidden"
															:id="'business_hours_json' + (index + 1)"
															:name="'business_hours_json' + (index + 1)"
															v-model="location.business_hours_json">

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
															<button type="button"
																class="close d-flex justify-content-center"
																data-dismiss="modal" aria-label="Close">

																<i class="fas fa-times"></i>
															</button>

														</div>
														<div class="modal-body">
															<div class="modal-dialog-header modalHeaderMessage mb-4">Select
																Working Days and Hours</div>

															<div class="row justify-content-center">
																<div class="row"
																	:id="'business_hours_container' + (index + 1)"></div>
															</div>

															<div class="row justify-content-center mt-4">
																<div class="col-lg-4 col-md-6 text-center">
																	<button type="button"
																		class="btnDoorder btn-doorder-primary mb-1"
																		@click="serializeBusinessHours(index + 1)"
																		data-dismiss="modal" aria-label="Close">Save changes</button>
																</div>
															</div>
														</div>

													</div>
												</div>
											</div>
											<!-- end working hours modal -->

										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header card-header-profile-border ">
								<div class="col-md-12 pl-3">
									<div class="row">
										<div class="col-12 col-lg-7 col-md-6 ">
											<h4>Contact Details</h4>
										</div>
										<div class="col-12 col-lg-5 col-md-6 ">
											<div class=" justify-content-right float-sm-right">
												<button type="button"
													class=" btn-doorder-filter btn-doorder-add-item mt-0"
													@click="addContact()">Add contact</button>

											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 my-2 profile-border-div mb-4"
											v-for="(contact, index) in contacts" :key="contact">

											<div class="row mb-2">
												<div class="col-12 col-lg-7 col-md-6 ">
													<h5 class="locationLabel card-title">Contact @{{ index + 1}}</h5>
													
												</div>
												<div class="col-12 col-lg-5 col-md-6">
													<div class=" justify-content-right float-sm-right">
														<span v-if="index!=0"> <img class="remove-icon"
															src="{{asset('images/doorder-new-layout/remove-icon.png')}}"
															@click="removeContact(index)" />
														</span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact Name</label> <input type="text"
															class="form-control" :id="'contact_name' + (index + 1)"
															:name="'contact_name' + (index + 1)"
															v-model="contact.contact_name"
															placeholder="Contact Name" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact number</label> <input type="text"
															class="form-control" :id="'contact_number' + (index + 1)"
															:name="'contact_number' + (index + 1)"
																	v-model="contact.contact_phone"
															placeholder="Contact Number" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact email</label> <input type="email"
															class="form-control" :id="'contact_email' + (index + 1)"
															:name="'contact_email' + (index + 1)"
															v-model="contact.contact_email"
															placeholder="Contact Email Address" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Location</label><select
															class="form-control form-control-select selectpicker"
															data-style="select-with-transition"
															:id="'contact_location' + (index + 1)"
															:name="'contact_location' + (index + 1)"
															v-model="contact.contact_location">
															<option selected disabled>Select location</option>
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
															name="shopify_store_domain" class="form-control"
															:value="account.shopify_store_domain"
															placeholder="Shop URL" >
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>App API key</label> <input type="text"
															name="shopify_app_api_key" class="form-control"
															:value="account.shopify_app_api_key"
															placeholder="App API key" >
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>App Password</label> <input type="text"
															name="shopify_app_password" class="form-control"
															:value="account.shopify_app_password"
															placeholder="App Password" >
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>App Secret</label> <input type="text"
															name="shopify_app_secret" class="form-control"
															:value="account.shopify_app_secret"
															placeholder="App Secret" >
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card"
							style="background-color: transparent; box-shadow: none;">
							<div class="card-body p-0">
								<div class="container w-100" style="max-width: 100%">

									<div class="row justify-content-center">
										<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">

											<button class="btnDoorder btn-doorder-primary  mb-1">Save</button>
										</div>


									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="{{asset('js/jquery.businessHours.min.js')}}"></script>

<script>
let business_hours_initial_array = [
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null},
            {"isActive":true,"timeFrom":null,"timeTill":null}
        ];
        
	let autocomp_countries = JSON.parse('{!!$google_auto_comp_countries!!}');
	//console.log(autocomp_countries)
	
        var app = new Vue({
            el: '#app',
           data() {
                return {
                     account: {!! $account !!},
                	 locations: {!!  isset($account->locations_details) ? $account->locations_details : '[{}]'  !!},
                	 contacts: {!!  isset($account->contacts_details) ? $account->contacts_details : '[{}]'  !!}, 
                     itn_inputs: [],  
                     counties: [],   
                  }
            },
            mounted(){
            
            	//loop locations                
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
                                app.locations[index-1].eircode = eircode_value.long_name;
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
					
//                     console.log(business_hours_initial_array)	
//                     console.log(Array.isArray(business_hours_initial_array))					
//                     console.log(this.locations[index-1].business_hours_json)	
//                     console.log(Array.isArray(this.locations[index-1].business_hours_json))
//                     console.log((this.locations[index-1].business_hours_json != 0) ? JSON.parse(this.locations[index-1].business_hours_json) : "")
//                     console.log((this.locations[index-1].business_hours_json != 0) ? Array.isArray(JSON.parse(this.locations[index-1].business_hours_json)) : Array.isArray(""))

					var operationTimeArr = (this.locations[index-1].business_hours_json != 0) ? JSON.parse(this.locations[index-1].business_hours_json) : "";
					 window['business_hours_container'+index] = $('#business_hours_container'+index).businessHours({
                    	operationTime: Array.isArray(operationTimeArr) ? operationTimeArr : business_hours_initial_array,
                    	dayTmpl:'<div class="dayContainer col-md-3 col-4 mt-1" style="">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                        '<div class="weekday text-center"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" class="mini-time form-control operationTimeFrom" name="startTime" value=""></div>' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" class="mini-time form-control operationTimeTill" name="endTime" value=""></div>' +
                        '</div></div>',
                    checkedColorClass: 'workingBusinssDay',
                    uncheckedColorClass: 'dayOff',
                })
// 					console.log(JSON.parse(this.locations[index-1].business_hours_json));
// 					console.log(business_hours_initial_array)
				}
            	
            	//end loop locations

                //Temporarily edited as DoOrder only want Dublin
                let iresh_counties_json = jQuery.getJSON('{{asset('iresh_counties.json')}}', data => {
                		
                	 for (let county of data) {
                        if(county.city.toLowerCase() == 'dublin') {
                            this.counties.push({name: county.city, coordinates: {lat: county.lat, lng: county.lng}});
                        }
                    }
                });
               
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
            	             	 
            },
            methods: {
				addLocation(){
					//this.locations.push({"address":"","coordinates":"","eircode":"","country":"","county":"","business_hours":"","business_hours_json":""});
					this.locations.push({});
					
					this.timer = setTimeout(() => {
                        this.addAutoCompleteInput();
            			$('.selectpicker').selectpicker();
                        this.addBusinessHoursContainer();
            			$(".selectpicker").selectpicker("refresh");
                    }, 1000)
				},
                removeLocation(index){
					//this.locations.splice(index, 1);
					
					Vue.delete(this.locations, index);
            		this.timer = setTimeout(() => {
                       $('.selectpicker').selectpicker();
                       $(".selectpicker").selectpicker("refresh");
                    }, 500)
                },
                addContact() {
                   for (let item of this.contacts) {
						let intl_tel_input_value = this.itn_inputs['contact_number' + (this.contacts.indexOf(item) + 1)]
						//console.log(item);
						intl_tel_input_value.destroy();
					}
                    this.contacts.push({});
                    this.timer = setTimeout(() => {
                        this.addIntelInput();
            			$('.selectpicker').selectpicker();
            			$(".selectpicker").selectpicker("refresh");
                    }, 500)
                    
                },
                removeContact(index){
					this.contacts.splice(index, 1);
					
            		this.timer = setTimeout(() => {
                       $('.selectpicker').selectpicker();
                       $(".selectpicker").selectpicker("refresh");
                    }, 500)
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
//                     let latest_key = this.contacts.length;
//                     let driver_phone_input = document.querySelector("#contact_number" + latest_key);
//                     this.itn_inputs["contact_number" + latest_key] = window.intlTelInput(driver_phone_input, {
//                         hiddenInput: "contact_number" + latest_key,
//                         initialCountry: 'IE',
//                         separateDialCode: true,
//                         preferredCountries: ['IE', 'GB'],
//                         utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
//                     });
                },
                addAutoCompleteInput() {
                    let latest_key = this.locations.length;
                    let retailer_address_input = document.getElementById('location'+latest_key);
                    let retailer_eircode_input = document.getElementById('eircode'+latest_key);
                    //Mutation observer hack for chrome address autofill issue
                    let observerHackAddress = new MutationObserver(function() {
                        observerHackAddress.disconnect();
                        retailer_eircode_input.setAttribute("autocomplete", "new-password");
                    });
                    observerHackAddress.observe(retailer_eircode_input, {
                        attributes: true,
                        attributeFilter: ['autocomplete']
                    });
                    let autocomplete_driver_address = new google.maps.places.Autocomplete(retailer_eircode_input);
                    autocomplete_driver_address.setComponentRestrictions({'country': ['ie']});
                    autocomplete_driver_address.addListener('place_changed', function () {
                    	//console.log("change")
                        let place = autocomplete_driver_address.getPlace();
                        if (!place.geometry) {
                            // User entered the name of a Place that was not suggested and
                            // pressed the Enter key, or the Place Details request failed.
                            window.alert("No details available for input: '" + place.name + "'");
                        } else {
                            //check if place has eircode
                            let eircode_value = place.address_components.find((x) => {
                                if (x.types.includes("postal_code")) {
                                    return x;
                                }
                                return undefined;
                            });
                            if (eircode_value != undefined) {
                            //console.log("ssssss "+latest_key)
                                let place_lat = place.geometry.location.lat();
                                let place_lon = place.geometry.location.lng();
                                document.getElementById("location_"+latest_key+"_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
                                retailer_eircode_input.value = eircode_value.long_name;
                                app.locations[latest_key-1].eircode = eircode_value.long_name;
                                // if (retailer_address_input.value != '') {
                                retailer_address_input.value = place.formatted_address;
                                app.locations[latest_key-1].address = place.formatted_address;
                                app.locations[latest_key-1].coordinates = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
                                // }
                            } else {
                                document.getElementById("location_"+latest_key+"_coordinates").value = '';
                                retailer_eircode_input.value = '';
                                retailer_address_input.value = '';
                                swal({
                                    icon: 'info',
                                    text: 'Please enter a valid Eircode'
                                });
                            }
                        }
                    });
                },
                 serializeBusinessHours(index) {
                    let businessHoursoutput = window['business_hours_container' + index].serialize()
                    let businessHoursText = '';
                    let businessHours = [];//{};
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
                        //businessHours[key] = item;
                        businessHours.push(item);
                    }
                    $('#business_hours' + index).val(businessHoursText)
                    $('#business_hours_json' + index).val(JSON.stringify(businessHours))
                    
                    
                    app.locations[index-1].business_hours = businessHoursText;
                    app.locations[index-1].business_hours_json = JSON.stringify(businessHours);
                    
                },
				addBusinessHoursContainer() {
					let latest_key = this.locations.length;
					window['business_hours_container' + latest_key] = $('#business_hours_container' + latest_key).businessHours({
						operationTime: business_hours_initial_array,
						dayTmpl:'<div class="dayContainer col-md-3 col-4 mt-1" style="">' +
								'<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
								'<div class="weekday text-center"></div>' +
								'<div class="operationDayTimeContainer">' +
								'<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
								'<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
								'</div></div>',
						checkedColorClass: 'workingBusinssDay',
						uncheckedColorClass: 'dayOff',
					})
				},

            }    
        });
        Vue.config.devtools = true
    </script>
@endsection
