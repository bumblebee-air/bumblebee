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

    <div class="content" id="app">
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
                                    <h4 class="card-title ">Contractors Fee</h4>
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
                                            <th>Year of Experience</th>
                                            <th>Fee Percentage</th>
                                            <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach($settings as $item)
                                                    <tr class="order-row">
                                                        <td>{{$item->display_name}}</td>
                                                        <td>{{$item->the_value}}</td>
                                                        <td>
                                                            <a class="btn  btn-link btn-link-gardenhelp btn-just-icon edit" onclick="window.location = '{{url("garden-help/contractors/edit_fee?fee_name=$item->name")}}'">
                                                                <i class="fas fa-pen-fancy"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
