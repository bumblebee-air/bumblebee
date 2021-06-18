@extends('templates.auth')

@section('title', 'DoOrder')

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
            border-radius: 22px 0px;
            box-shadow: 0 12px 36px -12px rgba(76, 151, 161, 0.35);
            background-color: #e8ca49;
            width: 247px;
            height: 50px;
        }

        input {
            font-family: Quicksand;
            font-size: 16px!important;
            letter-spacing: 0.3px;
            color: #ccb13e!important;
        }
.form-control:focus{
	 border-color: #f7dc69 !important;
}
.form-control:focus, .is-focused .form-control{
background-image: linear-gradient(0deg,#f7dc69 2px,rgba(247,220,105,0) 0),linear-gradient(0deg,#d2d2d2 1px,hsla(0,0%,82%,0) 0)
}
        @media screen and (min-width: 900px) {
            .card-login {
                padding: 20px 200px;
            }
        }
        
        .form-check .form-check-input:checked~.form-check-sign .check{
            background: #e8ca49 !important;
        }
        
@media screen and (min-width: 1200px) {
	.card-login {
		padding: 20px 180px;
	}
}

@media screen and (min-width: 992px) and (max-width: 1199.5px) {
	.card-login {
		padding: 20px 100px;
	}
}
    </style>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand" />
@endsection
@section('page-content')
    <div style="background: url({{asset('images/doorder-login-bg.jpg')}})"
         class="bg-cover h-100">
        <div class="row h-100 m-0">
            <div class="col-lg-8 col-md-10 col-sm-12 mx-auto my-auto">
                <div class="container">
                    <div class="card card-login">
                        <div class="card-header text-center">
                            <a href="{{url('/')}}"><img class="img-fluid" src="{{asset('images/doorder-logo.png')}}"
                                                        alt="DoOrder Logo" style="width: 180px; height: 110px;"></a>
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
                                <input type="hidden" name="guard" value="doorder">
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
