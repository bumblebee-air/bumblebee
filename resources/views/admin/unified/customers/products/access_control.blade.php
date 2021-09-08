
<form method="POST"
	action="{{route('unified_saveProductCustomer_accessControl', 'unified')}}"
	method="POST" id="save_productCustomer_accessControl">
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
										id="access_account_type_select" name="access_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypesAccessControl) > 0)
										@foreach($accountTypesAccessControl as $item)
											@if(isset($accessControlData) && $item->id==$accessControlData->access_account_type)
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
									<label>Brand</label> <select class="form-control"
										id="access_brand_select" name="access_brand">
										<option value="">Select brand</option>
										@if(count($brandsAccessControl) > 0)
										@foreach($brandsAccessControl as $item)
											@if(isset($accessControlData) && $item->id==$accessControlData->access_brand)
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
									<label class="labelRadio col-12" for="">Single/multi user</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="access_single_multi_user_single"
													name="access_single_multi_user" value="single"
													{{isset($accessControlData) && $accessControlData->access_single_multi_user=='single' ? 'checked' : ''}}> 
													Single <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="access_single_multi_user_multi"
													name="access_single_multi_user" value="multi"
													{{isset($accessControlData) && $accessControlData->access_single_multi_user=='multi' ? 'checked' : ''}}>
													 Multi <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Network IP address </label> <input type="text"
										class="form-control" name="access_network_ip_address"
										id="access_network_ip_address"
										placeholder="Enter network IP address" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_network_ip_address}}" @endif/>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>User ID</label> <input class="form-control" type="text"
										name="access_user_id" id="access_user_id"
										placeholder="Enter user ID" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_user_id}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Password</label> <input class="form-control" type="text"
										name="access_password" id="access_password"
										placeholder="Enter password" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_password}}" @endif/>
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
													id="access_remote_access_Yes" name="access_remote_access"
													value="1" {{isset($accessControlData) && $accessControlData->access_remote_access ? 'checked' : ''}}>
													 Yes <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="access_remote_access_No" name="access_remote_access"
													value="0" {{isset($accessControlData) && $accessControlData->access_remote_access=='0' ? 'checked' : ''}}>
													 No <span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>System type</label> <select class="form-control"
										id="access_system_type_select" name="access_system_type">
										<option value="">Select system type</option>
										@if(count($systemTypesAccessControl) > 0)
										@foreach($systemTypesAccessControl as $item)
											@if(isset($accessControlData) && $item->id==$accessControlData->access_system_type)
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
									<label>Number of doors</label> <select class="form-control"
										id="access_number_of_doors_select"
										name="access_number_of_doors">
										<option value="">Select number of doors</option> @for($i=1;
										$i<=20; $i++)
											@if(isset($accessControlData) && $i==$accessControlData->access_number_of_doors)
												<option value="{{$i}}" selected>{{$i}}</option>
											@else
												<option value="{{$i}}">{{$i}}</option>
											@endif	
										@endfor	
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Card fob</label> <select class="form-control"
										id="access_card_fob_select" name="access_card_fob">
										<option value="">Select card fob</option>
										@if(count($cardFobListAccessControl) > 0)
										@foreach($cardFobListAccessControl as $item)
											@if(isset($accessControlData) && $item->id==$accessControlData->access_card_fob)
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
									<label>Installation date</label> <input type="text"
										class="form-control dateInput" name="access_installation_date"
										id="access_installation_date" placeholder="Enter date" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_installation_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance start date</label> <input type="text"
										class="form-control dateInput" name="access_maintenance_start_date"
										id="access_maintenance_start_date" placeholder="Enter date" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_maintenance_start_date}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance cancellation date</label> <input type="text"
										class="form-control dateInput" name="access_maintenance_cancellation_date"
										id="access_maintenance_cancellation_date" placeholder="Enter date" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_maintenance_cancellation_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Last maintenance date</label> <input type="text"
										class="form-control dateInput" name="access_last_maintenance_date"
										id="access_last_maintenance_date" placeholder="Enter date" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_last_maintenance_date}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput" name="access_maintenance_due_date"
										id="access_maintenance_due_date" placeholder="Enter date" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_maintenance_due_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance contract</label> <input type="text"
										class="form-control" name="access_maintenance_contract"
										id="access_maintenance_contract" placeholder="Enter maintenance contract" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_maintenance_contract}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance cost</label> <input type="number" step="any"
										class="form-control" name="access_maintenance_cost"
										id="access_maintenance_cost" placeholder="Enter maintenance cost" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_maintenance_cost}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account notes</label> <input type="text"
										class="form-control" name="access_account_notes"
										id="access_account_notes" placeholder="Enter account notes" 
										@if(isset($accessControlData)) value="{{$accessControlData->access_account_notes}}" @endif/>
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