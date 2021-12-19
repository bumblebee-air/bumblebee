@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
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
</style>
@endsection @section('title','DoOrder | Retailer Application NO. ' .
$singleRequest->id) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					{{csrf_field()}}

					<div class="card card-profile-page-title">
						<div class="card-header row">
							<div class="col-12 p-0">
								<h4 class="card-title my-md-4 mt-4 mb-1">Retailer Application
									NO. {{$singleRequest->id}}</h4>
							</div>
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
											<label>Company Name</label> <span class="form-control">{{$singleRequest->name}}</span>
											<!-- 											<input type="text" -->
											<!-- 												class="form-control" name="company_name" -->
											<!-- 												value="{{$singleRequest->name}}" placeholder="Company Name" -->
											<!-- 												required> -->
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Company Website</label> <span class="form-control">{{$singleRequest->company_website}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Business Type</label> <span class="form-control">{{$singleRequest->business_type}}</span>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Number of Business Locations</label> <span
												class="form-control">{{$singleRequest->nom_business_locations}}</span>
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

									<div class="col-md-12 my-2 profile-border-div mb-4"
										v-for="(location, index) in locations">
										<h5 class="locationLabel card-title" v-if="locations.length > 1">Location
											@{{ index + 1 }}</h5>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Address</label>
													<span class="form-control">@{{ location.address }} </span>
<!-- 													<textarea :id="'location' + (index +1)" -->
<!-- 														class="form-control" rows="3" -->
<!-- 														:name="'address' + (index + 1)" placeholder="Address" -->
<!-- 														required>@{{ location.address }}</textarea> -->
<!-- 													<input :id="'location_'+ (index+1) +'_coordinates'" -->
<!-- 														:name="'address_coordinates_' + (index + 1)" type="hidden"> -->
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Eircode</label>
													<span class="form-control">@{{ location.eircode }} </span> 
<!-- 													<input type="text" -->
<!-- 														class="form-control" :name="'eircode' + (index + 1)" -->
<!-- 														:id="'eircode' + (index + 1)" :value="location.eircode" -->
<!-- 														placeholder="Postcode/Eircode" required> -->
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Country</label>
													<span class="form-control">@{{ location.country }} </span>
<!-- 													 <input type="text" -->
<!-- 														class="form-control" :value="location.country" -->
<!-- 														placeholder="Country" required> -->
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group bmd-form-group">

													<label>County</label>
													<span class="form-control">@{{ JSON.parse(location.county).name }} </span>
<!-- 													 <input type="text" -->
<!-- 														class="form-control" -->
<!-- 														:value="JSON.parse(location.county).name" -->
<!-- 														placeholder="County" required> -->
												</div>
											</div>
											
											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Working Days and Hours</label>
													<span class="form-control">@{{ location.business_hours }} </span>
<!-- 													<textarea class="form-control" -->
<!-- 														:id="'business_hours' + (index + 1)" -->
<!-- 														:name="'business_hours' + (index + 1)" -->
<!-- 														placeholder="Working Days and Hours">@{{location.business_hours}}</textarea> -->
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
								<div class="row" >
									<div class="col-md-12 my-2 profile-border-div mb-4" 
										v-for="(contact, index) in contacts">
										
										<h5 class="locationLabel card-title" v-if="contacts.length > 1">Contact Details @{{ index +
											1 }}</h5>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Contact Name</label>
													<span class="form-control">@{{ contact.contact_name }} </span>
<!-- 													 <input type="text" -->
<!-- 														class="form-control" :id="'contact_name' + (index + 1)" -->
<!-- 														:name="'contact_name' + (index + 1)" -->
<!-- 														:value="contact.contact_name" placeholder="Contact Name" -->
<!-- 														required> -->
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Contact number</label> 
													<span class="form-control">@{{ contact.contact_phone }} </span>
<!-- 													<input type="text" -->
<!-- 														class="form-control" :id="'contact_number' + (index + 1)" -->
<!-- 														:value="contact.contact_phone" -->
<!-- 														placeholder="Contact Number" required> -->
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Contact email</label>
													<span class="form-control">@{{ contact.contact_email }} </span>
<!-- 													 <input type="email" -->
<!-- 														class="form-control" :id="'contact_email' + (index + 1)" -->
<!-- 														:value="contact.contact_email" -->
<!-- 														placeholder="Contact Email Address" required> -->
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group bmd-form-group">
													<label>Location</label>
													<span class="form-control">@{{ contact.contact_location }} </span> 
<!-- 													<input type="text" -->
<!-- 														class="form-control" :value="contact.contact_location" -->
<!-- 														placeholder="Location" required> -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- 					<div class="card"> -->
					<!-- 						<div class="card-header card-header-profile-border "> -->
					<!-- 							<div class="col-md-12 pl-3"> -->
					<!-- 								<h4 >Shopify Details </h4> -->
					<!-- 							</div> -->
					<!-- 						</div> -->
					<!-- 						<div class="card-body"> -->
					<!-- 							<div class="container"> -->
					<!-- 								<div class="row" @click="changeCurrentTap('contact')"> -->
					<!-- 									<div class="col-md-12"> -->
					<!-- 										<div class="row"> -->
					<!-- 											<div class="col-sm-6"> -->
					<!-- 												<div class="form-group bmd-form-group"> -->
					<!-- 													<label>Shop URL</label> <input type="text" -->
					<!-- 														class="form-control" -->
					<!-- 														value="{{$singleRequest->shopify_store_domain}}" -->
					<!-- 														placeholder="Shop URL" required> -->
					<!-- 												</div> -->
					<!-- 											</div> -->

					<!-- 											<div class="col-sm-6"> -->
					<!-- 												<div class="form-group bmd-form-group"> -->
					<!-- 													<label>App API key</label> <input type="text" -->
					<!-- 														class="form-control" -->
					<!-- 														value="{{$singleRequest->shopify_app_api_key}}" -->
					<!-- 														placeholder="App API key" required> -->
					<!-- 												</div> -->
					<!-- 											</div> -->

					<!-- 											<div class="col-sm-6"> -->
					<!-- 												<div class="form-group bmd-form-group"> -->
					<!-- 													<label>App Password</label> <input type="text" -->
					<!-- 														class="form-control" -->
					<!-- 														value="{{$singleRequest->shopify_app_password}}" -->
					<!-- 														placeholder="App Password" required> -->
					<!-- 												</div> -->
					<!-- 											</div> -->

					<!-- 											<div class="col-sm-6"> -->
					<!-- 												<div class="form-group bmd-form-group"> -->
					<!-- 													<label>App Secret</label> <input type="text" -->
					<!-- 														class="form-control" -->
					<!-- 														value="{{$singleRequest->shopify_app_secret}}" -->
					<!-- 														placeholder="App Secret" required> -->
					<!-- 												</div> -->
					<!-- 											</div> -->
					<!-- 										</div> -->
					<!-- 									</div> -->
					<!-- 								</div> -->
					<!-- 							</div> -->
					<!-- 						</div> -->
					<!-- 					</div> -->

					<div class="card"
						style="background-color: transparent; box-shadow: none;">
						<div class="card-body p-0">
							<div class="container w-100" style="max-width: 100%">

								<div class="row justify-content-center">
									<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
										<form id="order-form" method="POST"
											action="{{route('post_doorder_retailers_single_request', ['doorder', $singleRequest->id])}}">
											{{csrf_field()}}
											<button class="btnDoorder btn-doorder-primary  mb-1">Accept</button>
										</form>
									</div>

									<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
										<button class="btnDoorder btn-doorder-danger-outline  mb-1"
											data-toggle="modal" data-target="#rejection-reason-modal">Reject</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Rejection Reason modal -->
					<div class="modal fade" id="rejection-reason-modal" tabindex="-1"
						role="dialog" aria-labelledby="assign-deliverer-label"
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
									<div class="text-center">
										<form id="request-rejection" method="POST"
											action="{{route('post_doorder_retailers_single_request', ['doorder', $singleRequest->id])}}">
											{{csrf_field()}}
											<img src="{{asset('images/doorder-new-layout/reject-img.png')}}"
													 alt="Reqject">
											<div class="modal-dialog-header modalHeaderMessage">Rejected</div>
											
											<div class="form-group bmd-form-group">
												<label  class="modal-dialog-header modalSubHeaderMessage">Please add reason for rejection</label>
												<textarea class="form-control" name="rejection_reason"
													rows="4" required></textarea>
											</div>
										</form>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-primary mb-1"
											onclick="$('form#request-rejection').submit()">Send</button>
									</div>
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-danger-outline mb-1"
											data-dismiss="modal">Close</button>
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
        var app = new Vue({
            el: '#app',
            data: {
               
                    locations: JSON.parse({!! json_encode($singleRequest->locations_details) !!}),
                    contacts: JSON.parse({!! json_encode($singleRequest->contacts_details) !!}),
                
            },
        });
    </script>
@endsection
