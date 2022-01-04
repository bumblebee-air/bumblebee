@extends('templates.garden_help') @section('title', 'GardenHelp |
Customers Registration') @section('styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.iti {
	width: 100%;
}

.tip-button {
	color: #60a244;
	background-color: white;
	cursor: pointer;
	margin-left: 5px;
}

#tip {
	width: 347px;
	padding: 11px 5px;
	border-radius: 10px;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #60a244;
	color: white;
	z-index: 9999;
	margin-top: 10px !important;
	margin-left: 10px !important;
	display: none;
}

.modal .modal-dialog {
	margin-top: 50px;
}

.loginH6 {
	font-family: Roboto;
	font-style: normal;
	font-weight: 500;
	font-size: 18px;
	line-height: 21px;
	/* identical to box height */
	color: #5E5873;
	text-transform: capitalize;
}

.bg-cover {
	background-image:
		url("../../images/gardenhelp_icons/login-background.png");
	min-height: 100vh;
}

input.form-control {
	/* 	background-color: transparent; */
	/*  	box-shadow: none !important;  */
	/* 	border-bottom: 1px solid #979797; */
	padding-left: 10px;
	padding-right: 10px;
}

@media screen and (min-width: 900px) {
	.card-login {
		padding: 20px 50px;
	}
}

.input-group-text {
	color: #aaa;
	padding-left: 0;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%)
}

.my-check-box {
	width: 20px;
	height: 20px;
}

.my-check-box i {
	font-size: 20px
}

.form-group label {
	position: initial !important;
}
.is-focused{
    box-shadow: none;
}
</style>
@endsection @section('content')

<div class="bg-cover h-100">
	<div class="row h-100 m-0">
		<div class="col-lg-8 col-md-6 col-sm-8 mx-auto my-auto">
			<div class="container" id="app">
				<div class="card card-login">
					<form action="{{route('postCustomerRegistration', 'garden-help')}}"
						method="POST" enctype="multipart/form-data" autocomplete="off"
						@submit="submitForm" id="customer-registration-form">
						{{csrf_field()}}
						<div class="card-header text-center">
							<img class="img-fluid"
								src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
								alt="GardenHelp Logo" style="height: 165px;">

						</div>
						<div class="card-body">

							@if(count($errors))
							<div class="alert alert-danger" role="alert">
								<ul>
									@foreach ($errors->all() as $error)
									<li>{{$error}}</li> @endforeach
								</ul>
							</div>
							@endif

							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<h6 class="loginH6">Create Account</h6>
									</div>

								</div>

								<div class="row">

									<div class="col-md-12">
										<div class="form-group bmd-form-group  my-1">
											<label class="form-label">Name</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fas fa-user"></i>
													</span>
												</div>
												<input type="text" class="form-control" name="name"
													value="{{old('name')}}" required>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group bmd-form-group">
											<label>Email address</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fas fa-envelope"></i>
													</span>
												</div>
												<input type="email" class="form-control" name="email"
													value="{{old('email')}}" required>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group bmd-form-group">
											<label>Phone</label>
											<!-- 											<div class="input-group"> -->
											<!-- 												<div class="input-group-prepend"> -->
											<!-- 													<span class="input-group-text"><i class="fas fa-mobile"></i> -->
											<!-- 													</span> -->
											<!-- 												</div> -->
											<input type="tel" class="form-control" id="phone"
												name="phone" value="{{old('phone')}}" required>
											<!-- 											</div> -->
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group bmd-form-group">
											<label>Password</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"> <i class="material-icons">lock_outline</i>
													</span>
												</div>
												<input type="password" class="form-control" name="password"
													value="{{old('password')}}" required>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group bmd-form-group">
											<label>Confirm password</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text"> <i class="material-icons">lock_outline</i>
													</span>
												</div>
												<input type="password" class="form-control"
													name="password_confirmation"
													value="{{old('password_confirmation')}}" required>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group bmd-form-group">
											<label>Contact through</label>
											<div class="row">
												<div class="col">
													<div class="contact-through d-flex pr-5"
														@click="changeContact('phone')">
														<div id="check"
															:class="contact_through == 'phone' ? 'my-check-box checked' : 'my-check-box'">
															<i class="fas fa-check-square"></i>
														</div>
														<label class="form-check-label">Phone number</label>
													</div>
												</div>

												<div class="col">
													<div class="contact-through d-flex"
														@click="changeContact('email')">
														<div id="check"
															:class="contact_through == 'email' ? 'my-check-box checked' : 'my-check-box'">
															<i class="fas fa-check-square"></i>
														</div>
														<label class="form-check-label">Email</label>
													</div>
												</div>
											</div>

											<input type="hidden" v-model="contact_through"
												name="contact_through">
										</div>
									</div>

								</div>


								<div class="row mt-4">
									<div class="col-md-12 mb-3">
										<p class="terms">
											By clicking Submit, you agree to our <a class="terms-text"
												target="_blank" href="{{$termsFile}}">Terms & Conditions</a>
											and that you have read our <a class="terms-text"
												target="_blank" href="{{$privacyFile}}">Privacy Policy</a>
										</p>
									</div>
								</div>
							</div>
							<div class="row">

								<div class="col-md-12 mb-3 submit-container">
									<button class="btn btn-gardenhelp-green btn-register"
										type="submit">Sign up</button>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://js.stripe.com/v3/"></script>

<script>
        var polygons_array = [];
        var total_size = 0;
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
        let icon = document.getElementById('is_parking_hint')
        let tooltip = document.getElementById('is_parking_tooltip')
        Popper.createPopper(icon, tooltip, {
            placement: 'right',
        });
        
        
                    addIntelInput('phone', 'phone');
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
    
        var app = new Vue({
            el: '#app',
            data: {
                type_of_work: '',
                service_types: {!! json_encode($services) !!},
                is_first_time: '',
                is_parking_site: '',
                contact_through: '',
                service_types_input: '',
                site_details_input: '',
                property_photo_input: '',
                service_types_json: [],
                is_recurring: ''
            },
            mounted() {
//                 if (this.type_of_work == 'Commercial') {
//                     $('#available_date_time').datetimepicker({
//                         icons: {
//                             time: "fa fa-clock",
//                             date: "fa fa-calendar",
//                             up: "fa fa-chevron-up",
//                             down: "fa fa-chevron-down",
//                             previous: 'fa fa-chevron-left',
//                             next: 'fa fa-chevron-right',
//                             today: 'fa fa-screenshot',
//                             clear: 'fa fa-trash',
//                             close: 'fa fa-remove'
//                         }
//                     });
//                     this.addIntelInput('contact_number', 'contact_number');
//                 } else if (this.type_of_work == 'Residential') {
                   
//                     this.addIntelInput('phone', 'phone');
//                 }
            },
            methods: {
                changeContact(value) {
                    this.contact_through = value;
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                changeWorkType() {
                    if ($("#type_of_work").val() == 'Residential') {
                        setTimeout(() => {
                            this.addIntelInput('phone', 'phone');
                        }, 500)
                    } else {
                        setTimeout(() => {
                        	 window.initAutoComplete();
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
                            
                        },500);
                    }
                },
                submitForm(e) {
                    e.preventDefault();
                    setTimeout(function () {
                        $('#customer-registration-form').submit();
                    }, 300);
                }
            }
        });
        
        
        
                window.initMap = function initMap() {
                           console.log("ssss")
                    //Autocomplete Initialization
                    let location_input = document.getElementById('location');
                    //Mutation observer hack for chrome address autofill issue
                    if(location_input != null){
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
            
//                                 locationMarker.setPosition({lat: place_lat, lng: place_lon})
//                                 locationMarker.setVisible(true);
            
                                //Fit Bounds
//                                 let bounds = new google.maps.LatLngBounds();
//                                 bounds.extend({lat: place_lat, lng: place_lon})
//                                 this.map.fitBounds(bounds);
            
                                document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
                            }
                        });
                     }   
       }     

     </script>

@endsection
