@extends('templates.dashboard') @section('page-styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css"/>

<style>
.verificationDocs .form-group {
	margin: 8px -15px 8px -15px !important;
}

#driverTable thead tr th {
	border: none !important;
}

#driverTable th, #driverTable td {
	padding-top: 3px !important;
	padding-bottom: 3px !important;
}


.ui-datepicker-calendar td {
	min-width: auto;
}

.ui-draggable, .ui-droppable {
	background-position: top;
}
.dataTables_wrapper.no-footer .dataTables_scrollBody {
	border: none !important;
}

table.dataTable.cell-border tbody th, table.dataTable.cell-border tbody td
	{
	border-right: none !important;
}

.ui-icon-circle-triangle-w {
	background: url('{{asset('images/doorder_icons/angle-arrow-left.png')}}')
		no-repeat center !important;
	background-size: cover;
}

.ui-icon-circle-triangle-e {
	background: url('{{asset('images/doorder_icons/angle-arrow-right.png')}}')
		no-repeat center !important;
	background-size: cover;
}

.dt-datetime-table thead tr th, .dt-datetime-table tbody tr td{
    min-width: 30px !important;
    max-width: 30px !important;
    width: 30px !important;
}

div.dt-datetime {
padding: 1px;
}
div.dt-datetime table th{
padding: 4px 0;
}
div.dt-datetime table td.selectable.now{
background-color: #f7dc69;
color: white;
}
div.dt-datetime table td.selectable button:hover{
background-color: #d6b93d;
}
</style>
@endsection @section('title','DoOrder | Driver ' . $driver->first_name .
' ' . $driver->last_name) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<input type="hidden" name="driver_id" value="{{$driver->id}}" />
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-md-8">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/doorder_icons/Deliverers-white.png')}}">
								</div>
								<h4 class="card-title ">Deliverer Profile</h4>
							</div>
						</div>

						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="table-responsive">

										<table id="driverTable"
											class="table table-no-bordered table-hover doorderTable "
											cellspacing="0" width="100%" style="width: 100%">
											<thead>

												<tr class="theadColumnsNameTr">
													<th>Location</th>
													<th>Name</th>
													<th>Address</th>
													<th>Transport Type</th>
													<th>Work Type</th>
													<th>Shift Time</th>
													<th class="disabled-sorting ">Action</th>
												</tr>
											</thead>

											<tbody>
												<tr class="order-row"
													@click="openViewDriver(event,driver.id)">
													<td>@{{ JSON.parse(driver.work_location).name}}</td>
													<td>@{{ driver.first_name}} @{{ driver.last_name }}</td>
													<td>@{{ driver.address}}</td>

													<td>@{{ driver.transport }}</td>
													<td></td>
													<td></td>
													<td><a
														class="btn  btn-link btn-primary-doorder btn-just-icon edit"
														@click="openDriver(driver.id)"><i class="fas fa-pen-fancy"></i></a>
														<button type="button"
															class="btn btn-link btn-danger btn-just-icon remove"
															@click="clickDeleteDriver(driver.id)">
															<i class="fas fa-trash-alt"></i>
														</button></td>

												</tr>
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-lg-5 col-md-6"></div>
							<div class="col-12 col-lg-7 col-md-6">
								<div class="status">
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_pending.png')}}"
											alt="pending"> pending order fulfilment
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_ready.png')}}"
											alt="ready"> Ready to collect
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_matched.png')}}"
											alt="matched"> Matched
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}"
											alt="matched"> On-route to pickup
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_picked_up.png')}}"
											alt="picked up"> Picked up
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_on_route.png')}}"
											alt="on route"> On-route
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_delivery_arrived.png')}}"
											alt="on route"> Arrived to location
									</div>
									<div class="status_item">
										<img class="status_icon"
											src="{{asset('images/doorder_icons/order_status_delivered.png')}}"
											alt="delivered"> Delivered
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="table-responsive">


										<div class="row" style="margin-left: 0px; margin-right: 0px">
											<div class="col-md-1">
												<label class=" col-form-label filterLabelDashboard">Filter:</label>
											</div>

											<div class="col-md-3">
												<div class="form-group bmd-form-group">
													<!-- <input class="form-control inputDate" id="startDate"
														type="text" placeholder="From" required="true"
														aria-required="true" name="from"> -->
														<input type="text"  class="form-control " placeholder="From"  id="min" name="min">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group bmd-form-group">
													<!-- <input class="form-control inputDate" id="endDate"
														type="text" placeholder="To" required="true"
														aria-required="true" name="to"> -->
														<input type="text"  class="form-control " placeholder="To"  id="max" name="max">
												</div>
											</div>
										</div>


										<table class="table" id="ordersTable" width="100%">
											<thead>
												<tr>
													<th>Date</th>
													<th>Time</th>
													<th>Order Number</th>
													<th>Retailer Name</th>
													<th>Status</th>
													<th>Pickup Location</th>
													<th>Delivery Location</th>
												</tr>
											</thead>

											<tbody>

												<tr v-for="order in orders" v-if="orders.length > 0"
													@click="openOrder(order.id)" class="order-row">
													<td>@{{ parseDate(order.created_at) }}</td>
													<td>@{{ parseTime(order.created_at) }}</td>
													<td>@{{order.order_id.includes('#')? order.order_id :
														'#'+order.order_id}}</td>

													<td>@{{order.retailer_name}}</td>
													<td><img class="order_status_icon"
														:src="'{{asset('/')}}images/doorder_icons/order_status_' + (order.status === 'assigned' ? 'matched' :  order.status) + '.png'"
														:alt="order.status"></td>

													<td>@{{ order.pickup_address }}</td>
													<td>@{{order.customer_address}}</td>
												</tr>

												<tr v-else>
													<td colspan="8" class="text-center"><strong>No data found.</strong>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Delete driver modal -->
					<div class="modal fade" id="delete-driver-modal" tabindex="-1"
						role="dialog" aria-labelledby="delete-deliverer-label"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button"
										class="close d-flex justify-content-center"
										data-dismiss="modal" aria-label="Close">
										<i class="fas fa-times"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="modal-dialog-header deleteHeader">Are you sure you
										want to delete this account?</div>
									<div>
										<form method="POST" id="delete-driver"
											action="{{url('doorder/driver/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="driverId" name="driverId"
												value="{{$driver->id}}" />
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<button type="button"
											class="btn btn-primary doorder-btn-lg doorder-btn"
											onclick="$('form#delete-driver').submit()">Yes</button>
									</div>
									<div class="col-sm-6">
										<button type="button"
											class="btn btn-danger doorder-btn-lg doorder-btn"
											data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- end delete driver modal -->
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript"
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>

<script type="text/javascript">


var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = moment( data[0], "DD-MM-YYYY" ).toDate();
 
 		console.log("min "+min)
 		console.log("max "+max)
 		console.log("date "+date)
 		console.log("sadsadasdsadsdsdasas")
 
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

$( document ).ready(function() {

 // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'DD-MM-YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'DD-MM-YYYY'
    });

var table= $('#ordersTable').DataTable({
    	
          fixedColumns: true,
          "lengthChange": false,
          "searching": true,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
  		  "responsive":true,
    	 columnDefs: [
                {
                    render: function (data, type, full, meta) {
                    	return '<span data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
                    },
                    targets: [-1,-2]
                }
             ],
       
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    	
    });
    
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });
 
    
});

  Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                driver: {!! json_encode($driver) !!},
                orders:{!! json_encode($driver_orders) !!}
            },
            mounted() {
               
            },
            methods: {
                openDriver(driver_id){
                   window.location.href = "{{url('doorder/drivers/')}}/"+driver_id;
                },
                openViewDriver(e,driver_id){
                  e.preventDefault();
                	
                	    if (e.target.cellIndex == undefined) {
                	    }
                		else{
                   			window.location.href = "{{url('doorder/drivers/view/')}}/"+driver_id;
                   		}
                },
                parseDate(date) {
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date(date);
                    let date_moment = new moment(date);
                    /*dateTime += parseDate.getDate() + '/';
                    dateTime += parseDate.getMonth()+1 + '/';
                    dateTime += parseDate.getFullYear() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();*/
                    dateTime = date_moment.format('DD-MM-YYYY');
                    return dateTime;
                },
                 parseTime(date) {
                    let dateTime = '';
                    //let parseDate = new Date(date);
                    let date_moment = new moment(date);
                    /*dateTime += parseDate.getDate() + '/';
                    dateTime += parseDate.getMonth()+1 + '/';
                    dateTime += parseDate.getFullYear() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();*/
                    dateTime = date_moment.format('HH:mm');
                    return dateTime;
                }
            }
        });
        
   
function clickDeleteDriver(driverId){
$('#delete-driver-modal').modal('show')
$('#delete-driver-modal #driverId').val(driverId);

}     
    </script>
@endsection
