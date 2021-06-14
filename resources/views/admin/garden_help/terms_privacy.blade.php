@extends('templates.dashboard') @section('title', 'GardenHelp | Terms')
@section('page-styles')

<style>

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

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}

.iti {
	width: 100%;
}

.requestSubTitle {
	margin-top: 25px !important;
	margin-bottom: 10px !important;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<form method="POST"
				action="{{route('garden_help_postTermsPrivacy',['garden-help'])}}"
				id="termsForm"  @submit="beforeFormSubmitting" enctype="multipart/form-data">
				 {{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-sm-4">
									<div class="card-icon">
										<i class="fas fa-clipboard-list"></i>
									</div>
									<h4 class="card-title ">Terms & Privacy</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">

										<div class="col-md-12">
											<h5 class="addServiceTypeSubTitle">Contractor</h5>
										</div>
										<div class=" col-12 mb-3">
											<div class=" row rowDownloadFile">
												<label class="requestLabel col-12">Terms & conditions</label>
<!-- 												<div class="col-md-4 aDiv"> -->
<!-- 													<a target="_blank" href="" -->
<!-- 														class="btn btn-primary clickBtn ">Click here to terms file</a> -->
<!-- 												</div> -->
												<div class="col-md-8 ">
													<div class="form-group form-file-upload form-file-multiple"
														style="margin: 0 !important;">
														<input id="termsContractor" name="termsContractor" type="file"
															class="inputFileHidden" accept="application/pdf,.doc,.docx"
															@change="onChangeFile($event, 'termsContractor_input')">
														<div class="input-group" @click="addFile('termsContractor')">
															<input type="text" id="termsContractor_input"
																class="form-control inputFileVisible"
																placeholder="Upload file"> <span class="input-group-btn">
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
												<label class="requestLabel col-12">Privacy policy</label>
<!-- 												<div class="col-md-4 aDiv"> -->
<!-- 													<a target="_blank" href="" -->
<!-- 														class="btn btn-primary clickBtn ">Click here to privacy policy file</a> -->
<!-- 												</div> -->
												<div class="col-md-8 ">
													<div class="form-group form-file-upload form-file-multiple"
														style="margin: 0 !important;">
														<input id="privacyContractor" name="privacyContractor" type="file"
															class="inputFileHidden" accept="application/pdf"
															@change="onChangeFile($event, 'privacyContractor_input')">
														<div class="input-group" @click="addFile('privacyContractor')">
															<input type="text" id="privacyContractor_input"
																class="form-control inputFileVisible"
																placeholder="Upload file"> <span class="input-group-btn">
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

									</div>
								</div>
							</div>
						</div>


						<div class="card">

							<div class="card-body ">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<h5 class="addServiceTypeSubTitle">Customer</h5>
										</div>
										<div class=" col-12 mb-3">
											<div class=" row rowDownloadFile">
												<label class="requestLabel col-12">Terms & conditions</label>
<!-- 												<div class="col-md-4 aDiv"> -->
<!-- 													<a target="_blank" href="" -->
<!-- 														class="btn btn-primary clickBtn ">Click here to terms file</a> -->
<!-- 												</div> -->
												<div class="col-md-8 ">
													<div class="form-group form-file-upload form-file-multiple"
														style="margin: 0 !important;">
														<input id="termsCustomer" name="termsCustomer" type="file"
															class="inputFileHidden" accept="application/pdf"
															@change="onChangeFile($event, 'termsCustomer_input')">
														<div class="input-group" @click="addFile('termsCustomer')">
															<input type="text" id="termsCustomer_input"
																class="form-control inputFileVisible"
																placeholder="Upload file"> <span class="input-group-btn">
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
												<label class="requestLabel col-12">Privacy policy</label>
<!-- 												<div class="col-md-4 aDiv"> -->
<!-- 													<a target="_blank" href="" -->
<!-- 														class="btn btn-primary clickBtn ">Click here to privacy policy file</a> -->
<!-- 												</div> -->
												<div class="col-md-8 ">
													<div class="form-group form-file-upload form-file-multiple"
														style="margin: 0 !important;">
														<input id="privacyCustomer" name="privacyCustomer" type="file"
															class="inputFileHidden" accept="application/pdf"
															@change="onChangeFile($event, 'privacyCustomer_input')">
														<div class="input-group" @click="addFile('privacyCustomer')">
															<input type="text" id="privacyCustomer_input"
																class="form-control inputFileVisible"
																placeholder="Upload file"> <span class="input-group-btn">
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


									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 text-center">
								<button id="addNewServiceTypeBtn"
									class="btn btn-register btn-gardenhelp-green">Save</button>
							</div>
						</div>

					</div>
				</div>


			</form>
		</div>

	</div>
</div>

<div></div>

@endsection @section('page-scripts')

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
	var app = new Vue({
		el: '#app',
		data: {
		},
		mounted() {

		},
		methods: {
			addFile(id) {
				$('#' + id).click();
			},
			onChangeFile(e ,id) {
				$("#" + id).val(e.target.files[0].name);
			},
			beforeFormSubmitting(e) {
				e.preventDefault();
				/*let termsContractor_input = $('#termsContractor');
				let privacyContractor_input = $('#privacyContractor');
				let termsCustomer_input = $('#termsCustomer');
				let privacyCustomer_input = $('#privacyCustomer');
				if (termsContractor_input.val() == "" || privacyContractor_input.val()==""
					|| termsCustomer_input.val() == "" || privacyCustomer_input.val()=="") {
					swal({
						title: 'There is a missing input',
						text: "Terms and privacy are required",
						icon: 'error',
					})
					return false;
				}*/
				$('#termsForm').submit();
			}
		}
	});
</script>

@endsection
