@extends('templates.dashboard') @section('title', 'Unified | Dashboard')

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
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" id="">
					<div class="card" id="dashboardCardDiv">
						<div class="card-header card-header-icon row">
							<div class="col-md-12">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/unified/dashboard.png')}}"
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
								<label
									class="col-lg-2 col-md-2 col-sm-2 col-form-label filterLabelDashboard">Filter:</label>
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
									<button class="btn btn-unified-primary btn-import" type="button"
										onclick="clickFilter()">Filter</button>
								</div>
							</div>


							<div class="row" style="display: flex; flex-wrap: wrap;">
								<div class="col-lg-3 col-md-4 col-sm-6 col-6">
									<div class="card card-stats">
										<a href="">
											<div class="card-dashboard-content">
												<p class="card-category">Jobs</p>
												<div class="row">
													<div class="col-md-6  col-sm-6 ">
														<h3 id="ordersValueH3"
															class="card-title cardDashboardValueH3">{{$all_jobs_count}}</h3>
														<div class="card-footer">
															<div class="stats" id="ordersStatsTime">Today</div>
														</div>
													</div>
													<div
														class="col-md-6 col-sm-6  dashboard-card-icon-container">
														<div class="dashboard-card-icon">
															<img class="dashboard-card-img"
																src="{{asset('images/unified/Jobs table-orange.png')}}"
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
										<a href="">
											<div class="card-dashboard-content">
												<p class="card-category">Completed</p>
												<div class="row">
													<div class="col-md-6  col-sm-6 ">
														<h3 id="deliveryValueH3"
															class="card-title cardDashboardValueH3">{{$completed_jobs_count}}</h3>
														<div class="card-footer">
															<div class="stats" id="deliveryStatsTime">Today</div>
														</div>
													</div>
													<div
														class="col-md-6  col-sm-6  dashboard-card-icon-container">
														<div class="dashboard-card-icon">
															<img class="dashboard-card-img"
																src="{{asset('images/unified/completed.png')}}"
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
										<a href="{{route('unified_getEngineersList', 'unified')}}">
											<div class="card-dashboard-content">
												<p class="card-category">New Engineers</p>
												<div class="row">
													<div class="col-md-6  col-sm-6 ">
														<h3 id="newEngineersValueH3"
															class="card-title cardDashboardValueH3">{{$engineers_count}}</h3>
														<div class="card-footer">
															<div class="stats" id="newEngineersStatsTime">This month</div>
														</div>
													</div>
													<div
														class="col-md-6  col-sm-6  dashboard-card-icon-container">
														<div class="dashboard-card-icon">
															<img class="dashboard-card-img"
																src="{{asset('images/unified/Engineers-orange.png')}}"
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
										<a href="{{route('unified_getCustomersList', 'doorder')}}">
											<div class="card-dashboard-content">
												<p class="card-category">New Customers</p>
												<div class="row">
													<div class="col-md-6  col-sm-6 ">
														<h3 id="newCustomersValueH3"
															class="card-title cardDashboardValueH3">{{$customers_count}}</h3>
														<div class="card-footer">
															<div class="stats" id="newCustomersStatsTime">This month</div>
														</div>
													</div>
													<div
														class="col-md-6  col-sm-6  dashboard-card-icon-container">
														<div class="dashboard-card-icon">
															<img class="dashboard-card-img"
																src="{{asset('images/unified/customers.svg')}}"
																alt="new engineers icon">
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
												<h3 class="card-title tableDashboardH3">Customers Charges
													(Per Week)</h3>
											</div>
											<div class="row">
												<div class="col-md-12">
													<table id="customersChargesPerWeekTable"
														class="table  row-border cell-border" width="100%">
														<thead>
															<tr>
																<th>Customer</th>
																<th>No Of Jobs</th>
																<th>Payment (€)</th>
															</tr>
														</thead>
														<tbody>
															@foreach($customers_jobs_charges as $obj)
															<tr>
																<td>{{$obj->customer_name}}</td>
																<td>{{$obj->job_count}}</td>
																<td>{{$obj->job_charge}}</td>
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
												<h3 class="card-title tableDashboardH3">Engineers Charges
													(Per Month)</h3>
											</div>
											<div class="row">
												<div class="col-md-12">
													<table id="engineersChargesPerMonthTable"
														class="table  row-border cell-border" width="100%">
														<thead>
															<tr>
																<th>Engineer</th>
																<th>No Of Jobs</th>
																<th>Charges (€)</th>
															</tr>
														</thead>
														<tbody>
															@foreach($engineers_jobs_charges as $objr)
															<tr>
																<td>{{$objr->engineer_name}}</td>
																<td>{{$objr->job_count}}</td>
																<td>{{$objr->job_charge}}</td>
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
												<h3 class="card-title tableDashboardH3">Statistics (Jobs
													Per Month)</h3>
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
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
	$( document ).ready(function() {
	
        	$('#minimizeSidebar').trigger('click')
	
            $( ".inputDate" ).datepicker({
            	maxDate: new Date()
            });
            
            $('#customersChargesPerWeekTable').DataTable({
             	"paging":   true,
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "customer_name" },
                    { "data": "job_count" },
                    { "data": "job_charge" }
        		]
             });
             
             
             $('#engineersChargesPerMonthTable').DataTable({
             	"paging":   true,
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "engineer_name" },
                    { "data": "job_count" },
                    { "data": "job_charge" }
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
                      
                      console.log(data.all_jobs_count);
                     
                      $("#ordersValueH3").html(data.all_jobs_count);
                      $("#ordersStatsTime").html("");
                      
                      $("#deliveryValueH3").html(data.completed_jobs_count);
                      $("#deliveryStatsTime").html("");
                      
                      $("#newEngineersValueH3").html(data.engineers_count);
                      $("#newEngineersStatsTime").html("");
                      
                      $("#newCustomersValueH3").html(data.customers_count);
                      $("#newCustomersStatsTime").html("");
                      
                     
                      
                      $('#customersChargesPerWeekTable').dataTable().fnClearTable();
					  if(data.customers_jobs_charges.length>0){
                      	$('#customersChargesPerWeekTable').dataTable().fnAddData(data.customers_jobs_charges);
                      }
					  
                      $('#engineersChargesPerMonthTable').dataTable().fnClearTable();
                      if(data.engineers_jobs_charges.length>0){
                      	$('#engineersChargesPerMonthTable').dataTable().fnAddData(data.engineers_jobs_charges);
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
        let engineers_array = JSON.parse('{!! $engineers_arr !!}');
        let engineer_markers = [];
        let engineer_marker;
        console.log(engineers_array);

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
            engineer_marker = {
                url: "{{asset('images/unified/marker-orange.png')}}",
                scaledSize: new google.maps.Size(50, 50), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
                        
            if(engineers_array.length > 0){
                engineers_array.forEach(function(engineer,index){
                    let del_lat = parseFloat(engineer.lat);
                    let del_lon = parseFloat(engineer.lon);
                    /*let engineer_latlng = {lat: del_lat, lng: del_lon};
                    let dlvrr_mrkr = new google.maps.Marker({
                        map: map,
                        icon: engineer_marker,
                        //anchorPoint: new google.maps.Point(del_lat, del_lon),
                        position: engineer_latlng
                    });
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="engineer-name">' + engineer.engineer.name + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + engineer.timestamp;
                    contentString += '</span>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    dlvrr_mrkr.addListener('click', function () {
                        infowindow.open(map, dlvrr_mrkr);
                    });
                    engineer_markers[engineer.engineer.id] = {
                        marker: dlvrr_mrkr,
                        info_window: infowindow
                    };*/
                    drawEngineerMarker(engineer.engineer.id,engineer.engineer.name,del_lat,del_lon,engineer.timestamp);
                });
            }
        }

        let map_socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');

        map_socket.on('doorder-channel:update-engineer-location'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
            let decodedData = JSON.parse(data);
            console.log('engineer location update');
            let the_data = decodedData.data;
            let engineer_id = the_data.engineer_id;
            let engineer_name = the_data.engineer_name;
            let lat = the_data.lat;
            let lon = the_data.lon;
            let the_timestamp = the_data.timestamp;
            if(google_initialized){
                if(engineer_markers[engineer_id] === undefined){
                    drawEngineerMarker(engineer_id,engineer_name,lat,lon,the_timestamp);
                } else {
                    let the_marker = engineer_markers[engineer_id]['marker'];
                    the_marker.setPosition({lat: lat, lng: lon});
                    let the_info_window = engineer_markers[engineer_id]['info_window'];
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="engineer-name">' + engineer_name + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + the_timestamp;
                    the_info_window.setContent(contentString);
                }
            }
        });

        function drawEngineerMarker(engineer_id,engineer_name,lat,lon,the_timestamp){
            let engineer_latlng = {lat: lat, lng: lon};
            let dlvrr_mrkr = new google.maps.Marker({
                map: map,
                icon: engineer_marker,
                //anchorPoint: new google.maps.Point(del_lat, del_lon),
                position: engineer_latlng
            });
            let contentString = '<h3 style="font-weight: 400">' +
                '<span class="engineer-name">' + engineer_name + '</span></h3>' +
                '<span style="font-weight: 400; font-size: 16px">' +
                'Last updated: ' + the_timestamp;
            contentString += '</span>';
            let infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            dlvrr_mrkr.addListener('click', function () {
                infowindow.open(map, dlvrr_mrkr);
            });
            engineer_markers[engineer_id] = {
                marker: dlvrr_mrkr,
                info_window: infowindow
            };
        }
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
