@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<style>
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_driver')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Driver</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="name">* First name</label> <input name="first_name"
										type="text" class="form-control" id="first_name"
										placeholder="Enter first name" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="name">* Last name</label> <input name="last_name"
										type="text" class="form-control" id="last_name"
										placeholder="Enter last name" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="sex_select">* Sex</label> <select id="sex_select"
										name="sex" class="form-control" required><option value="">Select
											sex</option> @foreach($sexList as $sex)
										<option value="{{$sex->id}}">{{$sex->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="date_of_birth">* Date of birth</label> <input
										name="date_of_birth" type="text" class="form-control"
										id="date_of_birth" placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">* Is primary driver? </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="is_primary_driver" id="is_primary_driver_radioPr"
												value="primary" class="form-check-input" required> Primary driver <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="is_primary_driver" id="is_primary_driver_radioPe"
												value="permitted" class="form-check-input" required> Permitted driver <span
												class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label >* Licence</label>
								</div>
							</div>


						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="no_claims_bonus">* No claims bonus</label> <input name="doors"
										type="number" class="form-control" id="no_claims_bonus"
										placeholder="Enter no claims bonus" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label >* Conviction</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label >* Medical conditon</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="disablility">* Disablility</label> <input name="disablility"
										type="text" class="form-control" id="disablility"
										placeholder="Enter disablility" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="loading">* Loading</label> <input name="loading"
										type="number" step="any" class="form-control" id="loading"
										placeholder="Enter loading" required>
								</div>
							</div><div class="col-md-6">
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
						</div>
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="non_motor_conviction">* Non motor conviction</label> <input name="non_motor_conviction"
										type="text" class="form-control" id="non_motor_conviction"
										placeholder="Enter non motor conviction" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="pleasure_miles">* Pleasure miles</label> <input name="pleasure_miles"
										type="number" class="form-control" id="pleasure_miles"
										placeholder="Enter pleasure miles" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="business_miles">* Business miles</label> <input name="business_miles"
										type="number" class="form-control" id="business_miles"
										placeholder="Enter business miles" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="work_status_select" class="formLabel">* Work status</label>
									<select id="work_status_select" name="work_status"
										class="form-control" required><option value="">Select status</option> @foreach($workStatusList as $wStatus)
										<option value="{{$wStatus->id}}">{{$wStatus->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="occupation_select">* Occupation</label> <select
										id="occupation_select" name="occupation" class="form-control"
										required><option value="">Select occupation</option>

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_select" class="formLabel">* Vehicle </label>
									<select id="vehicle_select" name="vehicle"
										class="form-control" required><option value="">Select vehicle
											</option> @foreach($vehicles as $vehicle)
										<option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
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
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script type="text/javascript">
  

$(document).ready(function() {
	$("#sex_select").select2({ allowClear: true,placeholder:'Select sex'}).trigger('change');
	$("#occupation_select").select2({ allowClear: true,placeholder:'Select occupation'}).trigger('change');
	$("#vehicle_select").select2({ allowClear: true,placeholder:'Select vehicle'}).trigger('change');
	$("#work_status_select").select2({ allowClear: true,placeholder:'Select work status'}).trigger('change');
	
	var test1 = $.getJSON("{{asset('world_countries.json')}}", function(json) {
    	console.log(json); // this will show the info it in firebug console
	});
	
	setTimeout(function (){

      // Something you want delayed.
      
	console.log(test1.responseJSON);
	
	var data = $.map(test1.responseJSON, function (obj) {
      obj.id = obj.alpha2 ; // replace pk with your identifier
      	obj.text = obj.name
      return obj;
    });
	
	$('#nationality_select').select2({
		allowClear: true,
        placeholder: 'Select nationality',
       
       data:data
        
	}).trigger('change');
    
    }, 1000); // How long do you want the delay to be (in milliseconds)? 
	
	/////// language
	var language_codes_full_json = $.getJSON("{{asset('language-codes-full_json.json')}}", function(json) {
    	console.log(json); // this will show the info it in firebug console
	});
	setTimeout(function (){

      // Something you want delayed.
      
	console.log(language_codes_full_json.responseJSON);
	
	var dataLanguage = $.map(language_codes_full_json.responseJSON, function (obj) {
      obj.id = obj.alpha3_b ; // replace pk with your identifier
      	obj.text = obj.English
      return obj;
    });
	
	$('#policy_holder_preferred_language_select').select2({
		allowClear: true,
        placeholder: 'Select language',
       
       data:dataLanguage
        
	}).trigger('change');
    
    }, 1000); // How long do you want the delay to be (in milliseconds)? 
    ////////////

    $("#date_of_birth").datetimepicker({
    		format: 'YYYY-MM-DD ',
    });
    
    
	addIntelInput('mobile_phone','mobile_phone');
	addIntelInput('phone','phone');

});



function addIntelInput(input_id, input_name) {
            let phone_input = document.querySelector("#" + input_id);
            window.intlTelInput(phone_input, {
                hiddenInput: input_name,
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
        }

</script>
@endsection
