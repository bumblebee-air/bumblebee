@extends('templates.garden_help-dashboard') @section('title',
'GardenHelp | Service Types') @section('page-styles')
<style>
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
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12">

								<h4 class="card-title my-md-4 mt-4 mb-1 ">Service Types</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-7 col-md-7 col-sm-12">
								<div class="row justify-content-end mt-2 mb-1 mt-md-3 mt-1 mt-xs-0">
									<div class="col-xl-4 col-lg-6 col-md-8  col-sm-8 px-md-1">
										<a
											href="{{route('garden_help_addServiceType', 'garden-help')}}"
											class="btn-gardenhelp-filter w-100">Add New Service</a>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table id="serviceTypesTable"
										class="table table-no-bordered table-hover gardenHelpTable jobsListTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th style="width: 20%">Service Type</th>
												<th style="width: 20%">Min Hours</th>
												<th style="width: 20%">Rate Per Hour</th>
												<th style="width: 20%">Max property size (MSQ)</th>
												<th style="width: 20%">Action</th>
											</tr>
										</thead>
										<tbody>
											<tr class="order-row" v-for="type in service_types.data"
												v-if="service_types.data.length"
												@click="openServiceType(event,type.id)">
												<td>@{{type.name}}</td>
												<td>@{{type.min_hours}}</td>
												<td v-html="type.rate_hours">@{{type.rate_hours}}</td>
												<td v-html="type.property_sizes">@{{type.property_sizes}}</td>
												<td class="actionsTd"><a class="edit"
													@click="editServiceType(type.id)"><img
														src="{{asset('images/gardenhelp/edit-icon.png')}}"></a> <a
													class="remove"
													@click="clickDeleteServiceType(type.id)"> <img
														src="{{asset('images/gardenhelp/delete-icon.png')}}">
												</a></td>
											</tr>
											<tr v-else>
												<td colspan="5" class="text-center"><strong>No data found.</strong>
												</td>
											</tr>

										</tbody>
									</table>
									<nav aria-label="pagination" class="float-right">

										{{$service_types->links('vendor.pagination.bootstrap-4')}}</nav>
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
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
					want to delete this service type?</div>

				<div>
					<form method="POST" id="delete-service-type"
						action="{{url('garden_help/service_types/delete_service_type')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="typeId" name="typeId" value="" />
					</form>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btn  btn-submit btn-gardenhelp-green"
						onclick="$('form#delete-service-type').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btn btn-submit  btn-gardenhelp-danger"
						data-dismiss="modal">Cancel</button>
				</div>
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
	
<script type="text/javascript">
$(document).ready(function() {
    var table= $('#serviceTypesTable').DataTable({
    	fixedColumns: true,
          "lengthChange": false,
          "searching": true,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
  		   "responsive":true,
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
    	},
    	"columnDefs": [ {
    		"targets": -1,
    		"orderable": false
    	} ],
    	      
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
        
    });
                        
    
} );
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
            	service_types : {!! json_encode($service_types) !!}
            },
            mounted() {
            	console.log(this.service_types.data)
            },
            methods: {
                openServiceType(e,type_id) {
                	 e.preventDefault();
                    
                    if (e.target.cellIndex == undefined) {  }
                    else{
						window.location.href = "{{url('garden-help/service_types/type')}}/"+type_id;
					}	
                },
                editServiceType(type_id) {
                	//alert("edit "+type_id);
                	window.location.href = "{{url('garden-help/service_types/edit_service_type')}}/"+type_id;
                }, 
                clickDeleteServiceType(type_id){
                    $('#delete-service-type-modal').modal('show')
					$('#delete-service-type-modal #typeId').val(type_id);
                },
            }
        });
    </script>
@endsection



