@extends('templates.dashboard') @section('title', 'GardenHelp | Service
Types') @section('page-styles')
<style>
.main-panel>.content {
	margin-top: 0px;
}

tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
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
							<div class="col-12 col-lg-9">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/gardenhelp_icons/Service-types-white.png')}}">
								</div>
								<h4 class="card-title ">Service Types</h4>
							</div>
							<div class="col-12 col-lg-3 mt-4">
								<div class="row justify-content-end">
									<div>
										<a href="{{route('garden_help_addServiceType', 'garden-help')}}"
											class="btn   btn-gardenhelp-green addServiceButton">Add New Service</a>
									</div>

								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Service Type</th>
												<th>Min Hours</th>
												<th>Rate Per Hour</th>
												<th>Max property size (MSQ)</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if(count($service_types)>0) @foreach($service_types as
											$type)
											<tr class="order-row"
												@click="openServiceType(event,{{$type['id']}})">
												<td>{{$type['name']}}</td>
												<td>{{$type['min_hours']}}</td>
												<td>{{$type['rate_per_hour']}}</td>
												<td>{{$type['max_property_size']}}</td>
												<td><a
													class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
													@click="editServiceType({{$type['id']}})"><i
														class="fas fa-pen-fancy"></i></a>
													<button type="button"
														class="btn btn-link btn-danger btn-just-icon remove"
														@click="clickDeleteServiceType({{$type['id']}})">
														<i class="fas fa-trash-alt"></i>
													</button></td>
											</tr>
											@endforeach @else
											<tr>
												<td colspan="8" class="text-center"><strong>No data found.</strong>
												</td>
											</tr>
											@endif

										</tbody>
									</table>
									<nav aria-label="pagination" class="float-right">
									
                                         {{$service_types->links('vendor.pagination.bootstrap-4')}} 
									</nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- delete service type modal -->
<div class="modal fade" id="delete-service-type-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-service-type-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal-dialog-header deleteHeader">Are you sure you want
					to delete this service type?</div>

				<div>

					<form method="POST" id="delete-service-type"
						action="{{url('garden_help/service_types/delete_service_type')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="typeId" name="typeId" value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-register btn-gardenhelp-green"
					onclick="$('form#delete-service-type').submit()">Yes</button>
				<button type="button"
					class="btn btn-register  btn-gardenhelp-danger"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete service type modal -->

@endsection @section('page-scripts')
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
	integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
	crossorigin="anonymous"></script>
<script>
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
            },
            mounted() {
               
            },
            methods: {
                openServiceType(e,type_id){
                	
                     if (e.target.cellIndex == undefined) {
                	    	
                	    }
                		else{
                			window.location.href = "{{url('garden-help/service_types/type')}}/"+type_id;
                   		}
                },
                editServiceType(type_id){
                	//alert("edit "+type_id);
                	window.location.href = "{{url('garden-help/service_types/edit_service_type')}}/"+type_id;
                }, 
                clickDeleteServiceType(type_id){
                    $('#delete-service-type-modal').modal('show')
					$('#delete-service-type-modal #typeId').val(type_id);
                }
            }
        });
    </script>
@endsection



