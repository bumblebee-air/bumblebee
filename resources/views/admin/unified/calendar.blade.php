@extends('templates.dashboard') @section('page-styles')
<!-- 
<link href="{{asset('css/calender-design-styles.css')}}"
	rel="stylesheet"> -->
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
@endsection @section('title', 'Unified | Calendar')
@section('page-content')
<div class="content px-0 px-md-3">
	<div class="container-fluid px-0 px-md-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-md-8">
								<div class="card-icon p-3">
									<img class="page_icon"
										src="{{asset('images/unified/Calendar.png')}}"
										style="width: 32px !important; height: 36px !important;">
								</div>
								<h4 class="card-title ">Calendar</h4>
							</div>


						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-lg-2 col-md-3 p-0"
										style="background-color: #fafafa;">
										<h3 class="servicesCalendarTitleH3">Services</h3>

										<ul class="servicesCalendarUl">

											@foreach($services as $service)
											<li class="mb-1"
												onclick="clickServiceGetJobList({{$service->id}})">
												<div class="row m-0">
													<div class="serviceColorLiDiv col-sm-2 mr-0 p-1"
														style="border-left: 4px solid {{$service->borderColor}}; 
														background-color:{{$service->backgroundColor}};">
													</div>
													<div class="col-sm-10 pl-0 pl-1 my-1">
														<p class="serviceNameCalendarP">{{$service->name}}</p>
														<p class="serviceJobsCalendarP">{{$service->jobs_count}}
															jobs in this month</p>
													</div>
												</div>

											</li> @endforeach
										</ul>
										<div class="row">
											<div class="col-md-6 offset-md-6">
												<button class=" btn-add-calendar" style="float: right;"
													onclick="clickAddScheduledJob()">
													<img class=""
														src="{{asset('images/unified/add-icon.png')}}">
												</button>
											</div>
										</div>

									</div>
									<div class="col-lg-10 col-md-9 px-0 px-md-3">

										<div id='calendar'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- calendar modal add job-->
<div class="modal fade" id="calendar-modal-add-job" 
	role="dialog">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader"
					id="calendar-label">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">


				<div>
					<h3 class="addJobSubTitleModal">Schedule A Job</h3>


					<form id="customer-form" method="POST"
						action="{{route('unified_postAddScheduledJob', ['unified'])}}"
						@submit="onSubmitForm">
						{{csrf_field()}}

						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Company name</label> <select name="companyName"
										class="form-control" id="companyNameSelect"
										onchange="changeCompany()">
										<option value="" selected class="placeholdered">Select company</option>
										@if(count($companyNames) > 0)
											@foreach($companyNames as $companyName)
											<option value="{{$companyName->id}}">{{$companyName->name}}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Type of job</label> <select name="typeOfJob"
										class="form-control" id="typeOfJobSelect"
										onchange="changeTypeOfJob()">
										<option value="" selected class="placeholdered">Select job
											type</option> @if(count($jobTypes) > 0)
											 @foreach($jobTypes as $jobType)
										<option value="{{$jobType->id}}">{{$jobType->name}}</option>
										@endforeach @endif
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<input type="hidden" name="serviceIdHidden" id="serviceIdHidden">
								<div class="form-group bmd-form-group">
									<label>Product type</label>
									<div id="selectedServiceTypesDiv"></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
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
									<div class="col-md-12 ">
										<div class=" row" style="margin-top: 15px">
											<label class="labelRadio col-12" for="">Contract</label>
											<div class="col-12 row">
												<div class="col">
													<div class="form-check form-check-radio">
														<label class="form-check-label"> <input
															class="form-check-input" type="radio" id="contractYes"
															name="contract" value="1" required onclick="clickContract(1)"> Yes <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>
												<div class="col">
													<div class="form-check form-check-radio">
														<label class="form-check-label"> <input
															class="form-check-input" type="radio" id="contractNo"
															name="contract" value="0" required  onclick="clickContract(0)"> No <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="contractDateDiv" >
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group" id="dateDiv">
									<label>Date</label> <input type="text" id="date"
										class="form-control" name="date" value=""
										placeholder="Select date" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Time</label> <input type="text" id="time"
										class="form-control" name="time" value=""
										placeholder="Select time" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Address</label>
									<textarea class="form-control" name="address" id="address"
										placeholder="Address" required> </textarea>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Email address</label> <input type="text" id="email"
										class="form-control" name="email" value=""
										placeholder="Email address" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Phone</label> <input type="tel" class="form-control"
										name="phone" id="phone" value="" placeholder="Phone" required>
								</div>
							</div>

							<div class="col-md-6">

								<div class="form-group bmd-form-group">
									<label>Mobile</label> <input type="tel" class="form-control"
										name="mobile" id="mobile" value="" placeholder="Mobile"
										required>
								</div>
							</div>
							<div class="col-md-6"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input type="checkbox" id="sendReminderRadio"
									name="send_reminder"> <label
									class="form-check-label w-100 px-0 sendReminderLabel"
									for="sendReminderRadio"> <i class="fas fa-check-circle"></i>

									Send an email reminder
								</label>
							</div>
						</div>

						<div class="row text-center mt-3">
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
<!-- end calendar add job modal -->

<!-- calendar modal edit job-->
<div class="modal fade" id="calendar-modal-edit-job" 
	role="dialog" aria-labelledby="calendar-edit-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">


				<div>
					<h3 class="addJobSubTitleModal">Edit Scheduled Job</h3>


					<form id="edit-job-form" method="POST"
						action="{{route('unified_postEditScheduledJob', ['unified'])}}"
						@submit="onSubmitForm">
						{{csrf_field()}} <input type="hidden" name="jobId" id="jobIdEdit">


						<div class="row">
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Company name</label> <select name="companyName"
												class="form-control" id="companyNameSelectEdit"
												onchange="changeCompanyEdit()">
												<option value="" selected class="placeholdered">Select
													company</option> @if(count($companyNames) > 0)
												@foreach($companyNames as $companyName)
												<option value="{{$companyName->id}}">{{$companyName->name}}</option>
												@endforeach @endif
											</select>
										</div></div>
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Type of job</label> <select name="typeOfJob"
												class="form-control" id="typeOfJobSelectEdit">
												<option value="" selected class="placeholdered">Select job
													type</option> @if(count($jobTypes) > 0) @foreach($jobTypes as $jobType)
												<option value="{{$jobType->id}}">{{$jobType->name}}</option>
												@endforeach @endif
											</select>
										</div></div>
						</div>
						<div class="row">
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Product type</label>
											<div id="selectedServiceTypesDivEdit"></div>
										</div></div>
							<div class="col-md-6">
								<div class="row">
								<div class="col-md-12">
										<div class="form-group bmd-form-group">
											<label>Engineer</label> <select name="engineer"
												class="form-control" id="engineerSelectEdit">
												<option value="" selected class="placeholdered">Select
													engineer</option> @if(count($engineers) > 0)
												@foreach($engineers as $engineer)
												<option value="{{$engineer->id}}">{{$engineer->name}}</option>
												@endforeach @endif
											</select>
										</div>
									</div>
								<div class="col-md-12 ">
										<div class=" row" style="margin-top: 15px">
											<label class="labelRadio col-12" for="">Contract</label>
											<div class="col-12 row">
												<div class="col">
													<div class="form-check form-check-radio">
														<label class="form-check-label"> <input
															class="form-check-input" type="radio"
															id="contractYesEdit" name="contract" value="1" required onclick="clickContractEdit(1)">
															Yes <span class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>
												<div class="col">
													<div class="form-check form-check-radio">
														<label class="form-check-label"> <input
															class="form-check-input" type="radio" id="contractNoEdit"
															name="contract" value="0" required  onclick="clickContractEdit(0)"> No <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									</div>
							</div>
						</div>
						<div class="row" id="contractDateDivEdit" >
						</div>
						<div class="row">
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Date</label> <input type="text" id="dateEdit"
												class="form-control" name="date" value=""
												placeholder="Select date" required>
										</div></div>
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Time</label> <input type="text" id="timeEdit"
												class="form-control" name="time" value=""
												placeholder="Select time" required>
										</div></div>
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Address</label>
											<textarea class="form-control" name="address"
												id="addressEdit" placeholder="Address" required> </textarea>
										</div></div>
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Email address</label> <input type="text"
												id="emailEdit" class="form-control" name="email" value=""
												placeholder="Email address" required>
										</div></div>
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Phone</label> <input type="tel" class="form-control"
												name="phone" id="phoneEdit" value="" placeholder="Phone"
												required>
										</div></div>
							<div class="col-md-6"><div class="form-group bmd-form-group">
											<label>Mobile</label> <input type="tel" class="form-control"
												name="mobile" id="mobileEdit" value="" placeholder="Mobile"
												required>
										</div></div>
						</div>

						<div class="row">
						

							<div class="col-md-12">
								<input type="checkbox" id="sendReminderRadioEdit"
									name="send_reminder"> <label
									class="form-check-label w-100 px-0 sendReminderLabel"
									for="sendReminderRadioEdit"> <i class="fas fa-check-circle"></i>

									Send an email reminder
								</label>
							</div>
						</div>

						<div class="row text-center mt-3 justify-content-md-center">
							<div class="col-12 col-xl-4 col-md-5 col-sm-6 text-center">

								<button type="submit" id="editJobButton"
									class="btn btn-unified-primary singlePageButton">Edit</button>
							</div>
							<div class="col-12 col-xl-4 col-md-5 col-sm-6 text-center">

								<button type="button" id="deleteJobButton"
									class="btn btn-unified-danger singlePageButton"
									onclick="clickDeleteJob()">Delete</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end calendar edit job modal -->


<!-- delete job modal -->
<div class="modal fade" id="calendar-modal-delete-job" tabindex="-1"
	role="dialog" aria-labelledby="delete-job-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header deleteHeader">Are you sure you want
					to delete this job?</div>

				<div>

					<form method="POST" id="delete-job"
						action="{{url('unified/delete_scheduled_job')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="jobId" name="jobId" value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-unified-primary modal-btn"
					onclick="$('form#delete-job').submit()">Yes</button>
				<button type="button" class="btn  btn-unified-danger modal-btn"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete job modal -->

<!-- calendar-modal-job-list empty-->
<div class="modal fade" id="calendar-modal-job-list-empty" tabindex="-1"
	role="dialog" aria-labelledby="calendar-label-job-list-empty"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">

				<input type="hidden" id="date"> <input type="hidden"
					id="isDateHidden"> <input type="hidden" id="serviceId">
				<div>
					<h3 class="addJobSubTitleModal">
						<span id="jobsListTitleModalSpan"></span> Jobs List
					</h3>

					<div class="row mt-3 text-center">
						<div class="col-12 text-center">
							<h3 class="noJobsAddedHeader">No jobs added to that day so far</h3>
						</div>
						<div class="col-12 mt-4 text-center">
							<button class=" btn-nojob-add-calendar"
								onclick="clickAddScheduledJobListModal('nojob')">
								<img src="{{asset('images/unified/add-job.png')}}">
							</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- end calendar-modal-job-list empty -->

<!-- calendar-modal-job-list -->

<div class="modal fade" id="calendar-modal-job-list" tabindex="-1"
	role="dialog" aria-labelledby="calendar-joblist-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">

				<input type="hidden" id="date"> <input type="hidden"
					id="isDateHidden"> <input type="hidden" id="serviceId">

				<h3 class="addJobSubTitleModal">
					<span id="jobsListTitleModalSpan"></span> Jobs List
				</h3>

				<div class="row mt-3 ">
					<div class="col">
						<ul class="list-group" id="jobsListUl">
						</ul>
					</div>
				</div>


				<div class="row mt-4">
					<div class="col-12">
						<button class=" btn-add-calendar" style="float: right;"
							onclick="clickAddScheduledJobListModal('hasjobs')">
							<img class="" src="{{asset('images/unified/add-icon.png')}}">
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end calendar-modal-job-list -->


<!-- calendar-modal-contract-list -->

<div class="modal fade" id="calendar-modal-contract-list" tabindex="-1"
	role="dialog" aria-labelledby="calendar-contractlist-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body mb-4">

				<h3 class="addJobSubTitleModal">
					<span id="contractListTitleModalSpan"></span>
				</h3>

				<div class="row mt-3 mb-3">
					<div class="col">
						<ul class="list-group" id="contractListUl">
						</ul>
					</div>
				</div>


				
			</div>
		</div>
	</div>
</div>
<!-- end calendar-modal-contract-list -->

@endsection @section('page-scripts')

<script src="{{asset('js/calender-design.js')}}"></script>
<script src="{{asset('js/fullcalendar.js')}}"></script>
<script
	src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Turn-Radio-Buttons-Checkboxes-Into-Labels-zInput/zInput.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function() {
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
         	events: {!! $events !!},
        	
//        	events: function(start_date, end_date, callback) {
// 				$.ajax({
// 					type:'GET',
// 					url: '{{url("garden-help/contractors/roster-events")}}'+'?start_date='+Math.round(start_date.getTime() / 1000)+'&end_date='+Math.round(end_date.getTime() / 1000),
// 					success:function(data) {
// 						contractors = data.contractors;
// 						callback(data.events);
// 					}
// 				});
//			},
        	
            eventRender: function(event, element) {
                 if(event.className=='expireContract'){          
                    element.find(".fc-title").prepend("<i class='fas fa-file-contract'></i>");
                 }
              }    ,
			eventAfterAllRender: function(){
				console.log({!! $events !!});
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
			 	console.log("click event "+calEvent+" "+calEvent.className);
			 	console.log(calEvent)
			 	console.log(calEvent.start)
			 	if(calEvent.className=='expireContract'){    
			 		getContractsExpiredData(calEvent.start);
			 	}else{
			 		getDetialsOfDate(calEvent.start,calEvent.serviceId);
			 	} 
 			 }	,
 			 dayClick: function(date, allDay, jsEvent, view) {
               getDetialsOfDate(date,0);
               
			                   
        	}
		});
		
		///////////////////////////////////////////////////////
		
        
        $("#companyNameSelect,#typeOfJobSelect,#engineerSelect,#companyNameSelectEdit,#typeOfJobSelectEdit,#engineerSelectEdit").select2({});
        
        
        $('#time,#timeEdit').datetimepicker({
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
                     
        $('#date,#dateEdit,#contractStartDate,#contractStartDate,#contractEndDate,#contractEndDateEdit').datetimepicker({
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
		
		 $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });
	
	});
	
	function getDetialsOfDate(date,serviceId){
		//console.log("get details of date "+serviceId);
		//Get Date Format
		var selectedDate = new Date(date);
		var d = selectedDate.getDate();
		var m = selectedDate.getMonth();
		var y = selectedDate.getFullYear();

		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var monthName = months[m];
		const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
		var dayName = days[selectedDate.getDay()]
		
		var token ='{{csrf_token()}}';
	
	console.log("job list "+serviceId);
	 $.ajax({
        type: "GET",
       	url: '{{url("unified/get_job_list/")}}'+'?date='+date.format()+'&serviceId='+serviceId,
        success: function(data) {
        	//console.log(data);
        	
        	if(data.jobsList.length==0){
                    $('#calendar-modal-job-list-empty').modal();
                    $('#calendar-modal-job-list-empty #dateSpan').html(dayName+', '+monthName+' '+d+', '+y);
                    $('#calendar-modal-job-list-empty #date').val(date.format("MM/DD/YYYY"));
                    $('#calendar-modal-job-list-empty #isDateHidden').val(1);
                    $('#calendar-modal-job-list-empty #serviceId').val(serviceId);
                    
        	}else{
        		var ulContent = '';
        		for(var i=0; i< data.jobsList.length; i++){
					ulContent = ulContent+ '<li class="list-group-item" style="background-color:'
								+data.jobsList[i].backgroundColor
								+'" onclick="clickEditScheduledJob('+data.jobsList[i].id+')"> '
								+data.jobsList[i].title 
								+'  </li>';
				}
        	
                    $('#calendar-modal-job-list').modal();
                    $('#calendar-modal-job-list #dateSpan').html(dayName+', '+monthName+' '+d+', '+y);
                    $('#calendar-modal-job-list #date').val(date.format("MM/DD/YYYY"));
                    $('#calendar-modal-job-list #isDateHidden').val(1);
                    $('#calendar-modal-job-list #serviceId').val(serviceId);
                    $("#calendar-modal-job-list #jobsListTitleModalSpan").html(data.titleModal);
                    
					$('#jobsListUl').html(ulContent);
        	}
        }
     });   
		
		
	}
	
	function getContractsExpiredData(date){
				//console.log("get details of date "+serviceId);
		//Get Date Format
		var selectedDate = new Date(date);
		var d = selectedDate.getDate();
		var m = selectedDate.getMonth();
		var y = selectedDate.getFullYear();

		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var monthName = months[m];
		const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
		var dayName = days[selectedDate.getDay()]
		
		var token ='{{csrf_token()}}';
	
	 $.ajax({
        type: "GET",
       	url: '{{url("unified/get_contract_expire/")}}'+'?date='+date.format(),
        success: function(data) {
        	console.log(data);
        	
        		var ulContent = '';
        		for(var i=0; i< data.jobsList.length; i++){
					ulContent = ulContent+ '<li class="list-group-item" style="background-color:'
								+data.jobsList[i].backgroundColor
								+'"> <a href="{{url('unified/customers/view/')}}/'+data.jobsList[i].customerId 
								+ '" >'
								+data.jobsList[i].title 
								+' </a> </li>';
				}
        	
                    $('#calendar-modal-contract-list').modal();
                    $('#calendar-modal-contract-list #dateSpan').html(dayName+', '+monthName+' '+d+', '+y);
                    $("#calendar-modal-contract-list #contractListTitleModalSpan").html(data.titleModal);
                    
					$('#calendar-modal-contract-list #contractListUl').html(ulContent);
        	
        }
     });
	}
	
	function clickServiceGetJobList(serviceId){
		var view = $('#calendar').fullCalendar('getView');
		var viewTitle = view.title; //date
		var viewName =view.name;
		//if(viewName==='month'){
			//alert(viewTitle)
			 $.ajax({
        type: "GET",
       	url: '{{url("unified/get_job_list/")}}'+'?date='+viewTitle+'&serviceId='+serviceId+'&viewName='+viewName,
        success: function(data) {
        	//console.log(data);
        	
        	if(data.jobsList.length==0){
                    $('#calendar-modal-job-list-empty').modal();
                    $('#calendar-modal-job-list-empty #dateSpan').html(viewTitle);
                    $('#calendar-modal-job-list-empty #date').val('');
                    $('#calendar-modal-job-list-empty #isDateHidden').val(0);
                    $('#calendar-modal-job-list-empty #serviceId').val(serviceId);
                    $("#calendar-modal-job-list-empty #jobsListTitleModalSpan").html(data.titleModal);
        	}else{
        		var ulContent = '';
        		for(var i=0; i< data.jobsList.length; i++){
					ulContent = ulContent+ '<li class="list-group-item" style="background-color:'
								+data.jobsList[i].backgroundColor
								+'" onclick="clickEditScheduledJob('+data.jobsList[i].id+')"> '
								+data.jobsList[i].title 
								+'  </li>';
				}
        	
                    $('#calendar-modal-job-list').modal();
                    $('#calendar-modal-job-list #dateSpan').html(viewTitle);
                    $('#calendar-modal-job-list #date').val('');
                    $('#calendar-modal-job-list #isDateHidden').val(0);
                    $('#calendar-modal-job-list #serviceId').val(serviceId);
                    $("#calendar-modal-job-list #jobsListTitleModalSpan").html(data.titleModal);
                    
					$('#jobsListUl').html(ulContent);
        	}
        }
     });   
		//}
	}
	
	function pad2(number) {
		return (number < 10 ? '0' : '') + number
	}
function clickAddScheduledJob(){
		$('#calendar-modal-add-job').modal('show');
		$('#calendar-modal-add-job #dateSpan').html('');
		$('#calendar-modal-add-job form').trigger("reset");
		
		getCompanyListOfService(0);
		
		$("#companyNameSelect,#typeOfJobSelect,#engineerSelect").select2().val('');
		
		 $("#selectedServiceTypesDiv").html('');
		$('#calendar-modal-add-job #dateDiv').html('<label>Date</label> <input type="text" id="date" class="form-control"'
												+' name="date" value=""	placeholder="Select date" required>');
		$('#calendar-modal-add-job #dateDiv').parent().css("display","block");
		$('#calendar-modal-add-job #serviceIdHidden').val(0);											
												
        $('#calendar-modal-add-job #date').datetimepicker({
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
		
		
		 addIntelInput('phone','phone');
        addIntelInput('mobile','mobile');
        initAutoComplete();
}


function clickEditScheduledJob(jobId){

	//console.log("click edit job")
	//console.log(jobId);
	var token ='{{csrf_token()}}';
	
	 $.ajax({
        type: "POST",
        method:"post",
       	url: '{{url("unified/get_job_data/")}}',
       	data: {_token: token, jobId:jobId},
        success: function(data) {
       
            //console.log(data);
            var job = data.job;
            $('#calendar-modal-edit-job #jobIdEdit').val(job.id);
            $('#calendar-modal-edit-job #emailEdit').val(job.email);
            $('#calendar-modal-edit-job #mobileEdit').val(job.mobile);
            $('#calendar-modal-edit-job #phoneEdit').val(job.phone);
            $('#calendar-modal-edit-job #addressEdit').val(job.address);
            $('#calendar-modal-edit-job #dateEdit').val(job.date);
            $('#calendar-modal-edit-job #timeEdit').val(job.time);
            
            
			$("#calendar-modal-edit-job #companyNameSelectEdit").val(job.companyId).select2();
			$("#calendar-modal-edit-job #typeOfJobSelectEdit").val(''+job.jobTypeId).select2();
			$("#calendar-modal-edit-job #engineerSelectEdit").val(''+job.engineerId).select2();
            
            if(job.contract ==true){
            	$('#calendar-modal-edit-job #contractYesEdit').prop("checked",true);
            	$('#calendar-modal-edit-job #contractDateDivEdit').html('<div class="col-md-6"> 	<div class="form-group bmd-form-group" > '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDateEdit" class="form-control" '
            						+' name="contractStartDate" value="'
            						+job.contractStartDate
            						+'" placeholder="Select contract start date" required> </div>	</div>'
            						+' <div class="col-md-6"> <div class="form-group bmd-form-group">  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDateEdit" class="form-control" name="contractEndDate" value="'
            						+job.contractEndDate
            						+'" '
            						+' placeholder="Select contract end date" required> </div> </div>');
            						
            	$('#calendar-modal-edit-job #contractStartDateEdit,#calendar-modal-edit-job #contractEndDateEdit').datetimepicker({
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
            	$('#calendar-modal-edit-job #contractNoEdit').prop("checked",true);
            	$('#calendar-modal-edit-job #contractDateDivEdit').html('');
            }
            
             if(job.sendEmail ==true){
            	$('#calendar-modal-edit-job #sendReminderRadioEdit').prop("checked",true);
            }else{
            	$('#calendar-modal-edit-job #sendReminderRadioEdit').prop("checked",false);
            }
            
            
	//console.log("change company edittttt ")
            var serviceTypesDivHtml = '';
            for(var i=0; i<job.serviceTypes.length; i++){
            	serviceTypesDivHtml += '<input type="radio" name="selectedServiceType" title="'+job.serviceTypes[i].name
            							+'" value="'+job.serviceTypes[i].id+'" id="serviceTypeE'+job.serviceTypes[i].id+ '" >';
            }
                       
            $("#selectedServiceTypesDivEdit").html(serviceTypesDivHtml);
            $("#selectedServiceTypesDivEdit").zInput();
            
            $("#selectedServiceTypesDivEdit #serviceTypeE"+job.selectedServiceType).prop('checked',true);
            $("#selectedServiceTypesDivEdit #serviceTypeE"+job.selectedServiceType).parent().parent().parent().addClass("zSelected");
            
            addIntelInput('phoneEdit','phone');
        	addIntelInput('mobileEdit','mobile');
       		initAutoComplete();
       		
       $('#calendar-modal-job-list').modal('hide');
       		
       $('#calendar-modal-edit-job').modal('show');
        }
    });

		//$('#calendar-modal-edit-job').html(dayName+', '+monthName+' '+d+', '+y);
		
		
}
function clickDeleteJob(){
$('#calendar-modal-edit-job').modal('hide')
$('#calendar-modal-delete-job').modal('show')
$('#calendar-modal-delete-job #jobId').val($('#calendar-modal-edit-job #jobIdEdit').val());
}

function clickAddScheduledJobListModal(list){// nojob, hasjobs
		var dateSpanVal = $("#calendar-modal-job-list #dateSpan").text();
		var dateVal = $("#calendar-modal-job-list #date").val();
		var isHiddenDate = $('#calendar-modal-job-list #isDateHidden').val();
        var selectedService = $('#calendar-modal-job-list #serviceId').val();
		//console.log(dateVal);

		if(list === 'nojob'){
			dateSpanVal = $("#calendar-modal-job-list-empty #dateSpan").text();
		 	dateVal = $("#calendar-modal-job-list-empty #date").val();
			isHiddenDate = $('#calendar-modal-job-list-empty #isDateHidden').val();
			selectedService = $('#calendar-modal-job-list-empty #serviceId').val();
			//console.log(dateVal +"  "+isHiddenDate+" "+selectedService);
			
			$('#calendar-modal-job-list-empty').modal('hide')
			
		}else if(list === 'hasjobs'){
			dateSpanVal = $("#calendar-modal-job-list #dateSpan").text();
			dateVal = $("#calendar-modal-job-list #date").val();
			isHiddenDate = $('#calendar-modal-job-list #isDateHidden').val();
			selectedService = $('#calendar-modal-job-list #serviceId').val();
			//console.log(dateVal +"  "+isHiddenDate +" "+selectedService);
			
			$('#calendar-modal-job-list').modal('hide')
			
		}
		getCompanyListOfService(selectedService);

		$('#calendar-modal-add-job').modal('show');
		$('#calendar-modal-add-job #dateSpan').html(dateSpanVal);
		
		$('#calendar-modal-add-job #serviceIdHidden').val(selectedService);											
		
		$('#calendar-modal-add-job form').trigger("reset");
		$("#companyNameSelect,#typeOfJobSelect,#engineerSelect").select2().val('');
		
		 $("#selectedServiceTypesDiv").html('');
		
		if(isHiddenDate == 1){
		$('#calendar-modal-add-job #dateDiv').html('<input type="hidden" name="date" id="date" value="'+dateVal+'">');
		$('#calendar-modal-add-job #dateDiv').parent().css("display","none");
		}else{
		$('#calendar-modal-add-job #dateDiv').html('<label>Date</label> <input type="text" id="date" class="form-control"'
												+' name="date" value=""	placeholder="Select date" required>');
		$('#calendar-modal-add-job #dateDiv').parent().css("display","block");
												 
												 $('#calendar-modal-add-job #date').datetimepicker({
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
		
		 addIntelInput('phone','phone');
        addIntelInput('mobile','mobile');
}

function getCompanyListOfService(serviceId){
		 $.ajax({
        type: "GET",
       	url: '{{url("unified/get_company_list_of_service/")}}'+'?serviceId='+serviceId,
        success: function(data) {
        	//console.log(data);
        	
        	var selectContent='<option value="" selected class="placeholdered">Select company</option>';
        	
        	for(var i=0; i<data.companyNames.length; i++){
        		selectContent += '<option value="'+data.companyNames[i].id+'"> '+ data.companyNames[i].name +'  </option>';
        	}
        	$("#companyNameSelect").html(selectContent);
        	
        	//$("#companyNameSelect").select2();
        	
        }
     });
}

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
            $('#calendar-modal-add-job #email').val(company.email);
            $('#calendar-modal-add-job #mobile').val(company.mobile);
            $('#calendar-modal-add-job #phone').val(company.phone);
            $('#calendar-modal-add-job #address').val(company.address);
            
            if(company.contract ==true){
            	$('#calendar-modal-add-job #contractYes').prop("checked",true);
            	$('#calendar-modal-add-job #contractDateDiv').html('<div class="col-md-6"> 	<div class="form-group bmd-form-group" > '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDate" class="form-control" '
            						+' name="contractStartDate" value="'
            						+company.contractStartDate
            						+'" placeholder="Select contract start date" required> </div>	</div>'
            						+' <div class="col-md-6"> <div class="form-group bmd-form-group" >  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDate" class="form-control" name="contractEndDate" value="'
            						+company.contractEndDate
            						+'" '
            						+' placeholder="Select contract end date" required> </div> </div>');
            						
            	$('#calendar-modal-add-job #contractStartDate,#calendar-modal-add-job #contractEndDate').datetimepicker({
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
            	$('#calendar-modal-add-job #contractNo').prop("checked",true);
            	$('#calendar-modal-add-job #contractDateDiv').html('');
            }
            
            
           // console.log(":D:D " +$('#calendar-modal-add-job #serviceIdHidden').val());
            var serviceIdHidden =$('#calendar-modal-add-job #serviceIdHidden').val();
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
	setSubmitButtonEnable()
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
		$('#calendar-modal-add-job #contractDateDiv').html('<div class="col-md-6"> 	<div class="form-group bmd-form-group"> '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDate" class="form-control" '
            						+' name="contractStartDate" value="" placeholder="Select contract start date" required> </div>	</div>'
            						+' <div class="col-md-6"> <div class="form-group bmd-form-group">  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDate" class="form-control" name="contractEndDate" value="" '
            						+' placeholder="Select contract end date" required> </div> </div>');
        		
            	$('#calendar-modal-add-job #contractStartDate,#calendar-modal-add-job #contractEndDate').datetimepicker({
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
        $('#calendar-modal-add-job #contractDateDiv').html('');
	}
}

function clickContractEdit(val){
	console.log("click contract edit "+val)
	if(val==1){
		$('#calendar-modal-edit-job #contractDateDivEdit').html('<div class="col-md-6"> 	<div class="form-group bmd-form-group"> '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDateEdit" class="form-control" '
            						+' name="contractStartDate" value="" placeholder="Select contract start date" required> </div>	</div>'
            						+' <div class="col-md-6"> <div class="form-group bmd-form-group">  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDateEdit" class="form-control" name="contractEndDate" value="" '
            						+' placeholder="Select contract end date" required> </div> </div>');
        		
            	$('#calendar-modal-edit-job #contractStartDateEdit,#calendar-modal-edit-job #contractEndDateEdit').datetimepicker({
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
        $('#calendar-modal-edit-job #contractDateDivEdit').html('');
	}
}
/////////////////////////// edit 
function changeCompanyEdit(){
	var companyVal = $("#companyNameSelectEdit").val();
	//console.log(companyVal);
	var token ='{{csrf_token()}}';
	//console.log("change company edit")
	 $.ajax({
        type: "POST",
        method:"post",
       	url: '{{url("unified/customers/get_company_data/")}}',
       	data: {_token: token, companyId:companyVal},
        success: function(data) {
       
            //console.log(data);
            var company = data.company;
            $('#calendar-modal-edit-job #emailEdit').val(company.email);
            $('#calendar-modal-edit-job #mobileEdit').val(company.mobile);
            $('#calendar-modal-edit-job #phoneEdit').val(company.phone);
            $('#calendar-modal-edit-job #addressEdit').val(company.address);
            
            if(company.contract ==true){
            	$('#calendar-modal-edit-job #contractYesEdit').prop("checked",true);
            	$('#calendar-modal-edit-job #contractDateDivEdit').html('<div class="col-md-6"> 	<div class="form-group bmd-form-group" > '
            						+' <label>Contract start date</label> <input type="text" id="contractStartDateEdit" class="form-control" '
            						+' name="contractStartDate" value="'
            						+company.contractStartDate
            						+'" placeholder="Select contract start date" required> </div>	</div>'
            						+' <div class="col-md-6"> <div class="form-group bmd-form-group">  <label>Contract end date</label> '
            						+' <input type="text" id="contractEndDateEdit" class="form-control" name="contractEndDate" value="'
            						+company.contractEndDate
            						+'" '
            						+' placeholder="Select contract end date" required> </div> </div>');
            						
            	$('#calendar-modal-edit-job #contractStartDateEdit,#calendar-modal-edit-job #contractEndDateEdit').datetimepicker({
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
            	$('#calendar-modal-edit-job #contractNoEdit').prop("checked",true);
            	$('#calendar-modal-edit-job #contractDateDivEdit').html('');
            }
            
                        
			//console.log("change company edit scuccess")
            
            var serviceTypesDivHtml = '';
            for(var i=0; i<company.serviceType.length; i++){
            	serviceTypesDivHtml += '<input type="radio" name="selectedServiceType" title="'+company.serviceType[i].name
            							+'" value="'+company.serviceType[i].id+'"> ';
            }
                       
            $("#selectedServiceTypesDivEdit").html(serviceTypesDivHtml);
            $("#selectedServiceTypesDivEdit").zInput();
            
            //setSubmitButtonEnableEdit();
        }
    });
}
/* function changeTypeOfJobEdit(){
	//console.log("type of job "+$("#typeOfJobSelectEdit").val());
	setSubmitButtonEnableEdit()
}
function changeEngineerEdit(){
	//console.log("engineer " +$("#engineerSelectEdit").val() );
	setSubmitButtonEnableEdit()
}
function setSubmitButtonEnableEdit(){
	var companyVal = $("#companyNameSelectEdit").val();
	var typeOfJobVal =$("#typeOfJobSelectEdit").val();
	var engineerVal =$("#engineerSelectEdit").val();
	
	if(companyVal!='' && typeOfJobVal!='' && engineerVal!=''){
		$('#createJobButton').prop("disabled",false);
	}else{
		$('#createJobButton').prop("disabled",true);
	}
	
} */
   
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
		}
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initAutoComplete"></script>

@endsection
