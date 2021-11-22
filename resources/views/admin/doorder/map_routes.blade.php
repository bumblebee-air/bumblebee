@extends('templates.doorder_dashboard') @section('page-styles')
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
				<div class="card">
					
					<div class="card-body">
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
		</div>
	</div>
</div>
@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script>

$(document).ready(function(){

 $("#driverSelect").select2({});
})

        let map;
        var routes = [];
        var colors=['#D2691E','#4682b4','#FF8C00','#a9a9a9','#DAA520','#696969','#778899','#5e70e6','#6a5acd','#9acd32'];
        var icons;
       	let markerAddress ,markerPickup,markerDriver ;
        let directionsService
     
     	var routesOpt = {!! $map_routes !!}
      
//       var routesOpt = [[   {"deliverer_location": "53.40264481,-6.4309825"},
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
//                     ],[   {"deliverer_location": "53.34581,-6.5285543"},
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
        

            
            for(var i=0;i<routesOpt.length; i++){
                		var routeTemp = routesOpt[i];
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
                    		origin:  new google.maps.LatLng(routeTemp[0]['deliverer_location'].split(",")[0],routeTemp[0]['deliverer_location'].split(",")[1]),
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
                    	calculateAndDisplayRoute(directionsService, directionsRendererArr[dirRendCount],route);
                    	dirRendCount++;
                	}
            
                        
//     		console.log(directionsRendererArr)
//     		console.log(dirRendCount);        
    
        }
        function calculateAndDisplayRoute(directionsService, directionsRenderer,route) {
            directionsService.route(route, function(result, status) {
            	console.log(result);
            	console.log(status)
                if (status == 'OK') {
                	  directionsRenderer.setDirections(result);
                	  
                	  var leg = result.routes[0].legs[0];
                       makeMarker(leg.start_location, markerDriver, "title", map);
                       leg = result.routes[0].legs[result.routes[0].legs.length-1];
                       makeMarker(leg.end_location, markerAddress, 'title', map);
                       
//                        for(var i=1; i<result.routes[0].legs.length; i++){
//                        		console.log(leg.start_location.lat()+","+leg.start_location.lng())
//                        		leg = result.routes[0].legs[i];
//                       		makeMarker(leg.start_location, markerPickup, "title", map);
//                        }
                }
              });
            
        }
        
        function makeMarker(position, icon, title, map) {
        	//console.log(position)
            var marker = new google.maps.Marker({
                position: position,
                 anchorPoint: new google.maps.Point(0, -29),
                map: map,
                icon: icon,
                //title: title
            });
            markersRoutesArr[markerRoutesCount] = marker;
            markerRoutesCount++;
            console.log(markersRoutesArr);
            console.log(markerRoutesCount)
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
                    		origin:  new google.maps.LatLng(routeTemp[0]['deliverer_location'].split(",")[0],routeTemp[0]['deliverer_location'].split(",")[1]),
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
