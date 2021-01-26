@extends('templates.dashboard')

@section('title', 'GardenHelp | Contractors Requests')

@section('page-styles')
    <style>
        .main-panel>.content {
            margin-top: 0px;
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
                                    <img class="page_icon" src="{{asset('images/gardenhelp_icons/Requests-white.png')}}">
                                </div>
                                <h4 class="card-title ">Request Number 1000</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>Date/Time</th>
                                                <th>Level</th>
                                                <th>Request No</th>
                                                <th>Status</th>
                                                <th>Address</th>
                                            </thead>

                                            <tbody>
                                                @if(count($contractors_requests) > 0)
                                                    @foreach($contractors_requests as $contractor)
                                                        <tr>
                                                            <td>
                                                                {{$contractor->created_at}}
                                                            </td>
                                                            <td>Level {{$contractor->experience_level_value}}</td>
                                                            <td>{{$contractor->id}}</td>
                                                            <td>
                                                                @php
                                                                    $contractor_status = '80';
                                                                    /*if ($order->status == 'pending') {
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
                                                                    }*/
                                                                @endphp
                                                                <div class="progress m-auto">
                                                                    <div class="progress-bar" role="progressbar" style="width: {{$contractor_status}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$contractor->address}}
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

        </div>
    </div>
@endsection


