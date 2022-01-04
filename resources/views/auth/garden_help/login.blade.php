@extends('templates.garden_help-auth') @section('title', 'GardenHelp')

@section('page-styles')
<style>
.loginH6 {
	font-family: Roboto;
	font-style: normal;
	font-weight: 500;
	font-size: 18px;
	line-height: 21px;
	/* identical to box height */
	color: #5E5873;
	text-transform: capitalize;
}

.bg-cover {
	background-image: url("../images/gardenhelp_icons/login-background.png");
}
input.form-control{
    background-color: transparent;
    box-shadow: none !important;
    border-bottom: 1px solid #979797;
    padding-left: 10px;
    padding-right: 10px;
}
</style>

@endsection @section('page-content')
<div class="bg-cover h-100">
	<div class="row h-100 m-0">
		<div class="col-lg-8 col-md-6 col-sm-8 mx-auto my-auto">
			<div class="container">
				<div class="card card-login">
					<div class="card-header text-center">
						 <img class="img-fluid"
							src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
							alt="GardenHelp Logo" style="height: 165px;">
						
					</div>
					<div class="card-body">
						<h6 class="loginH6">Welcome to Garden Help!</h6>
						<form class="form-signin" method="POST" action="{{url('login')}}">
							{{ csrf_field() }}

							<div class="bmd-form-group my-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <i class="material-icons">email</i>
										</span>
									</div>

									<input id="email" class="form-control" name="email"
										placeholder="Email" required autofocus>

								</div>
							</div>

							<div class="bmd-form-group my-4">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"> <i class="material-icons">lock_outline</i>
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
							<input type="hidden" name="guard" value="garden-help">
							<div class="d-flex justify-content-center align-content-center">
								<button class="btn btn-gardenhelp-green btn-login" type="submit">Login</button>
							</div>
							<div
								class="d-flex justify-content-center align-content-center mt-3">
								<p class="loginP">
									Dont have an account? <a
										href="{{url('garden-help/customers/registration')}}"> Sign up
										here </a>
								</p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
