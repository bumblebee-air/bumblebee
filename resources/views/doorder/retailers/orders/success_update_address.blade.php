@extends('templates.doorder') @section('title', 'Driver Rating')

@section('styles')
<link href="{{asset('css/doorder-styles.css')}}" rel="stylesheet">
<link href="{{asset('css/doorder_dashboard.css')}}" rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
	rel="stylesheet">
<link
	href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap"
	rel="stylesheet">
<link rel="icon" type="image/jpeg"
	href="{{asset('images/doorder-favicon.svg')}}">
<style>
.doorder-logo {
	width: 150px;
}

.ratingH2 {
	font-style: normal;
	font-weight: 500;
	font-size: 24px;
	line-height: 28px;
	text-align: center;
	color: #4D4D4D;
}

.ratingLabel {
	font-style: normal;
	font-weight: 500;
	font-size: 19px;
	line-height: 28px;
	text-align: center;
	color: #7B7B7B;
}
</style>
@endsection @section('content')
<div class="container mt-3" id="app">
	
		<div class="main main-raised p-3">
			<div class="h-100 row align-items-center">
				<div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center">
					<img class="doorder-logo"
						src="{{asset('images/doorder-logo.png')}}" alt="DoOrder">


						<h2 class="ratingH2 my-2 mt-5"> Thank you! Our courier will be sent soon! </h2>
						
					<div class="my-5"><img src="{{asset('images/doorder_icons/success_update_address.png')}}"
						alt="rating" /></div>
						
						
				</div>
			</div>
		</div>
</div>

@endsection @section('scripts')
<script type="text/javascript">


$( document ).ready(function() {	
});         
</script>

 @endsection
