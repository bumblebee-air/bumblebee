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

.contractorLinkA {
	font-style: normal;
	font-weight: normal;
	font-size: 14px;
	line-height: 21px;
	color: #406DAB;
	text-decoration: underline;
}

.file-url-container {
	padding: 8px 6px;
	border-radius: 9px;
	border: solid 1px #e3e3e3;
	background-color: #ffffff;
	/*width: fit-content;*/
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
	width: 300px;
	max-width: 100%;
}

.file-url-container i {
	font-size: 40px;
	color: #e2e5e7;
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
							<div class="col-12 col-sm-7">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/gardenhelp_icons/Contractors-white.png')}}">
								</div>
								<h4 class="card-title ">Contractor Details</h4>
							</div>

						</div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-12">
										<div class=" row">
											<div class="col-md-12">
												<h5 class="registerSubTitle mb-1">Comapany/Individual
													Details</h5>
											</div>
										</div>
									</div>


									<div class="col-12 ">
										<h5
											class="registerSubTitle font-weight-bold d-inline-block mb-0">{{$contractor->name}}</h5>
										<label class="requestLabel ml-3">{{$contractor->phone_number}}
										</label>
									</div>

									<div class="col-12">
										<p class="carouselContractorKmP mt-2"
											id="km-away-{{$contractor->id}}">{{$contractor->km_away}} Km
											away</p>
									</div>

									<div class="col-md-12 mt-2">
										<a class="contractorLinkA" target="_blank"
											href="{{$contractor->social_profile}}">{{$contractor->social_profile}}</a>

										<a class="contractorLinkA ml-2" target="_blank"
											href="{{$contractor->website_address}}">{{$contractor->website_address}}</a>
									</div>

									<div class="col-12 mt-2">

										<span class="input-group-text d-inline"> <img
											src="{{asset('images/gardenhelp_icons/location-icon.png')}}"
											alt="GardenHelp">
										</span> <label class="requestLabel d-inline"><span
											class="customerRequestSpan ">{{$contractor->address}}</span></label>

									</div>
									<div class="col-12 mt-3">
										<span class="input-group-text d-inline"> <img
											src="{{asset('images/gardenhelp_icons/property-size-icon.png')}}"
											alt="GardenHelp">
										</span> <label class="requestLabel d-inline">Experience Level:
											<span class="customerRequestSpan ">{{$contractor->experience_level}}</span>
										</label>
									</div>
									<div class="col-12 mt-3">
										<span class="input-group-text d-inline"> <img
											src="{{asset('images/gardenhelp_icons/property-size-icon.png')}}"
											alt="GardenHelp">
										</span> <label class="requestLabel d-inline">Type for work
											Experiece: <span class="customerRequestSpan ">{{$contractor->type_of_work_exp}}</span>
										</label>
									</div>
									<div class="col-12 mt-3">
										<span class="input-group-text d-inline"> <img
											src="{{asset('images/gardenhelp_icons/truck-icon.png')}}"
											alt="GardenHelp">
										</span> <label class="requestLabel d-inline">Type of
											Transport: <span class="customerRequestSpan ">{{$contractor->type_of_transport}}</span>
										</label>
									</div>


									<div class=" col-12 mt-3">
											<label class="requestLabel mb-0">CV:</label>
											
											<a target="_blank" href="{{asset($contractor->cv)}}"
												style="color: #333">
												<div class="file-url-container d-flex ">
													<i class="fas fa-file"></i>
													<p class="mt-xl-3 pl-xl-3 my-md-2 pl-2 my-3">Click here To CV file</p>
												</div>
											</a>
									</div>

									@if($contractor->company_number != '')
									<div class="col-12">
										<div class=" row">
											<div class="col-md-12">
												<h5 class="registerSubTitle mb-1">Other Details</h5>
											</div>
										</div>
									</div>
									<div class="col-12">
										<label class="requestLabel d-inline">Company number (If
											registered): <span class="customerRequestSpan ">{{$contractor->company_number}}</span>
										</label>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script>
		
    </script>
@endsection
