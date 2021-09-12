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
.overallRating img{
    width: 40px;height: 40px;
}
.doorder-btn{

background: #F7DC69;
border-radius: 42px;
}
</style>
@endsection @section('content')
<div class="container mt-3" id="app">
	<form
		action="{{route('doorder_saveRating', ['client_name' => 'doorder'])}}"
		method="post">
		{{csrf_field()}}
		
		<input type="hidden" name="order_id" value="{{$order_id}}">
		<input type="hidden" name="user_type" value="{{$user_type}}">
		
		<div class="main main-raised p-3">
			<div class="h-100 row align-items-center">
				<div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center">
					<img class="doorder-logo"
						src="{{asset('images/doorder-logo.png')}}" alt="DoOrder">


					<h2 class="ratingH2 my-4">Package has been {{$user_type == 'retailer' ? 'picked up' : 'delivered'}} successfully</h2>

					<div><img src="{{asset('images/doorder_icons/rating.png')}}"
						alt="rating" /></div>
						
					<label class="ratingLabel mt-5">Rate the driver</label>
					<div class="overallRating" ></div>

					<button type="submit"
						class="btn  doorder-btn mt-4">Submit</button>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection @section('scripts')
<script src="{{asset('js/jquery-raty.js')}}"></script>

<script type="text/javascript">


$( document ).ready(function() {	
  $('.overallRating').raty({
                    starHalf:     '{{asset("images/doorder_icons/star-half-lg.png")}}',
                	starOff:      '{{asset("images/doorder_icons/star-lg.png")}}',
                	starOn:       '{{asset("images/doorder_icons/star-selected-lg.png")}}',
        }); 
});         
</script>

 @endsection
