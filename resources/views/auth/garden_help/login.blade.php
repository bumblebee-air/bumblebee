@extends('templates.garden_help-auth') @section('title', 'GardenHelp')

@section('page-styles')
<link href="{{asset('css/gardenhelp-auth-styles.css')}}"
	rel="stylesheet">
<style>
</style>
<link
	href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap|Material+Icons"
	rel="stylesheet">

@endsection @section('page-content')
<div class="bg-cover h-100">
	<div class="row h-100 m-0">
		<div class="col-xl-5 col-lg-6 col-md-8 col-sm-12 mx-auto my-auto">
			<div class="container">
				<div class="card card-login">
					<div class="card-header text-center py-1">
						<img class="img-fluid loginIconImg"
							src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
							alt="GardenHelp Logo" >

					</div>
					<div class="card-body">
						<h6 class="loginH6">Welcome to Garden Help!</h6>
						<p class="mb-0">Please sign-in to your account to choose from our
							Extensive Range of Professional Landscaping Services</p>
						<form class="form-signin" method="POST" action="{{url('login')}}">
							{{ csrf_field() }}

							<div class="row">
								<div class="col">
									<div class="form-group ">
										<label for="email" class=" control-label"> Email </label> <input
											id="email" class="form-control" name="email" required
											autofocus>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group ">
										<label for="password" class=" control-label"> Password </label>
										<input type="password" id="password" name="password"
											class="form-control" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mt-1 mb-md-3 mb-0">
									<div class="form-check">
										<label class="form-check-label" for="remember-me"> <input
											type="checkbox" class="form-check-input" id="remember-me"
											name="remember"> Remember me <span class="form-check-sign"> <span
												class="check"></span>
										</span>
										</label>
									</div>
								</div>
								<div class="col-md-6 mt-2  mb-md-3 mb-0">
									<a id="forgetPasswordA"
										href="{{url('garden-help/password/reset')}}"
										class="float-md-right">Forget password?</a>
								</div>
							</div>

							<input type="hidden" name="guard" value="garden-help">
							<div class="d-flex justify-content-center align-content-center">
								<button class="btn btn-login" type="submit">Login</button>
							</div>
							<div
								class="d-flex justify-content-center align-content-center mt-3">
								<p class="loginP">
									New on our platform? <a
										href="{{url('garden-help/customers/registration')}}"> Create
										an account </a>
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
