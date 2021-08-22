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

										<ul class="servicesCalendarUl" id="serciesUiUl">

										
										</ul>
										
										<div class="row">
											<div class="col-md-6 offset-md-6">
												<a class=" btn-add-calendar" style="float: right;"
													href="{{route('unified_getAddScheduledJob', ['unified','0','0'])}}">
													<img class=""
														src="{{asset('images/unified/add-icon.png')}}">
												</a>
											
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
         	
       	events: function(start_date, end_date,timezone, callback) {
       	       	
				$.ajax({
					type:'GET',
					url: '{{url("unified/calendar-events")}}'+'?start_date='+Math.round(start_date/ 1000)+'&end_date='+Math.round(end_date / 1000),
					success:function(data) {
					console.log(data);
						//contractors = data.contractors;
						callback(JSON.parse(data.events));
						
						var servicesUl = '';
						for(var i =0; i<data.services.length; i++){
							var service=data.services[i];
							servicesUl += '<li class="mb-1" onclick="clickServiceGetJobList('
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
			 	console.log("click event "+calEvent+" "+calEvent.className);
			 	console.log(calEvent)
			 	console.log(calEvent.start)
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
	

	
	
	function pad2(number) {
		return (number < 10 ? '0' : '') + number
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

    </script>
@endsection
