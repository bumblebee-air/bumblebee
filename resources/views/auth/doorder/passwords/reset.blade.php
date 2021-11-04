@extends('templates.auth') @section('title', 'DoOrder')

@section('page-styles')
<style>
body, html {
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
	font-size: 16px !important;
	letter-spacing: 0.3px;
	color: #ccb13e !important;
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
		padding: 20px 200px;
	}
}

.form-check .form-check-input:checked ~.form-check-sign .check {
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

#forgetPasswordA {
	font-family: Quicksand;
	font-style: normal;
	font-weight: normal;
	font-size: 14px;
	line-height: 16px;
	letter-spacing: 0.244706px;
	color: #E8CA49;
}

.forgetPasswordH6 {
	font-family: Quicksand;
	font-style: normal;
	font-weight: normal;
	font-size: 16px;
	line-height: 20px;
	/* identical to box height */
	letter-spacing: 0.301176px;
	text-transform: capitalize;
	margin-bottom: 0;
	color: #656565
}
</style>

<link rel="stylesheet" type="text/css"
	href="https://fonts.googleapis.com/css?family=Quicksand" />
@endsection @section('page-content')
<div style="background: url({{asset('images/doorder-login-bg.jpg')}})"
	class="bg-cover h-100">
	<div class="row h-100 m-0">
		<div class="col-lg-8 col-md-10 col-sm-12 mx-auto my-auto">
			<div class="container">
				<div class="card card-login">
					<div class="card-header text-center">
						<a href="{{url('/')}}"><img class="img-fluid"
							src="{{asset('images/doorder-logo.png')}}" alt="DoOrder Logo"
							style="width: 180px; height: 110px;"></a>
						<h6 class="forgetPasswordH6">Reset your password</h6>
					</div>
					<div class="card-body">
						@if (session('status'))
						<div class="alert alert-success" role="alert">{{ session('status') }}</div>
						@endif
						<form class="form-signin" method="POST"
							action="{{ route('password.update') }}">
							{{ csrf_field() }} <input type="hidden" name="token"
								value="{{ $token }}">
							<div class="bmd-form-group mt-2 mb-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="color: #E8CA49;"> <i
											class="material-icons">email</i>
										</span>
									</div>
									<input id="email" name="email"
										placeholder="Enter your registered E-mail"
										class="form-control @error('email') is-invalid @enderror"
										type="email" value="{{ $email ?? old('email') }}" required
										autocomplete="email" autofocus> @error('email') <span
										class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
									</span> @enderror
								</div>
							</div>
							
							<div class="bmd-form-group mt-2 mb-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="color: #E8CA49;"> <i
											class="material-icons">lock_outline</i>
										</span>
									</div>
									<input id="password" name="password"
										placeholder="Enter new password"
										class="form-control @error('password') is-invalid @enderror"
										type="password"  required
										autocomplete="new-password" > @error('password') <span
										class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
									</span> @enderror
								</div>
							</div>
							
							<div class="bmd-form-group mt-2 mb-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="color: #E8CA49;"> <i
											class="material-icons">lock_outline</i>
										</span>
									</div>
									<input id="password-confirm" name="password_confirmation"
										placeholder="Re-enter new password"
										class="form-control"
										type="password"  required
										autocomplete="new-password" > 
								</div>
							</div>


							<input type="hidden" name="guard" value="doorder">
							<div class="d-flex justify-content-center align-content-center">
								<button class="btn btn-login" type="submit">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
