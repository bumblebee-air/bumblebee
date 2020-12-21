@extends('templates.doorder')

@section('title', 'Driver Registration')

@section('styles')
    <style>
        body {
            font-family: Quicksand;
        }
        .doorder-logo {
            width: 85px;
            padding-top: 30px;
        }

        .page-title-section {
            text-align: center;
            padding-top: 10px;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.19;
            letter-spacing: 0.1px;
            color: #e5c538;
        }

        input.form-control {
            padding: 11px 14px 11px 14px;
            border-radius: 10px;
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

        .my-check-box {
            width: 15px;
            height: 15px;
            color: #c3c7d2;
            padding-right: 20px;
        }

        .upload-file-card {
            padding: 13px 25px 20px 24px;
            border-radius: 10px;
            box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
            margin-bottom: 5px;
        }

        .upload-file-title {
            font-size: 14px;
            line-height: 1.36;
            letter-spacing: 1px;
            color: #000000;
        }

        .upload-file-subtitle {
            font-size: 11px;
            line-height: 1.09;
            letter-spacing: 0.79px;
            color: #000000;
        }

        .btn-white {
            background-color: red;
            box-shadow: 2px 2px 5px 0 #ffffff, 0 2px 4px 0 rgba(182, 182, 182, 0.5);
        }

        .btn-round {
            border-radius: 50%;
            width: 46px;
            height: 46px;
            text-align: center;
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

        .my-check-box-checked {
            color: #f7dc69;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
@endsection

@section('content')
    <div class="container" id="app">
        <form action="{{route('postDriverRegistration', ['client_name' => 'doorder'])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="main main-raised">
                <div class="h-100 row align-items-center">
                    <div class="col-md-12 text-center">
                        <img class="doorder-logo" src="{{asset('images/doorder-logo.png')}}" alt="DoOrder">
                    </div>
                </div>
                <form action="">
                    <div class="container">
                        <div class="page-title-section">
                            <h4 class="title">
                                Apply now to become part of
                                <br>
                                the DoOrder team
                            </h4>
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
                            <div class="col-md-12 d-flex form-head pl-3">
                                <span>
                                    1
                                </span>
                                A bit About You
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Email Address</label>
                                    <input type="text" class="form-control" name="email" value="{{old('email')}}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{old('phone_number')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Contact through</label>
                                    <div class="d-flex">
                                        <div class="contact-through d-flex pr-5" @click="changeContact('whatsapp')">
                                            <div id="check" :class="contact == 'whatsapp' ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                                <i class="fas fa-check-square"></i>
                                            </div>
                                            Whatsapp
                                        </div>

                                        <div class="contact-through d-flex" @click="changeContact('sms')">
                                            <div id="check" :class="contact == 'sms' ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                                <i class="fas fa-check-square"></i>
                                            </div>
                                            SMS
                                        </div>
                                        <input type="hidden" v-model="contact" name="contact_through">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Date of Birth</label>
                                    <input type="date" class="form-control" name="birthdate" value="{{old('birthdate')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{old('address')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">PPS Number</label>
                                    <input type="text" class="form-control" name="pps_number" value="{{old('pps_number')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Emergency Contact Name</label>
                                    <input type="text" class="form-control" name="emergency_contact_name" value="{{old('emergency_contact_name')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Emergency Contact Number</label>
                                    <input type="text" class="form-control" name="emergency_contact_number" value="{{old('emergency_contact_number')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Transport Type</label>
    {{--                                <input type="text" class="form-control" name="pps_number" value="{{old('pps_number')}}" required>--}}
                                    <select name="transport_type" class="form-control">
                                        <option selected disabled>Choose Transportation</option>
                                        <option value="car">Car</option>
                                        <option value="scooter">Scooter</option>
                                        <option value="van">Van</option>
                                        <option value="bicycle">Bicycle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Max package size</label>
    {{--                                <input type="text" class="form-control" name="emergency_contact_name" value="{{old('emergency_contact_name')}}" required>--}}
                                    <select name="max_package_size" class="form-control">
                                        <option selected disabled>Choose Max Package Weight</option>
                                        <option value="Very Light">Very Light</option>
                                        <option value="Light">Light</option>
                                        <option value="Medium Weight">Medium Weight</option>
                                        <option value="Very Heavy">Very Heavy</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Work Location</label>
    {{--                                <input type="text" class="form-control" name="emergency_contact_name" value="{{old('emergency_contact_name')}}" required>--}}
                                    <select name="work_location" class="form-control" required>
                                        <option selected disabled>Select Area</option>
                                        <option value="dublin">Dublin</option>
                                    </select>
                                </div>
                            </div>
    {{--                        <div class="col-sm-6 col-md-12">--}}
    {{--                            <div class="form-group pl-2">--}}
    {{--                                <div class="contact-through d-flex">--}}
    {{--                                    <div id="check" class="my-check-box">--}}
    {{--                                        <i class="fas fa-check-square"></i>--}}
    {{--                                    </div>--}}
    {{--                                    I want to have a radius from my address--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
                        </div>
                    </div>

                    <div class="container">
                        <div class="row pl-3">
                            <div class="col-md-12 d-flex form-head">
                                <span>
                                    2
                                </span>
                                Uploads and Verifications
                            </div>
                            <p class="pl-4 pt-0">Please upload the following:</p>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Evidence you can legally work in Ireland</p>
                                    <p class="upload-file-subtitle">
                                        (Work permit or Passport/National Identity Card
                                        issued by a state that is part of the EEA)
                                    </p>
                                </div>
                                <div class="col-md-12">
    {{--                                <div class="d-flex">--}}
    {{--                                    <p style="font-size: 14px;--}}
    {{--                                              font-weight: normal;--}}
    {{--                                              font-stretch: normal;--}}
    {{--                                              font-style: normal;--}}
    {{--                                              line-height: normal;--}}
    {{--                                              letter-spacing: 0.26px;--}}
    {{--                                              color: #4d4d4d;--}}
    {{--                                            ">Upload file</p>--}}
    {{--                                    <div class="btn btn-white btn-round ml-4">--}}
    {{--                                        <i class="fas fa-cloud-upload-alt" style="font-size: 20px"></i>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
                                    <input type="file" name="proof_id" required>
                                </div>
                            </div>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Driving License <small>(unless using a bicycle)</small></p>
                                    <p class="upload-file-subtitle">
                                        Please make sure the photo is clear and expiry
                                        date is visible
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="proof_driving_license">
                                </div>
                            </div>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Proof of Insurance <small>(unless using a bicycle)</small></p>
    {{--                                <p class="upload-file-subtitle">--}}
    {{--                                    Please make sure the photo is clear and expiry--}}
    {{--                                    date is visible--}}
    {{--                                </p>--}}
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-through d-flex pr-5" @click="changeHasInsurace">
                                        <div id="check" :class="hasInsurance ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        I have business insurance
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3" v-if="hasInsurance">
                                    <input type="file" name="proof_insurance" required>
                                </div>
                            </div>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Proof of Address</p>
                                    <p class="upload-file-subtitle">
                                        (bank statement, utility bill, driving licence)
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="proof_address" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 terms-container">
                                By clicking ‘Submit’, I hereby acknowledge and agree that I have read and understood
                                <a href="#" style="color: #e8ca49">DoOrder Privacy Policy</a>. DoOrder use cookies to personalise your experience. For our full
                                <a href="#" style="color: #e8ca49">Cookies Policy</a>.
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-block btn-submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    contact: '',
                    hasInsurance: false
                }
            },
            methods: {
                changeContact(contact) {
                    this.contact = contact;
                },
                changeHasInsurace() {
                    this.hasInsurance = !this.hasInsurance;
                }
            }
        });
    </script>
@endsection
