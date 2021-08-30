@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_vehicle')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Vehicle</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="plate_number">* Plate number</label> <input
										name="plate_number" type="text" class="form-control"
										id="plate_number" placeholder="Enter plate number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="registration_date">* Registration date</label> <input
										name="registration_date" type="text" class="form-control"
										id="registration_date" placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="country_of_registeration_select">* Country of
										registeration </label> <select
										id="country_of_registeration_select"
										name="country_of_registeration" class="form-control" required>
										<option value="">Select country</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="chassis_number">* Chassis number</label> <input
										name="chassis_number" type="text" class="form-control"
										id="chassis_number" placeholder="Enter chassis number"
										required>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vin">* Vin</label> <input name="vin" type="text"
										class="form-control" id="vin" placeholder="Enter vin" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="engine_number">* Engine number</label> <input
										name="engine_number" type="text" class="form-control"
										id="engine_number" placeholder="Enter engine number" required>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_weight">* Vehicle weight</label> <input
										name="vehicle_weight" type="number" step="any" min="1"
										class="form-control" id="vehicle_weight"
										placeholder="Enter vehicle weight" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Agency repair</label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="agency_repair" id="agency_repair_radio1" value="1"
												class="form-check-input" required> Yes <span class="circle">
													<span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="agency_repair" id="agency_repair_radio0" value="0"
												class="form-check-input" required> No <span class="circle">
													<span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Vehicle garage</label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="vehicle_garage" id="vehicle_garage_radio1" value="1"
												class="form-check-input" required> Yes <span class="circle">
													<span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="vehicle_garage" id="vehicle_garage_radio0" value="0"
												class="form-check-input" required> No <span class="circle">
													<span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="body_type_select" class="formLabel">* Body type</label>
									<select id="body_type_select" name="body_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($bodyTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="fuel_type_select" class="formLabel">* Fuel type</label>
									<select id="fuel_type_select" name="fuel_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($fuelTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="ai_classification_select" class="formLabel">* AI
										Classification</label> <select id="ai_classification_select"
										name="ai_classification" class="form-control" required><option
											value="">Select classification</option>
										@foreach($aiClassifications as $classification)
										<option value="{{$classification->id}}">{{$classification->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_use_select" class="formLabel">* Vehicle use</label>
									<select id="vehicle_use_select" name="vehicle_use"
										class="form-control" required><option value="">Select vehicle
											use</option> @foreach($vehicleUses as $vUse)
										<option value="{{$vUse->id}}">{{$vUse->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="yearly_mileage">* Yearly mileage</label> <input
										name="yearly_mileage" type="number" min="1"
										class="form-control" id="yearly_mileage"
										placeholder="Enter yearly mileage" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_brand">* Vehicle brand <span
										style="font-size: x-small;">(KBA/HSN and TSN) </span>
									</label> <input name="vehicle_brand" type="text"
										class="form-control" id="vehicle_brand"
										placeholder="Enter vehicle brand" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_modal">* Vehicle modal </label> <input
										name="vehicle_modal" type="text" class="form-control"
										id="vehicle_modal" placeholder="Enter vehicle modal" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="model_year">* Model year </label> <input
										name="model_year" type="text" class="form-control"
										id="model_year" placeholder="Enter model year" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="seats">* Seats</label> <input name="seats"
										type="number" class="form-control" id="seats"
										placeholder="Enter seats" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="colour">* Colour</label> <input name="colour"
										type="text" class="form-control" id="colour"
										placeholder="Enter colour" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Trailer included </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="trailer_included" id="trailer_included_radio1"
												value="1" class="form-check-input" required> Yes <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="trailer_included" id="trailer_included_radio0"
												value="0" class="form-check-input" required> No <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="accessories">* Accessories</label>
									<textarea name="accessories" rows="5" class="form-control"
										id="accessories" placeholder="Enter accessories" required></textarea>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="accessories_value">* Accessories value</label> <input
										name="accessories_value" type="number" class="form-control"
										id="accessories_value" placeholder="Enter accessories value"
										required>
								</div>
								<div class="form-group bmd-form-group">
									<label for="sum_insured">* Sum insured</label> <input
										name="sum_insured" type="number" class="form-control"
										id="sum_insured" placeholder="Enter sum insured" required>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="engine_capacity">* Engine capacity</label> <input
										name="engine_capacity" type="number" step="any"
										class="form-control" id="engine_capacity"
										placeholder="Enter engine capacity" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="co2_missions">* CO2 emissions</label> <input
										name="co2_missions" type="number" step="any"
										class="form-control" id="co2_missions"
										placeholder="Enter co2 missions" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Automatic transmission </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="automatic_transmission"
												id="automatic_transmission_radioM" value="manual"
												class="form-check-input" required> Manual <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="automatic_transmission"
												id="automatic_transmission_radioA" value="automactic"
												class="form-check-input" required> Automactic <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Left hand drive </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="left_hand_drive" id="left_hand_drive_radio1" value="1"
												class="form-check-input" required> Yes <span class="circle">
													<span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="left_hand_drive" id="left_hand_drive_radio0" value="0"
												class="form-check-input" required> No <span class="circle">
													<span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Blue badge adapted </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="blue_badge_adapted" id="blue_badge_adapted_radio1"
												value="1" class="form-check-input" required> Yes <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="blue_badge_adapted" id="blue_badge_adapted_radio0"
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
									<label for="doors">* Doors</label> <input name="doors"
										type="number" class="form-control" id="doors"
										placeholder="Enter doors" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="modification">* Modification</label>
									<textarea name="modification" rows="5" class="form-control"
										id="modification" placeholder="Enter modification" required></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="security_device">* Security device</label> <input
										name="security_device" type="text" class="form-control"
										id="security_device" placeholder="Enter security device"
										required>
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
	$("#country_of_registeration_select").select2({ allowClear: true,placeholder:'Select country'}).trigger('change');
	$("#body_type_select").select2({ allowClear: true,placeholder:'Select body type'}).trigger('change');
	$("#fuel_type_select").select2({ allowClear: true,placeholder:'Select fuel type'}).trigger('change');
	$("#ai_classification_select").select2({ allowClear: true,placeholder:'Select classification'}).trigger('change');
	$("#vehicle_use_select").select2({ allowClear: true,placeholder:'Select vehicle use'}).trigger('change');
	
	
	
	var world_countries_json = $.getJSON("{{asset('world_countries.json')}}", function(json) {
    	//console.log(json); // this will show the info it in firebug console
	});
	
	setTimeout(function (){

      // Something you want delayed.
      
	//console.log(world_countries_json.responseJSON);
	
	var world_countries_data = $.map(world_countries_json.responseJSON, function (obj) {
      obj.id = obj.alpha2 ; // replace pk with your identifier
      	obj.text = obj.name
      return obj;
    });
	
	$('#country_of_registeration_select').select2({
		allowClear: true,
        placeholder: 'Select country',
       
       data: world_countries_data
        
	}).trigger('change');
    
    }, 1000); // How long do you want the delay to be (in milliseconds)? 
	
	

    $("#registration_date").datetimepicker({
    		format: 'YYYY-MM-DD ',
    });
    
    $("#model_year").datetimepicker({
		 viewMode: 'years',
         format: 'YYYY',
         
    });
  	$('#model_year').on("dp.show", function(e) {
       $(e.target).data("DateTimePicker").viewMode("years"); 
    });
    
	

});



</script>

@endsection
