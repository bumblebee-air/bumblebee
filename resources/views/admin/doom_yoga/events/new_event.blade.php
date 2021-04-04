@extends('templates.dashboard') @section('title', 'Do OmYoga | New
Event') @section('page-styles')
<style>
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
													rows="5" required> </textarea>
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
													type="number" step="any" class="form-control"
													name="stream_password" required>
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

				<img class="" src="{{asset('images/doom-yoga/successfully.png')}}" width="160">
				<div class="modal-dialog-header modalHeaderH2 mt-4 mb-5">
					<h2 id="successMessageHeaderDiv"></h2>
				</div>


			</div>
			<div class="modal-footer d-flex justify-content-around">
				<a href="{{route('getNewEventDoomYoga', 'doom-yoga')}}" class="btn  btn-doomyoga-grey"
					>Done</a>
				<button type="button"
					class="btn btn-doomyoga-black">Share event</button>
			</div>


		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
 $(document).ready(function() {
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
       
        
$('#success-new-event-modal').modal('show')
$('#success-new-event-modal #successMessageHeaderDiv').html(data.msg);
        }
    });
});			
    });
</script>
@endsection
