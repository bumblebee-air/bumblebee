@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Customers
Registration') @section('styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.iti {
	width: 100%;
}

.fa-circle {
	color: #fff;
	line-height: 7;
	font-size: 15px
}

input[type="radio"] {
	display: none;
}

.radioLabel {
	height: 180px;
	width: 240px;
	border: 6px solid #18f98d
}

input[type="radio"]:checked+div .subscriptionRowDiv {
	background: linear-gradient(to bottom, #65dde2, #b850b8) !important;;
}

input[type="radio"]:checked+div i, input[type="radio"]:checked+div i:before
	{
	color: #fff;
	font-weight: 900;
}
</style>
@endsection @section('content')

<div class="container registerDoomYogaDiv" id="app">
	<form action="{{route('postCustomerRegistrationForm', 'doom_yoga')}}"
		method="POST" enctype="multipart/form-data" autocomplete="off">
		{{csrf_field()}}
		<div class="main main-raised">
			<div class="h-100 row align-items-center">
				<div class="col-md-12 text-center">
					<img src="{{asset('images/doom-yoga/doom-yoga-logo.png')}}"
						width="160" style="height: 150px" alt="DoomYoga">
				</div>
			</div>
			<div class="container">
				<div class="section">
					<h4 class="registerTitle">A Bit About You</h4>
				</div>
				@if(count($errors))
				<div class="alert alert-danger" role="alert">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li> @endforeach
					</ul>
				</div>
				@endif

				<div class="row">

					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">First name</label> <input
								type="text" class="form-control" name="fisrt_name"
								value="{{old('fisrt_name')}}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Last name</label> <input
								type="text" class="form-control" name="last_name"
								value="{{old('last_name')}}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group filledInputDiv ">
							<label class="bmd-label-floating">Phone number</label> <input
								type="tel" class="form-control" id="phone_number"
								name="phone_number" value="{{old('phone_number')}}" required>
						</div>
					</div>


					<div class="col-md-12">
						<div class="form-group formSelectDiv  filledInputDiv">
							<label for="level" class="bmd-label-floating">Level</label> <select
								id="level" name="level"
								class="form-control js-example-basic-single ">
								<option disabled selected value="">Select level</option>
								<option value="Beginner">Beginner</option>
								<option value="Intermediate">Intermediate</option>
								<option value="Advanced">Advanced</option>
							</select>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Email</label> <input
								type="email" class="form-control" name="email"
								value="{{old('email')}}" required autocomplete="false">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Password</label> <input
								type="password" class="form-control" name="password"
								value="{{old('password')}}" required autocomplete="new-password">
						</div>
					</div>
					<div class="col-md-12">
						<h5 class="registerSubTitleContact">Contact Us Through</h5>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<div class="d-flex">
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="whatsapp" value="whatsapp" v-model="contact_through"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> Whatsapp</label>
									</div>
								</div>
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="sms" value="sms" v-model="contact_through"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> SMS</label>
									</div>
								</div>
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="email" value="email" v-model="contact_through"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> Email</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<div class="d-flex">
								<div class="contact-through d-flex ">
									<div class="form-check">
										<label class="getUpdatesLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="get_updates" value="1"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> I want to get updates about upcoming events and classes</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- 					<div class="col-md-12"> -->
					<!-- 						<h5 class="registerSubTitle">Choose Subscription</h5> -->
					<!-- 					</div> -->
					<!-- 					<div class="col-12  mt-2"> -->
					<!-- 						<input type="radio" id="radioInputSubscriptionMonthly" -->
					<!-- 							name="subscription" value="monthly"> -->
					<!-- 						<div> -->
					<!-- 							<label class="form-check-label w-100 px-0" -->
					<!-- 								for="radioInputSubscriptionMonthly"> -->
					<!-- 								<div class="row subscriptionRowDiv"> -->

					<!-- 									<div class="col-1" style="text-align: center"> -->
					<!-- 										<i class="far fa-circle"></i> -->
					<!-- 									</div> -->
					<!-- 									<div class="col-11"> -->
					<!-- 										<h6 class="registerSubscriptionTitleH6">Doom Yoga - Monthly -->
					<!-- 											Subscription</h6> -->
					<!-- 										<p class="registerSubscriptionDetailsP">Gain access to the -->
					<!-- 											music library, class and events</p> -->
					<!-- 										<p class="registerSubscriptionFreeP">Free for 7 days</p> -->
					<!-- 										<p class="registerSubscriptionFeesP">£ 30/month after trial</p> -->
					<!-- 									</div> -->
					<!-- 								</div> -->
					<!-- 							</label> -->
					<!-- 						</div> -->
					<!-- 					</div> -->
					<!-- 					<div class="col-12 mt-2 "> -->
					<!-- 						<input type="radio" id="radioInputSubscriptionAnnual" -->
					<!-- 							name="subscription" value="annual"> -->
					<!-- 						<div> -->
					<!-- 							<label class="form-check-label w-100 px-0" -->
					<!-- 								for="radioInputSubscriptionAnnual"> -->
					<!-- 								<div class="row subscriptionRowDiv"> -->

					<!-- 									<div class="col-1" style="text-align: center"> -->
					<!-- 										<i class="far fa-circle"></i> -->
					<!-- 									</div> -->
					<!-- 									<div class="col-11"> -->
					<!-- 										<h6 class="registerSubscriptionTitleH6">Doom Yoga - Annual -->
					<!-- 											Subscription</h6> -->
					<!-- 										<p class="registerSubscriptionDetailsP">Gain access to the -->
					<!-- 											music library, class and events</p> -->
					<!-- 										<p class="registerSubscriptionFreeP">Free for 7 days</p> -->
					<!-- 										<p class="registerSubscriptionFeesP">£ 300/year after trial</p> -->
					<!-- 									</div> -->
					<!-- 								</div> -->
					<!-- 							</label> -->
					<!-- 						</div> -->
					<!-- 					</div> -->
				</div>

			</div>
		</div>

		<div class="row mt-5 mb-1">
			<div class="col-12 col-md-4 offset-md-4 mb-1 submit-container">
				<button class="btn btn-doomyoga-login btn-login" type="submit">Continue</button>
			</div>
		</div>
		<div class="row mt-2 mb-3">
			<div class="col-12 col-md-4 offset-md-4 mb-3 submit-container text-center">
				<span class="registerSpan" >Guest Checkout</span>
			</div>
		</div>
	</form>

</div>
@endsection @section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2({
        theme: "themes-dark"});
    $('b[role="presentation"]').hide();
    $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');
        addIntelInput('phone_number','phone_number');
    });
       
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
				contact_through: [],
            },
            mounted() {
                
            },
            methods: {
                

            }
        }); 
    </script>
@endsection
