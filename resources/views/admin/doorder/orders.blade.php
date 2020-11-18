@extends('templates.dashboard')

@section('page-styles')
    <style>
        h3 {
            margin-top: 0;
            font-weight: bold;
        }

        .main-panel>.content {
            margin-top: 0px;
        }

        audio {
            height: 32px;
            margin-top: 8px;
        }

        .swal2-popup .swal2-styled:focus {
            box-shadow: none !important;
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
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
{{--                                    <i class="material-icons">home_work</i>--}}
                                    <img class="page_icon" src="{{asset('images/doorder_icons/orders_table_white.png')}}">
                                </div>
                                <h4 class="card-title ">Orders Table</h4>
                                <div class="status">
                                    <div class="status_item">
                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_pending.png')}}" alt="pending">
                                        pending order fulfilment
                                    </div>
                                    <div class="status_item">
                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_ready.png')}}" alt="ready">
                                        Ready to collect
                                    </div>
                                    <div class="status_item">
                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="matched">
                                        Matched
                                    </div>
                                    <div class="status_item">
                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="picked up">
                                        Picked up
                                    </div>
                                    <div class="status_item">
                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route.png')}}" alt="on route">
                                        On-route
                                    </div>
                                    <div class="status_item">
                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="delivered">
                                        Delivered
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
{{--                                    <a class="btn btn-success btn-sm" href="{{ url('client/add') }}">Add New</a>--}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <th>Time</th>
                                        <th>Order Number</th>
                                        <th>Retailer Name</th>
                                        <th>Status</th>
                                        <th>Stage</th>
                                        <th>Deliverer</th>
                                        <th>Pickup Location</th>
                                        <th>Delivery Location</th>
                                        </thead>

                                        <tbody>
                                            @if(count($orders))
                                                @foreach($orders as $order)
                                                    <tr>
                                                        <td>
                                                            {{$order->created_at->format('h:i')}}
                                                        </td>
                                                        <td>#{{$order->order_id}}</td>
                                                        <td>{{$order->retailer_name}}</td>
                                                        <td>
                                                            <img class="order_status_icon" src="{{asset('images/doorder_icons/order_status_'. $order->status .'.png')}}" alt="">
                                                        </td>
                                                        <td>
                                                            @php
                                                                $order_status = '';
                                                                if ($order->status == 'pending') {
                                                                    $order_status = 0;
                                                                } elseif ($order->status == 'ready') {
                                                                    $order_status = 20;
                                                                } elseif ($order->status == 'matched') {
                                                                    $order_status = 40;
                                                                } elseif ($order->status == 'picked_up') {
                                                                    $order_status = 60;
                                                                } elseif ($order->status == 'on_route') {
                                                                    $order_status = 80;
                                                                } else {
                                                                    $order_status = 100;
                                                                }
                                                            @endphp
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar" style="width: {{$order_status}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{$order->driver}}
                                                        </td>
                                                        <td>
                                                            {{$order->pickup_address}}
                                                        </td>
                                                        <td>
                                                            {{$order->customer_address}}
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
                                        {{--                                        {{$clients->links('vendor.pagination.bootstrap-4')}}--}}
                                    </nav>
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
@endsection
