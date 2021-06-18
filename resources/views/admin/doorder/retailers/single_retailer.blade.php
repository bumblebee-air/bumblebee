@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
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
						action="{{route('post_doorder_retailers_single_retailer', ['doorder', $retailer->id])}}">
						@endif {{csrf_field()}} <input type="hidden" name="retailer_id"
							value="{{$retailer->id}}">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-md-8">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/doorder_icons/Retailer.png')}}">
									</div>
									<h4 class="card-title ">{{$retailer->name}}</h4>
								</div>

								@if($readOnly==1)
								<div class="col-12 col-md-4 mt-md-5">
									<div class="row justify-content-end float-sm-right">
										<a class="editLinkA btn  btn-link btn-primary-doorder  edit"
											href="{{url('doorder/retailers/')}}/{{$retailer->id}}">
											<p>Edit retailer</p>
										</a>
									</div>
								</div>
								@endif
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

										<div class="col-md-12 d-flex form-head pl-3">
											<span> 1 </span>
											<h5 class="singleViewSubTitleH5">Company Details</h5>
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
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12 d-flex form-head pl-3">
											<span> 2 </span>
											<h5 class="singleViewSubTitleH5">Locations Details</h5>
										</div>

										<div class="col-md-12" v-for="(location, index) in locations">
											<label class="locationTitleLabel mt-3"
												v-if="locations.length > 1">Location @{{ index + 1 }}</label>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Address</label>
														<textarea :id="'location' + (index +1)"
															class="form-control" rows="5"
															:name="'address' + (index + 1)" placeholder="Address"
															required>@{{ location.address }}</textarea>
														<input :id="'location_'+ (index+1) +'_coordinates'"
															:name="'address_coordinates_' + (index + 1)"
															type="hidden">
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Eircode</label> <input type="text"
															class="form-control" :name="'eircode' + (index + 1)"
															:id="'eircode' + (index + 1)" :value="location.eircode"
															placeholder="Postcode/Eircode" required>
													</div>
													<div class="form-group bmd-form-group">
														<label>Country</label> <input type="text"
															class="form-control" :value="location.country"
															placeholder="Country" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Working days and hours</label> <textarea
															class="form-control" :id="'business_hours' + (index + 1)"
															:name="'business_hours' + (index + 1)"
															placeholder="Working days and hours">@{{location.business_hours}}</textarea>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														 <label>County</label> <input type="text"
															class="form-control"
															:value="JSON.parse(location.county).name"
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
							<div class="card-body">
								<div class="container">
									<div class="row" @click="changeCurrentTap('contact')">
										<div class="col-md-12 d-flex form-head pl-3">
											<span> 3 </span>
											<h5 class="singleViewSubTitleH5">Contact Details</h5>
										</div>

										<div class="col-md-12" v-for="(contact, index) in contacts">
											<label class="locationTitleLabel mt-3"
												v-if="contacts.length > 1">Contact Details @{{ index + 1 }}</label>
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact name</label> <input type="text"
															class="form-control" :id="'contact_name' + (index + 1)"
															:name="'contact_name' + (index + 1)"
															:value="contact.contact_name" placeholder="Contact name"
															required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact number</label> <input type="text"
															class="form-control" :id="'contact_number' + (index + 1)"
															:name="'contact_number' + (index + 1)"
															:value="contact.contact_phone"
															placeholder="Contact number" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Contact email</label> <input type="email"
															class="form-control" :id="'contact_email' + (index + 1)"
															:name="'contact_email' + (index + 1)"
															:value="contact.contact_email"
															placeholder="Contact email address" required>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group bmd-form-group">
														<label>Location</label> <input type="text"
															class="form-control" :value="contact.contact_location"
															:name="'contact_location' + (index + 1)"
															placeholder="Location" required>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="container">
									<div class="row" @click="changeCurrentTap('contact')">
										<div class="col-md-12 d-flex form-head pl-3">
											<span> 4 </span>
											<h5 class="singleViewSubTitleH5">Shopify Details</h5>
										</div>

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
						<div class="row">
							<div class="col-sm-6 text-center">

								<button class="btn bt-submit">Save</button>
							</div>
							<div class="col-sm-6 text-center">
								<button class="btn bt-submit btn-danger" type="button"
									data-toggle="modal" data-target="#delete-retailer-modal">Delete</button>
							</div>
						</div>
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
<script>
$( document ).ready(function() {

var readonly = {!! $readOnly !!};
if(readonly==1){
$("input").prop('disabled', true);
$("textarea").prop('disabled', true);
$(".inputSearchNavbar").prop('disabled', false);
}
});
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    locations: JSON.parse({!! json_encode($retailer->locations_details) !!}),
                    contacts: JSON.parse({!! json_encode($retailer->contacts_details) !!}),
                }
            },
        });
    </script>
@endsection
