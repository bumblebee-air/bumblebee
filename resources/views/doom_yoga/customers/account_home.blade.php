@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Customer
Account') @section('styles')
<style>
body {
	height: inherit;
}

#containerPageBackgrundDiv {
	background-image: none !important;
	background-color: #dedede !important;
}

#myVideo {
	 object-fit: cover;
  width: 100vw;
  height: 100vh; position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
}
</style>
@endsection @section('content')

<div class="container-fluid " id="app">
	<video playsinline autoplay="autoplay" muted="muted" loop="loop"
		id="myVideo">
		<source src="{{asset('videos/doom-yoga/account-video.mp4')}}"
			type="video/mp4">
		Your browser does not support HTML5 video.
	</video>

	<div class="main main-raised">
		<div class="h-100 row align-items-center">
			<div class="col-md-12 text-center">
				<img src="{{asset('images/doom-yoga/Doomyoga-logo-black.png')}}"
					width="160" style="height: 150px" alt="DoomYoga">
			</div>
		</div>

		<div class="container-fluid my-5">


			<div class="row mx-auto text-center">
				<div class="col-md-4 containerDivLinkCustomer">
					<a class="btn btn-customer-account" href="{{route('getVideoLibrary','doom-yoga')}}">MOVEMENT</a>
				</div>
				<div class="col-md-4 containerDivLinkCustomer">
					<a class="btn btn-customer-account" href="{{route('getMeditationLibrary','doom-yoga')}}">MEDITATION</a>
				</div>
				<div class="col-md-4 containerDivLinkCustomer">
					<a class="btn btn-customer-account" href="{{route('getMusicLibrary','doom-yoga')}}">Music</a>
				</div>
			</div>

		</div>
	</div>


</div>
@endsection @section('scripts') @endsection
