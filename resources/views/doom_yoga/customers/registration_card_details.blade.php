@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Customers
Registration') @section('styles') @endsection @section('content')

<div class="container registerDoomYogaDiv" id="app">
	<form action="{{route('postCustomerRegistrationCardForm', 'doom_yoga')}}"
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
								type="text" class="form-control" name="expire_date"
								value="{{old('expire_date')}}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">CVV</label> <input type="text"
								class="form-control" id="cvv_number" name="cvv_number"
								value="{{old('cvv_number')}}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Card number</label> <input
								type="text" class="form-control" name="card_number"
								value="{{old('card_number')}}" required>
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
		<div class="row">
			<div class="col-12 col-md-4 offset-md-4 mb-3 submit-container">
				<button class="btn btn-doomyoga-primary " type="submit">Sign up</button>
			</div>
		</div>
	</form>

</div>
@endsection @section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script>
   
        
        var app = new Vue({
            el: '#app',
            data: {
				contact_through: '',
            },
            mounted() {
                
            },
            methods: {
                
               

            }
        }); 
    </script>
@endsection
