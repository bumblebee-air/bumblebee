@extends('templates.dashboard') @section('title', 'DoOrder | Dashboard')

@section('page-styles')

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

#chart1 .ct-legend {
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
	font-family: Quicksand;
	font-style: normal;
	font-weight: bold;
	font-size: 13px;
	line-height: 21px;
	color: #000000;
}
#chart2 .ct-legend li {
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

#chart1 .ct-legend li:nth-child(1)::before {
	background-color: #e9c218;
}

#chart1 .ct-legend li:nth-child(2)::before {
	background-color: #E5EAEE;
}

#chart2 .ct-legend li:nth-child(1)::before {
	background-color: #fff;
}

#chart2 .ct-legend li:nth-child(2)::before {
	background-color: rgba(255, 255, 255, 0.5);
}

.ct-chart .ct-legend .ct-legend-inside {
	position: absolute;
	top: 0;
	right: 0;
}

#chart1 g:not(.ct-grids):not(.ct-labels) g:nth-child(1) .ct-point,
	#chart1 g:not(.ct-grids):not(.ct-labels) g:nth-child(1) .ct-line {
	stroke: #e9c218;
}

#chart1 g:not(.ct-grids):not(.ct-labels) g:nth-child(2) .ct-point,
	#chart1 g:not(.ct-grids):not(.ct-labels) g:nth-child(2) .ct-line {
	stroke: #E5EAEE;
}

#chart2 g:not(.ct-grids):not(.ct-labels) g:nth-child(1) .ct-point,
	#chart2 g:not(.ct-grids):not(.ct-labels) g:nth-child(1) .ct-line {
	stroke: rgba(255, 255, 255, 0.5) !important;
}

#chart2 g:not(.ct-grids):not(.ct-labels) g:nth-child(2) .ct-point,
	#chart2 g:not(.ct-grids):not(.ct-labels) g:nth-child(2) .ct-line {
	stroke: #fff !important;
}

#chart2 .ct-series-b .ct-area, #chart2 .ct-series-b .ct-bar, #chart2 .ct-series-b .ct-line,
	#chart2 .ct-series-b .ct-point, #chart2 .ct-series-b .ct-slice-donut,
	#chart2 .ct-series-b .ct-slice-donut-solid, #chart2 .ct-series-b .ct-slice-pie
	{
	stroke: rgba(255, 255, 255, 0.5) !important;
}

#chart2 .ct-series-a .ct-area, #chart2 .ct-series-a .ct-bar, #chart2 .ct-series-a .ct-line,
	#chart2 .ct-series-a .ct-point, #chart2 .ct-series-a .ct-slice-donut,
	#chart2 .ct-series-a .ct-slice-donut-solid, .ct-chart .ct-series-a .ct-slice-pie
	{
	stroke: #fff !important;
}

.chartDataLabel {
	font-family: Quicksand;
	font-style: normal;
	font-weight: 500;
	font-size: 14px;
	line-height: 15px;
	/* identical to box height */
	color: #4D4D4D;
	margin-bottom: 4px;
}

.chartDataLabel.activeLabel {
	font-weight: bold;
	color: #E9C218;
}

.chartDataValue {
	font-family: Quicksand;
	font-style: normal;
	font-weight: bold;
	font-size: 17px;
	line-height: 21px;
	color: #212529;
}
.ct-label{
font-weight: 600;
font-size: 12px;
color: #B5B5C3 !important;
}
#chart2 .ct-label{
color: #645b5b !important;
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
							<h4 class="card-title ">Metrics Dashboard</h4>
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
							<div class="col-md-8">
								<div class="card ">
									<div class="cardContentTableDiv">
										<div class="">
											<h3 class="card-title tableDashboardH3">Orders Growth</h3>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div id="chart1" class="ct-chart"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card mb-0"
									style="background: radial-gradient(50% 38.76% at 50% 31.25%, #F7DC69 0%, #E9C218 100%);">
									<div class="cardContentTableDiv">
										<div class="row">
											<div class="col-md-12">
												<div id="chart2" class="ct-chart"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="card mt-0">
									<div class="cardContentTableDiv">

										<div class="row p-3">
											<div class="col-md-12 px-3 mx-2">
												<div class="row">
													<div class="col-6">
														<p class="chartDataLabel" onclick="clickChartDataLabel(this,'profitPercentage')">Profit</p>
														<h5 class="chartDataValue" id="profitPercentage">{{$profitPercentage}}</h5>
													</div>
													<div class="col-6">
														<p class="chartDataLabel" onclick="clickChartDataLabel(this,'lossPercentage')">Loss</p>
														<h5 class="chartDataValue" id="lossPercentage">{{$lossPercentage}}</h5>
													</div>
												</div>
												<div class="row">
													<div class="col-6">
														<p class="chartDataLabel activeLabel" onclick="clickChartDataLabel(this,'profitValue')">Profit</p>
														<h5 class="chartDataValue" id="profitValue">{{$profit}}</h5>
													</div>
													<div class="col-6">
														<p class="chartDataLabel" onclick="clickChartDataLabel(this,'lossValue')">Loss</p>
														<h5 class="chartDataValue" id="lossValue">{{$loss}}</h5>
													</div>
												</div>
												<div class="row">
													<div class="col-6">
														<p class="chartDataLabel" onclick="clickChartDataLabel(this,'deliverersCharge')">Deliverers Charge</p>
														<h5 class="chartDataValue" id="deliverersCharge">{{$deliverersCharge}}</h5>
													</div>
													<div class="col-6">
														<p class="chartDataLabel" onclick="clickChartDataLabel(this,'retailerCharge')">Retailer Charge</p>
														<h5 class="chartDataValue" id="retailerCharge">{{$retailerCharge}}</h5>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="card ">
									<div class="cardContentTableDiv">
										<div class="">
											<h3 class="card-title tableDashboardH3">Deliverers Charges</h3>
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
											<h3 class="card-title tableDashboardH3">Retailers Revenue</h3>
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


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts')
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/chartist-plugin-legend/0.6.1/chartist-plugin-legend.min.js"></script>
<script type="text/javascript"
	src="{{asset('js/chartist-plugin-tooltip.js')}}"> 

</script>
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
                   url: '{{url("doorder/metrics_dashboard")}}'+'?from_date='+startDate+'&to_date='+endDate,
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
                      
                      var data1 = {
                          labels:data.annual_chart_labels,
                          series: [
                           {"name": "No. Of Orders", "data": data.annual_chart_data_orders},
                           {"name": "Revenue", "data": data.annual_chart_data_revenue},
                          ]
                        };
					  new Chartist.Bar('#chart1', data1, options, responsiveOptions);
					  
					   var data2 = {
                          labels:data.profit_loss_chart_labels,
                          series: [
                           {"name": "Profit", "data": data.profit_loss_chart_data_profit},
                           {"name": "Loss", "data": data.profit_loss_chart_data_loss},
                          ]
                        };
					  new Chartist.Bar('#chart2', data2, options2, responsiveOptions);
         
                    	$("#profitPercentage").text(data.profitPercentage);
                    	$("#lossPercentage").text(data.lossPercentage);
                    	$("#profitValue").text(data.profit);
                    	$("#lossValue").text(data.loss);
                    	$("#deliverersCharge").text(data.deliverersCharge);
                    	$("#retailerCharge").text(data.retailerCharge);  
                   }
            	});
     		}
     	}
     }
     
														
     function clickChartDataLabel(e,id){
     	console.log(e )
     	console.log(id)
     	$('.chartDataLabel').removeClass('activeLabel');
     	$(e).addClass('activeLabel')
     	
     	var startDate = $("#startDate").val();
     	var endDate = $("#endDate").val();
     	var fromDate = Date.parse(startDate);
     	var toDate = Date.parse(endDate);
     	
     	
     	 $.ajax({
                   type:'GET',
                   url: '{{url("doorder/get_metrics_chart_label_data")}}'+'?from_date='+startDate+'&to_date='+endDate+'&label_name='+id,
                   success:function(data) {
                      console.log(data);
                      
                       var data2 = {
                          labels:data.profit_loss_chart_labels,
                          series: [
                           data.profit_loss_chart_data,
                          ]
                        };
                        
                        var options22 = {
                          height: 215,seriesBarDistance: 10,
                          
                        };
                        
					  new Chartist.Bar('#chart2', data2, options22, responsiveOptions);                
					  $('#chart2 ul.ct-legend').remove();
					  
                      
                   }
         });        
     } 
      
      var data = {
          labels:JSON.parse('{!! json_encode($annual_chart_labels) !!}'),
          series: [
           {"name": "No. Of Orders", "data": JSON.parse('{!! json_encode($annual_chart_data_orders) !!}')},
           {"name": "Revenue", "data": JSON.parse('{!! json_encode($annual_chart_data_revenue) !!}')}
          ]
        };
        
        var data2 = {
          labels:JSON.parse('{!! json_encode($profit_loss_chart_labels) !!}'),
          series: [
           {"name": "Profit", "data": JSON.parse('{!! json_encode($profit_loss_chart_data_profit) !!}')},
           {"name": "Loss", "data": JSON.parse('{!! json_encode($profit_loss_chart_data_loss) !!}')}
          ]
        };       
        

var options = {
  height: 400,seriesBarDistance: 10,
  
  plugins: [
        Chartist.plugins.legend({clickable: true}),
    	Chartist.plugins.tooltip()
    ],
};
var options2 = {
  height: 215,seriesBarDistance: 10,
  
  plugins: [
        Chartist.plugins.legend({clickable: true}),
    	Chartist.plugins.tooltip()
    ],
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


new Chartist.Bar('#chart1', data, options, responsiveOptions);
new Chartist.Bar('#chart2', data2, options2, responsiveOptions);
// .on("draw", function(data) {
// 	if (data.type === "bar") {
// 		data.element._node.setAttribute("title", "Value: " + data.value.y);
// 		data.element._node.setAttribute("data-chart-tooltip", "chart1");
// 	}
// }).on("created", function() {
// 	// Initiate Tooltip
// 	$("#chart1").tooltip({
// 		selector: '[data-chart-tooltip="chart1"]',
// 		container: "#chart1",
// 		html: true
// 	});
// });;
</script>
@endsection
