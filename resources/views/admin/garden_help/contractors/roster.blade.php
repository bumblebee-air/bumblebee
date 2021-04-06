@extends('templates.dashboard') @section('title', 'GardenHelp |
Contractors Requests') @section('page-styles')

<link href="{{asset('css/calender-design-styles.css')}}"
	rel="stylesheet">
<style>
#wrap {
	width: 1100px;
	margin: 0 auto;
}

#external-events {
	float: left;
	width: 150px;
	padding: 0 10px;
	text-align: left;
}

#external-events h4 {
	font-size: 16px;
	margin-top: 0;
	padding-top: 1em;
}

.external-event { /* try to mimick the look of a real event */
	margin: 10px 0;
	padding: 2px 4px;
	background: #3366CC;
	color: #fff;
	font-size: .85em;
	cursor: pointer;
}

#external-events p {
	margin: 1.5em 0;
	font-size: 11px;
	color: #666;
}

#external-events p input {
	margin: 0;
	vertical-align: middle;
}

#calendar {
	/* 		float: right; */
	margin: 0 auto;
	width: 92%;
	background-color: #FFFFFF;
	border-radius: 6px;
	box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0px 0px 21px 2px rgba(0, 0, 0, 0.18);
	-moz-box-shadow: 0px 0px 21px 2px rgba(0, 0, 0, 0.18);
	box-shadow: 0px 0px 21px 2px rgba(0, 0, 0, 0.18);
}

.fc-header td, .fc th {
	border-style: none !important;
}
.modal-dialog .modal-header{
padding: 0!important;
}
.list-group-item {
	padding: 15px;
	margin: 5px 10px;
	border-radius: 10px !important;
	font-family: Open Sans;
	font-size: 17px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.35;
	letter-spacing: -0.33px;
	color: #ffffff;
}

.list-group-item.level1 {
	background-color: #60a244;
}

.list-group-item.level2 {
	background-color: #d89556;
}

.list-group-item.level3 {
	background-color: #c64f4f;
}
.status_item i{
font-size: 12px !important;
}
.status_item.level1 i{
    color:#60a244;
}
.status_item.level2 i{
    color:#d89556;
}
.status_item.level3 i{
    color:#c64f4f;
}
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-sm-6">
								<div class="card-icon">
									<i class="fas fa-calendar-alt"></i>
								</div>
								<h4 class="card-title ">Contractors Roster</h4>
							</div>
							<div class="col-12 col-sm-6">
								 <div class="row justify-content-end">
                                        <div class="status">
                                            <div class="status_item level1">
                                                <i class="fas fa-circle"></i>
                                                (0-2 years)
                                            </div>
                                            <div class="status_item level2">
                                                <i class="fas fa-circle"></i>
                                                (2-5 years)
                                            </div>
                                            <div class="status_item level3">
                                                <i class="fas fa-circle"></i>
                                                (+5 years)
                                            </div>
                                        </div>
                                    </div>
							</div>

						</div>
						<div class="card-body">
							<div class="container">

								<div id='calendar'></div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>



<!-- date details modal -->
<div class="modal fade" id="calendar-modal" tabindex="-1" role="dialog"
	aria-labelledby="calendar-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header deleteHeader">
					<span id="dateSpan"></span>
				</div>

				<div>
					<ul class="list-group" id="dateDetailsUl">
						<li class="list-group-item">Cras justo odio</li>
						<li class="list-group-item">Dapibus ac facilisis in</li>
						<li class="list-group-item">Morbi leo risus</li>
						<li class="list-group-item">Porta ac consectetur ac</li>
						<li class="list-group-item">Vestibulum at eros</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end date details modal -->
@endsection @section('page-scripts')

<script src="{{asset('js/calender-design.js')}}"></script>

<script type="text/javascript">
	let contractors = [];
	$(document).ready(function() {
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		/*  className colors
		
		className: default(transparent), important(red), chill(pink), success(green), info(blue)
		
		*/		
		
		  
		/* initialize the external events
		-----------------------------------------------------------------*/
	
		$('#external-events div.external-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
	
	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		
		var calendar =  $('#calendar').fullCalendar({
			header: {
				//left: 'title',
				left:'',
				center: 'prev title next',
				right:''
				//center: 'agendaDay,agendaWeek,month',
				//right: 'prev,next today'
			},
   	 		eventorder: "-title",
			
			editable: true,
			firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			selectable: true,
			defaultView: 'month',
			
			axisFormat: 'h:mm',
			columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
			allDaySlot: false,
			selectHelper: true,
			
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped
			
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
				
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
				
				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
				
			},
			
			{{--events: {!! $events !!},--}}
			events: function(start_date, end_date, callback) {
				$.ajax({
					type:'GET',
					url: '{{url("garden-help/contractors/roster-events")}}'+'?start_date='+Math.round(start_date.getTime() / 1000)+'&end_date='+Math.round(end_date.getTime() / 1000),
					success:function(data) {
						contractors = data.contractors;
						callback(data.events);
					}
				});
			},

			 eventClick: function(calEvent, jsEvent, view) {
               getDetialsOfDate(calEvent.start);            
 			 }	,
 			 dayClick: function(date, allDay, jsEvent, view) {
               getDetialsOfDate(date);
			 },
		});
		
		
	});
	
	function getDetialsOfDate(date){
		//Get Date Format
		var selectedDate = new Date(date);
		var d = selectedDate.getDate();
		var m = selectedDate.getMonth();
		var y = selectedDate.getFullYear();

		var ulContent = '';
		let key = y+'-'+pad2(m+1)+'-'+pad2(d);
		let contractors_data = contractors[key];
		for(var i=0; i< contractors_data.length; i++){
			ulContent = ulContent+ '<li class="list-group-item '+contractors_data[i].className+'"> '+contractors_data[i].title +'  </li>';
		}


		const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		var monthName = months[m];
		const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
		var dayName = days[selectedDate.getDay()]

		$('#calendar-modal').modal('show');
		$('#calendar-modal #dateSpan').html(dayName+', '+monthName+' '+d+', '+y);

		$('#dateDetailsUl').html(ulContent);
	}

	function pad2(number) {
		return (number < 10 ? '0' : '') + number
	}
</script>
@endsection
