@extends('templates.dashboard') @section('title', 'GardenHelp |
Propertird ') @section('page-styles')
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
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-md-7">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/gardenhelp_icons/property-icon-white.png')}}">
								</div>
								<h4 class="card-title ">Properties List</h4>
							</div>
							<div class="col-12 col-md-5 mt-0 mt-md-3 justify-content-end">
								<a class="btn btn-gardenhelp-green addServiceButton float-right"
										href="{{url('garden-help/properties/add')}}">
										<p>Add property</p>
									</a>
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
											<tr class="theadColumnsNameTr">
												<th>Created At</th>
												<th>Property Number</th>
												<th>Location</th>
												<th>Address</th>
												<th>Property Type</th>
												<th>Property Size</th>
												<th class="disabled-sorting ">Actions</th>
											</tr>
										</thead>

										<tbody>
											@if(count($properties) > 0) @foreach($properties as
											$property)
											<tr class="order-row"
												@click="editProperty({{$property->id}})"
											>
												<td>{{$property->created_at}}</td>
												<td>{{$property->id}}</td>
												<td>{{$property->work_location}}</td>
												<td>
													<p style="" class="tablePinSpan tooltipC mb-0">
														<span> <i class="fas fa-map-marker-alt"
															style="color: #30BB30"></i>
														</span> <span class="tooltiptextC">
															{{$property->location}} </span>
													</p>
												</td>
												<td>{{$property->type_of_work}}</td>
												<td>{{$property->property_size}}</td>
												<td>
													<a class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
													@click="editProperty({{$property['id']}})"><i
														class="fas fa-pen-fancy"></i></a>
													<button type="button"
														class="btn btn-link btn-danger btn-just-icon remove"
														@click.prevent.stop="clickDeleteProperty({{$property['id']}})">
														<i class="fas fa-trash-alt"></i>
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
</div>


<!-- delete property modal -->
<div class="modal fade" id="delete-property-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-property-label"
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

					<form method="POST" id="delete-property"
						action="{{url('garden-help/properties/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="propertyId" name="property_id"
							value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-register btn-gardenhelp-green"
					onclick="$('form#delete-property').submit()">Yes</button>
				<button type="button"
					class="btn btn-register  btn-gardenhelp-danger"
					data-dismiss="modal">Cancel</button>
			</div>


		</div>
	</div>
</div>
<!-- end delete property modal -->

@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
    var table= $('#contractorsTable').DataTable({
    	 "ordering": false,
            "pagingType": "full_numbers",
                "lengthMenu": [
                  [-1,10, 25, 50,100],
                  ["All",10, 25, 50,100]
                ],
    
        responsive: true,
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
			
				"paginate": {
                              "previous": "<i class='fas fa-angle-left'></i>",
                              "next": "<i class='fas fa-angle-right'></i>",
                              "first":"<i class='fas fa-angle-double-left'></i>",
                              "last":"<i class='fas fa-angle-double-right'></i>"
                            }
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
//          var column = this.api().column(1);
//                   var select = $('<select id="selectFilter" class="form-control"><option value="">Select years of experience</option></select>')
//                     .appendTo( $('#yearsOfExperience').empty().text('Filter ') )
//                     .on( 'change', function () {
//                         var val = $.fn.dataTable.util.escapeRegex(
//                             $(this).val()
//                         );
//                   column
//                     .search( val ? '^'+val+'$' : '', true, false )
//                     .draw();
                      
//                   } );
//                   column.data().unique().sort().each( function ( d, j ) {
//                     select.append( '<option value="'+d+'">'+d+'</option>' );
//                   } );    
        }
    });
    
    
     $(".filterhead").each(function (i) {
//                  if (i == 1  ) {
//                      var select = $('<select ><option value="">Select '+$(this).text()+'</option></select>')
//                          .appendTo($(this).empty())
//                          .on('change', function () {
//                              var term = $(this).val();
//                              table.column(i).search(term, false, false).draw();
//                          });
//                      table.column(i).data().unique().sort().each(function (d, j) {
//                          select.append('<option value="' + d + '">' + d + '</option>')
//                      });
//                  } else {
//                     $(this).empty();
//                  }
             });
                      
    
} );

var app = new Vue({
	el: '#app',
	data: {
		//
	},
	methods: {
		clickDeleteProperty(id){
			console.log("delete prop ",id)
			$('#delete-property-modal').modal('show')
			$('#delete-property-modal #propertyId').val(id);

		},
		editProperty(propertyId){
			console.log("edit ",propertyId)
			window.location.href = "{{url('garden-help/properties/edit/')}}/"+propertyId;
		}
	}
});
</script>
@endsection

