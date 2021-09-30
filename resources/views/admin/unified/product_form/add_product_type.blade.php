@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{asset('css/form-builder-custom-unified.css')}}">
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
</style>
@endsection @section('title','Unified | Add Product Type ')
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<form id="productTypeForm" method="POST"
						action="{{route('unified_postAddProductType', ['unified'])}}"
						@submit="onSubmitForm">
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Add Service Form.png')}}"
											style="">
									</div>
									<h4 class="card-title customerProfile">Add Product Type</h4>
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
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label>Name</label> <input type="text" class="form-control"
													name="product_type_name" placeholder="Name" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label style="display: table-cell;">Color</label> <input
													type="color" class="inputColor" name="borderColor"
													id="color" required onchange="changeColor()"> <input
													type="hidden" name="backgroundColor" id="backgroundColor">
												<div class="productColorDiv"></div>
											</div>
										</div>

									</div>

								</div>
							</div>
						</div>

						<div class="card">

							<div class="card-body cardBodyAddContactDetails">
								<div class="container containerFormBuilder" >
									<div class="row">
										<div class="col-md-12">
											<h5 class="card-title customerProfile">Properties</h5>
										</div>
									</div>
									<div class="">
									 <!-- <button id="getJSON" type="button">Get JSON Data</button> -->
										<div id="build-wrap"></div>
									</div>
								</div>
							</div>
						</div>
						
						<input type="hidden" name="form_builder_data" id="form_builder_data">

						<div class="row ">
							<div class="col-md-12 text-center">

								<button class="btn btn-unified-primary singlePageButton">Add</button>
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
<script src="{{asset('js/form-builder/form-builder.min.js')}}"></script>
<script src="{{asset('js/form-builder/form-render.min.js')}}"></script>
    
<script type="text/javascript">
/////////////// form builder options
//disableFields: allows you to define and array of fields that should not be made available to users.
//disabledAttrs: Disable attributes for all field types.
//disabledSubtypes: disable subtypes for fields
//When the option editOnAdd is set to true, fields will automatically enter edit mode when added to the stage.
//fieldRemoveWarn: warn user's if before the remove a field from the stage.
//typeUserDisabledAttrs: Disabled attributes for specific field types.

var formBuilder;

$( document ).ready(function() {
          	var fbEditor = document.getElementById('build-wrap');
          	
          	var options = {
          		//formData: '[{"type":"checkbox-group","required":false,"label":"Checkbox Group","toggle":false,"inline":false,"name":"checkbox-group0","values":[{"label":"Option 1","value":"option-1","selected":true}]},{"type":"date","required":false,"label":"Date Field","className":"form-control","name":"date-1632958746281-0"},{"type":"select","required":false,"label":"Select","className":"form-control","name":"select-1632958752846-0","multiple":false,"values":[{"label":"Option 1","value":"option-1","selected":true},{"label":"Option 2","value":"option-2","selected":false},{"label":"Option 3","value":"option-3","selected":false}]}]',
              	disabledActionButtons: ['data','save'],
                scrollToFieldOnAdd: true,
                 disableFields: [ 
                  'autocomplete',	
                  'button',
                  'header',
                  'hidden',
                  'paragraph'
                ],
                disabledAttrs: [
                    'access','other','className','value'
                ],
                typeUserDisabledAttrs: {
                    'textarea': [
                      'subtype'
                    ],
                     'file': [
                      'subtype'
                    ],
                  },
                editOnAdd: true, 
                fieldRemoveWarn: true, // defaults to false
              	subtypes: {
                    text: ['datetime-local','time','month','url','address']
                },
//                  fields : [{
//                       label: "Email",
//                       type: "text",
//                       subtype: "email",
//                       icon: "<i class='far fa-envelope'></i>"
//                     },
//                     {
//                       label: "Address",
//                       type: "text",
//                       subtype: "address",
//                       icon: "<i class='fas fa-map-marker-alt'></i>"
//                   }],
//                    onAddField: function(fieldId,fieldData) {
// //                    		console.log(fieldId)
//                     		console.log(fieldData)
//                    		fieldData.name=fieldData.label.toLowerCase().replaceAll(" ","_")
//                       },
                    onAddOption: (optionTemplate, optionIndex) => {
                    	//console.log(optionTemplate)
                    	//console.log(optionIndex)
                       /*  optionTemplate.label = 'Option '+(optionIndex.index + 1)
                        optionTemplate.value = (optionIndex.index + 1) */
                        optionTemplate.selected = false
                        return optionTemplate
                      },   
            };
            
            
          	
  			formBuilder = $(fbEditor).formBuilder(options);
       
        
//         document.getElementById('getJSON').addEventListener('click', function() {
//             console.log(formBuilder.actions.getData('json'));
//             console.log(JSON.parse(formBuilder.actions.getData('json')));
//           }); 
          
       
      
});

   var app = new Vue({
            el: '#app',
            data() {
            },
            mounted() {
            },
            methods: {
            	onSubmitForm(e){
            		 e.preventDefault();
            		$("#form_builder_data").val(formBuilder.actions.getData('json')); 
            		console.log(formBuilder.actions.getData('json'))
//     				setTimeout(() => {
//     					$('#productTypeForm').submit();
//     				}, 300);
            	}
            }
        });  

function changeColor(){
	var colorVal = $("#color").val();
	var colorValBackground = colorVal+"26";
	console.log(colorVal)
	console.log(colorValBackground)
	$(".productColorDiv").css("background",colorValBackground);
	$(".productColorDiv").css("border-color",colorVal);
	
	$("#backgroundColor").val(colorValBackground)
}

    </script>
@endsection
