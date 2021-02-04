@extends('templates.auth')

@section('title', 'GardenHelp')

@section('page-styles')
    <style>
        body,html {
            height: 100%;
            font-family: Quicksand;
        }
        .bg-cover {
            background-size: cover !important;
        }
        .btn-text-shadow {
            text-shadow: 1px 1px 2px #000000;
        }
        .card-login {
            /*padding: 20px 200px;*/
            border-radius: 63px;
            border: solid 1px #979797;
            background-color: #ffffff;
        }

        .btn-login {
            border-radius: 24px;
            box-shadow: 0 12px 36px -12px rgba(76, 151, 161, 0.35);
            background-color: #60a244;
            width: 247px;
            height: 50px;
        }

        input {
            font-family: Quicksand;
            font-size: 16px!important;
            letter-spacing: 0.3px;
            color: #ccb13e!important;
        }

        @media screen and (min-width: 900px) {
            .card-login {
                padding: 20px 200px;
            }
        }
    </style>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand" />
@endsection
@section('page-content')
    <div style="background: url({{asset('images/gardenhelp_icons/login-background.png')}})"
         class="bg-cover h-100">
        <div class="row h-100 m-0">
            <div class="col-lg-8 col-md-6 col-sm-8 mx-auto my-auto">
                <div class="container">
                    <div class="card card-login">
                        <div class="card-header text-center">
                            <a href="{{url('/')}}">
{{--                                <img class="img-fluid" src="{{asset('images/gardenhelp_icons/Logo.png')}}" alt="DoOrder Logo" style=" height: 110px;">--}}
                                <img class="img-fluid" src="{{asset('images/gardenhelp_icons/New-Logo-02.png')}}" alt="DoOrder Logo" style=" height: 110px;">
                            </a>
                        </div>
                        <div class="card-body">
                            <form class="form-signin" method="POST" action="{{url('login')}}">
                                {{ csrf_field() }}

                                <div class="bmd-form-group my-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                        </div>
                                        <input id="email" class="form-control" name="email" placeholder="Email" required autofocus>
                                    </div>
                                </div>

                                <div class="bmd-form-group my-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                        </div>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                </div>

                                <div class="col-md-9 my-4">
                                    <div class="form-check">
                                        <label class="form-check-label" for="remember-me">
                                            <input type="checkbox" class="form-check-input" id="remember-me" name="remember">
                                            Remember me
                                            <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="guard" value="garden-help">
                                <div class="d-flex justify-content-center align-content-center">
                                    <button class="btn btn-login"
                                            type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
