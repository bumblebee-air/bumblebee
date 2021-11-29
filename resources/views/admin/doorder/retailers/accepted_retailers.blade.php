@extends('templates.doorder_dashboard') @section('page-styles')

<style>

</style>
 @endsection

@section('title', 'DoOrder | Retailers') @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">

								<h4 class="card-title my-4 mb-sm-1">Retailers</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
								
									<div class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv mb-2 mt-1">
										
										<div class="col-lg-4 col-md-4 col-sm-4 px-md-1">
											<div id="businessTypeP" class="form-group bmd-form-group"></div>
										</div>
										<div class="col-lg-3 col-md-3  col-sm-4 px-md-1">
											<a href="{{ url()->current()."?export_type=exel" }}" class="btn-doorder-filter w-100">Export</a>
										</div>

									</div>
							</div>
						</div>
					</div>
				
					<div class="card">
						
						<div class="card-body">
							<div style="float: right;">
								
							</div>

							<div class="table-responsive">
								<table id="retailersTable"
									class="table table-no-bordered table-hover doorderTable "
									cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr class="theadColumnsNameTr">
											<th>Business Type</th>
											<th>Retailer Name</th>
											<th class="text-center">Locations Number</th>
											<th class="text-center">Sub-Accounts</th>
											<th class="disabled-sorting text-center">Actions</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="retailer in retailers"
											v-if="retailers.length > 0" class="order-row"
											@click="openViewRetailer(event,retailer.id)">
											<td class="text-left">@{{ retailer.business_type}}</td>
											<td class="text-left">@{{ retailer.name}}</td>
											<td>@{{ retailer.nom_business_locations }}</td>
											<td>@{{ retailer.nom_business_locations }}</td>
											<td class="actionsTd"><a
												class="edit"
												@click="openRetailer(retailer.id)"><img
															src="{{asset('images/doorder-new-layout/edit-icon.png')}}"></a>
												<button type="button"
													class="remove"
													@click="clickDeleteRetailer(retailer.id)">
														<img
															src="{{asset('images/doorder-new-layout/delete-icon.png')}}">
												</button></td>
												
										</tr>

										<tr v-else>
											<td colspan="4" class="text-center"><strong>No data found.</strong>
											</td>
										</tr>
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


<!-- delete retailer modal -->
<div class="modal fade" id="delete-retailer-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-retailer-label"
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

					<form method="POST" id="delete-retailer"
						action="{{url('doorder/retailer/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="retailerId" name="retailerId"
							value="" />
					</form>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#delete-retailer').submit()">Yes</button>
				</div>

				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-danger-outline mb-1"
						data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end delete retailer modal -->

@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
    var table= $('#retailersTable').DataTable({
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
        "initComplete": function() {
        	
         	var column = this.api().column(0);
			var select = $('<select id="selectFilter" data-style="select-with-transition" class="form-control selectpicker" name="business_type">'
							+'<option value="">Select business type </option></select>')
			.appendTo( $('#businessTypeP').empty().text('') )
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


function clickDeleteRetailer(retailerId){

$('#delete-retailer-modal').modal('show')
$('#delete-retailer-modal #retailerId').val(retailerId);

}
</script>
<script>
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                retailers: {!! json_encode($retailers) !!}
            },
            mounted() {

            },
            methods: {
                
                parseDateTime(date) {
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date();
                    let date_moment = new moment();
                    if(date!=null && date!=''){
                        //parseDate = new Date(date);
                        date_moment = new moment(date);
                    }
                    /*dateTime += parseDate.getDate() + '/';
                    dateTime += parseDate.getMonth() + '/';
                    dateTime += parseDate.getFullYear() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();*/
                    dateTime = date_moment.format('DD-MM-YYYY HH:mm');
                    return dateTime;
                },
                openRetailer(retailer_id) {
                    window.location = "{{url('doorder/retailers/')}}/"+retailer_id
                },
                openViewRetailer(e,retailer_id){
                  e.preventDefault();
                	
                	    if (e.target.cellIndex == undefined) {
                	    	
                	    }
                		else{
                   			window.location.href = "{{url('doorder/retailers/view/')}}/"+retailer_id;
                   		}
                },
            }
        });
    </script>
@endsection
