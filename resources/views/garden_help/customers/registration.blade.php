@extends('templates.garden_help')

@section('title', 'GardenHelp | Customers Registration')

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
            padding-bottom: 35px;
            margin-bottom: 20px;
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
            margin-right: 10px;
        }
        .checked {
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

        /*.bootstrap-select>.dropdown-toggle.bs-placeholder {*/
        /*    color: white;*/
        /*}*/

        /*Map Caculater Style*/
        #panel {
            width: 200px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            float: right;
            margin: 10px;
        }

        #color-palette {
            clear: both;
        }

        .color-button {
            width: 14px;
            height: 14px;
            font-size: 0;
            margin: 2px;
            float: left;
            cursor: pointer;
        }

        #delete-button {
            margin-top: 5px;
        }

        .bootstrap-select .btn.dropdown-toggle.select-with-transition {
            background-image: none!important;
        }
    </style>
@endsection

@section('content')
    <div class="container" id="app">
        <form action="{{route('postCustomerRegistration', 'garden-help')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{csrf_field()}}
            <div class="main main-raised">
                <div class="h-100 row align-items-center">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}" width="50" alt="GardenHelp">
                    </div>
                </div>
                <div class="container">
                    <div class="section">
                        <h4 class="title">Customer Registration Form</h4>
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
{{--                                <label class="bmd-label-floating">Location</label>--}}
{{--                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>--}}
                                <select name="work_location" data-style="select-with-transition" class="form-control selectpicker" @change="changeLocation">
                                    <option disabled selected>Location</option>
                                    <option value="Limerick">Limerick</option>
                                    <option value="Drumcondra">Drumcondra</option>
                                    <option value="Dún Laoghaire">Dún Laoghaire</option>
                                    <option value="Smithfield">Smithfield</option>
                                    <option value="Clontarf">Clontarf</option>
                                    <option value="Blackrock">Blackrock</option>
                                    <option value="Glasnevin">Glasnevin</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                {{--                                <label class="bmd-label-floating">Location</label>--}}
                                {{--                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>--}}
                                <select name="type_of_work" data-style="select-with-transition" class="form-control selectpicker" v-model="type_of_work" @change="changeWorkType()">
                                    <option disabled selected>Type of work</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="type_of_work == 'Residential'">
                        <div class="col-md-12">
                            <h5 class="sub-title">Property Information</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contact through</label>
                                <div class="d-flex">
                                    <div class="contact-through d-flex pr-5" @click="changeContact('whatsapp')">
                                        <div id="check" :class="contact_through == 'whatsapp' ? 'my-check-box checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        Whatsapp
                                    </div>

                                    <div class="contact-through d-flex" @click="changeContact('sms')">
                                        <div id="check" :class="contact_through == 'sms' ? 'my-check-box checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        SMS
                                    </div>
                                    <input type="hidden" v-model="contact_through" name="contact_through">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Phone</label>
                                <input type="tel" class="form-control" name="phone" value="{{old('phone')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" value="{{old('password')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="type_of_work == 'Commercial'">
                        <div class="col-md-12">
                            <h5 class="sub-title">Business Details</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Business Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Company Email</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Contact through</label>
                                <div class="d-flex">
                                    <div class="contact-through d-flex pr-5" @click="changeContact('email')">
                                        <div id="check" :class="contact_through == 'email' ? 'my-check-box checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        Email
                                    </div>

                                    <div class="contact-through d-flex" @click="changeContact('phone')">
                                        <div id="check" :class="contact_through == 'phone' ? 'my-check-box checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        Phone Calls
                                    </div>
                                    <input type="hidden" v-model="contact_through" name="contact_through">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Contact Person Name</label>
                                <input type="text" class="form-control" name="contact_name" value="{{old('contact_name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label>Contact Person Number</label>
                                <input type="password" class="form-control" name="contact_number" value="{{old('contact_number')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="available_date_time">Select from the available date & time</label>
{{--                                <div class="d-flex justify-content-between">--}}
                                    <input name="available_date_time" type="text" class="form-control datetimepicker" id="available_date_time" {{old('available_date_time')}} required>
{{--                                    <a class="select-icon">--}}
{{--                                        <i class="fas fa-caret-down"></i>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main main-raised content-card" v-if="type_of_work == 'Residential'">
                <div class="container">
                    <div class="section">
                        <h5 class="sub-title">Services Details</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="type_of_experience">Service Type</label>
                                <div class="d-flex justify-content-between" @click="openModal('service_type')">
                                    <input name="service_types" type="text" class="form-control" id="service_type_input" v-model="service_types_input" {{old('service_details')}} required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main main-raised content-card" v-if="type_of_work == 'Residential'">
                <div class="container">
                    <div class="section">
                        <h5 class="sub-title">Property Information</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
{{--                                <label class="bmd-label-floating" for="location">Location</label>--}}
                                <input type="text" class="form-control" id="location" name="location" value="{{old('location')}}" required>
                                <input type="hidden" id="location_coordinates" name="location_coordinates">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <div id="area"></div>
                                <div id="map" style="height: 400px; margin-top: 0"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-file-upload form-file-multiple bmd-form-group">
                                <label class="bmd-label-static" for="photographs_of_property">
                                    Upload Photographs of Property
                                </label>
                                <br>
                                <input id="property_photo" name="property_photo" type="file" class="inputFileHidden" @change="onChangeFile($event, 'property_photo_input')">
                                <div class="input-group" @click="addFile('property_photo')">
                                    <input type="text" id="property_photo_input" class="form-control inputFileVisible" placeholder="Upload Photo" required>
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
                                <label>Property size</label>
                                <input type="text" class="form-control" id="property_size" name="property_size" value="{{old('property_size')}}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="vat-number">Is this the first time you do service for your property?</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios2" name="is_first_time" v-model="is_first_time" value="1" {{old('is_first_time') === '1' ? 'checked' : ''}} required>
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
                                                <input class="form-check-input" type="radio" id="exampleRadios1" name="is_first_time" v-model="is_first_time" value="0" {{old('is_first_time') === '0' ? 'checked' : ''}} @click="changeIsFirst()" required>
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

                        <div class="col-md-12" v-if="is_first_time != '' && is_first_time == 0">
                            <div class="form-group bmd-form-group">
                                <label for="type_of_experience">When was the last service?</label>
                                <div class="d-flex justify-content-between" @click="openModal('last_services')">
                                    <input name="last_services" type="text" class="form-control" id="last_services" {{old('last_services')}} required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" v-if="is_first_time != '' && is_first_time == 0">
                            <div class="form-group bmd-form-group">
                                <label for="type_of_experience">Site details</label>
                                <div class="d-flex justify-content-between" @click="openModal('site_details')">
                                    <input name="site_details" type="text" class="form-control" id="site_details" v-model="site_details_input" {{old('site_details')}} required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="vat-number">Is there a parking access on site?*</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios2" name="is_parking_site" v-model="is_parking_site" value="1" {{old('is_parking_site') === '1' ? 'checked' : ''}} required>
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
                                                <input class="form-check-input" type="radio" id="exampleRadios1" name="is_parking_site" v-model="is_parking_site" value="0" {{old('is_parking_site') === '0' ? 'checked' : ''}} required>
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
                    <button class="btn btn-success btn-block submit-btn" type="submit">Signup</button>
                </div>
            </div>
        </form>
        <a id="addOtherLocationBtn" data-toggle="modal"
           data-target="#addOtherLocationModal" style="display: none"></a>
        <!-- Modal -->
        <div class="modal fade" id="addOtherLocationModal" tabindex="-1" role="dialog"
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
                            <div class="col-md-12 d-flex justify-content-between">
                                <input type="text" class="form-control" placeholder="Add Other">
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

        <!-- Button trigger Site Details modal -->
        <a id="site_details_btn_modal" data-toggle="modal"
           data-target="#site_detailsModal" style="display: none"></a>

        <!-- Last Services Modal -->
        <div class="modal fade" id="site_detailsModal" tabindex="-1" role="dialog"
             aria-labelledby="type_of_experienceLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-left" id="type_of_experienceLabel">Site Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between" v-for="item in site_details"  @click="toggleCheckedValue(item)">
                                <label for="my-check-box" :class="item.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ item.title }}</label>
                                <div class="my-check-box" id="check">
                                    <i :class="item.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('site_details')">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
        <a id="service_type_btn_modal" data-toggle="modal"
           data-target="#service_typeModal" style="display: none"></a>

        <!-- Modal -->
        <div class="modal fade" id="service_typeModal" tabindex="-1" role="dialog"
             aria-labelledby="type_of_experienceLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-left" id="type_of_experienceLabel">Service Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between" v-for="type in service_types"  @click="toggleCheckedValue(type)">
                                <label for="my-check-box" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
                                <div class="my-check-box" id="check">
                                    <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                </div>
                            </div>
                            <div class="col-md-12" data-toggle="collapse" href="#otherServicesCollapse" role="button" aria-expanded="false" aria-controls="otherServicesCollapse">
                                <div class="d-flex justify-content-between">
                                    <h5 class="modal-title text-left" id="type_of_experienceLabel">Other Service</h5>
                                    <a class="select-icon" style="margin-top: 3px; color: black!important">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                                <br>
                            </div>
                            <div class="collapse" id="otherServicesCollapse" style="max-height: 300px; overflow: scroll; width: 100%;">
                                <div class="col-md-12 d-flex justify-content-between" v-for="type in other_service_types"  @click="toggleCheckedValue(type)">
                                    <label for="my-check-box" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
                                    <div class="my-check-box" id="check">
                                        <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('service_details')">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                type_of_work: '',
                service_types: [
                    {
                        title: 'Garden Maintenance',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Garden Maintenance') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Grass Cutting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Grass Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ],
                other_service_types: [
                    {
                        title: 'Landscaping/Garden Design',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Landscaping/Garden Design') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Tree Surgery/Stump Removal',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Tree Surgery/Stump Removal') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Fencing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Decking',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Decking') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Decking Repairs',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Decking Repairs') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Strimming',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Strimming') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Power Washing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Power Washing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Shed Repairs',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Shed Repairs') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Flat Pack Garden Furniture Assembly',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Flat Pack Garden Furniture Assembly') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Green Waste Removal',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Green Waste Removal') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Patio Installation',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Patio Installation') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Lawn Fertilization',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Lawn Fertilization') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Garden Painting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Garden Painting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Gutter VAC',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Gutter VAC') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Leaf blowing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Leaf blowing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Mulching',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Mulching') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Power Washing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Power Washing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Hedge Cutting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Hedge Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ],
                site_details: [
                    {
                        title: 'Pets',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Pets') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Underground Electrical Cable',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Underground Electrical Cable') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Over Ground Electrical Cable',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Over Ground Electrical Cable') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Water Mains',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Water Mains') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Gas Mains',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Gas Mains') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Metered Parking Area',
                        is_checked: JSON.parse("{{old('site_details') ? ( strpos(old('site_details'), 'Metered Parking Area') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ],
                is_first_time: '',
                is_parking_site: '',
                contact_through: '',
                service_types_input:'',
                site_details_input: '',
                property_photo_input: ''
            },
            mounted() {
                if (this.type_of_work == 'Commercial') {
                    $('#available_date_time').datetimepicker({
                        icons: {
                            time: "fa fa-clock",
                            date: "fa fa-calendar",
                            up: "fa fa-chevron-up",
                            down: "fa fa-chevron-down",
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                        }
                    });
                } else {
                    $('#last_services').datetimepicker({
                        icons: {
                            time: "fa fa-clock",
                            date: "fa fa-calendar",
                            up: "fa fa-chevron-up",
                            down: "fa fa-chevron-down",
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                        }
                    });
                }
            },
            methods: {
                changeLocation(e) {
                    if(e.target.value == 'Other') {
                        $('#addOtherLocationBtn').click();
                    }
                },
                openModal(type) {
                    $('#' + type + '_btn_modal').click();
                },
                changeSelectedValue(type) {
                    let input = '';
                    let list = '';
                    if (type === 'service_details') {
                        let service_types_input = '';
                        list = this.service_types;
                        for(let item of list) {
                            item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                        for(let item of this.other_service_types) {
                            item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                        this.service_types_input = service_types_input;
                    } else if (type === 'site_details') {
                        let site_details_input = '';
                        list = this.site_details;
                        for(let item of list) {
                            item.is_checked === true ? site_details_input += (site_details_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                        for(let item of this.other_service_types) {
                            item.is_checked === true ? site_details_input += (site_details_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                        this.site_details_input = site_details_input;
                    }
                },
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e ,id) {
                    $("#" + id).val(e.target.files[0].name);
                },
                changeContact(value) {
                    this.contact_through = value;
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                changeWorkType() {
                    if (this.type_of_work == 'Residential') {
                        setTimeout(() => {
                            window.initMap();
                            $('#last_services').datetimepicker({
                                icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                }
                            });
                        }, 500)
                    } else {
                        setTimeout(() => {
                            $('#available_date_time').datetimepicker({
                                icons: {
                                    time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
                                }
                            });
                        });
                    }
                },
                changeIsFirst() {
                    setTimeout(() => {
                        $('#last_services').datetimepicker({
                            icons: {
                                time: "fa fa-clock",
                                date: "fa fa-calendar",
                                up: "fa fa-chevron-up",
                                down: "fa fa-chevron-down",
                                previous: 'fa fa-chevron-left',
                                next: 'fa fa-chevron-right',
                                today: 'fa fa-screenshot',
                                clear: 'fa fa-trash',
                                close: 'fa fa-remove'
                            }
                        });
                    }, 500)
                }
            }
        });

        //Map Js
        window.initMap = function initMap() {
            //Map Initialization
            this.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668},
                disableDefaultUI: true
            });

            //Marker
            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/customer-address-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };

            let locationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position: {lat: 53.346324, lng: -6.258668}
            });

            locationMarker.setVisible(false)

            //Autocomplete Initialization
            let location_input = document.getElementById('location');
            let autocomplete_location = new google.maps.places.Autocomplete(location_input);
            autocomplete_location.setComponentRestrictions({'country': ['ie']});
            autocomplete_location.addListener('place_changed', () => {
                let place = autocomplete_location.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                    let place_lat = place.geometry.location.lat();
                    let place_lon = place.geometry.location.lng();

                    locationMarker.setPosition({lat: place_lat, lng: place_lon})
                    locationMarker.setVisible(true);

                    //Fit Bounds
                    let bounds = new google.maps.LatLngBounds();
                    bounds.extend({lat: place_lat, lng: place_lon})
                    this.map.fitBounds(bounds);

                    document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) +'}';
                }
            });

            //Map drawing
            var polyOptions = {
                strokeWeight: 0,
                fillOpacity: 0.45,
                editable: true
            };
            // Creates a drawing manager attached to the map that allows the user to draw
            // markers, lines, and shapes.
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                markerOptions: {
                    draggable: true
                },
                polylineOptions: {
                    editable: true
                },
                rectangleOptions: polyOptions,
                circleOptions: polyOptions,
                polygonOptions: polyOptions,
                map: this.map
            });

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
                if (e.type != google.maps.drawing.OverlayType.MARKER) {
                    // Switch back to non-drawing mode after drawing a shape.
                    drawingManager.setDrawingMode(null);

                    // Add an event listener that selects the newly-drawn shape when the user
                    // mouses down on it.
                    var newShape = e.overlay;
                    newShape.type = e.type;
                    google.maps.event.addListener(newShape, 'click', function() {
                        setSelection(newShape);
                    });
                    var area = google.maps.geometry.spherical.computeArea(newShape.getPath());
                    let property_size = $("#property_size");
                    property_size.val(area.toFixed(0) + ' Square Meters');
                    property_size.parent().addClass('is-filled');
                    setSelection(newShape);
                }
            });

            // Clear the current selection when the drawing mode is changed, or when the
            // map is clicked.
            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
            google.maps.event.addListener(map, 'click', clearSelection);
            // google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

            // buildColorPalette();

            //Add a custome control button
            let controlDiv = document.createElement("div");
            // Set CSS for the control border.
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "2px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Click to recenter the map";
            controlDiv.appendChild(controlUI);

            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "16px";
            controlText.style.lineHeight = "38px";
            controlText.style.paddingLeft = "5px";
            controlText.style.paddingRight = "5px";
            controlText.innerHTML = "Reset Area";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => deleteSelectedShape());

            this.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv)
        }

        var drawingManager;
        var selectedShape;
        var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
        var selectedColor;
        var colorButtons = {};

        function clearSelection() {
            if (selectedShape) {
                selectedShape.setEditable(false);
                selectedShape = null;
            }
        }

        function setSelection(shape) {
            clearSelection();
            selectedShape = shape;
            shape.setEditable(true);
            selectColor(shape.get('fillColor') || shape.get('strokeColor'));
            google.maps.event.addListener(shape.getPath(), 'set_at', calcar);
            google.maps.event.addListener(shape.getPath(), 'insert_at', calcar);
        }

        function calcar() {
            var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
            document.getElementById("area").innerHTML = "Area =" + area;
        }

        function deleteSelectedShape() {
            if (selectedShape) {
                selectedShape.setMap(null);
                let property_size = $("#property_size");
                property_size.val('');
                property_size.parent().removeClass('is-filled');
            }
        }

        function selectColor(color) {
            selectedColor = color;
            for (var i = 0; i < colors.length; ++i) {
                var currColor = colors[i];
                colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
            }

            // Retrieves the current options from the drawing manager and replaces the
            // stroke or fill color as appropriate.
            var polylineOptions = drawingManager.get('polylineOptions');
            polylineOptions.strokeColor = color;
            drawingManager.set('polylineOptions', polylineOptions);

            var rectangleOptions = drawingManager.get('rectangleOptions');
            rectangleOptions.fillColor = color;
            drawingManager.set('rectangleOptions', rectangleOptions);

            var circleOptions = drawingManager.get('circleOptions');
            circleOptions.fillColor = color;
            drawingManager.set('circleOptions', circleOptions);

            var polygonOptions = drawingManager.get('polygonOptions');
            polygonOptions.fillColor = color;
            drawingManager.set('polygonOptions', polygonOptions);
        }

        // function setSelectedShapeColor(color) {
        //     if (selectedShape) {
        //         if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
        //             selectedShape.set('strokeColor', color);
        //         } else {
        //             selectedShape.set('fillColor', color);
        //         }
        //     }
        // }

        // function makeColorButton(color) {
        //     var button = document.createElement('span');
        //     button.className = 'color-button';
        //     button.style.backgroundColor = color;
        //     google.maps.event.addDomListener(button, 'click', function() {
        //         selectColor(color);
        //         setSelectedShapeColor(color);
        //     });
        //
        //     return button;
        // }
        //
        // function buildColorPalette() {
        //     var colorPalette = document.getElementById('color-palette');
        //     for (var i = 0; i < colors.length; ++i) {
        //         var currColor = colors[i];
        //         var colorButton = makeColorButton(currColor);
        //         colorPalette.appendChild(colorButton);
        //         colorButtons[currColor] = colorButton;
        //     }
        //     selectColor(colors[0]);
        // }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>
@endsection
