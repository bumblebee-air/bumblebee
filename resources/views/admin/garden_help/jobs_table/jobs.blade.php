@extends('templates.dashboard')

@section('title', 'GardenHelp | Jobs Table')

@section('page-styles')
    <style>
        .main-panel>.content {
            margin-top: 0px;
        }
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
                                <div class="col-12 col-lg-3">
                                    <div class="card-icon">
                                        <img class="page_icon" src="{{asset('images/gardenhelp_icons/Job-Table-white.png')}}">
                                    </div>
                                    <h4 class="card-title ">Jobs Table</h4>
                                </div>
                                <div class="col-12 col-lg-9 mt-4">
                                    <div class="row justify-content-end">
                                        <div class="status">
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_pending.png')}}" alt="Not Assigned">
                                                Not Assigned
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route.png')}}" alt="Assigned">
                                                Assigned
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Accepted">
                                                Accepted
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="on way">
                                                On the way to Job Location
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="arrived">
                                                 Arrived to Job Location
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Completed">
                                                Job Completed
                                            </div>
                                        </div>                                     
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>Created At</th>
                                                <th>Scheduled At</th>
                                                <th>Service Type</th>
                                                <th>Job Number</th>
                                                <th>Status</th>
                                                <th>Stage</th>
                                                <th>Customer Name</th>
                                            </thead>
                                            <tbody>
                                                @if(count($jobs_table) > 0)
                                                    @foreach($jobs_table as $job)
                                 
                                                   <tr class="order-row" onclick="window.location = '{{route('garden_help_getSingleJob',['garden-help', $job['job_number']])}}'">
                                                            <td>{{$job['created_at']}}</td>
                                                            <td>{{$job['scheduled_at']}}</td>
                                                            <td>{{$job['service_type']}}</td>
                                                            <td>{{$job['job_number']}}</td>
                                                            <td>
                                                                @if($job['status'] == 'not_assigned')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_pending.png')}}" alt="not assigned">
                                                                @elseif($job['status'] == 'assigned')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route.png')}}" alt="assigned">
                                                                @elseif($job['status'] == 'not_assigned')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="accepted">
                                                                @elseif($job['status'] == 'on_way_job_location')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="on way">
                                                                @elseif($job['status'] == 'arrived_to_job_location')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="arrived">
                                                                @else
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="completed">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php($i = '20')
                                                                <div class="progress m-auto">
                                                                    <div class="progress-bar" role="progressbar" 
                                                                    style="width: {{$job['stage_width']}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$job['customer_name']}}
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
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection



