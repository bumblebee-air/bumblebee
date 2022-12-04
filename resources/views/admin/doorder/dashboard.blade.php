@extends('templates.doorder_dashboard') @section('title', 'DoOrder |
Dashboard') @section('page-styles')
<link rel="stylesheet"
	href="{{asset('css/chartist-plugin-tooltip.css')}}">

<style>
.ui-datepicker-calendar td {
	min-width: auto;
}

.ui-draggable, .ui-droppable {
	background-position: top;
}

.alert {
	padding: 0.5rem !important;
	font-size: 16px;
	display: none;
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

.ct-legend {
	position: relative;
	z-index: 10;
	list-style: none;
	text-align: right;
	top: -19px;
	margin-bottom: 0;
}

.ct-chart .ct-legend li {
	position: relative;
	padding-left: 23px;
	margin-right: 10px;
	margin-bottom: 3px;
	cursor: pointer;
	display: inline-block;
	font-style: normal;
	font-weight: bold;
	font-size: 13px;
	line-height: 21px;
	color: #000000;
}

#chart .ct-legend li {
	color: #645b5b !important;
}

.ct-chart .ct-legend li.inactive {
	font-weight: normal;
}

.ct-chart .ct-legend li:before {
	width: 12px;
	height: 12px;
	position: absolute;
	content: "";
	border: 3px solid transparent;
	border-radius: 50%;
	left: 8px;
	top: 4px;
}

.ct-chart .ct-legend li .inactive:before {
	background: transparent;
}

.ct-legend li:nth-child(1)::before {
	background-color: #F8C140;
}

.ct-legend li:nth-child(2)::before {
	background-color: #60A244;
}

.ct-chart .ct-legend .ct-legend-inside {
	position: absolute;
	top: 0;
	right: 0;
}

#chart g:not(.ct-grids):not(.ct-labels) g:nth-child(1) .ct-point,
	#chart1 g:not(.ct-grids):not(.ct-labels) g:nth-child(1) .ct-line {
	stroke: #e9c218;
}

#chart g:not(.ct-grids):not(.ct-labels) g:nth-child(2) .ct-point,
	#chart1 g:not(.ct-grids):not(.ct-labels) g:nth-child(2) .ct-line {
	stroke: #E5EAEE;
}
</style>

@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row" id="dashboardCardDiv">
			<div class="col-md-12" id="">
				<div class="card">
					<div class="card-header card-header-icon  row">
						<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">
							<h4 class="card-title my-md-4 mt-4 mb-1">Dashboard</h4>
						</div>
						<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
							<div class="row justify-content-end float-sm-right my-0"
								style="margin-left: 10px">
								<p id="errorMesssage" class="alert alert-danger m-0"></p>
							</div>
							<div class="row justify-content-end mb-1 mt-2 mt-xs-0"
								id="dashboardFilterRowDiv">
								<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
									<div class="form-group bmd-form-group">
										<input class="form-control inputDate inputFilter"
											id="startDate" type="text" data-toggle="datetimepicker"
											data-target="#startDate" placeholder="From" required="true"
											aria-required="true">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
									<div class="form-group bmd-form-group">
										<input class="form-control inputDate inputFilter" id="endDate"
											type="text" placeholder="To" required="true"
											aria-required="true">
									</div>
								</div>
								<div class="col-lg-3 col-md-3  col-sm-4 px-md-1">
									<button class=" btn-doorder-filter w-100" type="button"
										onclick="clickFilter()">Filter</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-7 col-md-7 col-sm-6">
						<div class="row" style="display: flex; flex-wrap: wrap;">
							<div class="col-6 pr-1">
								<div class="card card-stats">
									<a href="{{route('doorder_ordersTable', 'doorder')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-8 ">
													<h3 id="ordersValueH3"
														class="card-title cardDashboardValueH3">{{$all_orders_count}}</h3>
													<p class="card-category">Orders</p>
													<div class="card-footer">
														<div class="stats" id="ordersStatsTime">Today</div>
													</div>
												</div>
												<div
													class="col-4 dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder-new-layout/orders-dashboard-yellow.png')}}"
															alt="orders icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-6 pl-1">
								<div class="card card-stats">
									<a href="{{route('doorder_retailers_requests', 'doorder')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-8 ">
													<h3 id="newRetailersValueH3"
														class="card-title cardDashboardValueH3">{{$retailers_count}}</h3>
													<p class="card-category">New Retailers</p>
													<div class="card-footer">
														<div class="stats" id="newRetailersStatsTime">This month</div>
													</div>
												</div>
												<div
													class="col-4  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder-new-layout/retailers-dashboard-yellow.png')}}"
															alt="new retailers icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-6 pr-1">
								<div class="card card-stats">
									<a href="{{route('doorder_getInvoiceList', 'doorder')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-8 ">
													<h3 id="deliveryValueH3"
														class="card-title cardDashboardValueH3">{{$delivered_orders_count}}</h3>
													<p class="card-category">Delivery</p>
													<div class="card-footer">
														<div class="stats" id="deliveryStatsTime">Today</div>
													</div>
												</div>
												<div
													class="col-4  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder-new-layout/delivered-dashboard-yellow.png')}}"
															alt="delivery icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-6 pl-1">
								<div class="card card-stats">
									<a href="{{route('doorder_drivers_requests', 'doorder')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-8 ">
													<h3 id="newDeliverersValueH3"
														class="card-title cardDashboardValueH3">{{$deliverers_count}}</h3>
													<p class="card-category">New Deliverers</p>
													<div class="card-footer">
														<div class="stats" id="newDeliverersStatsTime">This month</div>
													</div>
												</div>
												<div
													class="col-4  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder-new-layout/drivers-dashboard-yellow.png')}}"
															alt="new deliverers icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card mt-1">
									<div class="cardContentTableDiv">
										<div class="card-header">
											<h3 class="card-title tableDashboardH3">
												Statistics <span>Orders Per Month</span>
											</h3>
										</div>
										<div class="card-body">

											<div class="row">
												<div class="col-md-12">
													<div class="ct-chart"></div>
												</div>
											</div>
											<div class="row weekMonthData">
												<div class="col-6">
													<h3 class="chartDataH3">Weekly</h3>
													<div class="row">
														<div class="col-6">
															<p class="chartDataLabel">This week</p>
															@if($thisWeekPercentage>=0)
															<h5
																class="chartDataValue chartDataValueThis chartDataValuePlus"
																id="thisWeekLabel">{{$thisWeekPercentage}}%</h5>
															@else
															<h5
																class="chartDataValue chartDataValueThis chartDataValueMinus"
																id="thisWeekLabel">{{$thisWeekPercentage}}%</h5>
															@endif
														</div>
														<div class="col-6">
															<p class="chartDataLabel">Last week</p>
															<h5 class="chartDataValue chartDataValueLast"
																id="lastWeekLabel">{{$lastWeekPercentage}}%</h5>
														</div>
													</div>
												</div>
												<div class="col-6">
													<h3 class="chartDataH3">Monthly</h3>
													<div class="row">
														<div class="col-6">
															<p class="chartDataLabel">This month</p>
															@if($thisMonthPercentage>=0)
															<h5
																class="chartDataValue chartDataValueThis chartDataValuePlus"
																id="thisMonthLabel">{{$thisMonthPercentage}}%</h5>
															@else
															<h5
																class="chartDataValue chartDataValueThis chartDataValueMinus"
																id="thisMonthLabel">{{$thisMonthPercentage}}%</h5>
															@endif
														</div>
														<div class="col-6">
															<p class="chartDataLabel">Last month</p>
															<h5 class="chartDataValue chartDataValueLast"
																id="lastMonthLabel">{{$lastMonthPercentage}}%</h5>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="col-lg-5 col-md-5 col-sm-6">

						<div class="row">
							<div class="col-12">
								<div class="card mt-0">
									<div class="cardContentTableDiv">
										<div class="card-header">
											<h3 class="card-title tableDashboardH3">
												Deliverers Charges <span>Per Week</span>
											</h3>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-md-12">
													<table id="deliverersChargesPerWeekTable"
														class="table  table-no-bordered table-hover doorderTable doorderDashboardTable "
														width="100%">
														<thead>
															<tr>
																<th>Deliverers</th>
																<th>No Of Orders</th>
																<th>Payment (€)</th>
															</tr>
														</thead>
														<tbody>
															@foreach($deliverers_order_charges as $obj)
															<tr>
																<td class="nameTd">{{$obj->deliverer_name}}</td>
																<td class="countTd">{{$obj->order_count}}</td>
																<td class="chargeTd">{{$obj->order_charge}}</td>
															</tr>
															@endforeach

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="card mt-0">
									<div class="cardContentTableDiv">
										<div class="card-header">
											<h3 class="card-title tableDashboardH3">
												Retailers Charges <span>Per Month</span>
											</h3>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-md-12">
													<table id="retailersChargesPerMonthTable"
														class="table  table-no-bordered table-hover doorderTable doorderDashboardTable "
														width="100%">
														<thead>
															<tr>
																<th>Retailers</th>
																<th>No Of Orders</th>
																<th>Charges (€)</th>
															</tr>
														</thead>
														<tbody>
															@foreach($retailers_order_charges as $objr)
															<tr>
																<td>{{$objr->retailer_name}}</td>
																<td>{{$objr->order_count}}</td>
																<td>{{$objr->order_charge}}</td>
															</tr>
															@endforeach
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
				</div>
				
				<div class="mapContainerDiv">
					<div class="row">
						<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">
							<h3 class="card-title tableDashboardH3">Live Map</h3>
						</div>
						<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
							<div class="row justify-content-end    mb-1 mt-2 mt-xs-0" id="">
								<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
									<div class="form-group selectShowPinsContainer">
										<select  id="showMapPinsSelect"
										data-style="select-with-transition"
													class="form-control selectpicker" onchange="changeShowPinsSelect()">
											<option value="all">Show all</option>
											<option value="driver">Deliverers</option>
											<option value="pickup">Pickups</option>
											<option value="dropoff">Drop off</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
									<div class="form-group bmd-form-group">
										<input class="form-control inputFilter" id="search_map"
											type="search" placeholder="Search" required="true">
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-4 pl-md-1">
									<button class=" btn-doorder-filter w-100" type="button"
										onclick="clickSearch()">Search</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12" id="map-container">
							<div class="card mt-1">
								<div id="map"
									style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/chartist-plugin-legend/0.6.1/chartist-plugin-legend.min.js"></script>

<script type="text/javascript"
	src="https://cdn.jsdelivr.net/npm/chartist-plugin-pointlabels@0.0.6/dist/chartist-plugin-pointlabels.min.js"> </script>

<script type="text/javascript">
function showHideDriversPins(flag){
		for(var i=0;i<deliverer_markers.length; i++){
			if(deliverer_markers[i]!=null){
				deliverer_markers[i].marker.setVisible(flag);
			}	
		}
}
function showHideCustomersPins(flag){
	for(var i=0;i<customer_markers.length; i++){
			if(customer_markers[i]!=null){
				customer_markers[i].marker.setVisible(flag);
			}	
		}
}
function showHidePickupsPins(flag){
	for(var i=0;i<pickup_markers.length; i++){
			if(pickup_markers[i]!=null){
				pickup_markers[i].marker.setVisible(flag);
			}	
		}
}
function changeShowPinsSelect(){
	var showVal = $("#showMapPinsSelect").val();
	//console.log("show pins "+showVal)
	
	if(showVal == 'all'){
		showHideDriversPins(true);
		showHideCustomersPins(true);
		showHidePickupsPins(true);
	}
	else if(showVal=='driver'){
		showHideDriversPins(true);
		showHideCustomersPins(false);
		showHidePickupsPins(false);
	}
	else if(showVal=='pickup'){
		showHideDriversPins(false);
		showHideCustomersPins(false);
		showHidePickupsPins(true);
	}
	else if(showVal=='dropoff'){
		showHideDriversPins(false);
		showHideCustomersPins(true);
		showHidePickupsPins(false);
	}
}
function clickSearch(){
	var searchVal = $("#search_map").val();
	//console.log(searchVal)
	
   	customer_markers.forEach(function(marker,index){
       		marker.marker.setMap(null);
    })
    customer_markers=[];
	
	pickup_markers.forEach(function(marker,index){
       		marker.marker.setMap(null);
    })
    pickup_markers=[];
	
	deliverer_markers.forEach(function(marker,index){
       		marker.marker.setMap(null);
    })
    deliverer_markers=[];
	
	
	$.ajax({
        type:'GET',
        url: '{{url("doorder/search_map")}}'+'?search_val='+searchVal,
        success:function(data) {
              //console.log(data);

              let pickup_position = {lat: parseFloat(data.pickup_pin.pickup_lat), lng: parseFloat(data.pickup_pin.pickup_lon)};
                    let pickupMarker = new google.maps.Marker({
                        map: map, 
                        icon: pickup_marker,    
                        position: pickup_position,
                    });
                    
                    let contentString = 
                    	'<h2 class="mapPickupOrderNumber px-2"> Order #'+ data.pickup_pin.order_id+' </h2>'+ 
                    	'<h3 class="pickup-name mapPickupName px-2">' + data.pickup_pin.retailer_name + '</h3>' +
                        '<p class="mapPickupAddress px-2">'+data.pickup_pin.pickup_address+'</p>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString,
                        maxWidth: 350
                    });
                    pickupMarker.addListener('click', function () {
                        infowindow.open(map, pickupMarker);
                    });
                    
                let customer_position = {lat: parseFloat(data.dropoff_pin.customer_address_lat), lng: parseFloat(data.dropoff_pin.customer_address_lon)};
                    let customerMarker = new google.maps.Marker({
                        map: map, 
                        icon: customer_marker,    
                        position: customer_position,
                    });
                    let contentStringC = 
                    	'<h2 class="mapCustomerOrderNumber px-2"> Order #'+ data.dropoff_pin.order_id+' </h2>'+ 
                    	'<h3 class="mapCustomerName px-2">' + data.dropoff_pin.customer_name + '</h3>' +
                        '<p class="mapCustomerAddress px-2">'+data.dropoff_pin.customer_address+'</p>';
                    let infowindowC = new google.maps.InfoWindow({
                        content: contentStringC,
                        maxWidth: 350
                    });
                    customerMarker.addListener('click', function () {
                        infowindowC.open(map, customerMarker);
                    });
                    
                     let dlvrr_mrkr = new google.maps.Marker({
                        map: map,
                        icon: deliverer_marker,
                        
                        position: {lat: parseFloat(data.driver_pin.lat), lng: parseFloat(data.driver_pin.lon)}
                    });
               			
        			let contentStringD = 
                            	'<h2 class="mapDriverName px-2">'+ data.driver_pin.driver.name +' </h2>';
                            	
                    let infowindowD = new google.maps.InfoWindow({
                        content: contentStringD,
                        maxWidth: 350
                    });
                    dlvrr_mrkr.addListener('click', function () {
                        infowindowD.open(map, dlvrr_mrkr);
                    });   
                   
              
        }
    });          
                      
}

	$( document ).ready(function() {
	
			if($(window).width()>768){
        		$('#minimizeSidebar').trigger('click');
        	}
	
            $( ".inputDate" ).datepicker({
            	maxDate: new Date()
            });
            
            $('#deliverersChargesPerWeekTable').DataTable({
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "deliverer_name","className":"nameTd"   },
                    { "data": "order_count","className":"countTd"  },
                    { "data": "order_charge" ,"className":"chargeTd"  }
        		],
        		"language": {
                    "paginate": {
                      "previous": "<i class='fas fa-angle-left'></i>",
                      "next": "<i class='fas fa-angle-right'></i>",
                    }
                  }
             });
             
             
             $('#retailersChargesPerMonthTable').DataTable({
             	
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "retailer_name" ,"className":"nameTd"  },
                    { "data": "order_count","className":"countTd" },
                    { "data": "order_charge" ,"className":"chargeTd"  }
        		],
        		"language": {
                    "paginate": {
                      "previous": "<i class='fas fa-angle-left'></i>",
                      "next": "<i class='fas fa-angle-right'></i>",
                    }
                  }
             });
     });
     
     function clickFilter(){
     	var startDate = $("#startDate").val();
     	var endDate = $("#endDate").val();
     	if(startDate==='' || endDate===''){
         	$("#errorMesssage").html("Both dates are required");
         	$("#errorMesssage").css("display","block");
     	}
     	else{
     		var fromDate = Date.parse(startDate);
     		var toDate = Date.parse(endDate);
     		
     		if(fromDate > toDate){
             	$("#errorMesssage").html("To date cannot be before from date");
             	$("#errorMesssage").css("display","block");
     		}else{
             	$("#errorMesssage").html("");
             	$("#errorMesssage").css("display","none");
             	
             	             	
             	 $.ajax({
                   type:'GET',
                   url: '{{url("doorder/dashboard")}}'+'?from_date='+startDate+'&to_date='+endDate,
                   success:function(data) {
                      //console.log(data);
					  //console.log(data.all_orders_count);
                     
                      $("#ordersValueH3").html(data.all_orders_count);
                      $("#ordersStatsTime").html("");
                      
                      $("#deliveryValueH3").html(data.delivered_orders_count);
                      $("#deliveryStatsTime").html("");
                      
                      $("#newRetailersValueH3").html(data.retailers_count);
                      $("#newRetailersStatsTime").html("");
                      
                      $("#newDeliverersValueH3").html(data.deliverers_count);
                      $("#newDeliverersStatsTime").html("");
                      
                      
                      $("#thisWeekLabel").html(data.thisWeekPercentage+'%');
                      $("#lastWeekLabel").html(data.lastWeekPercentage+'%');
                      $("#thisMonthLabel").html(data.thisMonthPercentage+'%');
                      $("#lastMonthLabel").html(data.lastMonthPercentage+'%');
                      
                      if(data.thisWeekPercentage>=0){
                      		 $("#thisWeekLabel").removeClass('chartDataValueMinus');
                      		 $("#thisWeekLabel").addClass('chartDataValuePlus');
                      }else{
                      		 $("#thisWeekLabel").removeClass('chartDataValuePlus');
                      		 $("#thisWeekLabel").addClass('chartDataValueMinus');
                      }
                      if(data.thisMonthPercentage>=0){
                      		 $("#thisMonthLabel").removeClass('chartDataValueMinus');
                      		 $("#thisMonthLabel").addClass('chartDataValuePlus');
                      }else{
                      		 $("#thisMonthLabel").removeClass('chartDataValuePlus');
                      		 $("#thisMonthLabel").addClass('chartDataValueMinus');
                      }
                                           
                      
                      $('#deliverersChargesPerWeekTable').dataTable().fnClearTable();
					  if(data.deliverers_order_charges.length>0){
                      	$('#deliverersChargesPerWeekTable').dataTable().fnAddData(data.deliverers_order_charges);
                      }
					  
                      $('#retailersChargesPerMonthTable').dataTable().fnClearTable();
                      if(data.retailers_order_charges.length>0){
                      	$('#retailersChargesPerMonthTable').dataTable().fnAddData(data.retailers_order_charges);
                      }
                      
                      	pickup_markers.forEach(function(marker,index){
               				marker.marker.setMap(null);
            			})
            			pickup_markers=[];
                    	drawPickupMarkers(JSON.parse(''+data.pickup_arr));
                    
                        customer_markers.forEach(function(marker,index){
                   			marker.marker.setMap(null);
                		})
                		customer_markers=[];
                        drawCustomerMarkers(JSON.parse(''+data.dropoff_arr));
                      
                      var data = {
                          labels:JSON.parse('{!! json_encode($annual_chart_labels) !!}'),
                          series: [
                           	{"name": "Last year", "data": JSON.parse('{!! json_encode($annual_chart_data_last) !!}') },
                            {"name": "This year", "data": JSON.parse('{!! json_encode($annual_chart_data) !!}') }
                          ]
                        };
					  new Chartist.Line('.ct-chart', data, options, responsiveOptions);
                      
                   }
            	});
     		}
     	}
     }
      
      
      var data = {
  labels:JSON.parse('{!! json_encode($annual_chart_labels) !!}'),
  series: [
    {"name": "Last year", "data": JSON.parse('{!! json_encode($annual_chart_data_last) !!}') }, 
   	 {"name": "This year", "data": JSON.parse('{!! json_encode($annual_chart_data) !!}') },
  ]
};


var options = {
  height: 250,
  
  fullWidth: true,
    chartPadding: {
        right: 40
    },
    showPoint: false,
    plugins: [
       
        Chartist.plugins.legend({
          
            clickable: true
        }),
    ]
};

var responsiveOptions = [
  ['screen and (max-width: 640px)', {
    
    axisX: {
      labelInterpolationFnc: function (value) {
        return value[0];
      }
    }
  }]
];

new Chartist.Line('.ct-chart', data, options, responsiveOptions);
             
        
</script>
<script>
        let google_initialized = false;
        let map;
        let deliverers_array = JSON.parse('{!! $drivers_arr !!}');
        let deliverer_markers = [];
        let deliverer_marker;
        
        let customer_arr = JSON.parse('{!! $dropoff_arr !!}');
        let customer_markers = [];
        let customer_marker;
        let pickup_arr = JSON.parse('{!! $pickup_arr !!}');
        let pickup_markers = [];
        let pickup_marker;

        function initMap() {
            google_initialized = true;
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });
            deliverer_marker = {
                url: "{{asset('images/doorder-new-layout/map-pin-driver.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            customer_marker = {
            	url: "{{asset('images/doorder-new-layout/map-pin-customer.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            }
            pickup_marker = {
            	url: "{{asset('images/doorder-new-layout/map-pin-pickup.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            
            pickup_markers.forEach(function(marker,index){
       			marker.marker.setMap(null);
    		})
    		pickup_markers=[];
            drawPickupMarkers(pickup_arr);
            
            customer_markers.forEach(function(marker,index){
       			marker.marker.setMap(null);
    		})
    		customer_markers=[];
            drawCustomerMarkers(customer_arr);
            
                      
            
            if(deliverers_array.length > 0){
                deliverers_array.forEach(function(deliverer,index){
                    let del_lat = parseFloat(deliverer.lat);
                    let del_lon = parseFloat(deliverer.lon);
                   
                    drawDelivererMarker(deliverer.driver.id,deliverer.driver.name,del_lat,del_lon,deliverer.timestamp);
                });
            }
        }

        let map_socket = io.connect('{{env('SOCKET_URL')}}');

        map_socket.on('doorder-channel:update-driver-location'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
            let decodedData = JSON.parse(data);
            console.log('driver location update');
            let the_data = decodedData.data;
            let driver_id = the_data.driver_id;
            let driver_name = the_data.driver_name;
            let lat = the_data.lat;
            let lon = the_data.lon;
            let the_timestamp = the_data.timestamp;
            if(google_initialized){
                if(deliverer_markers[driver_id] === undefined){
                    drawDelivererMarker(driver_id,driver_name,lat,lon,the_timestamp);
                } else {
                    let the_marker = deliverer_markers[driver_id]['marker'];
                    the_marker.setPosition({lat: lat, lng: lon});
                    let the_info_window = deliverer_markers[driver_id]['info_window'];
//                     let contentString = '<h3 style="font-weight: 400">' +
//                         '<span class="deliverer-name mapDriverName">' + driver_name + '</span></h3>' +
//                         '<span style="font-weight: 400; font-size: 16px">' +
//                         'Last updated: ' + the_timestamp;
                    let contentString = 
                    	'<h2 class="mapDriverName px-2">'+ driver_name +' </h2>'+
                    	'<p class="mapDriverLastUpdate px-2"> Last updated: '+the_timestamp+'</p>';    
                    the_info_window.setContent(contentString);
                }
            }
        });

        function drawDelivererMarker(deliverer_id,deliverer_name,lat,lon,the_timestamp){
            let deliverer_latlng = {lat: lat, lng: lon};
            let dlvrr_mrkr = new google.maps.Marker({
                map: map,
                icon: deliverer_marker,
                //anchorPoint: new google.maps.Point(del_lat, del_lon),
                position: deliverer_latlng
            });
//             let contentString = '<h3 style="font-weight: 400">' +
//                 '<span class="deliverer-name mapDriverName">' + deliverer_name + '</span></h3>' +
//                 '<span style="font-weight: 400; font-size: 16px">' +
//                 'Last updated: ' + the_timestamp;
//             contentString += '</span>';
			
			let contentString = 
                    	'<h2 class="mapDriverName px-2">'+ deliverer_name +' </h2>'+
                    	'<p class="mapDriverLastUpdate px-2"> Last updated: '+the_timestamp+'</p>';
                    	
            let infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            dlvrr_mrkr.addListener('click', function () {
                infowindow.open(map, dlvrr_mrkr);
            });
            deliverer_markers[deliverer_id] = {
                marker: dlvrr_mrkr,
                info_window: infowindow
            };
        }
        
        function drawCustomerMarkers(customer_arr){
        	 if(customer_arr.length>0){
             	var j=0;
            	 customer_arr.forEach(function(order,index){
            	 	//console.log(order)
            	 	let customer_position = {lat: parseFloat(order.customer_address_lat), lng: parseFloat(order.customer_address_lon)};
                    let customerMarker = new google.maps.Marker({
                        map: map, 
                        icon: customer_marker,    
                        position: customer_position,
                    });
                    let contentString = 
                    	'<h2 class="mapCustomerOrderNumber px-2"> Order #'+ order.order_id+' </h2>'+ 
                    	'<h3 class="mapCustomerName px-2">' + order.customer_name + '</h3>' +
                        '<p class="mapCustomerAddress px-2">'+order.customer_address+'</p>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString,
                        maxWidth: 350
                    });
                    customerMarker.addListener('click', function () {
                        infowindow.open(map, customerMarker);
                    });
                    customer_markers[j++] = {
                        marker: customerMarker,
                        info_window: infowindow
                    };
            	 	 
            	 });
            }
        }
        function drawPickupMarkers(pickup_arr){
        	//console.log(pickup_arr)
        	if(pickup_arr.length>0){
            	var i=0;
            	 pickup_arr.forEach(function(order,index){
            	 	//console.log(order)
            	 	let pickup_position = {lat: parseFloat(order.pickup_lat), lng: parseFloat(order.pickup_lon)};
                    let pickupMarker = new google.maps.Marker({
                        map: map, 
                        icon: pickup_marker,    
                        position: pickup_position,
                    });
                    
                    let contentString = 
                    	'<h2 class="mapPickupOrderNumber px-2"> Order #'+ order.order_id+' </h2>'+ 
                    	'<h3 class="pickup-name mapPickupName px-2">' + order.retailer_name + '</h3>' +
                        '<p class="mapPickupAddress px-2">'+order.pickup_address+'</p>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString,
                        maxWidth: 350
                    });
                    pickupMarker.addListener('click', function () {
                        infowindow.open(map, pickupMarker);
                    });
                    pickup_markers[i++] = {
                        marker: pickupMarker,
                        info_window: infowindow
                    };
            	 	 
            	 });
            }
        }
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
