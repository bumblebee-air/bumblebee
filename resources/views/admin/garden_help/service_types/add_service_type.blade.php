@extends('templates.dashboard') @section('title', 'GardenHelp | Add
Service Type') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

<style>
.main-panel>.content {
	margin-top: 0px;
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

.form-control, .form-control:invalid, .is-focused .form-control {
	box-shadow: none !important;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid" id="app">
			<form
				action="{{route('garden_help_postAddServiceType', 'garden-help')}}"
				method="POST" enctype="multipart/form-data" autocomplete="off">
				{{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/gardenhelp_icons/Service-types-white.png')}}">
								</div>
								<h4 class="card-title ">Add New Service Type</h4>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label class="">Service type</label> <input type="text"
													class="form-control" name="service_type"
													value="{{old('service_type')}}" required>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label>Min hours</label> <input type="number"
													class="form-control" name="min_hours" step="any"
													value="{{old('min_hours')}}" required>
											</div>
										</div>


									</div>
								</div>
							</div>
						</div>

						<div class="card" v-for="(rate, index) in ratePropertySizes"
							:id="'ratePropertyCardDiv'+(index)">

							<div class="card-body cardBodyAddServiceType">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<h5 class="addServiceTypeSubTitle">Rate And Property Size</h5>
											<span v-if="index==0"> <i
												class="fas fa-plus-circle addRatePropertySizeCircle"
												style="cursor: pointer; margin-left: 5px;"
												@click="addRatePropertySize()"></i>
											</span> <span v-if="index>0"> <i
												class="fas fa-minus-circle removeRatePropertySizeCircle"
												style="cursor: pointer; margin-left: 5px;"
												@click="removeRatePropertySize(index)"></i>
											</span>
										</div>
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label class="">Rate per hour</label> <input type="number"
													class="form-control" :name="'rate_per_hour' + (index)"
													:id="'rate_per_hour' + (index)"
													value="{{old('rate_per_hour')}}" required>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label>Max property size (MSQ)</label>
												<div class="row">
													<div class=" col-6 w-100">
														<input type="number" class="form-control"
															:name="'max_property_size_from' + (index)"
															:id="'max_property_size_from' + (index)"
															value="{{old('max_property_size_from')}}" required
															placeholder="From">
													</div>
													<div class=" col-6 w-100">
														<input type="number" class="form-control "
															:name="'max_property_size_to' + (index)"
															:id="'max_property_size_to' + (index)"
															value="{{old('max_property_size_to')}}" required
															placeholder="To">
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
									class="btn btn-register btn-gardenhelp-green" id="">Add service
									type</button>

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
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
    });
        
        var app = new Vue({
            el: '#app',
             data() {
                return {
                    ratePropertySizes: [
                        {}
                    ],
                }
            },
            mounted() {
            },
            methods: {
               
               addRatePropertySize() {
                    this.ratePropertySizes.push({})
                },
                removeRatePropertySize(index){
                	$("#ratePropertyCardDiv"+index).remove();
                }
            }
        });

      
    </script>

@endsection
