<div class="card">
	<div class="card-body">
		<div class="container " style="width: 100%; max-width: 100%;">
			<div class="row ">
				<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3"></div>
				<div class="col-12 col-lg-5 col-md-6 mt-md-2 mb-2">
					<div class="row justify-content-end float-sm-right">

						<button type="button"
							class="btn-doorder-filter btn-doorder-add-item mt-0"
							@click="clickAddUser()">Add New User</button>

					</div>
				</div>
			</div>

			<div class="table-responsive">
				<table id="usersTable"
					class="table table-no-bordered table-hover doorderTable "
					width="100%" style="width: 100%">
					<thead>
						<tr class="">
							<th >User</th>
							<th >Last Activity</th>
							<th >User Type</th>
							<th class="disabled-sorting text-center">Actions</th>
						</tr>
					</thead>

					<tbody>
						<tr v-for="user in users" v-if="users.length > 0"
							class="order-row">
							<td>
								<p class="invoiceServiceP">@{{ user.name}}</p>
								<p class="invoiceDateSpan">@{{user.email}}</p>
							</td>
							<td> @{{ user.last_activity}}</td>
							<td>@{{ user.user_type }}</td>

							<td class="actionsTd"><button type="button" class="edit"
									@click="clickEditUser(user.id,user.name,user.email,user.user_role)">
									<img src="{{asset('images/doorder-new-layout/edit-icon.png')}}">
								</button>
								<button type="button" class="remove"
									@click="clickDeleteUser(user.id)">

									<img
										src="{{asset('images/doorder-new-layout/delete-icon.png')}}">
								</button></td>
						</tr>


						<tr v-else>
							<td colspan="4" class="text-center"><strong>No data found.</strong>
							</td>
						</tr>


					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- delete user modal -->
<div class="modal fade" id="delete-user-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-user-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
					want to delete this account?</div>
				<div>
					<form method="POST" id="delete-user"
						action="{{url('doorder/user/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="userId" name="userId" value="" />
					</form>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#delete-user').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end delete user modal -->

<!-- add user modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog"
	aria-labelledby="add-user-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addUserModalHeader">Add User</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="add-user"
				action="{{url('doorder/user/save')}}"
				style="margin-bottom: 0 !important;">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="user_name">Name </label> <input type="text"
									class="form-control" name="user_name" id="user_name"
									placeholder="Name" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="email">Email </label> <input type="text"
									class="form-control" name="email" id="email"
									placeholder="Email" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Role</label> <select
									class="form-control form-control-select selectpicker"
									data-style="select-with-transition" id="userTypeSelect"
									name="user_type" required="required">
									<option value="" selected disabled>Select role</option>
									<option value="admin">Admin</option>
									<option value="driver_manager">Driver manager</option>
									<option value="investor">Investor</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button class="btnDoorder btn-doorder-primary mb-1"
							type="submit" id="addUserBtn">Add User</button>
					</div>

					<!-- 				<div class="col-sm-6"> -->
					<!-- 					<button type="button" -->
					<!-- 						class="btn btn-danger doorder-btn-lg doorder-btn" -->
					<!-- 						data-dismiss="modal">Cancel</button> -->
					<!-- 				</div> -->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end add user modal -->

<!-- edit user modal -->
<div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog"
	aria-labelledby="edit-user-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addUserModalHeader">Edit User</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="add-user"
				action="{{url('doorder/user/edit')}}"
				style="margin-bottom: 0 !important;">
				@csrf <input type="hidden" name="userId" id="userId" />
				<div class="modal-body">
					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="user_name">Name </label> <input type="text"
									class="form-control" name="user_name" id="user_nameEdit"
									placeholder="Name" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label for="email">Email </label> <input type="text"
									class="form-control" name="email" id="emailEdit"
									placeholder="Email" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Role</label> <select
									class="form-control form-control-select selectpicker"
									data-style="select-with-transition" id="userTypeSelectEdit"
									name="user_type" required="required">
									<option value="" disabled>Select role</option>
									<option value="admin">Admin</option>
									<option value="driver_manager">Driver manager</option>
									<option value="investor">Investor</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6 text-center">
						<button class="btnDoorder btn-doorder-primary mb-1"
							type="submit" id="editUserBtn">Edit User</button>
					</div>

					<!-- 				<div class="col-sm-6"> -->
					<!-- 					<button type="button" -->
					<!-- 						class="btn btn-danger doorder-btn-lg doorder-btn" -->
					<!-- 						data-dismiss="modal">Cancel</button> -->
					<!-- 				</div> -->
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end add user modal -->