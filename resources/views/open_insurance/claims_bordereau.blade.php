@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>

<style>
.custom-file-label {
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
	border-radius: 10px;
	line-height: 2 !important;
}

.custom-file-label:after {
	background: #e9ecef;
	padding-top: 0.8rem;
	height: 100%;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_claims_bordereau')}}"
				enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Claims Bordereau</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="treaty_reference">* Treaty reference</label>
									<input name="treaty_reference" type="text"
										class="form-control" id="treaty_reference"
										placeholder="Enter refernece" required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="policy_holder">* Policy holder</label> <input
										name="policy_holder" type="text" class="form-control"
										id="policy_holder" placeholder="Enter policy holder" required>
								</div>
							</div>
						</div>
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
									<label for="indemnity_limit_policy">* Indemnity limit policy</label> <input
										name="indemnity_limit_policy" type="number" step="any" class="form-control"
										id="indemnity_limit_policy" placeholder="Enter indemnity limit policy" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claim_number">* Claim number</label> <input
										name="claim_number" type="text" class="form-control"
										id="claim_number" placeholder="Enter claim number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="first_notice_of_loss">* First notice of loss</label>
									<input name="first_notice_of_loss" type="text"
										class="form-control" id="first_notice_of_loss"
										placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="date_of_loss">* Date of loss</label> <input
										name="date_of_loss" type="text" class="form-control"
										id="date_of_loss" placeholder="Enter date" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="cause_of_loss">* Cause of loss</label> <input
										name="cause_of_loss" type="text" class="form-control"
										id="cause_of_loss" placeholder="Enter cause" required>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claimant">* Claimant</label> <input
										name="claimant" type="text" class="form-control"
										id="claimant" placeholder="Enter claimant" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="gross_loss_reserve">* Gross loss reserve</label> <input
										name="gross_loss_reserve" type="number" step="any" class="form-control"
										id="gross_loss_reserve" placeholder="Enter gross loss reserve" required>
								</div>
							</div>
						</div>						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="excess_amount">* Excess amount</label> <input
										name="excess_amount" type="number" step="any" class="form-control"
										id="excess_amount" placeholder="Enter excess amount" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="expense_reserve">* Expense reserve</label> <input
										name="expense_reserve" type="number" step="any" class="form-control"
										id="expense_reserve" placeholder="Enter expense reserve" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="paid">* Paid</label> <input
										name="paid" type="number" step="any" class="form-control"
										id="paid" placeholder="Enter paid" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="expense_paid">* Expense paid</label> <input
										name="expense_paid" type="number" step="any" class="form-control"
										id="expense_paid" placeholder="Enter expense paid" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="expected_recovery">* Expected recovery</label> <input
										name="expected_recovery" type="number" step="any" class="form-control"
										id="expected_recovery" placeholder="Enter expected recovery" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="recovery_received">* Recovery received</label> <input
										name="recovery_received" type="number" step="any" class="form-control"
										id="recovery_received" placeholder="Enter recovery received" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claim_status_select" class="formLabel">* Claim status</label>
									<select id="claim_status_select" name="claim_status"
										class="form-control" required><option value="">Select status</option>
										@foreach($claimStatusList as $status)
										<option value="{{$status->id}}">{{$status->name}}</option>
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
	$("#claim_status_select").select2({ allowClear: true,placeholder:'Select status'}).trigger('change');
	

    $("#inception_date,#expiry_date").datetimepicker({	
    		format: 'YYYY-MM-DD ',
    });
    
    $("#first_notice_of_loss,#date_of_loss").datetimepicker({	
    });
    
  

});


</script>

@endsection
