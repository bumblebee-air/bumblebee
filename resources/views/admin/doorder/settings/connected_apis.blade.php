

<form method="POST"
	action="{{route('doorder_postSaveStripeApi', 'doorder')}}"
	method="POST" id="save_stripe_settings_form">
	{{csrf_field()}}
	<div class="card">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3">
						<h5 class="locationLabel card-title">Stripe</h5>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-sm-12">
						<div class="form-group bmd-form-group p-0" style="display: inline-block;">
							<label>Retailer automatic charging </label>
						</div>

						<div class="toggleButtonGeneralSettings ml-2"
							style="display: inline-block;">
							 <input type="checkbox" data-toggle="toggle" data-size="small"
								data-width="80" data-height="30" id="retailerAutomaticCharging" 
								value="1" name="retailerAutomaticCharging" 
								{{count($client_setting->where('name',
								'day_of_retailer_charging')) > 0 ? 'checked':''}}
								onclick="changeToggleRetAutoCharging()">
							
						</div>
					</div>
				</div>
				<div class="row" id="dayOfMonthDiv" style="display: {{count($client_setting->where('name', 'day_of_retailer_charging')) > 0 ? 'block':'none'}}">

					<div class="col-sm-6">
						<div class=" form-group bmd-form-group">
							<label class="" for="dayOfMonth">Day of month </label><select
								class="form-control form-control-select selectpicker" data-style="select-with-transition"
								name="dayOfMonth" id="dayOfMonth">
								<option value="">Select day</option> @for ($i = 1; $i <= 31;
								$i++)
								<option value="{{$i}}" {{count($client_setting->where('name', 'day_of_retailer_charging')) > 0  && $client_setting->where('name', 'day_of_retailer_charging')->first()['the_value'] == $i? 'selected':''}}>{{$i}}</option> @endfor
							</select>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-sm-12">
						<div class="form-group bmd-form-group p-0" style="display: inline-block;">
							<label>Deliverer automatic payout </label></div>
							
							<div class="toggleButtonGeneralSettings ml-2"
								style="display: inline-block;">
								 <input type="checkbox" id="delivererPayout" value="1" 
								 data-toggle="toggle" data-size="small"
								data-width="80" data-height="30" 
								 {{ count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 ? 'checked' : ''}}
									name="delivererPayout" onclick="changeToggleDelivererPayout()">
								
							</div>
						

					</div>
				</div>

				<div class="row" id="dayOfWeekDiv" style="display: {{ count($client_setting->where('name', 'day_time_of_driver_charging')) > 0 ? 'block' : 'none'}}">

					<div class="col-sm-6">
						<div class=" form-group bmd-form-group">
							<label class="" for="weekday">Weekday </label>
							<select class="form-control form-control-select selectpicker" data-style="select-with-transition"
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

	<div class="row justify-content-center">
		<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
			<button class="btnDoorder btn-doorder-primary  mb-1">Save</button>
		</div>
	</div>
</form>
