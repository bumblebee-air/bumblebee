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

div.dt-datetime table td {
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

table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before,
	table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc:before,
	table.dataTable thead .sorting_desc_disabled:before {
	top: 30% !important;
}

table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after,
	table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc:after,
	table.dataTable thead .sorting_desc_disabled:after {
	top: 30% !important;
}

/* td:hover{
  overflow: visible;
  white-space: normal;
  height: auto;} */
.bootstrap-datetimepicker-widget table td span.active {
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
							<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">

								<h4 class="card-title my-4 mb-sm-1">Invoice</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
								<form method="post" class="mb-1"
									action="{{route('doorder_exportInvoiceList', 'doorder')}}">
									{{csrf_field()}}
									<div class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv">
										<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
											<div class="form-group bmd-form-group inputWithIconDiv">
												<img
													src="{{asset('images/doorder-new-layout/calendar-filter-yellow.png')}}"
													alt=""> <input class="form-control inputDate inputFilter"
													id="date" type="text" placeholder="Month"
													aria-required="true" name="date">
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
											<div id="retailerNameP" class="form-group bmd-form-group"></div>
										</div>
										<div class="col-lg-3 col-md-3  col-sm-4 px-md-1">
											<button id="exportButton" type="submit"
												class="btn-doorder-filter w-100">Export</button>
										</div>

									</div>
								</form>
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
											<th width="10%">Date</th>
											<th width="10%">Retailer </th>
											<th width="10%">Status</th>
											<th  width="10%" class="text-center">No. Of Deliveries </th>
											<th  width="10%" class="text-center">Charges (€)</th>
											<th  width="10%" class="disabled-sorting text-center">Actions</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="invoice in invoiceList" class="order-row"
											@click="clickInvoice(invoice.id, invoice.month)">
											<td class="text-left">@{{invoice.date}}</td>
											<td class="text-left">@{{invoice.name}}</td>
											<td class="text-left">
												<span v-if="invoice.invoiced"
														class="orderStatusSpan invoicedStatus">Invoiced</span>
														<span v-else
														class="orderStatusSpan awaitingInvoiceStatus">Awaiting invoice</span>
											</td>
											<td>@{{ invoice.orders_count }}</td>
											<td>€@{{ 10 * invoice.orders_count }}</td>
											<td><a
												class=""
												@click="clickInvoice(invoice.id, invoice.month)">
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


@endsection @section('page-scripts')

<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script
	src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript">
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
    	console.log("search")
			
		var dateInput =$('#date').val();
        var min =  moment(dateInput,'MMM YYYY').toDate();
       
        var date = moment(data[0],'MMM YYYY').toDate();
 
        if (
            (dateInput==='') ||
            ( min <= date && date<=min )
        ) {
            return true;
        }	
			
        return false;
    }
);

$(document).ready(function() {

$("#date").datetimepicker({
		 viewMode: 'years',
         format: 'MMM YYYY',
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
         
});
$('#date').on('dp.change', function(e){table.draw(); });
$('#date').on("dp.show", function(e) {
   $(e.target).data("DateTimePicker").viewMode("months"); 
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
    	 "columnDefs": [ {
    		"targets": -1,
    		"orderable": false
    	} ],             
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
									
         initComplete: function () {
         	var column = this.api().column(1);
			var select = $('<select id="selectFilter" data-style="select-with-transition" class="form-control selectpicker" name="retailer">'
							+'<option value="">Select retailer </option></select>')
			.appendTo( $('#retailerNameP').empty().text('') )
			.on( 'change', function () {
				var val = $.fn.dataTable.util.escapeRegex(
					$(this).val()
				);
			column
			.search( val ? '^'+val+'$' : '', true, false )
			.draw();

			} );
			column.data().unique().sort().each( function ( d, j ) {
			select.append( '<option value="'+d+'">'+d+'</option>' );
			} );
        }
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
                
                clickInvoice(id, month) {
                    window.location = "{{url('doorder/invoice_view/')}}/"+id + "?month=" + month
                }
            }
        });
    </script>
@endsection
