@extends('templates.garden_help')
@section('title', 'GardenHelp | Contractors Registration')
@section('styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
	.iti {
		width: 100%;
	}
	.modal-body .row .d-flex {
		padding-bottom: 13px;
	}

	.content-card {
		border-radius: 20px;
		box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08);
		background-color: #ffffff;
		margin-top: 10px;
		padding-top: 25px;
	}

	.select-icon {
		position: absolute;
		right: 0;
		color: gray;
		margin-top: 10px;
		margin-right: 15px;
		color: #c3c7d2 !important;
		transition: 0.3s ease-in-out;
		font-size: 20px;
	}
	.bmd-form-group .bmd-label-static {
		top: -1rem !important;
	}
</style>
@endsection
@section('content')
<div class="container" id="app">
	<form action="{{route('postContractorRegistration', 'garden-help')}}"
		method="POST" enctype="multipart/form-data" autocomplete="off" id="cr_form" @submit="beforeFormSubmitting">
		{{csrf_field()}}
		<div class="main main-raised">
			<div class="h-100 row align-items-center">
				<div class="col-md-12 text-center">
					<img src="{{asset('images/gardenhelp/Garden-help-new-logo.png')}}"
						style="height: 150px" alt="GardenHelp">
				</div>
			</div>
			<div class="container">
				<div class="section">
					<h4 class="registerTitle">Contractors Registration Form</h4>
					<h5 class="registerSubTitle">Company/Individual Details</h5>
				</div>
				@if(count($errors))
				<div class="alert alert-danger" role="alert">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li> @endforeach
					</ul>
				</div>
				@endif
				<div class="row">
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Name</label> <input type="text"
								class="form-control" name="name" value="{{old('name')}}"
								required>
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Email address</label> <input
								type="email" class="form-control" name="email"
								value="{{old('email')}}" required>
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label>Phone number</label>
							<input
								type="tel" class="form-control" id="phone_number"
								value="{{old('phone_number')}}" required>
							<!--<input type="hidden" name="phone_number">-->
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label for="experience_level" class="bmd-label-floating">Years of experience
								</label> <input name="experience_level" type="text"
								class="form-control" id="experience_level"
								v-model="experience_level_input"
								@click="openModal('experience_level')" required>
							<!-- Button trigger modal -->
							<a id="experience_level_btn_modal" data-toggle="modal"
								data-target="#experience_levelModal" style="display: none"></a>

							<!-- Modal -->
							<div class="modal fade" id="experience_levelModal" tabindex="-1"
								role="dialog" aria-labelledby="experience_levelLabel"
								aria-hidden="true">
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
														<i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
													</div>
													<label for="my-check-box mr-1" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-link modal-button-close"
												data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-link modal-button-done"
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
						<div class="form-group bmd-form-group">
							 <label class="bmd-label-floating">Hourly Rate</label>
							<input type="number" class="form-control" id="charge_rate" name="charge_rate" value="{{old('charge_rate')}}" required>
						</div>
					</div>

					<div class="col-md-12 mb-3">
						<div
							class="form-group form-file-upload form-file-multiple bmd-form-group">
							<label class="bmd-label-static" for="age_proof"> Upload age card
								or passport <br> (Age proof 18 or older)
							</label> <br> <input id="age_proof" name="age_proof" type="file"
								class="inputFileHidden"
								@change="onChangeFile($event, 'age_proof_input')">
							<div class="input-group" @click="addFile('age_proof')">
								<input type="text" id="age_proof_input"
									class="form-control inputFileVisible"
									placeholder="Upload Photo" required> <span
									class="input-group-btn">
									<button type="button" class="btn btn-fab btn-round btn-success">
										<i class="fas fa-cloud-upload-alt"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label  class="" for="type_of_experience">Type of work experience </label>
							<input name="type_of_work_exp" type="text" class="form-control"
									id="type_of_experience" v-model="experience_type_input" @click="openModal('type_of_experience')"
									required>
							
								<input type="hidden" v-model="type_of_work_selected_value" name="type_of_work_selected_value">
							
							<!-- Button trigger modal -->
							<a id="type_of_experience_btn_modal" data-toggle="modal"
								data-target="#type_of_experienceModal" style="display: none"></a>

							<!-- Modal -->
							<div class="modal fade" id="type_of_experienceModal"
								tabindex="-1" role="dialog"
								aria-labelledby="type_of_experienceLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title text-left registerModalTitle"
												id="type_of_experienceLabel">Type of work experience</h5>
											<button type="button" class="close" data-dismiss="modal"
												aria-label="Close">
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
													<input type="text" class="form-control add-other-input"
														placeholder="Add other" v-model="experience_type_other"> <a
														class="add-other-button"
														v-if="experience_type_other != ''"
														@click="addOtherInput('experience_type')"> <i
														class="fas fa-arrow-right"></i>
													</a>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-link modal-button-close"
												data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-link modal-button-done"
												data-dismiss="modal"
												@click="changeSelectedValue('experience_type')">Done</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<div class="form-group form-file-upload form-file-multiple bmd-form-group">
							<label class="" for="cv"> Upload CV @{{experience_level_selected_value == 3 ? '*' : ''}} <br> </label>
							<input id="cv" name="cv" type="file" class="inputFileHidden" @change="onChangeFile($event, 'cv_input')">
							<div class="input-group" @click="addFile('cv')">
								<input type="text" id="cv_input" class="form-control inputFileVisible" placeholder="Upload file">
								<span class="input-group-btn">
									<button type="button" class="btn btn-fab btn-round btn-success">
										<i class="fas fa-cloud-upload-alt"></i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="col-md-12 mb-3">
						<div class="form-group form-file-upload form-file-multiple">
							<label class="" for="job_reference"> Upload job
								references  <br></label> <input id="job_reference"
								name="job_reference" type="file" class="inputFileHidden"
								@change="onChangeFile($event,'job_reference_input')">
							<div class="input-group" @click="addFile('job_reference')">
								<input type="text" id="job_reference_input"
									class="form-control inputFileVisible" placeholder="Upload file">
								<span class="input-group-btn">
									<button type="button" class="btn btn-fab btn-round btn-success">
										<i class="fas fa-cloud-upload-alt"></i>
									</button>
								</span>
							</div>
						</div>
					</div>

					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label for="available_tools">Available tools and equipment</label>
							<div class="d-flex justify-content-between"
								{{--@click="openModal('available_tools')"--}}>
								<div class="col-md-12 d-flex"
									style="padding-left: 0; padding-top: 5px;"
									@click="checkEquipment()">
									<div class="my-check-box" id="check">
										<i
											:class="equipments_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
									</div>
									<label style="margin-left: 14px; margin-top: 4px;"
										for="my-check-box"
										:class="equipments_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">I
										declare I have the correct tools to carry out the type of work
										I have requested</label>
								</div>
								<input type="hidden" name="available_equipments"
									v-model="available_tool_input" required> {{-- <input
									type="text" class="form-control" name="available_equipments"
									id="available_tools" v-model="available_tool_input" required>--}}
								{{-- <a class="select-icon">--}} {{-- <i
									class="fas fa-caret-down"></i>--}} {{--
								</a>--}}
							</div>
							<!-- Button trigger modal -->
							{{-- <a id="available_tools_btn_modal" data-toggle="modal"
								--}}
{{--                                   data-target="#available_toolsModal"
								style="display: none"></a>--}} {{--
							<!-- Modal -->
							--}} {{--
							<div class="modal fade" id="available_toolsModal" tabindex="-1"
								role="dialog"
								--}}
{{--                                     aria-labelledby="available_toolsLabel"
								aria-hidden="true">
								--}} {{--
								<div class="modal-dialog" role="document">
									--}} {{--
									<div class="modal-content">
										--}} {{--
										<div class="modal-header">
											--}} {{--
											<h5 class="modal-title text-left"
												id="type_of_experienceLabel">Available Tools and Equipment</h5>
											--}} {{--
											<button type="button" class="close" data-dismiss="modal"
												aria-label="Close">
												--}} {{-- <span aria-hidden="true">&times;</span>--}} {{--
											</button>
											--}} {{--
										</div>
										--}} {{--
										<div class="modal-body">
											--}} {{--
											<div class="row">
												--}} {{--
												<div class="col-md-12 d-flex justify-content-between"
													v-for="tool in available_tools"
													@click="toggleCheckedValue(tool)">
													--}} {{-- <label for="my-check-box"
														:class="tool.is_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{
														tool.title }}</label>--}} {{--
													<div class="my-check-box" id="check">
														--}} {{-- <i
															:class="tool.is_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>--}}
														{{--
													</div>
													--}} {{--
												</div>
												--}} {{--
												<div class="col-md-12 d-flex justify-content-between">
													--}} {{-- <input type="text" class="form-control"
														placeholder="Add Other" v-model="available_tool_other">--}}
													{{-- <a class="add-other-button"
														v-if="available_tool_other != ''"
														@click="addOtherInput('available_tools')">--}} {{-- <i
														class="fas fa-arrow-right"></i>--}} {{--
													</a>--}} {{--
												</div>
												--}} {{--
											</div>
											--}} {{--
										</div>
										--}} {{--
										<div class="modal-footer">
											--}} {{--
											<button type="button" class="btn btn-link modal-button-close"
												data-dismiss="modal">Close--}} {{--</button>
											--}} {{--
											<button type="button" class="btn btn-link modal-button-done"
												data-dismiss="modal"
												@click="changeSelectedValue('available_tools')">--}} {{--
												Done--}} {{--</button>
											--}} {{--
										</div>
										--}} {{--
									</div>
									--}} {{--
								</div>
								--}} {{--
							</div>
							--}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<br> {{--Other Details--}}
		<div class="main main-raised content-card">
			<div class="container">
				<div class="section">
					<h5 class="registerSubTitle">Other Details</h5>
				</div>
				<div class="row">
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label for="address">Address</label>
							<input id="address" type="text" class="form-control" name="address" value="{{old('address')}}" required>
							<input type="hidden" id="address_coordinates" name="address_coordinates">
						</div>
					</div>

					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating" for="company-number">Company
								number (if registered)</label> <input id="company-number"
								type="text" class="form-control" name="company_number"
								value="{{old('company_number')}}">
						</div>
					</div>
					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label for="vat-number" class="bmd-label-floating">VAT number (if
								registered)</label> <input id="vat-number" type="text"
								class="form-control" name="vat_number"
								value="{{old('vat_number')}}">
						</div>
					</div>
					<div class="col-md-12 mb-1">
						<div class="form-group form-file-upload form-file-multiple">
							<label for="vat-number">Upload insurance document</label> <input
								name="insurance_document" id="insurance_document" type="file"
								class="inputFileHidden"
								@change="onChangeFile($event,'insurance_document_input')">
							<div class="input-group" @click="addFile('insurance_document')">
								<input id="insurance_document_input" type="text"
									class="form-control inputFileVisible"
									placeholder="Upload Document"> <span
									class="input-group-btn">
									<button type="button" class="btn btn-fab btn-round btn-success">
										<i class="fas fa-cloud-upload-alt"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-12 mb-1">
						<div class="form-group ">
							<label class="bmd-label-floating" for="">Do you have a
								smartphone?</label>
							<div class="row">
								<div class="col">
									<div class="form-check form-check-radio">
										<label class="form-check-label"> <input
											class="form-check-input" type="radio" id="exampleRadios2"
											name="has_smartphone" value="1" {{old('has_smartphone') ===
											'1' ? 'checked' : ''}} required> Yes <span class="circle"> <span
												class="check"></span>
										</span>
										</label>
									</div>
								</div>
								<div class="col">
									<div class="form-check form-check-radio">
										<label class="form-check-label"> <input
											class="form-check-input" type="radio" id="exampleRadios1"
											name="has_smartphone" value="0" {{old('has_smartphone') ===
											'0' ? 'checked' : ''}} required> No <span class="circle"> <span
												class="check"></span>
										</span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 mb-3">
						<div class="form-group">
							<label>Contact through</label>
							<div class="d-flex">
								<div class="contact-through d-flex pr-5" @click="changeContact('whatsapp')">
									<div id="check" :class="contact_through == 'whatsapp' ? 'my-check-box checked' : 'my-check-box'">
										<i class="fas fa-check-square"></i>
									</div>
									Whatsapp
								</div>

								<div class="contact-through d-flex" @click="changeContact('sms')">
									<div id="check" :class="contact_through == 'sms' ? 'my-check-box checked' : 'my-check-box'">
										<i class="fas fa-check-square"></i>
									</div>
									SMS
								</div>
								<input type="hidden" v-model="contact_through" name="contact_through">
							</div>
						</div>
					</div>

					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label class="" for="transport_types">Type of
								Transport</label>
							<div class="d-flex justify-content-between">
								<input type="text" class="form-control" id="transport_types"
									name="type_of_transport" v-model="transport_type_input"
									@click="openModal('transport_types')" required> <a
									class="select-icon"> <i class="fas fa-caret-down"></i>
								</a>
							</div>
							<!-- Button trigger modal -->
							<a id="transport_types_btn_modal" data-toggle="modal"
								data-target="#transport_typesModal" style="display: none"></a>

							<!-- Modal -->
							<div class="modal fade" id="transport_typesModal" tabindex="-1"
								role="dialog" aria-labelledby="available_toolsLabel"
								aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title text-left registerModalTitle"
												id="type_of_experienceLabel">Type of Transport</h5>
											<button type="button" class="close" data-dismiss="modal"
												aria-label="Close">
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
											<button type="button" class="btn btn-link modal-button-close"
												data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-link modal-button-done"
												data-dismiss="modal"
												@click="changeSelectedValue('transport_types')">Done</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

{{--					<div class="col-md-12 mb-3"--}}
{{--						v-if="experience_level_selected_value == 3">--}}
{{--						<div class="form-group form-file-upload form-file-multiple">--}}
{{--							<label class="bmd-label-floating" >What type of charge?</label>--}}
{{--							<div class="row">--}}
{{--								<div class="col">--}}
{{--									<div class="form-check form-check-radio">--}}
{{--										<label class="form-check-label"> <input--}}
{{--											class="form-check-input" type="radio" id="exampleRadios2"--}}
{{--											name="charge_type" value="Hourly" v-model="charge" required>--}}
{{--											Hourly <span class="circle"> <span class="check"></span>--}}
{{--										</span>--}}
{{--										</label>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="col">--}}
{{--									<div class="form-check form-check-radio">--}}
{{--										<label class="form-check-label"> <input--}}
{{--											class="form-check-input" type="radio" id="exampleRadios1"--}}
{{--											name="charge_type" value="Daily" v-model="charge" required>--}}
{{--											Daily <span class="circle"> <span class="check"></span>--}}
{{--										</span>--}}
{{--										</label>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="col-md-12 mb-3"--}}
{{--						v-if="experience_level_selected_value == 3 && charge != ''">--}}
{{--						<div class="form-group bmd-form-group">--}}
{{--							--}}{{-- <label class="bmd-label-floating">Social Media Profiles--}}
{{--								(optional)</label>--}}{{-- <input type="text" class="form-control"--}}
{{--								name="charge_rate" :placeholder="charge + ' Charge'"--}}
{{--								value="{{old('charge_rate')}}" required>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="col-md-12 mb-3"--}}
{{--						v-if="experience_level_selected_value == 3">--}}
{{--						<div class="form-group form-file-upload form-file-multiple">--}}
{{--							<label class="bmd-label-floating" >Do you charge a call out fee?</label>--}}
{{--							<div class="row">--}}
{{--								<div class="col">--}}
{{--									<div class="form-check form-check-radio">--}}
{{--										<label class="form-check-label"> <input--}}
{{--											class="form-check-input" type="radio" id="exampleRadios2"--}}
{{--											name="has_callout_fee" value="1" v-model="call_out_fee"> Yes--}}
{{--											<span class="circle"> <span class="check"></span>--}}
{{--										</span>--}}
{{--										</label>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="col">--}}
{{--									<div class="form-check form-check-radio">--}}
{{--										<label class="form-check-label"> <input--}}
{{--											class="form-check-input" type="radio" id="exampleRadios1"--}}
{{--											name="has_callout_fee" value="0" v-model="call_out_fee"> No <span--}}
{{--											class="circle"> <span class="check"></span>--}}
{{--										</span>--}}
{{--										</label>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

					{{--
					<div class="col-md-12 mb-3"
						v-if="experience_level_selected_value == 3 && call_out_fee === '1'">
						--}} {{--
						<div class="form-group bmd-form-group">
							--}} {{-- <label class="bmd-label-floating">Call out fee charge</label>--}}
							{{-- <input type="text" class="form-control"
								name="callout_fee_value">--}} {{--
						</div>
						--}} {{--
					</div>
					--}}

{{--					<div class="col-md-12 mb-3"--}}
{{--						v-if="experience_level_selected_value == 3 && call_out_fee === '1'">--}}
{{--						<div class="form-group bmd-form-group">--}}
{{--							--}}{{-- <label class="bmd-label-floating">Call out fee charge</label>--}}
{{--							<input type="text" class="form-control" name="callout_fee_value"--}}
{{--								placeholder="Call out fee charge"--}}
{{--								value="{{old('callout_fee_value')}}" required>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="col-md-12 mb-3"--}}
{{--						v-if="experience_level_selected_value == 3">--}}
{{--						<div class="form-group bmd-form-group">--}}
{{--							<label class="">Rates for green waste removal</label>--}}
{{--							 <input type="text" class="form-control"--}}
{{--								name="rate_of_green_waste"--}}
{{--								value="{{old('rate_of_green_waste')}}" required>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					--}}

{{--					<div class="col-md-12 mb-3"--}}
{{--						v-if="experience_level_selected_value == 3">--}}
{{--						<div class="form-group bmd-form-group">--}}
{{--							<label for="green_waste_collection_method">Green waste collection--}}
{{--								method</label>--}}
{{--							<div class="d-flex justify-content-between"--}}
{{--								@click="openModal('green_waste_collection_method')">--}}
{{--								<input type="text" name="green_waste_collection_method"--}}
{{--									class="form-control" id="green_waste_collection_method"--}}
{{--									v-model="green_waste_collection_method_input" required> <a--}}
{{--									class="select-icon"> <i class="fas fa-caret-down"></i>--}}
{{--								</a>--}}
{{--							</div>--}}
{{--							<!-- Button trigger modal -->--}}
{{--							<a id="green_waste_collection_method_btn_modal"--}}
{{--								data-toggle="modal"--}}
{{--								data-target="#green_waste_collection_methodsModal"--}}
{{--								style="display: none"></a>--}}

{{--							<!-- Modal -->--}}
{{--							<div class="modal fade" id="green_waste_collection_methodsModal"--}}
{{--								tabindex="-1" role="dialog"--}}
{{--								aria-labelledby="available_toolsLabel" aria-hidden="true">--}}
{{--								<div class="modal-dialog" role="document">--}}
{{--									<div class="modal-content">--}}
{{--										<div class="modal-header">--}}
{{--											<h5 class="modal-title text-left registerModalTitle"--}}
{{--												id="green_waste_collection_methodsLabel">Green waste--}}
{{--												collection method</h5>--}}
{{--											<button type="button" class="close" data-dismiss="modal"--}}
{{--												aria-label="Close">--}}
{{--												<span aria-hidden="true">&times;</span>--}}
{{--											</button>--}}
{{--										</div>--}}
{{--										<div class="modal-body">--}}
{{--											<div class="row">--}}
{{--												<div class="col-md-12 d-flex justify-content-between"--}}
{{--													v-for="method in green_waste_collection_methods"--}}
{{--													@click="toggleCheckedValue(method)">--}}
{{--													<label for="my-check-box"--}}
{{--														:class="method.is_checked === true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{--}}
{{--														method.title }}</label>--}}
{{--													<div class="my-check-box" id="check">--}}
{{--														<i--}}
{{--															:class="method.is_checked === true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>--}}
{{--													</div>--}}
{{--												</div>--}}
{{--												<div class="col-md-12 d-flex justify-content-between">--}}
{{--													<input type="text" class="form-control"--}}
{{--														placeholder="Add Other"--}}
{{--														v-model="green_waste_collection_method_other"> <a--}}
{{--														class="add-other-button"--}}
{{--														v-if="green_waste_collection_method_other != ''"--}}
{{--														@click="addOtherInput('green_waste_collection_method')"> <i--}}
{{--														class="fas fa-arrow-right"></i>--}}
{{--													</a>--}}
{{--												</div>--}}
{{--											</div>--}}
{{--										</div>--}}
{{--										<div class="modal-footer">--}}
{{--											<button type="button" class="btn btn-link modal-button-close"--}}
{{--												data-dismiss="modal">Close</button>--}}
{{--											<button type="button" class="btn btn-link modal-button-done"--}}
{{--												data-dismiss="modal"--}}
{{--												@click="changeSelectedValue('green_waste_collection_methods')">--}}
{{--												Done</button>--}}
{{--										</div>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

					<div class="col-md-12 mb-3">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Social media profiles
								(optional)</label> <input type="text" class="form-control"
								name="social_profiles" value="{{old('social_profiles')}}">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group bmd-form-group">
							<label class="bmd-label-floating">Website wddress (optional)</label>
							<input type="text" class="form-control" name="website"
								value="{{old('website')}}">
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12 mb-3 ml-2">
				<p class="terms">
					By clicking Submit, you agree to our <a class="terms-text" href="#">Terms
						& Conditions</a> and that you have read our <a
						class="terms-text" href="#">Privacy Policy</a>
				</p>
			</div>

			<div class="col-md-12 mb-3 submit-container">
				<button class="btn btn-gardenhelp-green btn-register" type="submit">Submit</button>
			</div>
		</div>
	</form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script>
        var app = new Vue({
            el: '#app',
            data: {
                experience_level: '{{old('experience_level_value') ? old('experience_level_value') : 1}}',
                experience_level_input: '{{old('experience_level') ?  old('experience_level') : '(0-2 Years)'}}',
                experience_level_selected_value: '{{old('experience_level_value') ? old('experience_level_value') : 1}}',
                experience_types: [
                    {
                        title: 'Garden Design',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Garden Design') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Tree surgery',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Tree surgery') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Garden Maintenance',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Garden Maintenance') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
					{
						title: 'Commercial Grass Cutting',
						is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Commercial Grass Cutting') === false  ? 'false' : 'true' ) : 'false'}}"),
						level: ["2", "3"],
					},
                    {
                        title: 'Grass Cutting',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Grass Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Fencing')  === false  ? 'false' : true) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Groundwork',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Groundwork') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Hard Landscaping',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Hard Landscaping') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"],
                    },
                    {
                        title: 'Patios',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Patios') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"],
                    },
                    {
                        title: 'Decking',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Decking') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"],
                    },
                ],
                experience_type: '{{old('type_of_work_exp')}}',
                experience_type_input: '{{old('type_of_work_exp')}}',
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
                available_tool_input: "{{old('available_equipments')}}",
                transport_types: [
                    {
                        title: 'Van',
                        is_checked: JSON.parse("{{old('type_of_transport') ? ( strpos(old('type_of_transport'), 'Van') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{{old('type_of_transport') ? ( strpos(old('type_of_transport'), 'Trailer') === false  ? 'false' : 'true' ) : 'false'}}")
                    }
                ],
                transport_type_input: "{{old('type_of_transport')}}",
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
                equipments_checked: false,
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
				contact_through: ''
            },
            mounted() {
            	let phone_input = document.getElementById('phone_number');
            	let input_name = 'phone_number';
				window.intlTelInput(phone_input, {
					hiddenInput: input_name,
					initialCountry: 'IE',
					separateDialCode: true,
					preferredCountries: ['IE', 'GB'],
					utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
				});
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
                	setTimeout(()=>{
						$('#cr_form').submit();
					},300);
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
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places,drawing&callback=initAutoComplete"></script>

@endsection
