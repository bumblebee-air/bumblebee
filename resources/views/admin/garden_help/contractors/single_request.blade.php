@extends('templates.dashboard')

@section('title', 'GardenHelp | Contractors Requests')

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
            font-size: 10px !important;
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
                                <h4 class="card-title ">Request Number {{$contractor_request->id}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Name:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->name}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Email:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->email}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Phone Number:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->email}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Experience Level:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->experience_level}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Age Card / Passport:</label>
                                                <div class="col">
                                                    <img src="{{asset($contractor_request->age_proof)}}" style="width: 500px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Type of Work Experience:</label>
                                                <div class="col">
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->type_of_work_exp}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">CV:</label>
                                                <div class="col">
{{--                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->type_of_work_exp}}" required>--}}
                                                    <a target="_blank" href="{{asset($contractor_request->cv)}}" class="btn btn-primary">Click Here To CV File</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Job Reference:</label>
                                                <div class="col">
{{--                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->type_of_work_exp}}" required>--}}
                                                    <a target="_blank" href="{{asset($contractor_request->job_reference)}}" class="btn btn-primary">Click Here To Job Reference File</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Available Tool and Equipment:</label>
                                                <div class="col">
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->available_equipments}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Other Details:</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Address:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->address}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Company number (If registered):</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->company_number ? $contractor_request->company_number : 'N/A'}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">VAT number (If registered):</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->vat_number ? $contractor_request->vat_number : 'N/A'}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Insurance Document:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->vat_number ? $contractor_request->vat_number : 'N/A'}}" required>
                                            </div>
                                        </div>
                                        @if($contractor_request->experience_level_value != 1)
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first_name" class="control-label">What type of charge? :</label>
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->charge_type}}" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first_name" class="control-label">What rate of charge? :</label>
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->charge_rate}}" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first_name" class="control-label">Do you charge a call out fee? :</label>
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->has_callout_fee ? 'Yes' : 'No'}}" required>
                                                </div>
                                            </div>
                                            @if($contractor_request->has_callout_fee)
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first_name" class="control-label">Call out fee charge:</label>
                                                        <input id="first_name" type="text" class="form-control" value="{{$contractor_request->callout_fee_value}}" required>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first_name" class="control-label">Rate of green waste:</label>
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->rate_of_green_waste}}" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first_name" class="control-label">Green waste collection method:</label>
                                                    <input id="first_name" type="text" class="form-control" value="{{$contractor_request->green_waste_collection_method}}" required>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Do you have Access to a smartphone?:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->has_smartphone ? 'Yes' : 'No'}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Type of Transport:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->type_of_transport}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Social Media Profiles (optional):</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->social_profile ? $contractor_request->social_profile : 'N/A'}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">Website Address (optional):</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$contractor_request->website_address ? $contractor_request->website_address : 'N/A'}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <form id="order-form" method="POST" action="">
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
{{--                                        <button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">--}}
{{--                                            <i class="fas fa-times"></i>--}}
{{--                                        </button>--}}
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <form id="request-rejection" method="POST" action="{{route('garden_help_postContractorSingleRequest', ['garden-help', $contractor_request->id])}}">
                                                {{csrf_field()}}
                                                <div class="text-center" style="  font-size: 30px;
                                                                                  font-weight: bold;
                                                                                  font-stretch: normal;
                                                                                  font-style: normal;
                                                                                  line-height: normal;
                                                                                  letter-spacing: normal;
                                                                                  color: #414141;">
                                                    <img src="{{asset('images/doorder_icons/red-tick.png')}}" style="width: 160px" alt="Reqject">
                                                    <br>
                                                    Rejected
                                                </div>
                                                <div class="form-group bmd-form-group">
                                                    <label>Please add reason for rejection</label>
                                                    <textarea class="form-control" name="rejection_reason" rows="4" required></textarea>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around">
                                        <button type="button" class="btn btn-primary garden-btn-lg garden-btn" onclick="$('form#request-rejection').submit()">Send</button>
                                        <button type="button" class="btn btn-danger garden-btn-lg garden-btn" data-dismiss="modal">Close</button>
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
