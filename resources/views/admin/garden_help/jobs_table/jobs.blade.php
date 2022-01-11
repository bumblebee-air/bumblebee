@extends('templates.dashboard') @section('title', 'GardenHelp | Jobs
Table') @section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12  col-md-4">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/gardenhelp_icons/Job-Table-white.png')}}">
								</div>
								<h4 class="card-title ">Jobs Table</h4>
							</div>
							<div class="col-12  col-md-8 mt-4">
								<div class="row justify-content-end">
									<div class="status">
										<div class="status_item">
											<img class="status_icon"
												src="{{asset('images/doorder_icons/order_status_pending.png')}}"
												alt="Not Assigned">0 Applications
										</div>
										<div class="status_item">
											<img class="status_icon"
												src="{{asset('images/doorder_icons/order_status_on_route.png')}}"
												alt="Assigned"> Contractors Applied
										</div>
										<div class="status_item">
											<img class="status_icon"
												src="{{asset('images/doorder_icons/order_status_matched.png')}}"
												alt="Accepted"> Assigned
										</div>
										<div class="status_item">
											<img class="status_icon"
												src="{{asset('images/gardenhelp_icons/order_status_on_route_pickup.png')}}"
												alt="on way"> On the way to Job Location
										</div>
										<div class="status_item">
											<img class="status_icon"
												src="{{asset('images/doorder_icons/order_status_picked_up.png')}}"
												alt="arrived"> Arrived to Job Location
										</div>
										<div class="status_item">
											<img class="status_icon"
												src="{{asset('images/doorder_icons/order_status_delivered.png')}}"
												alt="Completed"> Job Completed
										</div>
									</div>

								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table class="table" id="jobsTable">
										<thead>
											<tr>
												<th  width="10%">Created At</th>
												<th  width="10%">Scheduled At</th>
												<th  width="20%">Service Type</th>
												<th  width="10%">Job Number</th>
												<th  width="10%">Status</th>
												<th  width="10%">Stage</th>
												@if(auth()->user()->user_role == 'client')<th  width="10%">Customer Name</th>@endif
												<th  width="10%">Contractor Name</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="job in jobs" v-if="jobs.length" class="order-row"
												@click="openJob(job.id)">
												<td>@{{job.created_at}}</td>
												<td>@{{job.available_date_time}}</td>
												<td>@{{job.service_types}}</td>
												<td>@{{job.id}}</td>
												<td><img v-if="job.status == 'ready'" class="status_icon"
													src="{{asset('images/doorder_icons/order_status_pending.png')}}"
													alt="not assigned"> <img
													v-else-if="job.status == 'assigned'" class="status_icon"
													src="{{asset('images/doorder_icons/order_status_on_route.png')}}"
													alt="assigned"> <img v-else-if="job.status == 'matched'"
													class="status_icon"
													src="{{asset('images/doorder_icons/order_status_matched.png')}}"
													alt="accepted"> <img v-else-if="job.status == 'on_route'"
													class="status_icon"
													src="{{asset('images/gardenhelp_icons/order_status_on_route_pickup.png')}}"
													alt="on way"> <img v-else-if="job.status == 'arrived'"
													class="status_icon"
													src="{{asset('images/doorder_icons/order_status_picked_up.png')}}"
													alt="arrived"> <img v-else class="status_icon"
													src="{{asset('images/doorder_icons/order_status_delivered.png')}}"
													alt="completed"></td>
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
									<nav aria-label="pagination" class="float-right"></nav>
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
                    item.created_at = moment(item.created_at).format('YYYY-MM-DD')
                    item.available_date_time = moment(item.available_date_time, "MM/DD/YYYY HH:mm").format('YYYY-MM-DD HH:mm');
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



