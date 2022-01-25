@extends('templates.garden_help-dashboard') @section('title',
'GardenHelp | Contractors ') @section('page-styles')
<style>

/* #yearsOfExperience { */
/* 	font-family: Roboto; */
/* 	font-size: 12px; */
/* 	font-weight: normal; */
/* 	font-stretch: normal; */
/* 	font-style: normal; */
/* 	line-height: normal; */
/* 	letter-spacing: 0.66px; */
/* 	color: #4d4d4d; */
/* } */

/* #selectFilter { */
/* 	display: inline-block; */
/* 	width: 200px; */
/* } */
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-xl-5 col-lg-4 col-md-4 col-sm-12">

								<h4 class="card-title  my-md-4 mt-4 mb-1 ">Contractors List</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-8 col-sm-12">
								<div
									class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv mb-3 mt-3">

									<div class="col-xl-6 col-md-8 col-sm-8 px-md-1">
										<div id="yearsOfExperience"
											class="form-group bmd-form-group"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table id="contractorsTable"
										class="table table-no-bordered table-hover gardenHelpTable jobsListTable"
										cellspacing="0" width="100%" style="width: 100%">

										<thead>
											<tr class="">
												<th>Date/Time</th>
												<th>Years Of Experience</th>
												<th>Contractor Name</th>
												<th>Request No</th>
												<th>Address</th>
												<th class="disabled-sorting ">Actions</th>
											</tr>
										</thead>

										<tbody>
											<tr class="order-row" v-for="contractor in contractors" v-if="contractors.length"
												@click="clickViewContractor(event,contractor.id)">
												<td v-html="contractor.created_at">@{{contractor.created_at}}</td>
												<td>@{{contractor.experience_level}}</td>
												<td>@{{contractor.name}}</td>
												<td>@{{contractor.id}}</td>

												<td>@{{contractor.location}}</td>
												<td class="actionsTd"><a
													class="edit"
													@click="editContractor(contractor.id)"><img
															src="{{asset('images/gardenhelp/edit-icon.png')}}"></a>
													<button type="button"
														class="remove"
														@click="clickDeleteContractor(contractor.id)">
														<img
															src="{{asset('images/gardenhelp/delete-icon.png')}}">
													</button></td>
											</tr>
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
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you want
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
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center"><button type="button" 
				class="btn  btn-submit btn-gardenhelp-green"
					onclick="$('form#delete-contractor').submit()">Yes</button>
				</div>
				<div class="col-lg-4 col-md-6 text-center"><button type="button"
					class="btn btn-submit  btn-gardenhelp-danger"
					data-dismiss="modal">Cancel</button></div>
			</div>


		</div>
	</div>
</div>
<!-- end delete contractor modal -->
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
    var table= $('#contractorsTable').DataTable({
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
        
        initComplete: function () {
         var column = this.api().column(1);
                  var select = $('<select id="" data-style="select-with-transition" class="form-control selectpicker selectFilter"><option value="">Filter by years of experience</option></select>')
                    .appendTo( $('#yearsOfExperience').empty().text('') )
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
                        
    
} );

var app = new Vue({
            el: '#app',
            data: {
                contractors: {},
            },
            mounted() {
            	console.log({!! json_encode($contractors) !!})
                var contractors = {!! json_encode($contractors) !!};

                for(let item of contractors.data) {
                    item.created_at = '<span class="jobDateTimeTd">'+ moment(item.created_at).format('D MMM YYYY')+ '</span><br>'
                    						+moment(item.created_at).format('HH:mm')
                 }

                this.contractors = contractors.data;
            },
            methods: {
                clickViewContractor(e,contractorId){
                    e.preventDefault();
                    
                    if (e.target.cellIndex == undefined) {  }
                    else{
                       window.location.href = "{{url('garden-help/contractors/view/')}}/"+contractorId;
                    }                
                },
                editContractor(contractorId){
                	window.location.href = "{{url('garden-help/contractors/edit/')}}/"+contractorId;
                },
                clickDeleteContractor(contractorId){

                    $('#delete-contractor-modal').modal('show')
                    $('#delete-contractor-modal #contractorId').val(contractorId);
                    
                 }
                
            }
        });

    </script>
@endsection

