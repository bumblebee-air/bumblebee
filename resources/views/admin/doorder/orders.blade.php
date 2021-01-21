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
                                <div class="col-12 col-sm-4">
                                    <div class="card-icon">
                                        {{--                                    <i class="material-icons">home_work</i>--}}
                                        <img class="page_icon" src="{{asset('images/doorder_icons/orders_table_white.png')}}">
                                    </div>
                                    <h4 class="card-title ">Orders Table</h4>
                                </div>
                                <div class="col-12 col-sm-8">
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
                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_on_route_pickup.png')}}" alt="matched">
                                            On-route to pickup
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
                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivery_arrived.png')}}" alt="on route">
                                            Arrived to location
                                        </div>
                                        <div class="status_item">
                                            <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="delivered">
                                            Delivered
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
                                        <th>Time</th>
                                        <th>Order Number</th>
                                        <th>Fulfilment At</th>
                                        <th>Retailer Name</th>
                                        <th>Status</th>
                                        <th>Stage</th>
                                        <th>Deliverer</th>
                                        <th>Pickup Location</th>
                                        <th>Delivery Location</th>
                                        </thead>

                                        <tbody>
{{--                                            @if(count($orders))--}}
{{--                                                @foreach($orders as $order)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->created_at->format('h:i')}}--}}
{{--                                                        </td>--}}
{{--                                                        <td>#{{$order->order_id}}</td>--}}
{{--                                                        <td>{{$order->retailer_name}}</td>--}}
{{--                                                        <td>--}}
{{--                                                            <img class="order_status_icon" src="{{asset('images/doorder_icons/order_status_'. $order->status .'.png')}}" alt="">--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            @php--}}
{{--                                                                $order_status = '';--}}
{{--                                                                if ($order->status == 'pending') {--}}
{{--                                                                    $order_status = 0;--}}
{{--                                                                } elseif ($order->status == 'ready') {--}}
{{--                                                                    $order_status = 20;--}}
{{--                                                                } elseif ($order->status == 'matched') {--}}
{{--                                                                    $order_status = 40;--}}
{{--                                                                } elseif ($order->status == 'picked_up') {--}}
{{--                                                                    $order_status = 60;--}}
{{--                                                                } elseif ($order->status == 'on_route') {--}}
{{--                                                                    $order_status = 80;--}}
{{--                                                                } else {--}}
{{--                                                                    $order_status = 100;--}}
{{--                                                                }--}}
{{--                                                            @endphp--}}
{{--                                                            <div class="progress">--}}
{{--                                                                <div class="progress-bar" role="progressbar" style="width: {{$order_status}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->driver ? $order->driver : 'N/A'}}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->pickup_address}}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{$order->customer_address}}--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                            @else--}}
{{--                                                <tr>--}}
{{--                                                    <td colspan="8" class="text-center">--}}
{{--                                                        <strong>No data found.</strong>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                            @endif--}}
                                            <tr v-for="order in orders.data" v-if="orders.data.length > 0" @click="openOrder(order.id)" class="order-row">
                                                <td>
                                                    @{{ order.time }}
                                                </td>
                                                <td>@{{order.order_id.includes('#')? order.order_id : '#'+order.order_id}}</td>
                                                <td>
                                                    @{{order.fulfilment_at}}
                                                </td>
                                                <td>@{{order.retailer_name}}</td>
                                                <td>
                                                    <img class="order_status_icon" :src="'{{asset('/')}}images/doorder_icons/order_status_' + (order.status === 'assigned' ? 'matched' :  order.status) + '.png'" :alt="order.status">
                                                </td>
                                                @php($i = 16.6)
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: {{0 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'pending'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{1 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'ready'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{2 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'matched' || order.status == 'assigned'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{3 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'on_route_pickup'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{4 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'picked_up'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{5 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'on_route'"></div>
                                                        <div class="progress-bar" role="progressbar" style="width: {{6 * $i}}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" v-if="order.status == 'delivered'"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @{{ order.driver != null ? order.driver : 'N/A' }}
                                                </td>
                                                <td>
                                                    @{{ order.pickup_address }}
                                                </td>
                                                <td>
                                                    @{{order.customer_address}}
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
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script>
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                orders: {}
            },
            mounted() {
                socket.on('doorder-channel:new-order', (data) => {
                    let decodedData = JSON.parse(data)
                    this.orders.data.unshift(decodedData.data);
                });

                socket.on('doorder-channel:update-order-status', (data) => {
                    let decodedData = JSON.parse(data);
                    console.log(decodedData);
                    // this.orders.data.filter(x => x.id === decodedData.data.id).map(x => x.foo);
                    let orderIndex = this.orders.data.map(function(x) {return x.id; }).indexOf(decodedData.data.id)
                    if (orderIndex != -1) {
                        this.orders.data[orderIndex].status = decodedData.data.status;
                        this.orders.data[orderIndex].driver = decodedData.data.driver;
                        updateAudio.play();
                    }
                });

                var orders_data = {!! json_encode($orders) !!};

                for(let order of orders_data.data) {
                    let fulfil_time= moment().add(order.fulfilment, 'minutes');
                    let duration = moment.duration(fulfil_time.diff(moment.now())).asMinutes();
                    if (duration <= 0) {
                        order.fulfilment_at = 'Fulfilled'
                    } else {
                        order.fulfilment_at = fulfil_time.format('hh:mm A');
                    }
                }

                this.orders = orders_data;
            },
            methods: {
                openOrder(order_id){
                    window.location.href = "{{url('doorder/single-order')}}/"+order_id;
                }
            }
        });
    </script>
@endsection
