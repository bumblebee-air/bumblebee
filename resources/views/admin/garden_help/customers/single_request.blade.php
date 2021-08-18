@extends('templates.dashboard')

@section('title', 'GardenHelp | Customer Request')

@section('page-styles')
    <style>
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

@media (max-width: 767px){
            .container-fluid{ 
            padding-left: 0px !important;
            padding-right: 0px !important;
            }
            .col-12{
            padding-left: 5px !important;
            padding-right: 5px !important;
            }
            .form-group label{
            margin-left: 0 !important;
            }
            .btn-register{
            float:none !important;
            }
            .modal-dialog .modal-footer button{
                margin-top: 10px !important;
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
                                <h4 class="card-title ">Customer Request Job No {{$customer_request->id}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Location:
                                                <span class="form-control customerRequestSpan col-12">{{$customer_request->work_location}} </span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label  class="requestLabel col-12">Type of work:
                                               <span class="form-control customerRequestSpan col-12">{{$customer_request->type_of_work}}</span></label>
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="col-12">
                                        	<div class=" row"> <div class="col-12">
                                           <h5 class="requestSubTitle">Business Details</h5></div></div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Business name:
                                                 <span class="form-control customerRequestSpan col-12">{{$customer_request->name}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Address:
                                                 <span class="form-control customerRequestSpan col-12">{{$customer_request->location}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Company email:
                                                 <span class="form-control customerRequestSpan col-12">{{$customer_request->email}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Contact through:
                                                 <span class="form-control customerRequestSpan col-12">{{$customer_request->contact_through}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row">
                                                <label class="requestLabel col-12">Contact person name:
                                                 <span class="form-control customerRequestSpan col-12">{{$customer_request->contact_name}}</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class=" row ">
                                                <label class="requestLabel  col-12">Contact person number:
                                                 <span class="form-control customerRequestSpan  col-12">{{$customer_request->contact_number}}</span></label>
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
                                    <button class="btn btn-register btn-gardenhelp-green" style="float: right;">Send email</button>
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
                                            <form id="request-rejection" method="POST" action="{{route('garden_help_postCustomerSingleRequest', ['garden-help', $customer_request->id])}}">
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
                                                <input type="hidden" name="rejected" value="rejected">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around ">
                                       <div class="row">
                              			  <div class="col-sm-6 col-12 text-center">
                                            <button type="button" class="btn btn-register btn-gardenhelp-green " 
                                            onclick="$('form#request-rejection').submit()">Send</button></div>
                                            
                               			 <div class="col-sm-6 col-12 text-center">
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
