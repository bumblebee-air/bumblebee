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
		method="POST" enctype="multipart/form-data" autocomplete="off">
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
											name="contact_through[]" id="whatsapp" value="whatsapp"
											v-model="contact_through"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> Whatsapp</label>
									</div>
								</div>
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="sms" value="sms"
											v-model="contact_through"> <span id="check"
											class="my-check-box"> <i class="fas fa-check-square"></i>
										</span> SMS</label>
									</div>
								</div>
								<div class="contact-through d-flex pr-5">
									<div class="form-check">
										<label class="contactUsLabel"><input type="checkbox"
											class="form-check-input contactThroughInput"
											name="contact_through[]" id="email" value="email"
											v-model="contact_through"> <span id="check"
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

<script>
   $(document).ready(function() {
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
       
    </script>
@endsection
