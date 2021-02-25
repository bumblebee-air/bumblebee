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
        
        .rowDownloadFile label{
            margin-bottom: 0 !important;
        }
        .rowDownloadFile .aDiv, .rowDownloadFile a{
            margin-top: 0 !important;
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
                                            <div class="row">
                                                <label class="requestLabel col-12">Name:
                                                <span class="form-control customerRequestSpan col-12">{{$contractor_request->name}} </span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="row">
                                                <label  class="requestLabel  col-12">Email:
                                               <span class="form-control customerRequestSpan col-12">{{$contractor_request->email}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="requestLabel col-12">Phone number:
                                               <span class="form-control customerRequestSpan col-12">{{$contractor_request->email}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <label class="requestLabel col-12">Experience level:
                                                <span class="form-control customerRequestSpan col-12">{{$contractor_request->experience_level}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">Age card / Passport:</label>
                                                <div class="col">
                                                    <img src="{{asset($contractor_request->age_proof)}}" style="width: 200px;height: 200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Type of work experience:
                                                <span class="form-control customerRequestSpan col-12">{{$contractor_request->type_of_work_exp}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-12">
                                            <div class=" row rowDownloadFile">
                                                <label class="requestLabel col-12">CV:</label>
                                                <div class="col-12 aDiv">
                                                    <a target="_blank" href="{{asset($contractor_request->cv)}}" class="btn btn-primary ">Click here To CV file</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-12">
                                            <div class=" row rowDownloadFile">
                                                <label  class="requestLabel  col-12">Job reference:</label>
                                                <div class="col aDiv">
                                                    <a target="_blank" href="{{asset($contractor_request->job_reference)}}" class="btn btn-primary ">Click here to job reference file</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label  class="requestLabel  col-12">Available tool and equipment:
                                                 <span class="form-control customerRequestSpan col-12" >{{$contractor_request->available_equipments}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                        	<div class=" row"> <div class="col-md-12">
                                           <h5 class="registerSubTitle">Other Details</h5></div></div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">Address:
                                                 <span class="form-control customerRequestSpan col-12">{{$contractor_request->address}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">Company number:
                                                 <span class="form-control customerRequestSpan col-12">
                                                 {{$contractor_request->company_number ? $contractor_request->company_number : 'N/A'}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">VAT number:
                                                 <span class="form-control customerRequestSpan col-12">
                                                 {{$contractor_request->vat_number ? $contractor_request->vat_number : 'N/A'}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">Insurance Document:
                                                 <span class="form-control customerRequestSpan col-12">
                                                 {{$contractor_request->vat_number ? $contractor_request->vat_number : 'N/A'}}</span></label>
                                            </div>
                                        </div>
                                        @if($contractor_request->experience_level_value != 1)
                                            <div class="col-12">
                                                <div class=" row">
                                                    <label class="requestLabel  col-12">What type of charge? :
                                                     <span class="form-control customerRequestSpan col-12">{{$contractor_request->charge_type}}</span></label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class=" row">
                                                    <label class="requestLabel  col-12">What rate of charge? :
                                                     <span class="form-control customerRequestSpan col-12">{{$contractor_request->charge_rate}}</span></label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <label class="requestLabel  col-12">Do you charge a call out fee? :
                                                     <span class="form-control customerRequestSpan col-12">
                                                     {{$contractor_request->has_callout_fee ? 'Yes' : 'No'}}</span></label>
                                                </div>
                                            </div>
                                            @if($contractor_request->has_callout_fee)
                                                <div class="col-12">
                                                    <div class="row">
                                                        <label class="requestLabel col-12">Call out fee charge:
                                                         <span class="form-control customerRequestSpan col-12">
                                                         {{$contractor_request->callout_fee_value}}</span></label>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-12">
                                                <div class="row">
                                                    <label class="requestLabel col-12">Rate of green waste:
                                                    < <span class="form-control customerRequestSpan col-12">
                                                    {{$contractor_request->rate_of_green_waste}}</span></label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class=" row">
                                                    <label class="requestLabel  col-12">Green waste collection method:
                                                     <span class="form-control customerRequestSpan col-12">
                                                     {{$contractor_request->green_waste_collection_method}}</span></label>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">Do you have access to a smartphone?:
                                                 <span class="form-control customerRequestSpan col-12">
                                                 {{$contractor_request->has_smartphone ? 'Yes' : 'No'}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Type of transport:
                                                 <span class="form-control customerRequestSpan col-12">
                                                 {{$contractor_request->type_of_transport}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel  col-12">Social media profiles:
                                                 <span class="form-control customerRequestSpan col-12">
                                                 {{$contractor_request->social_profile ? $contractor_request->social_profile : 'N/A'}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Website address:
                                                <span class="form-control customerRequestSpan col-12">
                                                {{$contractor_request->website_address ? $contractor_request->website_address : 'N/A'}}</span></label>
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
                                    <button class="btn btn-register btn-gardenhelp-green" style="float: right;">Accept</button>
                                </form>
                            </div>
                            <div class="col-sm-6 text-center">
                                <button class="btn btn-register btn-gardenhelp-danger"  style="float: left"
                                data-toggle="modal" data-target="#rejection-reason-modal">Reject</button>
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
                                                <div class="text-center" style="font-family:Roboto;  font-size: 30px;
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
                                                <div class="form-group ">
                                                    <label class="">Please add reason for rejection</label>
                                                    <textarea class="form-control" name="rejection_reason" rows="4" required></textarea>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around ">
                                       <div class="row">
                              			  <div class="col-sm-6 col-12">
                                            <button type="button" class="btn btn-register btn-gardenhelp-green " 
                                            onclick="$('form#request-rejection').submit()">Send</button></div>
                                            
                               			 <div class="col-sm-6 col-12">
                               			 	<button type="button" class="btn btn-register btn-gardenhelp-danger  " 
                                            data-dismiss="modal">Close</button></div></div>
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
