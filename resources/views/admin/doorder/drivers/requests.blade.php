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

@section('title', 'DoOrder | Drivers Requests')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose row">
                                <div class="col-12 col-sm-4">
                                    <div class="card-icon">
                                        {{--                                    <i class="material-icons">home_work</i>--}}
                                        <img class="page_icon" src="{{asset('images/doorder_icons/drivers_requests.png')}}">
                                    </div>
                                    <h4 class="card-title ">Drivers Table</h4>
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
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    {{--                                    <a class="btn btn-success btn-sm" href="{{ url('client/add') }}">Add New</a>--}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <th>Date/Time</th>
                                        <th>Location</th>
                                        <th>Deliverer Name</th>
                                        <th>Application No.</th>
                                        <th>Status</th>
                                        <th>Stage</th>
                                        <th>Address</th>
                                        </thead>

                                        <tbody>
                                            <tr v-for="driver_request in drivers_requests.data" v-if="drivers_requests.data.length > 0" class="order-row" @click="openRequest(driver_request.id)">
                                                <td>@{{ parseDateTime(driver_request.created_at) }}</td>
                                                <td>
                                                    @{{ JSON.parse(driver_request.work_location).name}}
                                                </td>
                                                <td>
                                                    @{{ driver_request.first_name}} @{{ driver_request.last_name  }}
                                                </td>
                                                <td>
                                                    @{{ driver_request.id}}
                                                </td>
                                                <td>
                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_ready.png')}}" v-if="driver_request.status == 'received'" alt="Request received">
                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" v-if="driver_request.status == 'missing'" alt="Missing Data">
                                                    <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" v-if="driver_request.status == 'completed'" alt="Request completed">
                                                </td>
                                                @php($i = 33.34)
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{1 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="driver_request.status == 'received'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{2 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="driver_request.status == 'missing'"></div>
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
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date(date);
                    let date_moment = new moment(date);
                    /*dateTime += parseDate.getDate() + '/';
                    dateTime += parseDate.getMonth()+1 + '/';
                    dateTime += parseDate.getFullYear() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();*/
                    dateTime = date_moment.format('DD-MM-YYYY HH:mm');
                    return dateTime;
                }
            }
        });
    </script>
@endsection
