@extends('templates.dashboard') @section('page-styles')

<link rel="stylesheet"
	href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css">
<style>
.card-icon i {
	font-size: 34px;
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

select.form-control:not([size]):not([multiple]) {
	height: 36px !important;
	padding: 11px 14px 11px 14px;
	border-radius: 5px;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
	font-family: Quicksand;
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
	width: 100%;
	height: auto;
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
							<div class="col-6 col-sm-4">
								<div class="card-icon">
									<i class="fas fa-file-invoice"></i>
								</div>
								<h4 class="card-title ">Invoice</h4>
							</div>

						</div>
						<div class="card-body">

							<div class="table-responsive">

								<div class="row" style="margin-left: 15px">
									<label class="col-md-2 col-form-label filterLabelDashboard">Filter:</label>
									<div class="col-md-3">
										<div class="form-group bmd-form-group">
											<input class="form-control inputDate" id="startDate"
												type="text" placeholder="From" required="true"
												aria-required="true">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group bmd-form-group">
											<input class="form-control inputDate" id="endDate"
												type="text" placeholder="To" required="true"
												aria-required="true">
										</div>
									</div>
									<div class="col-md-3">
										<div id="retailerNameP" class="form-group bmd-form-group"></div>
									</div>
								</div>

								<table id="invoiceListTable"
									class="table table-no-bordered table-hover doorderTable"
									cellspacing="0" width="90%">
									<thead>
										<tr>
											<th width="10%">Date</th>
											<th width="10%">Order Number</th>
											<th width="10%">Retailer Name</th>
											<th width="10%">Status</th>
											<th width="10%">Deliverer</th>
											<th width="10%">Pickup Location</th>
											<th width="10%">Delivery Location</th>
											<th width="10%">Charges (€)</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="invoice in invoiceList" class="order-row" @click="clickInvoice(invoice.id)">
											<td>@{{ parseDateTime(invoice.date) }}</td>
											<td>@{{invoice.orderNumber}}</td>
											<td>@{{invoice.retailerName}}</td>
											<td><span class="invoiceIconSpan"><i
													class="fas fa-file-invoice"></i></span></td>
											<td>@{{ invoice.deliverer}}</td>
											<td>@{{ invoice.pickupLocation }}</td>
											<td>@{{invoice.deliveryLocation}}</td>
											<td>€@{{invoice.charges}}</td>
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

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script
	src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript">
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        console.log(min)
        console.log(max)
        var date = moment(data[0],'DD/MM/YYYY').toDate();
 		console.log(data[0])
 		console.log(date)
 		console.log("sasasasa")
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);

$(document).ready(function() {
console.log(moment('14/3/2020','DD/MM/YYYY').toDate())
console.log(new Date('1/2/2020'))

 // Create date inputs
    minDate = new DateTime($('#startDate'), {
         format: 'DD/MM/YYYY'
    });
    maxDate = new DateTime($('#endDate'), {
         format: 'DD/MM/YYYY'
    });

    var table= $('#invoiceListTable').DataTable({
    "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50,100, -1],
          [10, 25, 50,100, "All"]
        ],
        responsive:true,
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
    	},
    	
         initComplete: function () {
         var column = this.api().column(2);
                  var select = $('<select id="selectFilter" class="form-control"><option value="">Select retailer </option></select>')
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
    
    $('#startDate, #endDate').on('change', function () {
        table.draw();
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
                    dateTime = date_moment.format('DD/MM/YYYY');
                     console.log(date);
                    return dateTime;
                },
                
                clickInvoice(id) {
                    window.location = "{{url('doorder/invoice_view/')}}/"+id
                }
            }
        });
    </script>
@endsection
