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
	font-size: 20px;
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

.overallRating img {
	width: 40px;
	height: 40px;
}

.doorder-btn {
	background: #F7DC69;
	border-radius: 42px;
}

.control-label {
	text-align: left;
}
.form-control:focus {
    border-color: #f7dc69 !important;
    background-image: none !important;
}    
</style>
@endsection @section('content')
<div class="container mt-3" id="app">
	<form
		action="{{route('doorder_saveUpdateAddress', ['client_name' => 'doorder'])}}"
		method="post">
		{{csrf_field()}} <input type="hidden" name="order_id"
			value="{{$order_id}}">

		<div class="main main-raised p-3">
			<div class="h-100 row align-items-center">
				<div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center">
					<img class="doorder-logo"
						src="{{asset('images/doorder-logo.png')}}" alt="DoOrder">

					<h2 class="ratingH2 my-4">Please confirm the address to pickup the
						package from store</h2>


					<div class="row mx-2">
						<div class="col-4">
							<div class="form-group">
								<label class="control-label">Order number </label>
							</div>
						</div>
						<div class="col-8">
							<span class="control-label"
								style="display: block; font-weight: 600">{{$order->order_id}} </span>
						</div>
					</div>

					<div class="row mx-2">
						<div class="col-4">
							<div class="form-group">
								<label class="control-label">Selected address </label>
							</div>
						</div>
						<div class="col-8">
							<span class="control-label"
								style="display: block; font-weight: 600">{{$order->pickup_address}}
							</span>
						</div>
					</div>

					<div class="row mx-2 mt-3">
						<div class="col-12">
							<select id="pick_address" name="pickup_address"
								class="form-control selectpicker"
								data-style="select-with-transition" required>
								<option value="">Select address</option>
								@foreach($retailer_addresses as $address)
								<option value="{{$address->address}}">{{$address->address}}</option>
								@endforeach
							</select>
						</div>
					</div>




					<button type="submit" class="btn  doorder-btn mt-4">Submit</button>

				</div>
			</div>
		</div>
	</form>
</div>

@endsection @section('scripts')

<script type="text/javascript">

$( document ).ready(function() {	
});         
</script>

@endsection
