@extends('templates.dashboard') @section('title', 'GardenHelp | Add
Job') @section('page-styles')
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
	margin-top: 25px !important;
	margin-bottom: 10px !important;
}

.form-control, .form-control:invalid, .is-focused .form-control {
	box-shadow: none !important;
}
</style>
<script src="https://js.stripe.com/v3/"></script>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid" id="app">
			<form action="{{route('postAddJob', 'garden-help')}}" method="POST"
				enctype="multipart/form-data" autocomplete="off" id="add-new-job" @submit="beforeSubmitForm">
				{{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose">
								<div class="card-icon">
									<i class="fas fa-plus-circle"></i>
								</div>
								<h4 class="card-title ">Add New Job</h4>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-7 col-sm-6 col-12">
											<div class="row">
												<div class="col-12">
													<div class="form-group ">
														<label for="work_location" class="">Location</label> <select
															id="work_location" name="work_location"
															class="form-control js-example-basic-single ">
															<option disabled selected value="">Select location</option>
															<option value="Dublin">Dublin</option>
															<option value="Carlow">Carlow</option>
															<option value="Kilkenny">Kilkenny</option>
															<option value="Kildare">Kildare</option>
														</select>
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group ">
														<label for="type_of_work" class="">Type of work </label><select
															id="type_of_work" name="type_of_work"
															class="form-control js-example-basic-single"
															v-model="type_of_work" onchange="changeWorkType()">
															<option disabled selected value="">Select type of work</option>
															<option value="Residential">Residential</option>
															<option value="Commercial">Commercial</option>
														</select>
													</div>
												</div>


											</div>

											<div class="row" v-if="type_of_work == 'Residential'">
												<div class="col-md-12">
													<h5 class="requestSubTitle">Person Details</h5>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Name</label> <input type="text"
															class="form-control" name="name" value="{{old('name')}}"
															required>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Email address</label> <input type="email"
															class="form-control" name="email"
															value="{{old('email')}}" required>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Contact through</label>
														<div class="d-flex">
															<div class="contact-through d-flex pr-5"
																@click="changeContact('whatsapp')">
																<div id="check"
																	:class="contact_through == 'whatsapp' ? 'my-check-box checked' : 'my-check-box'">
																	<i class="fas fa-check-square"></i>
																</div>
																WhatsApp
															</div>

															<div class="contact-through d-flex"
																@click="changeContact('sms')">
																<div id="check"
																	:class="contact_through == 'sms' ? 'my-check-box checked' : 'my-check-box'">
																	<i class="fas fa-check-square"></i>
																</div>
																SMS
															</div>
															<input type="hidden" v-model="contact_through"
																name="contact_through">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Phone number</label> <input type="tel"
															class="form-control" id="phone" name="phone"
															value="{{old('phone')}}" required>
													</div>
												</div>
											</div>


											<div class="row" v-if="type_of_work == 'Commercial'">
												<div class="col-md-12">
													<h5 class="requestSubTitle">Business Details</h5>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label class="bmd-form-floating">Business name</label> <input
															type="text" class="form-control" name="name"
															value="{{old('name')}}" required>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Company email</label> <input type="email"
															class="form-control" name="email"
															value="{{old('email')}}" required>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Contact through</label>
														<div class="d-flex">
															<div class="contact-through d-flex pr-5"
																onclick="changeContact('email')">
																<div id="check"
																	:class="contact_through == 'email' ? 'my-check-box checked' : 'my-check-box'">
																	<i class="fas fa-check-square"></i>
																</div>
																Email
															</div>

															<div class="contact-through d-flex"
																onclick="changeContact('phone')">
																<div id="check"
																	:class="contact_through == 'phone' ? 'my-check-box checked' : 'my-check-box'">
																	<i class="fas fa-check-square"></i>
																</div>
																Phone calls
															</div>
															<input type="hidden" v-model="contact_through"
																name="contact_through">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Contact person name</label> <input type="text"
															class="form-control" name="contact_name"
															value="{{old('contact_name')}}" required>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Contact person number</label> <input type="text"
															class="form-control" id="contact_number"
															name="contact_number" value="{{old('contact_number')}}"
															required>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group is-filled">
														<label for="available_date_time">Select from the available
															date & time</label> 
															<input name="available_date_time" type="text"
																class="form-control datetimepicker"
																id="available_date_time"
																 required> 
													</div>
												</div>

											</div>
											<div class="row" v-if="type_of_work != '' ">
												<div class="col-md-12">
													<h5 class="requestSubTitle">Service Details</h5>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label for="type_of_experience">Service type</label>
														<div class="d-flex justify-content-between"
															@click="openModal('service_type')">
															<input name="service_types" type="text"
																class="form-control" id="service_type_input"
																v-model="service_types_input"
																{{old('service_details')}} required> <a
																class="select-icon"> <i class="fas fa-caret-down"></i>
															</a>
														</div>
													</div>
												</div>
											</div>
											<div class="row" v-if="type_of_work != ''">
												<div class="col-md-12">
													<h5 class="requestSubTitle">Property Information</h5>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label class="" for="location">Address</label> <input
															type="text" class="form-control" id="location"
															name="location" value="{{old('location')}}" required> <input
															type="hidden" id="location_coordinates"
															name="location_coordinates">
													</div>
												</div>

												<div class="col-md-12 ">
													<div
														class="form-group form-file-upload form-file-multiple ">
														<label class="bmd-label-static"
															for="photographs_of_property"> Upload photographs of
															property </label> <br> <input id="property_photo"
															name="property_photo" type="file" class="inputFileHidden"
															@change="onChangeFile($event, 'property_photo_input')">
														<div class="input-group"
															@click="addFile('property_photo')">
															<input type="text" id="property_photo_input"
																class="form-control inputFileVisible"
																placeholder="Upload Photo" required> <span
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
														<label>Property size</label> <input type="text"
															class="form-control" id="property_size"
															name="property_size"
															required v-model="property_size">
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label for="vat-number">Is this the first time you do
															service for your property?</label>
														<div class="row">
															<div class="col">
																<div class="form-check form-check-radio">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio"
																		id="exampleRadios2" name="is_first_time"
																		v-model="is_first_time" value="1"
																		{{old('is_first_time') ===
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
																		id="exampleRadios1" name="is_first_time"
																		v-model="is_first_time" value="0"
																		{{old('is_first_time') ===
																		'0' ? 'checked' : ''}} @click="changeIsFirst()"
																		required> No <span class="circle"> <span class="check"></span>
																	</span>
																	</label>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="col-md-12"
													v-if="is_first_time != '' && is_first_time == 0">
													<div class="form-group bmd-form-group">
														<label for="type_of_experience">When was the last service?</label>
														<div class="d-flex justify-content-between"
															@click="openModal('last_services')">
															<input name="last_services" type="text"
																class="form-control" id="last_services"
																{{old('last_services')}} required>
															<!--<a class="select-icon"> <i class="fas fa-caret-down"></i></a>-->
														</div>
													</div>
												</div>

												<div class="col-md-12"
													v-if="is_first_time != '' && is_first_time == 0">
													<div class="form-group bmd-form-group">
														<label for="type_of_experience">Site details</label>
														<div class="d-flex justify-content-between"
															@click="openModal('site_details')">
															<input name="site_details" type="text"
																class="form-control" id="site_details"
																v-model="site_details_input"
																{{old('site_details')}} required> <a class="select-icon">
																<i class="fas fa-caret-down"></i>
															</a>
														</div>
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label for="vat-number">Is there a parking access on site?</label>
														<div class="row">
															<div class="col">
																<div class="form-check form-check-radio">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio"
																		id="exampleRadios2" name="is_parking_site"
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
																		id="exampleRadios1" name="is_parking_site"
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
													<div class="form-group bmd-form-group is-filled">
														<label for="available_date_time">Schedual at</label>
														{{--                                <div class="d-flex justify-content-between">--}}
														<input name="available_date_time" type="text" class="form-control datetimepicker" id="available_date_time" {{old('available_date_time')}} required>
														{{--                                    <a class="select-icon">--}}
														{{--                                        <i class="fas fa-caret-down"></i>--}}
														{{--                                    </a>--}}
														{{--                                </div>--}}
													</div>
												</div>

												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<div class="row">
															<div class="col-md-12">
																<h5 class="requestSubTitle">Payment Details</h5>
															</div>
															<div class="col-md-12">
																<div class="form-group bmd-form-group">
																	<label>Card Number</label>
																	<div class="form-control" id="card_number"></div>
																</div>
															</div>
															<div class="col">
																<div class="form-group bmd-form-group">
																	<label>CVC</label>
																	<div class="form-control" id="card_cvc"></div>
																</div>
															</div>
															<div class="col">
																<div class="form-group bmd-form-group">
																	<label>Exp. Month</label>
																	<div class="form-control" id="card_exp"></div>
																</div>
															</div>
														</div>
													</div>
												</div>


											</div>

										</div>
										<div class="col-md-5 col-sm-6 col-12">
											<div id="area"></div>
											<div id="map" style="height: 100%; margin-top: 0"></div>
											<input type="hidden" id="area_coordinates"
												name="area_coordinates">
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12  ">
								<div class="card ">
									<div class="card-body" style="padding-top: 0 !important;">
										<div class="container" style="padding-bottom: 10px !important;">
											<div class="row">
												<div class="col-12">
													<div class=" row">
														<div class="col-12">
															<h5 class="cardTitleGreen requestSubTitle ">Estimated
																Price Quotation</h5>
														</div>
													</div>
												</div>
												<div class="col-12">
													<div class="row" v-for="type in service_types" v-if="type.is_checked">
														<div class="col-md-3 col-6">
															<label class="requestLabelGreen">@{{ type.title }}</label>
														</div>
														<div class="col-md-3 col-6">
															<span class="requestSpanGreen">€@{{ getPropertySizeRate(type) }}</span>
														</div>
													</div>

													<div class="row">
														<div class="col-md-3 col-6">
															<label class="requestLabelGreen">VAT</label>
														</div>
														<div class="col-md-3 col-6">
															<span class="requestSpanGreen">€@{{ getVat(13.5, getTotalPrice()) }} (13.5%)</span>
														</div>
													</div>

													<div class="row" style="margin-top: 15px">
														<div class="col-md-3 col-6">
															<label class="requestSpanGreen">Total</label>
														</div>
														<div class="col-md-3 col-6">
															<span class="requestSpanGreen">€@{{ getTotalPrice() + getVat(13.5, getTotalPrice()) }}</span>
														</div>
													</div>
													<input type="hidden" name="services_types_json" v-model="JSON.stringify(services_types_json)">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 text-center">
								<button id="addNewJobBtn"
									class="btn btn-register btn-gardenhelp-green" disabled>Add
									new job</button>

							</div>
						</div>

					</div>
				</div>
			</form>
		</div>

	</div>
</div>

<div>
	<!-- Button trigger modal -->
	<a id="service_type_btn_modal" data-toggle="modal"
		data-target="#service_typeModal" style="display: none"></a>

	<!-- Modal -->
	<div class="modal fade" id="service_typeModal" tabindex="-1"
		role="dialog" aria-labelledby="type_of_experienceLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-left registerModalTitle"
						id="type_of_experienceLabel">Service Type</h5>
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" v-for="(type, index) in service_types">
							<div class="d-flex justify-content-between" @click="toggleCheckedValue(type)">
								<label for="my-check-box" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
								<div class="my-check-box" id="check">
									<i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
								</div>
							</div>
							<div class="col-md-12 d-flex" v-if="type.is_checked == true && type.is_service_recurring == true">
								<div class="form-check form-check-radio form-check-inline d-flex justify-content-between">
									<label class="form-check-label">
										<input class="form-check-input" type="radio"
											   :name="'is_recurring' + index" id="inlineRadio1"
											   value="1" v-model="type.is_recurring" checked> Recurring <span
												class="circle"> <span class="check"></span>
												</span>
									</label>
								</div>

								<div class="form-check form-check-radio form-check-inline d-flex justify-content-between">
									<label class="form-check-label">
										<input class="form-check-input" type="radio"
											   :name="'is_recurring' + index" id="inlineRadio1"
											   value="0" v-model="type.is_recurring"> Once <span
												class="circle"> <span class="check"></span>
												</span>
									</label>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link modal-button-close"
						data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-link modal-button-done"
						data-dismiss="modal"
						@click="changeSelectedValue('service_details')">Done</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal service type -->

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
</div>

@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
    });
    function changeWorkType(){
                $('#addNewJobBtn').prop("disabled", false);
            console.log($("#type_of_work").val());
            app.type_of_work=$("#type_of_work").val();

            if ($("#type_of_work").val() == 'Residential') {
                setTimeout(() => {
                    window.initMap();
					initStripeElements();
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
                    addIntelInput('phone', 'phone');
                }, 500)
            } else {
                setTimeout(() => {
                    window.initMap();
                    window.initAutoComplete()
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
                    addIntelInput('contact_number', 'contact_number');
                });
            }
        }
        
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
        
        var app = new Vue({
            el: '#app',
            data: {
                type_of_work: '',
                service_types: {!! json_encode($services) !!},
                other_service_types: [
                    {
                        title: 'Landscaping/Garden Design',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Landscaping/Garden Design') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Tree Surgery/Stump Removal',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Tree Surgery/Stump Removal') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Fencing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Decking',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Decking') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Decking Repairs',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Decking Repairs') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Strimming',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Strimming') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Power Washing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Power Washing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Shed Repairs',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Shed Repairs') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Flat Pack Garden Furniture Assembly',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Flat Pack Garden Furniture Assembly') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Green Waste Removal',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Green Waste Removal') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Patio Installation',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Patio Installation') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Lawn Fertilization',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Lawn Fertilization') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Garden Painting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Garden Painting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Gutter VAC',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Gutter VAC') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Leaf blowing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Leaf blowing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Mulching',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Mulching') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Power Washing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Power Washing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Hedge Cutting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Hedge Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ],
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
				services_types_json: []
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
                    this.addIntelInput('contact_number', 'contact_number');
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
                    this.addIntelInput('phone', 'phone');
                }
            },
            methods: {
            	beforeSubmitForm(e) {
            		e.preventDefault();
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
            		generateStripeToken(e)
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
				getTotalPrice(isActual = false) {
					let property_size = this.property_size;
					property_size = property_size.replace(' Square Meters', '');
					let total_price = 0
					let services_types = isActual === true ? this.actual_services_types : this.service_types;
					for (let type of services_types) {
						if (type.is_checked) {
							let rate_property_sizes = JSON.parse(type.rate_property_sizes);
							for (let rate of rate_property_sizes) {
								let size_from = rate.max_property_size_from;
								let size_to = rate.max_property_size_to;
								let rate_per_hour = rate.rate_per_hour;
								if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
									let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
									total_price += service_price;
								}
							}
						}
					}
					return parseFloat(total_price);
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
                    if (type === 'service_details') {
                        let service_types_input = '';
                        list = this.service_types;
                        for (let item of list) {
                            item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title) : '';
							item.is_checked === true ? this.services_types_json.push(item) : '';
                        }
                        for (let item of this.other_service_types) {
                            item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title) : '';
                        }
                        this.service_types_input = service_types_input;
                    } else if (type === 'site_details') {
                        let site_details_input = '';
                        list = this.site_details;
                        for (let item of list) {
                            item.is_checked === true ? site_details_input += (site_details_input == '' ? item.title : ', ' + item.title) : '';
                        }
                        for (let item of this.other_service_types) {
                            item.is_checked === true ? site_details_input += (site_details_input == '' ? item.title : ', ' + item.title) : '';
                        }
                        this.site_details_input = site_details_input;
                    }
                },
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e, id) {
                    $("#" + id).val(e.target.files[0].name);
                },
                changeContact(value) {
                    this.contact_through = value;
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                changeWorkType() {
                   // alert('ss');
                    // app.type_of_work = $("#type_of_work").val();

                    if ($("#type_of_work").val() == 'Residential') {
                        setTimeout(() => {
                            window.initMap();
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
                            this.addIntelInput('phone', 'phone');
                        }, 500)
                    } else {
                        setTimeout(() => {
                            window.initMap();
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
                            this.addIntelInput('contact_number', 'contact_number');
                        });
                    }
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
                }
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

                    document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
                }
            });
        }
        window.initMap = function initMap() {
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

                    document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
                }
            });

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
                    app.property_size = area.toFixed(0) + ' Square Meters';
                    property_size.parent().addClass('is-filled');
                    area_coordinates.val(JSON.stringify(newShape.getPath().getArray()));
                    setSelection(newShape);

                }
            });

            // Clear the current selection when the drawing mode is changed, or when the
            // map is clicked.
            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
            google.maps.event.addListener(map, 'click', clearSelection);
            // google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

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
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Click to recenter the map";
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "16px";
            controlText.style.lineHeight = "38px";
            controlText.style.paddingLeft = "5px";
            controlText.style.paddingRight = "5px";
            controlText.innerHTML = "Reset Area";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => deleteSelectedShape());

            this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv)
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
            if (selectedShape) {
                selectedShape.setMap(null);
                let property_size = $("#property_size");
                let area_coordinates = $("#area_coordinates");
                area_coordinates.val('');
                app.property_size = '';
                property_size.parent().removeClass('is-filled');
                clearMarkers();
            }
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

	//Stripe Elements
	var stripe = Stripe("{{env('STRIPE_PUBLIC_KEY')}}");
	var elements = stripe.elements({
		fonts: [
			{
				cssSrc: 'https://fonts.googleapis.com/css?family=Roboto',
			},
		],
		// Stripe's examples are localized to specific languages, but if
		// you wish to have Elements automatically detect your user's locale,
		// use `locale: 'auto'` instead.
		locale: 'auto'
	});

	var elementStyles = {
		iconStyle: "solid",
		style: {
			base: {
				iconColor: "#fff",
				color: "#fff",
				fontWeight: 400,
				fontFamily: "Helvetica Neue, Helvetica, Arial, sans-serif",
				fontSize: "16px",
				fontSmoothing: "antialiased",
				borderBottom: "solid 1px #eaecef",
				padding: "10px",

				"::placeholder": {
					color: "#BFAEF6"
				},
				":-webkit-autofill": {
					color: "#fce883"
				}
			},
			invalid: {
				iconColor: "#FFC7EE",
				color: "#FFC7EE"
			}
		}
	};

	var elementClasses = {
		focus: 'focus',
		empty: 'empty',
		invalid: 'invalid',
	};

	let cardNumber = window.cardNumber = elements.create('cardNumber', {
		style: elementStyles,
		classes: elementClasses,
	});

	let cardExpiry = window.cardExpiry = elements.create('cardExpiry', {
		style: elementStyles,
		classes: elementClasses,
	});

	let cardCvc = window.cardCvc = elements.create('cardCvc', {
		style: elementStyles,
		classes: elementClasses,
	});

	function initStripeElements() {
		// Add an instance of the card Element into the `card-element` <div>
		cardNumber.mount('#card_number');
		cardExpiry.mount('#card_exp');
		cardCvc.mount('#card_cvc');
	}
	function generateStripeToken() {
		stripe.createToken(window.cardNumber).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error
				var errorElement = document.getElementById('card-errors');
				errorElement.textContent = result.error.message;
				console.log(result.error.message);
			} else {
				// Send the token to your server
				// Insert the token ID into the form so it gets submitted to the server
				document.createElement('input');
				var form = document.getElementById('add-new-job');
				var hiddenInput = document.createElement('input');
				hiddenInput.setAttribute('type', 'hidden');
				hiddenInput.setAttribute('name', 'stripeToken');
				hiddenInput.setAttribute('value', result.token.id);
				form.appendChild(hiddenInput);
				// Submit the form
				setTimeout(form.submit(), 300);
			}
		});

	}
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>

@endsection
