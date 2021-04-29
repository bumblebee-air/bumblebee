@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Customers
Registration') @section('styles') @endsection @section('content')

<div class="container registerDoomYogaDiv" id="app">
	<form action="{{route('postCustomerRegistrationCardForm', 'doom_yoga')}}" id="payment-form"
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
					<h4 class="registerTitle">Card Details</h4>
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
					<input type="hidden" name="customer_id" value="{{$customer_id}}">
					<input type="hidden" name="price_id" value="{{$price_id}}">

					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Card holder name</label> <input
								type="text" class="form-control" name="card_holder_name"
								value="{{old('card_holder_name')}}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">MM/YY</label> <input
								type="text" class="form-control" id="expire_date" name="expire_date"
								value="{{old('expire_date')}}" maxlength="5" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">CVV</label>
							<input type="text" class="form-control" id="cvc_number" name="cvc_number"
								value="{{old('cvc_number')}}" required maxlength="4">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Card number</label>
							<input type="text" class="form-control" id="card_number" name="card_number"
								value="{{old('card_number')}}" required maxlength="19">

						</div>
					</div>
					<div class="col-12 col-md-4 offset-md-4 mb-3 text-center">
						<img src="{{asset('images/doom-yoga/stripelogo.png')}}"
								style="width:300px; max-width: 100%;" alt="Pay With Stripe">

					</div>
				</div>

			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-12 mb-1 ">
				<p class="terms">
					By clicking Sign up, you agree to our <a class="terms-text" href="#">Terms
						& Conditions</a> and that you have read our <a
						class="terms-text" href="#">Privacy Policy</a>
				</p>
			</div>
		</div>
		<div class="row mt-5 mb-3">
			<div class="col-12 col-md-4 offset-md-4 mb-3 submit-container">
				<button class="btn btn-doomyoga-login btn-login" type="submit">Sign up</button>
			</div>
		</div>
	</form>

</div>
@endsection
@section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script src="https://js.stripe.com/v2/"></script>

<script>
	$(document).ready(function () {
		$('#card_number').keyup(function (event) {
			if (event.target.value !== '') {
				$('#card_number').val(cc_format(event.target.value));
			}
		});

		$('#expire_date').keyup(function (event) {
			if (event.target.value !== '') {
				$('#expire_date').val(formatString(event));
			}
		});

		$('#payment-form').submit(function (event) {
			event.preventDefault();
			stripeCreateToken();
		});

		function formatString(e) {
			var inputChar = String.fromCharCode(e.keyCode);
			var code = e.keyCode;
			var allowedKeys = [8];
			if (allowedKeys.indexOf(code) !== -1) {
				return;
			}

			return e.target.value.replace(
					/^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
			).replace(
					/^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
			).replace(
					/^([0-1])([3-9])$/g, '0$1/$2' // 13 > 01/3
			).replace(
					/^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
			).replace(
					/^([0]+)\/|[0]+$/g, '0' // 0/ > 0 and 00 > 0
			).replace(
					/[^\d\/]|^[\/]*$/g, '' // To allow only digits and `/`
			).replace(
					/\/\//g, '/' // Prevent entering more than 1 `/`
			);
		}

		function cc_format(value) {
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

		function stripeTokenHandler(token) {
			console.log(token)
			// Insert the token ID into the form so it gets submitted to the server
			document.createElement('input');
			var form = document.getElementById('payment-form');
			var hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'stripeToken');
			hiddenInput.setAttribute('value', token);
			form.appendChild(hiddenInput);
			// Submit the form

			setTimeout(form.submit(), 300);

		}

		function stripeResponseHandler(code, result) {
			if (result.error) {
				// Inform the user if there was an error
				// var errorElement = document.getElementById('card-errors');
				// errorElement.textContent = result.error.message;
				alert(result.error.message);
			} else {
				// Send the token to your server
				stripeTokenHandler(result.id);
			}
		}

		function stripeCreateToken() {
			Stripe.setPublishableKey("{{env('STRIPE_PUBLIC_KEY')}}");
			Stripe.createToken({
				number: $('#card_number').val(),
				cvc: $('#cvc_number').val(),
				exp_month: $('#expire_date').val().split('/')[0],
				exp_year: $('#expire_date').val().split('/')[1],
			}, stripeResponseHandler);
			// stripe.createToken(cardNumber).then(function(result) {
			// 	if (result.error) {
			// 		// Inform the user if there was an error
			// 		var errorElement = document.getElementById('card-errors');
			// 		errorElement.textContent = result.error.message;
			// 		alert(result.error.message);
			// 	} else {
			// 		// Send the token to your server
			// 		stripeTokenHandler(result.token);
			// 	}
			// });
		}
	})
</script>
@endsection
