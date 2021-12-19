@extends('templates.doorder_dashboard')

@section('page-styles')
    <style>
      
        table td{
            text-align: left !important;
        }
    </style>
@endsection

@section('title', 'DoOrder | Retailers Requests')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    	<div class="card">
    						<div class="card-header card-header-icon card-header-rose row">
    							<div class="col-12">
    
    								<h4 class="card-title my-4">Retailers Requests</h4>
    							</div>
    							
    						</div>
						</div>
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-no-bordered table-hover doorderTable ordersListTable" id="retailersTable"
									cellspacing="0" width="100%" >
                                        <thead> 
                                            <tr>
                                            <th>Number</th>
                                            <th>Date/Time</th>
                                            <th>Business Type</th>
                                            <th>Retailer Name</th>
                                            <th>Status</th>
                                            <th>Stage</th>
                                            <th class="text-center">Locations No.</th>
                                           </tr> 
                                       </thead>

                                        <tbody>
                                            <tr v-for="request in retailers_requests.data" v-if="retailers_requests.data.length > 0" class="order-row" @click="openRequest(request.id)">
                                                <td>#@{{ request.id}}</td>
                                                <td  class="text-left orderDateTimeTd">@{{ parseDateTime(request.created_at) }}</td>
                                                <td>@{{ request.business_type}}</td>
                                                <td>@{{ request.name}}</td>
                                                <td>
                                                	
                                                	<span
															v-if="request.status == 'received'"
															class="orderStatusSpan receivedStatus">Request recieved</span>
                                                	<span
															v-if="request.status == 'missing'"
															class="orderStatusSpan missingStatus">Missing data</span>
                                                	<span
															v-if="request.status == 'completed'"
															class="orderStatusSpan completedStatus">Completed</span>
                                                </td>
                                                @php($i = 33.34)
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{1 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="request.status == 'received'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{2 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="request.status == 'missing'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{3 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="request.status == 'completed'"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center">@{{ request.nom_business_locations }}</td>
                                            </tr>

                                            <tr v-else>
                                                <td colspan="8" class="text-center">
                                                    <strong>No data found.</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    {{$retailers_requests->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
    
    
$(document).ready(function() {
 var table= $('#retailersTable').DataTable({
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
                retailers_requests: {!! json_encode($retailers_requests) !!}
            },
            mounted() {

            },
            methods: {
               
                parseDateTime(date) {
                    //console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date();
                    let date_moment = new moment();
                    if(date!=null && date!=''){
                        //parseDate = new Date(date);
                        date_moment = new moment(date);
                    }
                   
                    dateTime = date_moment.format('DD MMM YY HH:mm');
                    return dateTime;
                },
                openRequest(request_id) {
                    window.location = "{{url('doorder/retailers/requests/')}}/"+request_id
                }
            }
        });
    </script>
@endsection
