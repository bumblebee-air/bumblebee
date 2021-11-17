@extends('templates.doorder_dashboard') @section('page-styles')

<link rel="stylesheet"
	href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css">
<style>
.page_icon {
	width: 40px !important;
}

.invoiceIconSpan i {
	font-size: 18px;
	color: #60a244;
}

.invoiceIconSpan.completed i {
	color: #60a244;
}

.invoiceIconSpan.not-completed i {
	color: #f7dc69;
}

.invoiceIconSpan.no-account i {
	color: #838383;
}

.doorderTable>tbody>tr>td, .doorderTable>tbody>tr>th, .doorderTable>tfoot>tr>td,
	.doorderTable>tfoot>tr>th, .doorderTable>thead>tr>td, .doorderTable>thead>tr>th
	{
	padding: 10px 5px !important;
}

div.dt-datetime {
	padding: 0 !important;
}

div.dt-datetime div.dt-datetime-title {
	padding: 5px !important;
}

div.dt-datetime table {
	margin: 0 !important;
}

div.dt-datetime table th {
	padding: 5px;
	font-size: 12px !important;
}

div.dt-datetime table td, div.datepicker-days table td {
	min-width: 20px !important;
	max-width: 20px !important;
	width: 20px !important;
	padding: 2px !important;
}

div.dt-datetime table td.selectable.selected button {
	padding: 6px !important;
}

.form-control:read-only {
	background-image: none !important;
}

select.form-control:not([size]):not([multiple]) {
	height: 36px !important;
	padding: 8px 14px 8px 14px;
	border-radius: 5px;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
	width: 100%;
	height: auto;
}

.card-body {
	padding-top: 10px !important;
}

#dashboardCardDiv .btn, #exportButton {
	height: auto;
	padding: 8px;
}

#retailerNameP {
	height: 50px;
}

.bootstrap-datetimepicker-widget table td span.active, .datepicker-days table td.active div{
	background-color: #e8ca49;
}
.datepicker-days table td.today>div:before{
    border-bottom-color: #e8ca49
}
.datepicker-days table td.active:hover>div, .datepicker-days table td.active>div{
	background-color: #e8ca49;
}

.bootstrap-datetimepicker-widget table td span {
	color: #a5a5a5
}
</style>
@endsection @section('title', 'DoOrder | Invoice')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12  col-xl-5 col-lg-4 col-md-4 col-sm-12">
								
								<h4 class="card-title my-md-4 mt-4 mb-1">Drivers Invoice</h4>
							</div>

							<div class="col-12 col-xl-7 col-lg-8 col-md-8 col-sm-12">
								<div class="status text-right">
									<div class="status_item">
										<span class=" invoiceIconSpan completed"> <i
											class="fas fa-file-invoice"></i></span> Completed stripe
										profile

									</div>
									<div class="status_item">
										<span class=" invoiceIconSpan not-completed"> <i
											class="fas fa-file-invoice"></i></span> Not completed stripe
										profile

									</div>
									<div class="status_item">
										<span class=" invoiceIconSpan no-account"> <i
											class="fas fa-file-invoice"></i></span> No stripe profile

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">

							<div class="table-responsive">
								
								<table id="invoiceListTable"
									class="table table-no-bordered table-hover doorderTable"
									cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="10%">Last Payout Date</th>
											<th width="10%">Driver Name</th>
											<th width="10%"  class="text-center">Status</th>
											<th width="10%"  class="text-center">Charges (€)</th>
											<th  width="10%" class="disabled-sorting text-center">Actions</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="invoice in invoiceList" class="order-row"
											@click="clickInvoice(invoice.driver_id, invoice.last_payout_date)">
											<td class="text-left">@{{invoice.last_payout_date}}</td>
											<td class="text-left">@{{invoice.driver_name}}</td>
											<td><span :class="invoice.status+' invoiceIconSpan'"> <i
													class="fas fa-file-invoice"></i>
											</span></td>
											<td>@{{ invoice.charges }}</td>
											<td><a
												class=""
												@click="clickInvoice(invoice.driver_id, invoice.last_payout_date)">
													<img class="viewIcon"
													src="{{asset('images/doorder-new-layout/view-icon.png')}}"
													alt="">
												</a> </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- no account modal -->
<div class="modal fade" id="no-account-modal" tabindex="-1"
	role="dialog" aria-labelledby="no-account-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">This driver doesn't
					have last payout date. Please select date</div>

				<div>

					<form method="POST" id="updateLastPayoutDate"
						action="{{url('doorder/update_last_payout_date')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="driver_id" name="driver_id"
							value="" />

						<div class="row">
							<div class="col-6">
								<div class="form-group bmd-form-group">
									<label for="date">Date </label> <input type="text"
										class="form-control" name="date" id="date"
										placeholder="Date" required>
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
						onclick="$('form#updateLastPayoutDate').submit()">Yes</button>
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
<!-- end no account modal -->


@endsection @section('page-scripts')

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script
	src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript">
var minDate, maxDate;


$(document).ready(function() {

$("#date").datetimepicker({
         format: 'L',
         
         icons: { time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
            				},
         debug:true
});

    var table= $('#invoiceListTable').DataTable({
    "pagingType": "full_numbers",
        "lengthMenu": [ 
        	[-1,10, 25, 50,100],
          	["All",10, 25, 50,100]
        ],
        responsive:true,
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
			"paginate": {
                      "previous": "<i class='fas fa-angle-left'></i>",
                      "next": "<i class='fas fa-angle-right'></i>",
                      "first":"<i class='fas fa-angle-double-left'></i>",
                      "last":"<i class='fas fa-angle-double-right'></i>"
                    }
    	},
		scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    	
//          initComplete: function () {
//          	var column = this.api().column(1);
// 			var select = $('<select id="selectFilter" class="form-control" name="retailer"><option value="">Select driver </option></select>')
// 			.appendTo( $('#driverNameP').empty().text('') )
// 			.on( 'change', function () {
// 				var val = $.fn.dataTable.util.escapeRegex(
// 					$(this).val()
// 				);
// 			column
// 			.search( val ? '^'+val+'$' : '', true, false )
// 			.draw();

// 			} );
// 			column.data().unique().sort().each( function ( d, j ) {
// 			select.append( '<option value="'+d+'">'+d+'</option>' );
// 			} );
//         }
    });
    
    
    
} );

        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                invoiceList: {!! json_encode($invoiceList) !!}
            },
            mounted() {

            },
            methods: {
                  parseDateTime(date) {
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date();
                    let date_moment = new moment();
                    if(date!=null && date!=''){
                        //parseDate = new Date(date);
                        date_moment = new moment(date);
                    } console.log(date_moment);
                    dateTime = date_moment.format('MM/YYYY');
                     console.log(date);
                    return dateTime;
                },
                
                clickInvoice(driver_id, last_payout_date) {
                	if(last_payout_date == 'N/A'){
                		console.log("no date");
                        $('#no-account-modal').modal('show')
                        $('#no-account-modal #driver_id').val(driver_id);
                	}
                	else{
                		console.log("go to single invoice")
                		window.location = "{{url('doorder/invoice_driver_view/')}}/"+driver_id 
                	}
                    
                }
            }
        });
    </script>
@endsection
