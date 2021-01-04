@extends('templates.dashboard')

@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
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

        .iti {
            width: 100%;
        }

        .form-head {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.19;
            letter-spacing: 0.8px;
            color: #4d4d4d;
            padding-left: 0px;
        }

        .form-head span {
            width: 23px;
            height: 23px;
            background-color: #f7dc69;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 10px;
            margin-right: 10px;
            font-size: 12px;
            padding-top: 5px;
            font-weight: bold;
        }

        input.form-control, textarea.form-control {
            padding: 11px 14px 11px 14px;
            border-radius: 5px;
            box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
        }

        label {
            font-size: 14px;
            font-weight: 300;
            line-height: 1.36;
            letter-spacing: 1px;
            color: #000000;
            margin-left: 10px;
        }

        .terms-container {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.3px;
            color: #5d5d5d;
            padding: 20px;
        }

        .btn-submit {
            height: 50px;
            border-radius: 22px 0 22px 0;
            box-shadow: 0 12px 36px -12px rgba(76, 151, 161, 0.35);
            background-color: #e8ca49;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 0.99px;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .reg-inputs-scroll {
            position: absolute;
            overflow-y: scroll;
        }

        .business_day_switch {
            width: 75px;
            height: 31px;
            margin: 45px 18px 10px 85px;
            border-radius: 2px;
            background-color: #eeeeee;
        }

        .business_day_switch_checked {
            background-color: #e8ca49;
        }

        .modal-content {
            border-radius: 28px;
            border: solid 1px #979797;
            background-color: #ffffff;
            padding: 50px 40px;
        }

        .modal-header {
            border: none;
        }

        .modal-footer {
            border: none;
            padding-top: 40px;
        }

        .modal-header .close {
            width: 25px;
            height: 25px;
            padding: 0;
            background-color: #e8ca49;
            border-radius: 50%;
            color: white;
        }

        .iti {
            width: 100%;
        }

        .workingBusinssDay {
            background-color: #e8ca49;
            border-radius: 2px!important;
            border: none!important;
            max-height: 21px!important;
        }

        .dayOff {
            background-color: #eeeeee;
            border-radius: 2px;
            border: none!important;
            max-height: 21px!important;
        }

        .modal-dialog-header {
            font-size: 25px;
            font-weight: 500;
            line-height: 1.2;
            text-align: center;
            color: #cab459;
        }

        .modal-content {
            /*padding: 51px 51px 112px 51px;*/
            border-radius: 30px!important;
            border: solid 1px #979797!important;
            background-color: #ffffff;
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 972px!important;
                margin-left: 16.75rem!important;
                margin-right: 16.75rem!important;
            }
        }

        .modal-header .close {
            width: 15px;
            height: 15px;
            margin: 39px 37px 95px 49px;
            background-color: #e8ca49;
            border-radius: 30px;
            color: white!important;
            top: -20px!important;
            padding: 0.6rem;
        }

        .modal-header .close i {
            font-size: 10px!important;
            margin: -5px;
        }
    </style>
@endsection
@section('title','DoOrder | Retailer Application NO. ' . $singleRequest->id)
@section('page-content')
    <div class="content" id="app">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{csrf_field()}}
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                    {{--                                    <i class="material-icons">home_work</i>--}}
                                    <img class="page_icon" src="{{asset('images/doorder_icons/drivers_requests.png')}}">
                                </div>
                                <h4 class="card-title ">Retailer Application NO. {{$singleRequest->id}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(count($errors))
                                                <div class="alert alert-danger" role="alert">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{$error}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 d-flex form-head pl-3">
                                            <span>
                                                1
                                            </span>
                                            Company Details
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control" name="company_name" value="{{$singleRequest->name}}" placeholder="Company Name" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Company Website</label>
                                                <input type="text" class="form-control" name="company_website" value="{{$singleRequest->company_website}}" placeholder="Company Website" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Business Type</label>
                                                <input type="text" class="form-control" name="business_type" value="{{$singleRequest->business_type}}" placeholder="Business Type" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Number of Business Locations</label>
                                                <input type="text" class="form-control" name="number_business_locations" value="{{$singleRequest->nom_business_locations}}" placeholder="Number of Business Locations" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
{{--                                <div class="card-header card-header-icon card-header-rose">--}}
{{--                                    <div class="card-icon">--}}
{{--                                        --}}{{--                                    <i class="material-icons">home_work</i>--}}
{{--                                        <img class="page_icon" src="{{asset('images/doorder_icons/add-plus-outline.png')}}">--}}
{{--                                    </div>--}}
{{--                                    <h4 class="card-title ">New Order</h4>--}}
{{--                                </div>--}}
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 d-flex form-head pl-3">
                                            <span>
                                                2
                                            </span>
                                            Locations Details
                                        </div>

                                        <div class="col-md-12" v-for="(location, index) in locations">
                                            <label v-if="locations.length > 1">Location @{{ index + 1 }}</label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Address</label>
                                                        <textarea :id="'location' + (index +1)" class="form-control" rows="3" :name="'address' + (index + 1)" placeholder="Address" required>@{{ location.address }}</textarea>
                                                        <input :id="'location_'+ (index+1) +'_coordinates'" :name="'address_coordinates_' + (index + 1)" type="hidden">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Eircode</label>
                                                        <input type="text" class="form-control" :name="'eircode' + (index + 1)" :id="'eircode' + (index + 1)" :value="location.eircode" placeholder="Postcode/Eircode" required>
                                                    </div>
                                                    <div class="form-group bmd-form-group">
                                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
{{--                                                            <select class="form-control" :id="'country' + (index + 1)" :name="'country' + (index + 1)" required>--}}
{{--                                                                <option disabled>Select Country</option>--}}
{{--                                                                <option value="Ireland" selected>Ireland</option>--}}
{{--                                                            </select>--}}
                                                        <input type="text" class="form-control" :value="location.country" placeholder="Country" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Working Days and Hours</label>
                                                        <input type="text" class="form-control" :id="'business_hours' + (index + 1)" :name="'business_hours' + (index + 1)" :value="location.business_hours" placeholder="Working Days and Hours">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
{{--                                                            <select class="form-control" :id="'county' + (index + 1)" :name="'county' + (index + 1)" required>--}}
{{--                                                                <option selected disabled>Select County</option>--}}
{{--                                                                <option v-for="county in counties" :value="county">@{{ county }}</option>--}}
{{--                                                            </select>--}}
                                                        <label>Country</label>
                                                        <input type="text" class="form-control" :value="location.county" placeholder="Country" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Workig Hours Modal -->
                                            <div class="modal fade" :id="'exampleModal' + index" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Select Working Days and Hours</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-center">
                                                                <div :id="'business_hours_container' + (index + 1)"></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-submit" @click="serializeBusinessHours(index + 1)" data-dismiss="modal" aria-label="Close">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row" @click="changeCurrentTap('contact')">
                                        <div class="col-md-12 d-flex form-head pl-3">
                                            <span>
                                                3
                                            </span>
                                            Contact Details
                                        </div>

                                        <div class="col-md-12" v-for="(contact, index) in contacts">
                                            <label v-if="contacts.length > 1">Contact Details @{{ index + 1 }}</label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Contact Name</label>
                                                        <input type="text" class="form-control" :id="'contact_name' + (index + 1)" :name="'contact_name' + (index + 1)" :value="contact.contact_name" placeholder="Contact Name" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Contact Number</label>
                                                        <input type="text" class="form-control" :id="'contact_number' + (index + 1)" :value="contact.contact_number" placeholder="Contact Number" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Contact Email</label>
                                                        <input type="email" class="form-control" :id="'contact_email' + (index + 1)" :value="contact.contact_email" placeholder="Contact Email Address" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        {{--                                    <input type="text" class="form-control" name="contact_location" value="{{old('contact_location')}}" placeholder="Location" required>--}}
{{--                                                            <select class="form-control" :id="'contact_location' + (index + 1)"  :name="'contact_location' + (index + 1)">--}}
{{--                                                                <option selected disabled>Location</option>--}}
{{--                                                                <option v-for="(location, index) of locations" value="location">Location @{{ index +1 }}</option>--}}
{{--                                                                <option value="all" v-if="locations.length > 1">All</option>--}}
{{--                                                            </select>--}}
                                                        <label>Location</label>
                                                        <input type="text" class="form-control" :value="contact.contact_location" placeholder="Location" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row" @click="changeCurrentTap('contact')">
                                        <div class="col-md-12 d-flex form-head pl-3">
                                            <span>
                                                4
                                            </span>
                                            Shopify Details
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Shop URL</label>
                                                        <input type="text" class="form-control" value="{{$singleRequest->shopify_store_domain}}" placeholder="Shop URL" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>App API key</label>
                                                        <input type="text" class="form-control" value="{{$singleRequest->shopify_app_api_key}}" placeholder="App API key" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>App Password</label>
                                                        <input type="text" class="form-control" value="{{$singleRequest->shopify_app_password}}" placeholder="App Password" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>App Secret</label>
                                                        <input type="text" class="form-control" value="{{$singleRequest->shopify_app_secret}}" placeholder="App Secret" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-sm-6 text-center">
                                    <form id="order-form" method="POST" action="{{route('post_doorder_retailers_single_request', ['doorder', $singleRequest->id])}}">
                                        {{csrf_field()}}
                                        <button class="btn bt-submit">Accept</button>
                                    </form>
                                </div>
                            <div class="col-sm-6 text-center">
                                <button class="btn bt-submit btn-danger" data-toggle="modal" data-target="#rejection-reason-modal">Reject</button>
                            </div>
                        </div>

                        <!-- Rejection Reason modal -->
                        <div class="modal fade" id="rejection-reason-modal" tabindex="-1" role="dialog" aria-labelledby="assign-deliverer-label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        {{--                        <h5 class="modal-title" id="assign-deliverer-label">Assign deliverer</h5>--}}
                                        <button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <form id="request-rejection" method="POST" action="{{route('post_doorder_retailers_single_request', ['doorder', $singleRequest->id])}}">
                                                {{csrf_field()}}
                                                <div class="form-group bmd-form-group">
                                                    <label>Please add reason for rejection</label>
                                                    <textarea class="form-control" name="rejection_reason" rows="4" required></textarea>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around">
                                        <button type="button" class="btn btn-primary doorder-btn-lg doorder-btn" onclick="$('form#request-rejection').submit()">Assign</button>
                                        <button type="button" class="btn btn-danger doorder-btn-lg doorder-btn" data-dismiss="modal">Close</button>
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

@section('page-scripts')
{{--    <script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>--}}
{{--    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>--}}
    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    locations: JSON.parse({!! json_encode($singleRequest->locations_details) !!}),
                    contacts: JSON.parse({!! json_encode($singleRequest->contacts_details) !!}),
                }
            },
        });
    </script>
@endsection
