@extends('templates.garden_help')

@section('title', 'GardenHelp | Service Booking')

@section('page-style')
    <style>
        .input-value {
            font-family: Roboto;
            font-size: 17px;
            letter-spacing: 0.32px;
            color: #1e2432;
        }
    </style>
@endsection

@section('content')
    <form action="{{route('garde_help_postServicesBooking', $id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
        {{csrf_field()}}
        <div class="main main-raised">
            <div class="h-100 row align-items-center">
                <div class="col-md-12 text-center">
                    <img src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
                         style="height: 150px" alt="GardenHelp">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="registerSubTitle">Services Details</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Service Types</label>
                            <div class="input-value">
                                {{$customer_request->service_types}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Site Details</label>
                            <div class="input-value">
                                {{$customer_request->site_details ? $customer_request->site_details : 'N/A'}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label>Scheduled at</label>
                            <div class="input-value">
                                {{$customer_request->available_date_time}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main main-radius main-raised content-card">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-flex">
                        <div class="row">
                            <div class="col-12">
                                <div class=" row">
                                    <div class="col-12">
                                        <h5 class="cardTitleGreen requestSubTitle ">Estimated
                                            Price Quotation</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class=" col-8">
                                        <label class="requestLabelGreen">Garden maintenance
                                            (monthly)</label>
                                    </div>
                                    <div class=" col-4">
                                        <span class="requestSpanGreen">€100</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-8">
                                        <label class="requestLabelGreen">Grass cutting</label>
                                    </div>
                                    <div class=" col-4">
                                        <span class="requestSpanGreen">€25</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-8">
                                        <label class="requestLabelGreen">Gutter clearing</label>
                                    </div>
                                    <div class=" col-4">
                                        <span class="requestSpanGreen">€70</span>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 15px">
                                    <div class=" col-8">
                                        <label class="requestSpanGreen">Total</label>
                                    </div>
                                    <div class=" col-4">
                                        <span class="requestSpanGreen">€195</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main main-radius main-raised content-card">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="registerSubTitle">Billing Information</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label class="bmd-label-floating">Name on card</label>
                            <input name="name_on_card" type="text" class="form-control" id="service_type_input"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label class="bmd-label-floating">Card Number</label>
                            <input name="car_number" type="text" class="form-control" id="service_type_input"/>
                        </div>
                    </div>
                    <div class="col mt-1">
                        <div class="form-group ">
                            <label class="bmd-label-floating">CVC</label>
                            <input name="cvc_code" type="text" class="form-control" id="service_type_input"/>
                        </div>
                    </div>
                    <div class="col mt-1">
                        <div class="form-group ">
                            <label class="bmd-label-floating">Exp.Month</label>
                            <input name="exp_month" type="text" class="form-control" id="service_type_input"/>
                        </div>
                    </div>
                    <div class="col mt-1">
                        <div class="form-group ">
                            <label class="bmd-label-floating">Exp.Year</label>
                            <input name="exp_year" type="text" class="form-control" id="service_type_input"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 mb-3 ml-2 text-center">
                <img src="{{asset('images/stripe-secure.png')}}" width="150" alt="Stripe Secure">
            </div>

            <div class="col-md-12 mb-3 submit-container">
                <button class="btn btn-gardenhelp-green btn-register" type="submit">BOOK NOW</button>
            </div>
        </div>
    </form>

@endsection
