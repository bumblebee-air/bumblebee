
<form method="POST"
	action="{{route('unified_saveProductCustomer_cctv', 'unified')}}"
	method="POST" id="save_productCustomer_cctv">
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
										id="cctv_account_type_select" name="cctv_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypesAccessControl) > 0)
										@foreach($accountTypesAccessControl as $item)
											@if(isset($cctvData) && $item->id==$cctvData->cctv_account_type)
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
									<label>Manufacturer</label> <select class="form-control"
										id="cctv_manufacturer_select" name="cctv_manufacturer">
										<option value="">Select manufacturer</option>
										@if(count($manufacturersCCTV) > 0) 
										@foreach($manufacturersCCTV as $item)
											@if(isset($cctvData) && $item->id==$cctvData->cctv_manufacturer)
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
							<div class="col-md-6 ">
								@if(isset($cctvData) && $cctvData->cctv_dvr) <input type="checkbox" id="cctv_dvrRadio" name="cctv_dvr" value="1" checked> 
								@else <input type="checkbox" id="cctv_dvrRadio" name="cctv_dvr" value="1" >
								@endif
								<label
									class="form-check-label w-100 px-0 sendReminderLabel"
									for="cctv_dvrRadio"> <i class="fas fa-check-circle"></i> DVR
								</label>
							</div>
							<div class="col-md-6 ">
								@if(isset($cctvData) && $cctvData->cctv_nvr)<input type="checkbox" id="cctv_nvrRadio" name="cctv_nvr" value="1" checked>
								@else <input type="checkbox" id="cctv_nvrRadio" name="cctv_nvr" value="1" >
								@endif
								 <label
									class="form-check-label w-100 px-0 sendReminderLabel"
									for="cctv_nvrRadio"> <i class="fas fa-check-circle"></i> NVR
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Model</label> <select class="form-control"
										id="cctv_model_select" name="cctv_model">
										<option value="">Select model</option>
										@if(count($modelsCCTV) > 0) 
										@foreach($modelsCCTV as $item)
											@if(isset($cctvData) && $item->id==$cctvData->cctv_model)
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
									<label for="cctv_location">Location</label> <input name="cctv_location"
										type="text" class="form-control" id="cctv_location"
										placeholder="Enter location" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_location}}" @endif> <input type="hidden"
										name="cctv_location_lat" id="cctv_location_lat" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_location_lat}}" @endif> <input
										type="hidden" name="cctv_location_lon" id="cctv_location_lon" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_location_lon}}" @endif>
								</div>
							</div>

						</div>
						<div class="row">
						
						<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Public network IP address </label> <input type="text"
										class="form-control" name="cctv_public_network_ip_address"
										id="cctv_public_network_ip_address"
										placeholder="Enter public network IP address" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_public_network_ip_address}}" @endif/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Local network IP address </label> <input type="text"
										class="form-control" name="cctv_local_network_ip_address"
										id="cctv_local_network_ip_address"
										placeholder="Enter local network IP address"
										@if(isset($cctvData)) value="{{$cctvData->cctv_local_network_ip_address}}" @endif />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Unified user name</label> <input class="form-control" type="text"
										name="cctv_unified_user_name" id="cctv_unified_user_name"
										placeholder="Enter Unified user name"
										@if(isset($cctvData)) value="{{$cctvData->cctv_unified_user_name}}" @endif>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Unified user code</label> <input class="form-control" type="text"
										name="cctv_unified_user_code" id="cctv_unified_user_code"
										placeholder="Enter Unified user code"
										@if(isset($cctvData)) value="{{$cctvData->cctv_unified_user_code}}" @endif>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Local user name</label> <input class="form-control" type="text"
										name="cctv_local_user_name" id="cctv_local_user_name"
										placeholder="Enter local user name"
										@if(isset($cctvData)) value="{{$cctvData->cctv_local_user_name}}" @endif>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Local user code</label> <input class="form-control" type="text"
										name="cctv_local_user_code" id="cctv_local_user_code"
										placeholder="Enter local user code"
										@if(isset($cctvData)) value="{{$cctvData->cctv_local_user_code}}" @endif>
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
													id="cctv_remote_access_Yes" name="cctv_remote_access" value="1"
													{{isset($cctvData) && $cctvData->cctv_remote_access ? 'checked' : ''}}>
													Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cctv_remote_access_No" name="cctv_remote_access" value="0"
													{{isset($cctvData) && $cctvData->cctv_remote_access==0 ? 'checked' : ''}}>
													No <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Remote monitoring</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cctv_remote_monitoring_Yes" name="cctv_remote_monitoring" value="1"
													{{isset($cctvData) && $cctvData->cctv_remote_monitoring ? 'checked' : ''}}>
													Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cctv_remote_monitoring_No" name="cctv_remote_monitoring" value="0"
													{{isset($cctvData) && $cctvData->cctv_remote_monitoring==0 ? 'checked' : ''}}>
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
									<label>Monitoring centre</label> <select class="form-control"
										id="cctv_monitoring_centre_select" name="cctv_monitoring_centre">
										<option value="">Select monitoring centre</option>
										@if(count($monitoringCentreListCCTV) > 0) 
										@foreach($monitoringCentreListCCTV as $item)
											@if(isset($cctvData) && $item->id==$cctvData->cctv_monitoring_centre)
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
									<label>Number of cameras</label> <select class="form-control"
										id="cctv_number_of_cameras_select"
										name="cctv_number_of_cameras">
										<option value="">Select number of cameras</option> @for($i=1;
										$i<=20; $i++)
											@if(isset($cctvData) && $i==$cctvData->cctv_number_of_cameras)
												<option value="{{$i}}" selected>{{$i}}</option>
											@else
												<option value="{{$i}}">{{$i}}</option>
											@endif	 @endfor
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Camera brand</label> <select class="form-control"
										id="cctv_camera_brand_select" name="cctv_camera_brand">
										<option value="">Select camera brand</option>
										@if(count($cameraBrandsCCTV) > 0)
										@foreach($cameraBrandsCCTV as $item)
											@if(isset($cctvData) && $item->id==$cctvData->cctv_camera_brand)
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
									<label>Installation date</label> <input type="text"
										class="form-control dateInput" name="cctv_installation_date"
										id="cctv_installation_date" placeholder="Enter date"
										@if(isset($cctvData)) value="{{$cctvData->cctv_installation_date}}" @endif />
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
													id="cctv_maintenace_contract_Yes"
													name="cctv_maintenace_contract" value="1"
													{{isset($cctvData) && $cctvData->cctv_maintenace_contract ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cctv_maintenace_contract_No"
													name="cctv_maintenace_contract" value="0"
													{{isset($cctvData) && $cctvData->cctv_maintenace_contract==0 ? 'checked' : ''}}> No <span
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
										class="form-control dateInput" name="cctv_maintenance_start_date"
										id="cctv_maintenance_start_date" placeholder="Enter date" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_maintenance_start_date}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance cancellation date</label> <input type="text"
										class="form-control dateInput" name="cctv_maintenance_cancellation_date"
										id="cctv_maintenance_cancellation_date"
										placeholder="Enter date"
										@if(isset($cctvData)) value="{{$cctvData->cctv_maintenance_cancellation_date}}" @endif />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Last maintenance date</label> <input type="text"
										class="form-control dateInput" name="cctv_last_maintenance_date"
										id="cctv_last_maintenance_date" placeholder="Enter date" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_last_maintenance_date}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput" name="cctv_maintenance_due_date"
										id="cctv_maintenance_due_date" placeholder="Enter date"
										@if(isset($cctvData)) value="{{$cctvData->cctv_maintenance_due_date}}" @endif />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance frequency</label> <select
										class="form-control" id="cctv_maintenance_frequency_select"
										name="cctv_maintenance_frequency">
										<option value="">Select maintenance frequency</option>
										@if(count($maintenanceFrequenciesCCTV) > 0)
										@foreach($maintenanceFrequenciesCCTV as $item)
											@if(isset($cctvData) && $item->id==$cctvData->cctv_maintenance_frequency)
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
									<label>Maintenance cost</label> <input type="number" step="any"
										class="form-control" name="cctv_maintenance_cost"
										id="cctv_maintenance_cost"
										placeholder="Enter maintenance cost" 
										@if(isset($cctvData)) value="{{$cctvData->cctv_maintenance_cost}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="cctv_account_notes"
										id="cctv_account_notes" placeholder="Enter account notes"
										@if(isset($cctvData)) value="{{$cctvData->cctv_account_notes}}" @endif />
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