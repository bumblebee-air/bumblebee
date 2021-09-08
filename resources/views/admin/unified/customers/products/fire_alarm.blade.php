
<form method="POST"
	action="{{route('unified_saveProductCustomer_fireAlarm', 'unified')}}"
	method="POST" id="save_productCustomer_fireAlarm">
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
									<label>System type</label> <select class="form-control"
										id="fire_system_type_select" name="fire_system_type">
										<option value="">Select system type</option>
										@if(count($systemTypesFireAlarm) > 0)
										@foreach($systemTypesFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_system_type)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Wired / Wireless </label> <select class="form-control"
										id="fire_wired_select" name="fire_wired">
										<option value="">Select wired / wireless</option>
										@if(count($wiredWirlessFireAlarm) > 0)
										@foreach($wiredWirlessFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_wired)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Manufacturer</label> <select class="form-control"
										id="fire_manufacturer_select" name="fire_manufacturer">
										<option value="">Select manufacturer</option>
										@if(count($manufacturersFireAlarm) > 0) 
										@foreach($manufacturersFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_manufacturer)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Model</label> <select class="form-control"
										id="fire_model_select" name="fire_model">
										<option value="">Select model</option>
										@if(count($modelsFireAlarm) > 0) 
										@foreach($modelsFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_model)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="fire_panel_location">Panel location</label> <input name="fire_panel_location"
										type="text" class="form-control" id="fire_panel_location"
										placeholder="Enter location" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_panel_location}}" @endif> <input type="hidden"
										name="fire_panel_location_lat" id="fire_panel_location_lat" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_panel_location_lat}}" @endif> <input
										type="hidden" name="fire_panel_location_lon" id="fire_panel_location_lon" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_panel_location_lon}}" @endif>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Number of loops</label> <select class="form-control"
										id="fire_number_of_loops_select"
										name="fire_number_of_loops">
										<option value="">Select number of loops</option> @for($i=1;
										$i<=8; $i++)
											@if(isset($fireAlarmData) && $i==$fireAlarmData->fire_number_of_loops)
												<option value="{{$i}}" selected>{{$i}}</option>
											@else
												<option value="{{$i}}">{{$i}}</option>
											@endif	
										 @endfor
									</select>
								</div>
							</div>
					
						</div>
						
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Protocol</label> <select class="form-control"
										id="fire_protocol_select" name="fire_protocol">
										<option value="">Select protocol</option>
										@if(count($protocolsFireAlarm) > 0)
										@foreach($protocolsFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_protocol)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Panel operation</label> <select class="form-control"
										id="fire_panel_operation_select" name="fire_panel_operation">
										<option value="">Select panel operation</option>
										@if(count($panelOperationsFireAlarm) > 0)
										@foreach($panelOperationsFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_panel_operation)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">

							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Networked</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="fire_networked_Yes"
													name="fire_networked" value="1"
													{{isset($fireAlarmData) && $fireAlarmData->fire_networked ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="fire_networked_No"
													name="fire_networked" value="0"
													{{isset($fireAlarmData) && $fireAlarmData->fire_networked==0 ? 'checked' : ''}}> no <span
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
									<label>Password level 1</label> <input class="form-control" type="text"
										name="fire_password_level1" id="fire_password_level1"
										placeholder="Enter password"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_password_level1}}" @endif>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Password level 2</label> <input class="form-control" type="text"
										name="fire_password_level2" id="fire_password_level2"
										placeholder="Enter password"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_password_level2}}" @endif>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Password level 3</label> <input class="form-control" type="text"
										name="fire_password_level3" id="fire_password_level3"
										placeholder="Enter password"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_password_level3}}" @endif>
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
													id="fire_remote_access_Yes" name="fire_remote_access"
													value="1"
													{{isset($fireAlarmData) && $fireAlarmData->fire_remote_access ? 'checked' : ''}}>
													 Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="fire_remote_access_No" name="fire_remote_access"
													value="0"
													{{isset($fireAlarmData) && $fireAlarmData->fire_remote_access==0 ? 'checked' : ''}}> 
													No <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class=" row">
									<label class="labelRadio col-12" for="">Monitored</label>
									 <select class="form-control"
										id="fire_monitored_select" name="fire_monitored">
										<option value="">Select monitored</option>
										@if(count($monitoredListFireAlarm) > 0)
										@foreach($monitoredListFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_monitored)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Monitoring centre</label> <select class="form-control"
										id="fire_monitoring_centre_select" name="fire_monitoring_centre">
										<option value="">Select monitoring centre</option>
										@if(count($monitoringCentreListFireAlarm) > 0) 
										@foreach($monitoringCentreListFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_monitoring_centre)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Digi type</label> <select class="form-control"
										id="fire_digi_type_select" name="fire_digi_type">
										<option value="">Select digi type</option>
										@if(count($digiTypesFireAlarm) > 0) 
										@foreach($digiTypesFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_digi_type)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Digi number</label> <input class="form-control" type="number"
										name="fire_digi_number" id="fire_digi_number"
										placeholder="Enter digi number"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_digi_number}}" @endif>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Number of devices</label> <input class="form-control" type="number"
										name="fire_number_of_devices" id="fire_number_of_devices"
										placeholder="Enter number of devices"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_number_of_devices}}" @endif>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Installation date</label> <input type="text"
										class="form-control dateInput" name="fire_installation_date"
										id="fire_installation_date" placeholder="Enter date" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_installation_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Maintenace contract</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="fire_maintenace_contract_Yes"
													name="fire_maintenace_contract" value="1"
													{{isset($fireAlarmData) && $fireAlarmData->fire_maintenace_contract ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="fire_maintenace_contract_No"
													name="fire_maintenace_contract" value="0"
													{{isset($fireAlarmData) && $fireAlarmData->fire_maintenace_contract==0 ? 'checked' : ''}}> No <span
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
									<label>Maintenance start date</label> <input type="text"
										class="form-control dateInput" name="fire_maintenance_start_date"
										id="fire_maintenance_start_date" placeholder="Enter date"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_maintenance_start_date}}" @endif />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance cancellation date</label> <input type="text"
										class="form-control dateInput" name="fire_maintenance_cancellation_date"
										id="fire_maintenance_cancellation_date" placeholder="Enter date" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_maintenance_cancellation_date}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance frequency</label> <select
										class="form-control" id="fire_maintenance_frequency_select"
										name="fire_maintenance_frequency">
										<option value="">Select maintenance frequency</option>
										@if(count($maintenanceFrequenciesFireAlarm) > 0)
										@foreach($maintenanceFrequenciesFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_maintenance_frequency)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif 
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput" name="fire_maintenance_due_date"
										id="fire_maintenance_due_date" placeholder="Enter date"
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_maintenance_due_date}}" @endif />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance cost</label> <input type="number" step="any"
										class="form-control" name="fire_maintenance_cost"
										id="fire_maintenance_cost" placeholder="Enter maintenance cost" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_maintenance_cost}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account type</label> <select
										class="form-control" id="fire_account_type_select"
										name="fire_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypesFireAlarm) > 0)
										@foreach($accountTypesFireAlarm as $item)
											@if(isset($fireAlarmData) && $item->id==$fireAlarmData->fire_account_type)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif 
									</select>
								</div>
							</div>
							
						</div>
						<div class="row">	
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="fire_account_notes"
										id="fire_account_notes" placeholder="Enter account notes" 
										@if(isset($fireAlarmData)) value="{{$fireAlarmData->fire_account_notes}}" @endif/>
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