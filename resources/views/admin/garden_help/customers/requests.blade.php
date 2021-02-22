@extends('templates.dashboard')

@section('title', 'GardenHelp | Customers Requests')

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
                                <div class="col-12 col-sm-6">
                                    <div class="card-icon">
                                        <img class="page_icon" src="{{asset('images/gardenhelp_icons/Requests-white.png')}}">
                                    </div>
                                    <h4 class="card-title ">Customers Requests</h4>
                                </div>
                                <div class="col-6 col-sm-6 mt-4">
                                    <div class="row justify-content-end">
                                        <div class="status">
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Request received">
                                                Request Received
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="Quotation Sent">
                                                Quotation Sent
                                            </div>
                                            <div class="status_item">
                                                <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Service booked">
                                                Service booked
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
                                                <th>Date/Time</th>
                                                <th>Type</th>
                                                <th>Customer Name</th>
                                                <th>Job No</th>
                                                <th>Status</th>
                                                <th>Stage</th>
                                                <th>Location</th>
                                            </thead>

                                            <tbody>
                                               @if(count($customers_requests) > 0)
                                                    @foreach($customers_requests as $customer)
                                                        <tr class="order-row" onclick="window.location = '{{route('garden_help_getcustomerSingleRequest',['garden-help', $customer->id])}}'">
                                                            <td>
                                                                {{$customer->created_at}}
                                                            </td>
                                                            <td> {{$customer->type_of_work}}</td>
                                                            <td>{{$customer->name}}</td>
                                                            <td>{{$customer->id}}</td>
                                                            <td>
                                                                @if($customer->status == 'received')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Request received">
                                                                @elseif($customer->status == 'missing')
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="Quotation Sent">
                                                                @else
                                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Service booked">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php($i = '33.34')
                                                                <div class="progress m-auto">
                                                                    <div class="progress-bar" role="progressbar" 
                                                                    style="width: {{($customer->status == 'received' ? 1 : ($customer->status == 'missing' ? 2 : 3)) *$i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$customer->work_location}}
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
                                         {{$customers_requests->links('vendor.pagination.bootstrap-4')}}  
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


