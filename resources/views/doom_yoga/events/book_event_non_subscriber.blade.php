@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Event
Booking') @section('styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.iti {
	width: 100%;
}
</style>
@endsection @section('content')

<div class="container registerDoomYogaDiv" id="app">
	<form action="{{route('postYogaSignupEventBooking', 'doom_yoga')}}"
		method="POST" enctype="multipart/form-data" autocomplete="off" id="customer_form" @submit="createStripeToken">
		{{csrf_field()}}
		<div class="main main-raised">
			<div class="h-100 row align-items-center">
				<div class="col-md-12 text-center">
					<img src="{{asset('images/doom-yoga/doom-yoga-logo.png')}}"
						width="160" style="height: 150px" alt="DoomYoga">
					<h4 class="eventDetailsTitle mt-2">Event Details</h4>
				</div>
			</div>
			<div class="container">

				@if(count($errors))
				<div class="alert alert-danger" role="alert">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li> @endforeach
					</ul>
				</div>
				@endif
				<input type="hidden" name="id" value="{{$event->id}}">

				<div class="row">

					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Event name</label>
							<p class="eventDetailsSpan">{{ $event->name}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Description</label>
							<p class="eventDetailsSpan">{{ $event->short_description}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Date & Time</label>
							<p class="eventDetailsSpan">{{ \Carbon\Carbon::parse($event->date_Time)->format('Y/m/d H:m A')}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Place</label>
							<p class="eventDetailsSpan">{{ $event->place}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Duration</label>
							<p class="eventDetailsSpan">{{ $event->duration}} Mins</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Level</label>
							<p class="eventDetailsSpan">{{ $event->level}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="eventDetailsLabel">Price per class</label>
							<p class="eventDetailsSpan">£{{ $event->price}}</p>
						</div>
					</div>
				</div>

				<div class="section">
					<h4 class="registerTitle">A Bit About You</h4>
				</div>
				<div class="row">

					<div class="col-md-12">
						<div class="form-group bmd-form-group filledInputDiv ">
							<label class="bmd-label-floating">Phone number</label> <input
								type="tel" class="form-control" id="phone_number"
								name="phone_number" value="{{old('phone_number')}}" required>
						</div>
					</div>


					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Password</label> <input type=""
								class="form-control" name="password" value="{{old('password')}}"
								required autocomplete="new-password">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group  "
							style="padding-bottom: 0 !important;">
							<label class="contactUsThroughLabel">Contact Us Through </label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<div class="d-flex">
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="whatsapp" value="whatsapp"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> Whatsapp</label>
									</div>
								</div>
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="sms" value="sms"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> SMS</label>
									</div>
								</div>
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="email" value="email"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> Email</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="section">
					<h4 class="registerTitle">Payment Details</h4>
				</div>

				<div class="row">

{{--					<div class="col-md-12">--}}
{{--						<div class="form-group bmd-form-group">--}}
{{--							<label class="bmd-label-floating">Card holder name</label> <input--}}
{{--								type="text" class="form-control" name="card_holder_name"--}}
{{--								value="{{old('card_holder_name')}}" required>--}}
{{--						</div>--}}
{{--					</div>--}}
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">MM/YY</label> <input
								type="text" class="form-control" id="card_expiry" maxlength="5" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">CVC</label> <input type="text"
								class="form-control" id="cvc_number" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Card number</label>
							<input type="text" class="form-control" id="card_number">
						</div>
					</div>
					<div class="col-12 col-md-4 offset-md-4 mb-3 text-center">
						<img src="{{asset('images/doom-yoga/stripelogo.png')}}"
							style="width: 300px; max-width: 100%;" alt="Pay With Stripe">

					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-12 mb-1 ">
						<p class="terms">
							By clicking Sign up, you agree to our <a class="terms-text"
								href="#">Terms & Conditions</a> and that you have read our <a
								class="terms-text" href="#">Privacy Policy</a>
						</p>
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

			</div>
		</div>
		<div class="row mt-3 mb-1">
			<div class="col-12 col-md-4 offset-md-4 mb-1 submit-container">
				<button class="btn btn-doomyoga-login btn-login" type="submit">Sign
					up</button>
			</div>
		</div>
	</form>

</div>
@endsection @section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>

<script>
$(document).ready(function() {
	$('b[role="presentation"]').hide();
	$('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');
	addIntelInput('phone_number','phone_number');

	var expiryMask = function() {
		var inputChar = String.fromCharCode(event.keyCode);
		var code = event.keyCode;
		var allowedKeys = [8];
		if (allowedKeys.indexOf(code) !== -1) {
			return;
		}

		event.target.value = event.target.value.replace(
				/^([1-9]\/|[2-9])$/g, '0$1/'
		).replace(
				/^(0[1-9]|1[0-2])$/g, '$1/'
		).replace(
				/^([0-1])([3-9])$/g, '0$1/$2'
		).replace(
				/^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2'
		).replace(
				/^([0]+)\/|[0]+$/g, '0'
		).replace(
				/[^\d\/]|^[\/]*$/g, ''
		).replace(
				/\/\//g, '/'
		);
	}

	var splitDate = function($domobj, value) {
		var regExp = /(1[0-2]|0[1-9]|\d)\/(20\d{2}|19\d{2}|0(?!0)\d|[1-9]\d)/;
		var matches = regExp.exec(value);
		$domobj.siblings('input[name$="expiryMonth"]').val(matches[1]);
		$domobj.siblings('input[name$="expiryYear"]').val(matches[2]);
	}

	$('#card_expiry').on('keyup', function(){
		expiryMask();
	});

	$('#card_expiry').on('focusout', function(){
		splitDate($(this), $(this).val());
	});

	//Card number input
	var CardNumberMask = function (value) {
		var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
		var matches = v.match(/\d{4,16}/g);
		var match = matches && matches[0] || ''
		var parts = []

		for (i=0, len=match.length; i<len; i+=4) {
			parts.push(match.substring(i, i+4))
		}

		if (parts.length) {
			return parts.join(' ')
		} else {
			return value
		}
	}

	$('#card_number').on('keyup', function(e){
		$(this).val(CardNumberMask(e.target.value))
	});
});

new Vue({
	el: '#app',
	data() {

	},
	mounted() {
		//**********Elements making a conflicts with the design********

		{{--this.stripe = Stripe("{{env('STRIPE_PUBLIC_KEY')}}");--}}

		{{--var elements = this.stripe.elements({--}}
		{{--	fonts: [--}}
		{{--		{--}}
		{{--			cssSrc: 'https://fonts.googleapis.com/css?family=Roboto',--}}
		{{--		},--}}
		{{--	],--}}
		{{--	// Stripe's examples are localized to specific languages, but if--}}
		{{--	// you wish to have Elements automatically detect your user's locale,--}}
		{{--	// use `locale: 'auto'` instead.--}}
		{{--	locale: 'auto'--}}
		{{--});--}}

		{{--var elementStyles = {--}}
		{{--	iconStyle: "solid",--}}
		{{--	style: {--}}
		{{--		base: {--}}
		{{--			iconColor: "#fff",--}}
		{{--			color: "#fff",--}}
		{{--			fontWeight: 400,--}}
		{{--			fontFamily: "Helvetica Neue, Helvetica, Arial, sans-serif",--}}
		{{--			fontSize: "16px",--}}
		{{--			fontSmoothing: "antialiased",--}}
		{{--			borderBottom: "solid 1px #eaecef",--}}
		{{--			padding: "10px",--}}

		{{--			"::placeholder": {--}}
		{{--				color: "#BFAEF6"--}}
		{{--			},--}}
		{{--			":-webkit-autofill": {--}}
		{{--				color: "#fce883"--}}
		{{--			}--}}
		{{--		},--}}
		{{--		invalid: {--}}
		{{--			iconColor: "#FFC7EE",--}}
		{{--			color: "#FFC7EE"--}}
		{{--		}--}}
		{{--	}--}}
		{{--};--}}

		{{--var elementClasses = {--}}
		{{--	focus: 'focus',--}}
		{{--	empty: 'empty',--}}
		{{--	invalid: 'invalid',--}}
		{{--};--}}

		{{--this.cardNumber = elements.create('cardNumber', {--}}
		{{--	style: elementStyles,--}}
		{{--	classes: elementClasses,--}}
		{{--});--}}
		{{--// Add an instance of the card Element into the `card-element` <div>--}}
		{{--this.cardNumber.mount('#card_number');--}}

		{{--this.cardExpiry = elements.create('cardExpiry', {--}}
		{{--	style: elementStyles,--}}
		{{--	classes: elementClasses,--}}
		{{--});--}}

		{{--this.cardExpiry.mount('#card-expiry');--}}

		{{--this.cardCvc = elements.create('cardCvc', {--}}
		{{--	style: elementStyles,--}}
		{{--	classes: elementClasses,--}}
		{{--});--}}
		{{--this.cardCvc.mount('#cvc_number');--}}


	},
	methods: {
		createStripeToken(e) {
			e.preventDefault();
			let expiry_data = $('#card_expiry').val().split("/");
			let exp_month = expiry_data[0]
			let exp_year = expiry_data[1]


			if (exp_month == undefined || exp_year == undefined) {
				alert('The expiry date is invalid.');
			}
			Stripe.setPublishableKey("{{env('STRIPE_PUBLIC_KEY')}}");
			Stripe.createToken({
				number: $('#card_number').val(),
				cvc: $('#cvc_number').val(),
				exp_month: exp_month,
				exp_year: exp_year
			}, this.stripeResponseHandler);

		},
		stripeResponseHandler(status, response) {
			console.log(response)
			if (response.error) {
				alert(response.error.message);
			} else {
				// token contains id, last4, and card type
				var token = response['id'];
				// insert the token into the form so it gets submitted to the server
				let form = $('#customer_form')
				form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
				$('stripeToken').val = token;
				form.get(0).submit();
			}
		}
	}
})
    
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
       
</script>
@endsection
