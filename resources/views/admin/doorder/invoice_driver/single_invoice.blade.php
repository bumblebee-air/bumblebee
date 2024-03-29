@extends('templates.doorder_dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
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
</style>
@endsection @section('title','DoOrder | Invoice ' . $driver->id)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<div class="card invoiceCard">
						<div class="card-header">
							<div class="container">
								<div class="row mt-3">
									<div class="col-12 col-sm-6">

										<h4 class="card-title invoiceTitleH4">Payout To</h4>
										<h5 class="card-title invoiceTitleH5 mt-3">
											<a class=""
												href="{{url('doorder/drivers/view/')}}/{{$driver->id}}">{{$user->name}}</a>
										</h5>
									</div>

									<div class="col-12  col-sm-6"></div>
								</div>
								<div class="row">
									<div class="col-12 col-sm-6">
										<p class="invoiceTitleP">{{$user->email}}</p>
										<p class="invoiceTitleP">{{$user->phone}}</p>
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
													<th width="10%">Price</th>
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
													<td class="text-left">{{$invoice_price}}</td>
													<td class="invoiceBoldSpan">€@{{item.charge}}</td>
												</tr>
												<tr v-if="invoice.length == 0">
        											<td colspan="7" class="text-center">No data found.
        											</td>
        										</tr>
											</tbody>
											<tfoot v-if="invoice.length > 0">
												<tr>
													<th colspan="5"></th>
													<th class="tfootLabelTh tfootBorderTh">Total</th>
													<th class="tfootValueTh tfootBorderTh text-center">€{{$total}}</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>


					</div>

					@if($completed_stripe_account==true)
					<div class="row justify-content-center">
						<div class="col-lg-3  col-md-3 col-sm-4  text-center">
							<button class="btnDoorder btn-doorder-primary  mb-1"
								onclick="payoutToDriver({{$driver->id}},{{$subtotal}})">Payout</button>
						</div>
					</div>
					@else
					<div class="row justify-content-center">
						<div class="col-lg-3  col-md-3 col-sm-4  text-center">

							<button class="btnDoorder btn-doorder-primary  mb-1 disabled"
								disabled="disabled">Payout</button>
						</div>
						<div class="col-lg-3  col-md-3 col-sm-4  text-center">
							<button type="button"
								class="btnDoorder btn-doorder-primary  mb-1"
								onclick="sendNotificationNotCompleted({{$driver->id}},'{{$stripe_profile_status}}')">Notify
								driver</button>
						</div>
					</div>
					@endif

				</div>
			</div>
		</div>

	</div>

	<!-- send notification modal -->
	<div class="modal fade" id="send-notification-modal" tabindex="-1"
		role="dialog" aria-labelledby="send-notification-label"
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
					<div class="modal-dialog-header modalHeaderMessage"
						id="notifyDriverMessageDiv">This driver profile is incomplete or
						doesn't have a stripe profile yet</div>

					<div>

						<form method="POST" id="sendNotificationForm"
							action="{{url('doorder/send_notification_driver')}}"
							style="margin-bottom: 0 !important;">
							@csrf <input type="hidden" id="driver_id" name="driver_id"
								value="" />
						</form>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-primary mb-1"
							onclick="$('form#sendNotificationForm').submit()">Send
							notification</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-danger-outline mb-1"
							data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end send notification modal -->

	<!-- no payout modal -->
	<div class="modal fade" id="payout-driver-modal" tabindex="-1"
		role="dialog" aria-labelledby="payout-driver-label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-dialog-header addUserModalHeader">Payout To
						Driver</div>
					<button type="button" class="close d-flex justify-content-center"
						data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times"></i>
					</button>
				</div>
				<div class="modal-body">

					<div>

						<form method="POST" id="payoutForm"
							action="{{url('doorder/payout_driver_invoice')}}"
							style="margin-bottom: 0 !important;">
							@csrf <input type="hidden" id="driver_id" name="driver_id"
								value="" />

							<div class="row">
								<div class="col">
									<div class="form-group bmd-form-group">
										<label for="subtotal">Subtotal </label> <input type="number"
											class="form-control" name="subtotal" id="subtotal" step="any"
											placeholder="Subtotal" v-model="subtotal"
											@change="changeSubtotal" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group bmd-form-group">
										<label for="subtotal">Additional </label> <input type="number"
											class="form-control" name="additional" id="additional"
											step="any" placeholder="Additional" v-model="additional"
											@change="changeAdditional" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group bmd-form-group"
										style="font-weight: 800;">
										<label for="">Total: </label> <span v-html="total"></span>
										<input type="hidden" name="total" id="total" step="any"
											v-model="total">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group bmd-form-group">
										<label for="subtotal">Notes </label>
										<textarea rows="5" class="form-control" name="notes"></textarea>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-primary mb-1"
							onclick="$('form#payoutForm').submit()">Submit</button>
					</div>
					<div class="col-lg-4 col-md-6 text-center">
						<button type="button"
							class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end payout modal -->


</div>

@endsection @section('page-scripts')
<script>
function sendNotificationNotCompleted(driver_id,status){
	console.log("send notification",driver_id);
    	
    $('#send-notification-modal').modal('show')
    $('#send-notification-modal #driver_id').val(driver_id);
    
    if(status === 'not-completed'){
    	$("#send-notification-modal #notifyDriverMessageDiv").html("This driver profile is incomplete.")
    }else if(status === 'no-account'){
    	$("#send-notification-modal #notifyDriverMessageDiv").html("This driver profile doesn't have a Stripe profile yet.")    	
    }
}

function payoutToDriver(driver_id,subtotal){
	$('#payout-driver-modal').modal('show')
    $('#payout-driver-modal #driver_id').val(driver_id);
    $('#payout-driver-modal #subtotal').val(subtotal);
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
            	subtotal: {!! $subtotal !!},
            	additional: 0,
            	total:({!! $subtotal !!}).toFixed(2),
            	
            },
			methods: {
				changeSubtotal(){
					this.total = (parseFloat(this.subtotal) + parseFloat(this.additional)).toFixed(2);
				},
				changeAdditional(){
					this.total = (parseFloat(this.subtotal) + parseFloat(this.additional)).toFixed(2);
				}
			}
        });
    </script>
@endsection
