@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.page_icon {
	width: 40px !important;
}

.card-category, .card-category-invoice {
	margin-top: -10px !important;
	font-family: Quicksand;
	font-size: 16px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.5;
	letter-spacing: 0.15px;
	color: #7b7b7b !important;
	margin-left: 95px !important;
}

.card-category-invoice {
	margin-top: 20px !important;
}

.card-category-invoice span {
	display: block;
}

.card-category-invoice .monthSpan {
	text-transform: uppercase;
}

.card-category a {
	color: #494949 !important;
	font-weight: bold;
}

.card-category span {
	display: block;
}

.form-control {
	min-height: 36px;
	height: auto !important;
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

thead tr th {
	font-family: Quicksand;
	font-size: 16px !important;
	font-weight: bold !important;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.19;
	letter-spacing: 0.8px;
	color: #4d4d4d;
}

#invoiceListTable tbody tr td {
	font-family: Quicksand !important;
	font-size: 16px !important;
	font-weight: 500 !important;
	font-stretch: normal !important;
	font-style: normal !important;
	line-height: 1.19 !important;
	letter-spacing: 0.8px !important;
	color: #4d4d4d !important;
}

#invoiceListTable .invoiceBoldSpan {
	font-weight: bold !important;
	margin-bottom: 0
}

.invoiceDateSpan {
	margin-bottom: 10px;
}

tbody tr td:first-child, thead tr th:first-child {
	text-align: left;
	padding-left: 35px !important;
}

.dataTable>tbody>tr>td, .dataTable>tbody>tr>th, .dataTable>thead>tr>td,
	.dataTable>thead>tr>th, .dataTables_scrollFoot tfoot>tr:first-child>th
	{
	border: none !important;
	padding-top: 20px !important;
}

.dataTable>tfoot>tr>th {
	border: none !important;
	padding-top: 5px !important;
}

.dataTables_scrollFoot tfoot>tr:first-child>th, .dataTable>thead>tr>td,
	.dataTable>thead>tr>th {
	border-top: 1px solid #dddfe1 !important;
}

.table-striped>tbody>tr:nth-of-type(odd) {
	background-color: rgba(216, 216, 216, 0.2) !important;
}

.invoiceH4 {
	font-family: Quicksand;
	font-size: 20px;
	font-weight: bold;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.25;
	letter-spacing: 0.19px;
	color: #494949;
}

.doorderLimitedLabel {
	font-family: Quicksand;
	font-size: 16px;
	font-weight: 600;
	font-stretch: normal;
	font-style: normal;
	line-height: 1;
	letter-spacing: 0.15px;
	color: #7b7b7b;
}

.doorderLimitedSpan {
	font-weight: normal !important;
}

.doorderLimitedLabel i {
	color: #f7dc69;
}

.dataTables_scrollBody table tfoot tr th {
	border: none !important;
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}

.swal-text {
	font-family: Quicksand;
	font-size: 18px;
}
</style>
@endsection @section('title','DoOrder | Invoice ' . $retailer->id)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-lg-8 col-md-6">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/doorder_icons/Invoice-white.png')}}">
								</div>
								<h4 class="card-title ">Billed To</h4>
								<h5 class="card-category ">
									<a class=""
										href="{{url('doorder/retailers/view/')}}/{{$retailer->id}}">{{$retailer->name}}</a>
									<span>{{$user->email}}</span> <span>{{$user->phone}}</span>
								</h5>
							</div>

							<div class="col-12 col-lg-4 col-md-6">
								<h5 class="card-category-invoice ">
									<span>Invoice Number {{$retailer->id}}</span> <span
										class="monthSpan">{{$month}}</span>
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

									<div class="col-md-12">
										<table id="invoiceListTable"
											class="table table-striped table-no-bordered  "
											cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>SERVICE</th>
													<th>QTY</th>
													<th>PRICE</th>
													<th>TOTAL</th>
												</tr>

											</thead>
											<tbody>
												@foreach($invoice as $item)
												<tr>
													<td>{{$item['name']}}
														</p>
														
														<p class="invoiceDateSpan">{{$item['date']}}</p> <p>{{$item['data']}}</p>
														
														
													</td>
													<td>{{$item['count']}}</td>
													<td>€10</td>
													<td class="invoiceBoldSpan">€{{$item['charge']}}</td>
												</tr>
												@endforeach
											</tbody>
											<tfoot>
												<tr>
													<th colspan="2"></th>
													<th>Subtotal</th>
													<th>€{{$subtotal}}</th>
												</tr>
												<tr>
													<th colspan="2"></th>
													<th>VAT @ 21%</th>
													<th>€{{$vat}}</th>
												</tr>
												<tr>
													<th colspan="2"></th>
													<th>Total</th>
													<th>€{{$total}}</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body" style="background-color: #f8f8f8;">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<h4 class="invoiceH4">DOORDER LIMITED</h4>
									</div>
									<div class="col-md-12">
										<label class="doorderLimitedLabel">IBAN: <span
											class="doorderLimitedSpan"> IE67 BOFI 9007 5425 3970 40 </span></label>
									</div>
									<div class="col-md-12">
										<label class="doorderLimitedLabel">BIC/SWIFT: <span
											class="doorderLimitedSpan"> BOFIIE2DXXX </span></label>
									</div>

									<div class="col-md-6">
										<label class="doorderLimitedLabel">ADDRESS: <span
											class="doorderLimitedSpan"> Rathines, Dublin 6 </span></label>
									</div>
									<div class="col-md-6">
										<label class="doorderLimitedLabel float-right"><i
											class="fas fa-at"></i> www.doorder.eu</label>
									</div>
									<div class="col-md-6">
										<label class="doorderLimitedLabel">COMPANY REG NO. <span
											class="doorderLimitedSpan"> 673153 </span></label>
									</div>
									<div class="col-md-6">
										<label class="doorderLimitedLabel float-right"><i
											class="far fa-envelope"></i> info@doorder.eu</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row ">
						<div class="col text-center">
							<form method="POST"
								action="{{route('doorder_sendInvoice',['doorder',$retailer->id, 'month' => $_GET['month']])}}"
								id="invoice_orders_form">{{csrf_field()}}</form>
							<button class="btn bt-submit" @click="submitForm">Invoice</button>
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
    var table= $('#invoiceListTable').DataTable({
    		"paging":   false,
        	"ordering": false,
        	"info":     false,
        	"responsive":true,
        	"searching": false,
        	 scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    });
});
        var app = new Vue({
            el: '#app',
            data() {               
            },
			methods: {
				submitForm(e) {
					swal({
						// title: "Good job!",
						text: "Are you sure you want to invoice these orders?",
						icon: "info",
						buttons: {
							accept: {
								text: "Yes",
								value: "yes",
								className: 'btn bt-submit btn-primary w-100'
							},
							reject: {
								text: "No",
								value: "no",
								className: 'btn bt-submit btn-secondary w-100'
							}
						}
					}).then((input) => {
						if (input === 'yes') {
							$('#invoice_orders_form').submit();
						}
					});
				}
			}
        });
    </script>
@endsection
