@extends('templates.dashboard') @section('title', 'GardenHelp | Add
Property') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
@media ( max-width : 767px) {
	.container-fluid {
		padding-left: 0px !important;
		padding-right: 0px !important;
	}
	.col-12 {
		padding-left: 5px !important;
		padding-right: 5px !important;
	}
	.form-group label {
		margin-left: 0 !important;
	}
	.btn-register {
		float: none !important;
	}
}

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}

.iti {
	width: 100%;
}

.requestSubTitle {
	/*  	margin-top: 25px !important;  */
	margin-bottom: 0 !important;
}

span.form-control {
	font-family: Roboto;
	font-size: 17px !important;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.32px;
	color: #1e2432 !important;
	padding-left: 10px;
	padding-right: 10px;
	border-radius: 6px;
	background-image: none !important;
	min-height: 35px;
	height: auto;
}

.modal .modal-dialog {
	margin-top: 50px;
}

.form-control.StripeElement {
	padding: 10px 14px;
	background-image: none !important;
}
/* .form-control, .form-control:invalid, .is-focused .form-control { */
/* 	box-shadow: none !important; */
/* } */
.select2-container {
	width: calc(100% - 65px) !important;
}

.input-group-text {
	color: #aaa;
	padding-left: 0;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
}

.card .card-body .form-group {
	margin-top: 2px;
}
</style>
<script src="https://js.stripe.com/v3/"></script>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid" id="app">
			<form action="{{route('gardenhelp_saveProperties', 'garden-help')}}"
				method="POST" enctype="multipart/form-data" autocomplete="off"
				id="add-new-job" @submit="beforeSubmitForm">
				{{csrf_field()}} <input type="hidden" name="customer_id"
					value="{{$current_user->id}}" />
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose">
								<div class="card-icon">
									<i class="fas fa-plus-circle"></i>
								</div>
								<h4 class="card-title ">Add Property</h4>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-7 col-sm-6 col-12">
											<div class="row">
												<!-- 												<div class="col-md-12"> -->
												<!-- 													<h5 class="requestSubTitle">Location Details</h5> -->
												<!-- 												</div> -->
												<div class="col-12">
													<div class="form-group ">
														<label for="work_location" class="">Location</label>
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text"> <img
																	src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
																	alt="GardenHelp">
																</span>
															</div>
															<select id="work_location" name="work_location"
																class="form-control js-example-basic-single ">
																<option disabled selected value="">Select location</option>
																<option value="Dublin">Dublin</option>
																<option value="Carlow">Carlow</option>
																<option value="Kilkenny">Kilkenny</option>
																<option value="Kildare">Kildare</option>
															</select>
														</div>
													</div>
												</div>

											</div>
											<div>
												<div class="row ">
													<!-- 													<div class="col-md-12"> -->
													<!-- 														<h5 class="requestSubTitle">Property Information</h5> -->
													<!-- 													</div> -->

												</div>

												<div class="row">
													<div class="col-md-12">
														<!-- 														<div class="form-group "> -->
														<!-- 															<label for="type_of_work" class="">Property type <select -->
														<!-- 																id="type_of_work" name="type_of_work" -->
														<!-- 																class="form-control js-example-basic-single"> -->
														<!-- 																	<option disabled selected value="">Select property type</option> -->
														<!-- 																	<option value="Residential">Residential</option> -->
														<!-- 																	<option value="Commercial">Commercial</option> -->
														<!-- 															</select></label> -->
														<!-- 														</div> -->

														<div class="form-group bmd-form-group">
															<label>Property type</label>
															<div class="row">
																<div class="col">

																	<div class="form-check">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			name="type_of_work" value="Residential">Residential <span
																			class="form-check-sign"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
																<div class="col">

																	<div class="form-check">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			name="type_of_work" value="Commercial">Commercial <span
																			class="form-check-sign"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
															</div>

														</div>
													</div>

													<div class="col-md-12">
														<div class="form-group ">
															<label class="" for="location">Address</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<input type="text"
																	class="form-control js-example-basic-single"
																	id="location" name="location"
																	value="{{old('location')}}" required> <input
																	type="hidden" id="location_coordinates"
																	name="location_coordinates">
															</div>
														</div>
													</div>
													<div class="col-md-12 ">
														<div
															class="form-group form-file-upload form-file-multiple ">
															<label class="bmd-label-static"
																for="photographs_of_property">Property images </label> <br>
															<input id="property_photo" name="property_photo[]"
																type="file" class="inputFileHidden" multiple="multiple"
																@change="onChangeFile($event, 'property_photo_input')">
															<div class="input-group"
																@click="addFile('property_photo')">
																<input type="text" id="property_photo_input"
																	class="form-control inputFileVisible"
																	placeholder="Upload photos" required> <span
																	class="input-group-btn">
																	<button type="button"
																		class="btn btn-fab btn-round btn-success">
																		<i class="fas fa-cloud-upload-alt"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>


													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label>Property size</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/property-size-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<input type="text" class="form-control"
																	id="property_size" name="property_size" required
																	v-model="property_size">
															</div>
														</div>
													</div>


													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="type_of_experience">Site details</label>
															<div class="d-flex justify-content-between"
																@click="openModal('site_details')">
																<textarea name="site_details" rows="2"
																	class="form-control" id="site_details"
																	v-model="site_details_input" required>{{old('site_details')}}</textarea>
															</div>
														</div>
													</div>

													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="vat-number">Is there a parking access on
																site?</label>
															<div class="row">
																<div class="col">
																	<div class="form-check form-check-radio">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			id="exampleRadios2" name="is_parking_access"
																			v-model="is_parking_site" value="1"
																			{{old('is_parking_site') ===
																			'1' ? 'checked' : ''}} required> Yes <span
																			class="circle"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
																<div class="col">
																	<div class="form-check form-check-radio">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			id="exampleRadios1" name="is_parking_access"
																			v-model="is_parking_site" value="0"
																			{{old('is_parking_site') ===
																			'0' ? 'checked' : ''}} required> No <span
																			class="circle"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="">Notes</label>
															<div class="d-flex justify-content-between">
																<textarea name="notes" rows="5" class="form-control"
																	id="notes">{{old('notes')}}</textarea>
															</div>
														</div>
													</div>

												</div>

											</div>

										</div>
										<div class="col-md-5 col-sm-6 col-12">
											<div class="row mt-2 mt-md-0"
												style=" margin-bottom: 5px">
												<div class="col-10">
													<h5 class="requestSubTitle mb-3">Select location on map</h5>
												</div>
												<div class="col-2 mt-2">
													<button type="button"
														class="btn-contrainer-img float-right" data-toggle="modal"
														data-target="#map-navigation-modal">
														<img
															src="{{asset('images/gardenhelp_icons/info-icon.png')}}"
															style="width: 25px" alt="GardenHelp">
													</button>
												</div>
											</div>
											<div id="area"></div>
											<div id="map" style="margin-top: 0"></div>
											<input type="hidden" id="area_coordinates"
												name="area_coordinates">
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-12 text-center">
								<button id="addNewJobBtn"
									class="btn btn-register btn-gardenhelp-green">Save</button>

							</div>
						</div>

					</div>

				</div>
			</form>
		</div>

	</div>
</div>

<div>


	<!-- Button trigger Site Details modal -->
	<a id="site_details_btn_modal" data-toggle="modal"
		data-target="#site_detailsModal" style="display: none"></a>

	<!-- Last Services Modal -->
	<div class="modal fade" id="site_detailsModal" tabindex="-1"
		role="dialog" aria-labelledby="type_of_experienceLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-left registerModalTitle"
						id="type_of_experienceLabel">Site Details</h5>
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 d-flex justify-content-between"
							v-for="item in site_details" @click="toggleCheckedValue(item)">
							<label for="my-check-box"
								:class="item.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{
								item.title }}</label>
							<div class="my-check-box" id="check">
								<i
									:class="item.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link modal-button-close"
						data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-link modal-button-done"
						data-dismiss="modal" @click="changeSelectedValue('site_details')">
						Done</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal site details -->

	<!-- Map Navigation Modal -->
	<div class="modal fade bd-example-modal-lg" id="map-navigation-modal"
		tabindex="-1" role="dialog" aria-labelledby="map-navigationLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				{{--
				<div class="modal-header">
					--}} {{--
					<h5 class="modal-title text-left registerModalTitle"
						--}}
{{--						id="map-navigationLabel">Site Details</h5>
					--}} {{--
					<button type="button" class="close" data-dismiss="modal"
						--}}
{{--							aria-label="Close">
						--}} {{-- <span aria-hidden="true">&times;</span>--}} {{--
					</button>
					--}} {{--
				</div>
				--}}
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div
								class="col-md-6 col-sm-12 d-flex justify-content-center align-content-center p-3">
								<img src="{{asset('images/map-navigation-step-1.png')}}"
									alt="step-1" style="width: 95%; height: 95%">
							</div>
							<div
								class="col-md-6 col-sm-12 d-flex justify-content-center align-content-center p-3">
								<img src="{{asset('images/map-navigation-step-2.png')}}"
									alt="step-2" style="width: 95%; height: 95%">
							</div>
							<div
								class="col-md-6 col-sm-12 d-flex justify-content-center align-content-center p-3">
								<img src="{{asset('images/map-navigation-step-3.png')}}"
									alt="step-3" style="width: 95%; height: 95%">
							</div>
							<div
								class="col-md-6 col-sm-12 d-flex justify-content-center align-content-center p-3">
								<img src="{{asset('images/map-navigation-step-4.png')}}"
									alt="step-4" style="width: 95%; height: 95%">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-center">
					<button type="button" class="btn btn-register btn-gardenhelp-green"
						data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Map Navigation Modal -->
</div>


<!-- area-calculated-message-modal -->
<div class="modal fade" id="area-calculated-message-modal" tabindex="-1"
	role="dialog" aria-labelledby="area-calculated-message-label"
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


						<div class="row justify-content-center ">

							<div class="col text-center">
								<img src="{{asset('images/gardenhelp_icons/success.png')}}"
									style="" alt="warning">
							</div>
						</div>
						<div class="row justify-content-center mt-3">

							<div class="col text-center">
								<label class="modal-message-label">The land has been calculated
									successfully </label>

							</div>
						</div>
					</div>
				</div>

				<div class="row justify-content-center mt-3">

					<div class="col text-center">
						<button type="button"
							class="btn btn-register btn-gardenhelp-green mb-1"
							data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- end area-calculated-message-modal -->

@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
    });
        
        function changeContact(cont){
        console.log("change contact "+cont);
        app.contact_through=cont;
        }

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
        
        
    	function changeProperty(){
               console.log("ssss") 
               console.log($('option:selected',$("#property")).index()); 
            app.property=$("#property").val();
           
            
            if(app.property === 'other'){
            	 setTimeout(() => {
                    window.initMap();
                    window.initMapDraw();
                   // window.initAutoComplete();
                     $("#type_of_work").select2();
                	$('#available_date_time').datetimepicker({
						icons: {
							time: "fa fa-clock",
							date: "fa fa-calendar",
							up: "fa fa-chevron-up",
							down: "fa fa-chevron-down",
							previous: 'fa fa-chevron-left',
							next: 'fa fa-chevron-right',
							today: 'fa fa-screenshot',
							clear: 'fa fa-trash',
							close: 'fa fa-remove'
						}
					});
                 }, 500)
            	app.selected_property = {};
            }else{
                 console.log(app.properties[$('option:selected',$("#property")).index()-1])
                app.selected_property = app.properties[$('option:selected',$("#property")).index()-1]
                setTimeout(() => {
                    area_coordinates = app.selected_property.area_coordinates;
                        window.initMapDisplay();
                        
                        $('#available_date_time').datetimepicker({
    						icons: {
    							time: "fa fa-clock",
    							date: "fa fa-calendar",
    							up: "fa fa-chevron-up",
    							down: "fa fa-chevron-down",
    							previous: 'fa fa-chevron-left',
    							next: 'fa fa-chevron-right',
    							today: 'fa fa-screenshot',
    							clear: 'fa fa-trash',
    							close: 'fa fa-remove'
    						}
    					});
    			}, 500)		
            }
        }
        
        var app = new Vue({
            el: '#app',
            data: {
                type_of_work: '',
               
                site_details: [
                    {
                        title: 'Pets',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Pets') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Underground Electrical Cable',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Underground Electrical Cable') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Over Ground Electrical Cable',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Over Ground Electrical Cable') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Water Mains',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Water Mains') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Gas Mains',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Gas Mains') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Metered Parking Area',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Metered Parking Area') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ],
                is_first_time: '',
                is_parking_site: '',
                contact_through: '',
                service_types_input: '',
                site_details_input: '',
                property_photo_input: '',
				property_size: "{{old('property_size') ? old('property_size') : ''}}",
				services_types_json: [],
				is_recurring: '',
				available_contractors: [],
				property: '',
            },
            mounted() {
                if (this.type_of_work == 'Commercial') {
                    $('#available_date_time').datetimepicker({
                        icons: {
                            time: "fa fa-clock",
                            date: "fa fa-calendar",
                            up: "fa fa-chevron-up",
                            down: "fa fa-chevron-down",
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                        }
                    });
                    //this.addIntelInput('contact_number', 'contact_number');
                } else if (this.type_of_work == 'Residential') {
                    /*$('#last_services').datetimepicker({
                        icons: {
                            time: "fa fa-clock",
                            date: "fa fa-calendar",
                            up: "fa fa-chevron-up",
                            down: "fa fa-chevron-down",
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                        }
                    });*/
                    $('#available_date_time').datetimepicker({
						icons: {
							time: "fa fa-clock",
							date: "fa fa-calendar",
							up: "fa fa-chevron-up",
							down: "fa fa-chevron-down",
							previous: 'fa fa-chevron-left',
							next: 'fa fa-chevron-right',
							today: 'fa fa-screenshot',
							clear: 'fa fa-trash',
							close: 'fa fa-remove'
						}
					});
                   // this.addIntelInput('phone', 'phone');
                   
                }
            },
            methods: {
            	beforeSubmitForm(e) {
            		e.preventDefault();
            		//if($("#property").val()=='other'){
    					if ($('#area_coordinates').val() == "") {
    						swal({
    							icon: 'warning',
    							text: 'Please make sure you have selected the area on the map!',
    						});
    						return;
    					}
    					if ($('#location_coordinates').val() == "") {
    						swal({
    							icon: 'warning',
    							text: 'Please make sure you have selected an address from Google suggestions!',
    						});
    						return;
    					}
					//}
					var form = document.getElementById('add-new-job');
					setTimeout(form.submit(), 300);
            		
				},
				getVat(percentage, total_price) {
					return parseFloat(((percentage/100) * total_price).toFixed(2));
				},
				getPropertySizeRate(type) {
					let property_size = this.property_size;
					property_size = property_size.replace(' Square Meters', '');
					let rate_property_sizes = JSON.parse(type.rate_property_sizes);
					for (let rate of rate_property_sizes) {
						let size_from = rate.max_property_size_from;
						let size_to = rate.max_property_size_to;
						let rate_per_hour = rate.rate_per_hour;
						if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
							let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
							this.total_price += service_price;
							console.log('service_price ' + service_price);
							return service_price;
						}
					}
				},
				
                changeLocation(e) {
                    if (e.target.value == 'Other') {
                        $('#addOtherLocationBtn').click();
                    }
                },
                openModal(type) {
                    $('#' + type + '_btn_modal').click();
                },
                changeSelectedValue(type) {
                    let input = '';
                    let list = '';
//                     if (type === 'service_details') {
//                         let service_types_input = '';
//                         list = this.service_types;
//                         for (let item of list) {
//                             item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title) : '';
// 							item.is_checked === true ? this.services_types_json.push(item) : '';
//                         }
//                         for (let item of this.other_service_types) {
//                             item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title) : '';
//                         }
//                         this.service_types_input = service_types_input;
//                     } else 
                    if (type === 'site_details') {
                        let site_details_input = '';
                        list = this.site_details;
                        for (let item of list) {
                            item.is_checked === true ? site_details_input += (site_details_input == '' ? item.title : ', ' + item.title) : '';
                        }
//                         for (let item of this.other_service_types) {
//                             item.is_checked === true ? site_details_input += (site_details_input == '' ? item.title : ', ' + item.title) : '';
//                         }
                        this.site_details_input = site_details_input;
                    }
                },
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e, id) {
                   // $("#" + id).val(e.target.files[0].name);
                    console.log(e.target.files)
                	if(e.target.files.length==1){
                    	$("#" + id).val(e.target.files[0].name);
                    }else{
                    	var fileNames = e.target.files[0].name;
                    	for(var i=1; i<e.target.files.length;i++){
                    		fileNames += ", "+e.target.files[i].name;
                    	}
                    	$("#" + id).val(fileNames)
                    }
                },
                changeContact(value) {
                    this.contact_through = value;
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                changePropertyType(type){
                	app.type_of_work = type;
                },
                changeIsFirst() {
                    setTimeout(() => {
                        /*$('#last_services').datetimepicker({
                            icons: {
                                time: "fa fa-clock",
                                date: "fa fa-calendar",
                                up: "fa fa-chevron-up",
                                down: "fa fa-chevron-down",
                                previous: 'fa fa-chevron-left',
                                next: 'fa fa-chevron-right',
                                today: 'fa fa-screenshot',
                                clear: 'fa fa-trash',
                                close: 'fa fa-remove'
                            }
                        });*/
                    }, 500)
                },
				getAvailableContractors(e) {
					let date_time = e.target.value;
					if (date_time) {
						fetch('{{asset('api/garden-help/available_contractors')}}' + '?available_date=' + date_time)
								.then(response => response.json())
								.then(data => {
									this.available_contractors = data.data
								});
					}
				},
            }
        });

       //Map Js
        window.initAutoComplete = function initAutoComplete() {
            //Autocomplete Initialization
            let location_input = document.getElementById('location');
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

                    document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lng": ' + place_lon.toFixed(5) + '}';
                }
            });
        }
        
        let area_coordinates ;
        window.initMapDisplay = function initMapDisplay(){
        	//Map Initialization
			this.map = new google.maps.Map(document.getElementById('map'), {
				zoom: 12,
				center: {lat: 53.346324, lng: -6.258668},
				mapTypeId: 'hybrid'
			});

			// Define the LatLng coordinates for the polygon's path.
			
			const polygonCoords = JSON.parse(area_coordinates);
			// Construct the polygon.
			const polygon = new google.maps.Polygon({
				paths: polygonCoords,
				strokeColor: "#0068b8",
				strokeOpacity: 0.26,
				strokeWeight: 2,
				fillColor: "#0068b8",
				fillOpacity: 0.35,
			});
			polygon.setMap(map);
			// Create the bounds object
			var bounds = new google.maps.LatLngBounds();

			// Get paths from polygon and set event listeners for each path separately
			polygon.getPath().forEach(function (path, index) {

				bounds.extend(path);
			});

			// Fit Polygon path bounds
			map.fitBounds(bounds);
        }
        
        var total_property_size = 0;
        var all_overlays = [];
        window.initMap = function initMap(){
        	 //Map Initialization
            this.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668},
                disableDefaultUI: true,
				mapTypeId: 'hybrid'
			});
        	
            //Marker
            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/customer-address-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };

            let locationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position: {lat: 53.346324, lng: -6.258668}
            });

            locationMarker.setVisible(false)

            //Autocomplete Initialization
            let location_input = document.getElementById('location');
            console.log(location_input)
            if(location_input != null){
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
    
                        locationMarker.setPosition({lat: place_lat, lng: place_lon})
                        locationMarker.setVisible(true);
    
                        //Fit Bounds
                        let bounds = new google.maps.LatLngBounds();
                        bounds.extend({lat: place_lat, lng: place_lon})
                        this.map.fitBounds(bounds);
    
                        document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lng": ' + place_lon.toFixed(5) + '}';
                    }
                });
             }   

            //Map drawing
            var polyOptions = {
                strokeWeight: 0,
                fillOpacity: 0.45,
                editable: true
            };
            // Creates a drawing manager attached to the map that allows the user to draw
            // markers, lines, and shapes.
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                // markerOptions: {
                //     draggable: false
                // },
                // polylineOptions: {
                //     editable: true
                // },
                // rectangleOptions: polyOptions,
                // circleOptions: polyOptions,
                polygonOptions: polyOptions,
                drawingControl: true,
                drawingControlOptions: {
                    drawingModes: ['polygon']
                },
                map: this.map
            });

            // drawingManager.setOptions({
            //
            // });

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
            	 all_overlays.push(e);
                if (e.type != google.maps.drawing.OverlayType.MARKER) {
                    // Switch back to non-drawing mode after drawing a shape.
                    drawingManager.setDrawingMode(null);

                    // Add an event listener that selects the newly-drawn shape when the user
                    // mouses down on it.
                    var newShape = e.overlay;
                    newShape.type = e.type;
                    google.maps.event.addListener(newShape, 'click', function () {
                        setSelection(newShape);
                    });
                    var area = google.maps.geometry.spherical.computeArea(newShape.getPath());
                    let property_size = $("#property_size");
                    let area_coordinates = $("#area_coordinates");
                    total_property_size = parseInt(total_property_size) + parseInt(area.toFixed(0)); 
                    app.property_size = total_property_size + ' Square Meters';
                    property_size.parent().addClass('is-filled');
                    area_coordinates.val(JSON.stringify(newShape.getPath().getArray()));
                    
                    $("#area-calculated-message-modal").modal('show');
                    
                    setSelection(newShape);
					

                }
            });

            // Clear the current selection when the drawing mode is changed, or when the
            // map is clicked.
            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
            google.maps.event.addListener(map, 'click', clearSelection);
            //google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

            // buildColorPalette();

            //Add a custome control button
            let controlDiv = document.createElement("div");
            // Set CSS for the control border.
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "2px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginTop = "5px";
            controlUI.style.height = "24px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Click to recenter the map";
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "16px";
            controlText.style.lineHeight = "16px";
            controlText.style.padding = "4px";
            controlText.innerHTML = '<i class="fas fa-eraser"></i>';
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => deleteSelectedShape());

            this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlDiv)
        }

        var drawingManager;
        var selectedShape;
        var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
        var selectedColor;
        var colorButtons = {};

        function clearSelection() {
            if (selectedShape) {
                selectedShape.setEditable(false);
                selectedShape = null;
            }
        }

        function setSelection(shape) {
            clearSelection();
            selectedShape = shape;
            shape.setEditable(true);
            selectColor(shape.get('fillColor') || shape.get('strokeColor'));
            google.maps.event.addListener(shape.getPath(), 'set_at', calcar);
            google.maps.event.addListener(shape.getPath(), 'insert_at', calcar);
        }

        function calcar() {
            var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
            document.getElementById("area").innerHTML = "Area =" + area;
        }

        function deleteSelectedShape() {
//             if (selectedShape) {
//                 selectedShape.setMap(null);
//                 let property_size = $("#property_size");
//                 let area_coordinates = $("#area_coordinates");
//                 area_coordinates.val('');
//                 app.property_size = '';
//                 total_property_size = 0;
//                 property_size.parent().removeClass('is-filled');
//                 clearMarkers();
//             }
             for (var i=0; i < all_overlays.length; i++)
              {
                all_overlays[i].overlay.setMap(null);
              }
              all_overlays = [];
               let property_size = $("#property_size");
                let area_coordinates = $("#area_coordinates");
                area_coordinates.val('');
                app.property_size = '';
                total_property_size = 0;
                property_size.parent().removeClass('is-filled');
        }

        function selectColor(color) {
            selectedColor = color;
            for (var i = 0; i < colors.length; ++i) {
                var currColor = colors[i];
                colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
            }

            // Retrieves the current options from the drawing manager and replaces the
            // stroke or fill color as appropriate.
            var polylineOptions = drawingManager.get('polylineOptions');
            polylineOptions.strokeColor = color;
            drawingManager.set('polylineOptions', polylineOptions);

            var rectangleOptions = drawingManager.get('rectangleOptions');
            rectangleOptions.fillColor = color;
            drawingManager.set('rectangleOptions', rectangleOptions);

            var circleOptions = drawingManager.get('circleOptions');
            circleOptions.fillColor = color;
            drawingManager.set('circleOptions', circleOptions);

            var polygonOptions = drawingManager.get('polygonOptions');
            polygonOptions.fillColor = color;
            drawingManager.set('polygonOptions', polygonOptions);
        }

	
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>

@endsection
