@extends('templates.doorder_dashboard') @section('page-styles')

<link href="{{asset('css/fullcalendar.css')}}" rel="stylesheet">

<link rel="stylesheet"
	href="{{asset('css/doorder-calendar-styles.css')}}">

<link
	href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css"
	rel="stylesheet">

<style>
.fc-unthemed .fc-popover{
height: auto;
max-height: 330px;
overflow-y: auto; 
}
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
							<div class="col-12 col-lg-5 col-md-6 col-sm-6">
								<h4 class="card-title my-4">Orders List</h4>
							</div>
							<div class="col-12 col-lg-7 col-md-6 col-sm-6">
								<div class="row justify-content-end float-sm-right">
								@if(auth()->user()->user_role != 'retailer' )
									<ul class="nav nav-pills ordersListPills my-sm-3 mt-0 mb-1"
										id="pills-tab-orders" role="tablist">
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
								@endif	

								</div>
							</div>
						</div>
					</div>
					<div class="tab-content" id="pills-tab-ordersContent">
						<div class="tab-pane fade" id="ordersCalendarView" role="tabpanel"
							aria-labelledby="pills-calendar-tab">
							<div class="card">

								<div class="card-body pr-0 py-0">
									<div class="">
										<div class="row">
											<div class="col-lg-2 col-md-3 px-1">
												<div id="filterByStatusDiv" class="calendarFilterDiv">
													<h3 class="calendarFilterH3">Filter by status</h3>

													<div class="row "
														style="margin-left: -3px; margin-right: -10px;">

														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel viewAllLabel"
																for="view-all-status"> <input type="checkbox"
																value="all" checked="checked" class="form-check-input"
																id="view-all-status" name="filterByStatus" /> View all <span
																class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel pendingStatusLabel"
																for="pending-status"> <input type="checkbox"
																value="pending" class="form-check-input"
																id="pending-status" name="filterByStatus" /> Pending
																fullfilment <span class="form-check-sign"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel readyStatusLabel"
																for="ready-status"> <input type="checkbox" value="ready"
																class="form-check-input" id="ready-status"
																name="filterByStatus" /> Ready to Collect <span
																class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel matchedStatusLabel"
																for="matched-status"> <input type="checkbox"
																value="matched" class="form-check-input"
																id="matched-status" name="filterByStatus" /> Matched <span
																class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel on_route_pickupStatusLabel"
																for="on_route_pickup-status"> <input type="checkbox"
																value="on_route_pickup" class="form-check-input"
																id="on_route_pickup-status" name="filterByStatus" />
																On-route to pickup <span class="form-check-sign"> <span
																	class="check"></span>
															</span>
															</label>
														</div>

														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel picked_upStatusLabel"
																for="picked_up-status"> <input type="checkbox"
																value="picked_up" class="form-check-input"
																id="picked_up-status" name="filterByStatus" /> Picked up
																<span class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel on_routeStatusLabel"
																for="on_route-status"> <input type="checkbox"
																value="on_route" class="form-check-input"
																id="on_route-status" name="filterByStatus" /> On-route <span
																class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>


														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel delivery_arrivedStatusLabel"
																for="delivery_arrived-status"> <input type="checkbox"
																value="delivery_arrived" class="form-check-input"
																id="delivery_arrived-status" name="filterByStatus" />
																Arrived to location <span class="form-check-sign"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel deliveredStatusLabel"
																for="delivered-status"> <input type="checkbox"
																value="delivered" class="form-check-input"
																id="delivered-status" name="filterByStatus" /> Delivered
																<span class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel not_deliveredStatusLabel"
																for="not_delivered-status"> <input type="checkbox"
																value="not_delivered" class="form-check-input"
																id="not_delivered-status" name="filterByStatus" /> Not
																delivered <span class="form-check-sign"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
													</div>
												</div>
												<div id="filterByRetailerDiv" class="calendarFilterDiv"
													data-spy="scroll" data-target=".filter-retailers-container">

													<h3 class="calendarFilterH3">Filter by retailer</h3>
													<div class="row filter-retailers-container  overflow-auto"
														style="max-height: 400px; height: 100%; margin-left: -5px; margin-right: -6px;">
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel viewAllLabel"
																for="view-all-retailer"> <input type="checkbox"
																value="all" checked="checked" class="form-check-input"
																id="view-all-retailer" name="filterByRetailer" /> View
																all <span class="form-check-sign"> <span class="check"></span>
															</span>
															</label>
														</div>
														@foreach($retailers as $retailer)
														<div class="form-check col-6 col-md-12">
															<label
																class="form-check-label calendarFilterLabel retailerStatusLabel"
																for="retailer_{{$retailer->id}}"> <input type="checkbox"
																value="{{$retailer->id}}" class="form-check-input"
																id="retailer_{{$retailer->id}}" name="filterByRetailer" />
																{{$retailer->name}} <span class="form-check-sign"> <span
																	class="check"></span>
															</span>
															</label>
														</div>
														@endforeach
														

													</div>
												</div>
											</div>
											<div class="col-lg-10 col-md-9 pl-0 containerCalendarDiv">

												<div id='calendar'></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade  show active" id="ordersListView"
							role="tabpanel" aria-labelledby="pills-list-tab">
							<form method="POST" id="delete-driver"
								action="{{url('doorder/assign_orders')}}"
								style="margin-bottom: 0 !important;">
								{{csrf_field()}}
								<div class="card">
									<div class="card-body">
										<div class="float-right"></div>
										<div class="table-responsive">
											<table
												class="table table-no-bordered table-hover doorderTable ordersListTable"
												id="ordersTable" width="100%">
												<thead>
													<tr>
														@if(auth()->user()->user_role == 'client' || auth()->user()->user_role =='admin' )
														<th width="5%"></th>
														@endif
														<th>Date/Time</th>
														<th>Order Number</th>
														<th>Order Time</th>
														<th>Retailer</th>
														<th>Status</th>
														<th>Deliverer</th>
														<th>Location</th>
													</tr>
												</thead>

												<tbody>

													<tr v-for="order in orders.data"
														v-if="orders.data.length > 0"
														@click="openOrder(event,order.id)" class="order-row" :data-orderId="order.id">
														
														@if(auth()->user()->user_role == 'client' || auth()->user()->user_role =='admin' )
														<td class="p-3">
															<input type="checkbox" name="selectedOrders[]" v-bind:value="order.id">
														
														</td>
														@endif
														<td class="text-left orderDateTimeTd">@{{ order.time }}</td>
														<td class="text-left">@{{order.order_id.includes('#')?
															order.order_id : '#'+order.order_id}}</td>
														<td class="text-left">@{{order.fulfilment_date}}</td>
														<td class="text-left">@{{order.retailer_name}}</td>
														<td class="text-left"><span
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

															<!--                                                 	<img class="order_status_icon"  -->
															<!--                                                 	:src="'{{asset('/')}}images/doorder_icons/order_status_' + (order.status === 'assigned' ? 'matched' :  order.status) + '.png'" :alt="order.status"> -->

														</td>

														<td class="text-left">@{{ order.driver != null ?
															order.driver : 'N/A' }}</td>
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
								@if(auth()->user()->user_role == 'client' )
								<div class="card"
									style="background-color: transparent; box-shadow: none;">
									<div class="card-body p-0">
										<div class="container w-100" style="max-width: 100%">

											<div class="row justify-content-center ">
												<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">

													<button class="btnDoorder btn-doorder-primary disabled  mb-1" id="submitAssignOrderBtn"
														@click="submitForm">Assign orders</button>
												</div>
											</div>

										</div>
									</div>
								</div>
								@endif
							</form>
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

<script src="{{asset('js/fullcalendar.js')}}"></script>
 <script
	src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>


<script>
    
    var token = '{{csrf_token()}}';
	 var table;
	 var userRole = '{!! auth()->user()->user_role  !!}';
	 console.log(userRole)
	 
$(document).ready(function() {
////////////////////////////////////////// calendar
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		var calendar =  $('#calendar').fullCalendar({
			header: {
				//left: 'title',
				left:'prev,next title',
				center: '',
				right:'month,agendaWeek,agendaDay today'
				//center: 'agendaDay,agendaWeek,month',
				//right: 'prev,next today'
			},
   	 		eventorder: "-title",
			editable: true,
			firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			contentHeight:'auto',
			defaultView: 'month',
			displayEventTime: false,
			
			droppable: false, // this allows things to be dropped onto the calendar !!!
			disableDragging: true,
			
     		eventLimit: 3,
     		
			eventRender: function(event, element) {
				console.log("---------------------------")
				console.log(filter(event))
                return filter(event);
              }    ,
        	
       		events: function(start_date, end_date,timezone, callback) {
       			
    				$.ajax({
    					type:'GET',
    					url: '{{url("doorder/calendar-orders-events")}}',
    					 data: {
                            // our hypothetical feed requires UNIX timestamps
                            start_date: Math.round(start_date/ 1000),
                            end_date: Math.round(end_date / 1000),
                         },
    					success:function(data) {
//         					console.log(data);
//         					console.log(JSON.parse(data.events))	
//         					console.log((data.orders))	
    						//console.log(view.title);
    						
    						//contractors = data.contractors;
    						callback(JSON.parse(data.events));
    						
    					}
    				});
    				
			},
        	
			eventAfterAllRender: function(){
				
            }, 
			 
			 eventClick: function(calEvent, jsEvent, view) {
			 	console.log("click event "+calEvent+" "+calEvent.className);
			 	console.log(calEvent)
			 	console.log(calEvent.start)
			 	 window.location.href = "{{url('doorder/single-order')}}/"+calEvent.id;
// 			 	if(calEvent.className=='expireContract'){    
// 			 		getContractsExpiredData(calEvent.start,token,'{{url("unified/")}}');
// 			 	}else{
// 			 		getDetialsOfDate(calEvent.start,calEvent.serviceId,token,'{{url("unified/")}}');
// 			 	} 
 			 }	,
 			 dayClick: function(date, allDay, jsEvent, view) {
              // getDetialsOfDate(date,0,token,'{{url("unified/")}}');
               
			                   
        	}
		});
		
		$('input[name="filterByStatus"]').on('change', function() {
      	  $('#calendar').fullCalendar('rerenderEvents');
      	});
      	
		$('input[name="filterByRetailer"]').on('change', function() {
      	  $('#calendar').fullCalendar('rerenderEvents');
      	});
      	
      	function filter(calEvent) {
          var vals = [];
          $('input[name="filterByStatus"]:checked').each(function() {
            vals.push($(this).val());
          });
          
          if(calEvent.status==='assigned'){
          		calEvent.status = 'matched';
          }
          
          var valsR = [];
          $('input[name="filterByRetailer"]:checked').each(function() {
            valsR.push($(this).val());
          });
          
          console.log(vals)
          console.log(valsR)
          if(vals.indexOf('all') !== -1 && valsR.indexOf('all') !== -1){
          	return true
          }else if(vals.indexOf('all') !== -1 && valsR.indexOf(''+calEvent.retailer_id) !== -1){
          	return true;
          }
          else if(valsR.indexOf('all') !== -1 && vals.indexOf(''+calEvent.status) !== -1){
          	return true
          }
          return vals.indexOf(''+calEvent.status) !== -1 && valsR.indexOf(''+calEvent.retailer_id) !== -1;
    	}

//////////////////////////////////////////
    if(userRole == 'client' || userRole == 'admin'){
        table= $('#ordersTable').DataTable({
            	
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
            	  'columnDefs': [
                     {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0,
                     }
                  ],
                  'select': {
                     'style': 'multi'
                  },
               
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 0,
                },
            	
            });
            table.on( 'selectItems', function ( e, dt, items ) {
                console.log( 'Items to be selected are now: ', items );
            } );
            table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            	 var row = dt.row( cell.index().row );
               	 //console.log(row.data()[6])
            	 
            	 if(row.data()[6] === 'N/A'){           	   
                   	if($(originalEvent.target).children().is(':checked')){
                    	$(originalEvent.target).children().attr('checked',false)
                    }else{
                    	$(originalEvent.target).children().attr('checked','checked')
                    }
                 }else{
                	e.preventDefault();
                 }	
                
                
            	var selectedOrders = $('input[name="selectedOrders[]"]:checked');
            	if(selectedOrders.length >=2){
            		$("#submitAssignOrderBtn").removeClass('disabled');
            	}
            	else{
            		$("#submitAssignOrderBtn").addClass('disabled');
            	}	
            } );
            
         }    
         else{
        	table= $('#ordersTable').DataTable({
            	
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
               
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 0,
                },
            	
            });
            
         }   
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
                openOrder(e,order_id){
                	e.preventDefault();
                	//console.log(e.target.cellIndex )
                	if (e.target.cellIndex == undefined || e.target.cellIndex == 0) {
                	    	
                	}
                	else{
                    	window.location.href = "{{url('doorder/single-order')}}/"+order_id;
                    }
                }, 
                submitForm(e){
                	//e.preventDefault();

                }
            }
        });
    </script>
@endsection
