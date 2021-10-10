@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet"
	href="{{asset('css/form-builder-custom-unified.css')}}">
<style>
.iti {
	width: 100%;
}

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}

.card-title.customerProfile {
	display: inline-block;
}

.addContactDetailsCircle {
	color: #d58242;
	font-size: 18px;
}

.removeContactDetailsCircle {
	color: #df5353;
	font-size: 18px;
}

.inputColor {
	width: 50%;
	padding: 5px 8px;
	height: 40px;
	border: none;
	background: transparent;
	display: inline-block;
}

.productColorDiv {
	border-left: 4px solid #000000;
	background-color: #00000034;
	min-height: 38px;
	width: 30px;
	display: inline-block;
}

input[type=color] {
	width: 50%;
	padding: 5px 8px;
	height: 40px;
	border: none;
	background: transparent;
	/* display: inline-block; */
}
.form-check .form-check-input:checked~.form-check-sign .check{
    background: #d58242 !important;
    border-color:#d58242; 
}
/* .form-check .form-check-sign .check:before { */
/* margin-top: -4px; */
/* margin-left: 6px */
/* } */
/* .form-check .form-check-sign .check{ */
/*     width: 17px;  */
/*     height: 17px */
/* } */
.form-group.is-focused .togglebutton label, .togglebutton label{
    color: #aaa !important;
}
/* .form-check .form-check-label span { */
/*     top:0; */
/* } */
.uploadButton{
    height: 38px !important;
    margin-top: 0;
    box-shadow: 0px 2px 4px rgb(182 182 182 / 50%), 2px 2px 5px #ffffff;
    background-color: white !important;
}
.btn.btn-fab.uploadButton{
    line-height: 0 !important;
}
.uploadButton img{
    width: 35px;
}


.togglebutton {
	margin-top: -3px;
}

.togglebutton label .toggle, .togglebutton label input[type=checkbox][disabled]+.toggle
	{
	width: 45px;
	height: 20px;
	/* margin-left: 30px; */
	background-color: #656565
}

.togglebutton label input[type=checkbox]+.toggle:after {
	border-color: #656565;
}

.togglebutton label input[type=checkbox]:checked+.toggle {
	background-color: #d58242;
}

.togglebutton label .toggle:after {
	box-shadow: none;
	left: 0;
	/* top: -5px; */
	top:0;
}


.togglebutton label input[type=checkbox]:checked+.toggle:after {
	border-color: #d58242;
	left: 24px;
}
.togglebutton .form-check-label {
    padding-left: 55px
}

.tooltip-element {
    visibility: visible;
    color: #fff;
   
    border-radius: 8px;
    display: inline-block;
    text-align: center;
    line-height: 16px;
    margin: 0 5px;
    font-size: 12px;
    cursor: default;
    
    background: #d58242 !important;
    font-size: 13px !important;
    font-weight: 700;
    padding: 2px;
    width: 18px !important;
    height: 18px !important;
}
.errorMessage{
    color: red;
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 0;
    display: none; 
}
.errorMessage p {
    margin-bottom: 0;
}
form .form-group select.form-control {
	top: 55px;
	left: 50%;
}
.file-url-container {
    padding: 8px 6px;
    border-radius: 9px;
    border: solid 1px #e3e3e3;
    background-color: #ffffff;
    font-size: 14px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: 0.5;
    letter-spacing: 0.77px;
    color: #656565;
    margin-top: 5px;
}
.file-url-container i {
    font-size: 20px;
}    
</style>
@endsection @section('title','Unified | Add Product Form ')
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<form id="productFormCustomerForm" method="POST" enctype="multipart/form-data"
						action="{{route('unified_postAddProductForm', ['unified'])}}"
						@submit="onSubmitForm" autocomplete="off">
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Add Service Form.png')}}"
											style="">
									</div>
									@if(isset($customer))
										<h4 class="card-title">
        									<span class="card-title-grey">Add Product Form /</span>
        									{{$customer->name}}
        								</h4>
									@else
										<h4 class="card-title" >Add Product Form</h4>
									@endif
								</div>

							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											@if(count($errors))
											<div class="alert alert-danger" role="alert">
												<ul>
													@foreach ($errors->all() as $error)
													<li>{{$error}}</li> @endforeach
												</ul>
											</div>
											@endif
										</div>
									</div>

									<div class="row">
										@if(isset($customers))
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Customer</label> <select name="customer_id"
													class="form-control customerSelect2" id="customerSelect"
													onchange="changeCustomer()" required>
													<option value="" selected class="placeholdered">Select
														customer</option> @if(count($customers) > 0)
													@foreach($customers as $customer)
													<option value="{{$customer->id}}">{{$customer->name}}</option>
													@endforeach @endif
												</select>
											</div>
										</div>
										
										@elseif(isset($customer))
										 <input type="hidden" name="customer_id" id="customerSelect" value="{{$customer->id}}">
										@endif 
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Product type</label> <select class="form-control"
													id="productTypeSelect" name="productTypeSelect" required
													onchange="changeProductType()">
													<option value="" selected class="placeholdered">Select
														product type</option>
													
													@if(isset($serviceTypes))
    													
        													@foreach($serviceTypes as $type)
        														<option value="{{$type->id}}">{{$type->name}}</option>
        													@endforeach 
													@endif
														
												</select>
											</div>
										</div>

									</div>
									
									<div class="row mt-2">
										<div class="col-md-6" v-for="(property, index) in productTypeProperties">
											
											<div class="form-group bmd-form-group" v-if="property.type=='text'">
												<label> <span v-if="property.required">*</span> @{{property.label}}</label> 
												<span class="tooltip-element" v-if="property.description" :title="property.description" data-toggle="tooltip">?</span>
												<input v-if="property.subtype=='tel'" type="text" class="form-control phoneInputType" :name="property.name"
													 :required="property.required" :value="property.selected_value"/>
												<input v-else-if="property.subtype=='datetime-local'" type="text" class="form-control dateTimeInputType" :name="property.name" 
													 :required="property.required"  :placeholder="property.placeholder"  :value="property.selected_value"/>
												<input v-else-if="property.subtype=='time'" type="text" class="form-control timeInputType" :name="property.name"  
													:required="property.required" :placeholder="property.placeholder" :value="property.selected_value"/>
												<input v-else-if="property.subtype=='month'" type="text" class="form-control monthInputType" :name="property.name"  
													:required="property.required" :placeholder="property.placeholder" :value="property.selected_value"/>
												<input v-else-if="property.subtype=='address'" type="text" class="form-control addressInputType" :name="property.name" :id="property.name"
													 :required="property.required" :placeholder="property.placeholder" :value="property.selected_value"/>
												<input v-else :type="property.subtype" class="form-control" :name="property.name" autocomplete="off" 
													:required="property.required" :maxlength="property.maxlength" :placeholder="property.placeholder"
													:value="property.selected_value"/>
												
												<input v-if="property.subtype=='address'" type="hidden" :name="property.name+'_coordinates'" :id="property.name+'_coordinates'" 
														:value="property.coordinates">
											</div>
											<div class="form-group bmd-form-group" v-else-if="property.type=='date'">
												<label> <span v-if="property.required">*</span> @{{property.label}}</label>
												<span class="tooltip-element" v-if="property.description" :title="property.description" data-toggle="tooltip">?</span>
												<input type="text" class="form-control dateInputType" :name="property.name" :required="property.required" 
												 :placeholder="property.placeholder" :value="property.selected_value"/>
											</div>
											<div class="form-group bmd-form-group" v-else-if="property.type=='number'">
												<label> <span v-if="property.required">*</span> @{{property.label}}</label>
												<span class="tooltip-element" v-if="property.description" :title="property.description" data-toggle="tooltip">?</span>
												<input type="number" class="form-control" :name="property.name" :step="property.step" :min="property.min" 
													:max="property.max" :required="property.required" :placeholder="property.placeholder" :value="property.selected_value"/>
											</div>
											<div class="form-group bmd-form-group" v-else-if="property.type=='textarea'">
												<label> <span v-if="property.required">*</span> @{{property.label}}</label>
												<span class="tooltip-element" v-if="property.description" :title="property.description" data-toggle="tooltip">?</span>
												<textarea class="form-control" :name="property.name" :rows="property.rows" 
												:required="property.required" :maxlength="property.maxlength" :placeholder="property.placeholder">@{{property.selected_value}}</textarea>
											</div>	
											<div class="form-group bmd-form-group" v-else-if="property.type=='select'">
												<label> <span v-if="property.required">*</span> @{{property.label}}</label>
												<span class="tooltip-element" v-if="property.description" :title="property.description" data-toggle="tooltip">?</span>
												<select :name="property.multiple ? property.name+'[]' : property.name" class="form-control selectInputType"
													:multiple="property.multiple" :required="property.required"
													:data-placeholder="property.placeholder ? property.placeholder : 'Select option(s)'"
													:data-value="property.selected_value"
													>
														<option v-if="property.placeholder && property.multiple==false" value="" selected class="placeholdered">@{{property.placeholder}} </option>	
														<option v-else-if="!property.placeholder && property.multiple==false" value="" selected class="placeholdered">Select option</option> 
														<option v-for="item in property.values" :value="item.value" 
														>@{{item.label}}</option>	
												</select>
											</div>
											<div class=" row" style="margin-top: 15px" v-else-if="property.type=='radio-group'">
            									<label class="labelRadio col-12" for=""> <span v-if="property.required">*</span> @{{property.label}} 
												<span class="tooltip-element" v-if="property.description" :title="property.description" data-toggle="tooltip">?</span> </label>
            									<div v-if="property.required" :id="property.name+'_errorMessage'" class="col-12 errorMessage"><p>Please select one option</p></div>
            									<div :class="property.required ? 'col-12 row requiredRadioInput ' : 'col-12 row '  "
            										:data-inputname="property.name">
            										<div class="col-6" v-for="item in property.values">
            											<div class="form-check form-check-radio">
            												<label class="form-check-label"> 
            													<input v-if="item.value==property.selected_value"
                													class="form-check-input " type="radio"
                													:name="property.name" :value="item.value"
                													:id="property.name+'_'+item.value"  checked>
            													 <input v-else
                													class="form-check-input " type="radio"
                													:name="property.name" :value="item.value"
                													:id="property.name+'_'+item.value"  > 
            													@{{item.label}} <span class="circle"> <span class="check"></span> </span>
            												</label>
            											</div>
            										</div>
            									</div>
            								</div>
            								<div class=" row" style="margin-top: 15px" v-else-if="property.type=='checkbox-group'">
            									<label class="labelRadio col-12" for=""> <span v-if="property.required">*</span> @{{property.label}} 
												<span class="tooltip-element"  v-if="property.description" :title="property.description" data-toggle="tooltip">?</span> </label>
            									<div v-if="property.required" :id="property.name+'_errorMessage'" class="col-12 errorMessage"><p>Please select at least one option</p></div>
            									<div :class="property.required ? 'col-12 row requiredCheckboxInput ' : 'col-12 row '  "
            										:data-inputname="property.name" v-if="property.toggle==false">
            										<div class="col-6" v-for="item in property.values">
            											<div class="form-check form-check-radio">
            												<label class="form-check-label"> <input
            													class="form-check-input" type="checkbox"
            													:name="property.name+'[]'" :value="item.value" data-toggle="switch"
            													:id="property.name+'_'+item.value"
            													:checked="property.selected_value.includes(item.value)"> 
            													@{{item.label}} <span class="form-check-sign"> <span class="check"></span> </span>
            												</label>
            											</div>
            										</div>
            									</div>
            									<div :class="property.required ? 'col-12 row requiredCheckboxInput ' : 'col-12 row '  " 
            										:data-inputname="property.name" v-else>
            										<div class="col-6" v-for="item in property.values">
            											<div class="form-check form-check-radio togglebutton">
            												<label class="form-check-label"> <input
            													type="checkbox"
            													:name="property.name+'[]'" :value="item.value" 
            													:id="property.name+'_'+item.value"
            													:checked="property.selected_value.includes(item.value)">  
            													 <span class="toggle"></span>
            													@{{item.label}} 
            												</label>
            											</div>
            										</div>
            									</div>
            								</div>	
            								<div class="form-group bmd-form-group form-file-upload"
            									 v-else-if="property.type=='file'">
												<label> <span v-if="property.required">*</span> @{{property.label}}</label>
												<span class="tooltip-element"  v-if="property.description" :title="property.description" data-toggle="tooltip">?</span>
												<input :id="property.name" :multiple="property.multiple"
                    								:name="property.name" type="file" class="inputFileHidden"
                    								@change="onChangeFile($event, property.name+'_text')" >
                    							<div class="input-group" @click="addFile(property.name)">
                    								<textarea  :id="property.name+'_text'"
                    									class="form-control inputFileVisible"
                    									:placeholder="property.placeholder ? property.placeholder : 'Upload files'" 
                    									v-if="property.multiple==true" :required="property.required"></textarea>
                    								<input type="text" :id="property.name+'_text'"
                    									class="form-control inputFileVisible"
                    									:placeholder="property.placeholder ? property.placeholder : 'Upload file'" 
                    									v-else :required="property.required"> 	
                    									
                    									<span
                    									class="input-group-btn">
                    									<button type="button" class="btn btn-fab btn-round btn-light uploadButton">
                    										<img src="{{asset('images/unified/upload-orange.png')}}"
                    											alt="upload icon" />
                    									</button>
                    								</span>
                    							</div>
                    							
                    								<a target="_blank" v-for="(item,index) in property.selected_value" 
                    									:href="'{{asset('/')}}'+item"
														class="mt-1">
														<div class="file-url-container d-flex">
															<i class="fas fa-file"></i>
															<p class=" pl-xl-3  pl-2 my-md-2 my-sm-3 my-2">Download file @{{index+1}}</p>
														</div>
													</a>
											</div>	
											<div v-else>@{{property.label}}</div>	
											
											
											
										</div>
									</div>


								</div>
							</div>
						</div>
						<div class="row ">
							<div class="col-md-12 text-center">

								<button class="btn btn-unified-primary singlePageButton">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection @section('page-scripts')

<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>

<script type="text/javascript">

$( document ).ready(function() {
	$(".customerSelect2,#productTypeSelect").select2({});
	
	
});

       var app = new Vue({
       		
            el: '#app',
            
            data: {
            	productTypeProperties: []
            },
    		computed() {
    			console.log("saada")
    		},
    		methods: {
    			onSubmitForm(e){
    				 e.preventDefault();
    				 
    				 var divs = $('.requiredRadioInput')
                    // console.log(divs);
                    for(var i=0; i<divs.length; i++){
                     	// console.log(divs[i])
                    	var inputname= $(divs[i]).data('inputname');
                     	// console.log("#"+inputname+"_errorMessage")
                     	console.log($("input[name='"+inputname+"']:checked"))
                     	console.log($("input[name='"+inputname+"']:checked").val())
                     	// console.log($("#"+inputname+"_errorMessage"))
                    	if($("input[name='"+inputname+"']:checked").val()=== null || $("input[name='"+inputname+"']:checked").val()=== undefined){
                          	$("#"+inputname+"_errorMessage").css("display","block");
  							$('html, body').animate({ scrollTop: $("#"+inputname+"_errorMessage").offset().top }, 'slow');
                          	return false;
                        }else{
                          	$("#"+inputname+"_errorMessage").css("display","none");
                        }
                    }
                    
                    console.log("---------------------")
                    
                    var checkboxDivs = $('.requiredCheckboxInput')
                    console.log(checkboxDivs)
                    for(var i=0; i<checkboxDivs.length; i++){
                    	console.log(checkboxDivs[i])
                     	console.log($(checkboxDivs[i]).data('inputname'))
                     	var inputname= $(checkboxDivs[i]).data('inputname');
                     	console.log(inputname)
                     	console.log($("input[name='"+inputname+"[]']:checked"))
                     	console.log($("input[name='"+inputname+"[]']:checked").val())
                     	if($("input[name='"+inputname+"[]']:checked").val()=== null || $("input[name='"+inputname+"[]']:checked").val()=== undefined){
                          	$("#"+inputname+"_errorMessage").css("display","block");
  							$('html, body').animate({ scrollTop: $("#"+inputname+"_errorMessage").offset().top }, 'slow');
                          	return false;
                        }else{
                          	$("#"+inputname+"_errorMessage").css("display","none");
                        }
                    }
                    
                    //return false;
            		
    				setTimeout(() => {
    					$('#productFormCustomerForm').submit();
    				}, 300);
    			
    		   	},
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e ,id) {
                	console.log(e.target.files)
                	if(e.target.files.length==1){
                    	$("#" + id).val(e.target.files[0].name);
                    }else{
                    	var fileNames = e.target.files[0].name;
                    	for(var i=1; i<e.target.files.length;i++){
                    		fileNames += "\n"+e.target.files[i].name;
                    	}
                    	$("#" + id).val(fileNames)
                    }
                },
    		}
    });


function changeCustomer(){
	var customerId = $("#customerSelect").val();
	console.log(customerId);
	var token ='{{csrf_token()}}';
	
	app.productTypeProperties = [];
	
	 $.ajax({
        type: "POST",
        method:"post",
       	url: '{{url("unified/customers/get_customer_product_types/")}}',
       	data: {_token: token, customerId: customerId},
        success: function(data) {
       
            console.log(data);
            var productTypesOptions = '<option value="" selected class="placeholdered">Select product type</option>';
            for(var i=0; i<data.productTypes.length; i++){
            	productTypesOptions += '<option value="'+data.productTypes[i].id+'">'+data.productTypes[i].name+'</option>';
            }
            $("#productTypeSelect").html(productTypesOptions)
                       
        }
    });
}

function changeProductType(){
	var productTypeId = $("#productTypeSelect").val();
	var customerId = $("#customerSelect").val();
	console.log(customerId +" " +productTypeId);
	var token ='{{csrf_token()}}';
	app.productTypeProperties = [];
	
	 $.ajax({
        type: "POST",
        method:"post",
       	url: '{{url("unified/customers/get_product_type_fields/")}}',
       	data: {_token: token, productTypeId: productTypeId, customerId: customerId},
        success: function(data) {
       
            console.log(data);
            console.log(data.formFields);
            console.log(JSON.parse(data.formFields))
            app.productTypeProperties = JSON.parse(data.formFields);
            
            
            setTimeout(() => {
            	addIntlPhoneInput();
            	$(".dateTimeInputType").datetimepicker({
                          icons: { time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
            				}
         		});
         		 $('.timeInputType').datetimepicker({
                         format: 'LT', 
                          icons: { time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
            				}
         		});
         		 $('.monthInputType').datetimepicker({
                        viewMode: 'years',
         				format: 'MMM YYYY',
         		});
         		$('.dateInputType').datetimepicker({
                         format: 'L', 
                          icons: { time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
            				}
         		});
         		$('.monthInputType').on("dp.show", function(e) {
                   $(e.target).data("DateTimePicker").viewMode("months"); 
                });
                
                var addressInputs = document.getElementsByClassName("addressInputType");
                for(var i=0; i<addressInputs.length; i++){
                	initAutoComplete(addressInputs[i],addressInputs[i].id+'_coordinates')
                }
                
                $(".selectInputType").select2({ allowClear: true});
                 $.each($(".selectInputType"), function(){
                 	console.log(typeof $(this).data('value'))
                        //$(this).select2('val', ''+$(this).data('value'));
                        if($(this).data('value') != null){
                           	$(this).val( $(this).data('value').split(","));
    						$(this).trigger('change');
    					}	
                });
         		
    		}, 300);
                       
        }
    });
}

function addIntlPhoneInput(){
	var phoneInputs = document.getElementsByClassName("phoneInputType");
	for(var i=0; i<phoneInputs.length; i++){
		//console.log(phoneInputs[i])
		intlTelInput(phoneInputs[i], {
				   initialCountry: 'IE',
				   separateDialCode: true,
				   preferredCountries: ['IE', 'GB'],
				   utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
			   });
	}
}

 //Map Js
		function initAutoComplete(location_input,address_coordinates_id) {
			//Autocomplete Initialization
			//let location_input = document.getElementById(inputId);
			//Mutation observer hack for chrome address autofill issue
			let observerHackAddress = new MutationObserver(function() {
				observerHackAddress.disconnect();
				location_input.setAttribute("autocomplete", "new-password");
			});
			observerHackAddress.observe(location_input, {
				attributes: true,
				attributeFilter: ['autocomplete']
			});
			let autocomplete_location = new google.maps.places.Autocomplete(location_input);
			autocomplete_location.setComponentRestrictions({'country': ['ie']});
			autocomplete_location.addListener('place_changed', () => {
				let place = autocomplete_location.getPlace();
				if (!place.geometry) {
					// User entered the name of a Place that was not suggested and
					// pressed the Enter key, or the Place Details request failed.
					window.alert("No details available for input: '" + place.name + "'");
				} else {
					let place_lat = place.geometry.location.lat();
					let place_lon = place.geometry.location.lng();

					document.getElementById(address_coordinates_id).value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
				}
			});
		}
</script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initAutoComplete"></script>
@endsection
