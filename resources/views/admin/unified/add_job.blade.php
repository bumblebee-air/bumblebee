@extends('templates.dashboard') @section('page-styles')

<link href="{{asset('css/fullcalendar.css')}}" rel="stylesheet">
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

.card-body {
	padding-left: 0;
	padding-right: 0;
}

#navAddJobUl li a {
	width: 155px;
	font-family: 'Roboto', sans-serif !important;
	padding: 10px 35px;
	font-size: 16px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.5;
	letter-spacing: 0.15px;
	color: #7b7b7b;
	background: transparent;
}

#navAddJobUl li a.active, #navAddJobUl li a:hover {
	background-color: #d58242;
	border-color: #d58242;
	color: white !important;
	box-shadow: 0 4px 20px 0 rgb(0 0 0/ 14%), 0 7px 10px -5px
		rgb(213 130 66/ 40%);
	border-radius: 30px !important;
}

.tab-space {
	padding: 0 !important;
}

.tab-pane {
	height: calc(100% - 50px);
}

.form-head {
	padding: 20px 0 0;
	font-style: normal;
	font-weight: 500;
	font-size: 17px;
	line-height: 1.19;
	letter-spacing: 0.8px;
	color: #4D4D4D;
}
.card-container-form{

background: #FFFFFF;
box-shadow: 0px 4px 31px rgba(0, 0, 0, 0.25);
border-radius: 18px;}

.card-container-form .card-body .container{
padding: 0 !important;
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
							<!-- 							</div> -->
							<!-- 						<div class="card">	 -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-12 col-sm-6 pl-0" id="details-container">
											<div class="card card-container-form">
												<div class="card-header" data-toggle="collapse"
													id="customer-details-header" data-target="#company-details"
													aria-expanded="true" aria-controls="company-details">
													<div class="d-flex form-head">
														<span>1</span> Company Details
													</div>
												</div>
												<div id="company-details" class="collapse show"
													aria-labelledby="company-details-header"
													data-parent="#details-container">
													<div class="card-body">
														<div class="container">
															<div class="row">
																<div class="col-12">
																	<div class="form-group bmd-form-group">
																		<label>Company name</label> <select name="companyName"
																			class="form-control" id="companyNameSelect"
																			onchange="changeCompany()" required>
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
																			id="accounts_note" placeholder="Accounts note"
																			required rows="3"></textarea>
																	</div>
																</div>
																<div class="col-12">
																	<input type="hidden" name="serviceIdHidden"
																		id="serviceIdHidden" value="{{$serviceId}}">
																	<p style="font-size: 14px; color:red; font-weight: 500px;display: none;" id="errorMessageServiceType"> Please select product type </p>	
																	<div class="form-group bmd-form-group">
																		<label>Product type</label>
																		<div id="selectedServiceTypesDiv"></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="card card-container-form">
												<div class="card-header" data-toggle="collapse"
													id="contact-details-header" data-target="#contact-details"
													aria-expanded="true" aria-controls="contact-details">
													<div class="d-flex form-head">
														<span>2</span> Contact Details
													</div>
												</div>
												<div id="contact-details" class="collapse"
													aria-labelledby="contact-details-header"
													data-parent="#details-container">
													<div class="card-body">
														<div class="container">
															<div class="row">
																<div class="col-12">
																	<div class=" row" style="margin-top: 15px">
																		<label class="labelRadio col-12" for="">Contract</label>
																		<div class="col-12 row">
																			<div class="col">
																				<div class="form-check form-check-radio">
																					<label class="form-check-label"> <input
																						class="form-check-input" type="radio"
																						id="contractYes" name="contract" value="1"
																						required onclick="clickContract(1)"> Yes <span
																						class="circle"> <span class="check"></span>
																					</span>
																					</label>
																				</div>
																			</div>
																			<div class="col">
																				<div class="form-check form-check-radio">
																					<label class="form-check-label"> <input
																						class="form-check-input" type="radio"
																						id="contractNo" name="contract" value="0" required
																						onclick="clickContract(0)"> No <span
																						class="circle"> <span class="check"></span>
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
																			placeholder="Select date" required
																			onchange="changeDate()">
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
																		<label>Engineer</label> <select name="engineer[]"
																			class="form-control" id="engineerSelect" required
																			onchange="changeEngineer()" multiple="">
																			@if(count($engineers) > 0) @foreach($engineers as
																			$engineer)
																			<option value="{{$engineer->id}}">{{$engineer->first_name}}
																				{{$engineer->last_name}}</option> @endforeach @endif
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="card card-container-form" >
												<div class="card-header" data-toggle="collapse"
													id="customer-details-header"
													data-target="#customer-details" aria-expanded="true"
													aria-controls="customer-details">
													<div class="d-flex form-head">
														<span>3</span> Customer Details
													</div>
												</div>
												<div id="customer-details" class="collapse"
													aria-labelledby="customer-details-header"
													data-parent="#details-container">
													<div class="card-body">
														<div class="container">
															<div class="row">
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
																		<textarea class="form-control" name="address"
																			id="address" placeholder="Customer location" required></textarea>

																		<input type="hidden" name="address_coordinates"
																			id="address_coordinates">
																	</div>
																</div>
																<div class="col-12">
																	<div class="form-group bmd-form-group">
																		<label>Mobile</label> <input type="tel"
																			class="form-control" name="mobile" id="mobile"
																			value="" placeholder="Mobile" required>
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
																		for="pickupNeededRadio"> <i
																		class="fas fa-check-circle"></i> Pickup needed
																	</label>
																</div>
																<div class="col-12" id="pickupAddressDiv"
																	style="display: none">
																	<div class="form-group bmd-form-group">
																		<label>Pickup address</label>
																		<textarea class="form-control" name="pickupAddress"
																			id="pickupAddress" placeholder="Pickup address"
																			required> </textarea>
																		<input type="hidden" name="pickup_coordinates"
																			id="pickup_coordinates">
																	</div>
																</div>
																<div class="col-12">
																	<div class="form-group bmd-form-group">
																		<label>Cost estimate </label> <input type="number"
																			step="any" id="costEstimate" class="form-control"
																			name="costEstimate" value=""
																			placeholder="Cost estimate " required>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-12 ">
													<input type="checkbox" id="sendReminderRadio"
														name="send_reminder"> <label
														class="form-check-label w-100 px-0 sendReminderLabel"
														for="sendReminderRadio"> <i class="fas fa-check-circle"></i>
														Send an email reminder
													</label>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 pr-0" id="calendar-container">
											<ul
												class="nav nav-pills nav-pills-primary justify-content-start justify-content-md-center mb-3"
												role="tablist" id="navAddJobUl">
												<li class="nav-item"><a class="nav-link" data-toggle="tab"
													href="#mapContainerDiv" role="tablist" aria-expanded="true">
														Map </a></li>
												<li class="nav-item"><a class="nav-link active"
													data-toggle="tab" href="#calendarContainerDiv"
													role="tablist" aria-expanded="false"> Calendar </a></li>
											</ul>
											<div class="tab-content tab-space h-100">
												<div class="tab-pane " id="mapContainerDiv"
													aria-expanded="false">
													<div id="map"
														style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
												</div>

												<div class="tab-pane active" id="calendarContainerDiv"
													aria-expanded="false">
													<h3 class="servicesCalendarTitleH3">Services</h3>

													<ul class="servicesCalendarUl" id="serciesUiUl">
													</ul>
													<div id='calendar'></div>
												</div>
											</div>


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


@include('admin.unified.calendar_modals') @endsection
@section('page-scripts')

<script src="{{asset('js/calender-design.js')}}"></script>
<script src="{{asset('js/fullcalendar.js')}}"></script>
<script
	src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Turn-Radio-Buttons-Checkboxes-Into-Labels-zInput/zInput.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script type="text/javascript"
	src="{{asset('js/unified_calendar_js_functions.js')}}"></script>

<script type="text/javascript">

	var token = '{{csrf_token()}}';


$(document).ready(function(){
	$('#minimizeSidebar').trigger('click');
	
	$('.card-container-form').on('show.bs.collapse hide.bs.collapse', function() {

      //$(this).toggleClass("panel-default panel-primary");
      //$(this).find(".indicator").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
    })
    $('.collapse').collapse({
      toggle: false,
      parent: '#details-container'
    });
    
    

$('#createJobButton').click(function() {
var inputs = $("#addScheduledJob input[required],#addScheduledJob textarea[required],#addScheduledJob select[required]");
//console.log(inputs)

  inputs.each(function() {

    if ($(this).val() == "") {

      var current = $(this).closest(".collapse");
//       console.log(this)
//       console.log(current)

      if (!current.hasClass("show")) {
        current.collapse("show");
      }

      return false;
    }
  });
  
  if($("input[name='selectedServiceType']:checked").val()=== null || $("input[name='selectedServiceType']:checked").val()=== undefined){
  	$("#errorMessageServiceType").css("display","block");
  	$('html, body').animate({ scrollTop: $('#errorMessageServiceType').offset().top }, 'slow');
  	return false;
  }else{
  	$("#errorMessageServiceType").css("display","none")
  }
  
});
    
	

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
       $('#date').datetimepicker().on('dp.change', function (event) {
                //console.log($(this).val());
                var date = moment($(this).val()).format('YYYY-MM-DD');
                //var date2 = date.toString('dd-MM-yy');
                //console.log(date);
                $('#calendar').fullCalendar('gotoDate', date);
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
			//defaultView: 'month',
			  defaultView: 'agendaWeek',
			
			
			droppable: true, // this allows things to be dropped onto the calendar !!!
			    disableDragging: true,
			
     		eventLimit: false, // allow "more" link when too many events
			eventRender: function (event, element) {

        	},
         	
       	events: function(start_date, end_date,timezone, callback) {
       	       	var view = $('#calendar').fullCalendar('getView');
           	    setTimeout(function (){
    				$.ajax({
    					type:'GET',
    					url: '{{url("unified/calendar-events")}}',
        					 data: {
                                // our hypothetical feed requires UNIX timestamps
                                start_date: Math.round(start_date/ 1000),
                                end_date: Math.round(end_date / 1000),
                                viewTitle: view.title,
                                viewName:view.name
                              },
                              success:function(data) {
//     							console.log(data);
//     							console.log(JSON.parse(data.events))
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
				
    			 }, 200); // How long do you want the delay to be (in milliseconds)? 	
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
		//$('#calendar').fullCalendar('gotoDate', '2020-05-06');
		
		
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
       
            console.log(data);
            var company = data.company;
            $('#email').val(company.email);
            $('#mobile').val(company.mobile);
            $('#phone').val(company.phone);
            $('#address').val(company.address);
            $('#address').change();
			if(company.address_coordinates!=null) {
				var position = new google.maps.LatLng(company.address_coordinates.lat, company.address_coordinates.lon);
				document.getElementById("address_coordinates").value = '{"lat": ' + company.address_coordinates.lat + ', "lon": ' + company.address_coordinates.lon + '}';
				markerAddress.setPosition(position);
				markerAddress.setVisible(true);
				markers[0] = markerAddress;
				fitBoundsMap();
			}
            
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
                							+'" value="'+company.serviceType[i].id+'" id="serviceType'+company.serviceType[i].id+ '" required>';
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
	var engineerIds =$("#engineerSelect").val();
	setSubmitButtonEnable();
	
	var token ='{{csrf_token()}}';
		//console.log(markers);
		for(var j=2; j<markers.length; j++){
			markers[j].setMap(null);
		}
		markers.length = 2;
		//console.log(markers);
                              
	for(var i=0; i<engineerIds.length;i++){
		//console.log(engineerIds[i]);
		var engineerId = engineerIds[i];
		 
		 $.ajax({
                type: "POST",
                method:"post",
               	url: '{{url("unified/get_engineer_location/")}}',
               	data: {_token: token, engineerId: engineerId},
                success: function(data) {
//                     console.log(data);
//                     console.log(data.location);
//                     console.log(JSON.parse(data.location));
                    var location = JSON.parse(data.location);
                    
                    var marker = new google.maps.Marker({
                        map,
                        anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/unified/marker-blue.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                        },
                        scaledSize: new google.maps.Size(30, 35), // scaled size
                      });     
                    marker.setPosition(new google.maps.LatLng(location.lat,location.lon))
                     markers.push(marker);
                     
				//console.log(markers);
                     
                 			  fitBoundsMap();
					//  map.setZoom(12);   
                              
                }
            });
        //console.log("-----------------------------------")    
	}	
	
	
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
		//Pickup marker needed
		//autoCompDrawMarkMap('pickup_coordinates', '')
		
	}else{
		$("#pickupAddressDiv").css("display","none");
		markerPickup.setMap(null)
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
                        },
                      });
        	 markerPickup = new google.maps.Marker({
                        map,
                        anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/unified/marker-grey.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                        },
                        scaledSize: new google.maps.Size(30, 35), // scaled size
                      });   
            markerEngineer =new google.maps.Marker({
                        map,
                        anchorPoint: new google.maps.Point(0, -29),
                        icon: {
                            url:"{{asset('images/unified/marker-blue.png')}}", // url
                            scaledSize: new google.maps.Size(50, 50), // scaled size
                        },
                        scaledSize: new google.maps.Size(30, 35), // scaled size
                      });                    

			//Autocomplete Initialization
			
			autoCompDrawMarkMap('address','marker-orange.png');
			autoCompDrawMarkMap('pickupAddress','marker-grey.png');

         }
		function autoCompDrawMarkMap(inputId,markerImage){
				//console.log("auto complete draw marker map")
				let location_input = document.getElementById(inputId);
				// console.log(location_input)
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
        				//console.log("place changed")
        				let place = autocomplete_location.getPlace();
        				if (!place.geometry) {
        					// User entered the name of a Place that was not suggested and
        					// pressed the Enter key, or the Place Details request failed.
        					window.alert("No details available for input: '" + place.name + "'");
        				} else {
        					//console.log(place.geometry.location.lat() +" "+place.geometry.location.lng());
        					//console.log(place.geometry.viewport);
        					if (place.geometry.viewport) {
                              map.fitBounds(place.geometry.viewport);
                            } else {
                              map.setCenter(place.geometry.location);
                            }
                           
                           // console.log("before if "+location_input)
                            if(inputId=='address'){
                            	markerAddress.setPosition(place.geometry.location);
                            	markerAddress.setVisible(true);
                            	markers[0] = markerAddress;
                            	
								let place_lat = place.geometry.location.lat();
                                let place_lon = place.geometry.location.lng();
                                document.getElementById("address_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) +'}';
                            }else{
                            	markerPickup.setPosition(place.geometry.location);
                            	markerPickup.setVisible(true);
                            	markers[1] = markerPickup; 
                            	
								let place_lat = place.geometry.location.lat();
                                let place_lon = place.geometry.location.lng();
                                document.getElementById("pickup_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) +'}';
                            }
        					fitBoundsMap();
        				}
        			});
		}	
		function fitBoundsMap(){
						//console.log(markers)
  			if (markers.length>1) { 
  				var bounds = new google.maps.LatLngBounds();
                for (var i = 0; i < markers.length; i++) {
                	if(markers[i]){

    //                 	console.log(markers);
    //                 	console.log(markers[i]);                	
    //                 	console.log(markers[i].position.lat(),markers[i].position.lng());
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
