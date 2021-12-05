@extends('templates.doorder_dashboard') @section('page-styles')

<link
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
	rel="stylesheet"></link>

<style>
div[data-toggle='collapse'] {
	cursor: pointer;
}

.select2-container--default .select2-selection--multiple,
	.select2-container .select2-selection--single {
	padding: 13px 14px 11px 14px;
	border: none !important;
	border-radius: 5px;
	box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
	background-color: #ffffff;
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.66px;
	color: #656565;
	width: 100%;
	height: auto !important;
}

.select2-container .select2-selection--single {
	padding: 11px 14px 11px 14px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered
	{
	line-height: 1.2 !important;
}

.select2-container--default.select2-container--disabled .select2-selection--multiple
	{
	background-color: #fff !important;
}
</style>
@endsection @section('title','DoOrder | Map Routes')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12" id="map-container">
				<div class="card">
					<div class="card-header card-header-icon card-header-rose row">
						<div class="col-12 col-lg-5 col-md-6 col-sm-6">

							<h4 class="card-title my-4">Route Optimization Map</h4>
						</div>

					</div>
				</div>

				<div class="row">
					<div class="col-xl-9 col-md-8 pr-0">
						<div class="card mt-1 mb-0"
							style="background: transparent; box-shadow: none">

							<div class="card-body p-0">
								<!-- 						<div class="row" id="dashboardFilterRowDiv"> -->
								<!-- 							<label class="col-lg-2 col-md-2 col-sm-2 col-form-label filterLabelDashboard">Filter:</label> -->

								<!-- 							<div class="col-lg-3 col-md-3 col-sm-3"> -->
								<!-- 								<div class="form-group bmd-form-group"> -->
								<!-- 									<select class="form-control" id="driverSelect"  -->
								<!-- 										name="driver" required> -->
								<!-- 										<option value="">Select driver </option> -->
								<!-- 										@foreach($drivers as $driver) -->
								<!-- 											<option value="{{$driver->user_id}}">{{$driver->first_name}} {{$driver->last_name}} </option> -->
								<!-- 										@endforeach -->
								<!-- 									</select>	 -->
								<!-- 								</div> -->
								<!-- 							</div> -->
								<!-- 							<div class="col-lg-2 col-md-3  col-sm-2"> -->
								<!-- 								<button class="btn btn-primary filterButton" type="button" -->
								<!-- 									onclick="clickFilter()">Filter</button> -->
								<!-- 							</div> -->
								<!-- 						</div> -->


								<div id="map"
									style="width: 100%; height: 100%; min-height: 550px; margin-top: 0; border-radius: 6px;"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-md-4  " id="driversListContrainer">
						<div class="card mt-1 h-100">
							<div class="card-body p-0">

								<div v-for="(route, index) in map_routes"
									class="card card-driver-map-route">
									<div class="card-header collapsed" data-toggle="collapse"
										:id="'driver-header-'+(route[0].deliverer_id)"
										:data-target="'#driver-routes-'+(route[0].deliverer_id)"
										aria-expanded="true"
										:aria-controls="'driver-routes-'+(route[0].deliverer_id)">
										<div class="row">
											<div class="col-2 p-0 pl-1">
												<div class="card-icon card-icon-driver-profile text-center">@{{route[0].deliverer_first_letter}}</div>
											</div>
											<div class="col-6">
												<h3 class="my-2">@{{route[0].deliverer_name}}</h3>
											</div>

											<div class="col-2 p-0"><span class="collapse-arrow"></span></div>
											<div class="col-2 pr-0 pl-1">
												<button type="button"
													class="remove btnActions btnActionsMapRoutes "
													@click="clickDeleteDriver(event,route[0].deliverer_id,index)">

													<img
														src="{{asset('images/doorder-new-layout/delete-icon.png')}}">
												</button>
											</div>
										</div>
									</div>

									<div :id="'driver-routes-'+(route[0].deliverer_id)"
										class="collapse"
										:aria-labelledby="'driver-header-'+(route[0].deliverer_id)"
										data-parent="#driversListContrainer">
										<div class="card-body p-0">
											<div class="container pb-0">
												<ul class="timeline mb-0 pr-0">
													<li class="timeline-item"
														v-for="driver_route in route.slice(1)">
														<div class="timeline-badge"></div>
														<div class="timeline-panel">
															<div class="timeline-heading">
																<h4 class="timeline-title">
																	Order #@{{driver_route.order_id}} <span
																		v-if="driver_route.type=='dropoff'"
																		class="float-right dropoffPin"> <i
																		class="fas fa-map-marker-alt"></i>
																	</span> <span v-if="driver_route.type=='pickup'"
																		class="float-right pickupPin"> <i
																		class="fas fa-map-marker-alt"></i>
																	</span>
																</h4>
															</div>
														</div>
													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<!-- end div row -->
				<div class="card"
					style="background-color: transparent; box-shadow: none;">
					<div class="card-body p-0">
						<div class="container w-100" style="max-width: 100%">

							<div class="row justify-content-end ">
								<div id="confirmRouteDiv"
									class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
										<a href="{{url('doorder/confirm_route_optimization_map')}}" type="submit" id="confirmRoutesButton"
											class="btnDoorder btn-doorder-primary  mb-1">Confirm</a>
								</div>
								<div id="startRouteDiv"
									class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center"
									style="display: none">
									<button type="button" @click="startRouteOptimization()"
										class="btnDoorder btn-doorder-primary  mb-1">Start</button>
								</div>
								<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">

									<button class="btnDoorder btn-doorder-danger-outline  mb-1"
										type="button" onclick="cancelResultRouteOptimization()">Cancel</button>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- cancel route optimization modal -->
<div class="modal fade" id="cancel-routes-modal" tabindex="-1"
	role="dialog" aria-labelledby="cancel-routes-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
					want to cancel the route optimization?</div>

			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						onclick="confirmCancelRouteOptimization()">Yes</button>
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
<!-- end cancel route optimization modal -->

<!-- delete driver modal -->
<div class="modal fade" id="delete-driver-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-driver-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">This will remove
					the driver and redistribute their orders after you click start.</div>

				<input type="hidden" id="driverId" value="" /> <input type="hidden"
					id="index" value="" />
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						@click="confirmDeleteDriver()">Proceed</button>
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

<!-- confirm route optimization modal  -->
<div class="modal fade" id="confirm-route-optimization-modal"
	tabindex="-1" role="dialog"
	aria-labelledby="confirm-route-optimization-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<img src="{{asset('images/doorder-new-layout/confirm-img.png')}}"
						style="" alt="confirm">
				</div>
				<div class="modal-dialog-header modalHeaderMessage">Starting Route
					Optimization</div>
				<div class="modal-dialog-header modalSubHeaderMessage">Deliveries
					have been confirmed</div>


			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						@click="clickConfirmStartRouteOptimization()">Ok</button>
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
<!-- end confirm route optimization modal  -->

@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script>

    var token = '{{csrf_token()}}';
$(document).ready(function(){

	if($(window).width()>768){
        		$('#minimizeSidebar').trigger('click');
        	}

 $("#driverSelect").select2({});
});

  var app = new Vue({
            el: '#app',
            data: {
                driversIds: {!! json_encode($selectedDrivers) !!},
                selectedOrders: {!! json_encode($selectedOrders) !!},
                map_routes: {!! $map_routes !!}
            },
            mounted() {
            },
            methods: {
                submitForm(e){
                	//e.preventDefault();

                },
                clickDeleteDriver(e,driverId,index){
               		e.stopPropagation();
    				e.preventDefault()
                	console.log("delete driver "+driverId + " "+index)
					$('#delete-driver-modal').modal('show');
					$('#delete-driver-modal #driverId').val(driverId);
					$('#delete-driver-modal #index').val(index);
                },
                confirmDeleteDriver(){
                	console.log("confirm delete driver "+$('#delete-driver-modal #driverId').val() +" "+$('#delete-driver-modal #index').val())
                	var index = $('#delete-driver-modal #index').val();
                	this.driversIds.splice(index, 1);
                	this.map_routes.splice(index, 1);
                	$('#delete-driver-modal').modal('toggle');
                	
                	$("#confirmRouteDiv").css('display','none');
                	$("#startRouteDiv").css('display','block');
                },
                startRouteOptimization(){
                	console.log("start route modal");
                	console.log(this.selectedOrders);
                	console.log(this.driversIds);
                	
                	$('#confirm-route-optimization-modal').modal('show')
                },
                clickConfirmStartRouteOptimization(){
                	console.log(this.driversIds)
                	console.log(this.selectedOrders)
                	$('#confirm-route-optimization-modal').modal('toggle')
                	
                	
                						$("#confirmRouteDiv").css('display','block');
                						$("#startRouteDiv").css('display','none');
                						
                						 $("#confirmRoutesButton").removeAttr('onclick');
                                         $("#confirmRoutesButton").prop("disabled", true);
                                         $("#confirmRoutesButton").removeClass("btn-doorder-primary");
                                         $("#confirmRoutesButton").addClass("btn-doorder-grey");
                                         //   add spinner to button
                                         $("#confirmRoutesButton").html(
                                            ' Wait for a few minutes  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                                         );
                	
                	 $.ajax({
                                type:'POST',
                                url: '{{url("doorder/assign_orders_drivers")}}',
								data: {
                                	_token: token,
                                	selectedOrders: app.selectedOrders.toString(),
                                	selectedDrivers: app.driversIds
                                },
                                success:function(data) {
                                      console.log(data);
                                      console.log(data.mapRoutes);
                                      console.log(data.selectedOrders);
                                      console.log(data.selectedDrivers);
                                      
                                      
                						
                                      
                                      console.log(this.map_routes)
                                      app.map_routes = JSON.parse(data.mapRoutes);
                                      console.log(this.map_routes)
                                       $("#map_routes").val(data.mapRoutes);
                                       app.selectedOrders = data.selectedOrders;
                                       app.driversIds = data.selectedDrivers;
//                                       $("#selectedOrdersMap").val(data.selectedOrders)
//                                       $("#selectedDriversMap").val(data.selectedDrivers)

                                        routesOpt=JSON.parse(data.mapRoutes);
                                                            for(var i=0; i<dirRendCount; i++){
                                                            	directionsRendererArr[i].setMap(null)
                                                            }
                                                            for(var i=0; i<markerRoutesCount; i++){
                                                            	markersRoutesArr[i].setMap(null)
                                                            }
                                                            markersRoutesArr=[];
                                                            markerRoutesCount=0;
                                                            directionsRendererArr=[];
                                                            dirRendCount=0;
                                                            
                                                            getAndDrawRoutes();    
                                                            
                                                            
                                    $("#confirmRoutesButton").prop("disabled", false);
        							$("#confirmRoutesButton").html('Confirm');
                          			$("#confirmRoutesButton").removeClass("btn-doorder-grey");   
                          			$("#confirmRoutesButton").addClass("btn-doorder-primary");                     			
                                 } 
                          });
                }
            }
        });

function cancelResultRouteOptimization(){
	$('#cancel-routes-modal').modal('show')
}
function confirmCancelRouteOptimization(){
	window.location.href = "{{url('doorder/orders')}}";
}
 

////////////////// map
        let map;
        var routes = [];
        var colors=['#D2691E','#4682b4','#FF8C00','#a9a9a9','#DAA520','#696969','#778899','#5e70e6','#6a5acd','#9acd32'];
        var icons;
       	let markerAddress ,markerPickup,markerDriver ;
        let directionsService
     
     	var routesOpt = {!! $map_routes !!}
      
//       var routesOpt = [[   {"coordinates": "53.40264481,-6.4309825"},
//                         {"coordinates": "53.4264481,-6.243099098",
//                             "order_id": "14",
//                             "type": "pickup"},
//                         {"coordinates": "53.42604481,-6.12499098",
//                             "order_id": "13",
//                             "type": "pickup"},
//                         {"coordinates": "53.29034,-6.17659",
//                             "order_id": "15",
//                             "type": "pickup"},
//                         {"coordinates": "53.289851,-6.24756",
//                             "order_id": "14",
//                             "type": "dropoff"},
//                         {"coordinates": "53.304581,-6.205543",
//                             "order_id": "13",
//                             "type": "dropoff"},
//                         {"coordinates": "53.34581, -6.25543",
//                             "order_id": "15",
//                             "type": "dropoff"}
//                     ],[   {"coordinates": "53.34581,-6.5285543"},
//                         {"coordinates": "53.334981, -6.526025",
//                             "order_id": "14",
//                             "type": "pickup"},
//                         {"coordinates": "53.32604,-6.531861",
//                             "order_id": "13",
//                             "type": "pickup"},
//                         {"coordinates": "53.234868,-6.539165",
//                             "order_id": "13",
//                             "type": "dropoff"},
//                         {"coordinates": "53.2034868,-6.5020463",
//                             "order_id": "14",
//                             "type": "dropoff"}
//                     ]];
		console.log(routesOpt)
      
      var directionsRendererArr = [], markersRoutesArr=[];
      var dirRendCount =0, markerRoutesCount=0;     
           
        function initMap() {
        	  var infowindow = new google.maps.InfoWindow();
        	  directionsService = new google.maps.DirectionsService();
        	
        	markerAddress ={
                            url:"{{asset('images/doorder_driver_assets/customer-address-pin.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                        };
        	 markerPickup = {
                            url:"{{asset('images/doorder_driver_assets/pickup-address-pin-grey.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                        };   
            markerDriver = {
                            url:"{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                        };  
                   map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 12,
                        center: {lat: 53.346324, lng: -6.258668},
                        mapTypeControl: false,
              		//	mapTypeId: google.maps.MapTypeId.ROADMAP,
                    });        
        

            getAndDrawRoutes();
          
    
        }
        function getAndDrawRoutes(){
        	  for(var i=0;i<routesOpt.length; i++){
                		var routeTemp = routesOpt[i];
                		console.log(routeTemp)
                		if(routeTemp.length>1){
                    		var waypoints=[];
                    		var destination;
                    		for(var j=1; j<routeTemp.length; j++){
    //                 			console.log(routeOpt[j])
    //                 			console.log("point "+j +" "+routeTemp[j]['coordinates'])
                    			if(j==routeTemp.length-1){
                    				destination = new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0],routeTemp[j]['coordinates'].split(",")[1])
                    			}else{
                    				waypoints.push({location: new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0],routeTemp[j]['coordinates'].split(",")[1]),
                    							stopover: true});	
                    			}				
                    		}
    //                 		console.log(waypoints)
                    		 route = {
                        		origin:  new google.maps.LatLng(routeTemp[0]['coordinates'].split(",")[0],routeTemp[0]['coordinates'].split(",")[1]),
                        		destination: destination,
                        		waypoints:waypoints,
                        		travelMode: google.maps.TravelMode.DRIVING,
                    		};
                    		console.log(route)
                    		console.log("------=====-----");
                    		directionsRendererArr[dirRendCount] = new google.maps.DirectionsRenderer({ polylineOptions: {
                               strokeColor: colors[i%colors.length]
                             },});
                        	directionsRendererArr[dirRendCount].setMap(map);
                        	calculateAndDisplayRoute(directionsService, directionsRendererArr[dirRendCount],route,routeTemp[0]['deliverer_name'],routeTemp[0]['deliverer_first_letter'],routeTemp);
                        	dirRendCount++;
                    	}
                	}
        }
        function calculateAndDisplayRoute(directionsService, directionsRenderer,route,driver_name,driver_first_letters,routeTemp) {
            directionsService.route(route, function(result, status) {
            	console.log(result);
            	console.log(status)
                if (status == 'OK') {
                	  directionsRenderer.setDirections(result);
                	  
                	  var leg = result.routes[0].legs[0];
                       makeMarker(leg.start_location, markerDriver, "title", map,driver_name,driver_first_letters,null);
                       leg = result.routes[0].legs[result.routes[0].legs.length-1];
                       makeMarker(leg.end_location, markerAddress, 'title', map,null,null,routeTemp[result.routes[0].legs.length]['order_id']);
                       
                       for(var i=0; i<result.routes[0].legs.length; i++){
                       		//console.log(leg.start_location.lat()+","+leg.start_location.lng())
                       		console.log(routeTemp[i+1]['type'])
                       		
                       		leg = result.routes[0].legs[i];
                       		                       		
//                        		if(i==1){
//                        			makeMarker(leg.start_location, markerPickup, "title", map,null,null);
//                        		}
							console.log(routeTemp[i+1]['order_id'])
                       		if(routeTemp[i+1]['type']==='pickup'){
                      			makeMarker(leg.end_location, markerPickup, "title", map,driver_name,null,routeTemp[i+1]['order_id']);
                      		}
                      		else if(routeTemp[i+1]['type']==='dropoff'){
                      			makeMarker(leg.end_location, markerAddress, "title", map,driver_name,null,routeTemp[i+1]['order_id']);
                      		}	
                       }
                }
              });
            
        }
        
        function makeMarker(position, icon, title, map,driver_name,driver_first_letters,order_number) {
        	console.log(order_number)
            var marker = new google.maps.Marker({
                position: position,
                 anchorPoint: new google.maps.Point(0, -29),
                map: map,
                icon: icon,
                title: driver_first_letters
            });
            
            if(driver_name != null){
            	var content = driver_name;
            	console.log(order_number)
            	if(order_number!=null){
            		content += '<br> Order #'+order_number;
            	}
            	const infowindow = new google.maps.InfoWindow({
                    content: content,
                  });
                  
               //   marker.setLabel(driver_first_letters);
                                  
                  marker.addListener("click", () => {
                    infowindow.open({
                      anchor: marker,
                      map,
                      shouldFocus: false,
                    });
                  });
            }
            
            markersRoutesArr[markerRoutesCount] = marker;
            markerRoutesCount++;
//             console.log(markersRoutesArr);
//             console.log(markerRoutesCount)
        }
        	
        function clickFilter(){
        	var driverId = $("#driverSelect").val();
        	console.log("click filter "+driverId);
        	
        	 $.ajax({
                   type:'GET',
                   url: '{{url("doorder/get_route_driver")}}'+'?driverId='+driverId,
                   success:function(data) {
                      console.log(data);
                      var routeTemp = data.route;
                      
                    for(var i=0; i<dirRendCount; i++){
                    	directionsRendererArr[i].setMap(null)
                    }
                    for(var i=0; i<markerRoutesCount; i++){
                    	markersRoutesArr[i].setMap(null)
                    }
                    markersRoutesArr=[];
                    markerRoutesCount=0;
                    directionsRendererArr=[];
                    dirRendCount=0;
                     
                    var waypoints=[];
                		var destination;
                		for(var j=1; j<routeTemp.length; j++){
//                 			console.log(routeTemp[j])
//                 			console.log("point "+j +" "+routeTemp[j]['coordinates'])
                			if(j==routeTemp.length-1){
                				destination = new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0],routeTemp[j]['coordinates'].split(",")[1])
                			}else{
                				waypoints.push({location: new google.maps.LatLng(routeTemp[j]['coordinates'].split(",")[0],routeTemp[j]['coordinates'].split(",")[1]),
                							stopover: true});	
                			}				
                		}
//                 		console.log(waypoints)
                		var route = {
                    		origin:  new google.maps.LatLng(routeTemp[0]['coordinates'].split(",")[0],routeTemp[0]['coordinates'].split(",")[1]),
                    		destination: destination,
                    		waypoints:waypoints,
                    		travelMode: google.maps.TravelMode.DRIVING,
                		};
                		console.log(route)
                		console.log("------=====-----");
                		
                	
                  	directionsRendererArr[dirRendCount] = new google.maps.DirectionsRenderer({ polylineOptions: {
                           strokeColor: colors[6]
                         },});
        	       	directionsRendererArr[dirRendCount].setMap(map);
                    	calculateAndDisplayRoute(directionsService, directionsRendererArr[dirRendCount],route);
                      dirRendCount++;
                      
                   }
             });         
        }	
    </script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
