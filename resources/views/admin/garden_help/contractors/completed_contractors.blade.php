@extends('templates.dashboard') @section('title', 'GardenHelp |
Contractors ') @section('page-styles')
<style>

tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

#yearsOfExperience {
	font-family: Roboto;
	font-size: 12px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.66px;
	color: #4d4d4d;
}

#selectFilter {
	display: inline-block;
	width: 200px;
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
							<div class="col-12 col-sm-6">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/gardenhelp_icons/Contractors-white.png')}}">
								</div>
								<h4 class="card-title ">Contractors List</h4>
							</div>

						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<p id="yearsOfExperience"></p>
									<table id="contractorsTable"
										class="table table-no-bordered table-hover gardenHelpTable"
										cellspacing="0" width="100%" style="width: 100%">

										<thead>
<!-- 											<tr> -->
<!-- 												<th class="filterhead">Date/Time</th> -->
<!-- 												<th class="filterhead">Years Of Experience</th> -->
<!-- 												<th class="filterhead">Contractor Name</th> -->
<!-- 												<th class="filterhead">Request No</th> -->
<!-- 												<th class="filterhead">Address</th> -->
<!-- 												<th class="filterhead">Actions</th> -->
<!-- 											</tr> -->
											<tr class="theadColumnsNameTr">
												<th style="width: 16%">Date/Time</th>
												<th>Years Of Experience</th>
												<th>Contractor Name</th>
												<th>Request No</th>
												<th>Address</th>
												<th class="disabled-sorting ">Actions</th>
											</tr>
										</thead>

										<tbody>
											@if(count($contractors) > 0) @foreach($contractors as
											$contractor)
											<tr class="order-row"
												onclick="clickViewContractor(event,{{$contractor->id}})">
												<td>{{$contractor->created_at}}</td>
												<td>{{$contractor->experience_level}}</td>
												<td>{{$contractor->name}}</td>
												<td>{{$contractor->id}}</td>

												<td>{{$contractor->address}}</td>
												<td><a
													class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
													onclick="editContractor({{$contractor['id']}})"><i
														class="fas fa-pen-fancy"></i></a>
													<button type="button"
														class="btn btn-link btn-danger btn-just-icon remove"
														onClick="clickDeleteContractor({{$contractor['id']}})">
														<i class="fas fa-trash-alt"></i>
													</button></td>
											</tr>
											@endforeach @endif
										</tbody>
									</table>
									<nav aria-label="pagination" class="float-right">
										{{$contractors->links('vendor.pagination.bootstrap-4')}}</nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- delete contractor modal -->
<div class="modal fade" id="delete-contractor-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-contractor-label"
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

					<form method="POST" id="delete-contractor"
						action="{{url('garden-help/contractors/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="contractorId" name="contractorId"
							value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-register btn-gardenhelp-green"
					onclick="$('form#delete-contractor').submit()">Yes</button>
				<button type="button"
					class="btn btn-register  btn-gardenhelp-danger"
					data-dismiss="modal">Cancel</button>
			</div>


		</div>
	</div>
</div>
<!-- end delete contractor modal -->
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
    var table= $('#contractorsTable').DataTable({
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
    	} ],
    	
        initComplete: function () {
         var column = this.api().column(1);
                  var select = $('<select id="selectFilter" class="form-control"><option value="">Select years of experience</option></select>')
                    .appendTo( $('#yearsOfExperience').empty().text('Filter ') )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                  column
                    .search( val ? '^'+val+'$' : '', true, false )
                    .draw();
                      
                  } );
                  column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' );
                  } );    
        }
    });
    
    
     $(".filterhead").each(function (i) {
                 if (i == 1  ) {
                     var select = $('<select ><option value="">Select '+$(this).text()+'</option></select>')
                         .appendTo($(this).empty())
                         .on('change', function () {
                             var term = $(this).val();
                             table.column(i).search(term, false, false).draw();
                         });
                     table.column(i).data().unique().sort().each(function (d, j) {
                         select.append('<option value="' + d + '">' + d + '</option>')
                     });
                 } else {
                    $(this).empty();
                 }
             });
                      
    
} );

function clickViewContractor(e,contractorId){
 		e.preventDefault();
                	
        if (e.target.cellIndex == undefined) {  }
        else{
        	window.location.href = "{{url('garden-help/contractors/view/')}}/"+contractorId;
        }
}
function editContractor(contractorId){
	window.location.href = "{{url('garden-help/contractors/edit/')}}/"+contractorId;
}

function clickDeleteContractor(contractorId){

$('#delete-contractor-modal').modal('show')
$('#delete-contractor-modal #contractorId').val(contractorId);

}
    </script>
@endsection

