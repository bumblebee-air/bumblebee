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
                                    <h4 class="card-title ">Customers</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table" id="requestsTable">
                                            <thead><tr>
                                                <th>Customer Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
{{--                                                <th>Address</th>--}}
                                                <th>Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-if="customers.data.length > 0" v-for="item in customers.data" class="order-row">
                                                    <td>@{{item.name}}</td>
                                                    <td>@{{item.email}}</td>
                                                    <td>@{{item.phone}}</td>
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
                                         {{$customers->links('vendor.pagination.bootstrap-4')}}
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
                                to delete this customer?
                                <br>
                                <small>knowing that it will delete all data related to him, such as jobs and properties.</small>
                            </div>

                            <div>

                                <form method="POST" id="delete-request"
                                      :action='"{{url('garden-help/customers/delete')}}/"+customer_id'
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
    
$(document).ready(function() {
    var table= $('#requestsTable').DataTable({
        lengthChange: false,
         searching: true,
         info: false,
         ordering: false,
         paging: true,
         language: {
            search: '',
            "searchPlaceholder": "Search ",
        },
        // scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
        // fixedColumns: true
    });
});
    
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                customers: '',
                stage: 33.34,
                customer_id: ''
            },
            mounted() {
                socket.on('garden-help-channel:new-request'+'-'+'{{env('APP_ENV','dev')}}', (data) => {
                    let decodedData = JSON.parse(data);
                    decodedData.data.created_at = moment(decodedData.created_at).format('YYYY-MM-DD HH:mm');
                    this.customers.data.unshift(decodedData.data);
                });

                var customers = {!! json_encode($customers) !!};

                for(let item of customers.data) {
                    item.created_at = moment(item.created_at).format('YYYY-MM-DD HH:mm')
                }

                this.customers = customers;
            },
            methods: {
                openRequest(customer_id){
                    window.location.href = "{{url('garden-help/customers/requests')}}/"+customer_id;
                },
                deleteRequest(e, id) {
                    console.log(id)
                    e.preventDefault();
                    this.customer_id = id;
                    $('#delete-request-modal').modal('show')
                }
            }
        });
    </script>
@endsection


