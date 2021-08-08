@extends('templates.auth') @section('title','DoOrder | Print Label')
@section('page-styles')
<link
	href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
	rel="stylesheet">
<style>
body {
	background-color: #f6f7fa;
}
@media print {
    body{
        width: 21cm;
        height: 15cm;
        /* change the margins as you want them to be. */
   } 
}
.control-label{
font-family: Quicksand;
  font-size: 16px;
  font-weight: normal;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.77px;
  color: #4d4d4d;
}
</style>
@endsection @section('page-content')
<div class="content " style="">
	<div class="container-fluid ">
		<div class="row" style="background-color: #ededed; height: 100px;-webkit-print-color-adjust: exact;color-adjust: exact;">
			<div class="col-md-12 text-center py-1">
				<img src="{{asset('images/doorder-logo.png')}}" height="80px"
					width="250px">
			</div>
		</div>
		<div class="row mx-auto" style="background-color: #f6f7fa;">

			<div class="col-6  ">
				<div class="form-group  mx-auto">
					<label class="control-label  ">Name </label> <span
						class="control-label  "
						style="display: block; font-weight: 600"> {{$order->customer_name}} </span>
				</div>
			</div>
			<div class="col-6">
				<div class="form-group ">
					<label class="control-label">Eircode </label> <span
						class="control-label"
						style="display: block; font-weight: 600"> {{$order->eircode}}</span>
				</div>
			</div>
			<div class="col-12">
				<div class="form-group ">
					<label class="control-label ">Address </label> <span
						class="control-label "
						style="display: block; font-weight: 600"> {{$order->customer_address}}</span>
				</div>
			</div>
			<div class="col-12">
				<div class="form-group ">
					<label class="control-label ">Phone number </label>
					<span class="control-label "
						style="display: block; font-weight: 600"> {{$order->customer_phone}}</span>
				</div>
			</div>

		</div>
	</div>
</div>


@endsection
