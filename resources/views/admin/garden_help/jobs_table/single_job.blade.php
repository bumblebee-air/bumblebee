@extends('templates.dashboard') @section('title', 'GardenHelp | Job')
@section('page-styles')
<style>
.main-panel>.content {
	margin-top: 0px;
}

.modal-content {
	padding: 51px !important;
	border-radius: 30px !important;
	border: solid 1px #979797 !important;
	background-color: #ffffff;
}

@media ( min-width : 576px) {
	.modal-dialog {
		max-width: 972px !important;
		margin-left: 16.75rem !important;
		margin-right: 16.75rem !important;
	}
}

@media ( max-width : 767px) {
	.container-fluid {
		padding-left: 0px !important;
		padding-right: 0px !important;
	}
	.col-12 {
		padding-left: 5px !important;
		padding-right: 5px !important;
	}
	.form-group label {
		margin-left: 0 !important;
	}
	.btn-register {
		float: none !important;
	}
}

.modal-header .close {
	width: 15px;
	height: 15px;
	margin: 39px 37px 95px 49px;
	background-color: #e8ca49;
	border-radius: 30px;
	color: white !important;
	top: -20px !important;
	padding: 0.6rem;
}

.modal-header .close i {
	font-size: 10px !important;
}

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}
</style>

<style>
input[type="radio"] {
	display: none;
}

.radioLabel {
	height: 180px;
	width: 240px;
	border: 6px solid #18f98d
}

input[type="radio"]:checked+div, input[type="radio"]:checked+label {
	background-color: #f7f7f7;
}

input[type="radio"]:checked+div i {
	color: #60a244;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose">
							<div class="card-icon">
								{{-- <i class="material-icons">home_work</i>--}} <img
									class="page_icon"
									src="{{asset('images/gardenhelp_icons/Job-Table-white.png')}}">
							</div>
							<h4 class="card-title ">Job No {{$job->id}}</h4>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-7 col-sm-6 col-12">
										<div class="row">
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Location: <span
														class="form-control customerRequestSpan col-12">{{$job->work_location}}
													</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Type of work: <span
														class="form-control customerRequestSpan col-12">{{$job->type_of_work}}</span></label>
												</div>
											</div>


											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Personal Details</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Name: <span
														class="form-control customerRequestSpan col-12">{{$job->name}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Email: <span
														class="form-control customerRequestSpan col-12">{{$job->email}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Contact through: <span
														class="form-control customerRequestSpan col-12">{{$job->contact_through}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row ">
													<label class="requestLabel  col-12">Phone number: <span
														class="form-control customerRequestSpan  col-12">{{$job->phone_number}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Service Details</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Service type: <span
														class="form-control customerRequestSpan col-12">{{$job->service_types}}</span></label>
												</div>
											</div>

											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Property Information</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Address: <span
														class="form-control customerRequestSpan col-12">{{$job->location}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Property Image</label>
													<div class="col">
														<img src="{{asset($job->property_photo)}}"
															style="width: 200px; height: 200px">
													</div>
												</div>
											</div>


											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Property size: <span
														class="form-control customerRequestSpan col-12">{{$job->property_size}}</span></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Is this the first time
														you do service for your property?: <span
														class="form-control customerRequestSpan col-12">{{$job->is_first_time
															? 'Yes' : 'No'}}</span>
													</label>
												</div>
											</div>
											@if($job->is_first_time != 1)
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">When Was the last
														Service?: <span
														class="form-control customerRequestSpan col-12">{{$job->last_service}}</span>
													</label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Site details: <span
														class="form-control customerRequestSpan col-12">{{$job->site_details}}</span></label>
												</div>
											</div>
											@endif
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel col-12">Is there a parking
														access on site?: <span
														class="form-control customerRequestSpan col-12">{{$job->is_parking_access
															? 'Yes' : 'No'}}</span>
													</label>
												</div>
											</div>
										</div>

									</div>
									<div class="col-md-5 col-sm-6 col-12">
										<div id="map" style="height: 100%; margin-top: 0"></div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="row ">
						@if($job->status =='ready' || $reassign == 1)
						<div class="col-lg-6 ">
							<div class="card ">
								<div class="card-body" style="padding-top: 0 !important;">
									<div class="container" style="padding-bottom: 10px !important;">
										<div class="row">
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class=" requestSubTitle cardTitleGrey"
															style="margin-bottom: 0 !important;">Highly Recommended
															Contractors</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												@if(count($contractors) > 0) @foreach($contractors as
												$contractor)
												<div class="card recommendContractor">
													<input type="radio"
														id="radioInputContractor-{{$contractor->id}}"
														name="selected-contractor" value="{{$contractor->id}}"
														data-contractor-name="{{$contractor->name}}"
														data-contractor-level="{{$contractor->experience_level}}"
														data-contractor-away="0">

													<div class="card-body">
														<div class="col-12  ">
															<label class="form-check-label w-100 px-0"
																for="radioInputContractor-{{$contractor->id}}">
																<div class="row">

																	<div class="col-10">
																		<h6 class="recommendContractorNameH6">
																			{{$contractor->name}}</h6>
																		<p class="recommendContractorDataP">{{$contractor->experience_level}}</p>
																		<p class="recommendContractorDataP"
																			id="km-away-{{$contractor->id}}">0 km away</p>
																	</div>
																	<div class="col-2" style="text-align: right">
																		<i class="fas fa-check-circle"></i>
																	</div>
																</div>
															</label>
														</div>

													</div>
												</div>
												@endforeach @endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@elseif( ($job->status !='ready' || $job->status =='completed')
						&& $reassign == 0)
						<div class="col-lg-6 "
							v-if="job.status != 'ready' || job.status =='completed'">
							<div class="card ">
								<div class="card-body" style="padding-top: 0 !important;">
									<div class="container" style="padding-bottom: 10px !important;">
										<div class="row">
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class=" requestSubTitle cardTitleGrey"
															style="margin-bottom: 0 !important; display: inline-block;">Assigned
															Contractor</h5>
														<a v-if="job.status != 'completed'"
															href="{{url('garden-help/jobs_table/reassign_job/')}}/{{$job->id}}"
															class="editLinkA "> <i class="fas fa-redo-alt"></i>
														</a>
													</div>
												</div>
											</div>
											<div class="col-12">

												<div class="card recommendContractor">


													<div class="card-body">
														<div class="col-12  ">
															<div class="row">

																<div class="col-10">
																	<h6 class="recommendContractorNameH6">
																		{{$contractor->name}}</h6>
																	<p class="recommendContractorDataP">{{$contractor->experience_level}}</p>
																	<p class="recommendContractorDataP"
																		id="km-away-{{$contractor->id}}">
																		{{$contractor->km_away}} km away</p>
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
						</div>
						@endif @if($job->status =='completed')

						<div class="col-lg-6  ">
							<div class="card ">
								<div class="card-body" style="padding-top: 0 !important;">
									<div class="container" style="padding-bottom: 10px !important;">
										<div class="row">
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="cardTitleGreen requestSubTitle ">Estimated
															Price Quotation</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Garden maintenance
															(monthly)</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€100</span>
													</div>
												</div>
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Grass cutting</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€25</span>
													</div>
												</div>
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Gutter clearing</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€70</span>
													</div>
												</div>
												<div class="row" style="margin-top: 15px">
													<div class=" col-8">
														<label class="requestSpanGreen">Total</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€195</span>
													</div>
												</div>
											</div>
										</div>

										<div class="row" style="margin-top: 25px">
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="cardTitleGreen requestSubTitle ">Actual Price
															Quotation</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Garden maintenance
															(monthly)</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€100</span>
													</div>
												</div>
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Grass cutting</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€25</span>
													</div>
												</div>
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Gutter clearing</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€70</span>
													</div>
												</div>
												<div class="row" style="margin-top: 15px">
													<div class=" col-8">
														<label class="requestSpanGreen">Total</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€195</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@else
						<div class="col-lg-6  ">
							<div class="card ">
								<div class="card-body" style="padding-top: 0 !important;">
									<div class="container" style="padding-bottom: 10px !important;">
										<div class="row">
											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="cardTitleGreen requestSubTitle ">Estimated
															Price Quotation</h5>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Garden maintenance
															(monthly)</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€100</span>
													</div>
												</div>
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Grass cutting</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€25</span>
													</div>
												</div>
												<div class="row">
													<div class=" col-8">
														<label class="requestLabelGreen">Gutter clearing</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€70</span>
													</div>
												</div>
												<div class="row" style="margin-top: 15px">
													<div class=" col-8">
														<label class="requestSpanGreen">Total</label>
													</div>
													<div class=" col-4">
														<span class="requestSpanGreen">€195</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endif
					</div>

					<div class="row " v-if="job.status == 'ready' || reassign == 1">
						<div class="col-sm-6 text-center">

							<button class="btn btn-register btn-gardenhelp-green"
								id="assignContractorBtn" style="float: right;" disabled
								onclick="showAssignContractorModal()">Assign Contractor</button>

						</div>
						<div class="col-sm-6 text-center">
							<button class="btn btn-register btn-gardenhelp-danger"
								style="float: left" data-toggle="modal"
								data-target="#rejection-reason-modal">Cancel Job</button>
						</div>
					</div>
					<div class="row " v-else-if="job.status == 'assigned'">

						<div class="col-sm-12 text-center">
							<button class="btn btn-register btn-gardenhelp-danger"
								data-toggle="modal" data-target="#rejection-reason-modal">Cancel
								Job</button>
						</div>
					</div>

					<!-- Rejection Reason modal -->
					<div class="modal fade" id="rejection-reason-modal" tabindex="-1"
						role="dialog" aria-labelledby="assign-deliverer-label"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									{{--
									<h5 class="modal-title" id="assign-deliverer-label">Assign
										deliverer</h5>
									--}} {{--
									<button type="button"
										class="close d-flex justify-content-center"
										data-dismiss="modal" aria-label="Close">
										--}} {{-- <i class="fas fa-times"></i>--}} {{--
									</button>
									--}}
								</div>
								<div class="modal-body">
									<div class="col-md-12">
										<form id="request-rejection" method="POST"
											action="{{route('garden_help_postCustomerSingleRequest', ['garden-help', $job->id])}}">
											{{csrf_field()}}
											<div class="text-center"
												style="font-family: Roboto; font-size: 30px; font-weight: bold; font-stretch: normal; font-style: normal; line-height: normal; letter-spacing: normal; color: #414141;">
												<img src="{{asset('images/doorder_icons/red-tick.png')}}"
													style="width: 160px" alt="Reqject"> <br> Canceled
											</div>
											<div class="form-group ">
												<label class="">Please add reason for cancellation</label>
												<textarea class="form-control" name="rejection_reason"
													rows="4" required></textarea>
											</div>
										</form>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-around ">
									<div class="row">
										<div class="col-sm-6 col-12">
											<button type="button"
												class="btn btn-register btn-gardenhelp-green "
												onclick="$('form#request-rejection').submit()">Send</button>
										</div>

										<div class="col-sm-6 col-12">
											<button type="button"
												class="btn btn-register btn-gardenhelp-danger  "
												data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- end reject modal -->
					<!-- assign contractor modal -->
					<div class="modal fade" id="assign-contractor-modal" tabindex="-1"
						role="dialog" aria-labelledby="assign-deliverer-label"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">

								<div class="modal-body">
									<div class="modal-dialog-header assignContractorHeader">
										This contractor is successfully selected <br> and ready to be
										assigned
									</div>

									<div>
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-md-8 offset-md-2 deliverers-container">
														<div class="card selected-contractor-card">
															<div class="card-header deliverer-details row">

																<div class="col-10">
																	<h6 class="recommendContractorNameH6">
																		<span id="contractorNameSpan"></span>
																	</h6>
																	<p class="recommendContractorDataP">
																		<span id="contractorLevelSpan"></span>
																	</p>
																	<p class="recommendContractorDataP">
																		<span id="contractorAwaySpan"></span> km away
																	</p>
																</div>
																<div class="col-2" style="text-align: right">
																	<i class="fas fa-check-circle checked"></i>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<form method="POST" id="assign-contractor"
											action="{{url('garden-help/job/assign')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="jobId" name="jobId"
												value="{{$job->id}}" /> <input type="hidden"
												id="contractorId" name="contractorId" required />
										</form>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-around">
									<button type="button"
										class="btn btn-register btn-gardenhelp-green"
										onclick="$('form#assign-contractor').submit()">Assign</button>
									<button type="button"
										class="btn btn-register btn-gardenhelp-danger"
										data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
					<!-- end assign contractor modal -->
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">

        $(document).ready(function () {

            $('input').on('change', function () {
                $('#assignContractorBtn').prop("disabled", false);
            });
        });
         var app = new Vue({
            el: '#app',
            data: {
                job: {},
                reassign:0
            },
            mounted() {
                

                var job = {!! json_encode($job) !!};


                this.job = job;
                this.reassign = {!! $reassign !!}
            },
            methods: {
            }
        });

        function showAssignContractorModal() {
            $('#contractorId').val($("input[name='selected-contractor']:checked").val());
            $('#assign-contractor-modal').modal('show')

            let selectedInput = $("input[name='selected-contractor']:checked");
            let contractor_name = selectedInput.data('contractor-name');
            $('#contractorNameSpan').html(contractor_name);
            let contractor_level = selectedInput.data('contractor-level');
            $('#contractorLevelSpan').html(contractor_level);
            let contractor_away = selectedInput.data('contractor-away');
            $('#contractorAwaySpan').html(contractor_away);


        }

        function initMap() {
            //Map Initialization
            this.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668},
                mapTypeId: 'hybrid'
            });

            // Define the LatLng coordinates for the polygon's path.
            let area_coordinates = {!!$job->area_coordinates!!};
            console.log(area_coordinates);
            const polygonCoords = [area_coordinates];
            // Construct the polygon.
            const polygon = new google.maps.Polygon({
                paths: polygonCoords,
                strokeColor: "#0068b8",
                strokeOpacity: 0.26,
                strokeWeight: 2,
                fillColor: "#0068b8",
                fillOpacity: 0.35,
            });
            polygon.setMap(map);
            // Create the bounds object
            var bounds = new google.maps.LatLngBounds();

            // Get paths from polygon and set event listeners for each path separately
            polygon.getPath().forEach(function (path, index) {

                bounds.extend(path);
            });

            // Fit Polygon path bounds
            map.fitBounds(bounds);

            //Getting the distance between the contractor and the customer location
            let contractors = {!! json_encode($contractors) !!};
            let job = {!! json_encode($job) !!};
            let job_coordinates = JSON.parse(job.location_coordinates);

            for (let contractor of contractors) {
                let contractor_location = JSON.parse(contractor.address_coordinates);
                let from = new google.maps.LatLng(contractor_location.lat, contractor_location.lon)
                let to = new google.maps.LatLng(job_coordinates.lat, job_coordinates.lon);
                let distance = google.maps.geometry.spherical.computeDistanceBetween(from, to) / 1000;
                $('#km-away-' + contractor.id).text(distance.toFixed(0) + ' km away');
                $('#radioInputContractor-' + contractor.id).attr('data-contractor-away', distance.toFixed(0) + ' km away');
            }
        }
    </script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>
@endsection
