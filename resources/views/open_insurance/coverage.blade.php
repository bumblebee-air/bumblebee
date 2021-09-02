@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>

@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('open_insurance/save_coverage')}}"
				enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Coverage</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="policy_number">* Policy number</label> <input
										name="policy_number" type="text" class="form-control"
										id="policy_number" placeholder="Enter policy number" required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="driver_select" class="formLabel">* Driver</label> <select
										id="driver_select" name="driver" class="form-control"
										required><option value="">Select driver</option>
										@foreach($drivers as $driver)
										<option value="{{$driver->id}}">{{$driver->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="intermediary">* Intermediary</label> <input
										name="intermediary" type="text" class="form-control"
										id="intermediary" placeholder="Enter intermediary" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="inception_date">* Inception date</label> <input
										name="inception_date" type="text" class="form-control"
										id="inception_date" placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="expiry_date">* Expiry date</label> <input
										name="expiry_date" type="text" class="form-control"
										id="expiry_date" placeholder="Enter date" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="policy_status_select" class="formLabel">* Policy
										status</label> <select id="policy_status_select"
										name="policy_status" class="form-control" required><option
											value="">Select status</option> @foreach($policyStatusList as
										$status)
										<option value="{{$status->id}}">{{$status->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="peril_select" class="formLabel">* Peril</label> <select id="peril_select"
										name="peril" class="form-control" required><option
											value="">Select peril</option> @foreach($perils as
										$peril)
										<option value="{{$peril->id}}">{{$peril->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="benefit_select" class="formLabel">* Benefit</label> <select id="benefit_select"
										name="benefit" class="form-control" required><option
											value="">Select benefit</option> @foreach($benefits as
										$benefit)
										<option value="{{$benefit->id}}">{{$benefit->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="discount_amount">* Discount amount</label> <input
										name="discount_amount" type="number" step="any" class="form-control"
										id="discount_amount" placeholder="Enter discount amount"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="policy_fees">* Policy fees</label> <input
										name="policy_fees" type="number" step="any" class="form-control"
										id="policy_fees" placeholder="Enter policy fees"
										required>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="premium_rate">* Premium rate</label> <input
										name="premium_rate" type="number" step="any" class="form-control"
										id="premium_rate" placeholder="Enter premium rate"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="gross_written_premium">* Gross written premium</label> <input
										name="gross_written_premium" type="number" step="any" class="form-control"
										id="gross_written_premium" placeholder="Enter gross written premium"
										required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vat">* Vat</label> <input
										name="vat" type="number" step="any" class="form-control"
										id="vat" placeholder="Enter vat"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="brokerage">* Brokerage</label> <input
										name="brokerage" type="number" step="any" class="form-control"
										id="brokerage" placeholder="Enter brokerage"
										required>
								</div>
							</div>
						</div>	
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="premium_payment_frequency_select" class="formLabel">* Premium payment frequency</label> 
									<select id="premium_payment_frequency_select"
										name="premium_payment_frequency" class="form-control" required><option
											value="">Select premium payment frequency</option> @foreach($premiumPaymentFrequencies as
										$item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_select" class="formLabel">* Vehicle</label> 
									<select id="vehicle_select"
										name="vehicle" class="form-control" required><option
											value="">Select vehicle</option> @foreach($vehicles as
										$vehicle)
										<option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="indemnity_limit_policy">* Indemnity limit policy</label>
									<input name="indemnity_limit_policy" type="number" step="any"
										class="form-control" id="indemnity_limit_policy"
										placeholder="Enter indemnity limit policy" required>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="indemnity_limit_accident">* Indemnity limit accident</label>
									<input name="indemnity_limit_accident" type="number" step="any"
										class="form-control" id="indemnity_limit_accident"
										placeholder="Enter indemnity limit accident" required>
								</div>
							</div>
						</div>
										
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Is agreed value? </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="is_agreed_value" id="is_agreed_value_radio1"
												value="1" class="form-check-input" required> Yes <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="is_agreed_value" id="is_agreed_value_radio0"
												value="0" class="form-check-input" required> No <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="endorsement_id">* Endorsement ID</label>
									<input name="endorsement_id" type="text"
										class="form-control" id="endorsement_id"
										placeholder="Enter endorsement ID" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="endorsement_date">* Endorsement date</label> <input
										name="endorsement_date" type="text" class="form-control"
										id="endorsement_date" placeholder="Enter date" required>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="endorsement_type_select" class="formLabel">* Endorsement type</label>
									<select id="endorsement_type_select" name="endorsement_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($endorsementTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="profit_share">* Profit share</label> <input
										name="profit_share" type="text" 
										class="form-control" id="profit_share"
										placeholder="Enter profit_share" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="voluntary_deductible_percentage">* Voluntary deductible percentage
									</label> <input
										name="voluntary_deductible_percentage" type="number" step="any"
										class="form-control" id="voluntary_deductible_percentage"
										placeholder="Enter voluntary deductible percentage" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="compulsory_deductible_percentage">* Compulsory deductible percentage
									</label> <input
										name="compulsory_deductible_percentage" type="number" step="any"
										class="form-control" id="compulsory_deductible_percentage"
										placeholder="Enter compulsory deductible percentage" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="windscreen_deductible_percentage">* Windscreen deductible percentage
									</label> <input
										name="windscreen_deductible_percentage" type="number" step="any"
										class="form-control" id="windscreen_deductible_percentage"
										placeholder="Enter windscreen deductible percentage" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="beneficiary_select" class="formLabel">* Beneficiary</label>
									<select id="beneficiary_select" name="beneficiary"
										class="form-control" required><option value="">Select beneficiary</option>
										@foreach($beneficiaries as $beneficiary)
										<option value="{{$beneficiary->id}}">{{$beneficiary->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="receipt_select" class="formLabel">* Receipt</label>
									<select id="receipt_select" name="receipt"
										class="form-control" required><option value="">Select receipt</option>
										@foreach($receipts as $receipt)
										<option value="{{$receipt->id}}">{{$receipt->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claim_select" class="formLabel">* Claim</label>
									<select id="claim_select" name="claim"
										class="form-control" required><option value="">Select claim</option>
										@foreach($claims as $claim)
										<option value="{{$claim->id}}">{{$claim->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="row text-center">
					<div class="col-md-12">
						<button type="submit" id="saveButton"
							class="btn btn-fill btn-rose">Save</button>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
  

$(document).ready(function() {
	$("#driver_select").select2({ allowClear: true,placeholder:'Select driver'}).trigger('change');
	$("#policy_status_select").select2({ allowClear: true,placeholder:'Select status'}).trigger('change');
	$("#peril_select").select2({ allowClear: true,placeholder:'Select peril'}).trigger('change');
	$("#benefit_select").select2({ allowClear: true,placeholder:'Select benefit'}).trigger('change');
	$("#premium_payment_frequency_select").select2({ allowClear: true,placeholder:'Select premium payment frequency'}).trigger('change');
	$("#vehicle_select").select2({ allowClear: true,placeholder:'Select vehicle'}).trigger('change');
	$("#endorsement_type_select").select2({ allowClear: true,placeholder:'Select endorsement type'}).trigger('change');
	$("#beneficiary_select").select2({ allowClear: true,placeholder:'Select beneficiary'}).trigger('change');
	$("#receipt_select").select2({ allowClear: true,placeholder:'Select receipt'}).trigger('change');
	$("#claim_select").select2({ allowClear: true,placeholder:'Select claim'}).trigger('change');
	

    $("#inception_date,#expiry_date,#endorsement_date").datetimepicker({	
    		
    });
    
  

});


</script>

@endsection
