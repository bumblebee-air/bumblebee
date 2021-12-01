@extends('templates.doorder_dashboard')

@section('page-styles')
<link rel="stylesheet"
	href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css" />
    <style>
        table td{
            text-align: left !important;
        }
    </style>
@endsection

@section('title', 'DoOrder | History Orders')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    	<div class="card">
    						<div class="card-header card-header-icon card-header-rose row">
    							<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">

									<h4 class="card-title my-md-4 mt-4 mb-1">History</h4>
    							</div>
    							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
									<div class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv">
										<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
											<div class="form-group bmd-form-group inputWithIconDiv">
												<img
													src="{{asset('images/doorder-new-layout/calendar-filter-yellow.png')}}"
													alt=""> <input class="form-control inputDate inputFilter"
													id="min" type="text" placeholder="From"
													aria-required="true" name="min">
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
										<div class="col-lg-3 col-md-3  col-sm-4 px-md-1">
											<button id="exportButton" type="submit"
												class="btn-doorder-filter w-100">Export</button>
										</div>
									</div>
								</div>
    						</div>
						</div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-no-bordered table-hover doorderTable ordersListTable"
												id="historyTable" width="100%">
                                        <thead>
                                        	<tr>
                                                <th width="10%">Date/Time</th>
                                                <th width="10%">Order Number</th>
                                                <th width="10%">Retailer Name</th>
                                                <th width="10%">Deliverer</th>
                                                <th width="10%">Trip Route </th>
                                                <th width="10%">Status</th>
                                                <th width="10%" class="text-center">Comments</th>
												<th width="10%" class="disabled-sorting text-center">Actions</th>
                                        	</tr>
                                        </thead>

                                        <tbody>
                                        <tr v-for="order in orders.data" v-if="orders.data.length > 0" @click="openOrder(order.id)" class="order-row">
                                            <td class="orderDateTimeTd">
                                                @{{ order.time }}
                                            </td>
                                            <td>@{{order.order_id.includes('#')? order.order_id : '#'+order.order_id}}</td>
                                            <td>@{{order.retailer_name}}</td>
                                            <td>
                                                @{{ order.driver != null ? order.driver : 'N/A' }}
                                            </td>
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
											 
                                            <td ><span
															v-if="order.status == 'pending'"
															class="orderStatusSpan pendingStatus">Pending fullfilment</span>
															<span v-if="order.status == 'ready'"
															class="orderStatusSpan readyStatus">Ready to Collect</span>
															<span
															v-if="order.status == 'matched' || order.status == 'assigned'"
															class="orderStatusSpan matchedStatus">Matched</span> <span
															v-if="order.status == 'on_route_pickup'"
															class="orderStatusSpan onRoutePickupStatus">On-route to
																Pickup</span> <span v-if="order.status == 'picked_up'"
															class="orderStatusSpan pickedUpStatus">Picked up</span> <span
															v-if="order.status == 'on_route'"
															class="orderStatusSpan onRouteStatus">On-route</span> <span
															v-if="order.status == 'delivery_arrived'"
															class="orderStatusSpan deliveredArrivedStatus">Arrived to
																location</span> <span v-if="order.status == 'delivered'"
															class="orderStatusSpan deliveredStatus">Delivered</span>
															<span v-if="order.status == 'not_delivered'"
															class="orderStatusSpan notDeliveredStatus">Not delivered</span>
														</td>
                                           <td class="text-center actionsTd ">
											 	<img class="order_status_icon" src="{{asset('images/doorder-new-layout/comment-icon-yellow.png')}}" 
                                                    v-if="order.comments.length > 0" 
                                                    data-toggle="tooltip" data-placement="top"
                                                     :title="order.comments[order.comments.length-1].comment">
                                                <img class="order_status_icon" src="{{asset('images/doorder-new-layout/no-comment-grey.png')}}" 
                                                	v-else>
                                               
                                            </td>
                                            <td class="text-center"> <a 
												@click="openOrder(order.id)">
													<img class="viewIcon"
													src="{{asset('images/doorder-new-layout/view-icon.png')}}"
													alt="">
												</a></td>                                    
                                        </tr>
                                        <tr v-else>
                                            <td colspan="8" class="text-center">
                                                <strong>No data found.</strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <nav aria-label="pagination" class="float-right">
                                        {{--                                        {{$clients->links('vendor.pagination.bootstrap-4')}}--}}
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
   
   
<script type="text/javascript"
	src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>
   
<script  type="text/javascript">
  

var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = moment( data[0], "DD MMM YY" ).toDate();
 
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
    
$(document).ready(function() {

	// Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'DD-MM-YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'DD-MM-YYYY'
    });

 var table= $('#historyTable').DataTable({
    	
          fixedColumns: true,
          "lengthChange": false,
          "searching": true,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
  		   "language": {  
            		search: '',
        			"searchPlaceholder": "Search ",
            	   },
//     	 columnDefs: [
//                 {
//                     render: function (data, type, full, meta) {
//                     	return '<span data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
//                     },
//                     targets: [5,6]
//                 }
//              ],
             
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
                orders: {}
            },
            mounted() {
                let orders_socket = io.connect('{{env('SOCKET_URL')}}');
                @if(Auth::guard('doorder')->check() && auth()->user() && auth()->user()->user_role != "retailer")
                orders_socket.on('doorder-channel:new-order'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
                    let decodedData = JSON.parse(data)
                    this.orders.data.unshift(decodedData.data);
                });
                @endif

                orders_socket.on('doorder-channel:update-order-status'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
                    let decodedData = JSON.parse(data);
                    console.log(decodedData);
                    // this.orders.data.filter(x => x.id === decodedData.data.id).map(x => x.foo);
                    let orderIndex = this.orders.data.map(function(x) {return x.id; }).indexOf(decodedData.data.id)
                    if (orderIndex != -1) {
                        this.orders.data[orderIndex].status = decodedData.data.status;
                        this.orders.data[orderIndex].driver = decodedData.data.driver;
                        updateAudio.play();
                    }
                });

                var orders_data = {!! json_encode($orders) !!};

//                 for(let order of orders_data.data) {
//                     let fulfil_time= moment(order.created_at).add(order.fulfilment, 'minutes');
//                     let duration = moment.duration(fulfil_time.diff(moment.now())).asMinutes();
//                     if (duration <= 0) {
//                         order.fulfilment_at = 'Ready'
//                     } else {
//                         order.fulfilment_at = fulfil_time.format('d M HH:mm');
//                     }
//                 }

                this.orders = orders_data;
            },
            methods: {
                openOrder(order_id){
                    window.location.href = "{{url('doorder/single-order')}}/"+order_id;
                }
            }
        });
    </script>
@endsection
