@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.card-icon {
	padding: 25px 20px !important;
}

.card-icon i {
	font-size: 40px;
}

.card .card-header .card-title {
	margin-bottom: 0 !important
}

.card-category {
	margin-top: -15px !important;
	font-family: Quicksand;
	font-size: 16px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 2;
	letter-spacing: 0.15px;
	color: #7b7b7b !important;
	text-decoration: underline;
	left: 70px;
	font-family: Quicksand;
}

.card-category a {
	text-decoration: underline;
	color: #7b7b7b !important;
}

.form-head {
	padding-top: 0 !important;
	padding-bottom: 5px !important;
}

.form-control:read-only {
	background-image: none !important;
	padding: 10px
}

.form-control span {
	font-family: Quicksand;
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
}

.invoiceDetialsLabel {
	font-family: Quicksand;
	font-size: 17px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.32px;
	color: #4d4d4d;
}

.invoiceDetialsSpan {
	font-family: Quicksand;
	font-size: 17px;
	font-weight: bold;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.32px;
	color: #4d4d4d;
}
}
</style>
@endsection @section('title','DoOrder | Invoice ' . $invoice->order_id) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 ">
								<div class="card-icon">
									<i class="fas fa-file-invoice"></i>
								</div>
								<h4 class="card-title ">Order Number {{$invoice->order_id}}</h4>
								<h5 class="card-category ">
									<a class="" href= "{{url('doorder/retailers/view/')}}/{{$invoice->retailer->id}}">{{$invoice->retailer->name}}</a>
								</h5>
							</div>

						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										@if(count($errors))
										<div class="alert alert-danger" role="alert">
											<ul>
												@foreach ($errors->all() as $error)
												<li>{{$error}}</li> @endforeach
											</ul>
										</div>
										@endif
									</div>

									<div class="col-md-12 d-flex form-head pl-3">
										<span> 1 </span>
										<h5 class="singleViewSubTitleH5">Order Details</h5>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Customer first name</label>
											<div class="form-control">
												<span>{{$invoice->customer_name}}</span>
											</div>

										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Customer last name</label>
											<div class="form-control">
												<span>{{$invoice->customer_name}}</span>
											</div>

										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Customer email address</label>
											<div class="form-control">
												<span>{{$invoice->customer_email}}</span>
											</div>

										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Customer contact number</label>
											<div class="form-control">
												<span>{{$invoice->customer_phone}}</span>
											</div>

										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Customer address</label>
											<div class="form-control">
												<span>{{$invoice->customer_address}}</span>
											</div>

										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Postcode/Eircode</label>
											<div class="form-control">
												<span>{{$invoice->eircode}}</span>
											</div>

										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-12 d-flex form-head pl-3">
										<span> 2 </span>
										<h5 class="singleViewSubTitleH5">Package Details</h5>
									</div>
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Pickup address</label>
											<div class="form-control">
												<span>{{$invoice->pickup_address}}</span>
											</div>

										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Package weight in kg</label>
											<div class="form-control">
												<span>{{$invoice->customer_address}}</span>
											</div>

										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Other details</label>
											<div class="form-control">
												<span>N/A</span>
											</div>

										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Fragile package? </label>
											<div class="radio-container row">
												<div
													class="form-check form-check-radio form-check-inline d-flex justify-content-between">
													<label class="form-check-label"> <input type="radio"
														name="fragile" id="inlineRadio1" value="1"
														class="form-check-input" required @if($invoice->fragile==1)
														checked @endif> Yes <span class="circle"> <span
															class="check"></span>
													</span>
													</label>
												</div>

												<div
													class="form-check form-check-radio form-check-inline d-flex justify-content-between">
													<label class="form-check-label"> <input type="radio"
														name="fragile" id="inlineRadio1" value="0"
														class="form-check-input" required @if($invoice->fragile==0)
														checked @endif> No <span class="circle"> <span
															class="check"></span>
													</span>
													</label>
												</div>
											</div>

										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Order fulfilment</label>
											<div class="form-control">
												<span>{{$invoice->fulfilment}}</span>
											</div>

										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group bmd-form-group">
											<label>Package dimensions in cm</label>
											<div class="form-control">
												<span>{{$invoice->dimensions}}</span>
											</div>

										</div>
									</div>

								</div>

							</div>
						</div>
					</div>



					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-12 d-flex form-head pl-3">
										<span> 3 </span>
										<h5 class="singleViewSubTitleH5">Invoice Details</h5>
									</div>


									<div class="col-md-12">



										<div class="row">
											<div class="col-md-6 col-9">
												<label class="invoiceDetialsLabel">{{$invoiceDetails['name']}}</label>
											</div>
											<div class="col-md-3 col-3">
												<span class="invoiceDetialsSpan">€{{$invoiceDetails['charge']}}</span>
											</div>
										</div>
										<div class="row" style="margin-top: 15px">
											<div class="col-md-6 col-9">
												<label class="invoiceDetialsSpan">Total</label>
											</div>
											<div class="col-md-3 col-3">
												<span class="invoiceDetialsSpan">€{{$total}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row ">
						<div class="col text-center">
							<form method="POST"
								action="{{route('doorder_sendInvoice',['doorder',$invoice->id])}}"
								id="edit_contractor_form">
								{{csrf_field()}}
								<button class="btn bt-submit">Invoiced</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts')
<script>
$( document ).ready(function() {

});
        var app = new Vue({
            el: '#app',
            data() {               
            },
        });
    </script>
@endsection
