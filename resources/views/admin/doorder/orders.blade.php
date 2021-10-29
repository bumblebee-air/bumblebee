@extends('templates.doorder_dashboard') @section('page-styles')
<style>
</style>
@endsection @section('title', 'DoOrder | Orders')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-lg-5 col-md-6">

								<h4 class="card-title my-4">Orders List</h4>
							</div>
							<div class="col-12 col-lg-7 col-md-6">
								<div class="row justify-content-end float-sm-right">

									<ul class="nav nav-pills ordersListPills my-3" id="pills-tab"
										role="tablist">
										<li class="nav-item"><a class="nav-link active"
											id="pills-list-tab" data-toggle="pill" href="#ordersListView"
											role="tab" aria-controls="ordersListView"
											aria-selected="false">Switch to list view</a></li>
										<li class="nav-item"><a class="nav-link "
											id="pills-calendar-tab" data-toggle="pill"
											href="#ordersCalendarView" role="tab"
											aria-controls="ordersCalendarView" aria-selected="true">Switch
												to calendar view</a></li>
									</ul>

								</div>
							</div>
						</div>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade " id="ordersCalendarView"
							role="tabpanel" aria-labelledby="pills-calendar-tab">calendar</div>
						<div class="tab-pane fade show active" id="ordersListView"
							role="tabpanel" aria-labelledby="pills-list-tab">
							<div class="card">
								<div class="card-body">
									<div class="float-right"></div>
									<div class="table-responsive">
										<table
											class="table table-no-bordered table-hover doorderTable ordersListTable"
											id="ordersTable" width="100%">
											<thead>
												<tr>
													<th>Date/Time</th>
													<th>Order Number</th>
													<th>Order Time</th>
													<th>Retailer Name</th>
													<th>Status</th>
													<th>Deliverer</th>
													<th>Location</th>
												</tr>
											</thead>

											<tbody>

												<tr v-for="order in orders.data"
													v-if="orders.data.length > 0" @click="openOrder(order.id)"
													class="order-row">
													<td>@{{ order.time }}</td>
													<td>@{{order.order_id.includes('#')? order.order_id :
														'#'+order.order_id}}</td>
													<td>@{{order.fulfilment_at}}</td>
													<td>@{{order.retailer_name}}</td>
													<td><span v-if="order.status == 'pending'"
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
														class="orderStatusSpan deliveredStatus">Delivered</span> <span
														v-if="order.status == 'not_delivered'"
														class="orderStatusSpan notDeliveredStatus">Not delivered</span>

														<!--                                                 	<img class="order_status_icon"  -->
														<!--                                                 	:src="'{{asset('/')}}images/doorder_icons/order_status_' + (order.status === 'assigned' ? 'matched' :  order.status) + '.png'" :alt="order.status"> -->

													</td>

													<td>@{{ order.driver != null ? order.driver : 'N/A' }}</td>
													<td>
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

												</tr>

												<tr v-else>
													<td colspan="8" class="text-center"><strong>No data found.</strong>
													</td>
												</tr>
											</tbody>
										</table>
										
									</div>
									<div class="d-flex justify-content-end mt-3">
											{{$orders->links()}}</div>
								</div>
							</div>
							<!-- end card - table -->
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
	integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
	crossorigin="anonymous"></script>
<script>
    
    
$(document).ready(function() {


 var table= $('#ordersTable').DataTable({
    	
          fixedColumns: true,
          "lengthChange": false,
          "searching": true,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
  		  "responsive":true,
  		  "language": {  
    		search: '',
			"searchPlaceholder": "Search ",
    	   },
//     	 columnDefs: [
//                 {
//                     render: function (data, type, full, meta) {
//                     	return '<span data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
//                     },
//                     targets: [-1,-2]
//                 }
//              ],
       
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    	
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

                for(let order of orders_data.data) {
                    let fulfil_time= moment(order.created_at).add(order.fulfilment, 'minutes');
                    let duration = moment.duration(fulfil_time.diff(moment.now())).asMinutes();
                    if (duration <= 0) {
                        order.fulfilment_at = 'Ready'
                    } else {
                        order.fulfilment_at = fulfil_time.format('D MMMM HH:mm');
                    }
                }

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
