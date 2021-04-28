@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Event
Booking') @section('styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
</style>
@endsection @section('content')

<div class="container registerDoomYogaDiv" id="app">
	<form action="{{route('postYogaEventBooking', 'doom_yoga')}}"
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
				@endif <input type="hidden" name="id" value="{{$event->id}}">
				<div class="row">

					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Event name</label>
							<p class="eventDetailsSpan">{{ $event->event_name}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Description</label>
							<p class="eventDetailsSpan">{{ $event->description}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Date & Time</label>
							<p class="eventDetailsSpan">{{ $event->dateTime}}</p>
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
							<p class="eventDetailsSpan">{{ $event->duration}}</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group ">
							<label class="eventDetailsLabel">Level</label>
							<p class="eventDetailsSpan">{{ $event->level}}</p>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-12 mb-1 ">
				<p class="terms">
					By clicking Book now, you agree to our <a class="terms-text"
						href="#">Terms & Conditions</a> and that you have read our <a
						class="terms-text" href="#">Privacy Policy</a>
				</p>
			</div>
		</div>
		<div class="row mt-3 mb-1">
			<div class="col-12 col-md-4 offset-md-4 mb-1 submit-container">
				<button class="btn btn-doomyoga-login btn-login" type="submit">Book
					now</button>
			</div>
		</div>
	</form>

</div>
@endsection @section('scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script>
  
    </script>
@endsection
