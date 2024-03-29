@extends('templates.dashboard') @section('title', 'GardenHelp | Add
Job') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">

<link rel="stylesheet"
	href="{{asset('css/gardenhelp-slick-styles.css')}}">

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
.select2-container, .inputContainerDiv {
	width: calc(100% - 52px) !important;
}

.input-group-text {
	color: #aaa;
	padding-left: 0;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
}

.card .card-body .form-group {
	margin-top: 2px;
}

.form-control {
	border-radius: 6px;
}

.input-group-prepend+.inputContainerDiv .form-control {
	border-radius: 0 6px 6px 0;
}

.input-group-text img {
	width: 20px;
}
.errorMessage{
    color: red; font-weight: 500; display: none; margin-bottom: 0;
}
</style>
<script src="https://js.stripe.com/v3/"></script>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid" id="app">
			<form action="{{route('postAddJob', 'garden-help')}}" method="POST"
				enctype="multipart/form-data" autocomplete="off" id="add-new-job"
				@submit="beforeSubmitForm">
				{{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose">
								<div class="card-icon">
									<i class="fas fa-plus-circle"></i>
								</div>
								<h4 class="card-title ">Book New Job</h4>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-7 col-sm-6 col-12">

											@if(auth()->user()->user_role == 'customer') <input
												type="hidden" name="customer_id"
												value="{{$current_user->id}}" /> @endif

											@if(auth()->user()->user_role == 'client')
											<div class="row mt-3">
												<div class="col-md-12">
													<h5 class="requestSubTitle">Customer Details</h5>
												</div>

												<div class="col-md-12">
													<div class="form-group ">
														<label for="property" class="">Select Customer </label>
														<div class="input-group">
															<div class="input-group-prepend">
															<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/property-icon.png')}}"
																		alt="GardenHelp">
															</span>
															</div>
															<select id="customer" name="customer"
																	class="form-control js-example-basic-single"
																	v-model="customer" onchange="changeCustomer()" required="required">
																<option disabled selected value="">Select customer</option>
																<option v-for="customer in customers"
																		:value="customer.id">@{{customer.name}}</option>
																<option value="other" >Create a new customer</option>
															</select>
														</div>

													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Name</label> <input type="text"
															class="form-control" name="name" value="{{old('name')}}" v-model="selected_customer.name"
															required :disabled="customer != 'other'">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Email address</label> <input type="email"
															class="form-control" name="email"
															value="{{old('email')}}" required v-model="selected_customer.email" :disabled="customer != 'other'">
													</div>
												</div>
{{--												<div class="col-md-12">--}}
{{--													<div class="form-group">--}}
{{--														<label>Contact through</label>--}}
{{--														<div class="d-flex">--}}
{{--															<div class="contact-through d-flex pr-5"--}}
{{--																@click="changeContact('whatsapp')">--}}
{{--																<div id="check"--}}
{{--																	:class="contact_through == 'whatsapp' ? 'my-check-box checked' : 'my-check-box'">--}}
{{--																	<i class="fas fa-check-square"></i>--}}
{{--																</div>--}}
{{--																WhatsApp--}}
{{--															</div>--}}

{{--															<div class="contact-through d-flex"--}}
{{--																@click="changeContact('sms')">--}}
{{--																<div id="check"--}}
{{--																	:class="contact_through == 'sms' ? 'my-check-box checked' : 'my-check-box'">--}}
{{--																	<i class="fas fa-check-square"></i>--}}
{{--																</div>--}}
{{--																SMS--}}
{{--															</div>--}}
{{--															<input type="hidden" v-model="contact_through"--}}
{{--																name="contact_through">--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
												<div class="col-md-12">
													<div class="form-group bmd-form-group">
														<label>Phone number</label> <input type="tel"
															class="form-control" id="phone" name="phone"
															value="{{old('phone')}}" required v-model="selected_customer.phone" :disabled="customer != 'other'">
													</div>
												</div>
											</div>
											@endif

											<div>
												<div class="row mt-3">
													<div class="col-md-12">
														<h5 class="requestSubTitle">Property Information</h5>
													</div>
													<div class="col-md-12"  v-show="properties.length > 0">
														<div class="form-group ">
															<label for="property" class="">Property </label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/property-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<select id="property" name="property" 
																	class="form-control js-example-basic-single"
																	v-model="property" onchange="changeProperty()" required="required">
																	<option disabled selected value="">Select property</option>
																	<option v-for="property in properties"
																		:value="property.id">@{{property.location}}</option>
																	<option value="other" >Other</option>
																</select>
															</div>

														</div>
													</div>
												</div>
												<div class="row"
													v-if="property != '' && property != 'other' ">
													<div class="col-12 mt-2">
														<div class=" row">
															<div class=" col-12">
																<span class="input-group-text d-inline"> <img
																	src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
																	alt="GardenHelp">
																</span> <label class="requestLabel d-inline"><span
																	class="customerRequestSpan ">@{{selected_property.work_location}}</span></label>
															</div>
														</div>
													</div>
													<div class="col-12 mt-2">
														<div class=" row">
															<div class=" col-12">
																<label class="requestLabel d-inline">Property type: <span
																	class="customerRequestSpan ">@{{selected_property.type_of_work}}</span></label>
															</div>
														</div>
													</div>

													<div class="col-12 mt-2">
														<div class=" row">
															<div class=" col-12">
																<span class="input-group-text d-inline"> <img
																	src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
																	alt="GardenHelp">
																</span> <label class="requestLabel d-inline"><span
																	class="customerRequestSpan ">@{{selected_property.location}}</span></label>
															</div>
														</div>
													</div>
													<div class="col-12 mt-2">
														<div class=" row">
															<div class=" col-12">
																<span class="input-group-text d-inline"> <img
																	src="{{asset('images/gardenhelp_icons/property-size-icon.png')}}"
																	alt="GardenHelp">
																</span> <label class="requestLabel d-inline">Property
																	size: <span class="customerRequestSpan ">@{{selected_property.property_size}}</span>
																</label>
															</div>
														</div>
													</div>


													<div class="col-12 mt-3">
														<div class=" row">
															<label class="requestLabel col-12">Property Images</label>
															<div class="col-12">
																<section class="timeline-carousel">

																	<div class="timeline-carousel__item-wrapper"
																		data-js="timeline-carousel">
																		<!--Timeline item-->
																		<div class="timeline-carousel__item"
																			v-for="item in selected_property.property_photo">
																			<div class="timeline-carousel__image">
																				<div class=" ">
																					<img :src="'{{asset('/')}}'+item" width="100%">
																				</div>
																			</div>
																		</div>
																		<!--/Timeline item-->

																	</div>
																</section>
															</div>
														</div>
													</div>

													<div class="col-12 mt-2">
														<div class=" row">
															<div class=" col-12">
																<label class="requestLabel d-inline">Is there a parking
																	access on site? <span class="customerRequestSpan ">@{{selected_property.is_parking_access
																		? 'Yes' : 'No'}}</span>
																</label>
															</div>
														</div>
													</div>



													<div class="col-12 mt-2">
														<div class=" row">
															<label class="requestLabel col-12 mb-0">Site details: </label><span
																class=" customerRequestSpan col-12 mt-0">@{{selected_property.site_details}}</span>
														</div>
													</div>

												</div>
												<div class="row"
													v-if="property != '' && property == 'other' ">
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
																	class="form-control js-example-basic-single " required="required">
																	<option disabled selected value="">Select location</option>
																	<option value="Dublin">Dublin</option>
																	<option value="Carlow">Carlow</option>
																	<option value="Kilkenny">Kilkenny</option>
																	<option value="Kildare">Kildare</option>
																</select>
															</div>
														</div>
													</div>
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
															<p id="productTypeErrorMessage" class="errorMessage">Please
													select one of these options</p>
															<div class="row">
																<div class="col">

																	<div class="form-check">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			name="type_of_work" value="Residential" required="required">Residential <span
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
																for="photographs_of_property">Property image </label> <br>
															<input id="property_photo" name="property_photo[]"
																type="file" class="inputFileHidden" multiple="multiple"
																@change="onChangeFile($event, 'property_photo_input')">
															<div class="input-group"
																@click="addFile('property_photo')">
																<input type="text" id="property_photo_input"
																	class="form-control inputFileVisible"
																	placeholder="Upload Photos" required> <span
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
																<span class="form-control"
																	id="property_size_span"
																	><span style="color: #ACB1C0">Please use map to calculate size </span></span>
															</div>
															<input type="hidden" class="form-control"
																	id="property_size" name="property_size" required
																	v-model="property_size"
																	placeholder="Please use map to calculate size">
														</div>
													</div>
													

													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="vat-number">Is there a parking access on
																site?</label>
															<p id="isParkingErrorMessage" class="errorMessage">Please
													select one of these options</p>
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
													
												</div>

												<div class="row">

													<div class="col-md-12">
														<h5 class="requestSubTitle">Job Information</h5>
													</div>
													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="type_of_experience">What Services would you like to book?</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/property-size-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<div
																	class="d-flex justify-content-between inputContainerDiv"
																	@click="openModal('service_type')">
																	<input name="service_types" type="text"
																		class="form-control" id="service_type_input"
																		v-model="service_types_input"
																		{{old('service_details')}} required>
																</div>
															</div>

														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="available_date_time">What date and time would you like to book ?</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/time-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<input name="available_date_time" type="text"
																	class="form-control datetimepicker"
																	id="available_date_time"
																	value="{{old('available_date_time')}}"
																	required @focusout="getAvailableContractors">
															</div>
														</div>
													</div>

													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="budget">What is your budget?</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/budget-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<input name="budget" type="number" min="0"
																	class="form-control " id="budget"
																	value="{{old('budget')}}" required>
															</div>
														</div>
													</div>

													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="vat-number">Is this your first service?</label>
															
															<p id="isFirstServiceErrorMessage" class="errorMessage">Please
													select one of these options</p>
													
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
																			'0' ? 'checked' : ''}} onclick="changeIsFirst()"
																			required> No <span class="circle"> <span
																				class="check"></span>
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
															<label for="type_of_experience">What was the time of your last service ?</label>
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"> <img
																		src="{{asset('images/gardenhelp_icons/time-icon.png')}}"
																		alt="GardenHelp">
																	</span>
																</div>
																<input name="last_services" type="text"
																	class="form-control datetimepicker" id="last_services"
																	{{old('last_services')}} required>
															</div>
														</div>
													</div>
<!-- 													<div class="col-md-12"> -->
<!-- 														<div class="form-group bmd-form-group"> -->
<!-- 															<label for="vat-number">Contact Through</label> -->
<!-- 															<div class="row"> -->
<!-- 																<div class="col"> -->
<!-- 																	<div class="form-check form-check-radio"> -->
<!-- 																		<label class="form-check-label"> <input -->
<!-- 																					class="form-check-input" type="radio" -->
<!-- 																					id="contact-through" name="contact_through" -->
<!-- 																					value="sms" --><!-- required> Phone <span -->
<!-- 																					class="circle"> <span class="check"></span> -->
<!-- 																		</span> -->
<!-- 																		</label> -->
<!-- 																	</div> -->
<!-- 																</div> -->
<!-- 																<div class="col"> -->
<!-- 																	<div class="form-check form-check-radio"> -->
<!-- 																		<label class="form-check-label"> <input -->
<!-- 																					class="form-check-input" type="radio" -->
<!-- 																					id="contact-through" name="contact_through" -->
<!-- 																					value="email" -->
<!-- 																					required> Email <span class="circle"> <span -->
<!-- 																						class="check"></span> -->
<!-- 																		</span> -->
<!-- 																		</label> -->
<!-- 																	</div> -->
<!-- 																</div> -->
<!-- 															</div> -->
<!-- 														</div> -->
<!-- 													</div> -->
													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="vat-number">Do you mind being contacted prior
																to job?</label>
															
															<p id="isContactErrorMessage" class="errorMessage">Please
													select one of these options</p><div class="row">
																<div class="col">
																	<div class="form-check form-check-radio">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			id="exampleRadios2" name="is_contacted" value="0"
																			v-model="is_contacted" {{old('is_contacted') ===
																			'0' ? 'checked' : ''}} required> Yes <span
																			class="circle"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
																<div class="col">
																	<div class="form-check form-check-radio">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			id="exampleRadios1" name="is_contacted" value="1"
																			v-model="is_contacted" {{old('is_contacted') ===
																			'1' ? 'checked' : ''}} required @click="changeIsContacted()">
																			No <span class="circle"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12"
														v-if="is_contacted != '' && is_contacted == 1">
														<div class="form-group bmd-form-group">
															<label for="">Contact me through</label>
																														<p id="contactThroughErrorMessage" class="errorMessage">Please
													select one of these options</p>
															<div class="row">
																<div class="col">
																	<div class="form-check form-check-radio">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			name="contact_through" value="sms"
																			{{old('contact_through') ===  'sms' ? 'checked' : ''}} required>
																			Phone <span class="circle"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
																<div class="col">
																	<div class="form-check form-check-radio">
																		<label class="form-check-label"> <input
																			class="form-check-input" type="radio"
																			name="contact_through" value="email" 
																			{{old('contact_through') ===
                                                                                    'email' ? 'checked' : ''}}
																			required>
																			Email <span class="circle"> <span class="check"></span>
																		</span>
																		</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group bmd-form-group">
															<label for="">Any specific details regarding the Service you are booking ?</label>
															<textarea name="notes" rows="2" class="form-control"
																id="notes">{{old('notes')}}</textarea>

														</div>
													</div>
												</div>

											</div>

										</div>
										<div class="col-md-5 col-sm-6 col-12">
<!-- 											<div class="row mt-3" style="margin-top: -20px; margin-bottom: 5px"> -->
<!-- 												<div class="col-md-10"> -->
<!-- 													<h5 class="requestSubTitle mb-3">Select location on map</h5> -->
<!-- 												</div> -->
<!-- 												<div class="col-md-2 mt-2"> -->
<!-- 													<button type="button" -->
<!-- 														class="btn-contrainer-img float-right" data-toggle="modal" -->
<!-- 														data-target="#map-navigation-modal"> -->
<!-- 														<img -->
<!-- 															src="{{asset('images/gardenhelp_icons/info-icon.png')}}" 
															style="width: 25px" alt="GardenHelp"> -->
<!-- 													</button> -->
<!-- 												</div> -->
<!-- 											</div> -->
											<div class="row mt-3 justify-content-center">
												<div class="col text-center">
													<button type="button" style="max-width: 100%;text-transform: none; font-size: 16px"
														class="btn btn-outline-success btn-sm btn-round " data-toggle="modal"
														data-target="#map-navigation-modal">How to select the location on the map ?</button>
												</div>
											</div>
											<div id="area"></div>
											<div id="map" style="height: 95%; margin-top: 0"></div>
											<input type="hidden" id="area_coordinates"
												name="area_coordinates">
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
											<div class="form-group bmd-form-group">
												<div class="row mt-3">
													<div class="col-md-12">
														<h5 class="requestSubTitle">Payment Details</h5>
													</div>
												</div>
												<div class="row">
													<div class="col-md-3 d-flex align-content-center p-4">
														<img src="{{asset('images/powered-by-stripe.png')}}"
															style="width: 100%" alt="Powred By Stripe">
													</div>
													<div class="col-md-9">
														<div class="row">
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
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="services_types_json"
							v-model="JSON.stringify(services_types_json)">
{{--						<div class="row">--}}
{{--							@if(auth()->user()->user_role == 'client')--}}
{{--							<div class="col-lg-12">--}}
{{--								<div class="card ">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container"--}}
{{--											style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Estimated--}}
{{--																Price Quotation</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row" v-for="type in service_types"--}}
{{--														v-if="type.is_checked">--}}
{{--														<div class="col-md-3 col-6">--}}
{{--															<label class="requestLabelGreen">@{{ type.title }}</label>--}}
{{--														</div>--}}
{{--														<div class="col-md-9 col-6">--}}
{{--															<span class="requestSpanGreen">€@{{--}}
{{--																getPropertySizeRate(type) }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}

{{--													<div class="row">--}}
{{--														<div class="col-md-3 col-6">--}}
{{--															<label class="requestLabelGreen">VAT</label>--}}
{{--														</div>--}}
{{--														<div class="col-md-9 col-6">--}}
{{--															<span class="requestSpanGreen">€@{{ getVat(13.5,--}}
{{--																getTotalPrice()) }} (13.5%)</span>--}}
{{--														</div>--}}
{{--													</div>--}}

{{--													<div class="row" style="margin-top: 15px">--}}
{{--														<div class="col-md-3 col-6">--}}
{{--															<label class="requestSpanGreen">Total</label>--}}
{{--														</div>--}}
{{--														<div class="col-md-9 col-6">--}}
{{--															<span class="requestSpanGreen">€@{{ (getTotalPrice() ---}}
{{--																this.percentage + getVat(13.5,--}}
{{--																getTotalPrice())).toFixed(2) }} - €@{{ (getTotalPrice()--}}
{{--																+ this.percentage + getVat(13.5,--}}
{{--																getTotalPrice())).toFixed(2) }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							@endif--}}
{{--							@if(auth()->user()->user_role == 'client')--}}
{{--							<div class="col-lg-12" v-if="available_contractors.length > 0">--}}
{{--								<div class="card ">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container"--}}
{{--											style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-lg-12 d-flex">--}}
{{--													<div class="row">--}}
{{--														<div class="col-12">--}}
{{--															<div class=" row">--}}
{{--																<div class="col-12">--}}
{{--																	<h5 class="cardTitleGreen requestSubTitle ">Available--}}
{{--																		contractors on this date</h5>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--														<div class="col-12">--}}
{{--															<div class="row"--}}
{{--																v-for="contractor in available_contractors"--}}
{{--																v-if="available_contractors.length > 0">--}}
{{--																<div class="col-md-3 col-6">--}}
{{--																	<span class="requestSpanGreen">@{{ contractor.name }} </span>--}}
{{--																</div>--}}
{{--																<div class="col-md-3 col-6">--}}
{{--																	<label class="requestLabelGreen">@{{--}}
{{--																		contractor.experience_level }}</label>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--															<div class="col text-center" v-else>--}}
{{--																<div>There is no contractors available on this date.</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							@endif--}}
							<div class="col-12 text-center">
								<button id="addNewJobBtn"
									class="btn btn-register btn-gardenhelp-green">Submit</button>

							</div>
{{--						</div>--}}

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
							<div class="d-flex justify-content-between"
								@click="toggleCheckedValue(type)">
								<label for="my-check-box"
									:class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{
									type.title }}</label>
								<div class="my-check-box" id="check">
									<i
										:class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
								</div>
							</div>
							<div class="col-md-12 d-flex" v-if="type.is_checked == true && type.is_service_recurring == true">
								<div
									class="form-check form-check-radio form-check-inline d-flex justify-content-between">
									<label class="form-check-label"> <input
										class="form-check-input" type="radio"
										:name="'is_recurring' + index" id="inlineRadio1" value="1"
										v-model="type.is_recurring" checked> Recurring <span
										class="circle"> <span class="check"></span>
									</span>
									</label>
								</div>

								<div
									class="form-check form-check-radio form-check-inline d-flex justify-content-between">
									<label class="form-check-label"> <input
										class="form-check-input" type="radio"
										:name="'is_recurring' + index" id="inlineRadio1" value="0"
										v-model="type.is_recurring"> Once <span class="circle"> <span
											class="check"></span>
									</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="input-group mb-3 input-group-sm">
								<input type="text" class="form-control form-control-sm" placeholder="Other Service" v-model="other_service">
								<div class="input-group-append">
									<button class="btn btn-primary btn-sm m-0" type="button" :disabled="other_service.length == 0" @click="addOtherService">
										<i class="fas fa-plus ml-2 mr-2"></i>
									</button>
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
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"> </script>
<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
        
        $('.datetimepicker').datetimepicker({
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
						},
						
					});
					
		 $('#addNewJobBtn').click(function( event ) {
    	//console.log("submittttt")
		 		validateInput();
         });
    });
    
    function validateInput(){
    	//console.log("submit")
    	if($("#property").val()==="other"){
    		if( $("input[name=type_of_work]:checked").val()==null ){
            			//console.log("submit 4")
					 	$('#productTypeErrorMessage').css("display","block")
                        return false;
           }else{
              // console.log("submit 5")
                $('#productTypeErrorMessage').css("display","none");
                
                if( $("input[name=is_parking_site]:checked").val()==null ){
                			//console.log("submit 44")
    					 	$('#isParkingErrorMessage').css("display","block")
                            return false;
               }else{
                   //console.log("submit 55")
                    $('#isParkingErrorMessage').css("display","none");
                               
                 }           
                            
              
             }
    	}
    	
       if( $("input[name=is_first_time]:checked").val()==null ){
            			//console.log("submit 4")
					 	$('#isFirstServiceErrorMessage').css("display","block")
                        return false;
       }else{
           //console.log("submit 5")
            $('#isFirstServiceErrorMessage').css("display","none");
            
            if( $("input[name=is_contacted]:checked").val()==null ){
            			//console.log("submit 44")
					 	$('#isContactErrorMessage').css("display","block")
                        return false;
           }else{
               //console.log("submit 55")
                $('#isContactErrorMessage').css("display","none");
                if( $("input[name=is_contacted]:checked").val()==0 ){
                    if( $("input[name=contact_through]:checked").val()==null ){
                			//console.log("submit 44")
    					 	$('#contactThroughErrorMessage').css("display","block")
                            return false;
                   }else{
                       //console.log("submit 55")
                        $('#contactThroughErrorMessage').css("display","none");
                        
                                   
                     }   
                 }    
                           
             }           
                        
          
         }
         
         
         
         return true;
    }
    
    function changeWorkType(){
                $('#addNewJobBtn').prop("disabled", false);
          //  console.log($("#type_of_work").val());
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

					$('.datetimepicker').datetimepicker({
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
                    //window.initAutoComplete()
                    $('.datetimepicker').datetimepicker({
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
                },300);
            }
        }
        
        function changeContact(cont){
            //console.log("change contact "+cont);
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
        
         function  changeIsFirst() {
                    setTimeout(() => {
                        $('.datetimepicker').datetimepicker({
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
        
    	function changeProperty(){
//                console.log("ssss") 
//                console.log($('option:selected',$("#property")).index()); 
            app.property=$("#property").val();
           
            
            if(app.property === 'other'){
            	 setTimeout(() => {
                    window.initMap();
                    window.initMapDraw();
                   // window.initAutoComplete();
                     $("#type_of_work").select2();
                     $("#work_location").select2();
                	$('.datetimepicker').datetimepicker({
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
						},
						
					});
					
                 }, 500)
            	app.selected_property = {};
            }else{
                 //console.log(app.properties[$('option:selected',$("#property")).index()-1])
                app.selected_property = app.properties[$('option:selected',$("#property")).index()-1]
                setTimeout(() => {
                    area_coordinates = app.selected_property.area_coordinates;
                        window.initMapDisplay();
                        
                        $('.datetimepicker').datetimepicker({
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
    					
    					 $('.timeline-carousel__item-wrapper').not('.slick-initialized').slick({
                            infinite: false,
                            arrows: true,
                            prevArrow: '<div class="slick-prev"> <div class="btn mr-3  d-flex justify-content-center align-items-center"> <i class="fas fa-chevron-left"></i></div></div>',
                            nextArrow: '<div class="slick-next"> <div class="btn d-flex justify-content-center align-items-center"><i class="fas fa-chevron-right"></i> </div></div>',
                            dots: true,
                            autoplay: false,
                            speed: 1100,
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            responsive: [
                              {
                                breakpoint: 800,
                                settings: {
                                  slidesToShow: 1,
                                  slidesToScroll: 1
                                }
                              }]
                     	 });
    			}, 500)		
            }
            
        }
		function changeCustomer(){
			app.customer = $("#customer").val();
			if (app.customer == 'other') {
				app.selected_customer = {
					id: '',
					name: '',
					phone: '',
					properties: [],
				}
				app.selected_property = null;
			} else {
				app.selected_customer = app.customers[$('option:selected',$("#customer")).index()-1];
			}
			app.properties = app.selected_customer.properties;
			// app.selected_customer.phone = window.phoneNumber.setNumber(app.selected_customer.phone);
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
                is_contacted:'',
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
				properties : {!! json_encode($properties) !!},
				selected_property: null,
				other_service: '',
				customers : {!! json_encode($customers) !!},
				customer: 'other',
				selected_customer: {
					id: '',
					name: '',
					phone_number: '',
					location: '',
					location_coordinates: ''
				}

			},
            mounted() {
            	if(this.properties.length == 0 ){
            		this.property = 'other';
            		 setTimeout(() => {
                    window.initMap();
                    window.initMapDraw();
                   // window.initAutoComplete();
                     $("#type_of_work").select2();
                     $("#work_location").select2();
                	$('.datetimepicker').datetimepicker({
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
						},
						
					});
					
                 }, 500)
            	}
                if (this.type_of_work == 'Commercial') {
                    $('.datetimepicker').datetimepicker({
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
                    /*$('.datetimepicker').datetimepicker({
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
                    $('.datetimepicker').datetimepicker({
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
                   
                }
				window.phoneNumber = this.addIntelInput('phone', 'phone');
                
            },
            methods: {
				addOtherService() {
					this.service_types.push({
						"id": null,
						"name": this.other_service,
						"min_hours":20,
						"rate_property_sizes":"[{\"rate_per_hour\":\"30\",\"max_property_size_from\":\"1\",\"max_property_size_to\":\"5000\"}]","is_service_recurring":0,"created_at":"2021-05-05T10:54:44.000000Z","updated_at":"2021-05-05T10:54:44.000000Z",
						"title":this.other_service,
						"is_checked": true,
						"is_recurring":"0"
					});
					this.other_service = ''
				},
            	beforeSubmitForm(e) {
            		e.preventDefault();
            		if($("#property").val()=='other'){
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
					}
					
					validateInput();
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
							//console.log('service_price ' + service_price);
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
					this.percentage = (total_price / 100) * 20;
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
                    // $("#" + id).val(e.target.files[0].name);
                   // console.log(e.target.files)
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
                changeWorkType() {
                   // alert('ss');
                     app.type_of_work = $("#type_of_work").val();

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
                            $('.datetimepicker').datetimepicker({
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
                        /*$('.datetimepicker').datetimepicker({
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
                changeIsContacted(){
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
				addIntelInput(input_id, input_name) {
					let phone_input = document.querySelector("#" + input_id);
					return window.intlTelInput(phone_input, {
						hiddenInput: input_name,
						initialCountry: 'IE',
						separateDialCode: true,
						preferredCountries: ['IE', 'GB'],
						utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
					});
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

                    document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lng": ' + place_lon.toFixed(5) + '}';
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
			
			//Marker
            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/customer-address-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };
			// console.log(app.selected_property.location_coordinates)
            let locationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position: JSON.parse(app.selected_property.location_coordinates)
            });
			
        }
        
//         var total_property_size = 0;
//         var all_overlays = [];
        let newShape;
        let locationMarker;
        
        window.initMapDraw = function initMapDraw(){
        	
            //Marker
            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/customer-address-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };

            locationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position: {lat: 53.346324, lng: -6.258668}
            });

            locationMarker.setVisible(false)

            //Autocomplete Initialization
            let location_input = document.getElementById('location');
            //console.log(location_input)
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
            	// all_overlays.push(e);
                if (e.type != google.maps.drawing.OverlayType.MARKER) {
                	if(newShape !=null){
                		newShape.setMap(null)
                	}
                    // Switch back to non-drawing mode after drawing a shape.
                    drawingManager.setDrawingMode(null);

                    // Add an event listener that selects the newly-drawn shape when the user
                    // mouses down on it.
                    newShape = e.overlay;
                    newShape.type = e.type;
                    google.maps.event.addListener(newShape, 'click', function () {
                        setSelection(newShape);
                    });
                    var area = google.maps.geometry.spherical.computeArea(newShape.getPath());
                    let property_size = $("#property_size");
                    let area_coordinates = $("#area_coordinates");
                    var total_property_size = parseInt(area.toFixed(0)); 
                     app.property_size = total_property_size + ' Square Meters';
                    $("#property_size_span").html(total_property_size + ' Square Meters')
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
            controlUI.style.marginTop = "5px";
            controlUI.style.height = "24px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Click to recenter the map";
            controlDiv.appendChild(controlUI);

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

//              for (var i=0; i < all_overlays.length; i++)
//               {
//                 all_overlays[i].overlay.setMap(null);
//               }
//               all_overlays = [];
				newShape.setMap(null);
               let property_size = $("#property_size");
                let area_coordinates = $("#area_coordinates");
                area_coordinates.val('');
                app.property_size = '';
                 $("#property_size_span").html('<span style="color: #ACB1C0">Please use map to calculate size </span>')
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

	initStripeElements();
					
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
				//console.log(result.error.message);
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
