@extends('templates.auth') @section('title', 'DoOrder')

@section('page-styles')
<style>
body, html {
	height: 100vh;
	font-family: 'Montserrat', sans-serif;
}

.bg-cover {
	background-size: cover !important;
}

.btn-text-shadow {
	text-shadow: 1px 1px 2px #000000;
}

.card-login {
	/*padding: 20px 200px;*/
	box-shadow: 0px 0px 40px rgba(239, 240, 241, 0.7);
	border-radius: 20px;
	background-color: #ffffff;
}

.btn-login {
	border-radius: 8px;
	box-shadow: 0 12px 36px -12px rgba(76, 151, 161, 0.35);
	background-color: #e8ca49;
	width: 190px;
	height: 50px;
	font-style: normal;
	font-weight: bold;
	font-size: 16px;
	line-height: 20px;
	text-align: center;
	color: #FFFFFF;
	text-transform: capitalize;
}


.control-label {
	font-family: Montserrat;
	font-style: normal;
	font-weight: bold;
	font-size: 14px;
	line-height: 17px;
	color: #181C32;
}
input {
	font-family: 'Montserrat', sans-serif;
	font-size: 14px !important;
	font-weight: 400;
	letter-spacing: 0.3px;
	color: #6E6B7B !important;
	background-color: #F5F8FA !important;
}

.card-login input.form-control {
	border-color: transparent !important;
}

.form-control:focus {
	border-color: #f7dc69 !important;
}

.form-control:focus, .is-focused .form-control {
	background-image: linear-gradient(0deg, #f7dc69 2px, rgba(247, 220, 105, 0)
		0), linear-gradient(0deg, #d2d2d2 1px, hsla(0, 0%, 82%, 0) 0)
}

@media screen and (min-width: 900px) {
	.card-login {
		padding: 20px;
	}
}

.form-check .form-check-input:checked ~.form-check-sign .check {
	background: #e8ca49 !important;
	border: 1px solid #e8ca49 !important;
}
.form-check .form-check-sign .check {
	background: #ebebec !important;
	border: none;
}

@media screen and (min-width: 1200px) {
	.card-login {
		padding: 20px ;
	}
}

@media screen and (min-width: 992px) and (max-width: 1199.5px) {
	.card-login {
		padding: 20px 10px;
	}
}

#forgetPasswordA {
	font-family: 'Montserrat', sans-serif;
	font-style: normal;
	font-weight: normal;
	font-size: 14px;
	line-height: 21px;
	letter-spacing: -0.02em;
	color: #E9C218;
}

.card-login h6 {
	font-family: 'Montserrat', sans-serif;
	font-style: normal;
	font-weight: 500;
	font-size: 18px;
	line-height: 22px;
	color: #5E5873;
	text-transform: capitalize;
}

.card-login p {
	font-family: 'Montserrat', sans-serif;;
	font-style: normal;
	font-weight: normal;
	font-size: 14px;
	line-height: 21px;
	color: #6E6B7B;
}
.card-login p a{
    color: #E9C218;
}

.form-check-label {
	font-family: 'Montserrat', sans-serif; font-style : normal;
	font-weight: normal;
	font-size: 14px;
	line-height: 21px;
	color: #3F4254;
	font-style: normal;
}

#containerPageBackgrundDiv {
    background-image: url("{{asset('images/doorder-new-layout/doorder-login-background.png')}}");
	background-position: center; /* Center the image */
	background-repeat: no-repeat; /* Do not repeat the image */
	background-size: cover;
}

@media only screen and (max-height: 550px) and (orientation: landscape) {
 .h-100{
    height: auto !important;
 }
}
</style>

<link
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
	rel="stylesheet">
	
@endsection @section('page-content')
<div class="h-100">
	<div class="row h-100 m-0">
		<div class="col-xl-4 col-lg-8 col-md-10 col-sm-12 mx-auto my-auto">
			<div class="container">
				<div class="card card-login">
					<div class="card-header text-center">
						<a href="{{url('/')}}"><img class="img-fluid"
							src="{{asset('images/doorder-new-layout/Logo.png')}}" alt="DoOrder Logo"
							style="width: 160px;"></a>
						
					</div>
					<div class="card-body">
						<h6>Reset password</h6>
						<p>Please enter your registered email to send you a link to reset your password </p>
						
						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}</div>
						@endif
						
						<form class="form-signin" method="POST"
							action="{{ route('password.email') }}">
							{{ csrf_field() }}
							
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="email" class="control-label"> Email </label> <input
											id="email" class="form-control" name="email" required
											autofocus>
											
									@error('email') <span class="invalid-feedback" role="alert"> <strong>{{
											$message }}</strong>
									</span> @enderror
									</div>
								</div>
							</div>

							<input type="hidden" name="guard" value="doorder">
							<div class="d-flex justify-content-center align-content-center mt-3">
								<button class="btn btn-login" type="submit">Send E-mail</button>
							</div>
							<div class="d-flex justify-content-center align-content-center mt-3">
								<p> Remember your password? <a href="{{url('doorder/login')}}">Log in</a> </p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
