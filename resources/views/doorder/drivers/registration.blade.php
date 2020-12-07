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
    </style>
@endsection

@section('content')
    <div class="container" id="app">
        <form action="">
            <div class="main main-raised">
                <div class="h-100 row align-items-center">
                    <div class="col-md-12 text-center">
                        <img class="doorder-logo" src="{{asset('images/doorder-logo.png')}}" alt="DoOrder">
                    </div>
                </div>
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
                        <div class="col-md-12 d-flex form-head">
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
                                    <div class="contact-through d-flex pr-5">
                                        <div id="check" class="my-check-box">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        Whatsapp
                                    </div>

                                    <div class="contact-through d-flex">
                                        <div id="check" class="my-check-box">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        SMS
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-form-group">Date of Birth</label>
                                <input type="text" class="form-control" name="birthdate" value="{{old('birthdate')}}" required>
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
                                <label class="bmd-form-group">Postcode/Eircode</label>
                                <input type="text" class="form-control" name="birthdate" value="{{old('birthdate')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-form-group">Address</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
