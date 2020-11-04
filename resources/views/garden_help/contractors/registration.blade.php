@extends('templates.garden_help')

@section('title', 'Contractors Registration')

@section('styles')
    <style>
        html, body {
            height: 100%;
        }

        .title {
            color: #62a043;
            font-weight: bold;
        }

        .sub-title {
            font-weight: bold;
        }

        .container {
            /*padding-left: 12px;*/
            /*padding-right: 12px;*/

            padding-left: 0px;
            padding-right: 0px;
        }

        .main {
            background-color: white;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            padding-top: 10px;
            padding-left: 23px;
            padding-right: 23px;
        }

        .modal-content {
            border-radius: 20px!important;
            box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08)!important;
            padding-left: 12px;
            padding-right: 12px;
        }

        .modal-body .row .d-flex{
            padding-bottom: 13px;
        }
        .modal-title {
            font-weight: bold;
        }

        .form-check-label {
            font-family: Roboto;
            font-size: 17px !important;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal !important;
            letter-spacing: 0.32px;

        }

        .modal-button-close {
            width: 57px;
            height: 45px;
            font-family: Roboto;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 2.5;
            letter-spacing: 0.17px;
            color: #767676;
        }

        .modal-button-done {
            width: 43px;
            height: 45px;
            font-family: Roboto;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 2.5;
            letter-spacing: 0.17px;
            color: #60a244 !important;
        }

        .modal-button-done:disabled {
            color: #999 !important;
        }

        .content-card {
            border-radius: 20px;
            box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
            margin-top: 10px;
            padding-top: 25px;
        }

        .my-check-box-label {
            font-family: Roboto;
            font-size: 17px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.32px;
            color: #acb1c0!important;
        }

        .my-check-box-label-checked {
            color: #6c707c!important;
            font-weight: bold!important;
        }

        .my-check-box {
            width: 15px;
            height: 15px;
            color: #c3c7d2;
        }
        .my-check-box .checked {
            color: #60a244;
        }

        .add-other-button {
            position: absolute;
            right: 0;
            color: gray;
            margin-top: 10px;
            margin-right: 15px;
            color: #c3c7d2!important;
            transition: 0.3s ease-in-out;
        }

        .inputFileVisible {
            background-image: none;
        }

        .circle {
            border-color: #60a244!important;
        }

        .check {
            background-color: #60a244!important;
        }

        .form-check-label {
            font-size: 17px;
            letter-spacing: 0.32px;
            color: #1e2432;

        }

        .terms {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.32px;
            color: #1e2432;
            padding-right: 29px;
            padding-left: 29px;
        }
        .terms-text {
            color: #60a244;
        }

        .submit-btn {
            height: 48px;
            border-radius: 24px;
            background-color: #60a244!important;
            font-size: 14px;
            font-weight: bold;
            line-height: 0.79;
            letter-spacing: 0.32px;
            text-align: center;
            color: #ffffff!important;
        }

        .submit-container {
            padding-left: 29px;
            padding-right: 29px;
        }

        .select-icon {
            position: absolute;
            right: 0;
            color: gray;
            margin-top: 10px;
            margin-right: 15px;
            color: #c3c7d2!important;
            transition: 0.3s ease-in-out;
            font-size: 20px;
        }

    </style>
@endsection

@section('content')
    <div class="container" id="app">
        <form action="{{route('postContractorRegistration')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{csrf_field()}}
            <div class="main main-raised">
                <div class="h-100 row align-items-center">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/Garden-Help-Logo.png')}}" alt="GardenHelp">
                    </div>
                </div>
                <div class="container">
                    <div class="section">
                        <h4 class="title">Contractors Registration Form</h4>
                        <h5 class="sub-title">Company/Individual Form</h5>
                    </div>
                    @if(count($errors))
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Phone Number</label>
                                <input type="tel" class="form-control" name="phone_number" value="{{old('phone_number')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="experience_level" class="bmd-label-floating">Experience Level</label>
                                <input name="experience_level" type="text" class="form-control" id="experience_level"
                                       v-model="experience_level_input" @click="openModal('experience_level')" required>
                                <!-- Button trigger modal -->
                                <a id="experience_level_btn_modal" data-toggle="modal"
                                   data-target="#experience_levelModal" style="display: none"></a>

                                <!-- Modal -->
                                <div class="modal fade" id="experience_levelModal" tabindex="-1" role="dialog"
                                     aria-labelledby="experience_levelLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-left" id="experience_levelLabel">Experience
                                                    Level</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-check form-check-radio form-check-inline d-flex justify-content-between">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio"
                                                               name="experience_level_value" id="inlineRadio1"
                                                               v-model="experience_level" value="1">
                                                        Level 1 (0-2 Years)
                                                        <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio"
                                                               name="experience_level_value" id="inlineRadio2"
                                                               v-model="experience_level" value="2">
                                                        Level 2 (2-5 Years)
                                                        <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-radio form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio"
                                                               name="experience_level_value" id="inlineRadio2"
                                                               v-model="experience_level" value="3">
                                                        Level 3 (+5 Years)
                                                        <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link modal-button-close"
                                                        data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-link modal-button-done"
                                                        data-dismiss="modal"
                                                        :disabled="experience_level != '' ? false : true"
                                                        @click="changeExperienceLevel">Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 2 || experience_level_selected_value == 1">
                            <div class="form-group form-file-upload form-file-multiple bmd-form-group">
                                <label class="bmd-label-static" for="age_proof">
                                    Upload Age Card or Passport
                                    <br>
                                    (Age Proof 18 or older)
                                </label>
                                <br>
                                <input id="age_proof" name="age_proof" type="file" class="inputFileHidden" @change="onChangeFile($event, 'age_proof_input')">
                                <div class="input-group" @click="addFile('age_proof')">
                                    <input type="text" id="age_proof_input" class="form-control inputFileVisible" placeholder="Upload Photo" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-success">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="type_of_experience">Type of work experience </label>
                                <div class="d-flex justify-content-between" @click="openModal('type_of_experience')">
                                    <input name="type_of_work_exp" type="text" class="form-control" id="type_of_experience" v-model="experience_type_input" required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                                <!-- Button trigger modal -->
                                <a id="type_of_experience_btn_modal" data-toggle="modal"
                                   data-target="#type_of_experienceModal" style="display: none"></a>

                                <!-- Modal -->
                                <div class="modal fade" id="type_of_experienceModal" tabindex="-1" role="dialog"
                                     aria-labelledby="type_of_experienceLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-left" id="type_of_experienceLabel">Type of work experience</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
{{--                                                    @{{type.level.includes(experience_level)}}--}}
                                                    <div class="col-md-12 d-flex justify-content-between" v-for="type in experience_types" v-if="type.level.includes(experience_level) === true" @click="toggleCheckedValue(type)">
                                                        <label for="my-check-box" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
                                                        <div class="my-check-box" id="check">
                                                            <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-between">
                                                        <input type="text" class="form-control" placeholder="Add Other" v-model="experience_type_other">
                                                        <a class="add-other-button" v-if="experience_type_other != ''" @click="addOtherInput('experience_type')">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('experience_type')">
                                                    Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="experience_level_selected_value == 2 || experience_level_selected_value == 1">
                            <div class="form-group form-file-upload form-file-multiple">
{{--                                <label for="vat-number">--}}
{{--                                    Upload CV--}}
{{--                                </label>--}}
                                <input id="cv" name="cv" type="file" class="inputFileHidden" @change="onChangeFile($event, 'cv_input')">
                                <div class="input-group" @click="addFile('cv')">
                                    <input type="text" id="cv_input" class="form-control inputFileVisible" placeholder="Upload CV" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-success">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 2 || experience_level_selected_value == 1">
                            <div class="form-group form-file-upload form-file-multiple">
                                {{--                                <label for="vat-number">--}}
                                {{--                                    Upload CV--}}
                                {{--                                </label>--}}
                                <input id="job_reference" name="job_reference" type="file" class="inputFileHidden" @change="onChangeFile($event,'job_reference_input')">
                                <div class="input-group" @click="addFile('job_reference')">
                                    <input type="text" id="job_reference_input" class="form-control inputFileVisible" placeholder="Upload Job References" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-success">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 2 || experience_level_selected_value == 1">
                            <div class="form-group bmd-form-group">
                                <label for="available_tools">Available Tools and Equipment</label>
                                <div class="d-flex justify-content-between" @click="openModal('available_tools')">
                                    <input type="text" class="form-control" name="available_equipments" id="available_tools" v-model="available_tool_input" required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                                <!-- Button trigger modal -->
                                <a id="available_tools_btn_modal" data-toggle="modal"
                                   data-target="#available_toolsModal" style="display: none"></a>

                                <!-- Modal -->
                                <div class="modal fade" id="available_toolsModal" tabindex="-1" role="dialog"
                                     aria-labelledby="available_toolsLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-left" id="type_of_experienceLabel">Available Tools and Equipment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-between" v-for="tool in available_tools" @click="toggleCheckedValue(tool)">
                                                        <label for="my-check-box" :class="tool.is_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ tool.title }}</label>
                                                        <div class="my-check-box" id="check">
                                                            <i :class="tool.is_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-between">
                                                        <input type="text" class="form-control" placeholder="Add Other" v-model="available_tool_other">
                                                        <a class="add-other-button" v-if="available_tool_other != ''" @click="addOtherInput('available_tools')">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('available_tools')">
                                                    Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            {{--Other Details--}}
            <div class="main main-raised content-card">
                <div class="container">
                    <div class="section">
                        <h5 class="sub-title">Other Details</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating" for="address">Address</label>
                                <input id="address" type="text" class="form-control" name="address" value="{{old('address')}}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating" for="company-number">Company Number (if Registered)</label>
                                <input id="company-number" type="text" class="form-control" name="company_number" value="{{old('company_number')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="vat-number" class="bmd-label-floating">VAT Number (if Registered)</label>
                                <input id="vat-number" type="text" class="form-control" name="vat_number" value="{{old('vat_number')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-file-upload form-file-multiple">
                                <label for="vat-number">Upload Insurance document</label>
                                <input name="insurance_document" id="insurance_document" type="file" class="inputFileHidden" @change="onChangeFile($event,'insurance_document_input')">
                                <div class="input-group" @click="addFile('insurance_document')">
                                    <input id="insurance_document_input" type="text" class="form-control inputFileVisible" placeholder="Upload Document" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-success">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-file-upload form-file-multiple">
                                <label for="vat-number">Do you have a smartphone?</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios2" name="has_smartphone" value="1" {{old('has_smartphone') === '1' ? 'checked' : ''}} required>
                                                Yes
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios1" name="has_smartphone" value="0" {{old('has_smartphone') === '0' ? 'checked' : ''}} required>
                                                No
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating" for="transport_types">Type of Transport</label>
                                <div class="d-flex justify-content-between">
                                    <input type="text" class="form-control" id="transport_types" name="type_of_transport" v-model="transport_type_input" @click="openModal('transport_types')" required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                                <!-- Button trigger modal -->
                                <a id="transport_types_btn_modal" data-toggle="modal"
                                   data-target="#transport_typesModal" style="display: none"></a>

                                <!-- Modal -->
                                <div class="modal fade" id="transport_typesModal" tabindex="-1" role="dialog"
                                     aria-labelledby="available_toolsLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-left" id="type_of_experienceLabel">Type of Transport </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-between" v-for="type in transport_types" @click="toggleCheckedValue(type)">
                                                        <label for="my-check-box" :class="type.is_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
                                                        <div class="my-check-box" id="check">
                                                            <i :class="type.is_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('transport_types')">
                                                    Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 3">
                            <div class="form-group form-file-upload form-file-multiple">
                                <label for="vat-number">What type of charge?</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios2" name="charge_type" value="Hourly" v-model="charge" required>
                                                Hourly
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios1" name="charge_type" value="Daily" v-model="charge" required>
                                                Daily
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 3 && charge != ''">
                            <div class="form-group bmd-form-group">
{{--                                <label class="bmd-label-floating">Social Media Profiles (optional)</label>--}}
                                <input type="text" class="form-control" name="charge_rate" :placeholder="charge + ' Charge'" value="{{old('charge_rate')}}" required>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 3">
                            <div class="form-group form-file-upload form-file-multiple">
                                <label for="vat-number">Do you charge a call out fee?</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios2" name="has_callout_fee" value="1" v-model="call_out_fee">
                                                Yes
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios1" name="has_callout_fee" value="0" v-model="call_out_fee">
                                                No
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                        <div class="col-md-12" v-if="experience_level_selected_value == 3 && call_out_fee === '1'">--}}
{{--                            <div class="form-group bmd-form-group">--}}
{{--                                <label class="bmd-label-floating">Call out fee charge</label>--}}
{{--                                <input type="text" class="form-control" name="callout_fee_value">--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-md-12" v-if="experience_level_selected_value == 3 && call_out_fee === '1'">
                            <div class="form-group bmd-form-group">
{{--                                <label class="bmd-label-floating">Call out fee charge</label>--}}
                                <input type="text" class="form-control" name="callout_fee_value" placeholder="Call out fee charge" value="{{old('callout_fee_value')}}" required>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 3">
                            <div class="form-group bmd-form-group">
                                {{--                                <label class="bmd-label-floating">Social Media Profiles (optional)</label>--}}
                                <input type="text" class="form-control" name="rate_of_green_waste" placeholder="Rates for green waste removal" value="{{old('rate_of_green_waste')}}" required>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="experience_level_selected_value == 3">
                            <div class="form-group bmd-form-group">
                                <label for="green_waste_collection_method">Green waste collection method</label>
                                <div class="d-flex justify-content-between" @click="openModal('green_waste_collection_method')">
                                    <input type="text" name="green_waste_collection_method" class="form-control" id="green_waste_collection_method" v-model="green_waste_collection_method_input" required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                                <!-- Button trigger modal -->
                                <a id="green_waste_collection_method_btn_modal" data-toggle="modal"
                                   data-target="#green_waste_collection_methodsModal" style="display: none"></a>

                                <!-- Modal -->
                                <div class="modal fade" id="green_waste_collection_methodsModal" tabindex="-1" role="dialog"
                                     aria-labelledby="available_toolsLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-left" id="green_waste_collection_methodsLabel">Green waste collection method</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-between" v-for="method in green_waste_collection_methods" @click="toggleCheckedValue(method)">
                                                        <label for="my-check-box" :class="method.is_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ method.title }}</label>
                                                        <div class="my-check-box" id="check">
                                                            <i :class="method.is_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-between">
                                                        <input type="text" class="form-control" placeholder="Add Other" v-model="green_waste_collection_method_other">
                                                        <a class="add-other-button" v-if="green_waste_collection_method_other != ''" @click="addOtherInput('green_waste_collection_method')">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('green_waste_collection_methods')">
                                                    Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Social Media Profiles (optional)</label>
                                <input type="text" class="form-control" name="social_profiles" value="{{old('social_profiles')}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Website Address (optional)</label>
                                <input type="text" class="form-control" name="website" value="{{old('website')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p class="terms">
                        By clicking Submit, you agree to our <span class="terms-text">Terms & Conditions</span> and that you have read our <span class="terms-text">Privacy Policy</span>
                    </p>
                </div>

                <div class="col-md-12 submit-container">
                    <button class="btn btn-success btn-block submit-btn" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                experience_level: '{{old('experience_level_value') ? old('experience_level_value') : 1}}',
                experience_level_input: '{{old('experience_level') ?  old('experience_level') : 'Level 1 (0-2 Years)'}}',
                experience_level_selected_value: '{{old('experience_level_value') ? old('experience_level_value') : 1}}',
                experience_types: [
                    {
                        title: 'Garden Design',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Garden Design') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Tree surgery',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Tree surgery') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Garden Maintenance',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Garden Maintenance') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Grass Cutting',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Grass Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Fencing')  === false  ? 'false' : true) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Groundwork',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Groundwork') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Landscaping',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Landscaping') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"],
                    },
                ],
                experience_type: '{{old('type_of_work_exp')}}',
                experience_type_input: '{{old('type_of_work_exp')}}',
                experience_type_other: '',
                available_tools: [
                    {
                        title: 'Hedge cutters',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hedge cutters') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Hand fork',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hand fork') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Lawn scarifier',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Lawn scarifier') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Hoe',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hoe') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Secateurs',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Secateurs') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Dibber',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Dibber') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Pruning saw',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Pruning saw') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Paving knife',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Paving knife') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Edging knife',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Edging knife') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Mattock',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Mattock') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                ],
                available_tool_other: '',
                available_tool_input: "{{old('available_equipments')}}",
                transport_types: [
                    {
                        title: 'Van',
                        is_checked: JSON.parse("{{old('type_of_transport') ? ( strpos(old('type_of_transport'), 'Van') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{{old('type_of_transport') ? ( strpos(old('type_of_transport'), 'Trailer') === false  ? 'false' : 'true' ) : 'false'}}")
                    }
                ],
                transport_type_input: "{{old('type_of_transport')}}",
                charge: "{{old('charge_type')}}",
                call_out_fee: "{{old('has_callout_fee')}}",
                call_out_fee_charge: "{{old('callout_fee_value')}}",
                green_waste_collection_methods: [
                    {
                        title: 'Ton bags',
                        is_checked: JSON.parse("{{old('green_waste_collection_method') ? ( strpos(old('green_waste_collection_method'), 'Ton bags') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{{old('green_waste_collection_method') ? ( strpos(old('green_waste_collection_method'), 'Trailer') === false  ? 'false' : 'true' ) : 'false'}}")
                    }
                ],
                green_waste_collection_method_input: "{{old('green_waste_collection_method')}}",
                green_waste_collection_method_other: ''
            },
            mounted() {

            },
            methods: {
                changeExperienceLevel() {
                    if (this.experience_level == 1) {
                        this.experience_level_input = "Level 1 (0-2 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    } else if (this.experience_level == 2) {
                        this.experience_level_input = "Level 2 (2-5 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    } else {
                        this.experience_level_input = "Level 3 (+5 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    }
                },
                openModal(type) {
                    $('#' + type + '_btn_modal').click();
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                addOtherInput(type) {
                    if (type === 'experience_type') {
                        this.experience_types.push({
                            title: this.experience_type_other,
                            is_checked: true,
                            level: [this.experience_level],
                        });
                        this.experience_type_other = '';
                    } else if (type === 'available_tools') {
                        this.available_tools.push({
                            title: this.available_tool_other,
                            is_checked: true
                        });
                        this.available_tool_other = '';
                    } else if (type === 'green_waste_collection_method') {
                        this.green_waste_collection_methods.push({
                            title: this.green_waste_collection_method_other,
                            is_checked: true
                        });
                        this.green_waste_collection_method_other = '';
                    }
                },
                changeSelectedValue(type) {
                    let input = '';
                    let list = '';
                    if (type === 'experience_type') {
                        this.experience_type_input = '';
                        list = this.experience_types;
                        for(let item of list) {
                            item.is_checked === true ? this.experience_type_input += (this.experience_type_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'available_tools') {
                        this.available_tool_input = '';
                        list = this.available_tools;
                        for(let item of list) {
                            item.is_checked === true ? this.available_tool_input += (this.available_tool_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'transport_types') {
                        this.transport_type_input = '';
                        list = this.transport_types;
                        for(let item of list) {
                            item.is_checked === true ? this.transport_type_input += (this.transport_type_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'green_waste_collection_methods') {
                        this.green_waste_collection_method_input = '';
                        list = this.green_waste_collection_methods;
                        for(let item of list) {
                            item.is_checked === true ? this.green_waste_collection_method_input += (this.green_waste_collection_method_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    }
                },
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e ,id) {
                    $("#" + id).val(e.target.files[0].name);
                }
            }
        });
    </script>
@endsection
