@extends('templates.dashboard') @section('page-styles')

<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css">
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
	padding: 12px 6px !important;
}

div.dt-datetime{
    padding: 0 !important;
}
div.dt-datetime div.dt-datetime-title {
    padding: 5px !important;
}
div.dt-datetime table{
    margin: 0 !important;
}
div.dt-datetime table th{
padding: 5px;
font-size: 12px !important;
}
div.dt-datetime table td{

min-width:20px !important;
max-width:20px !important;
width: 20px !important;
padding: 2px !important;
}
div.dt-datetime table td.selectable.selected button{
padding: 6px !important;
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
									<label class="col-sm-2 col-form-label filterLabelDashboard">Filter:</label>
									<div class="col-sm-3">
										<div class="form-group bmd-form-group">
											<input class="form-control inputDate" id="startDate"
												type="text" placeholder="From" required="true"
												aria-required="true">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group bmd-form-group">
											<input class="form-control inputDate" id="endDate"
												type="text" placeholder="To" required="true"
												aria-required="true">
										</div>
									</div>
								</div>

								<table id="invoiceListTable"
									class="table table-no-bordered table-hover doorderTable"
									cellspacing="0" width="90%">
									<thead>
										<tr>
											<th>Date</th>
											<th>Order Number</th>
											<th>Retailer Name</th>
											<th>Status</th>
											<th>Stage</th>
											<th>Deliverer</th>
											<th>Pickup Location</th>
											<th>Delivery Location</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="invoice in invoiceList" class="order-row">
											<td>@{{ parseDateTime(invoice.date) }}</td>
											<td>@{{invoice.orderNumber}}</td>
											<td>@{{invoice.retailerName}}</td>
											<td><span class="invoiceIconSpan"><i
													class="fas fa-file-invoice"></i></span></td>
											<td>
												<div class="progress">
													<div class="progress-bar" role="progressbar"
														style="width: 100%" aria-valuenow="100" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</td>
											<td>@{{ invoice.deliverer}}</td>
											<td>@{{ invoice.pickupLocation }}</td>
											<td>@{{invoice.deliveryLocation}}</td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>
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
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
    	},
    	
        initComplete: function () {
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
            }
        });
    </script>
@endsection
