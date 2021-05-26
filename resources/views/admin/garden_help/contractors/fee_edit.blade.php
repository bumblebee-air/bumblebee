@extends('templates.dashboard')
@section('title', 'GardenHelp | Edit
Fee')
@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

    <style>
        .main-panel>.content {
            margin-top: 0px;
        }

        @media ( max-width : 767px) {
            .container-fluid {
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
            .col-12 {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }
            .form-group label {
                margin-left: 0 !important;
            }
            .btn-register {
                float: none !important;
            }
        }

        .fa-check-circle {
            color: #b1b1b1;
            line-height: 3;
            font-size: 20px
        }

        .iti {
            width: 100%;
        }

        .requestSubTitle {
            margin-top: 25px !important;
            margin-bottom: 10px !important;
        }

        .form-control, .form-control:invalid, .is-focused .form-control {
            box-shadow: none !important;
        }
    </style>
@endsection @section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid" id="app">
                <form action="{{route('garden_help_updateContractorsFee', 'garden-help')}}" method="POST"
                      enctype="multipart/form-data" autocomplete="off">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon card-header-rose">
                                    <div class="card-icon">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <h4 class="card-title ">Edit Contractor Fee</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-7 col-sm-6 col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group ">
                                                            <label for="fee_name" class="">Year of Experiance</label>
                                                            <input type="text" class="form-control" value="{{$fee->display_name}}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group ">
                                                            <label for="fee_name" class="">Fee Percentage</label>
                                                            <input name="the_value" type="number" class="form-control" value="{{$fee->the_value}}">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="{{$fee->id}}">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button id="addNewJobBtn"
                                            class="btn btn-register btn-gardenhelp-green">
                                        Edit
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
@section('page-scripts')

@endsection
