@extends('templates.doorder_dashboard')

@section('page-styles')
    <style>
        table td{
            text-align: left !important;
        }
        
    </style>
@endsection

@section('title', 'DoOrder | Drivers Requests')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    	<div class="card">
    						<div class="card-header card-header-icon card-header-rose row">
    							<div class="col-12">
    
    								<h4 class="card-title my-4">Drivers Requests</h4>
    							</div>
    							
    						</div>
						</div>
                        <div class="card">
                            
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-no-bordered table-hover doorderTable ordersListTable" id="driversTable"
									cellspacing="0" width="100%" >
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Date/Time</th>
                                                <th>Location</th>
                                                <th>Deliverer Name</th>
                                                <th>Status</th>
                                                <th>Stage</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="driver_request in drivers_requests.data" v-if="drivers_requests.data.length > 0" class="order-row" @click="openRequest(driver_request.id)">
                                                <td>
                                                    #@{{ driver_request.id}}
                                                </td>
                                                 <td class="text-left orderDateTimeTd">@{{ parseDateTime(driver_request.created_at) }}</td>
                                                <td>
                                                    @{{ JSON.parse(driver_request.work_location).name}}
                                                </td>
                                                <td>
                                                    @{{ driver_request.first_name}} @{{ driver_request.last_name  }}
                                                </td>
                                               
                                                <td>
                                                	<span
															v-if="driver_request.status == 'received'"
															class="orderStatusSpan receivedStatus">Request recieved</span>
                                                	<span
															v-if="driver_request.status == 'stripe_form_sent'"
															class="orderStatusSpan stripeFormSentStatus">Stripe form sent</span>
                                                	<span
															v-if="driver_request.status == 'missing'"
															class="orderStatusSpan missingStatus">Missing data</span>
                                                	<span
															v-if="driver_request.status == 'completed'"
															class="orderStatusSpan completedStatus">Completed</span>
                                                </td>
                                                @php($i = 33.34)
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{1 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="driver_request.status == 'received'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{2 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="driver_request.status == 'missing' || driver_request.status =='stripe_form_sent'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{3 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="driver_request.status == 'completed'"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @{{ driver_request.address}}
                                                </td>
                                            </tr>

                                            <tr v-else>
                                                <td colspan="8" class="text-center">
                                                    <strong>No data found.</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <nav aria-label="pagination" class="float-right">
                                        {{--                                        {{$clients->links('vendor.pagination.bootstrap-4')}}--}}
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{$drivers_requests->links()}}
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
 var table= $('#driversTable').DataTable({
    	
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
    	 columnDefs: [
                {
                    render: function (data, type, full, meta) {
                    	return '<span class="tableTextSpan" data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
                    },
                    targets: -1
                }
             ],
             
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
                drivers_requests: {!! json_encode($drivers_requests) !!}
            },
            mounted() {
                // socket.on('doorder-channel:new-order', (data) => {
                //     let decodedData = JSON.parse(data)
                //     this.orders.data.unshift(decodedData.data);
                // });
                //
                // socket.on('doorder-channel:update-order-status', (data) => {
                //     let decodedData = JSON.parse(data);
                //     console.log(decodedData);
                //     // this.orders.data.filter(x => x.id === decodedData.data.id).map(x => x.foo);
                //     let orderIndex = this.orders.data.map(function(x) {return x.id; }).indexOf(decodedData.data.id)
                //     if (orderIndex != -1) {
                //         this.orders.data[orderIndex].status = decodedData.data.status;
                //         this.orders.data[orderIndex].driver = decodedData.data.driver;
                //         updateAudio.play();
                //     }
                // });
            },
            methods: {
                openRequest(request_id){
                    window.location.href = "{{url('doorder/drivers/requests/')}}/"+request_id;
                },
                parseDateTime(date) {
                   // console.log(date);
                    let dateTime = '';
                    let date_moment = new moment(date);
                    dateTime = date_moment.format('DD MMM YY HH:mm');
                    return dateTime;
                }
            }
        });
    </script>
@endsection
