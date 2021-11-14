
<form method="POST"
	action="{{route('doorder_postSaveGeneralSettings', 'doorder')}}"
	method="POST" id="save_stripe_settings_form"  enctype="multipart/form-data">
	{{csrf_field()}}

	<div class="card">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label for="business_name">Business name </label><input
								type="text" class="form-control" name="business_name"
								id="business_name" placeholder="Business name" >
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label for="business_email">Business email </label><input
								type="email" class="form-control" name="business_email"
								id="business_email" placeholder="Business email" >
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label for="business_phone_number">Business phone number </label><input
								type="text" class="form-control" name="business_phone_number"
								id="business_phone_number" placeholder="Business phone number"
								>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label>Country</label> <select class="form-control selectpicker"
								data-style="select-with-transition" id="countrySelect"
								name="country">
								<option value="" selected disabled>Select country</option>
								<option value="Ireland">Ireland</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label>Language</label> <select class="form-control selectpicker"
								data-style="select-with-transition" id="languageSelect"
								name="language">
								<option value="" selected disabled>Select language</option>
								<option value="English">English</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label>Time zone</label> <select
								class="form-control selectpicker"
								data-style="select-with-transition" id="timeZoneSelect"
								name="time_zone">
								<option value="" selected disabled>Select time zone</option>
								<option value="GMT+1">(GMT+1)</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label>Upload logo</label> <input id="logo_input"
								name="logo_input" type="file" class="inputFileHidden"
								onchange="onChangeFile(event, 'logo_input_text')">
							<div class="input-group" onclick="addFile('logo_input')">
								<input type="text" id="logo_input_text"
									class="form-control inputFileVisible"
									placeholder="Upload logo" > <span
									class="input-group-btn">
									<button type="button" id="uploadButton" class="btn btn-fab btn-round btn-light">
										<img src="{{asset('images/doorder_icons/upload-icon.png')}}"
											alt="upload icon" />
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3">
						<h5 class="singleViewSubTitleH5" style="font-weight: 500">Deliverers
							Settings</h5>

					</div>
				</div>
				<div class="row">

					<div class="col-sm-6">
						<div class="form-group bmd-form-group ">
							<label style="font-weight: 700">Deliverers accept orders
								automatically </label>
						</div>

					</div>
					<div class="col-sm-6 text-right">
						<div class="toggleButtonGeneralSettings"
							style="display: inline-block;">
							<input type="checkbox" data-toggle="toggle" data-size="small"
								data-width="80" data-height="30"
								id="driversAcceptsOrdersAutomatic" value="1"
								name="driversAcceptsOrdersAutomatic">
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-sm-3">
						<div class="form-group bmd-form-group ">
							<label style="font-weight: 700">Set Time to finish shift </label>
							<input class="form-control" type="number" min="1" value="{{ $general_setting->driversTimeEndShift }}" name="driversTimeEndShift">

						</div>

					</div>
					
				</div>

			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3">
						<h5 class="singleViewSubTitleH5" style="font-weight: 500">Retailers
							Settings</h5>

					</div>
				</div>
				<div class="row">

					<div class="col-sm-6">
						<div class="form-group bmd-form-group ">
							<label style="font-weight: 700">Retailers automatic rating SMS </label>
						</div>

					</div>
					<div class="col-sm-6 text-right">
						<div class="toggleButtonGeneralSettings"
							style="display: inline-block;">
							<input type="checkbox" data-toggle="toggle" data-size="small"
								data-width="80" data-height="30"
								id="retailersAutomaticRatingSMS" value="1"
								name="retailersAutomaticRatingSMS" @if($general_setting->retailers_automatic_rating_sms)checked="true"@endif>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="row ">
		<div class="col text-center">


			<button class="btn bt-submit">Save</button>

		</div>
	</div>
</form>
