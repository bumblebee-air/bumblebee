<form method="POST"
	action="{{route('unified_saveProductCustomer_intruderAlarm', 'unified')}}"
	method="POST" id="save_productCustomer_intruderAlarm">
	{{csrf_field()}} <input type="hidden" name="customer_id"
		value="{{$customer->id}}">

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="container " style="width: 100%; max-width: 100%;">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account type</label> <select class="form-control"
										id="intruder_account_type_select" name="intruder_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypesIntruderAlarm) > 0)
										@foreach($accountTypesIntruderAlarm as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>System type</label> <select class="form-control"
										id="intruder_system_type_select" name="intruder_system_type">
										<option value="">Select system type</option>
										@if(count($systemTypesIntruderAlarm) > 0)
										@foreach($systemTypesIntruderAlarm as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Manufacturer</label> <select class="form-control"
										id="intruder_manufacturer_select" name="intruder_manufacturer">
										<option value="">Select manufacturer</option>
										@if(count($manufacturersIntruderAlarm) > 0)
										@foreach($manufacturersIntruderAlarm as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Panel type</label> <select class="form-control"
										id="intruder_panel_type_select" name="intruder_panel_type">
										<option value="">Select panel type</option>
										@if(count($panelTypesIntruderAlarm) > 0)
										@foreach($panelTypesIntruderAlarm as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="intruder_panel_location">Panel location</label> <input
										name="intruder_panel_location" type="text"
										class="form-control" id="intruder_panel_location"
										placeholder="Enter location"> <input type="hidden"
										name="intruder_panel_location_lat"
										id="intruder_panel_location_lat" value=""> <input
										type="hidden" name="intruder_panel_location_lon"
										id="intruder_panel_location_lon" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="intruder_panel_location">Panel battery date</label>
									<input type="text" class="form-control dateInput"
										id="intruder_panel_battery_date"
										name="intruder_panel_battery_date" placeholder="Enter date">
								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="intruder_wireless_location">Wireless battery date</label>
									<input type="text" class="form-control dateInput"
										id="intruder_wireless_battery_date"
										name="intruder_wireless_battery_date" placeholder="Enter date">
								</div>
							</div>
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Networked</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_networked_Yes" name="intruder_networked"
													value="1"> Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_networked_No" name="intruder_networked"
													value="0"> no <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Remote access</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_remote_access_Yes"
													name="intruder_remote_access" value="1"> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_remote_access_No"
													name="intruder_remote_access" value="0"> No <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Secure comm ID</label> <input class="form-control"
										type="number" name="intruder_secure_comm_id"
										id="intruder_secure_comm_id"
										placeholder="Enter secure comm ID">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Secure comm code</label> <input class="form-control"
										type="number" name="intruder_secure_comm_code"
										id="intruder_secure_comm_code"
										placeholder="Enter secure comm code">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Remote user code</label> <input class="form-control"
										type="number" name="intruder_remote_user_code"
										id="intruder_remote_user_code"
										placeholder="Enter remote user code">
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Monitored</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_monitored_Yes" name="intruder_monitored"
													value="1"> Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_monitored_No" name="intruder_monitored"
													value="0"> no <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Monitoring centre</label> <select class="form-control"
										id="intruder_monitoring_centre_select"
										name="intruder_monitoring_centre">
										<option value="">Select monitoring centre</option>
										@if(count($monitoringCentreListCCTV) > 0)
										@foreach($monitoringCentreListCCTV as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Digi type</label> <select class="form-control"
										id="intruder_digi_type_select" name="intruder_digi_type">
										<option value="">Select digi type</option>
										@if(count($digiTypesIntruderAlarm) > 0)
										@foreach($digiTypesIntruderAlarm as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Digi number</label> <input class="form-control"
										type="number" name="intruder_digi_number"
										id="intruder_digi_number" placeholder="Enter digi number">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Radio number</label> <input class="form-control"
										type="number" name="intruder_radio_number"
										id="intruder_radio_number" placeholder="Enter radio number">
								</div>
							</div>
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">App only monitoring</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_app_only_monitoring_Yes"
													name="intruder_app_only_monitoring" value="1"> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_app_only_monitoring_No"
													name="intruder_app_only_monitoring" value="0"> no <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Number of devices</label> <input class="form-control"
										type="number" name="intruder_number_of_devices"
										id="intruder_number_of_devices"
										placeholder="Enter number of devices">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Installation date</label> <input type="text"
										class="form-control dateInput"
										name="intruder_installation_date"
										id="intruder_installation_date" placeholder="Enter date" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Maintenace contract</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_maintenace_contract_Yes"
													name="intruder_maintenace_contract" value="1"> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="intruder_maintenace_contract_No"
													name="intruder_maintenace_contract" value="0"> No <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance start date</label> <input type="text"
										class="form-control dateInput"
										name="intruder_maintenance_start_date"
										id="intruder_maintenance_start_date" placeholder="Enter date" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance canceled date</label> <input type="text"
										class="form-control dateInput"
										name="intruder_maintenance_canceled_date"
										id="intruder_maintenance_canceled_date"
										placeholder="Enter date" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance frequency</label> <select
										class="form-control"
										id="intruder_maintenance_frequency_select"
										name="intruder_maintenance_frequency">
										<option value="">Select maintenance frequency</option>
										@if(count($maintenanceFrequenciesCCTV) > 0)
										@foreach($maintenanceFrequenciesCCTV as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Last maintenance date</label> <input type="text"
										class="form-control dateInput"
										name="intruder_last_maintenance_date"
										id="intruder_last_maintenance_date" placeholder="Enter date" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput"
										name="intruder_maintenance_due_date"
										id="intruder_maintenance_due_date" placeholder="Enter date" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance and monitoring cost</label> <input
										type="number" step="any" class="form-control"
										name="intruder_maintenance_and_monitoring_cost"
										id="intruder_maintenance_and_monitoring_cost"
										placeholder="Enter maintenance and monitoring cost" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="intruder_account_notes"
										id="intruder_account_notes" placeholder="Enter account notes" />
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>


	</div>

	<div class="row ">
		<div class="col-md-12 text-center">

			<button type="submit"
				class="btn btn-unified-primary singlePageButton">Save</button>
		</div>
	</div>

</form>