@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.min.css">
<style>
.singleViewSubTitleH5 {
	font-size: 16px;
	font-weight: 400;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.19;
	letter-spacing: 0.8px;
	color: #4d4d4d;
}

.vue-treeselect__control {
	border: none !important;
	margin-top: -6px;
}


.vue-treeselect__menu {
	font-size: 13px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: normal;
	color: #494949;
}

.vue-treeselect__menu li:hover {
	background: #e8ca49;
	font-weight: bold;
	color: white;
	box-shadow: none !important;
}

.vue-treeselect__menu li:hover .vue-treeselect__label,
	.vue-treeselect__option--highlight .vue-treeselect__label,
	.vue-treeselect--single .vue-treeselect__option--selected .vue-treeselect__label
	{
	/* font-weight: bold !important; */
	color: white !important;
	box-shadow: none !important;
}

.vue-treeselect__option--highlight, .vue-treeselect--single .vue-treeselect__option--selected
	{
	background: #5897fb !important;
	font-weight: bold !important;
	color: white !important;
	box-shadow: none !important;
}
.vue-treeselect__indent-level-0 .vue-treeselect__option {
	padding: 5px
}

.vue-treeselect__indent-level-1 {
	margin-left: 8px;
}

.vue-treeselect__indent-level-2 {
	margin-left: 8px;
}

.vue-treeselect__indent-level-3 {
	margin-left: 10px;
}

.vue-treeselect__indent-level-4 {
	margin-left: 12px;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('open_insurance/save_driver')}}"
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
									<label for="first_name">* First name</label> <input
										name="first_name" type="text" class="form-control"
										id="first_name" placeholder="Enter first name" required>
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
												value="primary" class="form-check-input" required> Primary
												driver <span class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="is_primary_driver" id="is_primary_driver_radioPe"
												value="permitted" class="form-check-input" required>
												Permitted driver <span class="circle"> <span class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="no_claims_bonus">* No claims bonus</label> <input
										name="no_claims_bonus" type="number" class="form-control"
										id="no_claims_bonus" placeholder="Enter no claims bonus"
										required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="disablility">* Disablility</label> <input
										name="disablility" type="text" class="form-control"
										id="disablility" placeholder="Enter disablility" required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="loading">* Loading</label> <input name="loading"
										type="number" step="any" class="form-control" id="loading"
										placeholder="Enter loading" required>
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
									<label for="non_motor_conviction">* Non motor conviction</label>
									<input name="non_motor_conviction" type="text"
										class="form-control" id="non_motor_conviction"
										placeholder="Enter non motor conviction" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="pleasure_miles">* Pleasure miles</label> <input
										name="pleasure_miles" type="number" class="form-control"
										id="pleasure_miles" placeholder="Enter pleasure miles"
										required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="business_miles">* Business miles</label> <input
										name="business_miles" type="number" class="form-control"
										id="business_miles" placeholder="Enter business miles"
										required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="work_status_select" class="formLabel">* Work status</label>
									<select id="work_status_select" name="work_status"
										class="form-control" required><option value="">Select status</option>
										@foreach($workStatusList as $wStatus)
										<option value="{{$wStatus->id}}">{{$wStatus->name}}</option>
										@endforeach

									</select>
								</div>
							</div>


							<!-- <div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="occupation_select">* Occupation</label> <select
										id="occupation_select" name="occupation" class="form-control"
										required><option value="">Select occupation</option>

									</select>
								</div>
							</div> -->
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="occupation_select">* Occupation </label>

									<div id="component_occupation_select">
										<template>
											<treeselect class="form-control" v-model="occupation"
												name="occupation" id="occupation" placeholder="Select type"
												:multiple="false" :options="options" :clearable="true"
												:searchable="true" :openOnClick="true"
												:disable-branch-nodes="true" :closeOnSelect="true"
												:flat="true" :open-on-focus="true" :always-open="false"
												:normalizer="normalizer" required>
											<div slot="value-label" slot-scope="{ node }">@{{node.raw.customLabel}}</div>

											</treeselect>
										</template>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="vehicle_select" class="formLabel">* Vehicle </label>
									<select id="vehicle_select" name="vehicle" class="form-control"
										required><option value="">Select vehicle</option>
										@foreach($vehicles as $vehicle)
										<option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
						</div>
					</div>


				</div>

				<div class="card">
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 ">
								<h5 class="singleViewSubTitleH5">Licence</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="licence_number">* Licence number</label> <input
										name="licence_number" type="text" class="form-control"
										id="licence_number" placeholder="Enter licence number"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="licence_issue_date">* Issue date</label> <input
										name="licence_issue_date" type="text" class="form-control"
										id="licence_issue_date" placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="licence_expiry_date">* Expiry date</label> <input
										name="licence_expiry_date" type="text" class="form-control"
										id="licence_expiry_date" placeholder="Enter date" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="licence_country_select">* Country</label> <select
										id="licence_country_select" name="licence_country"
										class="form-control" required>
										<option value="">Select country</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="licence_category">* Licence category</label> <input
										name="licence_category" type="text" class="form-control"
										id="licence_category" placeholder="Enter licence category"
										required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="licence_codes">* Licence codes</label> <input
										name="licence_codes" type="text" class="form-control"
										id="licence_codes" placeholder="Enter licence codes" required>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 ">
								<h5 class="singleViewSubTitleH5">Conviction</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_offence_date">Offence date</label> <input
										name="conviction_offence_date" type="text"
										class="form-control" id="conviction_offence_date"
										placeholder="Enter date">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_offence_code_select" class="formLabel">Offence
										code </label> <select id="conviction_offence_code_select"
										name="conviction_offence_code" class="form-control"><option
											value="">Select offence code</option> @foreach($offenceCodes as $code)
										<option value="{{$code->id}}">{{$code->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_date">Date</label> <input
										name="conviction_date" type="text" class="form-control"
										id="conviction_date" placeholder="Enter date">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_points">Points</label> <input
										name="conviction_points" type="number" class="form-control"
										id="conviction_points" placeholder="Enter points">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_fine">Fine</label> <input
										name="conviction_fine" type="number" step="any"
										class="form-control" id="conviction_fine"
										placeholder="Enter fine">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_fine_currency_select" class="formLabel">Fine
										currency </label> <select id="conviction_fine_currency_select"
										name="conviction_fine_currency" class="form-control"><option
											value="">Select fine currency</option> @foreach($currencies as $currency)
										<option value="{{$currency->id}}">{{$currency->name}}</option>
										@endforeach
									</select>
								</div>
							</div>


						</div>
						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">Suspension </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="conviction_suspension"
												id="conviction_suspension_radio1" value="1"
												class="form-check-input"> Yes <span class="circle"> <span
													class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="conviction_suspension"
												id="conviction_suspension_radio0" value="0"
												class="form-check-input"> No <span class="circle"> <span
													class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="conviction_suspension_length">Suspension length</label>
									<input name="conviction_suspension_length" type="number"
										class="form-control" id="conviction_suspension_length"
										placeholder="Enter suspension length">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body ">
						<div class="row">
							<div class="col-md-12 ">
								<h5 class="singleViewSubTitleH5">Medical Condition</h5>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="medical_notifiable_condition_select"
										class="formLabel">Notifiable condition </label> <select
										id="medical_notifiable_condition_select"
										name="medical_notifiable_condition" class="form-control"><option
											value="">Select notifiable condition</option>
										@foreach($notifiableConditions as $condition)
										<option value="{{$condition->id}}">{{$condition->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="medical_status">Status</label> <input
										name="medical_status" type="text" class="form-control"
										id="medical_status" placeholder="Enter status">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="medical_dvla_restriction">Medical DVLA restriction</label>
									<input name="medical_dvla_restriction" type="text"
										class="form-control" id="medical_dvla_restriction"
										placeholder="Enter medical DVLA restriction">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="medical_treatment">Medical treatment</label> <input
										name="medical_treatment" type="text" class="form-control"
										id="medical_treatment" placeholder="Enter medical treatment">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">Bypass operation </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="medical_bypass_operation"
												id="medical_bypass_operation_radio1" value="1"
												class="form-check-input"> Yes <span class="circle"> <span
													class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="medical_bypass_operation"
												id="medical_bypass_operation_radio0" value="0"
												class="form-check-input"> No <span class="circle"> <span
													class="check"></span>
											</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label class="formLabel">Insulin injected </label>
									<div class="radio-container row ml-0">
										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="medical_insulin_injected"
												id="medical_insulin_injected_radio1" value="1"
												class="form-check-input"> Yes <span class="circle"> <span
													class="check"></span>
											</span>
											</label>
										</div>

										<div
											class="col-6 form-check form-check-radio  d-flex justify-content-between">
											<label class="form-check-label"> <input type="radio"
												name="medical_insulin_injected"
												id="medical_insulin_injected_radio0" value="0"
												class="form-check-input"> No <span class="circle"> <span
													class="check"></span>
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
									<label for="medical_daily_insulin_units">Daily insulin units</label>
									<input name="medical_daily_insulin_units" type="number"
										class="form-control" id="medical_daily_insulin_units"
										placeholder="Enter daily insulin units">
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

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.umd.min.js"></script>

<script type="text/javascript">
  
Vue.use('vue-cascader-select');
        Vue.component('treeselect', VueTreeselect.Treeselect);
        var occupations_array=[];
               var app = new Vue({
            el: '#app',
            
             data: {
             	occupation: null,
        
                // define options
                options: occupations_array,
                
	      },
		   mounted() {
		   },
		   methods: {
    			normalizer(node) {
    			 	return {
    					id: node.id,
    					label: node.label,
    					customLabel: node.customLabel,
    					children: node.children,
    				}
    			},
      		}
        });
        /////////////////////////////////////

$(document).ready(function() {
	$("#sex_select").select2({ allowClear: true,placeholder:'Select sex'}).trigger('change');
	//$("#occupation_select").select2({ allowClear: true,placeholder:'Select occupation'}).trigger('change');
	$("#vehicle_select").select2({ allowClear: true,placeholder:'Select vehicle'}).trigger('change');
	$("#work_status_select").select2({ allowClear: true,placeholder:'Select work status'}).trigger('change');
	$("#conviction_offence_code_select").select2({ allowClear: true,placeholder:'Select offence code'}).trigger('change');
	$("#conviction_fine_currency_select").select2({ allowClear: true,placeholder:'Select fine currency'}).trigger('change');
	$("#medical_notifiable_condition_select").select2({ allowClear: true,placeholder:'Select notifiable condition'}).trigger('change');
	
	
	
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
	
	$('#licence_country_select').select2({
		allowClear: true,
        placeholder: 'Select country',
       
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
    
    var occupations_json = $.getJSON("{{asset('occupations.json')}}", function(json) {
    	console.log(json.Blad1); // this will show the info it in firebug console
	});
	
    setTimeout(function (){
    	console.log(occupations_json.responseJSON.Blad1);
    	var all_occupations = occupations_json.responseJSON.Blad1;
    	var level_1_Data,level_2_Data,level_3_Data,level_4_Data;
    	for(var i=0;i<all_occupations.length;i++){
    		//console.log(all_occupations[i]);
    		//console.log(all_occupations[i].level);
    		if(all_occupations[i].level=="1"){
    			level_1_Data = {
    					level: all_occupations[i].level,
    					id :all_occupations[i].CODE,
    					label :all_occupations[i].ENGLISH,
    					children:[]
    			};
    			occupations_array.push(level_1_Data);
    		}
    		if(all_occupations[i].level=="2"){
    			level_2_Data = {
    					level: all_occupations[i].level,
    					id :all_occupations[i].CODE,
    					label :all_occupations[i].ENGLISH,
    					children:[]
    			};
    			level_1_Data.children.push(level_2_Data);
    		}
    		if(all_occupations[i].level=="3"){
    			level_3_Data = {
    					level: all_occupations[i].level,
    					id:  all_occupations[i].CODE,
    					label :all_occupations[i].ENGLISH,
    					children:[]
    			};
    			level_2_Data.children.push(level_3_Data);
    		}
    		
    		if(all_occupations[i].level=="4"){
    			level_4_Data = {
    					level: all_occupations[i].level,
    					id:  all_occupations[i].CODE,
    					label: all_occupations[i].ENGLISH,
    					customLabel: all_occupations[i].ENGLISH,
    			};
    			level_3_Data.children.push(level_4_Data);
    		}
    	}
    	
    	console.log(occupations_array);
     }, 1000); // How long do you want the delay to be (in milliseconds)? 
     
        
    ///////////////

    $("#date_of_birth,#licence_issue_date,#licence_expiry_date,#conviction_offence_date,#conviction_date").datetimepicker({	
    		format: 'YYYY-MM-DD ',
    });
    

});



</script>
@endsection
