@extends('templates.dashboard') @section('title', 'Do OmYoga | My
Events') @section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

.modal-dialog .modal-header .close {
	top: 0 !important;
	right: 15px
}

.formLabel {
	font-size: 15px !important;
	font-weight: 600;
}

.formSpan {
	margin-left: 10px;
	font-weight: normal !important;
	font-size: 14px !important;
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
									<img class="page_icon"
										src="{{asset('images/doom-yoga/My-Events.png')}}">
								</div>
								<h4 class="card-title ">My Events</h4>
							</div>
							<div class="col-6 col-sm-6 mt-4">
								<div class="row justify-content-end"></div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table id="myEventsTable"
										class="table table-no-bordered table-hover gardenHelpTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th>Date/Time</th>
												<th>Name</th>
												<th>Event Type</th>
												<th>Event In Person</th>
												<th>Duration in Mins</th>
												<th>Attending</th>
												<th>Reccuring</th>
											</tr>
										</thead>

										<tbody>
											@if(count($myevents) > 0) @foreach($myevents as $event)
											<tr class="order-row" onclick="clickEvent({{$event->id}})">
												<td>{{$event->dateTime}}</td>
												<td>{{$event->event_name}}</td>
												<td>{{$event->event_type}}</td>
												<td>{{$event->eventInPerson}}</td>
												<td>{{$event->durationInMins}}</td>
												<td>{{$event->attending}}</td>
												<td>{{$event->reccuring}}</td>
											</tr>
											@endforeach @endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- event data modal -->
<div class="modal fade" id="event-data-modal" tabindex="-1"
	role="dialog" aria-labelledby="event-data-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content p-3">
			<div class="modal-header">

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form action="{{route('postLaunchMeetingDoomYoga', 'doom-yoga')}}"
				method="POST" id="launchMeetingForm" autocomplete="off">
				{{csrf_field()}}
				<div class="modal-body ">
					<input type="hidden" name="eventId" id="eventId">
					<div class="card-body">

						<div class="container py-4">

							<div class="row">
								<div class="col-md-12 d-flex form-head pl-3 py-2">
									<span> 1 </span>
									<h5 class="formSubTitleH5" style="font-weight: 600">Event
										Details</h5>
								</div>
							</div>
							<div class="row">


								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Event name:</label> <span
											id="eventNameSpan" class="formSpan"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Event in person: </label> <span
											id="eventInPersonSpan" class="formSpan"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Event type: </label> <span
											id="eventTypeSpan" class="formSpan"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Attending: </label> <span
											id="attendingSpan" class="formSpan"></span>
									</div>
								</div>

								<div class="col-sm-6">

									<div class="form-group bmd-form-group">
										<label class="formLabel">Date: </label> <span id="dateSpan"
											class="formSpan"></span>
									</div>
									<div class="form-group bmd-form-group">
										<label class="formLabel">Time: </label> <span id="timeSpan"
											class="formSpan"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Reccuring: </label> <span
											id="eventIsReccuringSpan" class="formSpan"></span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Duration in minutes:</label> <span
											id="eventDurationSpan" class="formSpan"></span>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group bmd-form-group">
										<label class="formLabel">Short description</label>
										<p id="eventShortDescriptionSpan" class="formSpan"></p>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer " style="display: block !important;">
					<div class="row mt-0 text-center">
						<div class="col-12">

							<button type="submit" class="btn btn-doomyoga-grey">Launch
								meeting</button>
						</div>
					</div>
				</div>
			</form>


		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
     $('#myEventsTable').DataTable({
          fixedColumns: true,
          "lengthChange": false,
          "searching": false,
  		  "info": false,
  		  "ordering": false,
    });
 });  
 
 function clickEvent(eventId){
 
  $.ajax({
        type: "GET",
       	url: '{{url("doom-yoga/events/get_event_data")}}?eventId='+eventId,
        success: function(data) {
       
        console.log(data.event);
        
		$('#event-data-modal').modal('show')
		$('#event-data-modal #eventId').val(data.event.id);
		$('#event-data-modal #eventNameSpan').text(data.event.name);
		$('#event-data-modal #eventInPersonSpan').text(data.event.is_person == 1 ? 'Yes' : 'No' );
		$('#event-data-modal #eventTypeSpan').text(data.event.type == 'class' ? 'Class' : 'Regular event');
		$('#event-data-modal #attendingSpan').text(data.event.attending);
		$('#event-data-modal #dateSpan').text(moment(data.event.date_Time).format('L'));
		$('#event-data-modal #timeSpan').text(moment(data.event.date_Time).format('LT'));
		$('#event-data-modal #eventIsReccuringSpan').text(data.event.is_reccuring == 1 ? 'Yes' : 'No' );
		$('#event-data-modal #eventDurationSpan').text(data.event.duration +' minutes');
		$('#event-data-modal #eventShortDescriptionSpan').text(data.event.name);
		
        }
    });
 
 } 
</script>
@endsection
