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

        .container-fluid {
            padding-left: 0px;
            padding-right: 0px;
        }

        th {
            font-size: 15px!important;
        }

        td {
            font-size: 12px;
        }

        tr.order-row:hover,
        tr.order-row:focus {
            cursor: pointer;
            box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
        }
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
                                <div class="col-6 col-sm-4">
                                    <div class="card-icon">
                                        <img class="page_icon" src="{{asset('images/doorder_icons/drivers_requests.png')}}">
                                    </div>
                                    <h4 class="card-title ">Retailers Requests</h4>
                                </div>
                                <div class="col-6 col-sm-8 mt-4">
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
                                {{--                                <div class="col-12 col-sm-8">--}}
                                {{--                                    <div class="status">--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_pending.png')}}" alt="pending">--}}
                                {{--                                            pending order fulfilment--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_ready.png')}}" alt="ready">--}}
                                {{--                                            Ready to collect--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="matched">--}}
                                {{--                                            Matched--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="matched">--}}
                                {{--                                            On-route to pickup--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="picked up">--}}
                                {{--                                            Picked up--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route.png')}}" alt="on route">--}}
                                {{--                                            On-route--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="status_item">--}}
                                {{--                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="delivered">--}}
                                {{--                                            Delivered--}}
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
                                        <th>Date/Time</th>
                                        <th>Business Type</th>
                                        <th>Retailer Name</th>
                                        <th>Application No.</th>
                                        <th>Status</th>
                                        <th>Stage</th>
                                        <th>Locations No.</th>
                                        </thead>

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
                    let parseDate = new Date(date);
                    dateTime += parseDate.getFullYear() + '/';
                    dateTime += parseDate.getMonth() + '/';
                    dateTime += parseDate.getDay() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();
                    return dateTime;
                },
                openRequest(request_id) {
                    window.location = "{{url('doorder/retailers/requests/')}}/"+request_id
                }
            }
        });
    </script>
@endsection
