@extends('templates.garden_help-dashboard') @section('title', 'GardenHelp | Jobs
Table') @section('page-styles')
<style>
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">
								
								@if(auth()->user()->user_role == 'client')
								<h4 class="card-title  my-md-4 mt-4 mb-1">Jobs Table</h4>
								@else
								<h4 class="card-title my-md-4 mt-4 mb-1 ">My Bookings</h4>
								@endif
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
								<div class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv mt-1 mb-2 my-md-3">
										
										<div class=" col-md-6 col-sm-6 px-md-1">
											<div id="serviceTypeFilterDiv" class="form-group bmd-form-group"></div>
										</div>
								</div>
							</div>
						</div>
						</div><div class="card">
						<div class="card-body ">
							<div class="container">
								<div class="table-responsive">
									<table class="table table-no-bordered table-hover gardenHelpTable jobsListTable" id="jobsTable" width="100%">
										<thead>
											<tr>
												<th  width="10%">Created At</th>
												<th  width="10%">Scheduled At</th>
												<th  width="10%">Job No.</th>
												<th  width="20%">Service Type</th>
												<th  width="15%">Location</th>
												<th width="20%">Status</th>
												<th  width="15%">Stage</th>
												@if(auth()->user()->user_role == 'client')<th  width="10%">Customer Name</th>@endif
												<th  width="10%">Contractor Name</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="job in jobs" v-if="jobs.length" class="order-row"
												@click="openJob(job.id)">
												<td class="" v-html="job.created_at">@{{job.created_at}}</td>
												<td class="" v-html="job.available_date_time">@{{job.available_date_time}}</td>
												<td>@{{job.id}}</td>
												<td>@{{job.service_types}}</td>
												<td> <p style="" class="tablePinSpan tooltipC mb-0">
																<span> <i class="fas fa-map-marker-alt"
																	style="color: #30BB30"></i></span>
																<span class="tooltiptextC"> @{{job.location}} 
																</span>
															</p></td>
												<td class="jobStatusTd">
													<span 	v-if="job.status == 'ready'"
															class="jobStatusSpan readyStatus">0 Applications</span>
													<span 	v-else-if="job.status == 'assigned'"
															class="jobStatusSpan assignedStatus">Contractors Applied</span>
													<span 	v-else-if="job.status == 'matched'"
															class="jobStatusSpan matchedStatus">Assigned</span>
													<span 	v-else-if="job.status == 'on_route'"
															class="jobStatusSpan onRouteStatus">On the way to Job Location</span>
													<span 	v-else-if="job.status == 'arrived'"
															class="jobStatusSpan arrivedStatus">Arrived to Job Location</span>
													<span 	v-else-if="job.status == 'completed'"
															class="jobStatusSpan completedStatus">Job Completed</span>
												</td>
													
												<td>
													<div class="progress m-auto">
														<div class="progress-bar" role="progressbar"
															:style="'width:' + (stage * 0) + '%'"
															v-if="job.status == 'ready'" aria-valuenow="100"
															aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar" role="progressbar"
															:style="'width:' + (stage * 1) + '%'"
															v-else-if="job.status == 'assigned'" aria-valuenow="100"
															aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar" role="progressbar"
															:style="'width:' + (stage * 3) + '%'"
															v-else-if="job.status == 'matched'" aria-valuenow="100"
															aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar" role="progressbar"
															:style="'width:' + (stage * 4) + '%'"
															v-else-if="job.status == 'on_route'" aria-valuenow="100"
															aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar" role="progressbar"
															:style="'width:' + (stage * 5) + '%'"
															v-else-if="job.status == 'arrived'" aria-valuenow="100"
															aria-valuemin="0" aria-valuemax="100"></div>
														<div class="progress-bar" role="progressbar"
															:style="'width:' + (stage * 6) + '%'"
															v-else-if="job.status == 'completed'" aria-valuenow="100"
															aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</td>
												@if(auth()->user()->user_role == 'client')<td>@{{job.name}}</td>@endif
												<td>@{{job.contractor ? job.contractor.name : 'N/A'}}</td>
											</tr>
											<tr v-else>
												<td colspan="8" class="text-center"><strong>No data found.</strong>
												</td>
											</tr>
										</tbody>
									</table>
									
										<div class="d-flex justify-content-end mt-3">
											{{$jobs->links()}}</div>
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
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
	integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
	crossorigin="anonymous"></script>
<script>
   
$(document).ready(function() {
 var table= $('#jobsTable').DataTable({
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
            columnDefs: [
                { width: 60, targets: 2 },
                { width: 150, targets: 5 },
                { width: 100, targets: 7 },
                { width: 100, targets: 8 },
            ],        
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
         initComplete: function () {
        	var column = this.api().column(3);
                  var select = $('<select id="" data-style="select-with-transition" class="form-control selectpicker selectFilter"><option value="">Filter by service type</option></select>')
                    .appendTo( $('#serviceTypeFilterDiv').empty().text('') )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        console.log($(this).val())
                        column
                            .search( $(this).val() )
                            .draw();
                      
                  } );
                  column.data().unique().sort().each( function( d, j ) {      
                           var nameArr = d.split(",");
                            nameArr.forEach(function(number) {          
                                console.log(number)
                                if(number != ''){          
                                    var optionExists = ($("#language option[value='"+number+"']").length > 0);
                                    console.log(optionExists)
                                    if(!optionExists){
                                        select.append( '<option value="'+number+'">'+number+'</option>' );
                                    } 
                                }                       
                            });                     
                   
                	} );
                	

          }            
    	
    });
});

        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                jobs: {},
                stage: 16.66
            },
            mounted() {
                @if(Auth::user()->user_role != 'customer')
					socket.on('garden-help-channel:update-job-status'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
						let decodedData = JSON.parse(data);
						//Check if job exists
						let orderIndex = this.jobs.map(function(x) {return x.id; }).indexOf(decodedData.data.id)
						if (orderIndex != -1) {
							this.jobs[orderIndex].status = decodedData.data.status;
							updateAudio.play();
						}
					});
				@endif

                var jobs = {!! json_encode($jobs) !!};

                for(let item of jobs.data) {
                    item.created_at = '<span class="jobDateTimeTd">'+ moment(item.created_at).format('D MMM YYYY')+ '</span><br>'
                    						+moment(item.created_at).format('HH:mm')
                    item.available_date_time = '<span class="jobDateTimeTd">'+moment(item.available_date_time, "MM/DD/YYYY HH:mm").format('D MMM YYYY') + '</span><br>'
                    							+ moment(item.available_date_time, "MM/DD/YYYY HH:mm").format('HH:mm');
                }

                this.jobs = jobs.data;
            },
            methods: {
                openJob(request_id){
                    window.location.href = "{{url('garden-help/jobs_table/job')}}/"+request_id;
                }
            }
        });
    </script>
@endsection



