@extends('templates.dashboard')

@section('page-styles')
    <style>
      
    </style>
@endsection

@section('title', 'DoOrder | Orders')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose row">
                               <div class="col-12 col-lg-6 col-md-6">
                                    <div class="card-icon">
                                        <img class="page_icon" src="{{asset('images/doorder_icons/drivers_requests.png')}}">
                                    </div>
                                    <h4 class="card-title ">Retailers Requests</h4>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6 mt-md-3">
                                    <div class="row justify-content-end">
                                        <div class="status">
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_ready.png')}}" alt="Request received">
                                                Request received
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="Missing Data">
                                                Missing Data
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Request completed">
                                                Request completed
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="retailersTable"
									cellspacing="0" width="100%" >
                                        <thead> <tr>
                                        <th>Date/Time</th>
                                        <th>Business Type</th>
                                        <th>Retailer Name</th>
                                        <th>Application No.</th>
                                        <th>Status</th>
                                        <th>Stage</th>
                                        <th>Locations No.</th>
                                       </tr> </thead>

                                        <tbody>
                                            <tr v-for="request in retailers_requests.data" v-if="retailers_requests.data.length > 0" class="order-row" @click="openRequest(request.id)">
                                                <td>@{{ parseDateTime(request.created_at) }}</td>
                                                <td>@{{ request.business_type}}</td>
                                                <td>@{{ request.name}}</td>
                                                <td>@{{ request.id}}</td>
                                                <td>
                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_ready.png')}}" v-if="request.status == 'received'" alt="Request received">
                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" v-if="request.status == 'missing'" alt="Missing Data">
                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" v-if="request.status == 'completed'" alt="Request completed">
                                                </td>
                                                @php($i = 33.34)
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{1 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="request.status == 'received'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{2 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="request.status == 'missing'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{3 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="request.status == 'completed'"></div>
                                                    </div>
                                                </td>
                                                <td>@{{ request.nom_business_locations }}</td>
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
                            {{$retailers_requests->links()}}
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
          "searching": false,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
    	 columnDefs: [
                {
                    render: function (data, type, full, meta) {
                    	return '<span data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
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
                retailers_requests: {!! json_encode($retailers_requests) !!}
            },
            mounted() {

            },
            methods: {
                openOrder(order_id){
                    {{--window.location.href = "{{url('doorder/single-order')}}/"+order_id;--}}
                },
                parseDateTime(date) {
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date();
                    let date_moment = new moment();
                    if(date!=null && date!=''){
                        //parseDate = new Date(date);
                        date_moment = new moment(date);
                    }
                    /*dateTime += parseDate.getDate() + '/';
                    dateTime += parseDate.getMonth() + '/';
                    dateTime += parseDate.getFullYear() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();*/
                    dateTime = date_moment.format('DD-MM-YYYY HH:mm');
                    return dateTime;
                },
                openRequest(request_id) {
                    window.location = "{{url('doorder/retailers/requests/')}}/"+request_id
                }
            }
        });
    </script>
@endsection
