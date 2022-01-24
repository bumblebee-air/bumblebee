@extends('templates.garden_help-dashboard') @section('title', 'Garden
Help | Dashboard') @section('page-styles')
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
	background: url('{{asset(' images/ gardenhelp/ angle-arrow-left.png ')}}')
		no-repeat center !important;
	background-size: cover;
}

.ui-icon-circle-triangle-e {
	background: url('{{asset(' images/ gardenhelp/ angle-arrow-right.png ')}}')
		no-repeat center !important;
	background-size: cover;
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
							<div class="row  text-center justify-content-center my-0"
								style="margin-left: 10px">
								<p id="errorMesssage" class="alert alert-danger m-0"></p>
							</div>
							<div class="row justify-content-end mb-1 mt-3 mt-xs-0"
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
									<button class=" btn-gardenhelp-filter w-100" type="button"
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
									<a href="{{route('garden_help_getJobsTable', 'garden-help')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-7 ">
													<h3 id="commercialJobsValueH3"
														class="card-title cardDashboardValueH3">{{$commercial_jobs_count}}</h3>
													<p class="card-category">Commercial Jobs</p>
													<div class="card-footer">
														<div class="stats" id="commercialJobsStatsTime">Today</div>
													</div>
												</div>
												<div class="col-5 dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img id="commerical-jobs-dashboard-img"
															class="dashboard-card-img"
															src="{{asset('images/gardenhelp/commercial_jobs_dashboard.png')}}"
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
									<a href="{{route('garden_help_getJobsTable', 'garden-help')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-7 ">
													<h3 id="residentialJobsValueH3"
														class="card-title cardDashboardValueH3">{{$residential_jobs_count}}</h3>
													<p class="card-category">Residential Jobs</p>
													<div class="card-footer">
														<div class="stats" id="residentialJobsStatsTime">Today</div>
													</div>
												</div>
												<div class="col-5  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/gardenhelp/residential_jobs_dashboard.png')}}"
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
									<a
										href="{{route('garden_help_getContractorsList', 'garden-help')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-7 ">
													<h3 id="contractorsValueH3"
														class="card-title cardDashboardValueH3">{{$contractors_count}}</h3>
													<p class="card-category">Contractors</p>
													<div class="card-footer">
														<div class="stats" id="contractorsStatsTime">This month</div>
													</div>
												</div>
												<div class="col-5  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img id="contractors-dashboard-img"
															class="dashboard-card-img"
															src="{{asset('images/gardenhelp/contractors_dashboard.png')}}"
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
									<a
										href="{{route('garden_help_getCustomerssRequests', 'garden-help')}}">
										<div class="card-dashboard-content">
											<div class="row">
												<div class="col-7 ">
													<h3 id="newCustomersValueH3"
														class="card-title cardDashboardValueH3">{{$new_customers_count}}</h3>
													<p class="card-category">New Customers</p>
													<div class="card-footer">
														<div class="stats" id="newCustomersStatsTime">This month</div>
													</div>
												</div>
												<div class="col-5  dashboard-card-icon-container">
													<div class="dashboard-card-icon">
														<img class="dashboard-card-img"
															src="{{asset('images/gardenhelp/new_customers_dashboard.png')}}"
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
												Statistics <span>Jobs Per Month</span>
											</h3>
										</div>
										<div class="card-body">

											<div class="row">
												<div class="col-md-12">
													<div class="chart-container">
														<div id="statisticsChart"></div>
													</div>
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
											<h3 class="card-title tableDashboardH3">Contracters Charge</h3>
										</div>
										<div class="card-body pt-1">
											<div class="row">
												<div class="col-md-12">
													<table id="contractorsChargesPerWeekTable"
														class="table  table-no-bordered table-hover gardenHelpTable gardenHelpDashboardTable "
														width="100%">
														<thead>
															<tr>
																<th>Name</th>
																<th>Total Jobs</th>
																<th>Payment (€)</th>
															</tr>
														</thead>
														<tbody>
															@foreach($contractors_charges as $obj)
															<tr>
																<td class="nameTd">{{$obj->name}}</td>
																<td class="countTd">{{$obj->job_count}}</td>
																<td class="chargeTd">{{$obj->charge}}</td>
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
											<h3 class="card-title tableDashboardH3">Customers Charges</h3>
										</div>
										<div class="card-body pt-1">
											<div class="row">
												<div class="col-md-12">
													<table id="customersChargesPerMonthTable"
														class="table  table-no-bordered table-hover gardenHelpTable gardenHelpDashboardTable "
														width="100%">
														<thead>
															<tr>
																<th>Name</th>
																<th>Total Jobs</th>
																<th>Payment (€)</th>
															</tr>
														</thead>
														<tbody>
															@foreach($customers_charges as $objr)
															<tr>
																<td>{{$objr->name}}</td>
																<td>{{$objr->job_count}}</td>
																<td>{{$objr->charge}}</td>
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
</div>
@endsection @section('page-scripts')

<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">

$( document ).ready(function() {
	
	
            Highcharts.chart('statisticsChart', {
            	 chart: {
                    type: 'spline',
                    style:{fontFamily: 'Poppins'},
                    height: '300px'
                },
                title: {
                    text: null
                },
            
                subtitle: {
                    text:null
                },
            
                yAxis: {
                    title: {
                        text: 'Number of Jobs'
                    }
                },
            
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'top'
                },
            
                 plotOptions: {
                    spline: {
                        dataLabels: {
                            enabled: false
                        },
                        
                        enableMouseTracking: true
                    },
                   
                    series:{
                    	label:{
                    	//	enabled: true,
                    		 connectorAllowed: false
                    	},
            //         	   marker: {
            //                 enabled: true
            //             }
                    }
                },
            
            	xAxis: {
                    categories:JSON.parse('{!! json_encode($annual_chart_labels) !!}')
                },
                 credits: {
                enabled: false
              },
                series: [{
                		color: '#F8C140',
                    	 name: 'Last year',
                        data: JSON.parse('{!! json_encode($annual_chart_data_last) !!}')
                    }, {
                		color: '#30BB30',
                        name: 'This year',
                        data: JSON.parse('{!! json_encode($annual_chart_data) !!}')
                    } ],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                            }
                        }
                    }]
                }
            
            });


			if($(window).width()>768){
        		$('#minimizeSidebar').trigger('click');
        	}
	
            $( ".inputDate" ).datepicker({
            	maxDate: new Date()
            });
            
            var table = $('#contractorsChargesPerWeekTable').DataTable({
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		
        		"columns": [
                    { "data": "name","className":"nameTd"   },
                    { "data": "job_count","className":"countTd"  },
                    { "data": "charge" ,"className":"chargeTd"  }
        		],
        		"language": {
                    "paginate": {
                      "previous": "<i class='fas fa-angle-left'></i>",
                      "next": "<i class='fas fa-angle-right'></i>",
                    }
                  }
             });
                         
             $('#customersChargesPerMonthTable').DataTable({
             	
        		"ordering": false,
        		"info":     false,
        		"responsive":true,
        		"scrollY":        "450px",
        		"scrollCollapse": true,
        		"searching": false,
        		"columns": [
                    { "data": "name" ,"className":"nameTd"  },
                    { "data": "job_count","className":"countTd" },
                    { "data": "charge" ,"className":"chargeTd"  }
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
     	console.log(typeof startDate, typeof endDate)
     	if(startDate==='' || endDate===''){
         	$("#errorMesssage").html("Both dates are required");
         	$("#errorMesssage").css("display","block");
     	}
     	else{
     		var fromDate = Date.parse(startDate);
     		var toDate = Date.parse(endDate);
     		
     		console.log(typeof fromDate)
     		console.log(typeof endDate)
     		
     		if(fromDate > toDate){
             	$("#errorMesssage").html("To date cannot be before from date");
             	$("#errorMesssage").css("display","block");
     		}else{
             	$("#errorMesssage").html("");
             	$("#errorMesssage").css("display","none");
             	
             	             	
             	 $.ajax({
                   type:'GET',
                   url: '{{url("garden-help/garden_help_dashboard")}}'+'?from_date='+startDate+'&to_date='+endDate,
                   success:function(data) {
                      console.log(data);
                      
                      console.log(data.commercial_jobs_count);
                     
                      $("#commercialJobsValueH3").html(data.commercial_jobs_count);
                      $("#commercialJobsStatsTime").html("");
                      
                      $("#residentialJobsValueH3").html(data.residential_jobs_count);
                      $("#residentialJobsStatsTime").html("");
                      
                      $("#contractorsValueH3").html(data.contractors_count);
                      $("#contractorsStatsTime").html("");
                      
                      $("#newCustomersValueH3").html(data.new_customers_count);
                      $("#newCustomersStatsTime").html("");
                      
                      
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
                                           
                      
                      $('#contractorsChargesPerWeekTable').dataTable().fnClearTable();
					  if(data.contractors_charges.length>0){
                      	$('#contractorsChargesPerWeekTable').dataTable().fnAddData(data.contractors_charges);
                      }
					  
                      $('#customersChargesPerMonthTable').dataTable().fnClearTable();
                      if(data.customers_charges.length>0){
                      	$('#customersChargesPerMonthTable').dataTable().fnAddData(data.customers_charges);
                      }
                    
                      
                   }
            	});
     		}
     	}
     }
      
      
              
        
</script>
@endsection
