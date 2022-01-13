@extends('templates.garden_help-auth') @section('title', 'GardenHelp')

@section('page-styles')
<link href="{{asset('css/gardenhelp-auth-styles.css')}}"
	rel="stylesheet">
<style>
</style>
<link
	href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap|Material+Icons"
	rel="stylesheet">
<style></style>

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

						<h6>Reset your password</h6>
						<p>Enter your new password to log in to your account now.</p>

						@if (session('status'))
						<div class="alert alert-success" role="alert">{{ session('status')
							}}</div>
						@endif
						<form class="form-signin" method="POST"
							action="{{ route('password.update') }}">
							{{ csrf_field() }} <input type="hidden" name="token"
								value="{{ $token }}"> <input type="hidden" name="email"
								value="{{ $email ?? old('email') }}" />

							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="password" class="control-label"> New password </label>
										<input type="password" id="password" name="password"
											class="form-control @error('password') is-invalid @enderror"
											required autocomplete="new-password">@error('password') <span
											class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong>
										</span> @enderror
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label for="password-confirm" class="control-label"> Re-enter
											new password </label> <input type="password"
											id="password-confirm" name="password_confirmation"
											class="form-control" required autocomplete="new-password">
									</div>
								</div>
							</div>

							<input type="hidden" name="guard" value="garden-help">
							<div class="d-flex justify-content-center align-content-center mt-3">
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
