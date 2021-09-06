
<form method="POST"
	action="{{route('unified_saveProductCustomer_hostedCpbx', 'unified')}}"
	method="POST" id="save_productCustomer_hostedCpbx">
	{{csrf_field()}}
	
	<input type="hidden" name="customer_id"
						value="{{$customer->id}}">

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<div class="container " style="width: 100%; max-width: 100%;">
						<div class="row">
							<div class="col-md-12">
								<h5 class="card-title card-sub-title customerProfile">Hosted</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Hosted package</label> <select class="form-control"
										id="hosted_package_select" name="hosted_package">
										<option value="">Select hosted package</option>
										@if(count($hostedPackages) > 0) @foreach($hostedPackages as
										$item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>IP vendor</label> <select class="form-control"
										id="hosted_ip_vendor_select" name="hosted_ip_vendor">
										<option value="">Select IP vendor</option>
										@if(count($ipVendors) > 0) @foreach($ipVendors as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Provisioning URL </label> <input type="text"
										class="form-control" name="hosted_provisioning_url"
										id="hosted_provisioning_url" placeholder="Enter provisioning URL" />
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Account portal ID</label> <input type="text"
										class="form-control" name="hosted_account_portal_id"
										id="hosted_account_portal_id" placeholder="Enter account portal ID"/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Line & DDI numbers</label> <input type="text"
										class="form-control" name="hosted_line_ddi_numbers"
										id="hosted_line_ddi_numbers" placeholder="Enter line & DDI numbers"/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Broadband provider</label> <input type="text"
										class="form-control" name="hosted_broadband_provider"
										id="hosted_broadband_provider" placeholder="Enter broadband provider" />
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Number of users</label> <input type="number"
										class="form-control" name="hosted_number_of_users"
										id="hosted_number_of_users" placeholder="Enter number of users" />
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Handset type</label> <input type="text"
										class="form-control" name="hosted_handset_type"
										id="hosted_handset_type" placeholder="Enter handset type"/>
								</div>
							</div>
							<div class="col-12">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Call recording</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="hosted_call_recording_Yes" name="hosted_call_recording"
													value="1" > Yes <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="hosted_call_recording_No" name="hosted_call_recording"
													value="0" > No <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">CRM interface</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="hosted_crm_interface_Yes" name="hosted_crm_interface"
													value="1" > Yes <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="hosted_crm_interface_No" name="hosted_crm_interface"
													value="0" > No <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Installation date</label> <input type="text"
										class="form-control dateInput" name="hosted_installation_date"
										id="hosted_installation_date" placeholder="Enter date"/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput" name="hosted_maintenance_due_date"
										id="hosted_maintenance_due_date" placeholder="Enter date"/>
								</div>
							</div>
							<div class="col-12">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Maintenance</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="hosted_maintenance_yes" name="hosted_maintenance"
													value="1" > Yes <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="hosted_maintenance_no" name="hosted_maintenance"
													value="0" > No <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Account type</label> <select class="form-control"
										id="hosted_account_type_select" name="hosted_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypes) > 0) @foreach($accountTypes as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="hosted_account_notes"
										id="hosted_account_notes" placeholder="Enter account notes"/>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">

			<div class="card">
				<div class="card-body">
					<div class="container " style="width: 100%; max-width: 100%;">
						<div class="row">
							<div class="col-md-12">
								<h5 class="card-title card-sub-title customerProfile">Cpbx</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>System model</label> <select class="form-control"
										id="cpbx_system_model_select" name="cpbx_system_model">
										<option value="">Select system model</option>
										@if(count($systemModels) > 0) @foreach($systemModels as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>System user ID</label> <input class="form-control"
										type="text" name="cpbx_system_user_id"
										id="cpbx_system_user_id" placeholder="Enter system user ID">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>System password</label> <input class="form-control"
										type="text" name="cpbx_system_password"
										id="cpbx_system_password" placeholder="Enter system password">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Line type</label> <select class="form-control"
										id="cpbx_line_type_select" name="cpbx_line_type">
										<option value="">Select line type</option>
										@if(count($lineTypes) > 0) @foreach($lineTypes as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Line vendor</label> <select class="form-control"
										id="cpbx_line_vendor_select" name="cpbx_line_vendor">
										<option value="">Select line vendor</option>
										@if(count($lineVendors) > 0) @foreach($lineVendors as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>SIP account user ID</label> <input class="form-control"
										type="text" name="cpbx_sip_account_user_id"
										id="cpbx_sip_account_user_id"
										placeholder="Enter SIP account user ID">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>SIP account password</label> <input class="form-control"
										type="text" name="cpbx_sip_account_password"
										id="cpbx_sip_account_password"
										placeholder="Enter SIP account password">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Number of users</label> <input type="number"
										class="form-control" name="cpbx_number_of_users"
										id="cpbx_number_of_users" placeholder="Enter number of users" />
								</div>
							</div>
							
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Handset type</label> <input type="text"
										class="form-control" name="cpbx_handset_type"
										id="cpbx_handset_type" placeholder="Enter handset type"/>
								</div>
							</div>
							
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Static IP address</label> 
									<input class="form-control" type="text" name="cpbx_static_ip_address" id="cpbx_static_ip_address" 
									placeholder="Enter static IP address">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Port number</label> <input class="form-control" type="text" 
									name="cpbx_port_number" id="cpbx_port_number" placeholder="Enter port number">
								</div>
							</div>
							
							
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Line & DDI numbers</label> <input type="text"
										class="form-control" name="cpbx_line_ddi_numbers"
										id="cpbx_line_ddi_numbers" placeholder="Enter line & DDI numbers"/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Broadband provider</label> <input type="text"
										class="form-control" name="cpbx_broadband_provider"
										id="cpbx_broadband_provider" placeholder="Enter broadband provider" />
								</div>
							</div>
							
							<div class="col-12">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Call recording</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cpbx_call_recording_Yes" name="cpbx_call_recording"
													value="1" > Yes <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cpbx_call_recording_No" name="cpbx_call_recording"
													value="0" > No <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">CRM interface</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cpbx_crm_interface_Yes" name="cpbx_crm_interface"
													value="1" > Yes <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cpbx_crm_interface_No" name="cpbx_crm_interface"
													value="0" > No <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Installation date</label> <input type="text"
										class="form-control dateInput" name="cpbx_installation_date"
										id="cpbx_installation_date" placeholder="Enter date"/>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput" name="cpbx_maintenance_due_date"
										id="cpbx_maintenance_due_date" placeholder="Enter date"/>
								</div>
							</div>
							<div class="col-12">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Maintenance</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cpbx_maintenance_yes" name="cpbx_maintenance"
													value="1" > Yes <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="cpbx_maintenance_no" name="cpbx_maintenance"
													value="0" > No <span class="circle"> <span
														class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Account type</label> <select class="form-control"
										id="cpbx_account_type_select" name="cpbx_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypes) > 0) @foreach($accountTypes as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="cpbx_account_notes"
										id="cpbx_account_notes" placeholder="Enter account notes"/>
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