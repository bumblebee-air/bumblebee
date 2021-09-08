
<form method="POST"
	action="{{route('unified_saveProductCustomer_structuredCablingSystems', 'unified')}}"
	method="POST" id="save_productCustomer_structuredCablingSystems">
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
									<label>Model</label> <select class="form-control"
										id="structured_model_select" name="structured_model">
										<option value="">Select model</option>
										@if(count($modelsStructuredCabling) > 0)
										@foreach($modelsStructuredCabling as $item)
											@if(isset($structuredCablingData) && $item->id==$structuredCablingData->structured_model)
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
									<label class="labelRadio col-12" for="">Single/multi user</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="structured_single_multi_user_single"
													name="structured_single_multi_user" value="single"
													{{isset($structuredCablingData) && $structuredCablingData->structured_single_multi_user=='single' ? 'checked' : ''}}>
													 Single
													<span class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="structured_single_multi_user_multi"
													name="structured_single_multi_user" value="multi"
													{{isset($structuredCablingData) && $structuredCablingData->structured_single_multi_user=='multi' ? 'checked' : ''}}> 
													Multi <span
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
									<label>Network IP address </label> <input type="text"
										class="form-control" name="structured_network_ip_address"
										id="structured_network_ip_address"
										placeholder="Enter network IP address"
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_network_ip_address}}" @endif />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>User ID</label> <input class="form-control" type="text"
										name="structured_user_id" id="structured_user_id"
										placeholder="Enter user ID"
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_user_id}}" @endif>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Password</label> <input class="form-control" type="text"
										name="structured_password" id="structured_password"
										placeholder="Enter password"
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_password}}" @endif>
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
													id="structured_remote_access_Yes"
													name="structured_remote_access" value="1"
													{{isset($structuredCablingData) && $structuredCablingData->structured_remote_access ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="structured_remote_access_No"
													name="structured_remote_access" value="0"
													{{isset($structuredCablingData) && $structuredCablingData->structured_remote_access==0 ? 'checked' : ''}}> No <span
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
									<label>Number of doors</label> <input class="form-control"
										type="number" name="structured_number_of_doors"
										id="structured_number_of_doors"
										placeholder="Enter number of doors"
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_number_of_doors}}" @endif>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Number of fobs</label> <input class="form-control"
										type="number" name="structured_number_of_fobs"
										id="structured_number_of_fobs"
										placeholder="Enter number of fobs"
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_number_of_fobs}}" @endif>
								</div>
							</div>
						</div>

						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Installation date</label> <input type="text"
										class="form-control dateInput"
										name="structured_installation_date"
										id="structured_installation_date" placeholder="Enter date" 
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_installation_date}}" @endif/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Maintenance due date</label> <input type="text"
										class="form-control dateInput"
										name="structured_maintenance_due_date"
										id="structured_maintenance_due_date" placeholder="Enter date" 
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_maintenance_due_date}}" @endif/>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class=" row" style="margin-top: 15px">
									<label class="labelRadio col-12" for="">Maintenace</label>
									<div class="col-12 row">
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="structured_maintenace_Yes"
													name="structured_maintenace" value="1"
													{{isset($structuredCablingData) && $structuredCablingData->structured_maintenace ? 'checked' : ''}}> Yes <span
													class="circle"> <span class="check"></span>
												</span>
												</label>
											</div>
										</div>
										<div class="col">
											<div class="form-check form-check-radio">
												<label class="form-check-label"> <input
													class="form-check-input" type="radio"
													id="structured_maintenace_No"
													name="structured_maintenace" value="0"
													{{isset($structuredCablingData) && $structuredCablingData->structured_maintenace==0 ? 'checked' : ''}}> No <span
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
									<label>Maintenance cost</label> <input type="number" step="any"
										class="form-control" name="structured_maintenance_cost"
										id="structured_maintenance_cost"
										placeholder="Enter maintenance cost" 
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_maintenance_cost}}" @endif/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Account type</label> <select class="form-control"
										id="structured_account_type_select" name="structured_account_type">
										<option value="">Select account type</option>
										@if(count($accountTypesStructuredCabling) > 0)
										@foreach($accountTypesStructuredCabling as $item)
											@if(isset($structuredCablingData) && $item->id==$structuredCablingData->structured_account_type)
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
									<label>Account notes</label> <input type="text"
										class="form-control" name="structured_account_notes"
										id="structured_account_notes"
										placeholder="Enter account notes" 
										@if(isset($structuredCablingData)) value="{{$structuredCablingData->structured_account_notes}}" @endif/>
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