@extends('templates.dashboard') @section('page-styles') @endsection
@section('page-content')
<div class="content">
	<div class="container">
		<div class="row">
			<div class="card changePasswordDiv" id="dashboardCardDiv">
				<div class="card-header card-header-icon  row">
					<div class="col-md-12">
						<div class="card-icon">
							<img class="page_icon"
								src="{{asset('images/doorder_icons/settings.png')}}"
								alt="Profile icon">
						</div>
						<h4 class="card-title ">Reset Password</h4>
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
												id="current-password" required />
										</div></div>
									</div>
									<div class="row">
										<div class="col-md-6">
										<div class="form-group bmd-form-group">
											<label for="new-password">New password</label> <input
												name="new_password" type="password" class="form-control"
												id="new-password" required />
										</div></div>
									</div>
									<div class="row">
										<div class="col-md-6">
										<div class="form-group bmd-form-group">
											<label for="confirm-password">Confirm password</label> <input
												name="confirm_password" type="password" class="form-control"
												id="confirm-password" required />
										</div></div>
									</div>
								</div>
								<div class="card-btns" style="text-align: center">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts') @endsection
