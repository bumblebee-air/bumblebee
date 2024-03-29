@extends('templates.dashboard') @section('page-styles')
<style>

tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

#serviceTypeFilter, #contractFilter {
	font-family: Roboto;
	font-size: 12px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.66px;
	color: #4d4d4d;
	display: inline-block;
}

.selectFilter {
	display: inline-block;
	width: 200px;
}
.hidden-val{
display: none
}
</style>
@endsection @section('title', 'Unified | Engineer')
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
										src="{{asset('images/unified/Engineers.png')}}">
								</div>
								<h4 class="card-title ">Engineers</h4>
							</div>
							<div class="col-12 col-md-4 mt-4">
								<div class="row justify-content-end">
									<a class="btn btn-unified-grey btn-import"
										href="{{route('unified_getAddEngineer', 'unified')}}">Add</a>
									
								</div>
							</div>

						</div>
						<div class="card-body">
							<div class="table-responsive">

								<table id="engineersTable"
									class="table table-no-bordered table-hover unifiedTable"
									cellspacing="0" width="100%" style="width: 100%">

									<thead>

										<tr class="theadColumnsNameTr">
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Address</th>
											<th class="disabled-sorting ">Actions</th>
										</tr>
									</thead>

									<tbody>
										@if(count($engineers) > 0) @foreach($engineers as $engineer)
										<tr class="order-row"
											onclick="clickViewEngineer(event,{{$engineer->id}})">
											<td>{{$engineer->first_name}} {{$engineer->last_name}}</td>
											<td>{{$engineer->email}}</td>
											<td>{{$engineer->phone}}
											</td>
											<td>{{$engineer->address}}
											</td>
											<td><a
												class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
												onclick="editEngineer({{$engineer->id}})"> <img
													class="edit_icon" alt=""
													src="{{asset('images/unified/Edit.png')}}">
											</a>
												<button type="button"
													class="btn btn-link btn-danger btn-just-icon remove"
													onClick="clickDeleteEngineer({{$engineer->id}})">
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

<!-- delete customer modal -->
<div class="modal fade" id="delete-engineer-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-engineer-label"
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
					to delete this account?</div>

				<div>

					<form method="POST" id="delete-engineer"
						action="{{url('unified/engineers/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="engineerId" name="engineerId"
							value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-unified-primary modal-btn"
					onclick="$('form#delete-engineer').submit()">Yes</button>
				<button type="button" class="btn  btn-unified-danger modal-btn"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete customer modal -->


@endsection @section('page-scripts')
<script
	src="//cdn.datatables.net/plug-ins/1.10.24/sorting/alt-string.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table= $('#engineersTable').DataTable({
   
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
    	},{ type: "hiddenVal", targets: 2 }  ],
    	
        initComplete: function () {
        }
    });
   
} );

function clickViewEngineer(e,engineerId){
 		e.preventDefault();
                	console.log(e.target.cellIndex)
        if (e.target.cellIndex == undefined) {  }
        else{
        	window.location.href = "{{url('unified/engineers/view/')}}/"+engineerId;
        }
}
function editEngineer(engineerId){
	window.location.href = "{{url('unified/engineers/edit/')}}/"+engineerId;
}
function clickDeleteEngineer(engineerId){
$('#delete-engineer-modal').modal('show')
$('#delete-engineer-modal #engineerId').val(engineerId);

}

</script>
@endsection
