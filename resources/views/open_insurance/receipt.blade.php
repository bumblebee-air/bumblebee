@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>

@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('open_insurance/save_receipt')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Receipt</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="receipt_type_select" class="formLabel">* Receipt type</label>
									<select id="receipt_type_select" name="receipt_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($receiptTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="receipt_date">* Receipt date</label> <input
										name="receipt_date" type="text" class="form-control"
										id="receipt_date" placeholder="Enter date" required>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="receipt_amount">* Receipt amount</label> <input
										name="receipt_amount" type="number" class="form-control"
										id="receipt_amount" placeholder="Enter receipt amount"
										required>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="receipt_calculation_select" class="formLabel">* Receipt calculation</label>
									<select id="receipt_calculation_select" name="receipt_calculation"
										class="form-control" required><option value="">Select calculation</option>
										@foreach($receiptCalculations as $calculation)
										<option value="{{$calculation->id}}">{{$calculation->name}}</option>
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
	$("#receipt_type_select").select2({ allowClear: true,placeholder:'Select receipt type'}).trigger('change');
	$("#receipt_calculation_select").select2({ allowClear: true,placeholder:'Select receipt calculation'}).trigger('change');
	
    $("#receipt_date").datetimepicker({
    		format: 'YYYY-MM-DD ',
    });
    
});

</script>


@endsection
