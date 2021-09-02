@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">
<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.min.css">
<style>
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
			<form id="customer-form" action="{{url('open_insurance/save_personal')}}"
				method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Personal</h4>
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
									<label for="salutation_select"> Salutation</label> <select
										id="salutation_select" name="salutation" class="form-control"><option
											value="">Select salutation</option> @foreach($salutations as
										$salutation)
										<option value="{{$salutation->id}}">{{$salutation->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="nationality_select">* Nationality</label> <select
										id="nationality_select" name="nationality"
										class="form-control" required>
										<option value="">Select nationality</option>
									</select>
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
									<label for="email">* Email</label> <input name="email"
										type="email" class="form-control" id="email"
										placeholder="Enter email" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="mobile_phone">* Mobile phone</label> <input
										name="mobile_phone" type="tel" class="form-control"
										id="mobile_phone" required>
								</div>
							</div>


						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="phone">Phone</label> <input name="phone" type="tel"
										class="form-control" id="phone">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="address">* Address</label> <input name="address"
										type="text" class="form-control" id="address"
										placeholder="Enter address" required> <input type="hidden"
										name="address_lat" id="address_lat" value=""> <input
										type="hidden" name="address_lon" id="address_lon" value="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="id_type_select">* ID type</label> <select
										id="id_type_select" name="id_type" class="form-control"
										required><option value="">Select type</option>
										@foreach($idTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="id_number">* ID number</label> <input
										name="id_number" type="text" class="form-control"
										id="id_number" placeholder="Enter ID number" required>
								</div>
							</div>
						</div>

						<div class="row">
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
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="policy_holder_preferred_language_select"> Policy
										holder preferred language</label> <select
										name="policy_holder_preferred_language" class="form-control"
										id="policy_holder_preferred_language_select">
										<option value="">Select language</option>

									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="product_select">* Product</label> <select
										id="product_select" name="product" class="form-control"
										required><option value="">Select product</option>
										@foreach($products as $product)
										<option value="{{$product->id}}">{{$product->name}}</option>
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

	$("#salutation_select").select2({ allowClear: true,placeholder:'Select salutation'}).trigger('change');
	$("#nationality_select").select2({ allowClear: true,placeholder:'Select nationality'}).trigger('change');
	$("#sex_select").select2({ allowClear: true,placeholder:'Select sex'}).trigger('change');
	$("#id_type_select").select2({ allowClear: true,placeholder:'Select type'}).trigger('change');
	//$("#occupation_select").select2({ allowClear: true,placeholder:'Select occupation'}).trigger('change');
	$("#policy_holder_preferred_language_select").select2({ allowClear: true,placeholder:'Select language'}).trigger('change');
	$("#product_select").select2({ allowClear: true,placeholder:'Select product'}).trigger('change');
	
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

        function initMap() {
            let address_input = document.getElementById('address');
            //Mutation observer hack for chrome address autofill issue
            let observerHackAddress = new MutationObserver(function() {
                observerHackAddress.disconnect();
				address_input.setAttribute("autocomplete", "new-password");
            });
            observerHackAddress.observe(address_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete = new google.maps.places.Autocomplete(address_input);
            autocomplete.setComponentRestrictions({'country': ['ie']});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                	
					console.log(place)
						let place_lat = place.geometry.location.lat();
						let place_lon = place.geometry.location.lng();
						document.getElementById("address_lat").value = place_lat.toFixed(5);
						document.getElementById("address_lon").value = place_lon.toFixed(5);
						//address_input.value = eircode_value.long_name;
						// if (customer_address_input.value != '') {
						//	address_input.value = place.formatted_address;
						// }
					
                }
            });

           
           
        }
</script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>

@endsection
