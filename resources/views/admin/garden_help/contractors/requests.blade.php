@extends('templates.dashboard')

@section('title', 'GardenHelp | Contractors Requests')

@section('page-styles')
    <style>
        tr.order-row:hover,
        tr.order-row:focus {
            cursor: pointer;
            box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
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
                            <div class="card-header card-header-icon card-header-rose row">
                                <div class="col-12 col-sm-6">
                                    <div class="card-icon">
                                        <img class="page_icon" src="{{asset('images/gardenhelp_icons/Requests-white.png')}}">
                                    </div>
                                    <h4 class="card-title ">Contractors Requests</h4>
                                </div>
                                <div class="col-6 col-sm-6 mt-4">
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
                            <div class="card-body">
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table" id="requestsTable">
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

                                            <tbody>
                                                @if(count($contractors_requests) > 0)
                                                    @foreach($contractors_requests as $contractor)
                                                        <tr class="order-row" onclick="window.location = '{{route('garden_help_getContractorSingleRequest',['garden-help', $contractor->id])}}'">
                                                            <td>
                                                                {{$contractor->created_at}}
                                                            </td>
                                                            <td> {{$contractor->experience_level}}</td>
                                                            <td>{{$contractor->name}}</td>
                                                            <td>{{$contractor->id}}</td>
                                                            <td>
                                                                @if($contractor->status == 'received')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Request received">
                                                                @elseif($contractor->status == 'missing')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="Missing Data">
                                                                @else
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Request completed">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php($i = '33.34')
                                                                <div class="progress m-auto">
                                                                    <div class="progress-bar" role="progressbar" 
                                                                    style="width: {{($contractor->status == 'received' ? 1 : ($contractor->status == 'missing' ? 2 : 3)) *$i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$contractor->address}}
                                                            </td>
                                                            <td>
                                                                <a type="button"
                                                                   class="btn btn-link btn-danger btn-just-icon remove" @click.stop="deleteRequest(event, {{$contractor->id}})">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="8" class="text-center">
                                                            <strong>No data found.</strong>
                                                        </td>
                                                    </tr>
                                                @endif
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
                 role="dialog" aria-labelledby="delete-contractor-label"
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
                            <div class="modal-dialog-header deleteHeader">Are you sure you want
                                to delete this request?</div>

                            <div>

                                <form method="POST" id="delete-request"
                                      :action='"{{url('garden-help/contractors/requests/delete')}}/"+request_id'
                                      style="margin-bottom: 0 !important;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-around">
                            <button type="button" class="btn  btn-register btn-gardenhelp-green"
                                    onclick="$('form#delete-request').submit()">Yes</button>
                            <button type="button"
                                    class="btn btn-register  btn-gardenhelp-danger"
                                    data-dismiss="modal">Cancel</button>
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
                request_id: ''
            },
            mounted() {

            },
            methods: {
                deleteRequest(e, id) {
                    e.preventDefault();
                    this.request_id = id;
                    $('#delete-request-modal').modal('show')
                }
            }
        });
    </script>
@endsection


