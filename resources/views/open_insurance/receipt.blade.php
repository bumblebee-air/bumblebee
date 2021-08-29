@extends('templates.dashboard') @section('page-styles')
<style>
.select2-container {
	padding: 5px;
	border-radius: 10px;
	box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
	background-color: #ffffff;
	font-size: 14px !important;
	font-weight: normal !important;
}

.select2-container--default .select2-selection--multiple,
	.select2-container .select2-selection--single {
	width: 100% !important;
	height: auto;
}

.select2-container--default .select2-selection--single {
	border: none !important;
}

.select2-results__option {
	font-family: 'Futura', Fallback, sans-serif !important;;
	font-size: 14px !important;
	font-weight: normal !important;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
}

.select2-results__option:hover {
	font-family: 'Futura', Fallback, sans-serif !important;;
	font-size: 14px !important;
	font-weight: normal !important;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.32px;
	color: #4d4d4d;
	background-color: grey;
}

.select2-container .select2-selection--single {
	border-bottom: none !important;
}

.select2-container .select2-selection--single .select2-selection__rendered
	{
	color: #4d4d4d !important;
	font-size: 14px !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple,
	.select2-container--default .select2-selection--multiple {
	border: none !important;
}

.iti {
	width: 100%
}

.form-control {
	border-radius: 10px;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
}

.form-control:focus {
	border-color: #d176e1;
	background-image: linear-gradient(0deg, #d176e1 2px, rgba(209, 118, 225, 0)
		0), linear-gradient(0deg, #d2d2d2 1px, hsla(0, 0%, 82%, 0) 0)
}

.main-panel>.content {
	margin-top: 40px !important;
}

form .form-group select.form-control {
	top: 55px;
	left: 50%;
}
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
			<form id="customer-form" action="{{url('save_receipt')}}"
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
