@extends('templates.dashboard') @section('title', 'Do OmYoga | New
Event') @section('page-styles')
<style>
.select2-container {
	padding: 5px;
	border-radius: 10px;
	box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
	background-color: #ffffff;
	font-size: 14px !important;
	font-weight: normal !important;
}

.select2-container--default .select2-selection--multiple,
	.select2-container .select2-selection--single {
	width: 100% !important;
	height: auto;
}

.select2-results__option {
	font-family: 'Futura', Fallback, sans-serif !important;;
	font-size: 14px !important;
	font-weight: normal !important;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
}

.select2-results__option:hover {
	font-family: 'Futura', Fallback, sans-serif !important;;
	font-size: 14px !important;
	font-weight: normal !important;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.32px;
	color: #4d4d4d;
	background-color: grey;
}

.select2-container .select2-selection--single {
	border-bottom: none !important;
}

.select2-container .select2-selection--single .select2-selection__rendered
	{
	color: #4d4d4d !important;
	font-size: 14px !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple,
	.select2-container--default .select2-selection--multiple {
	border: none !important;
}

.modal-dialog .modal-header .close {
	top: 20px !important;
}

.modal-header .close {
	width: 15px;
	height: 15px;
	margin: 39px 37px 35px 49px;
	background-color: #4f4f4f;
	border-radius: 30px;
	color: white !important;
	padding: 0.6rem;
	opacity: 1 !important;
	width: 15px;
}

.modal-header .close i {
	font-size: 10px !important;
	margin: -5px;
}
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<form action="{{route('postNewEventDoomYoga', 'doom-yoga')}}"
				method="POST" id="addEventForm" enctype="multipart/form-data"
				autocomplete="off">
				{{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-sm-6">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/doom-yoga/New-Event.png')}}">
									</div>
									<h4 class="card-title ">New Event</h4>
								</div>
								<div class="col-6 col-sm-6 mt-4">
									<div class="row justify-content-end"></div>
								</div>
							</div>
							<div class="card-body">
								<div class="container py-4">
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
										<div class="col-md-12 d-flex form-head pl-3 py-2">
											<span> 1 </span>
											<h5 class="formSubTitleH5">Event Details</h5>
										</div>
									</div>
									<div class="row">


										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Event Name</label> <input
													type="text" class="form-control" name="event_name" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Event type</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="event_type" id="inlineRadioRegular"
															value="regular_event" class="form-check-input" required>
															Regular event <span class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="event_type" id="inlineRadioClass" value="class"
															class="form-check-input" required> Class <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Short description</label>
												<textarea class="form-control" name="short_description"
													rows="5" required></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Max. participants</label> <input
													type="number" class="form-control" name="max_participants"
													required>
											</div>
											<div class="form-group bmd-form-group">
												<label class="formLabel">Date/Time</label> <input
													type="text" class="form-control datetimepicker"
													id="date_time" name="date_time" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Duration in minutes</label> <input
													type="number" class="form-control"
													name="duration_in_minutes" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Is the event in person?</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="is_event_person" id="inlineRadioP1" value="1"
															class="form-check-input" required> Yes <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="is_event_person" id="inlineRadioP0" value="0"
															class="form-check-input" required> No <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Display events x weeks in advance</label>
												<input type="text" class="form-control"
													name="display_events_weeks_advance" required>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">This event is reccuring</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="is_event_reccuring" id="inlineRadioR1" value="1"
															class="form-check-input" required> Yes <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="is_event_reccuring" id="inlineRadioR0" value="0"
															class="form-check-input" required> No <span
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

						<div class="card">

							<div class="card-body">
								<div class="container py-4">

									<div class="row">
										<div class="col-md-12 d-flex form-head pl-3 py-2">
											<span> 2 </span>
											<h5 class="formSubTitleH5">Stream Settings</h5>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Automatic zoom link</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="automatic_zoom_link" id="inlineRadioZ1" value="1"
															class="form-check-input" required> Yes <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="automatic_zoom_link" id="inlineRadioZ0" value="0"
															class="form-check-input" required> No <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Stream link (eg Zoom)</label> <input
													type="text" class="form-control" name="stream_link"
													required>
											</div>
										</div>


										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Stream password</label> <input
													type="text" class="form-control" name="stream_password"
													required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card">

							<div class="card-body">
								<div class="container py-4">

									<div class="row">
										<div class="col-md-12 d-flex form-head pl-3 py-2">
											<span> 2 </span>
											<h5 class="formSubTitleH5">Payment Settings</h5>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Free event</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="free_event" id="inlineRadioF1" value="1"
															class="form-check-input" required> Yes <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="free_event" id="inlineRadioF0" value="0"
															class="form-check-input" required> No <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Free ticket option</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="free_ticket_option" id="inlineRadioT1" value="1"
															class="form-check-input" required> Yes <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="free_ticket_option" id="inlineRadioT0" value="0"
															class="form-check-input" required> No <span
															class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>

											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Ticket price settings</label>
												<div class="radio-container row">
													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="ticket_price_settings" id="inlineRadioTP1"
															value="1" class="form-check-input" required> Fixed price
															<span class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>

													<div
														class="col-6 form-check form-check-radio  d-flex justify-content-between">
														<label class="form-check-label"> <input type="radio"
															name="ticket_price_settings" id="inlineRadioTP0"
															value="0" class="form-check-input" required> Users pick
															price <span class="circle"> <span class="check"></span>
														</span>
														</label>
													</div>
												</div>

											</div>
										</div>


										<div class="col-sm-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Price in £</label> <input
													type="number" step="any" class="form-control" name="price"
													required>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>


				</div>
				<div class="row text-center">
					<div class="col-12 text-center">

						<button id="addEventBtn" type="submit"
							class="btn btn-doomyoga-grey" id="">Create event</button>

					</div>
				</div>
			</form>
		</div>

	</div>
</div>

<!-- success new event modal -->
<div class="modal fade" id="success-new-event-modal" tabindex="-1"
	role="dialog" aria-labelledby="success-new-event-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content p-5">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body text-center">

				<img class="" src="{{asset('images/doom-yoga/successfully.png')}}"
					width="160">
				<div class="modal-dialog-header modalHeaderH2 mt-4 mb-5">
					<h2 id="successMessageHeaderDiv"></h2>
				</div>


			</div>
			<div class="modal-footer d-flex justify-content-around">
				<a href="{{route('getNewEventDoomYoga', 'doom-yoga')}}"
					class="btn  btn-doomyoga-grey">Done</a>
				<button type="button" class="btn btn-doomyoga-black"
					onclick="clickShareEvent()">Share event</button>
			</div>


		</div>
	</div>
</div>
<!-- share event modal -->
<div class="modal fade" id="share-event-modal" tabindex="-1"
	role="dialog" aria-labelledby="share-event-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content p-5">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form action="{{route('postShareEventDoomYoga', 'doom-yoga')}}"
				method="POST" id="shareEventForm" autocomplete="off">
				{{csrf_field()}}
				<div class="modal-body ">
					<input type="hidden" name="eventId" id="eventId">
					<div class="row justify-content-md-center">
						<div class="col-md-5 col-sm-6 mt-2">
							<label class="eventShareLabel">Share event with</label>
						</div>
						<div class="col-md-5 col-sm-6">
							<div class="form-group bmd-form-group">
								<select class="form-control" name="share_with"
									id="shareWithSelect" onchange="shangeShareSelect()">
									<option value="all" selected="selected">All</option>
									<option value="level">Level</option>
									<option value="selected_subscribers">Selected subscribers</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-5 offset-md-6 col-sm-6   offset-sm-6"
							id="levelSelectDiv" style="display: none;">

							<select class="form-control" name="level" id="levelSelect">
								<option value="">Select level</option>
								<option value="Beginner">Beginner</option>
								<option value="Intermediate">Intermediate</option>
								<option value="Advanced">Advanced</option>
							</select>

						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-5 offset-md-6 col-sm-6  offset-sm-6"
							id="selectedSubscribersSelectDiv" style="display: none;">

							<select class="form-control" name="selected_subscribers[]"
								id="selectedSubscribersSelect" multiple="multiple">
								<option value="1">Jane Dow</option>
								<option value="2">Adam Andrews</option>
							</select>
						</div>
					</div>


				</div>
				<div class="modal-footer " style="display: block !important;">
					<div class="row mt-2">
						<div class="col-md-5 offset-md-6 col-sm-6   offset-sm-6">

							<button type="submit" class="btn btn-doomyoga-grey">Share</button>
						</div>
					</div>
				</div>
			</form>


		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">

var eventId;
 $(document).ready(function() {
 $('#share-event-modal select').css('width', '100%');
 $('#shareWithSelect').select2({    minimumResultsForSearch: -1}).val('all');
 $('#levelSelect').select2({    minimumResultsForSearch: -1,placeholder:'Select level' });
  $('#selectedSubscribersSelect').select2({ dropdownParent: "#share-event-modal" });
  
        $('#date_time').datetimepicker({
						icons: {
							time: "fa fa-clock",
							date: "fa fa-calendar",
							up: "fa fa-chevron-up",
							down: "fa fa-chevron-down",
							previous: 'fa fa-chevron-left',
							next: 'fa fa-chevron-right',
							today: 'fa fa-screenshot',
							clear: 'fa fa-trash',
							close: 'fa fa-remove'
						}, 
					});
					
		$('#addEventForm').on('submit', function(e) {
    e.preventDefault(); 
    console.log($(this).serialize());
    $.ajax({
        type: "POST",
       	url: '{{url("doom-yoga/events/add_event")}}',
        data: $(this).serialize(),
        success: function(data) {
       
        console.log(data.subscribers);
        
         $("#selectedSubscribersSelect").html("");
        for(var i=0; i<data.subscribers.length; i++){
        $("#selectedSubscribersSelect").append('<option value="'+data.subscribers[i].id+'">'+data.subscribers[i].name+'</option>');
        }


        
        eventId = data.eventId;
$('#success-new-event-modal').modal('show')
$('#success-new-event-modal #successMessageHeaderDiv').html(data.msg);
        }
    });
});			
    });
    
function clickShareEvent(){
$('#success-new-event-modal').modal('hide')
$('#share-event-modal').modal('show')
$('#share-event-modal #eventId').val(eventId);
}    



function shangeShareSelect(){
	var shareSelectVal = $("#shareWithSelect").val();
	if(shareSelectVal=='level'){
    	$("#levelSelectDiv").css('display','block');
    	$("#selectedSubscribersSelectDiv").css('display','none');
	}else if(shareSelectVal=='selected_subscribers'){
    	$("#levelSelectDiv").css('display','none');
    	$("#selectedSubscribersSelectDiv").css('display','block');
	}
}
</script>
@endsection
