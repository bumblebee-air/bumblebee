@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_premium_bordereau')}}"
				enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Premium Bordereau</h4>
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
										name="indemnity_limit_policy" type="number" class="form-control"
										id="indemnity_limit_policy" placeholder="Enter indemnity limit policy" required>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="gross_written_premium">* Gross written premium</label> <input
										name="gross_written_premium" type="number" class="form-control"
										id="gross_written_premium" placeholder="Enter gross written premium" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="net_premium">* Net premium</label> <input
										name="net_premium" type="number" class="form-control"
										id="net_premium" placeholder="Enter net premium" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="transaction_type_select" class="formLabel">* Transaction type</label>
									<select id="transaction_type_select" name="transaction_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($receiptTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
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
	$("#transaction_type_select").select2({ allowClear: true,placeholder:'Select  type'}).trigger('change');
	

    $("#inception_date,#expiry_date").datetimepicker({	
    });
    
    
  

});


</script>

@endsection
