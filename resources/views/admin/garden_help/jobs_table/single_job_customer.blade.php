@extends('templates.dashboard') @section('title', 'GardenHelp | Job')
@section('page-styles')
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">

<link rel="stylesheet"
	href="{{asset('css/gardenhelp-slick-styles.css')}}">
<style>
.modal-content {
	border-radius: 30px !important;
	border: solid 1px #979797 !important;
	background-color: #ffffff;
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

.recommendAssignContractor .recommendContractorNameH6,
	.recommendAssignContractor .recommendContractorDataP {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
}

.requestSubTitle {
	margin: 0 !important;
}

.input-group-text img {
	width: 18px;
	height: 22px;
}

.my-check-box-label, .customer-register-label, .requestLabel {
	font-size: 16px;
	line-height: 19px;
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
									<div class="col-md-6 col-sm-6 col-12">
										<div class="row">

											<div class="col-12">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle my-0">Service Details</h5>
													</div>
												</div>
											</div>
											<div class="col-12 mt-2">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/service-type-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline">Service type:
															<span class="customerRequestSpan ">{{$job->service_types}}</span>
														</label>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<div class="col-12">
														<h5 class="requestSubTitle">Property Information</h5>
													</div>
												</div>
											</div>

											<div class="col-12 mt-2">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline"><span
															class="customerRequestSpan ">{{$job->work_location}}</span></label>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<label class="requestLabel d-inline">Property type: <span
															class="customerRequestSpan ">{{$job->type_of_work}}</span></label>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline"><span
															class="customerRequestSpan ">{{$job->location}}</span></label>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/property-size-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline">Property
															size: <span class="customerRequestSpan ">{{$job->property_size}}</span>
														</label>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<label class="requestLabel col-12">Property Images</label>
													<div class="col-12">
														<section class="timeline-carousel">

															<div class="timeline-carousel__item-wrapper"
																data-js="timeline-carousel">

																@if($job->property_photo != null)
																@foreach(json_decode($job->property_photo) as $item)
																<!--Timeline item-->
																<div class="timeline-carousel__item">
																	<div class="timeline-carousel__image">
																		<div class="media-wrapper media-wrapper--overlay"
																			style="background: url('{{asset($item)}}') center center; background-size: cover;"></div>
																	</div>
																</div>
																<!--/Timeline item-->
																@endforeach @endif

															</div>
														</section>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/time-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline">Scheduled at:
															<span class="customerRequestSpan ">{{$job->available_date_time}}</span>
														</label>
													</div>
												</div>
											</div>
											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/budget-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline">Budget: <span
															class="customerRequestSpan ">€{{$job->budget}}</span></label>
													</div>
												</div>
											</div>

											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<label class="requestLabel d-inline">Is this your first
															service? <span class="customerRequestSpan ">{{$job->is_first_time
																? 'Yes' : 'No'}}</span>
														</label>
													</div>
												</div>
											</div>

											@if($job->is_first_time != 1)

											<div class="col-12 mt-2">
												<div class=" row">
													<div class=" col-12">
														<span class="input-group-text d-inline"> <img
															src="{{asset('images/gardenhelp_icons/time-icon.png')}}"
															alt="GardenHelp">
														</span> <label class="requestLabel d-inline">Last service:
															<span class="customerRequestSpan ">{{$job->last_service}}</span>
														</label>
													</div>
												</div>
											</div>
											@endif

											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<label class="requestLabel d-inline">Is there a parking
															access on site? <span class="customerRequestSpan ">{{$job->is_parking_access
																? 'Yes' : 'No'}}</span>
														</label>
													</div>
												</div>
											</div>
											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<label class="requestLabel d-inline">Do you mind being
															contacted prior to job? <span
															class="customerRequestSpan ">{{$job->is_contacted ? 'Yes'
																: 'No'}}</span>
														</label>
													</div>
												</div>
											</div>
											<div class="col-12 mt-3">
												<div class=" row">
													<div class=" col-12">
														<label class="requestLabel d-inline">Contact me through: <span
															class="customerRequestSpan ">{{$job->contact_through}}</span></label>
													</div>
												</div>
											</div>



											<div class="col-12 mt-3">
												<div class=" row">
													<label class="requestLabel col-12 mb-0">Site details: </label><span
														class=" customerRequestSpan col-12 mt-0">{{$job->site_details}}</span>
												</div>
											</div>
											<div class="col-12 mt-3">
												<div class=" row">
													<label class="requestLabel col-12 mb-0">Notes: </label><span
														class=" customerRequestSpan col-12 mt-0">{{$job->notes}}</span>
												</div>
											</div>


										</div>

									</div>
									<div class="col-md-6 col-sm-6 col-12">
										<div id="map" style="height: 100%; margin-top: 0"></div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="row ">
						@if($job->status =='ready' || $reassign == 1)
						<div class="col-lg-12 ">
							<section class="timeline-carousel timeline-carousel-contractors">

								<div class="timeline-carousel__item-wrapper"
									data-js="timeline-carousel">

									@if(count($contractors) > 0) @foreach($contractors as
									$contractor)
									<!--Timeline item-->
									<div class="timeline-carousel__item">
										<div class="contractor-card text-center">
											<img
												src="{{asset('images/gardenhelp_icons/contractors_applied.png')}}"
												alt="" width="70px"> <img>
											<h2 class="carouselContractorH2 mt-2">Contractor Applied</h2>
											<h4 class="carouselContractorNameH4 mt-1">
												<a target="_blank"
													href="{{url('garden-help/view_applied_contractor')}}/{{$contractor->id}}"><u>{{$contractor->name}}</u></a>
											</h4>
{{--											<p class="carouselContractorKmP mt-2"--}}
{{--												id="km-away-{{$contractor->id}}">{{$contractor->km_away}} Km--}}
{{--												away</p>--}}
{{--											<input type="hidden" id="hiddenKmAway-{{$contractor->id}}"--}}
{{--												value="" />--}}
											<div class=" row mt-2">
												<div class=" col-12 ">
													<span class="input-group-text d-inline"> </span> <label
														class="requestLabel d-inline"><img
														src="{{asset('images/gardenhelp_icons/budget-icon.png')}}"
														alt="GardenHelp" width="18px"> Bidding: <span
														class="customerRequestSpan ">€{{$contractor->bidding->where('job_id', $job->id)[0]->estimated_quote}}</span></label>
												</div>
											</div>
											<button type="button"
												class="btn btn-gardenhelp-green addServiceButton mt-3" style="max-width: 100%"
												onclick="showAssignContractorModal({{$contractor->id}},'{{$contractor->name}}','{{$contractor->experience_level}}', '{{$contractor->bidding[0]->estimated_quote}}')">
												<p>BOOK NOW</p>
											</button>
										</div>
									</div>
									<!--/Timeline item-->
									@endforeach @endif


								</div>
							</section>

						</div>
						@elseif( ($job->status !='ready' || $job->status =='completed') &&
						$reassign == 0)
						<div class="col-12"
							v-if="job.status != 'ready' && job.status != 'completed' ">
							<div class="card">
								<div class="card-body">
									<div class="recommendContractor recommendAssignContractor">
										<div class="row text-center">
												<div class="col-xl-2 col-lg-2 ">
													<img
														src="{{asset('images/gardenhelp_icons/contractor-assigned.png')}}"
														alt="" width="70px"> <img>
												</div>

												<div class="col-xl-6 col-lg-5 justify-content-center align-self-center">
													<h2 class="carouselContractorH2 mt-2 d-inline-block"
														style="font-size: large">Assigned contractor:</h2>

													<h4
														class="carouselContractorH2 mt-2 d-inline-block font-weight-bold"
														style="font-size: large">{{$contractor->name}}</h4>
												</div>


												<div class="col-xl-2 col-lg-2 justify-content-center align-self-center">
													<p class="carouselContractorKmP mt-2"
														id="km-away-{{$contractor->id}}">{{$contractor->km_away}}
														Km away</p>
												</div>
												<div
													class="col-xl-2 col-lg-3 justify-content-center align-self-center mt-3 mb-2">
													<label class="requestLabel d-inline"> <img
														src="{{asset('images/gardenhelp_icons/budget-icon.png')}}"
														alt="GardenHelp" width="18px"> Bidding: <span
														class="customerRequestSpan ">€{{$contractor->bidding[0]->estimated_quote}}</span></label>
												</div>
											</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12" v-if="job.status == 'completed' ">
							<div class="card">
								<div class="card-body">
									<div class="recommendContractor recommendAssignContractor">
										<div class="row text-center">
												<div class="col-xl-2 col-lg-2 ">
													<img
														src="{{asset('images/gardenhelp_icons/job-completed.png')}}"
														alt="" width="70px"> <img>
												</div>
												<div class="col-xl-4 col-lg-4   justify-content-center align-self-center">
													<h4
														class="carouselContractorH2 mt-2 d-inline-block font-weight-bold"
														style="color: #60A244">Job Completed</h4>

												</div>

												<div class="col-xl-6 col-lg-6  justify-content-center align-self-center">
													<h2 class="carouselContractorH2 mt-2 d-inline-block"
														style="">Assigned contractor:</h2>

													<h4
														class="carouselContractorH2 mt-2 d-inline-block font-weight-bold"
														style="">{{$contractor->name}}</h4>
												</div>

										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- 						<div class="col-lg-12 " -->
						<!-- 							v-if="job.status != 'ready' || job.status =='completed'"> -->
						<!-- 							<div class="card "> 
								<div class="card-body" style="padding-top: 0 !important;">
									<div class="container" style="padding-bottom: 10px !important;">
<!-- 										<div class="row"> -->
						<!-- 											<div class="col-12"> -->
						<!-- 												<div class=" row"> -->
						<!-- 													<div class="col-12"> -->
						<!-- 														<h5 class=" requestSubTitle cardTitleGrey" 
															style="margin-bottom: 0 !important; display: inline-block;">Assigned
<!-- 															Contractor</h5> -->
						<!-- 														<a v-if="job.status != 'completed'" -->
						<!-- 															href="{{url('garden-help/jobs_table/reassign_job/')}}/{{$job->id}}" -->
						<!-- 															class="editLinkA "> <i class="fas fa-redo-alt"></i> -->
						<!-- 														</a> -->
						<!-- 													</div> -->
						<!-- 												</div> -->
						<!-- 											</div> -->
						<!-- 											<div class="col-12"> -->
						<!-- 												<div class="card recommendContractor"> -->
						<!-- 													<div class="card-body"> -->
						<!-- 														<div class="col-12  "> -->
						<!-- 															<div class="row"> -->
						<!-- 																<div class="col"> -->
						<!-- 																	<h6 class="recommendContractorNameH6"> -->
						<!-- 																		{{$contractor->name}}</h6> -->
						<!-- 																	<p class="recommendContractorDataP">{{$contractor->experience_level}}</p> -->
						<!-- 																	<p class="recommendContractorDataP" -->
						<!-- 																		id="km-away-{{$contractor->id}}"> -->
						<!-- 																		{{$contractor->km_away}} km away</p> -->
						<!-- 																	<h6 class="recommendContractorNameH6">Price quotation: -->
						<!-- 																		€{{$contractor->price_quotation}}</h6> -->
						<!-- 																</div> -->
						<!-- 															</div> -->
						<!-- 														</div> -->

						<!-- 													</div> -->
						<!-- 												</div> -->
						<!-- 											</div> -->
						<!-- 										</div> -->
						<!-- 									</div> -->
						<!-- 								</div> -->
						<!-- 							</div> -->
						<!-- 						</div> -->
						@endif
{{--						@if($job->status =='completed')--}}
{{--							@if(auth()->user()->user_role == 'client')--}}
{{--							<div class="col-lg-6  ">--}}
{{--								<div class="card ">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container" style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Estimated--}}
{{--																Price Quotation</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row" v-for="type in services_types">--}}
{{--														<div class="col-8">--}}
{{--															<label class="requestLabelGreen">@{{ type.title }}</label>--}}
{{--														</div>--}}
{{--														<div class="col-4">--}}
{{--															<span class="requestSpanGreen">€@{{--}}
{{--																getPropertySizeRate(type) }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--		--}}
{{--													<div class="row" style="margin-top: 15px">--}}
{{--														<div class="col-8">--}}
{{--															<label class="requestSpanGreen">Total</label>--}}
{{--														</div>--}}
{{--														<div class="col-4">--}}
{{--															<span class="requestSpanGreen">€@{{ getTotalPrice() }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--		--}}
{{--											<div class="row" style="margin-top: 25px">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Actual Price--}}
{{--																Quotation</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row" v-for="type in actual_services_types">--}}
{{--														<div class="col-8">--}}
{{--															<label class="requestLabelGreen">@{{ type.title }}</label>--}}
{{--														</div>--}}
{{--														<div class="col-4">--}}
{{--															<span class="requestSpanGreen">€@{{--}}
{{--																getPropertySizeRate(type) }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--		--}}
{{--													<div class="row" style="margin-top: 15px">--}}
{{--														<div class="col-8">--}}
{{--															<label class="requestSpanGreen">Total</label>--}}
{{--														</div>--}}
{{--														<div class="col-4">--}}
{{--															<span class="requestSpanGreen">€@{{ getTotalPrice(true) +--}}
{{--																getVat(13.5, getTotalPrice(true)) }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							@endif--}}
{{--							@if(auth()->user()->user_role == 'client')--}}
{{--							<div class="col-lg-6" v-if="job_other_expenses_json.length > 0">--}}
{{--								<div class="card">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container" style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Other Expenses</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row" v-for="expense in job_other_expenses_json"--}}
{{--														v-if="expense.is_checked">--}}
{{--														<div class="col-8">--}}
{{--															<label class="requestLabelGreen">@{{ expense.title }}</label>--}}
{{--														</div>--}}
{{--														<div class="col-4">--}}
{{--															<span class="requestSpanGreen">€@{{ expense.value }}</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--		--}}
{{--													<div class="row">--}}
{{--														<div class="col-8">--}}
{{--															<label class="requestLabelGreen">Other Expenses File</label>--}}
{{--														</div>--}}
{{--														<div class="col-4">--}}
{{--															<span class="requestSpanGreen"> <a--}}
{{--																:href="'https://'+location.hostname + '/' + job.job_expenses_receipt_file"--}}
{{--																target="_blank"> <img--}}
{{--																	:src="'https://'+location.hostname + '/' + job.job_expenses_receipt_file"--}}
{{--																	alt="Other Expenses File" style="width: 100%">--}}
{{--															</a>--}}
{{--															</span>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--		--}}
{{--							<div class="col-lg-6">--}}
{{--								<div class="card">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container" style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Job Images</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row">--}}
{{--														<div class="col-6" v-for="image in job_images">--}}
{{--															<label class="requestLabelGreen"></label> <a--}}
{{--																:href="'https://'+location.hostname+'/'+image"--}}
{{--																target="_blank"> <img--}}
{{--																:src="'https://'+location.hostname+'/'+image"--}}
{{--																alt="job image" style="width: 100%">--}}
{{--															</a>--}}
{{--														</div>--}}
{{--														--}}{{----}}
{{--														<div class="col-4">--}}
{{--															--}}{{-- --}}{{-- <span class="requestSpanGreen">€@{{--}}
{{--																expense.value }}</span>--}}{{-- --}}{{----}}
{{--														</div>--}}
{{--														--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--		--}}
{{--							@if($job->notes)--}}
{{--							<div class="col-lg-6">--}}
{{--								<div class="card">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container" style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Contractor--}}
{{--																Notes</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row">{{$job->notes}}</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							@endif @if(count($job->job_timestamps) > 0)--}}
{{--							<div class="col-lg-6">--}}
{{--								<div class="card">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container" style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Contractor--}}
{{--																Breaks</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row">--}}
{{--														@foreach($job->job_timestamps as $key => $value)--}}
{{--														<div class="col-12">--}}
{{--															<div class=" row">--}}
{{--																<div class="col-12">--}}
{{--																	<h5 class="cardTitleGreen requestSubTitle ">Break--}}
{{--																		{{$key+1}}</h5>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--														<div class="col-12">--}}
{{--															<div class="row">--}}
{{--																<div class="col-6">--}}
{{--																	<label class="requestLabelGreen">From:{{\Carbon\Carbon::parse($value->started_at)->format('H:i--}}
{{--																		A')}}, To:--}}
{{--																		{{\Carbon\Carbon::parse($value->stopped_at)->format('H:i--}}
{{--																		A')}}</label>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--														@endforeach--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							@endif @endif--}}
{{--							@php--}}
{{--								$timestamps = \App\KPITimestamp::where('model_id', $job->id)->where('model', 'gardenhelp_job')->first(); @endphp--}}
{{--							@if($timestamps)--}}
{{--							@if(auth()->user()->user_role == 'client')--}}
{{--							<div class="col-lg-6">--}}
{{--								<div class="card">--}}
{{--									<div class="card-body" style="padding-top: 0 !important;">--}}
{{--										<div class="container" style="padding-bottom: 10px !important;">--}}
{{--											<div class="row">--}}
{{--												<div class="col-12">--}}
{{--													<div class=" row">--}}
{{--														<div class="col-12">--}}
{{--															<h5 class="cardTitleGreen requestSubTitle ">Job Timestamps</h5>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-12">--}}
{{--													<div class="row">--}}
{{--														<div class="col-12">--}}
{{--															<div class=" row">--}}
{{--																<div class="col-12">--}}
{{--																	<h5 class="cardTitleGreen requestSubTitle ">Started At</h5>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--														<div class="col-12">--}}
{{--															<div class="row">--}}
{{--																<div class="col-6">--}}
{{--																	<label class="requestLabelGreen">--}}
{{--																		{{$timestamps->accepted ?: 'N/A'}} </label>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--													<div class="row">--}}
{{--														<div class="col-12">--}}
{{--															<div class=" row">--}}
{{--																<div class="col-12">--}}
{{--																	<h5 class="cardTitleGreen requestSubTitle ">Completed At</h5>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--														<div class="col-12">--}}
{{--															<div class="row">--}}
{{--																<div class="col-6">--}}
{{--																	<label class="requestLabelGreen">--}}
{{--																		{{$timestamps->completed?: 'N/A'}} </label>--}}
{{--																</div>--}}
{{--															</div>--}}
{{--														</div>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--							@endif--}}
{{--							@endif --}}
{{--						@else --}}
{{--						@if(auth()->user()->user_role == 'client')--}}
{{--						<div class="col-lg-6  ">--}}
{{--							<div class="card ">--}}
{{--								<div class="card-body" style="padding-top: 0 !important;">--}}
{{--									<div class="container" style="padding-bottom: 10px !important;">--}}
{{--										<div class="row">--}}
{{--											<div class="col-12">--}}
{{--												<div class=" row">--}}
{{--													<div class="col-12">--}}
{{--														<h5 class="cardTitleGreen requestSubTitle ">Estimated--}}
{{--															Price Quotation</h5>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--											<div class="col-12">--}}
{{--												<div class="row" v-for="type in services_types">--}}
{{--													<div class="col-md-3 col-6">--}}
{{--														<label class="requestLabelGreen">@{{ type.title }}</label>--}}
{{--													</div>--}}
{{--													<div class="col-md-3 col-6">--}}
{{--														<span class="requestSpanGreen">€@{{--}}
{{--															getPropertySizeRate(type) }}</span>--}}
{{--													</div>--}}
{{--												</div>--}}

{{--												<div class="row">--}}
{{--													<div class="col-md-3 col-6">--}}
{{--														<label class="requestLabelGreen">Vat</label>--}}
{{--													</div>--}}
{{--													<div class="col-md-3 col-6">--}}
{{--														<span class="requestSpanGreen">€@{{ getVat(13.5,--}}
{{--															getTotalPrice()) }} (13.5%)</span>--}}
{{--													</div>--}}
{{--												</div>--}}

{{--												<div class="row" style="margin-top: 15px">--}}
{{--													<div class="col-md-3 col-6">--}}
{{--														<label class="requestSpanGreen">Total</label>--}}
{{--													</div>--}}
{{--													<div class="col-md-3 col-6">--}}
{{--														<span class="requestSpanGreen">€@{{ getTotalPrice() +--}}
{{--															getVat(13.5, getTotalPrice()) }}</span>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						@endif @endif--}}
					</div>

					<div class="row " v-if="job.status == 'ready' || reassign == 1">
						<!-- 						<div class="col-sm-6 text-center"> -->

						<!-- 							<button class="btn btn-register btn-gardenhelp-green" 
								id="assignContractorBtn" style="float: right;" disabled
								onclick="showAssignContractorModal()">Assign Contractor</button>

<!-- 						</div> -->
						<div class="col-sm-12 text-center">
							<button class="btn btn-register btn-gardenhelp-danger"
								data-toggle="modal" data-target="#rejection-reason-modal">Cancel
								Job</button>
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
											<input type="hidden" name="rejected" value="rejected">
										</form>
									</div>
								</div>
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btn btn-register btn-gardenhelp-green "
											onclick="$('form#request-rejection').submit()">Send</button>
									</div>

									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btn btn-register btn-gardenhelp-danger  "
											data-dismiss="modal">Close</button>
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
													<div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 deliverers-container">
														<div class="card selected-contractor-card">
															<div class="card-header deliverer-details row">

																<div class="col-10">
																	<h6 class="recommendContractorNameH6 mt-2">
																		<span id="contractorNameSpan"></span>
																	</h6>
																	<p class="recommendContractorDataP">
																		<span id="contractorLevelSpan"></span>
																	</p>
																	<p class="recommendContractorDataP">
																		<span id="contractorAwaySpan"></span> km away
																	</p>
																	<h6 class="recommendContractorNameH6">
																		Price quotation: €<span id="contractorPriceQuotation"></span>
																	</h6>
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
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btn btn-register btn-gardenhelp-green"
											onclick="$('form#assign-contractor').submit()">Assign</button>
									</div>

									<div class="col-lg-4 col-md-6 text-center">
										<button type="button"
											class="btn btn-register btn-gardenhelp-danger"
											data-dismiss="modal">Cancel</button>
									</div>
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

<script
	src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"> </script>
<script type="text/javascript">

		$(document).ready(function () {
		
// 		    $('input').on('change', function () {
// 		        $('#assignContractorBtn').prop("disabled", false);
// 		    });
			
			$('.timeline-carousel__item-wrapper').slick({
                infinite: false,
                arrows: true,
                prevArrow: '<div class="slick-prev"> <div class="btn mr-3  d-flex justify-content-center align-items-center"> <i class="fas fa-chevron-left"></i></div></div>',
                nextArrow: '<div class="slick-next"> <div class="btn d-flex justify-content-center align-items-center"><i class="fas fa-chevron-right"></i> </div></div>',
                dots: true,
                autoplay: false,
                speed: 1100,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                  {
                    breakpoint: 800,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  }]
              });	
		});
		
		var app = new Vue({
			el: '#app',
			data: {
				job: {},
				reassign:0,
				services_types: {!! $job->services_types_json ?  $job->services_types_json : '[]'!!},
				actual_services_types: {!! $job->job_services_types_json ? $job->job_services_types_json : '[]' !!},
				job_other_expenses_json: {!! $job->job_other_expenses_json ? $job->job_other_expenses_json : '[]' !!},
				job_images: {!! json_encode($job->job_image) ?: '[]' !!},
			},
			mounted() {
				var job = {!! json_encode($job) !!};
				this.job = job;
				this.reassign = {!! $reassign !!}
			},
			methods: {
				selectContractor() {
					$('#assignContractorBtn').prop("disabled", false);
				},
				getPropertySizeRate(type) {
					let property_size = "{{$job->property_size}}";
					property_size = property_size.replace(' Square Meters', '');
					let rate_property_sizes = JSON.parse(type.rate_property_sizes);
					for (let rate of rate_property_sizes) {
						let size_from = rate.max_property_size_from;
						let size_to = rate.max_property_size_to;
						let rate_per_hour = rate.rate_per_hour;
						if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
							let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
							this.total_price += service_price;
							return service_price;
						}
					}
				},
				getTotalPrice(isActual = false) {
					let property_size = "{{$job->property_size}}";
					property_size = property_size.replace(' Square Meters', '');
					let total_price = 0
					let services_types = isActual === true ? this.actual_services_types : this.services_types;
					for (let type of services_types) {
						if (type.is_checked) {
							let rate_property_sizes = JSON.parse(type.rate_property_sizes);
							for (let rate of rate_property_sizes) {
								let size_from = rate.max_property_size_from;
								let size_to = rate.max_property_size_to;
								let rate_per_hour = rate.rate_per_hour;
								if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
									let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
									total_price += service_price;
								}
							}
						}
					}
					return parseFloat(total_price);
				},
				getVat(percentage, total_price) {
					return parseFloat(((percentage/100)*total_price).toFixed(2));
				}
			}
		});

		function showAssignContractorModal(contractorId,contractor_name, contractor_level, price_quotation) {
			//$('#contractorId').val($("input[name='selected-contractor']:checked").val());
			$('#assign-contractor-modal').modal('show')

// 			let selectedInput = $("input[name='selected-contractor']:checked");
// 			let contractor_name = selectedInput.data('contractor-name');
// 			$('#contractorNameSpan').html(contractor_name);
// 			let contractor_level = selectedInput.data('contractor-level');
// 			$('#contractorLevelSpan').html(contractor_level);
// 			let contractor_away = selectedInput.data('contractor-away');
// 			$('#contractorAwaySpan').html(contractor_away);
// 			let price_quotation = selectedInput.data('contractor-price');
// 			$('#contractorPriceQuotation').html(price_quotation);
			
			$('#contractorId').val(contractorId);
			$('#contractorNameSpan').html(contractor_name);
			$('#contractorLevelSpan').html(contractor_level);
			$('#contractorAwaySpan').html($("#hiddenKmAway-"+contractorId).val());
			$('#contractorPriceQuotation').html(price_quotation);
		}

		function initMap() {
			//Map Initialization
			this.map = new google.maps.Map(document.getElementById('map'), {
				zoom: 12,
				center: {lat: 53.346324, lng: -6.258668},
				mapTypeId: 'hybrid'
			});
			
			//Marker
            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/customer-address-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };
            var loc = {!!$job->location_coordinates!!};
            
            //console.log(loc.lat)
            
			let locationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position:  {"lat": loc.lat, "lng": loc.lon}
            });

            locationMarker.setVisible(true)

			// Define the LatLng coordinates for the polygon's path.
			let area_coordinates = {!!$job->area_coordinates!!};
			const polygonCoords = area_coordinates;
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
			let job = {!! $job !!};
			let job_coordinates = JSON.parse(job.location_coordinates);
			@if($job->status == 'ready')
					for (let contractor of contractors) {
				let contractor_location = JSON.parse(contractor.address_coordinates);
				console.log(contractor_location.lat)
				let from = new google.maps.LatLng(contractor_location.lat, contractor_location.lon)
				let to = new google.maps.LatLng(job_coordinates.lat, job_coordinates.lon);
				console.log( google.maps.geometry.spherical.computeDistanceBetween(from, to))
				let distance = google.maps.geometry.spherical.computeDistanceBetween(from, to) / 1000;
				console.log(distance)
				console.log('#contractors-list #km-away-' + contractor.id)
				$('.timeline-carousel-contractors #km-away-' + contractor.id).text(distance.toFixed(2) + ' km away');
				$('.timeline-carousel-contractors #hiddenKmAway-' + contractor.id).val(distance.toFixed(2));
				$('#contractors-list #contractor-row-' + contractor.id).data('sort', distance.toFixed(2));
				$('#contractors-list #radioInputContractor-' + contractor.id).attr('data-contractor-away', distance.toFixed(2) + ' km away');
			}
			@else
			let assigned_contractor = {!! json_encode($contractor) !!};
			let contractor_location = JSON.parse(assigned_contractor.address_coordinates);
			let from = new google.maps.LatLng(contractor_location.lat, contractor_location.lon)
			let to = new google.maps.LatLng(job_coordinates.lat, job_coordinates.lon);
			let distance = google.maps.geometry.spherical.computeDistanceBetween(from, to) / 1000;
			$('#km-away-' + assigned_contractor.id).text(distance.toFixed(2) + ' km away');
			$('#contractor-row-' + assigned_contractor.id).data('sort', distance.toFixed(2));
			$('#radioInputContractor-' + assigned_contractor.id).attr('data-contractor-away', distance.toFixed(2) + ' km away');
			@endif

			//Arranging Contractors
			var contractors_list = $('#contractors-list').children()
			let result = contractors_list.sort(function (a, b) {
				var contentA =parseInt( $(a).data('sort'));
				var contentB =parseInt( $(b).data('sort'));
				return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
			});
			$('#contractors-list').html(result);
		}
	</script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initMap"></script>
@endsection
