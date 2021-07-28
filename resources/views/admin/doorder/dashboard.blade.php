@extends('templates.dashboard') @section('title', 'DoOrder | Dashboard')

@section('page-styles')
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
</style>

@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" id="">
				<div class="card" id="dashboardCardDiv">
					<div class="card-header card-header-icon card-header-rose row">
						<div class="col-md-12">
							<div class="card-icon">
								<img class="page_icon"
									src="{{asset('images/doorder_icons/dashboard.png')}}"
									alt="dashboard icon">
							</div>
							<h4 class="card-title ">Dashboard</h4>
						</div>
					</div>

					<div class="card-body">
						<div class="row" style="margin-left: 10px">
							<p id="errorMesssage" class="alert alert-danger"></p>
						</div>
						<div class="row" id="dashboardFilterRowDiv">
							<label class="col-lg-2 col-md-2 col-sm-2 col-form-label filterLabelDashboard">Filter:</label>
							<div class="col-lg-3 col-md-3 col-sm-3">
								<div class="form-group bmd-form-group">
									<input class="form-control inputDate" id="startDate"
										type="text" data-toggle="datetimepicker"
										data-target="#startDate" placeholder="From" required="true"
										aria-required="true">
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3">
								<div class="form-group bmd-form-group">
									<input class="form-control inputDate" id="endDate" type="text"
										placeholder="To" required="true" aria-required="true">
								</div>
							</div>
							<div class="col-lg-2 col-md-3  col-sm-2">
								<button class="btn btn-primary" type="button"
									onclick="clickFilter()">Filter</button>
							</div>
						</div>


						<div class="row" style="display: flex; flex-wrap: wrap;">
							<div class="col-lg-3 col-md-4 col-sm-6 col-6">
								<div class="card card-stats">
									<a href="{{route('doorder_ordersTable', 'doorder')}}">
										<div class="card-dashboard-content">
											<p class="card-category">Orders</p>
											<div class="row">
												<div class="col-md-6  col-sm-6 ">
													<h3 id="ordersValueH3"
														class="card-title cardDashboardValueH3">{{$all_orders_count}}</h3>
													<div class="card-footer">
														<div class="stats" id="ordersStatsTime">Today</div>
													</div>
												</div>
												<div
													class="col-md-6 col-sm-6  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder_icons/orders-dashbord.png')}}"
															alt="orders icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-6">
								<div class="card card-stats">
									<a href="{{route('doorder_getInvoiceList', 'doorder')}}">
										<div class="card-dashboard-content">
											<p class="card-category">Delivery</p>
											<div class="row">
												<div class="col-md-6  col-sm-6 ">
													<h3 id="deliveryValueH3"
														class="card-title cardDashboardValueH3">{{$delivered_orders_count}}</h3>
													<div class="card-footer">
														<div class="stats" id="deliveryStatsTime">Today</div>
													</div>
												</div>
												<div
													class="col-md-6  col-sm-6  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder_icons/delivery-dashboard.png')}}"
															alt="delivery icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-6">
								<div class="card card-stats">
									<a href="{{route('doorder_retailers_requests', 'doorder')}}">
										<div class="card-dashboard-content">
											<p class="card-category">New Retailers</p>
											<div class="row">
												<div class="col-md-6  col-sm-6 ">
													<h3 id="newRetailersValueH3"
														class="card-title cardDashboardValueH3">{{$retailers_count}}</h3>
													<div class="card-footer">
														<div class="stats" id="newRetailersStatsTime">This month</div>
													</div>
												</div>
												<div
													class="col-md-6  col-sm-6  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder_icons/new-retailers-dashboard.png')}}"
															alt="new retailers icon">
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-3 col-md-4 col-sm-6 col-6">
								<div class="card card-stats">
									<a href="{{route('doorder_drivers_requests', 'doorder')}}">
										<div class="card-dashboard-content">
											<p class="card-category">New Deliverers</p>
											<div class="row">
												<div class="col-md-6  col-sm-6 ">
													<h3 id="newDeliverersValueH3"
														class="card-title cardDashboardValueH3">{{$deliverers_count}}</h3>
													<div class="card-footer">
														<div class="stats" id="newDeliverersStatsTime">This month</div>
													</div>
												</div>
												<div
													class="col-md-6  col-sm-6  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/doorder_icons/new-deliverers-dashbord.png')}}"
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
							<div class="col-12" id="map-container">
								<div class="card ">
									<div id="map"
										style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="card ">
									<div class="cardContentTableDiv">
										<div class="">
											<h3 class="card-title tableDashboardH3">Deliverers Charges
												(Per Week)</h3>
										</div>
										<div class="row">
											<div class="col-md-12">
												<table id="deliverersChargesPerWeekTable"
													class="table  row-border cell-border" width="100%">
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
															<td>{{$obj->deliverer_name}}</td>
															<td>{{$obj->order_count}}</td>
															<td>{{$obj->order_charge}}</td>
														</tr>
														@endforeach

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card ">
									<div class="cardContentTableDiv">
										<div class="">
											<h3 class="card-title tableDashboardH3">Retailers Charges
												(Per Month)</h3>
										</div>
										<div class="row">
											<div class="col-md-12">
												<table id="retailersChargesPerMonthTable"
													class="table  row-border cell-border" width="100%">
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


						<div class="row">
							<div class="col-md-12">
								<div class="card ">
									<div class="cardContentTableDiv">
										<div class="">
											<h3 class="card-title tableDashboardH3">Statistics (Order Per
												Month)</h3>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="ct-chart"></div>
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
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
	$( document ).ready(function() {
	
        	$('#minimizeSidebar').trigger('click')
	
            $( ".inputDate" ).datepicker({
            	maxDate: new Date()
            });
            
            $('#deliverersChargesPerWeekTable').DataTable({
             	"paging":   true,
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "deliverer_name" },
                    { "data": "order_count" },
                    { "data": "order_charge" }
        		]
             });
             
             
             $('#retailersChargesPerMonthTable').DataTable({
             	"paging":   true,
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "retailer_name" },
                    { "data": "order_count" },
                    { "data": "order_charge" }
        		]
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
     		
     		if(fromDate > endDate){
             	$("#errorMesssage").html("To date cannot be before from date");
             	$("#errorMesssage").css("display","block");
     		}else{
             	$("#errorMesssage").html("");
             	$("#errorMesssage").css("display","none");
             	
             	 $.ajax({
                   type:'GET',
                   url: '{{url("doorder/dashboard")}}'+'?from_date='+startDate+'&to_date='+endDate,
                   success:function(data) {
                      console.log(data);
                      
                      console.log(data.all_orders_count);
                     
                      $("#ordersValueH3").html(data.all_orders_count);
                      $("#ordersStatsTime").html("");
                      
                      $("#deliveryValueH3").html(data.delivered_orders_count);
                      $("#deliveryStatsTime").html("");
                      
                      $("#newRetailersValueH3").html(data.retailers_count);
                      $("#newRetailersStatsTime").html("");
                      
                      $("#newDeliverersValueH3").html(data.deliverers_count);
                      $("#newDeliverersStatsTime").html("");
                      
                     
                      
                      $('#deliverersChargesPerWeekTable').dataTable().fnClearTable();
					  if(data.deliverers_order_charges.length>0){
                      	$('#deliverersChargesPerWeekTable').dataTable().fnAddData(data.deliverers_order_charges);
                      }
					  
                      $('#retailersChargesPerMonthTable').dataTable().fnClearTable();
                      if(data.retailers_order_charges.length>0){
                      	$('#retailersChargesPerMonthTable').dataTable().fnAddData(data.retailers_order_charges);
                      }
                      
                      var data = {
                          labels:data.annual_chart_labels,
                          series: [
                           data.annual_chart_data
                          ]
                        };
					  new Chartist.Bar('.ct-chart', data, options, responsiveOptions);
                      
                   }
            	});
     		}
     	}
     }
      
      
      var data = {
  labels:JSON.parse('{!! json_encode($annual_chart_labels) !!}'),
  series: [
   JSON.parse('{!! json_encode($annual_chart_data) !!}')
  ]
};

var options = {
  height: 400
};

var responsiveOptions = [
  ['screen and (max-width: 640px)', {
    seriesBarDistance: 5,
    axisX: {
      labelInterpolationFnc: function (value) {
        return value[0];
      }
    }
  }]
];

new Chartist.Bar('.ct-chart', data, options, responsiveOptions);
             
        
</script>
<script>
        let google_initialized = false;
        let map;
        let deliverers_array = JSON.parse('{!! $drivers_arr !!}');
        let deliverer_markers = [];
        let deliverer_marker;

        function initMap() {
            google_initialized = true;
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });
            /*customer_marker = new google.maps.Marker({
                map: map,
                label: 'D',
                anchorPoint: new google.maps.Point(0, -29)
            });
            customer_marker.setVisible(false);
            let customer_address_lat = $("#customer_lat").val();
            let customer_address_lon = $("#customer_lon").val();
            if(customer_address_lat!=null && customer_address_lat!='' &&
                customer_address_lon!=null && customer_address_lon!=''){
                customer_marker.setPosition({lat: parseFloat(customer_address_lat),lng: parseFloat(customer_address_lon)});
                customer_marker.setVisible(true);
            }*/
            deliverer_marker = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            if(deliverers_array.length > 0){
                deliverers_array.forEach(function(deliverer,index){
                    let del_lat = parseFloat(deliverer.lat);
                    let del_lon = parseFloat(deliverer.lon);
                    /*let deliverer_latlng = {lat: del_lat, lng: del_lon};
                    let dlvrr_mrkr = new google.maps.Marker({
                        map: map,
                        icon: deliverer_marker,
                        //anchorPoint: new google.maps.Point(del_lat, del_lon),
                        position: deliverer_latlng
                    });
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="deliverer-name">' + deliverer.driver.name + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + deliverer.timestamp;
                    contentString += '</span>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    dlvrr_mrkr.addListener('click', function () {
                        infowindow.open(map, dlvrr_mrkr);
                    });
                    deliverer_markers[deliverer.driver.id] = {
                        marker: dlvrr_mrkr,
                        info_window: infowindow
                    };*/
                    drawDelivererMarker(deliverer.driver.id,deliverer.driver.name,del_lat,del_lon,deliverer.timestamp);
                });
            }
        }

        let map_socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');

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
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="deliverer-name">' + driver_name + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + the_timestamp;
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
            let contentString = '<h3 style="font-weight: 400">' +
                '<span class="deliverer-name">' + deliverer_name + '</span></h3>' +
                '<span style="font-weight: 400; font-size: 16px">' +
                'Last updated: ' + the_timestamp;
            contentString += '</span>';
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
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
