@extends('templates.unified-auth') @section('title', 'Unified')

@section('page-styles')
<style>
body, html {
	height: 100%;
	font-family: 'Roboto', sans-serif;
}

.bg-cover {
	background-size: cover !important;
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
	background-color: #d58242;
	width: 247px;
	height: 50px;
	font-family: 'Roboto', sans-serif;
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 0.79;
	letter-spacing: 0.32px;
	text-align: center;
	color: #ffffff;
}

.btn-login:hover {
	background-color: #be7339;
}

input {
	font-family: 'Roboto', sans-serif;
	font-size: 16px !important;
	letter-spacing: 0.3px;
	color: #d58242 !important;
}

input::placeholder {
	font-family: 'Roboto', sans-serif;
	font-size: 16px !important;
	letter-spacing: 0.3px;
	color: #acb1c0 !important;
}

.form-control {
	border-bottom-color: #acb1c0
}

.form-control:focus, .is-focused .form-control {
	background-image: linear-gradient(0deg, #d58242 2px, rgba(156, 39, 176, 0)
		0), linear-gradient(0deg, #d2d2d2 1px, hsla(0, 0%, 82%, 0) 0);
}
.form-check .form-check-input:checked~.form-check-sign .check{
background: #d58242;
}
.input-group-text img {
	width: 20px
}

@media screen and (min-width: 900px) {
	.card-login {
		padding: 40px 100px;
	}
}
</style>

@endsection @section('page-content')
<div
	style="background: url({{ asset('images/unified/Background-Image.jpg')}})"
	class="bg-cover h-100">
	<div class="row h-100 m-0">
		<div class="col-lg-8 col-md-6 col-sm-8 mx-auto my-auto">
			<div class="container">
				<div class="card card-login">
					<div class="card-header text-center">
						<a href="{{url('/')}}"><img class="img-fluid"
							src="{{asset('images/unified/Logo.png')}}" alt="Unified Logo"
							style="width: 300px; height: 110px;"></a>
					</div>
					<div class="card-body">
						<form class="form-signin" method="POST" action="{{url('login')}}">
							{{ csrf_field() }}


							<div class="bmd-form-group my-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <img
											src="{{asset('images/unified/Email.png')}}" />
										</span>
									</div>

									<input id="email" class="form-control" name="email"
										placeholder="Email" required autofocus autocomplete="off">

								</div>
							</div>

							<div class="bmd-form-group my-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <img
											src="{{asset('images/unified/Password.png')}}" />
										</span>
									</div>
									<input type="password" id="password" name="password"
										class="form-control" placeholder="Password" required>
								</div>
							</div>

							<div class="col-md-9 my-4">
								<div class="form-check">
									<label class="form-check-label" for="remember-me"> <input
										type="checkbox" class="form-check-input" id="remember-me"
										name="remember"> Remember me <span class="form-check-sign"> <span
											class="check"></span>
									</span>
									</label>
								</div>
							</div>


							<input type="hidden" name="guard" value="unified">
							<div class="d-flex justify-content-center align-content-center">
								<button class="btn btn-login" type="submit">Login</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
