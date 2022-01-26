@extends('templates.garden_help-dashboard')

@section('title', 'GardenHelp | Contractors Requests')

@section('page-styles')
    <style>
     .status_icon{
        width: 22px;
     }
    </style>
@endsection

@section('page-content')

    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon row">
                                <div class="col-12 col-xl-5 col-lg-4 col-md-4 col-sm-12">

								<h4 class="card-title  my-md-4 mt-4 mb-1 ">Contractors Requests</h4>
                                </div>
                                <div class="col-12 col-xl-7 col-lg-8 col-md-8 col-sm-6 mt-4">
                                    <div class="row justify-content-end">
                                        <div class="status">
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Request received">
                                                Request Received
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="Missing Data">
                                                Missing Data
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Request completed">
                                                Request Completed
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="table-responsive">
                                        <table id="requestsTable" class="table table-no-bordered table-hover gardenHelpTable jobsListTable"
										cellspacing="0" width="100%" style="width: 100%">
                                            <thead><tr>
                                                <th>Date/Time</th>
                                                <th>Years Of Experience</th>
                                                <th>Contractor Name</th>
                                                <th>Request No</th>
                                                <th>Status</th>
                                                <th>Stage</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody> <tr class="order-row" v-if="contractors_requests.length"
                                                        	v-for="contractor in contractors_requests"
                                                        	@click="clickViewContractor(event,contractor.id)"
                                                        >
                                                            <td v-html="contractor.created_at">@{{contractor.created_at}}</td>
												<td>@{{contractor.experience_level}}</td>
												<td>@{{contractor.name}}</td>
												<td>@{{contractor.id}}</td>

                                                            <td class="jobStatusTd">
                                                            	<span 	
																	class="jobStatusSpan readyStatus">@{{contractor.status}}</span>
                                                                <img class="status_icon"
                                                                    	v-if="contractor.status == 'received'"
                                                                    	 src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Request received">
                                                                <img class="status_icon" 
                                                                    	v-if="contractor.status == 'missing'"
                                                                    	src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="Missing Data">
                                                                
                                                                    <img class="status_icon" v-else src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Request completed">
                                                                
                                                            </td>
                                                            <td>
                                                                <div class="progress m-auto">
                                                                	<div class="progress-bar" role="progressbar"
            															:style="'width:' + (stage * 1) + '%'"
            															v-if="contractor.status == 'received'" aria-valuenow="100"
																			aria-valuemin="0" aria-valuemax="100"></div>
                                                                	<div class="progress-bar" role="progressbar"
            															:style="'width:' + (stage * 2) + '%'"
            															v-if="contractor.status == 'missing'" aria-valuenow="100"
																			aria-valuemin="0" aria-valuemax="100"></div>
                                                                	<div class="progress-bar" role="progressbar"
            															:style="'width:' + (stage * 3) + '%'"
            															v-else aria-valuenow="100"
																			aria-valuemin="0" aria-valuemax="100"></div>
                                                                    
                                                                </div>
                                                            </td>
                                                            <td>
                                                                 @{{contractor.location}} 
                                                            </td>
                                                            <td class="actionsTd">
                                                                <button type="button"
                                                                   class="remove" @click="clickDeleteContractor(contractor.id)">
                                                                   <img
															src="{{asset('images/gardenhelp/delete-icon.png')}}">
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <tr v-else>
                                                        <td colspan="9" class="text-center">
                                                            <strong>No data found.</strong>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                        <nav aria-label="pagination" class="float-right">
                                            {{$contractors_requests->links('vendor.pagination.bootstrap-4')}}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- delete contractor modal -->
            <div class="modal fade" id="delete-request-modal" tabindex="-1"
                 role="dialog" aria-labelledby="delete-request-label"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close d-flex justify-content-center"
                                    data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-dialog-header modalHeaderMessage">Are you sure you want
                                to delete this request?</div>

                            <div>

							<form method="POST" id="delete-request"
								action="{{url('garden-help/contractors/requests/delete')}}"
								style="margin-bottom: 0 !important;">
								@csrf <input type="hidden" id="contractorId" name="contractorId"
									value="" />
							</form>

						</div>
                        </div>
                        <div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center"><button type="button" 
				class="btn  btn-submit btn-gardenhelp-green" onclick="$('form#delete-request').submit()">Yes</button>
                            </div>
				<div class="col-lg-4 col-md-6 text-center"><button type="button"
					class="btn btn-submit  btn-gardenhelp-danger"
                                    data-dismiss="modal">Cancel</button>
                        </div>
</div>

                    </div>
                </div>
            </div>
            <!-- end delete contractor modal -->
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
    
$(document).ready(function() {
 var table= $('#requestsTable').DataTable({
    	
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
           "columnDefs": [ {
    		"targets": -1,
    		"orderable": false
    	} ],            
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    	
    });
});
        var app = new Vue({
            el: '#app',
            data: {
            	contractors_requests: {},
                stage:33.34
            },
            mounted() {
            	var contractors_requests = {!! json_encode($contractors_requests) !!};

                for(let item of contractors_requests.data) {
                    item.created_at = '<span class="jobDateTimeTd">'+ moment(item.created_at).format('D MMM YYYY')+ '</span><br>'
                    						+moment(item.created_at).format('HH:mm')
                 }

                this.contractors_requests = contractors_requests.data;
            },
            methods: {
                clickViewContractor(e,contractorId){
                    e.preventDefault();
                    
                    if (e.target.cellIndex == undefined) {  }
                    else{
                       window.location.href = "{{url('garden-help/contractors/requests/')}}/"+contractorId;
                    }                
                },
                 clickDeleteContractor(contractorId){

                    $('#delete-request-modal').modal('show')
                    $('#delete-request-modal #contractorId').val(contractorId);
                    
                 }
                
            }
        });
    </script>
@endsection


