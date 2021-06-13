@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.iti {
	width: 100%;
}

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}

.card-title.customerProfile {
	display: inline-block;
}

.addContactDetailsCircle {
	color: #d58242;
	font-size: 18px;
}

.removeContactDetailsCircle {
	color: #df5353;
	font-size: 18px;
}
</style>
@endsection @section('title','Unified | Customer ' . $customer->name)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)
					<form id="customer-form" method="POST"
						action="{{route('unified_postCustomerSingleEdit', ['unified', $customer->id])}}"
						@submit="onSubmitForm">
						@endif {{csrf_field()}} <input type="hidden" name="customer_id"
							value="{{$customer->id}}">
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Customer.png')}}"
											style="width: 42px !important; height: 32px !important;">
									</div>
									<h4 class="card-title customerProfile">{{$customer->name}}</h4>
								</div>
								@if($readOnly==1)
								<div class="col-6 col-md-4 mt-4">
									<div class="row justify-content-end">
										<a class="btn btn-unified-primary btn-import"
											href="{{url('unified/customers/edit')}}/{{$customer->id}}">
											Edit customer </a>
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
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Name</label> <input type="text" class="form-control"
													name="name" placeholder="Name" value="{{$customer->name}}"
													required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="" style="margin-top: 15px">
												<label class="labelRadio col-12" for="">Contract</label>
												<div class="col-12 row">
													<div class="col">
														<div class="form-check form-check-radio">
															<label class="form-check-label"> <input
																class="form-check-input" type="radio"
																id="exampleRadios2" name="contract" value="1"
																{{$customer->contract ? 'checked' : ''}} required
																onclick="clickContract(1)"> Yes <span class="circle"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
													</div>
													<div class="col">
														<div class="form-check form-check-radio">
															<label class="form-check-label"> <input
																class="form-check-input" type="radio"
																id="exampleRadios1" name="contract" value="0"
																{{$customer->contract=='0' ? 'checked' : ''}} required
																onclick="clickContract(0)"> No <span class="circle"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row" id="contractDateDiv">
										@if($customer->contract=='1')
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Contract start date</label> <input type="text"
													id="contractStartDate" class="form-control"
													name="contractStartDate" value="{{$customer->contractStartDate}}"
													placeholder="Select contract start date" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Contract end date</label> <input type="text"
													id="contractEndDate" class="form-control"
													name="contractEndDate" value="{{$customer->contractEndDate}}"
													placeholder="Select contract end date" required>
											</div>
										</div>
										@endif
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Product type</label> <select class="form-control"
													id="serviceTypeSelect" name="serviceTypeSelect"
													multiple="multiple"> @if(count($serviceTypes) > 0)
													@foreach($serviceTypes as $serviceType)
													<option value="{{$serviceType['id']}}">
														{{$serviceType['name']}}</option> @endforeach @endif
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Address</label>
												<textarea class="form-control" name="address" id="address"
													placeholder="Address" required> {{$customer->address}} </textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Postcode</label> <input type="text"
													class="form-control" name="postcode" placeholder="Postcode"
													value="{{$customer->post_code}}" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Company phone number</label> <input type="tel"
													class="form-control" name="companyPhoneNumner"
													id="companyPhoneNumner" placeholder="Company phone number"
													value="{{$customer->phone}}" required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card" v-for="(contact, index) in contactDetailss"
							:id="'contactCardDiv'+(index)">

							<div class="card-body cardBodyAddContactDetails">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<h5 class="card-title customerProfile">Contact Details</h5>
											<span v-if="index==0"> <i
												class="fas fa-plus-circle addContactDetailsCircle"
												style="cursor: pointer; margin-left: 5px;"
												@click="addContactDetails()"></i>
											</span> <span v-else> <i
												class="fas fa-minus-circle removeContactDetailsCircle"
												style="cursor: pointer; margin-left: 5px;"
												@click="removeContactDetails(index)"></i>
											</span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Contact name</label> <input type="text"
													class="form-control" :name="'contactName'+ (index)"
													:id="'contactName'+ (index)" v-model="contact.contactName"
													placeholder="Contact name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Position</label> <input type="text"
													class="form-control" :name="'position'+ (index)"
													:id="'position'+ (index)" v-model="contact.position"
													placeholder="Position" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Contact number</label> <input type="tel"
													class="form-control" :name="'contactNumber'+(index)"
													id="'contactNumber'+(index)"
													v-model="contact.contactNumber"
													placeholder="Contact number" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Contact email</label> <input type="text"
													class="form-control" :name="'contactEmail'+(index)"
													id="'contactEmail'+(index)" v-model="contact.contactEmail"
													placeholder="Contact email" required>
											</div>
										</div>
									</div>

									<input type="hidden" name="contact_detailss"
										v-model="contactDetailssString">
								</div>
							</div>
						</div>


						@if($readOnly==0)
						<div class="row ">
							<div class="col-md-4 offset-md-2 text-center">

								<button class="btn btn-unified-primary singlePageButton">Save</button>
							</div>
							<div class="col-md-4 text-center">
								<button class="btn btn-unified-danger singlePageButton"
									type="button" data-toggle="modal"
									data-target="#delete-customer-modal">Delete</button>
							</div>
						</div>
						<input type="hidden" name="serviceTypeSelectValues"
							id="serviceTypeSelectValues">
					</form>
					@endif
					<!-- Delete modal -->

					<!-- delete customer modal -->
					<div class="modal fade" id="delete-customer-modal" tabindex="-1"
						role="dialog" aria-labelledby="delete-deliverer-label"
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

										<form method="POST" id="delete-customer"
											action="{{url('unified/customers/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="customerId" name="customerId"
												value="{{$customer->id}}" />
										</form>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-around">
									<button type="button"
										class="btn  btn-unified-primary modal-btn"
										onclick="$('form#delete-customer').submit()">Yes</button>
									<button type="button" class="btn  btn-unified-danger modal-btn"
										data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
					<!-- end delete customer modal -->
				</div>
			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts')

<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script>

	var app = new Vue({
		el: '#app',
		data: {

			contactDetailss: {!! old('contact_detailss') ? old('contact_detailss') : $customer->contacts !!},
			contactDetailssString: ''
		},
		methods: {
    		addContactDetails() {
    				this.contactDetailss.push({
    					contactName: '',
    					position: '',
    					contactNumber: '',
    					contactEmail:''
    				})
    			},
    			removeContactDetails(index){
    				this.contactDetailss.splice(index, 1);
    			},
			onSubmitForm(e) {
				e.preventDefault();
				$('#serviceTypeSelectValues').val(JSON.stringify($('#serviceTypeSelect').val()));
				this.contactDetailssString = JSON.stringify(this.contactDetailss);
				setTimeout(() => {
					$('#customer-form').submit();
				}, 300);
			}
		}
	});

$( document ).ready(function() {

	var readonly = {!! $readOnly !!};
	if(readonly==1){
	$("input").prop('disabled', true);
	$("textarea").prop('disabled', true);
	$("select").prop('disabled', true);
	}
	$("#serviceTypeSelect").select2({
	  placeholder: 'Select service type',
	  tags: true
	}).val({!! json_encode($customer->selectedServiceType) !!}).change();

	
	addIntelInput('companyPhoneNumner','companyPhoneNumner');
	
	function onSubmitForm() {
		console.log($('#serviceTypeSelect').val());
	}
	

});
   

function clickContract(val){

	console.log("click contract "+val)
	if(val==1){
		$('#contractDateDiv').html('<div class="col-md-6"> 	<div class="form-group bmd-form-group"> '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDate" class="form-control" '
            						+' name="contractStartDate" value="" placeholder="Select contract start date" required> </div>	</div>'
            						+' <div class="col-md-6"> <div class="form-group bmd-form-group">  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDate" class="form-control" name="contractEndDate" value="" '
            						+' placeholder="Select contract end date" required> </div> </div>');
        		
            	$(' #contractStartDate, #contractEndDate').datetimepicker({
                         format: 'L', 
                        icons: { time: "fa fa-clock",
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
	else{
        $(' #contractDateDiv').html('');
	}

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
  //Map Js
		window.initAutoComplete = function initAutoComplete() {
			//Autocomplete Initialization
			let location_input = document.getElementById('address');
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

					document.getElementById("address_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
				}
			});
		}
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initAutoComplete"></script>

@endsection
