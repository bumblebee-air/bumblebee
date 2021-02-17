@extends('templates.garden_help-auth')

@section('title', 'GardenHelp')

@section('page-styles')
    <style>
      
        
    </style>

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
								 <img class="img-fluid" src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}" 
								 alt="GardenHelp Logo" style=" height: 165px;">
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
                                    <button class="btn btn-gardenhelp-green btn-login"
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
