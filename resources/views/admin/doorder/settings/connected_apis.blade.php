

<form method="POST"
	action="{{route('doorder_postSaveStripeApi', 'doorder')}}"
	method="POST" id="save_stripe_settings_form">
	{{csrf_field()}}
	<div class="card">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3">
						<h5 class="singleViewSubTitleH5">Stripe</h5>

					</div>

				</div>
				<div class="row">

					<div class="col-sm-6">
						<div class="form-group bmd-form-group ">
							<label>Retailer automatic charging </label>
							<div class="togglebutton toggleButtonConnectedApi"
								style="display: inline-block;">
								<label> <input type="checkbox" id="retailerAutomaticCharging"
									value="1" name="retailerAutomaticCharging" {{count($client_setting->where('name', 'day_of_retailer_charging')) > 0 ? 'checked':''}}
									onclick="changeToggleRetAutoCharging()"> <span class="toggle"></span>
								</label>
							</div>
						</div>

					</div>
				</div>

				<div class="row" id="dayOfMonthDiv" style="display: {{count($client_setting->where('name', 'day_of_retailer_charging')) > 0 ? 'block':'none'}}">

					<div class="col-sm-6">
						<div class=" ">
							<label class="control-label" for="dayOfMonth">Day of month </label><select
								class="form-control " data-style="select-with-transition"
								name="dayOfMonth" id="dayOfMonth">
								<option value="">Select day</option> @for ($i = 1; $i <= 31;
								$i++)
								<option value="{{$i}}" {{count($client_setting->where('name', 'day_of_retailer_charging')) > 0  && $client_setting->where('name', 'day_of_retailer_charging')->first()['the_value'] == $i? 'selected':''}}>{{$i}}</option> @endfor
							</select>
						</div>
					</div>
				</div>

				<div class="row mt-2">

					<div class="col-sm-6">
						<div class="form-group bmd-form-group ">
							<label>Deliverer automatic payout </label>
							<div class="togglebutton toggleButtonConnectedApi"
								style="display: inline-block;">
								<label> <input type="checkbox" id="delivererPayout" value="1" {{ count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 ? 'checked' : ''}}
									name="delivererPayout" onclick="changeToggleDelivererPayout()">
									<span class="toggle"></span>
								</label>
							</div>
						</div>

					</div>
				</div>

				<div class="row" id="dayOfWeekDiv" style="display: {{ count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 ? 'block' : 'none'}}">

					<div class="col-sm-6">
						<div class=" ">
							<label class="control-label" for="weekday">Weekday </label>
							<select class="form-control " data-style="select-with-transition"
								name="weekday" id="weekday">
								<option value="">Select day</option>
								<option value="Mon" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 && \Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Mon' ? 'selected' : ''}}>Monday</option>
								<option value="Tue" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 &&\Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Tue' ? 'selected' : ''}}>Tuesday</option>
								<option value="Wed" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 &&\Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Wed' ? 'selected' : ''}}>Wednesday</option>
								<option value="Thu" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 &&\Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Thu' ? 'selected' : ''}}>Thursday</option>
								<option value="Fri" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 &&\Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Fri' ? 'selected' : ''}}>Friday</option>
								<option value="Sat" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 &&\Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Sat' ? 'selected' : ''}}>Saturday</option>
								<option value="Sun" {{count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 &&\Carbon\Carbon::parse($client_setting->where('name', 'day_time_of_driver_charging')->first()['the_value'])->format('D') == 'Sun' ? 'selected' : ''}}>Sunday</option>
							</select>
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
