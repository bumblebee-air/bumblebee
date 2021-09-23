@extends('templates.dashboard') @section('page-styles')
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
@endsection @section('title','DoOrder | View Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12" id="map-container">
				<div class="card">
					<div class="card-header card-header-icon card-header-rose">
						<div class="card-icon"><img
								class="page_icon"
								src="{{asset('images/map_icon_card_white.png')}}">
						</div>
						<h4 class="card-title ">Map Routes</h4>
					</div>

					<div class="card-body">
						<div class="row" id="dashboardFilterRowDiv">
							<label class="col-lg-2 col-md-2 col-sm-2 col-form-label filterLabelDashboard">Filter:</label>
							
							<div class="col-lg-3 col-md-3 col-sm-3">
								<div class="form-group bmd-form-group">
									<select class="form-control" id="driverSelect" 
										name="driver" required>
										<option value="">Select driver </option>
										@foreach($drivers as $driver)
											<option value="{{$driver->user_id}}">{{$driver->first_name}} {{$driver->last_name}} </option>
										@endforeach
									</select>	
								</div>
							</div>
							<div class="col-lg-2 col-md-3  col-sm-2">
								<button class="btn btn-primary filterButton" type="button"
									onclick="clickFilter()">Filter</button>
							</div>
						</div>
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
        var colors=['#D2691E','#DAA520','#FF8C00','#a9a9a9','#696969','#778899','#5e70e6','#6a5acd','#4682b4','#9acd32'];
        var icons;
       	let markerAddress ,markerPickup,markerDriver ;
        let directionsService
     
      var routesOpt = [
      			{
      				"deliverer_location": "53.40264481,-6.4309825", 
      				"921945_pickup": "53.4264481,-6.243099098", 
      				"18_pickup": "53.42604481,-6.12499098", 
      				"17_pickup": "53.29034,-6.17659", 
      				"921945_dropoff": "53.289851,-6.24756", 
      				"18_dropoff": "53.304581,-6.205543", 
      				"17_dropoff": "53.34581, -6.25543"},
      			{
      				"deliverer_location": "53.34581,-6.5285543", 
      				"123_pickup": "53.334981, -6.526025", 
      				"45_pickup": "53.32604,-6.531861", 
      				"123_dropoff": "53.234868,-6.539165", 
// 					"123_pickup": "53.2344155,-6.53898908", 
//       				"45_pickup": "53.3430084,-6.52864568", 
//       				"123_dropoff": "53.325824,-6.53175112", 
      				"45_dropoff": "53.2034868,-6.5020463", },
      
      ];
      console.log(routesOpt);
      
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
        
        		 for(var i=0;i<routesOpt.length;i++){
                	var keysss=Object.keys(routesOpt[i]);
                	var waypoints = [];
                	for(var j=1;j<keysss.length-1; j++){
                		console.log(routesOpt[i][keysss[j]]);
                		console.log(keysss[j]);
                		waypoints.push({location: new google.maps.LatLng(routesOpt[i][keysss[j]].split(",")[0],routesOpt[i][keysss[j]].split(",")[1]),
                							stopover: true});
//                    		 makeMarker(new google.maps.LatLng(routesOpt[i][keysss[j]].split(",")[0],routesOpt[i][keysss[j]].split(",")[1]),
//                    		  markerPickup, 'title', map);
							//	makeMarker(leg.start_location, markerPickup, "title", map);
						
// 						var  marker = new google.maps.Marker({
//                               position: new google.maps.LatLng(routesOpt[i][keysss[j]].split(",")[0],routesOpt[i][keysss[j]].split(",")[1]),
//                                 map: map,
//                                zIndex:0,
//                         		anchorPoint: new google.maps.Point(0, 0),
//                         		icon: {
//                                     url:"{{asset('images/doorder_driver_assets/pickup-address-pin-grey.png')}}", // url
//                                     scaledSize: new google.maps.Size(30, 35), // scaled size
//                                 },
//                         });
                    
//                         google.maps.event.addListener(marker, 'click', (function(marker,i,j) {
//                           return function() {
//                             infowindow.setContent(routesOpt[i][keysss[j]].split(",")[0]+','+routesOpt[i][keysss[j]].split(",")[1]);
//                             infowindow.open(map, marker);
//                           }
//                         })(marker, i,j));

					
                	}
                	console.log(waypoints)
                	console.log("----------");
                	var route = {
                		origin:  new google.maps.LatLng(routesOpt[i][keysss[0]].split(",")[0],routesOpt[i][keysss[0]].split(",")[1]),
                		destination: new google.maps.LatLng(routesOpt[i][keysss[keysss.length-1]].split(",")[0],
                						routesOpt[i][keysss[keysss.length-1]].split(",")[1]),
                		waypoints:waypoints,
                		travelMode: google.maps.TravelMode.DRIVING,
                	};
//                 	routes.push(route)
//                }
        		
//         		console.log(routes)
        	    
//             for(var i=0;i<routes.length; i++){
            	directionsRendererArr[dirRendCount] = new google.maps.DirectionsRenderer({ polylineOptions: {
                   strokeColor: colors[i%colors.length]
                 },});
//                          markerOptions: {
//                   icon: {
//                     scaledSize: new google.maps.Size(35, 35), 
//                     url: 'http://res.cloudinary.com/tapsy/image/upload/v1572870098/u_fzktfv.png'
//                   },}
//                          });//suppressMarkers: true
            	directionsRendererArr[dirRendCount].setMap(map);
            	calculateAndDisplayRoute(directionsService, directionsRendererArr[dirRendCount],route);
            	dirRendCount++;
            }
            
                        
    		console.log(directionsRendererArr)
    		console.log(dirRendCount);        
    
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

    
    /*routes = [
            	{	
                  origin:  new google.maps.LatLng(53.49412,-6.4309825),
                  destination: new google.maps.LatLng(53.304581,-6.205543),
                  waypoints: [
                  		{ 	location: new google.maps.LatLng(53.34581, -6.25543),
            				stopover: true,
            			},
                  		{ 	location: new google.maps.LatLng(53.29034,-6.17659),
            				stopover: true,
            			},
                  		{ 	location: new google.maps.LatLng(53.289851,-6.24756),
            				stopover: true,
            			},
                  		{ 	location: new google.maps.LatLng(53.4264481,-6.2499098),
            				stopover: true,
            			},
            	  ],
            	   travelMode: google.maps.TravelMode.DRIVING,
            	},
            	{
                  origin:  new google.maps.LatLng( 53.34981, -6.26025),
                  destination: new google.maps.LatLng(53.049412,-6.04309825),
                  waypoints: [
                  		{ 	location: new google.maps.LatLng(53.34581,-6.285543 ),
            				stopover: true,
            			},
                  		{ 	location: new google.maps.LatLng( 53.32604,-6.31861),
            				stopover: true,
            			},
                  		{ 	location: new google.maps.LatLng( 53.234868,-6.039165),
            				stopover: true,
            			},
                  		{ 	location: new google.maps.LatLng(53.037131,-6.020463 ),
            				stopover: true,
            			},
            	  ],
            	   //travelMode: google.maps.TravelMode.DRIVING,
            	   travelMode: google.maps.TravelMode.WALKING,
            	}
        	];*/
        	
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
                     
                    var keysss=Object.keys(routeTemp);
                	var waypoints = [];
                	for(var j=1;j<keysss.length-1; j++){
                		console.log(routeTemp[keysss[j]]);
                		console.log(keysss[j]);
                		waypoints.push({location: new google.maps.LatLng(routeTemp[keysss[j]].split(",")[0],routeTemp[keysss[j]].split(",")[1]),
                							stopover: true});
				
                	}
                	console.log(waypoints)
                	console.log("----------");
                	var route = {
                		origin:  new google.maps.LatLng(routeTemp[keysss[0]].split(",")[0],routeTemp[keysss[0]].split(",")[1]),
                		destination: new google.maps.LatLng(routeTemp[keysss[keysss.length-1]].split(",")[0],
                						routeTemp[keysss[keysss.length-1]].split(",")[1]),
                		waypoints:waypoints,
                		travelMode: google.maps.TravelMode.DRIVING,
                	};
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
