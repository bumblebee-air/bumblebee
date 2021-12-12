@extends('templates.doorder_dashboard') @section('page-styles')

<link rel="stylesheet"
	href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
<link rel="stylesheet"
	href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css" />

<style>
.verificationDocs .form-group {
	margin: 8px -15px 8px -15px !important;
}



.dataTables_wrapper.no-footer .dataTables_scrollBody {
	border: none !important;
}

table.dataTable.cell-border tbody th, table.dataTable.cell-border tbody td
	{
	border-right: none !important;
}

.doorderTable tbody tr td, .doorderTable thead tr th{
    min-width: 120px;
}
.overallRating img {
	width: 18px;
	height: 18px;
}
.driverRating img{
    width: 22px;
}

@media ( min-width :768px) and ( max-width :991.5px) {

.driverRating img{
    width: 19px;
}
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
						<div class="card-header   row">
							<div class="col-12 col-lg-4 col-md-5">
								<div class="row">
									<div class="col-3">
										<div class="card-icon card-icon-driver-profile">@{{driver.first_letters}}</div>
									</div>
									<div class="col-9">
										<h4 class="card-title mt-1">@{{ driver.first_name}} @{{
											driver.last_name }}</h4>
										<p class="invoiceTitleP mb-0">@{{driver.email}}</p>

										<div class="row mt-2">
											<div class=" col-md-6 text-center p-sm-1">
												<button class="btn-doorder-filter mb-1 ml-0"
													@click="openDriver(driver.id)">Edit</button>
											</div>
											<div class="col-md-6 text-center p-sm-1">
												<button class="btn-doorder-filter-danger-outline mb-1 ml-0"
													@click="clickDeleteDriver(driver.id)">Delete</button>

											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-xl-7 offset-xl-1 col-lg-8 col-md-7">
								<div class="row mt-1">
									<div class="col-md-4 col-6">
										<label class="viewTitleLabel mb-0 label-display-block">Location</label>
										<label class="viewValueLabel">@{{
											JSON.parse(driver.work_location).name}}</label>
									</div>
									<div class="col-md-4 col-6">
										<label class="viewTitleLabel mb-0 label-display-block">Address</label>
										<label class="viewValueLabel">@{{driver.address}}</label>
									</div>
									<div class="col-md-4 col-6">
										<label class="viewTitleLabel mb-0 label-display-block">Transport</label>
										<label class="viewValueLabel">@{{driver.transport}}</label>
									</div>
									<div class="col-md-4 col-6">
										<label class="viewTitleLabel mb-0 label-display-block">Work
											type</label> <label class="viewValueLabel">@{{driver.email}}</label>
									</div>
									<div class="col-md-4 col-6">
										<label class="viewTitleLabel mb-0 label-display-block">Shift
											time</label> <label class="viewValueLabel">@{{driver.transport}}</label>
									</div>
									<div class="col-md-4 col-6">
										<label class="viewTitleLabel mb-0 label-display-block">Driver
											rating</label>
										<div class="driverRating" :data-score="driver.rating_doorder.rating"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card">

						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-xl-5 col-lg-4 col-md-4 col-sm-12">

								<h4 class="card-title my-4 mb-sm-1">Delivery History</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-8 col-sm-12">

								<div
									class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv">
									<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
										<div class="form-group bmd-form-group inputWithIconDiv">
											<img
												src="{{asset('images/doorder-new-layout/calendar-filter-yellow.png')}}"
												alt=""> <input class="form-control inputDate inputFilter"
												id="min" name="min" type="text" placeholder="From"
												aria-required="true">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
										<div class="form-group bmd-form-group inputWithIconDiv">
											<img
												src="{{asset('images/doorder-new-layout/calendar-filter-yellow.png')}}"
												alt=""> <input class="form-control inputDate inputFilter"
												id="max" name="max" type="text" placeholder="To"
												aria-required="true">
										</div>
									</div>


								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="table-responsive">
										<table
											class="table table-no-bordered table-hover doorderTable tableTextLeft ordersListTableWithYellowTime"
											id="ordersTable" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="10%">Date & Time</th>
													<th width="10%">Order Number</th>
													<th width="10%">Retailer Name</th>
													<th width="10%">Trip Route</th>
													<th width="10%">Retailer Rating</th>
													<th width="10%">Customer Rating</th>
												</tr>
											</thead>

											<tbody>

												<tr v-for="order in orders" v-if="orders.length > 0"
													@click="openOrder(order.id)" class="order-row">
													<td>@{{ parseDate(order.created_at) }} <span
														class="orderTime"> @{{ parseTime(order.created_at) }} </span>
													</td>
													<td>@{{order.order_id.includes('#')? order.order_id :
														'#'+order.order_id}}</td>

													<td>@{{order.retailer_name}}</td>
													<td class="text-left">
														<p style="" class="tablePinSpan tooltipC mb-0">
															<span> <i class="fas fa-map-marker-alt"
																style="color: #747474"></i> <span
																style="width: 20px; height: 0; display: inline-block; border-top: 2px solid #979797"></span>
																<i class="fas fa-map-marker-alt" style="color: #60A244"></i></span>
															<span class="tooltiptextC"> <i class="fas fa-circle"
																style="color: #747474"></i> @{{order.pickup_address}} <br>
																<i class="fas fa-circle" style="color: #60A244"></i>
																@{{order.customer_address}}
															</span>
														</p>

													</td>

													<td><div class="overallRating"
															:data-score="order.rating_retailer"></div></td>
													<td><div class="overallRating"
															:data-score="order.rating_customer"></div></td>
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
									<div class="modal-dialog-header modalHeaderMessage">Are you
										sure you want to delete this account?</div>
									<div>
										<form method="POST" id="delete-driver"
											action="{{url('doorder/driver/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="driverId" name="driverId"
												value="{{$driver->id}}" />
										</form>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btnDoorder btn-doorder-primary mb-1"
											onclick="$('form#delete-driver').submit()">Yes</button>
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
					<!-- end delete driver modal -->
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript"
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript"
	src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>

<script src="{{asset('js/jquery-raty.js')}}"></script>

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
 		//console.log("sadsadasdsadsdsdasas")
 
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
    "pagingType": "full_numbers",
          "ordering": false,
  		  "responsive":true,
    	 	columnDefs: [
                
             ],
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
    	
    });
    
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });
    var driver = {!! json_encode($driver) !!};
    
  $('.overallRating').raty({
  					readOnly: true, 
                    starHalf:     '{{asset("images/doorder_icons/star-half.png")}}',
                	starOff:      '{{asset("images/doorder_icons/star.png")}}',
                	starOn:       '{{asset("images/doorder_icons/star-selected.png")}}',
                	hints: null
        }); 
   $('.driverRating').raty({
  					readOnly: true, 
                    starHalf:     '{{asset("images/doorder_icons/star-half.png")}}',
                	starOff:      '{{asset("images/doorder_icons/star.png")}}',
                	starOn:       '{{asset("images/doorder_icons/star-selected.png")}}',
                	hints: [driver.rating_doorder.comment,driver.rating_doorder.comment,driver.rating_doorder.comment,driver.rating_doorder.comment,driver.rating_doorder.comment]
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
