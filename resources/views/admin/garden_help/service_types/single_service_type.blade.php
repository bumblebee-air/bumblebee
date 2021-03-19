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
			@if($readOnly==0)
			<form id="order-form" method="POST"
				action="{{route('garden_help_postEditServiceType','garden-help')}}">
				@endif {{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-sm-4">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/gardenhelp_icons/Service-types-white.png')}}">
									</div>
									<h4 class="card-title ">Edit Service Type</h4>
									{{$readOnly}} <input type="hidden" name="serviceTypeId"
										value="{{$service_type_id}}">
								</div>


								@if($readOnly==1)
								<div class="col-6 col-sm-8 mt-5">
									<div class="row justify-content-end">
										<a class="editLinkA btn  btn-link   edit"
											href="{{url('garden-help/service_types/edit_service_type/')}}/{{$service_type_id}}">
											<p>Edit service type</p>
										</a>
									</div>
								</div>
								@endif
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label class="">Service type</label> <input type="text"
													class="form-control" name="service_type"
													value="{{$service_type}}" required>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label>Min hours</label> <input type="number"
													class="form-control" name="min_hours"
													value="{{$min_hours}}" required>
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
											
						@if($readOnly==0)<span v-if="index==0"> <i
												class="fas fa-plus-circle addRatePropertySizeCircle"
												style="cursor: pointer; margin-left: 5px;"
												@click="addRatePropertySize()"></i>
											</span> <span v-if="index>0"> <i
												class="fas fa-minus-circle removeRatePropertySizeCircle"
												style="cursor: pointer; margin-left: 5px;"
												@click="removeRatePropertySize(index)"></i>
											</span>@endif
										</div>
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label class="">Rate per hour</label> <input type="number"
													class="form-control" :name="'rate_per_hour' + (index)"
													:id="'rate_per_hour' + (index)" :value="rate.rate_per_hour"
													required>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group bmd-form-group">
												<label>Max property size (MSQ)</label> <input type="text"
													class="form-control" :name="'max_property_size' + (index)"
													:id="'max_property_size' + (index)"
													:value="rate.max_property_size" required>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>


						@if($readOnly==0)
						<div class="row">
							<div class="col-12 text-center">

								<button id="addNewServiceTypeBtn"
									class="btn btn-register btn-gardenhelp-green" id="">Edit</button>

							</div>
						</div>
						@endif

					</div>
				</div>

				@if($readOnly==0)
			</form>
			@endif
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
  
var readonly = {!! $readOnly !!};
if(readonly==1){
$("input").prop('disabled', true);
$("textarea").prop('disabled', true);
}
});
        
        var app = new Vue({
            el: '#app',
             data() {
                return {
                  
                    
                    ratePropertySizes: {!! json_encode($ratePropertySizes) !!},
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
