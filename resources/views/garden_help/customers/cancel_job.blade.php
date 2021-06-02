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
    <form action="{{route('garde_help_postServicesCancel', $id)}}" method="POST" enctype="multipart/form-data" autocomplete="off" id="booking-form" onsubmit="stripeCreateToken(event)">
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
        <br>
        <div class="row">
            <div class="col-md-12 mb-3 submit-container">
                <button class="btn btn-gardenhelp-green btn-register" type="submit">Cancel Job</button>
            </div>
        </div>
    </form>

@endsection

@section('scripts')

@endsection
