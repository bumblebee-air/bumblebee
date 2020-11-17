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
{{--                                <div class=" status float-right">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-2">--}}
{{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/Tick-Grey.png')}}" alt="pending">--}}
{{--                                            <p class="status_text">--}}
{{--                                                pending order fulfilment--}}
{{--                                            </p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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
                                        {{--                                        @if(count($clients))--}}
                                        {{--                                            @foreach($clients as $client)--}}
                                        {{--                                                <tr>--}}
                                        {{--                                                    <td>--}}
                                        {{--                                                        {{$client->name}}--}}
                                        {{--                                                    </td>--}}
                                        {{--                                                    <td>{{ !empty($client->user) ? $client->user->name : '' }}</td>--}}
                                        {{--                                                    <td>{{ !empty($client->user) ? $client->user->email : '' }}</td>--}}
                                        {{--                                                    <td>--}}
                                        {{--                                                        <a class="btn btn-sm btn btn-info" href="{{ url('client/edit/'.$client->id) }}">Edit</a>--}}
                                        {{--                                                        <a class="btn btn-sm btn btn-danger" deleteLink="{{ url('client/delete/'.$client->id) }}" href="#" onclick="confirmDelete(this)">Delete</a>--}}
                                        {{--                                                    </td>--}}

                                        {{--                                                </tr>--}}
                                        {{--                                            @endforeach--}}
                                        {{--                                        @else--}}
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <strong>No data found.</strong>
                                            </td>
                                        </tr>
                                        {{--                                        @endif--}}
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
