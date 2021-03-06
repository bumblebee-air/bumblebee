@extends('templates.dashboard')

@section('title', 'GardenHelp | Customers Requests')

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
                                                <th>Actions</th>
                                            </thead>

                                            <tbody>
                                                <tr v-if="requests.data.length > 0" v-for="item in requests.data" class="order-row" @click="openRequest(item.id)">
                                                    <td>
                                                        @{{item.created_at}}
                                                    </td>
                                                    <td>@{{ item.type_of_work }}</td>
                                                    <td>@{{item.name}}</td>
                                                    <td>@{{item.id}}</td>
                                                    <td>
                                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_matched.png')}}" alt="Request received" v-if="item.status === 'received'">
                                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_picked_up.png')}}" alt="Quotation Sent" v-else-if="item.status === 'quote_sent'">
                                                        <img class="status_icon" src="{{asset('images/doorder_icons/order_status_delivered.png')}}" alt="Service booked" v-else>
                                                    </td>
                                                    <td>
                                                        <div class="progress m-auto">
                                                            <div class="progress-bar" role="progressbar"
                                                            :style="'width:'  + (item.status === 'received' ? 1 : (item.status === 'quote_sent' ? 2 : 3)) * stage + '%'" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @{{item.work_location}}
                                                    </td>
                                                    <td>
                                                        <a type="button"
                                                                class="btn btn-link btn-danger btn-just-icon remove" @click.stop="deleteRequest(event, item.id)">
                                                                <i class="fas fa-trash-alt"></i>
                                                        </a>
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
                                         {{$customers_requests->links('vendor.pagination.bootstrap-4')}}  
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
                                      :action='"{{url('garden-help/customers/requests/delete')}}/"+request_id'
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script>
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                requests: '',
                stage: 33.34,
                request_id: ''
            },
            mounted() {
                socket.on('garden-help-channel:new-request'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
                    let decodedData = JSON.parse(data);
                    decodedData.data.created_at = moment(decodedData.created_at).format('YYYY-MM-DD HH:mm');
                    this.requests.data.unshift(decodedData.data);
                });

                var requests = {!! json_encode($customers_requests) !!};

                for(let item of requests.data) {
                    item.created_at = moment(item.created_at).format('YYYY-MM-DD HH:mm')
                }

                this.requests = requests;
            },
            methods: {
                openRequest(request_id){
                    window.location.href = "{{url('garden-help/customers/requests')}}/"+request_id;
                },
                deleteRequest(e, id) {
                    e.preventDefault();
                    this.request_id = id;
                    $('#delete-request-modal').modal('show')
                }
            }
        });
    </script>
@endsection


