@extends('templates.dashboard') @section('page-styles')

<link href="{{asset('css/fullcalendar.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<link rel="stylesheet"
	href="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Turn-Radio-Buttons-Checkboxes-Into-Labels-zInput/zInput_default_stylesheet.css">

<link rel="stylesheet"
	href="{{asset('css/unified-calendar-styles.css')}}">
	
<style>
.expireContract{
position: absolute;
/* bottom: 0; */
top: -5px;
}
.expireContract .fc-content,
.expireContract .fc-content i{
color: #d95353 !important;
font-size: 18px;

}
</style>

<style>
.select2-container--default .select2-selection--single .select2-selection__arrow
	{
	top: 20%;
}
.card-body{
padding-left: 0;
padding-right: 0;
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
															class="form-control" name="date"
															value="{{$date==0 ? '' : $date }}"
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
															<option value="{{$engineer->id}}">{{$engineer->first_name}} {{$engineer->last_name}}</option>
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

														<input type="hidden" name="address_coordinates"
															id="address_coordinates">
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
														<input type="hidden" name="pickup_coordinates"
															id="pickup_coordinates">
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
										<div class="col-12 col-sm-6" id="calendar-container">
<!-- 											<div id="map" 
												style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div> -->
												<h3 class="servicesCalendarTitleH3">Services</h3>

										<ul class="servicesCalendarUl" id="serciesUiUl">

										
										</ul>
										
												<div id='calendar'></div>
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


						@include('admin.unified.calendar_modals')
@endsection @section('page-scripts')

<script src="{{asset('js/calender-design.js')}}"></script>
<script src="{{asset('js/fullcalendar.js')}}"></script>
<script
	src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Turn-Radio-Buttons-Checkboxes-Into-Labels-zInput/zInput.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script type = "text/javascript" src="{{asset('js/unified_calendar_js_functions.js')}}"></script>

<script type="text/javascript">

	var token = '{{csrf_token()}}';


$(document).ready(function(){
	$('#minimizeSidebar').trigger('click')
	

 $("#companyNameSelect,#typeOfJobSelect,#engineerSelect").select2({});
		 addIntelInput('phone','phone');
        addIntelInput('mobile','mobile');
        
          $('#time').datetimepicker({
          debug:true,
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
		
		////////////////////////////////////////// calendar
		
			    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		var calendar =  $('#calendar').fullCalendar({
			header: {
				//left: 'title',
				left:'prev title next',
				center: 'today,agendaDay,agendaWeek,month,agendaYear',
				right:''
				//center: 'agendaDay,agendaWeek,month',
				//right: 'prev,next today'
			},
   	 		eventorder: "-title",
			editable: true,
			firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			contentHeight:'auto',
			defaultView: 'month',
			
			droppable: true, // this allows things to be dropped onto the calendar !!!
			    disableDragging: true,
			
     		eventLimit: false, // allow "more" link when too many events
			eventRender: function (event, element) {

        	},
         	
       	events: function(start_date, end_date,timezone, callback) {
       	       	
				$.ajax({
					type:'GET',
					url: '{{url("unified/calendar-events")}}'+'?start_date='+Math.round(start_date/ 1000)+'&end_date='+Math.round(end_date / 1000),
					success:function(data) {
					//console.log(data);
						//contractors = data.contractors;
						callback(JSON.parse(data.events));
						
						var servicesUl = '';
						for(var i =0; i<data.services.length; i++){
							var service=data.services[i];
							servicesUl += '<li class="mb-1" style="display:inline-block" onclick="clickServiceGetJobList('
										+service.id
										+',\''+token+'\',\'{{url("unified/")}}\')"> <div class="row m-0"> <div class="serviceColorLiDiv col-sm-2 mr-0 p-1" '
										+ ' style="border-left: 4px solid '
										+service.borderColor
										+'; background-color:'
										+service.backgroundColor 
										+';"> </div> <div class="col-sm-10 pl-0 pl-1 my-1"> <p class="serviceNameCalendarP">'
										+ service.name 
										+'</p> <p class="serviceJobsCalendarP"> '
										+service.jobs_count 
										+' jobs in this month</p> </div> </div>	</li>';
						}
						
						
						$("#serciesUiUl").html(servicesUl);
					}
				});
			},
        	
            eventRender: function(event, element) {
                 if(event.className=='expireContract'){          
                    element.find(".fc-title").prepend("<i class='fas fa-file-contract'></i>");
                 }
              }    ,
			eventAfterAllRender: function(){
				// loop through each calendar row
            	$('.fc-content-skeleton').each(function(){
            		var firstRow,
            		ctr = 0;
            
            		// loop through each event row in a week
            		$(this).find('table > tbody > tr').each(function(){
            			var $this = $(this);
            
            			if(ctr == 0) {
            				// pass off the first row as the main event container of dots
            				firstRow = $this;
            			} else {
            				// get td with only the .fc-event-container
            				var mainEventContainers = $('.fc-event-container', firstRow),
            				      eventItems = $('.fc-event-container', $this);
            
            				// these are the events you want to append to the top row
            				eventItems.each(function(){
            					var eventLink = $('.fc-day-grid-event', $(this));
            					// pass of the td rowspan attribute to the link to be appended 
            					eventLink.attr('data-rowspan', $(this).attr('rowspan'));
            
            					// loop through each td.fc-event-container 
            					mainEventContainers.each(function(){
            						// skip container if it has rowspan (which means it doesn't have any more events to put)
            						if(!$(this).attr('rowspan')) {
            							var dataLinks = $('.fc-day-grid-event', $(this));
            
            							// append if the last link doesn't have a rowspan
            							if(!dataLinks.last().data('rowspan')) {
            								eventLink.appendTo($(this));
            								return false;
            							}
            						}
            					});
            				});
            
            			}
            
            			ctr++;
            		});
            
            	});
            }, 
			 
			 eventClick: function(calEvent, jsEvent, view) {
			 	//console.log("click event "+calEvent+" "+calEvent.className);
			 	//console.log(calEvent)
			 	//console.log(calEvent.start)
			 	if(calEvent.className=='expireContract'){    
			 		getContractsExpiredData(calEvent.start,token,'{{url("unified/")}}');
			 	}else{
			 		getDetialsOfDate(calEvent.start,calEvent.serviceId,token,'{{url("unified/")}}');
			 	} 
 			 }	,
 			 dayClick: function(date, allDay, jsEvent, view) {
               getDetialsOfDate(date,0,token,'{{url("unified/")}}');
               
			                   
        	}
		});
		
		//////////////////////////// end calendar
        
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
       
           // console.log(data);
            var company = data.company;
            $('#email').val(company.email);
            $('#mobile').val(company.mobile);
            $('#phone').val(company.phone);
            $('#address').val(company.address);
            
            if(company.contract ==true){
            	//console.log(company.contractStartDate)
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
            	//console.log("0000 "+serviceIdHidden)
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
	
// 		var token ='{{csrf_token()}}';
	
// 	 $.ajax({
//         type: "POST",
//         method:"post",
//        	url: '{{url("unified/get_engineer_location/")}}',
//        	data: {_token: token, engineerId:engineerId},
//         success: function(data) {
                      
//         }
//     });
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
	//console.log("click contract "+val)
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


 
  //Map Js
		window.initAutoComplete = function initAutoComplete() {
			//Autocomplete Initialization
			let location_input = document.getElementById('address');
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

					document.getElementById("address_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
				}
			});
			
			let pickup_input = document.getElementById('pickupAddress');
			//Mutation observer hack for chrome address autofill issue
			let observerHackPickup = new MutationObserver(function() {
				observerHackPickup.disconnect();
				pickup_input.setAttribute("autocomplete", "new-password");
			});
			observerHackPickup.observe(pickup_input, {
				attributes: true,
				attributeFilter: ['autocomplete']
			});
			let autocomplete_location_pickup = new google.maps.places.Autocomplete(pickup_input);
			autocomplete_location_pickup.setComponentRestrictions({'country': ['ie']});
			autocomplete_location_pickup.addListener('place_changed', () => {
				let place = autocomplete_location_pickup.getPlace();
				if (!place.geometry) {
					// User entered the name of a Place that was not suggested and
					// pressed the Enter key, or the Place Details request failed.
					window.alert("No details available for input: '" + place.name + "'");
				} else {
					let place_lat = place.geometry.location.lat();
					let place_lon = place.geometry.location.lng();

					document.getElementById("pickup_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) + '}';
				}
			});
		}
		
		
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initAutoComplete"></script>

@endsection
