@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Customer
Account') @section('styles')
<style>
body {
	height: inherit;
}
#containerPageBackgrundDiv{
background-image: none !important;
background-color: #dedede !important;
}
</style>
@endsection @section('content')

<div class="container-fluid " id="app">
	<div class="main main-raised">
		<div class="h-100 row align-items-center">
			<div class="col-md-12 text-center">
				<img src="{{asset('images/doom-yoga/doom-yoga-logo.png')}}"
					width="160" style="height: 150px" alt="DoomYoga">
			</div>
		</div>
		<div class="container-fluid my-5">


			<div class="row mx-auto text-center">
				<div class="col-md-4 containerDivLinkCustomer">
					<a class="btn btn-customer-account">MOVEMENT</a>
				</div>
				<div class="col-md-4 containerDivLinkCustomer">
					<a class="btn btn-customer-account">MEDITATION</a>
				</div>
				<div class="col-md-4 containerDivLinkCustomer">
					<a class="btn btn-customer-account">Music</a>
				</div>
			</div>

		</div>
	</div>


</div>
@endsection @section('scripts') @endsection
