@extends('templates.dashboard') @section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

.unifiedTable>tbody>tr>td, .unifiedTable>tbody>tr>th, .unifiedTable>tfoot>tr>td,
	.unifiedTable>tfoot>tr>th, .unifiedTable>thead>tr>td, .unifiedTable>thead>tr>th
	{
	padding: 5px !important;
}

.selectFilter {
	display: inline-block;
	width: 200px;
}

.hidden-val {
	display: none
}

.jobTypeBorderColorDiv {
	width: 20px;
	height: 20px;
	border-radius: 50%;
	margin: auto;
}

.jobTypeBackgroundColorDiv {
	width: 90%;
	height: 20px;
	margin: auto;
}
.addUserModalHeader{
    font-style: normal;
    font-weight: 500;
    font-size: 20px;
    line-height: 1.19;
    letter-spacing: 0.8px;
    color: #4D4D4D;
}
@media (min-width: 576px){
#add-jobType-modal .modal-dialog, #edit-jobType-modal .modal-dialog ,.modal-dialog {
    max-width: 700px !important;
    margin: 100px auto !important;
}
}
@media (max-width: 575.5px){
#add-jobType-modal .modal-dialog, #edit-jobType-modal .modal-dialog  {
   width:90%;
   margin: auto;
    
}
}
</style>
@endsection @section('title', 'Unified | Job Types')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-md-8">
								<div class="card-icon p-3">
									<img class="page_icon"
										src="{{asset('images/unified/Add Service Form.png')}}"
										style="">
								</div>
								<h4 class="card-title ">Job Type</h4>
							</div>
							<div class="col-12 col-md-4 mt-4">
								<div class="row justify-content-end">
									<!-- <a class="btn btn-unified-grey btn-import"
										href="{{route('unified_getAddJobType', 'unified')}}">Add</a> -->

									<button class="btn btn-unified-grey btn-import" type="button"
										data-toggle="modal" data-target="#add-jobType-modal">Add</button>

								</div>
							</div>

						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="jobTypesTable"
									class="table table-no-bordered table-hover unifiedTable"
									cellspacing="0" width="100%" style="width: 100%">

									<thead>

										<tr class="theadColumnsNameTr">
											<th>Name</th>
											<th class="disabled-sorting ">Actions</th>
										</tr>
									</thead>

									<tbody>
										@if(count($job_types) > 0) @foreach($job_types as $job_type)
										<tr class="order-row" >
<!-- 											onclick="clickViewJobType(event,{{$job_type->id}})"> -->
											<td>{{$job_type->name}}</td>
											<td><a
												class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
												onclick="editJobType({{$job_type->id}},'{{$job_type->name}}')"> <img
													class="edit_icon" alt=""
													src="{{asset('images/unified/Edit.png')}}">
											</a>
												<button type="button"
													class="btn btn-link btn-danger btn-just-icon remove"
													onClick="clickDeleteJobType({{$job_type->id}})">
													<img class="delete_icon" alt=""
														src="{{asset('images/unified/Delete.png')}}">
												</button></td>

										</tr>
										@endforeach @endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- add jobType modal -->
<div class="modal fade" id="add-jobType-modal" tabindex="-1"
	role="dialog" aria-labelledby="add-jobType-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addUserModalHeader">Add Job Type</div>

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form id="jobTypeForm" method="POST"
				action="{{route('unified_postAddJobType', ['unified'])}}">
				{{csrf_field()}}
				<div class="modal-body">
					<div class="row mb-3">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Name</label> <input type="text" class="form-control"
									name="name" placeholder="Name" required>
							</div>
						</div>

					</div>

				</div>
			
			<div class="modal-footer d-flex justify-content-around">
				<button type="submit" class="btn  btn-unified-primary modal-btn"
					>Add </button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- end add jobType modal -->

<!-- eidt jobType modal -->
<div class="modal fade" id="edit-jobType-modal" tabindex="-1"
	role="dialog" aria-labelledby="edit-jobType-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addUserModalHeader">Edit Job Type</div>

				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form id="jobTypeForm" method="POST"
				action="{{route('unified_postJobTypeSingleEdit', ['unified'])}}">
						
				{{csrf_field()}}
						<input type="hidden" name="job_type_id" id="jobTypeId"
							value="">
				<div class="modal-body">
					<div class="row mb-3">
						<div class="col">
							<div class="form-group bmd-form-group">
								<label>Name</label> <input type="text" class="form-control" id="jobTypeName"
									name="name" placeholder="Name" required>
							</div>
						</div>

					</div>

				</div>
			
			<div class="modal-footer d-flex justify-content-around">
				<button type="submit" class="btn  btn-unified-primary modal-btn"
					>Edit </button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit jobType modal -->

<!-- delete jobType modal -->
<div class="modal fade" id="delete-jobType-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-jobType-label" aria-hidden="true">
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
					to delete this job type?</div>

				<div>

					<form method="POST" id="delete-jobType"
						action="{{url('unified/job_types/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="jobTypeId" name="jobTypeId"
							value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-unified-primary modal-btn"
					onclick="$('form#delete-jobType').submit()">Yes</button>
				<button type="button" class="btn  btn-unified-danger modal-btn"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete jobType modal -->


@endsection @section('page-scripts')
<script
	src="//cdn.datatables.net/plug-ins/1.10.24/sorting/alt-string.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table= $('#jobTypesTable').DataTable({
   
    "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50,100, -1],
          [10, 25, 50,100, "All"]
        ],
        responsive: true,
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
    	},
    	"columnDefs": [ {
    		"targets": -1,
    		"orderable": false
    	},  ],
    	
    });
} );


function clickViewJobType(e,jobTypeId){
 		e.preventDefault();
                	console.log(e.target.cellIndex)
        if (e.target.cellIndex == undefined) {  }
        else{
        	window.location.href = "{{url('unified/job_types/edit/')}}/"+jobTypeId;
        }
}
function editJobType(jobTypeId,jobTypeName){
	//window.location.href = "{{url('unified/job_types/edit/')}}/"+jobTypeId;
	
    $('#edit-jobType-modal').modal('show')
    $('#edit-jobType-modal #jobTypeId').val(jobTypeId);
    $('#edit-jobType-modal #jobTypeName').val(jobTypeName);
}
function clickDeleteJobType(jobTypeId){
    $('#delete-jobType-modal').modal('show')
    $('#delete-jobType-modal #jobTypeId').val(jobTypeId);

}
</script>
@endsection
