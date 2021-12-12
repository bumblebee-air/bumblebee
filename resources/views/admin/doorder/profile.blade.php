@extends('templates.doorder_dashboard') @section('page-styles')
@endsection @section('page-content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="card card-profile-page-title">
				<div class="card-header row">
					<div class="col-12  p-0">
						<h4 class="card-title my-md-4 mt-4 mb-1">Reset Password</h4>
					</div>

				</div>
			</div>
			<div class="card changePasswordDiv" id="dashboardCardDiv">
				<div class="card-body">
					<form
						action="{{url($client_url_prefix.'/profile/password-reset')}}"
						method="post">
						<div class="card-body">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group bmd-form-group">
										<label for="current-password">Current password</label> <input
											name="current_password" type="password" class="form-control"
											id="current-password" placeholder="Enter current password"
											required />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group bmd-form-group">
										<label for="new-password">New password</label> <input
											name="new_password" type="password" class="form-control"
											id="new-password" placeholder="Enter new password" required />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group bmd-form-group">
										<label for="confirm-password">Confirm password</label> <input
											name="confirm_password" type="password" class="form-control"
											id="confirm-password" placeholder="Enter confirm password"
											required />
									</div>
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
								<button type="submit"
									class="btnDoorder btn-doorder-primary  mb-1">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts') @endsection
