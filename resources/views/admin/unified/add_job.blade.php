@extends('templates.dashboard') @section('page-styles')

<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet"
	href="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Turn-Radio-Buttons-Checkboxes-Into-Labels-zInput/zInput_default_stylesheet.css">

<link rel="stylesheet"
	href="{{asset('css/unified-calendar-styles.css')}}">

<style>
.select2-container--default .select2-selection--single .select2-selection__arrow
	{
	top: 20%;
}
</style>
@endsection @section('title', 'Unified | Schedule A Job')
@section('page-content')
<div class="content px-0 px-md-3">
	<div class="container-fluid px-0 px-md-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<form id="addScheduledJob" method="POST"
						action="{{route('unified_postAddScheduledJob', ['unified'])}}">
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Calendar.png')}}"
											style="width: 32px !important; height: 36px !important;">
									</div>
									<h4 class="card-title ">
										<span class="card-title-grey"><a
											href="{{route('unified_getCalendar', 'unified')}}"> Calendar</a>
											/ </span> Schedule a Job
									</h4>
								</div>


							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-12 col-sm-6" id="details-container">
											<div class="row">
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Company name</label> <select name="companyName"
															class="form-control" id="companyNameSelect"
															onchange="changeCompany()">
															<option value="" selected class="placeholdered">Select
																company</option> @if(count($companyNames) > 0)
															@foreach($companyNames as $companyName)
															<option value="{{$companyName->id}}">{{$companyName->name}}</option>
															@endforeach @endif
														</select>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Type of job</label> <select name="typeOfJob"
															class="form-control" id="typeOfJobSelect"
															onchange="changeTypeOfJob()">
															<option value="" selected class="placeholdered">Select
																job type</option> @if(count($jobTypes) > 0)
															@foreach($jobTypes as $jobType)
															<option value="{{$jobType->id}}">{{$jobType->name}}</option>
															@endforeach @endif
														</select>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Job description </label>
														<textarea class="form-control" name="job_description"
															id="job_description" placeholder="Job description"
															required rows="7"></textarea>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Accounts note </label>
														<textarea class="form-control" name="accounts_note"
															id="accounts_note" placeholder="Accounts note" required
															rows="3"></textarea>
													</div>
												</div>
												<div class="col-12">
													<input type="hidden" name="serviceIdHidden"
														id="serviceIdHidden" value="{{$serviceId}}">
													<div class="form-group bmd-form-group">
														<label>Product type</label>
														<div id="selectedServiceTypesDiv"></div>
													</div>
												</div>
												<div class="col-12">
													<div class=" row" style="margin-top: 15px">
														<label class="labelRadio col-12" for="">Contract</label>
														<div class="col-12 row">
															<div class="col">
																<div class="form-check form-check-radio">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio" id="contractYes"
																		name="contract" value="1" required
																		onclick="clickContract(1)"> Yes <span class="circle">
																			<span class="check"></span>
																	</span>
																	</label>
																</div>
															</div>
															<div class="col">
																<div class="form-check form-check-radio">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio" id="contractNo"
																		name="contract" value="0" required
																		onclick="clickContract(0)"> No <span class="circle"> <span
																			class="check"></span>
																	</span>
																	</label>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-12" id="contractStartDateDiv"></div>
												<div class="col-12" id="contractEndDateDiv"></div>
												<div class="col-12">
													<div class="form-group bmd-form-group" id="dateDiv">
														<label>Date</label> <input type="text" id="date"
															class="form-control" name="date" value="{{$date==0 ? '' : $date }}"
															placeholder="Select date" required>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Time</label> <input type="text" id="time"
															class="form-control" name="time" value=""
															placeholder="Select time" required>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Engineer</label> <select name="engineer"
															class="form-control" id="engineerSelect"
															onchange="changeEngineer()">
															<option value="" selected class="placeholdered">Select
																engineer</option> @if(count($engineers) > 0)
															@foreach($engineers as $engineer)
															<option value="{{$engineer->id}}">{{$engineer->name}}</option>
															@endforeach @endif
														</select>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Email </label> <input type="text" id="email"
															class="form-control" name="email" value=""
															placeholder="Email " required>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Customer location</label>
														<textarea class="form-control" name="address" id="address"
															placeholder="Customer location" required> </textarea>
															
														<input type="hidden" name="address_coordinates" id="address_coordinates">
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Mobile</label> <input type="tel"
															class="form-control" name="mobile" id="mobile" value=""
															placeholder="Mobile" required>
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Phone</label> <input type="tel"
															class="form-control" name="phone" id="phone" value=""
															placeholder="Phone" required>
													</div>
												</div>
												<div class="col-12 mt-2">
													<input type="checkbox" id="pickupNeededRadio"
														name="pickup_needed" value="1"
														onclick="clickPickupNeeded()"> <label
														class="form-check-label w-100 px-0 sendReminderLabel"
														for="pickupNeededRadio"> <i class="fas fa-check-circle"></i>

														Pickup needed
													</label>
												</div>
												<div class="col-12" id="pickupAddressDiv"
													style="display: none">
													<div class="form-group bmd-form-group">
														<label>Pickup address</label>
														<textarea class="form-control" name="pickupAddress"
															id="pickupAddress" placeholder="Pickup address" required> </textarea>
														<input type="hidden" name="pickup_coordinates" id="pickup_coordinates">	
													</div>
												</div>
												<div class="col-12">
													<div class="form-group bmd-form-group">
														<label>Cost estimate </label> <input type="number"
															step="any" id="costEstimate" class="form-control"
															name="costEstimate" value="" placeholder="Cost estimate "
															required>
													</div>
												</div>
												<div class="col-12 mt-2">
													<input type="checkbox" id="sendReminderRadio"
														name="send_reminder"> <label
														class="form-check-label w-100 px-0 sendReminderLabel"
														for="sendReminderRadio"> <i class="fas fa-check-circle"></i>

														Send an email reminder
													</label>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6" id="map-container">
											<div id="map"
												style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="row ">
							<div class="col text-center">

								<button type="submit" id="createJobButton"
									class="btn btn-unified-primary singlePageButton"
									disabled="disabled">Create</button>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>


@endsection @section('page-scripts')

<script
	src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Turn-Radio-Buttons-Checkboxes-Into-Labels-zInput/zInput.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script type="text/javascript">



$(document).ready(function(){
 $("#companyNameSelect,#typeOfJobSelect,#engineerSelect").select2({});
		 addIntelInput('phone','phone');
        addIntelInput('mobile','mobile');
          $('#time').datetimepicker({
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
                     
        $('#date,#contractStartDate,#contractEndDate').datetimepicker({
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
		
        
});


function changeCompany(){
	var companyVal = $("#companyNameSelect").val();
	//console.log(companyVal);
	var token ='{{csrf_token()}}';
	
	 $.ajax({
        type: "POST",
        method:"post",
       	url: '{{url("unified/customers/get_company_data/")}}',
       	data: {_token: token, companyId:companyVal},
        success: function(data) {
       
            console.log(data);
            var company = data.company;
            $('#email').val(company.email);
            $('#mobile').val(company.mobile);
            $('#phone').val(company.phone);
            $('#address').val(company.address);
            var position = new google.maps.LatLng(company.addressLatlng.lat,company.addressLatlng.lng);
            markerAddress.setPosition(position);
            markerAddress.setVisible(true);
            markers[0] = markerAddress;
  			fitBoundsMap();
            
            
            if(company.contract ==true){
            	$('#contractYes').prop("checked",true);
            	$('#contractStartDateDiv').html('<div class="form-group bmd-form-group" > '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDate" class="form-control" '
            						+' name="contractStartDate" value="'
            						+company.contractStartDate
            						+'" placeholder="Select contract start date" required> </div>');
            						
            	$('#contractEndDateDiv').html(' <div class="form-group bmd-form-group" >  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDate" class="form-control" name="contractEndDate" value="'
            						+company.contractEndDate
            						+'" '
            						+' placeholder="Select contract end date" required> </div> ');
            						
            	$('#contractStartDate,#contractEndDate').datetimepicker({
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
            }else{
            	$('#contractNo').prop("checked",true);
            	$('#contractDateDiv').html('');
            }
            
            
           // console.log(":D:D " +$('#serviceIdHidden').val());
            var serviceIdHidden =$('#serviceIdHidden').val();
            //console.log(serviceIdHidden)
            var serviceTypesDivHtml = '';
            if(serviceIdHidden==0){
            	console.log("0000 "+serviceIdHidden)
                for(var i=0; i<company.serviceType.length; i++){
                	serviceTypesDivHtml += '<input type="radio" name="selectedServiceType" title="'+company.serviceType[i].name
                							+'" value="'+company.serviceType[i].id+'" id="serviceType'+company.serviceType[i].id+ '" >';
                }
                //console.log(serviceTypesDivHtml)
                $("#selectedServiceTypesDiv").html(serviceTypesDivHtml);
                $("#selectedServiceTypesDiv").zInput();
                
            }else{
            	//console.log("sasdas "+serviceIdHidden)
                for(var i=0; i<company.serviceType.length; i++){
                	if(company.serviceType[i].id==serviceIdHidden){
                		serviceTypesDivHtml += '<input type="radio" name="selectedServiceType" title="'+company.serviceType[i].name
                							+'" value="'+company.serviceType[i].id+'" id="serviceType'+company.serviceType[i].id+ '" >';
                	}
                }
                $("#selectedServiceTypesDiv").html(serviceTypesDivHtml);
                $("#selectedServiceTypesDiv").zInput();
                
                $("#selectedServiceTypesDiv #serviceType"+serviceIdHidden).prop('checked',true);
                $("#selectedServiceTypesDiv #serviceType"+serviceIdHidden).parent().parent().parent().addClass("zSelected");
            }
                       
            
            setSubmitButtonEnable();
        }
    });
}

function changeTypeOfJob(){
	//console.log("type of job "+$("#typeOfJobSelect").val());
	setSubmitButtonEnable()
}
function changeEngineer(){
	//console.log("engineer " +$("#engineerSelect").val() );
	var engineerId =$("#engineerSelect").val();
	setSubmitButtonEnable();
	
		var token ='{{csrf_token()}}';
	
	 $.ajax({
        type: "POST",
        method:"post",
       	url: '{{url("unified/get_engineer_location/")}}',
       	data: {_token: token, engineerId:engineerId},
        success: function(data) {
       
            console.log(data);
            console.log(data.location);
            console.log(JSON.parse(data.location));
            var location = JSON.parse(data.location);
                      markerEngineer.setPosition(new google.maps.LatLng(location.lat,location.lng))
                      markers[2] = markerEngineer;
         			  fitBoundsMap();
//                       map.setZoom(12);                     
        }
    });
}
function setSubmitButtonEnable(){
	var companyVal = $("#companyNameSelect").val();
	var typeOfJobVal =$("#typeOfJobSelect").val();
	var engineerVal =$("#engineerSelect").val();
	
	if(companyVal!='' && typeOfJobVal!='' && engineerVal!=''){
		$('#createJobButton').prop("disabled",false);
	}else{
		$('#createJobButton').prop("disabled",true);
	}
	
}

function clickContract(val){
	console.log("click contract "+val)
	if(val==1){
	$('#contractStartDateDiv').html('<div class="form-group bmd-form-group" > '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDate" class="form-control" '
            						+' name="contractStartDate" value="" placeholder="Select contract start date" required> </div>');
            						
            	$('#contractEndDateDiv').html(' <div class="form-group bmd-form-group" >  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDate" class="form-control" name="contractEndDate" value=""'
            						+' placeholder="Select contract end date" required> </div> ');
		
            	$('#contractStartDate, #contractEndDate').datetimepicker({
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
	}
	else{
        $('#contractStartDateDiv').html('');
        $('#contractEndDateDiv').html('');
	}
}
function clickPickupNeeded(){
	var pickupVal = $("#pickupNeededRadio:checked").val();
	if(pickupVal==1){
		$("#pickupAddressDiv").css("display","block")
		
	}else{
		$("#pickupAddressDiv").css("display","none")
	}
}

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
 ////////////////// map 
 
		       
		let map;
		let markerAddress ,markerPickup,markerEngineer ;
		let markers=[];

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });
             markerAddress = new google.maps.Marker({
                        map,
                        anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/unified/marker-orange.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                            origin: new google.maps.Point(0,0), // origin
                            anchor: new google.maps.Point(0, 0) // anchor
                        },
                        scaledSize: new google.maps.Size(30, 35), // scaled size
                      });
        	 markerPickup = new google.maps.Marker({
                        map,
                        anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/unified/marker-grey.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                            origin: new google.maps.Point(0,0), // origin
                            anchor: new google.maps.Point(0, 0) // anchor
                        },
                        scaledSize: new google.maps.Size(30, 35), // scaled size
                      });   
            markerEngineer =new google.maps.Marker({
                        map,
                        anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/unified/marker-blue.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                            origin: new google.maps.Point(0,0), // origin
                            anchor: new google.maps.Point(0, 0) // anchor
                        },
                        scaledSize: new google.maps.Size(30, 35), // scaled size
                      });                    

			//Autocomplete Initialization
			
			autoCompDrawMarkMap('address','marker-orange.png');
			autoCompDrawMarkMap('pickupAddress','marker-grey.png');

         }
		function autoCompDrawMarkMap(inputId,markerImage){
				let location_input = document.getElementById(inputId);
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
        					console.log(place.geometry.location.lat() +" "+place.geometry.location.lng());
        					console.log(place.geometry.viewport);
        					if (place.geometry.viewport) {
                              map.fitBounds(place.geometry.viewport);
                            } else {
                              map.setCenter(place.geometry.location);
                            }
                           
                            console.log("before if "+location_input)
                            if(inputId=='address'){
                            	markerAddress.setPosition(place.geometry.location);
                            	markerAddress.setVisible(true);
                            	markers[0] = markerAddress;
                            	
								let place_lat = place.geometry.location.lat();
                                let place_lon = place.geometry.location.lng();
                                document.getElementById("address_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';	
                            }else{
                            	markerPickup.setPosition(place.geometry.location);
                            	markerPickup.setVisible(true);
                            	markers[1] = markerPickup; 
                            	
								let place_lat = place.geometry.location.lat();
                                let place_lon = place.geometry.location.lng();
                                document.getElementById("pickup_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
                            }
        					fitBoundsMap();
        				}
        			});
		}	
		function fitBoundsMap(){
						
  			if (markers.length>1) { 
  				var bounds = new google.maps.LatLngBounds();
                for (var i = 0; i < markers.length; i++) {
                	if(markers[i]){
                 		bounds.extend(markers[i].position);
                 	}	
                }
                map.fitBounds(bounds);
    			
            }    
            
	
		}
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>

@endsection
