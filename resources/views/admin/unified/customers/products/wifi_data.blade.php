<form method="POST"
	action="{{route('unified_saveProductCustomer_wifiData', 'unified')}}"
	method="POST" id="save_productCustomer_wifiData">
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
										id="wifi_account_type_select" name="wifi_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypesAccessControl) > 0)
										@foreach($accountTypesAccessControl as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_account_type)
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
									<label>System type</label> <select class="form-control"
										id="wifi_system_type_select" name="wifi_system_type">
										<option value="">Select system type</option>
										@if(count($systemTypesWifiData) > 0)
										@foreach($systemTypesWifiData as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_system_type)
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
										id="wifi_manufacturer_select" name="wifi_manufacturer">
										<option value="">Select manufacturer</option>
										@if(count($manufacturersWifiData) > 0)
										@foreach($manufacturersWifiData as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_manufacturer)
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
									<label>Switch type</label> <select class="form-control"
										id="wifi_switch_type_select" name="wifi_switch_type">
										<option value="">Select switch type</option>
										@if(count($switchTypesWifiData) > 0)
										@foreach($switchTypesWifiData as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_switch_type)
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
									<label>Uplink</label> <select class="form-control"
										id="wifi_uplink_select" name="wifi_uplink">
										<option value="">Select uplink</option>
										@if(count($uplinksWifiData) > 0)
										@foreach($uplinksWifiData as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_uplink)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">UPS backup</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="wifi_ups_backup_Yes" name="wifi_ups_backup"
													value="1"
													{{isset($wifiData) && $wifiData->wifi_ups_backup ? 'checked' : ''}}> 
													Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="wifi_ups_backup_No" name="wifi_ups_backup"
													value="0"
													{{isset($wifiData) && $wifiData->wifi_ups_backup==0 ? 'checked' : ''}}>
													 No <span class="circle"> <span class="check"></span>
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
									<label>Broabband provider</label> <select class="form-control"
										id="wifi_broabband_provider_select" name="wifi_broabband_provider">
										<option value="">Select uplink</option>
										@if(count($broabbandProvidersWifiData) > 0)
										@foreach($broabbandProvidersWifiData as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_broabband_provider)
												<option value="{{$item->id}}" selected>{{$item->name}}</option>
											@else
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endif	
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Remote access</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="wifi_remote_access_Yes"
													name="wifi_remote_access" value="1"
													{{isset($wifiData) && $wifiData->wifi_remote_access ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="wifi_remote_access_No"
													name="wifi_remote_access" value="0"
													{{isset($wifiData) && $wifiData->wifi_remote_access==0 ? 'checked' : ''}}> No <span
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
									<label>Username</label> <input class="form-control"
										type="text" name="wifi_username"
										id="wifi_username"
										placeholder="Enter username"
										@if(isset($wifiData)) value="{{$wifiData->wifi_username}}" @endif>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Password</label> <input class="form-control"
										type="text" name="wifi_password"
										id="wifi_password"
										placeholder="Enter password"
										@if(isset($wifiData)) value="{{$wifiData->wifi_password}}" @endif>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Number of devices</label> <input class="form-control"
										type="number" name="wifi_number_of_devices"
										id="wifi_number_of_devices"
										placeholder="Enter number of devices"
										@if(isset($wifiData)) value="{{$wifiData->wifi_number_of_devices}}" @endif>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Installation date</label> <input type="text"
										class="form-control dateInput"
										name="wifi_installation_date"
										id="wifi_installation_date" placeholder="Enter date" 
										@if(isset($wifiData)) value="{{$wifiData->wifi_installation_date}}" @endif/>
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
													id="wifi_maintenace_contract_Yes"
													name="wifi_maintenace_contract" value="1"
													{{isset($wifiData) && $wifiData->wifi_maintenace_contract ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="wifi_maintenace_contract_No"
													name="wifi_maintenace_contract" value="0"
													{{isset($wifiData) && $wifiData->wifi_maintenace_contract==0 ? 'checked' : ''}}> No <span
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
										name="wifi_maintenance_start_date"
										id="wifi_maintenance_start_date" placeholder="Enter date"
										@if(isset($wifiData)) value="{{$wifiData->wifi_maintenance_start_date}}" @endif />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance canceled date</label> <input type="text"
										class="form-control dateInput"
										name="wifi_maintenance_canceled_date"
										id="wifi_maintenance_canceled_date"
										placeholder="Enter date" 
										@if(isset($wifiData)) value="{{$wifiData->wifi_maintenance_canceled_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance frequency</label> <select
										class="form-control"
										id="wifi_maintenance_frequency_select"
										name="wifi_maintenance_frequency">
										<option value="">Select maintenance frequency</option>
										@if(count($maintenanceFrequenciesCCTV) > 0)
										@foreach($maintenanceFrequenciesCCTV as $item)
											@if(isset($wifiData) && $item->id==$wifiData->wifi_maintenance_frequency)
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
									<label>Last maintenance date</label> <input type="text"
										class="form-control dateInput"
										name="wifi_last_maintenance_date"
										id="wifi_last_maintenance_date" placeholder="Enter date" 
										@if(isset($wifiData)) value="{{$wifiData->wifi_last_maintenance_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput"
										name="wifi_maintenance_due_date"
										id="wifi_maintenance_due_date" placeholder="Enter date" 
										@if(isset($wifiData)) value="{{$wifiData->wifi_maintenance_due_date}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance and monitoring cost</label> <input
										type="number" step="any" class="form-control"
										name="wifi_maintenance_and_monitoring_cost"
										id="wifi_maintenance_and_monitoring_cost"
										placeholder="Enter maintenance and monitoring cost" 
										@if(isset($wifiData)) value="{{$wifiData->wifi_maintenance_and_monitoring_cost}}" @endif/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="wifi_account_notes"
										id="wifi_account_notes" placeholder="Enter account notes" 
										@if(isset($wifiData)) value="{{$wifiData->wifi_account_notes}}" @endif/>
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