@extends('templates.dashboard') @section('title', 'GardenHelp |
Contractor View') @section('page-styles')
<style>
.modal-dialog-header {
	font-size: 25px;
	font-weight: 500;
	line-height: 1.2;
	text-align: center;
	color: #cab459;
}

.modal-content {
	/*padding: 51px 51px 112px 51px;*/
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

.rowDownloadFile label {
	margin-bottom: 0 !important;
}

.rowDownloadFile .aDiv, .rowDownloadFile a {
	margin-top: 0 !important;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)
					<form method="POST"
						action="{{route('garden_help_postEditContractor',['garden-help',$contractor->id])}}"
						id="edit_contractor_form">
						@endif {{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-sm-7">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/gardenhelp_icons/Contractors-white.png')}}">
									</div>
									<h4 class="card-title ">Contractor: {{$contractor->name}}</h4>
									<input type="hidden" name="contractorId"
										value="{{$contractor->id}}">
								</div>
								@if($readOnly==1)
								<div class="col-6 col-sm-5 mt-5">
									<div class="row justify-content-end">
										<a class="editLinkA btn  btn-link   edit"
											href="{{url('garden-help/contractors/edit/')}}/{{$contractor->id}}">
											<p>Edit contractor</p>
										</a>
									</div>
								</div>
								@endif
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-12">
											<div class=" row">
												<div class="col-md-12">
													<h5 class="registerSubTitle">Comapany/Individual Details</h5>
												</div>
											</div>
										</div>
										<div class="col-12 ">
											<div class="row">
												<label class="requestLabel col-12">Name <input type="text"
													class="form-control" name="name"
													value="{{$contractor->name}}" required>
												</label>
											</div>
										</div>


										<div class="col-12">
											<div class="row">
												<label class="requestLabel  col-12">Email: <input
													type="email" name="email" value="{{$contractor->email}}"
													class="form-control " required>
												</label>
											</div>
										</div>
										<div class="col-12">
											<div class="row">
												<label class="requestLabel col-12">Phone number: <input
													type="tel" name="phone_number" class="form-control"
													value="{{$contractor->phone_number}}" /></label>
											</div>
										</div>

										<div class="col-md-12 mb-3">
											<div class="row">
												<label for="experience_level" class="requestLabel col-12">Years
													of experience <input name="experience_level" type="text"
													class="form-control" id="experience_level"
													v-model="experience_level_input"
													@click="openModal('experience_level')" required>
												</label>
												<!-- Button trigger modal -->
												<a id="experience_level_btn_modal" data-toggle="modal"
													data-target="#experience_levelModal" style="display: none"></a>

												<!-- Modal -->
												<div class="modal fade" id="experience_levelModal"
													tabindex="-1" role="dialog"
													aria-labelledby="experience_levelLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title text-left registerModalTitle"
																	id="experience_levelLabel">Years of Experience</h5>
																<button type="button" class="close" data-dismiss="modal"
																	aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div
																	class="form-check form-check-radio form-check-inline d-flex justify-content-between">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio"
																		name="experience_level_value" id="inlineRadio1"
																		v-model="experience_level" value="1"> (0-2 years) <span
																		class="circle"> <span class="check"></span>
																	</span>
																	</label>
																</div>
																<div
																	class="form-check form-check-radio form-check-inline d-flex justify-content-between">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio"
																		name="experience_level_value" id="inlineRadio2"
																		v-model="experience_level" value="2"> (2-5 years) <span
																		class="circle"> <span class="check"></span>
																	</span>
																	</label>
																</div>
																<div
																	class="form-check form-check-radio form-check-inline d-flex justify-content-between">
																	<label class="form-check-label"> <input
																		class="form-check-input" type="radio"
																		name="experience_level_value" id="inlineRadio2"
																		v-model="experience_level" value="3"> (+5 years) <span
																		class="circle"> <span class="check"></span>
																	</span>
																	</label>
																</div>
																<div class="row mt-4">
																	<div class="col d-flex" v-for="type in type_of_work"
																		v-if="type.level.includes(experience_level) === true"
																		@click="toggleCheckedValue(type)">
																		<div class="my-check-box mr-1" id="check">
																			<i
																				:class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
																		</div>
																		<label for="my-check-box mr-1"
																			:class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{
																			type.title }}</label>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button"
																	class="btn btn-link modal-button-close"
																	data-dismiss="modal">Close</button>
																<button type="button"
																	class="btn btn-link modal-button-done"
																	data-dismiss="modal"
																	:disabled="experience_level != '' ? false : true"
																	@click="changeExperienceLevel">Done</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>


										<div class="col-md-12 mb-3">
											<div class="row">
												<label class="requestLabel col-12">Hourly rate <input
													type="number" class="form-control" id="charge_rate"
													name="charge_rate" value="{{$contractor->charge_rate}}"
													required></label>
											</div>
										</div>

										<div class="col-12">
											<div class=" row form-file-upload form-file-multiple">
												<label class="requestLabel  col-12" for="age_proof">Age card
													/ Passport:</label>
												<div class="col">
													<img src="{{asset($contractor->age_proof)}}"
														style="width: 200px; height: 200px">
												</div>
												<br> <input id="age_proof" name="age_proof" type="file"
													class="inputFileHidden"
													@change="onChangeFile($event, 'age_proof_input')">
												<div class="form-group input-group" style="padding: 0 15px;"
													@click="addFile('age_proof')">
													<input type="text" id="age_proof_input"
														class="form-control inputFileVisible"
														placeholder="Upload Photo" > <span
														class="input-group-btn">
														<button type="button"
															class="btn btn-fab btn-round btn-success">
															<i class="fas fa-cloud-upload-alt"></i>
														</button>
													</span>
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<div class="row">
													<label for="type_of_experience" class="requestLabel col-12">Type
														of work experience </label>
													<div class="d-flex justify-content-between"
														style="padding: 0 15px; width: 100%;"
														@click="openModal('type_of_experience')">
														<input name="type_of_work_exp" type="text"
															class="form-control" id="type_of_experience"
															v-model="experience_type_input" required> <input
															type="hidden" v-model="type_of_work_selected_value"
															name="type_of_work_selected_value"> <a
															class="select-icon"> <i class="fas fa-caret-down"></i>
														</a>
													</div>
													<!-- Button trigger modal -->
													<a id="type_of_experience_btn_modal" data-toggle="modal"
														data-target="#type_of_experienceModal"
														style="display: none"></a>

													<!-- Modal -->
													<div class="modal fade" id="type_of_experienceModal"
														tabindex="-1" role="dialog"
														aria-labelledby="type_of_experienceLabel"
														aria-hidden="true">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title text-left registerModalTitle"
																		id="type_of_experienceLabel">Type of work experience</h5>
																	<button type="button" class="close"
																		data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<div class="row">
																		{{-- @{{type.level.includes(experience_level)}}--}}
																		<div class="col-md-12 d-flex justify-content-between"
																			v-for="type in experience_types"
																			v-if="type.level.includes(experience_level) === true"
																			@click="toggleCheckedValue(type)">
																			<label for="my-check-box"
																				:class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{
																				type.title }}</label>
																			<div class="my-check-box" id="check">
																				<i
																					:class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
																			</div>
																		</div>
																		<div class="col-md-12 d-flex justify-content-between">
																			<input type="text"
																				class="form-control add-other-input"
																				placeholder="Add other"
																				v-model="experience_type_other"> <a
																				class="add-other-button"
																				v-if="experience_type_other != ''"
																				@click="addOtherInput('experience_type')"> <i
																				class="fas fa-arrow-right"></i>
																			</a>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button"
																		class="btn btn-link modal-button-close"
																		data-dismiss="modal">Close</button>
																	<button type="button"
																		class="btn btn-link modal-button-done"
																		data-dismiss="modal"
																		@click="changeSelectedValue('experience_type')">Done</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class=" col-12 mb-3">
												<div class=" row rowDownloadFile">
													<label class="requestLabel col-12">CV:</label>
													<div class="col-md-4 aDiv">
														<a target="_blank" href="{{asset($contractor->cv)}}"
															class="btn btn-primary clickBtn ">Click here To CV file</a>
													</div>

													<div class="col-md-8 ">
														<div
															class="form-group form-file-upload form-file-multiple"
															style="margin: 0 !important;">
															<input id="cv" name="cv" type="file"
																class="inputFileHidden"
																@change="onChangeFile($event, 'cv_input')">
															<div class="input-group" @click="addFile('cv')">
																<input type="text" id="cv_input"
																	class="form-control inputFileVisible"
																	placeholder="Upload file"> <span
																	class="input-group-btn">
																	<button type="button"
																		class="btn btn-fab btn-round btn-success">
																		<i class="fas fa-cloud-upload-alt"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>

												</div>
											</div>



											<div class=" col-12 mb-3">
												<div class=" row rowDownloadFile">
													<label class="requestLabel  col-12">Job reference:</label>
													<div class="col-md-4 aDiv">
														<a target="_blank"
															href="{{asset($contractor->job_reference)}}"
															class="btn btn-primary clickBtn">Click here to job
															reference file</a>
													</div>
													<div class="col-md-8 ">
														<div
															class="form-group form-file-upload form-file-multiple"
															style="margin: 0 !important;">
															<input id="job_reference" name="job_reference"
																type="file" class="inputFileHidden"
																@change="onChangeFile($event,'job_reference_input')">
															<div class="input-group"
																@click="addFile('job_reference')">
																<input type="text" id="job_reference_input"
																	class="form-control inputFileVisible"
																	placeholder="Upload file"> <span
																	class="input-group-btn">
																	<button type="button"
																		class="btn btn-fab btn-round btn-success">
																		<i class="fas fa-cloud-upload-alt"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<div class=" row">
													<label for="available_tools" class="requestLabel col-12"
														style="margin-bottom: 0">Available tools and equipment</label>
													<div class="d-flex justify-content-between"
														style="padding: 0 15px; width: 100%;">
														<div class="col-md-12 d-flex" style="padding-left: 0;"
															@click="checkEquipment()">
															<div class="my-check-box" id="check">
																<i
																	:class="equipments_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
															</div>
															<label style="margin-left: 10px; margin-top: 1px;"
																for="my-check-box"
																:class="equipments_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">I
																declare I have the correct tools to carry out the type
																of work I have requested</label>
														</div>
														<input type="hidden" name="available_equipments"
															v-model="available_tool_input" required>

													</div>

												</div>
											</div>


											<div class="col-12">
												<div class=" row">
													<div class="col-md-12">
														<h5 class="registerSubTitle">Other Details</h5>
													</div>
												</div>
											</div>

											<div class="col-md-12 ">
												<div class="row">
													<label for="address" class="requestLabel col-12">Address <input
														id="address" type="text" class="form-control"
														name="address" value="{{$contractor->address}}" required></label>
													<input type="hidden" id="address_coordinates"
														name="address_coordinates" value="{{$contractor->address_coordinates}}">
												</div>
											</div>

											<div class="col-12">
												<div class=" row">
													<label class="requestLabel  col-12">Company number <input
														type="text" name="company_number" class="form-control "
														value="{{$contractor->company_number ?
														$contractor->company_number : ''}}" /></label>
												</div>
											</div>
											<div class="col-12">
												<div class=" row">
													<label class="requestLabel  col-12">VAT number <input
														class="form-control" type="text" name="vat_number"
														value="{{$contractor->vat_number ?: ''}}" /></label>
												</div>
											</div>
											<div class=" col-12 mb-3">
												<div class=" row rowDownloadFile">
													<label class="requestLabel  col-12">Insurance document:</label>
													<div class="col-md-4 aDiv">
														<a target="_blank"
															href="{{asset($contractor->insurance_document)}}"
															class="btn btn-primary clickBtn">Click here to insurance
															document</a>
													</div>
													<div class="col-md-8 ">
														<div
															class="form-group form-file-upload form-file-multiple"
															style="margin: 0 !important;">
															<input name="insurance_document" id="insurance_document"
																type="file" class="inputFileHidden"
																@change="onChangeFile($event,'insurance_document_input')">
															<div class="input-group"
																@click="addFile('insurance_document')">
																<input id="insurance_document_input" type="text"
																	class="form-control inputFileVisible"
																	placeholder="Upload Document"> <span
																	class="input-group-btn">
																	<button type="button"
																		class="btn btn-fab btn-round btn-success">
																		<i class="fas fa-cloud-upload-alt"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>

												</div>
											</div>

											<div class="col-12">
												<div class=" row">
													<label class="requestLabel  col-12">Do you have access to a
														smartphone?: <span
														class="form-control customerRequestSpan col-12">
															{{$contractor->has_smartphone ? 'Yes' : 'No'}}</span>
													</label>
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<div class=" row">
													<label class=" requestLabel col-12" for="">Do you have a
														smartphone?</label>
													<div class="col-12 row">
														<div class="col">
															<div class="form-check form-check-radio">
																<label class="form-check-label"> <input
																	class="form-check-input" type="radio"
																	id="exampleRadios2" name="has_smartphone" value="1"
																	{{$contractor->has_smartphone ? 'checked' : ''}}
																	required> Yes <span class="circle"> <span class="check"></span>
																</span>
																</label>
															</div>
														</div>
														<div class="col">
															<div class="form-check form-check-radio">
																<label class="form-check-label"> <input
																	class="form-check-input" type="radio"
																	id="exampleRadios1" name="has_smartphone" value="0"
																	{{$contractor->has_smartphone == '0' ? 'checked' : ''}}
																	required> No <span class="circle"> <span class="check"></span>
																</span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<div class="row">
													<label class=" requestLabel col-12">Contact through</label>
													<div class="col-12 d-flex">
														<div class="contact-through d-flex pr-5"
															@click="changeContact('whatsapp')">
															<div id="check"
																:class="contact_through == 'whatsapp' ? 'my-check-box checked' : 'my-check-box'">
																<i class="fas fa-check-square"></i>
															</div>
															<label class="form-check-label">Whatsapp</label>
														</div>

														<div class="contact-through d-flex"
															@click="changeContact('sms')">
															<div id="check"
																:class="contact_through == 'sms' ? 'my-check-box checked' : 'my-check-box'">
																<i class="fas fa-check-square"></i>
															</div>
															<label class="form-check-label">SMS</label>
														</div>
														<input type="hidden" v-model="contact_through"
															name="contact_through">
													</div>
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<div class="row">
													<label class="requestLabel col-12" for="transport_types">Type
														of transport</label>
													<div class="col-12 d-flex justify-content-between">
														<input type="text" class="form-control"
															id="transport_types" name="type_of_transport"
															v-model="transport_type_input"
															@click="openModal('transport_types')" required> <a
															class="select-icon"> <i class="fas fa-caret-down"></i>
														</a>
													</div>
													<!-- Button trigger modal -->
													<a id="transport_types_btn_modal" data-toggle="modal"
														data-target="#transport_typesModal" style="display: none"></a>

													<!-- Modal -->
													<div class="modal fade" id="transport_typesModal"
														tabindex="-1" role="dialog"
														aria-labelledby="available_toolsLabel" aria-hidden="true">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title text-left registerModalTitle"
																		id="type_of_experienceLabel">Type of Transport</h5>
																	<button type="button" class="close"
																		data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<div class="row">
																		<div class="col-md-12 d-flex justify-content-between"
																			v-for="type in transport_types"
																			@click="toggleCheckedValue(type)">
																			<label for="my-check-box"
																				:class="type.is_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{
																				type.title }}</label>
																			<div class="my-check-box" id="check">
																				<i
																					:class="type.is_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button"
																		class="btn btn-link modal-button-close"
																		data-dismiss="modal">Close</button>
																	<button type="button"
																		class="btn btn-link modal-button-done"
																		data-dismiss="modal"
																		@click="changeSelectedValue('transport_types')">Done</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-12 ">
												<div class="row">
													<label class="requestLabel col-12">Social media profiles <input
														type="text" class="form-control" name="social_profile"
														value="{{$contractor->social_profile}}" ></label>
												</div>
											</div>
											<div class="col-md-12 ">
												<div class="row">
													<label class="requestLabel col-12">Website address <input
														type="text" class="form-control" id="website_address"
														name="website_address"
														value="{{$contractor->website_address}}" ></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						@if($readOnly==0)
						<div class="row">
							<div class="col-12 text-center">
								<button class="btn btn-register btn-gardenhelp-green">Edit</button>
							</div>
						</div>

					</form>
					@endif
				</div>
			</div>

		</div>
	</div>

</div>
@endsection @section('page-scripts')
<script>
$(document).ready(function() {
        $(".js-example-basic-single").select2();
  
		var readonly = {!! $readOnly !!};
		if(readonly==1){
			$("input").prop('disabled', true);
			$("textarea").prop('disabled', true);
		}
	});
</script>
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script>
        var app = new Vue({
            el: '#app',
            data: {
            
                experience_level: '{!! $contractor->experience_level_value ? $contractor->experience_level_value : 1 !!}',
                experience_level_input: '{!! $contractor->experience_level ?  $contractor->experience_level : '(0-2 Years)' !!}',
                experience_level_selected_value: '{!! $contractor->experience_level_value ? $contractor->experience_level_value : 1 !!}',
                experience_types: [
                    {
                        title: 'Garden Design',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Garden Design') === false ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Tree surgery',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Tree surgery') === false ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Garden Maintenance',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Garden Maintenance') === false  ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["2", "3"]
                    },
					{
						title: 'Commercial Garden Maintenance',
						is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Decking') === false  ? 'false' : 'true' ) : 'false' !!}"),
						level: ["2", "3"],
					},
                    {
                        title: 'Grass Cutting',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Grass Cutting') === false ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Fencing')  === false  ? 'false' : true) : 'false' !!}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Groundwork',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Groundwork') === false  ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Hard Landscaping',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Hard Landscaping') === false  ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["2", "3"],
                    },
                    {
                        title: 'Patios',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Patios') === false  ? 'false' : 'true' ) : 'false' !!}"),
                        level: ["2", "3"],
                    },
                    {
                        title: 'Decking',
                        is_checked: JSON.parse("{!! $contractor->type_of_work_exp ? ( strpos($contractor->type_of_work_exp, 'Decking') === false  ? 'false' : 'true' ) : 'false'!!}"),
                        level: ["2", "3"],
                    },
                ],
                experience_type: '{!! $contractor->type_of_work_exp!!}',
                experience_type_input: '{!! $contractor->type_of_work_exp!!}',
                experience_type_other: '',
                available_tools: [
                    {
                        title: 'Hedge cutters',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hedge cutters') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Hand fork',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hand fork') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Lawn scarifier',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Lawn scarifier') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Hoe',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hoe') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Secateurs',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Secateurs') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Dibber',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Dibber') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Pruning saw',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Pruning saw') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Paving knife',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Paving knife') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Edging knife',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Edging knife') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Mattock',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Mattock') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                ],
                available_tool_other: '',
                available_tool_input: "{!! $contractor->available_equipments !!}",
                transport_types: [
                    {
                        title: 'Van',
                        is_checked: JSON.parse("{!! $contractor->type_of_transport ? ( strpos($contractor->type_of_transport, 'Van') === false  ? 'false' : 'true' ) : 'false'!!}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{!! $contractor->type_of_transport ? ( strpos($contractor->type_of_transport, 'Trailer') === false  ? 'false' : 'true' ) : 'false'!!}")
                    }
                ],
                transport_type_input: "{!! $contractor->type_of_transport !!}",
                charge: "{{old('charge_type')}}",
                call_out_fee: "{{old('has_callout_fee')}}",
                call_out_fee_charge: "{{old('callout_fee_value')}}",
                green_waste_collection_methods: [
                    {
                        title: 'Ton bags',
                        is_checked: JSON.parse("{{old('green_waste_collection_method') ? ( strpos(old('green_waste_collection_method'), 'Ton bags') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{{old('green_waste_collection_method') ? ( strpos(old('green_waste_collection_method'), 'Trailer') === false  ? 'false' : 'true' ) : 'false'}}")
                    }
                ],
                green_waste_collection_method_input: "{{old('green_waste_collection_method')}}",
                green_waste_collection_method_other: '',
                equipments_checked: true,
				type_of_work: [
					{
						title: 'Residential',
						is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Residential') === false ? 'false' : 'true' ) : 'false'}}"),
						level: ["3"],
					},
					{
						title: 'Commercial',
						is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Commercial') === false ? 'false' : 'true' ) : 'false'}}"),
						level: ["3"],
					},
				],
				type_of_work_selected_value: '',
				contact_through: '{!! $contractor->contact_through !!}'
            },
            mounted() {

            },
            methods: {
                changeExperienceLevel() {
                    if (this.experience_level == 1) {
                        this.experience_level_input = "(0-2 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    } else if (this.experience_level == 2) {
                        this.experience_level_input = "(2-5 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    } else {
                        this.experience_level_input = "(+5 Years)";
                        this.experience_level_selected_value = this.experience_level;
                        let type_of_work_selected_value = [];
                        for (let item of this.type_of_work) {
                        	if (item.is_checked === true) {
								this.experience_level_input +=  ', ' + item.title;
								type_of_work_selected_value.push(item.title);
							}
						}
                        this.type_of_work_selected_value = type_of_work_selected_value.length > 0 ? JSON.stringify(type_of_work_selected_value) : '';
                    }
                },
                openModal(type) {
                    $('#' + type + '_btn_modal').click();
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                addOtherInput(type) {
                    if (type === 'experience_type') {
                        this.experience_types.push({
                            title: this.experience_type_other,
                            is_checked: true,
                            level: [this.experience_level],
                        });
                        this.experience_type_other = '';
                    } else if (type === 'available_tools') {
                        this.available_tools.push({
                            title: this.available_tool_other,
                            is_checked: true
                        });
                        this.available_tool_other = '';
                    } else if (type === 'green_waste_collection_method') {
                        this.green_waste_collection_methods.push({
                            title: this.green_waste_collection_method_other,
                            is_checked: true
                        });
                        this.green_waste_collection_method_other = '';
                    }
                },
                changeSelectedValue(type) {
                    let input = '';
                    let list = '';
                    if (type === 'experience_type') {
                        this.experience_type_input = '';
                        list = this.experience_types;
                        for(let item of list) {
                            item.is_checked === true ? this.experience_type_input += (this.experience_type_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'available_tools') {
                        this.available_tool_input = '';
                        list = this.available_tools;
                        for(let item of list) {
                            item.is_checked === true ? this.available_tool_input += (this.available_tool_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'transport_types') {
                        this.transport_type_input = '';
                        list = this.transport_types;
                        for(let item of list) {
                            item.is_checked === true ? this.transport_type_input += (this.transport_type_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'green_waste_collection_methods') {
                        this.green_waste_collection_method_input = '';
                        list = this.green_waste_collection_methods;
                        for(let item of list) {
                            item.is_checked === true ? this.green_waste_collection_method_input += (this.green_waste_collection_method_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    }
                },
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e ,id) {
                    $("#" + id).val(e.target.files[0].name);
                },
                checkEquipment() {
                    if(this.equipments_checked == true) {
                        this.equipments_checked = false;
                        this.available_tool_input = '';
                    } else {
                        this.equipments_checked = true;
                        this.available_tool_input = "I declare I have the correct tools to carry out the type of work I have requested";
                    }
                },
				changeContact(value) {
					this.contact_through = value;
				},
				beforeFormSubmitting(e) {
                	e.preventDefault();
                	let cv_input = $('#cv');
                	let job_ref_input = $('#job_reference');
                	let hourly_rate =  $('#charge_rate');
                	if (this.experience_level_selected_value==3) {
                		if (cv_input.val() == "" || job_ref_input.val() == "") {
							swal({
								title: 'There is a missing input',
								text: "CV and Job reference are required",
								icon: 'error',
							})
							return false;
						} else if (hourly_rate.val() > 30) {
							swal({
								title: 'There is a missing input',
								text: "Max Hourly Rate for (+5 years) experience is €30 Per Hour, " +
										"please change the rate to be able to proceed with the registration form",
								icon: 'warning',
							})
							return false;
						}
					} else if (this.experience_level_selected_value==2) {
						if (hourly_rate.val() > 20) {
							swal({
								title: 'There is a missing input',
								text: "Max Hourly Rate for " + this.experience_level_selected_value +" experience is €20 Per Hour, " +
										"please change the rate to be able to proceed with the registration form",
								icon: 'warning',
							});
							return false;
						}
					} else {
						if (hourly_rate.val() > 15) {
							swal({
								title: 'There is a missing input',
								text: "Max Hourly Rate for Level " + this.experience_level_selected_value +" experience is €15 Per Hour, " +
										"please change the rate to be able to proceed with the registration form",
								icon: 'warning',
							});
							return false;
						}
					}
                	$('#cr_form').submit();
				}
            }
        });

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
