@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

<link rel="stylesheet" href="{{asset('css/jquery.businessHours.css')}}">
<style>
/* .workingBusinssDay { */
/* 	background-color: #e8ca49; */
/* 	border-radius: 2px !important; */
/* 	border: none !important; */
/* 	max-height: 21px !important; */
/* } */

/* .dayOff { */
/* 	background-color: #eeeeee; */
/* 	border-radius: 2px; */
/* 	border: none !important; */
/* 	max-height: 21px !important; */
/* } */
textarea {
	height: auto !important;
}

.iti {
	width: 100% !important;
}

.dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item:hover,
	.dropdown-menu a:active, .dropdown-menu a:focus, .dropdown-menu a:hover
	{
	box-shadow: none !important;
}

/* .business_day_switch { */
/* 	width: 75px; */
/* 	height: 31px; */
/* 	margin: 45px 18px 10px 85px; */
/* 	border-radius: 2px; */
/* 	background-color: #eeeeee; */
/* } */

/* .business_day_switch_checked { */
/* 	background-color: #e8ca49; */
/* } */

/* .workingBusinssDay { */
/* 	background-color: #e8ca49; */
/* 	border-radius: 2px !important; */
/* 	border: none !important; */
/* 	max-height: 21px !important; */
/* } */

/* .dayOff { */
/* 	background-color: #eeeeee; */
/* 	border-radius: 2px; */
/* 	border: none !important; */
/* 	max-height: 21px !important; */
/* } */
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

#usersTable td {
	text-align: left;
}
</style>
@endsection @section('title','DoOrder | Retailer ' . $retailer->name)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
								<h4 class="card-title my-md-4 mt-4 mb-md-1 mb-4">
									Retailer Profile: <span class="titleNameSpan ml-2">
										{{$retailer->name}} </span>
								</h4>
							</div>
						</div>
					</div>

					<div>
						<ul
							class="nav nav-pills nav-pills-primary justify-content-start justify-content-md-center row"
							role="tablist" id="navSettingsUl">
							<li class="nav-item" data-value="general"><a
								class="nav-link active" data-toggle="tab" href="#generalDetails"
								role="tablist" aria-expanded="true"> General Details </a></li>
							<li class="nav-item" data-value="locations"><a class="nav-link"
								data-toggle="tab" href="#locations" role="tablist"
								aria-expanded="true"> Locations </a></li>
							<li class="nav-item" data-value="shopify"><a class="nav-link "
								data-toggle="tab" href="#shopifyDetails" role="tablist"
								aria-expanded="true"> Shopify Details </a></li>
							@if($readOnly==0)
							<li class="nav-item" data-value="payment"><a class="nav-link "
								data-toggle="tab" href="#paymentDetails" role="tablist"
								aria-expanded="true"> Payment Details </a></li>@endif
							<li class="nav-item" data-value="subaccounts"><a class="nav-link"
								data-toggle="tab" href="#subAccounts" role="tablist"
								aria-expanded="true"> Sub-Accounts </a></li>
							<li class="nav-item" data-value="users"><a class="nav-link "
								data-toggle="tab" href="#users" role="tablist"
								aria-expanded="true"> Users </a></li>

						</ul>
					</div>
					@if($readOnly==0)
					<form id="order-form" method="POST"
						action="{{route('post_doorder_retailers_single_retailer', ['doorder', $retailer->id])}}"
						v-on:submit="checkPaymentCard">
						@endif {{csrf_field()}} <input type="hidden" name="retailer_id"
							value="{{$retailer->id}}">
						<div class="tab-content tab-space">

							<div class="tab-pane active" id="generalDetails"
								aria-expanded="true">
								<div class="card">
									<div class="card-header card-header-profile-border ">
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
												<div class="col-md-12  my-2 profile-border-div mb-4"
													v-for="(contact, index) in contacts">

													<div class="row mb-2">
														<div class="col-12 col-lg-7 col-md-6 ">
															<h5 class="locationLabel card-title">Contact Details @{{
																index + 1 }}</h5>
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
																<label>Contact name</label> <input type="text"
																	class="form-control" :id="'contact_name' + (index + 1)"
																	:name="'contact_name' + (index + 1)" value=""
																	v-model="contact.contact_name"
																	placeholder="Contact name" required>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group bmd-form-group">
																<label>Contact number</label> <input type="text"
																	class="form-control"
																	:id="'contact_number' + (index + 1)"
																	:name="'contact_number' + (index + 1)" value=""
																	v-model="contact.contact_phone"
																	placeholder="Contact number" required>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group bmd-form-group">
																<label>Contact email</label> <input type="email"
																	class="form-control"
																	:id="'contact_email' + (index + 1)"
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
																<select
																	class="form-control form-control-select selectpicker"
																	data-style="select-with-transition"
																	:id="'contact_location' + (index + 1)"
																	:name="'contact_location' + (index + 1)"
																	v-model="contact.contact_location">
																	<option selected disabled>Select location</option>
																	<option v-for="(location, index) of locations"
																		:value="'location'+ (index +1)">Location @{{ index +1
																		}}</option>
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

							</div>
							<div class="tab-pane" id="locations" aria-expanded="true">
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
													v-for="(location, index) in locations">
													<div class="row mb-2">
														<div class="col-10 col-lg-7 col-md-6 ">
															<h5 class="locationLabel card-title">Location @{{ index +
																1 }}</h5>
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
																	v-model="location.eircode"
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
																<label>Working days and hours</label>

																<textarea class="form-control" rows="4"
																	:id="'business_hours' + (index + 1)"
																	:name="'business_hours' + (index + 1)"
																	v-model="location.business_hours"
																	placeholder="Working Days and Hours"
																	data-toggle="modal"
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
																	<div
																		class="modal-dialog-header modalHeaderMessage mb-4">Select
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
												</div>
											</div>

										</div>
									</div>
								</div>

							</div>

							<div class="tab-pane" id="shopifyDetails" aria-expanded="true">
								<div class="card">
									<div class="card-header card-header-profile-border">
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

							</div>
							@if($readOnly==0)
							<div class="tab-pane " id="paymentDetails" aria-expanded="true">

								<div class="card">
									<div class="card-header card-header-profile-border">
										<div class="col-md-12 pl-3">
											<h4>Payment Details</h4>
										</div>
									</div>
									<div class="card-body">
										<div class="container">
											<div class="row">
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
								</div>

							</div>
							@endif

							<div class="tab-pane " id="subAccounts" aria-expanded="true">
								<div class="card">

									<div class="card-body">
										<div
											class=" justify-content-right float-sm-right  mt-md-2 mb-2">
											<button type="button"
												class=" btn-doorder-filter btn-doorder-add-item mt-0"
												@click="addNewAccount()">Add new account</button>

										</div>
										<div class="table-responsive">
											<table id="retailersTable"
												class="table table-no-bordered table-hover doorderTable "
												cellspacing="0" width="100%" style="width: 100%">
												<thead>
													<tr class="theadColumnsNameTr">
														<th>Business Type</th>
														<th>Retailer Name</th>
														<th class="text-center">Locations Number</th>
														<!-- 											<th class="text-center">Sub-Accounts</th> -->
														<th class="disabled-sorting text-center">Actions</th>
													</tr>
												</thead>

												<tbody>
													<tr v-for="account in subaccounts"
														v-if="subaccounts.length > 0" class="order-row">
														<td class="text-left">@{{ account.business_type}}</td>
														<td class="text-left">@{{ account.name}}</td>
														<td>@{{ account.nom_business_locations }}</td>
														<!-- 											<td></td> -->
														<td class="actionsTd"><a class="edit"
															@click="openRetailerSubaccount(account.id)"><img
																src="{{asset('images/doorder-new-layout/edit-icon.png')}}"></a>
															<button type="button" class="remove"
																@click="clickDeleteRetailerSubaccount(account.id)">
																<img
																	src="{{asset('images/doorder-new-layout/delete-icon.png')}}">
															</button></td>

													</tr>

													<tr v-else>
														<td colspan="4" class="text-center"><strong>No data found.</strong>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!--  end card subaccounts -->
							</div>
							<div class="tab-pane" id="users" aria-expanded="true">
								<div class="card">
									<div class="card-body">
										<div class="container " style="width: 100%; max-width: 100%;">
											<div class="row ">
												<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3"></div>
												<div class="col-12 col-lg-5 col-md-6 mt-md-2 mb-2">
													<div class="row justify-content-end float-sm-right">

														<button type="button"
															class="btn-doorder-filter btn-doorder-add-item mt-0"
															@click="clickAddUser()">Add New User</button>

													</div>
												</div>
											</div>

											<div class="table-responsive">
												<table id="usersTable"
													class="table table-no-bordered table-hover doorderTable "
													width="100%" style="width: 100%">
													<thead>
														<tr class="">
															<th>User</th>
															<th>Last Activity</th>
															<th>User Type</th>
															<th>Business Account</th>
															<th class="disabled-sorting text-center">Actions</th>
														</tr>
													</thead>

													<tbody>
														<tr v-for="user in users" v-if="users.length > 0"
															class="order-row">
															<td>
																<p class="invoiceServiceP">@{{ user.name}}</p>
																<p class="invoiceDateSpan">@{{user.email}}</p>
															</td>
															<td>@{{ user.last_activity}}</td>
															<td>@{{ user.user_type }}</td>
															<td>@{{ user.business_account }}</td>

															<td class="actionsTd"><button type="button" class="edit"
																	@click="clickEditUser(user.id,user.name,user.email,user.userTypeId,user.businessAccountId)">
																	<img
																		src="{{asset('images/doorder-new-layout/edit-icon.png')}}">
																</button>
																<button type="button" class="remove"
																	@click="clickDeleteUser(user.id)">

																	<img
																		src="{{asset('images/doorder-new-layout/delete-icon.png')}}">
																</button></td>
														</tr>


														<tr v-else>
															<td colspan="4" class="text-center"><strong>No data
																	found.</strong></td>
														</tr>


													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- end card users -->

							</div>


						</div>
						@if($readOnly==0) <input type='hidden' id="locations_details"
							name='locations_details' /> <input type='hidden'
							id='contacts_details' name='contacts_details' />
					</form>
					@endif @if($readOnly==0)
					<div class="row justify-content-center">
						<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center"
							id="saveButtonContainer">

							<button type="button"
								class="btnDoorder btn-doorder-primary  mb-1"
								@click="submitForm()">Save</button>
						</div>
						@if(auth()->user()->user_role != 'retailer')
						<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
							<button class="btnDoorder btn-doorder-danger-outline  mb-1"
								type="button" data-toggle="modal"
								data-target="#delete-retailer-modal">Delete</button>
						</div>
						@endif
					</div>
					@endif

				</div>
			</div>
		</div>

	</div>
</div>
<!-- Delete retailer modal -->
<div class="modal fade" id="delete-retailer-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-retailer-label"
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
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
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
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#delete-retailer').submit()">Yes</button>
				</div>

				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end delete retailer modal -->

<!-- delete user modal -->
<div class="modal fade" id="delete-user-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-user-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
					want to delete this account?</div>
				<div>
					<form method="POST" id="delete-user"
						action="{{url('doorder/retailer/user/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" name="retailer_id"
							value="{{$retailer->id}}"> <input type="hidden" id="userId"
							name="userId" value="" />
					</form>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#delete-user').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end delete user modal -->

<!-- add user modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog"
	aria-labelledby="add-user-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addUserModalHeader">Add User</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="add-user"
				action="{{url('doorder/retailer/user/save')}}"
				style="margin-bottom: 0 !important;">
				@csrf <input type="hidden" name="retailer_id"
					value="{{$retailer->id}}">
				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="user_name">Name </label> <input type="text"
									class="form-control" name="user_name" id="user_name"
									placeholder="Name" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="email">Email </label> <input type="text"
									class="form-control" name="email" id="email"
									placeholder="Email" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Role</label> <select
									class="form-control form-control-select selectpicker"
									data-style="select-with-transition" id="userTypeSelect"
									name="user_type" required="required">
									<option value="" selected disabled>Select role</option>
									<option value="admin">Admin</option>
									<option value="retailer">Retailer</option>
									<option value="sales">Sales</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Business account</label> <select
									class="form-control form-control-select"
									id="businessAccountSelect" name="business_account[]"
									required="required" multiple="multiple">
									<option value="" disabled>Select business account</option>
									<option value="all" class="selectAllOption">All</option>
									@foreach ($businessAccounts as $account)
									<option value="{{$account->id}}" class="option">{{$account->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

				</div>

				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button class="btnDoorder btn-doorder-primary mb-1" type="submit"
							id="addUserBtn">Add User</button>
					</div>

					<!-- 				<div class="col-sm-6"> -->
					<!-- 					<button type="button" -->
					<!-- 						class="btn btn-danger doorder-btn-lg doorder-btn" -->
					<!-- 						data-dismiss="modal">Cancel</button> -->
					<!-- 				</div> -->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end add user modal -->

<!-- edit user modal -->
<div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog"
	aria-labelledby="edit-user-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addUserModalHeader">Edit User</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="add-user"
				action="{{url('doorder/retailer/user/edit')}}"
				style="margin-bottom: 0 !important;">
				@csrf <input type="hidden" name="retailer_id"
					value="{{$retailer->id}}"> <input type="hidden" name="userId"
					id="userId" />
				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="user_name">Name </label> <input type="text"
									class="form-control" name="user_name" id="user_nameEdit"
									placeholder="Name" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="email">Email </label> <input type="text"
									class="form-control" name="email" id="emailEdit"
									placeholder="Email" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Role</label> <select
									class="form-control form-control-select selectpicker"
									data-style="select-with-transition" id="userTypeSelectEdit"
									name="user_type" required="required">
									<option value="" disabled>Select role</option>
									<option value="admin">Admin</option>
									<option value="retailer">Retailer</option>
									<option value="sales">Sales</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Business account</label> <select class="form-control "
									id="businessAccountSelectEdit" name="business_account[]"
									required="required" multiple="multiple">
									<option value="" disabled>Select business account</option>
									<option value="all">All</option> @foreach ($businessAccounts as
									$account)
									<option value="{{$account->id}}">{{$account->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>


				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button class="btnDoorder btn-doorder-primary mb-1" type="submit"
							id="editUserBtn">Edit User</button>
					</div>

					<!-- 				<div class="col-sm-6"> -->
					<!-- 					<button type="button" -->
					<!-- 						class="btn btn-danger doorder-btn-lg doorder-btn" -->
					<!-- 						data-dismiss="modal">Cancel</button> -->
					<!-- 				</div> -->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit user modal -->


<!-- delete subaccount modal -->
<div class="modal fade" id="delete-subaccount-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-subaccount-label"
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
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
					want to delete this account?</div>
				<div>
					<form method="POST" id="delete-user"
						action="{{url('doorder/retailer/subaccount/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" name="retailer_id"
							value="{{$retailer->id}}"> <input type="hidden" id="accountId"
							name="accountId" value="" />
					</form>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#delete-user').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end delete subaccount modal -->

@endsection @section('page-scripts')
<script src="{{asset('js/jquery.businessHours.min.js')}}"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=places"></script>

<script>
	let autocomp_countries = JSON.parse('{!!$google_auto_comp_countries!!}');
	let retailer_id = {!! $retailer->id !!}
	
	$(document).ready(function() {
		var readonly = {!! $readOnly !!};
		if(readonly==1){
			$("input").prop('disabled', true);
			$("textarea").prop('disabled', true);
			$("select").prop('disabled', true);
			$(".inputSearchNavbar").prop('disabled', false);
			$('.addCircle,.removeCircle').css("display","none")
		}
		
		var table= $('#retailersTable').DataTable({
         "pagingType": "full_numbers",
                "lengthMenu": [
                  [-1,10, 25, 50,100],
                  ["All",10, 25, 50,100]
                ],
          responsive: true,
          "language": {  
            		search: '',
        			"searchPlaceholder": "Search ",
        			
        			"paginate": {
                              "previous": "<i class='fas fa-angle-left'></i>",
                              "next": "<i class='fas fa-angle-right'></i>",
                              "first":"<i class='fas fa-angle-double-left'></i>",
                              "last":"<i class='fas fa-angle-double-right'></i>"
                            }
            	},
        	"columnDefs": [ {
        		"targets": -1,
        		"orderable": false
        	} ],
    	});
    	
    	 var table= $('#usersTable').DataTable({
           		"pagingType": "full_numbers",
         		 fixedColumns: true,
                "lengthMenu": [
                  [-1,10, 25, 50,100],
                  ["All",10, 25, 50,100]
                ],
                "ordering": false,
                "language": {  
            		search: '',
        			"searchPlaceholder": "Search ",
        			
        			"paginate": {
                              "previous": "<i class='fas fa-angle-left'></i>",
                              "next": "<i class='fas fa-angle-right'></i>",
                              "first":"<i class='fas fa-angle-double-left'></i>",
                              "last":"<i class='fas fa-angle-double-right'></i>"
                            }
            	},
            	"columnDefs": [ {
                		"targets": [-1],
                		"orderable": false
            		},                        
                 ],
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 0,
                },
    });
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );
    	
    	$("#navSettingsUl li").click(function(){
        		var val = $(this).attr('data-value');
            	if(val=="users" || val=="subaccounts"){
            		$("#saveButtonContainer").css("display","none");
            	}else{
            		$("#saveButtonContainer").css("display","block");
            	}       
     	 });
     	 
     	 
    		   		$("#add-user-modal #businessAccountSelect").select2({ tags: true});
    		   		$("#edit-user-modal #businessAccountSelectEdit").select2({ tags: true});
    		   		$("#businessAccountSelect").change(function(e){
    		   			e.preventDefault()
                      	//console.log($(this).val())
                      	if($(this).val().indexOf("all") ==-1){
                      		$("#businessAccountSelect .option").prop('disabled', false);
                      	}
                      	else{
                      		if($(this).val().length==1){
                      			return;
                      		}
                      		$("#businessAccountSelect .option").prop('disabled', true);
                      		//$("#businessAccountSelect").select2().val('')
                      		$("#businessAccountSelect").select2('val',['all'])
                      		//$("#businessAccountSelect").select2(['all'], null, false)
                      		$('#businessAccountSelect').select2('close');
                      	}
                    });
                    $("#businessAccountSelectEdit").change(function(e){
    		   			e.preventDefault()
                      	//console.log("edit "+$(this).val())
                      	if($(this).val().indexOf("all") ==-1){
                      		//console.log("edit  -1")
                      		$("#businessAccountSelectEdit .option").prop('disabled', false);
                      	}
                      	else{
                      		//console.log("edit ! -1")
                      		if($(this).val().length==1){
                      			
                      			//console.log("edit ! -1 & length 1")
                      			return;
                      		}
                      		$("#businessAccountSelectEdit .option").prop('disabled', true);
                      		//$("#businessAccountSelectEdit").select2().val('')
                      		$("#businessAccountSelectEdit").select2('val',['all'])
                      		//$("#businessAccountSelect").select2(['all'], null, false)
                      		$('#businessAccountSelectEdit').select2('close');
                      		
                      		//console.log("edit  ! -1 end")
                      	}
                    });
                    
                    
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
                    disabled:'',
                    contact_location: null,
                    subaccounts: {!! json_encode($subaccounts) !!},
                    users: {!! json_encode($users) !!},
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
				
				//Temporarily edited as DoOrder only want Dublin
                let iresh_counties_json = jQuery.getJSON('{{asset('iresh_counties.json')}}', data => {
                		
                	 for (let county of data) {
                        if(county.city.toLowerCase() == 'dublin') {
                            this.counties.push({name: county.city, coordinates: {lat: county.lat, lng: county.lng}});
                        }
                    }
                });
				
			},
			methods: {
				addLocation(){
					this.locations.push({});
					this.timer = setTimeout(() => {
                        this.addAutoCompleteInput();
                        this.addBusinessHoursContainer();
            			$('.selectpicker').selectpicker();
            			$(".selectpicker").selectpicker("refresh");
                    }, 1000)
				},
                removeLocation(index){
					this.locations.splice(index, 1);
					this.timer = setTimeout(() => {
                       $('.selectpicker').selectpicker();
                       $(".selectpicker").selectpicker("refresh");
                    }, 500)
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
							 app.locations[latest_key-1].address = place.formatted_address;
                                app.locations[latest_key-1].coordinates = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
							// }
							if (eircode_value != undefined) {
								retailer_eircode_input.value = eircode_value.long_name;
								 app.locations[latest_key-1].eircode = eircode_value.long_name;
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
                clickEditUser(user_id,name, email, user_type,business_account){
    		   		//console.log("edit user ",user_id,name, email, user_type, business_account);
    		   		
    		   		$("#edit-user-modal").modal('show');
    		   		$("#edit-user-modal #userId").val(user_id);
    		   		$("#edit-user-modal #user_nameEdit").val(name);
    		   		$("#edit-user-modal #emailEdit").val(email);
    		   		$("#edit-user-modal #userTypeSelectEdit").val(user_type);
    		   		$("#edit-user-modal #businessAccountSelectEdit").val(business_account).change();
    		   		$('#edit-user-modal .selectpicker').selectpicker('refresh');
    		   	//$("#businessAccountSelectEdit").select2('val',['all'])	
    		   },
    		   clickDeleteUser(userId){
    		   		//console.log("delete user ",userId);
                    		   		
                    $('#delete-user-modal').modal('show')
                    $('#delete-user-modal #userId').val(userId);
    		   },
    		   clickAddUser(){
    		   		//console.log("click add user");
    		   		$("#add-user-modal").modal('show');
    		   },
    		   clickDeleteRetailerSubaccount(account_id){
    		   		//console.log("delete subaccount ",account_id);
                    		   		
                    $('#delete-subaccount-modal').modal('show')
                    $('#delete-subaccount-modal #accountId').val(account_id);
    		   },
    		   addNewAccount(){
    		   		window.location.href = "{{url('doorder/retailer')}}/"+retailer_id+"/subaccount/add";
    		   },
    		   openRetailerSubaccount(account_id){
    		   		window.location.href = "{{url('doorder/retailer')}}/"+retailer_id+'/subaccount/edit/'+account_id;
    		   }
			}
        });
        Vue.config.devtools = true
        
    </script>
@endsection
