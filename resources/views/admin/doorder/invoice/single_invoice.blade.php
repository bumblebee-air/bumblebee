@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>

#invoiceListTable .invoiceBoldSpan {
	font-weight: bold !important;
	margin-bottom: 0
}

.invoiceDateSpan {
	margin-bottom: 10px;
}

tbody tr td:first-child, thead tr th:first-child {
	text-align: left;
	padding-left: 15px !important;
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

.dataTables_scrollBody table tfoot tr th {
	border: none !important;
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}

.swal-text {
	font-size: 18px;
}

.invoiceBtn, .payBtn {
	color: white !important;
}

a.invoiceBtn {
	background: #747474 !important;
	border-color: #747474 !important;
	box-shadow: 0 2px 2px 0 rgb(116 116 116/ 14%), 0 3px 1px -2px
		rgb(116 116 116/ 20%), 0 1px 5px 0 rgb(116 116 116/ 12%) !important
}

table.doorderTable {
	margin-top: 0
}
</style>
@endsection @section('title','DoOrder | Invoice ' . $retailer->id)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card invoiceCard" id="invoiceCard">
						<div class="card-header ">
							<div class="container">
								<div class="row mt-3">
									<div class="col-12 col-sm-6">
										<h4 class="card-title invoiceTitleH4">Billed To</h4>
										<h5 class="card-title invoiceTitleH5 mt-3">
											<a class=""
												href="{{url('doorder/retailers/view/')}}/{{$retailer->id}}">{{$retailer->name}}</a>
										</h5>
									</div>
									<div class="col-12 col-sm-6 mt-md-3">
										<h6 class="card-title float-md-right invoiceTitleH6">Invoice Number {{$invoice_number}}</h6>
									</div>
								</div>
								<div class="row">
									<div class="col-12 col-sm-6">
										<p class="invoiceTitleP">{{$user->email}}</p>
										<p class="invoiceTitleP">{{$user->phone}}</p>
									</div>

									<div class="col-12 col-sm-6 text-md-right text-left mt-md-1 mt-2">
										<div class="row ">
											<div class="col-xl-4 col-md-2"></div>
											<div class="col-xl-4 col-md-5 col-6">
												<label class="invoiceTitleLabel">Date Issued:</label>
											</div>
											<div class="col-xl-4 col-md-5 col-6">
												<label class="invoiceTitleValue">{{$month}}</label>
											</div>
										</div>
										<div class="row ">
											<div class="col-xl-4 col-md-2"></div>
											<div class="col-xl-4 col-md-5 col-6">
												<label class="invoiceTitleLabel">VAT Reg .No.:</label>
											</div>
											<div class="col-xl-4 col-md-5 col-6">
												<label class="invoiceTitleValue">IE3719422OH</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body cardBodyPaymentDetails">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<h4 class="invoicePaymentDetails">Payment Details:</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-12">
												<label class="invoicePaymentLabel">IBAN: <span
													class="invoicePaymentSpan"> IE67 BOFI 9007 5425 3970 40 </span></label>
											</div>
											<div class="col-12">
												<label class="invoicePaymentLabel">BIC/SWIFT: <span
													class="invoicePaymentSpan"> BOFIIE2DXXX </span></label>
											</div>
											<div class="col-12">
												<label class="invoicePaymentLabel">ADDRESS: <span
													class="invoicePaymentSpan"> Rathines, Dublin 6 </span></label>
											</div>
											<div class="col-12">
												<label class="invoicePaymentLabel">COMPANY REG NO. <span
													class="invoicePaymentSpan"> 673153 </span></label>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row invoiceDoorderBottomRow"
											style="">

											<div class="col-12">
												<label class="invoicePaymentLabel float-right"><i
													class="fab fa-chrome"></i> www.doorder.eu</label>
											</div>

											<div class="col-12">
												<label class="invoicePaymentLabel float-right"><i
													class="fas fa-envelope"></i> info@doorder.eu</label>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="card-body pt-0">
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
											class="table table-no-bordered table-hover doorderTable mt-0"
											cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="70%" colspan="4">Service</th>
													<th width="10%" class="text-center">QTY</th>
													<th width="10%" >Price</th>
													<th width="10%" class="text-center">Total</th>
												</tr>

											</thead>
											<tbody>
																								
												<tr v-if="invoice.length > 0" v-for="item in invoice" >
													<td colspan="4"><p class="invoiceServiceP">@{{item.name}}
														</p>
														<p class="invoiceDateSpan">@{{item.date}}</p> 
													</td>
													<td>@{{item.count}}</td>
													<td class="text-left">€10</td>
													<td class="">€@{{item.charge.toFixed(2)}}</td>
												</tr>
												<tr v-if="invoice.length == 0">
        											<td colspan="7" class="text-center">No data found.
        											</td>
        										</tr>
											</tbody>
											<tfoot>
												<tr>
													<th colspan="5"></th>
													<th class="tfootLabelTh">Subtotal</th>
													<th class="tfootValueTh text-center">€{{number_format((float)$subtotal, 2, '.', '')}}</th>
												</tr>
												<tr>
													<th colspan="5"></th>
													<th class="tfootLabelTh">VAT @ 23%</th>
													<th class="tfootValueTh text-center">€{{number_format((float)$vat, 2, '.', '')}}</th>
												</tr>
												<tr>
													<th colspan="5"></th>
													<th class="tfootLabelTh tfootBorderTh">Total</th>
													<th class="tfootValueTh tfootBorderTh text-center">€{{number_format((float)$total, 2, '.', '')}}</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>


					</div>

					<div class="card"
						style="background-color: transparent; box-shadow: none;">
						<div class="card-body p-0">
							<div class="container w-100" style="max-width: 100%">

								@if(auth()->user()->user_role != 'retailer')
								<div class="row justify-content-center ">
<!-- 									<div class="col-xl-2 offset-xl-6 col-md-3  col-sm-4 text-center"> -->
<!-- 										<button class="btnDoorder btn-doorder-grey  mb-1" onclick="editInvoice({{$retailer->id}},'{{$month}}')">Edit</button>-->
<!-- 									</div> -->
									<div class="col-lg-3 col-md-3 col-sm-4 text-center @if($paid_flag==1) d-none @endif">
										<form method="POST"
											action="{{route('doorder_sendInvoice',['doorder',$retailer->id, 'month' => $_GET['month']])}}"
											id="invoice_orders_form" style="margin: 0 !important;">{{csrf_field()}}</form>
										<button class="btnDoorder btn-doorder-primary  mb-1"
											@click="submitForm">Invoice</button>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-4 text-center @if($paid_flag==1) d-none @endif">
										<button type="button"
											class="btnDoorder btn-doorder-green  mb-1"
											onclick="clickSendEmail({{$retailer->id}},'{{$month}}')">Send
											invoice email</button>
									</div>
									<div class="col-lg-3  col-md-3 col-sm-4 text-center">
										<button class="btnDoorder btn-doorder-grey mb-1" type="button" @click="PrintElem">Print</button>
									</div>
								</div>
								@else
								<div class="row justify-content-center">
									<div class="col-lg-3 col-md-3 col-sm-4">
										<button class="btnDoorder btn-doorder-primary mb-1 w-100"
											data-toggle="modal"
												data-target="#warning-modal">Download invoice</button>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-4 @if($paid_flag==1) d-none @endif">
										<a class="btnDoorder btn-doorder-green  mb-1 w-100 "
											href="{{url('doorder/pay_invoice/')}}/{{$retailer->id}}/{{$invoice_number}}">Pay</a>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-4">
										<button class="btnDoorder btn-doorder-grey" type="button" @click="PrintElem">Print</button>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- send email modal -->
<div class="modal fade" id="send-email-modal" tabindex="-1"
	role="dialog" aria-labelledby="send-email-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you want
					to send the invoice email to the retailer</div>
				<div>
					<form method="POST" id="sendEmailForm"
						action="{{url('doorder/send_invoice_email')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="retailer_id" name="retailer_id"
							value="" /> <input type="hidden" id="month" name="month" value="" />
					</form>
				</div>
			</div>
			<div class="row  justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#sendEmailForm').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1 "
						data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end send email modal -->

<!-- cinfirm invoice modal -->
<div class="modal fade" id="confirm-invoice-modal" tabindex="-1"
	role="dialog" aria-labelledby="confirm-invoice-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you want to invoice these orders?</div>

			</div>
			<div class="row  justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('#invoice_orders_form').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">No</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end confirm invoice modal -->
<!-- warning modal -->
<div class="modal fade" id="warning-modal" tabindex="-1"
	role="dialog" aria-labelledby="warning--label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="col-md-12">

						<div class="text-center">
							<img
								src="{{asset('images/doorder-new-layout/warning-icon.png')}}"
								style="" alt="warning">
						</div>
						<div class="text-center mt-3">
							<label class="warning-label">Under construction</label>

						</div>
					</div>
				</div>

				<div class="row justify-content-center mt-3">
					
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-primary mb-1"
							data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- end warning modal -->


@endsection @section('page-scripts')
<script>
function clickSendEmail(retailer_id,month){
	console.log("send email",retailer_id,month);
    $('#send-email-modal').modal('show')
    $('#send-email-modal #retailer_id').val(retailer_id);
    $('#send-email-modal #month').val(month);
}

function editInvoice(id,month){
 window.location = "{{url('doorder/invoice_edit/')}}/"+id + "?month=" + month
}


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
             data: {                
            	
            	invoice: {!! json_encode($invoice) !!},     
            	
            },
			methods: {
			
				submitForm(e) {
					$('#confirm-invoice-modal').modal('show');
				},
				PrintElem()
				{
					// var mywindow = window.open('', 'PRINT', 'height=400,width=600');
					//
					// mywindow.document.write('<html><head><title>' + document.title  + '</title>');
					// mywindow.document.write('</head><body >');
					// mywindow.document.write('<h1>' + document.title  + '</h1>');
					// mywindow.document.write(document.getElementById('invoiceCard').innerHTML);
					// mywindow.document.write('</body></html>');
					//
					// mywindow.document.close(); // necessary for IE >= 10
					// mywindow.focus(); // necessary for IE >= 10*/
					//
					// mywindow.print();
					// mywindow.close();

					var contents = document.getElementById('invoiceCard').innerHTML;
					var frame1 = document.createElement('iframe');
					frame1.name = "frame1";
					frame1.style.position = "absolute";
					frame1.style.top = "-1000000px";
					document.body.appendChild(frame1);
					var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
					frameDoc.document.open('', 'PRINT', 'height=400,width=600');
					frameDoc.document.write(`<html><head><title>document.title</title>`);
					frameDoc.document.write(document.head.innerHTML);
					frameDoc.document.write('</head><body>');
					frameDoc.document.write('<div class="user" style="z-index: 3;"><div class="photo photo-full text-center mb-3"><img src="{{asset('images/doorder-new-layout/Logo.png')}}" title="DoOrder" alt="DoOrder" id="adminNavLogoImg"></div></div>');
					frameDoc.document.write(contents);
					frameDoc.document.write('</body></html>');
					frameDoc.document.close();
					setTimeout(function () {
						window.frames["frame1"].focus();
						window.frames["frame1"].print();
						document.body.removeChild(frame1);
					}, 500);
					return true;
				}
			}
        });
    </script>
@endsection
