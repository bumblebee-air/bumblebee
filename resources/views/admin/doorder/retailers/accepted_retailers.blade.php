@extends('templates.dashboard') @section('page-styles')

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
							<div class="col-12">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/doorder_icons/Retailer.png')}}">
								</div>
								<h4 class="card-title ">Retailers</h4>
							</div>

						</div>
						<div class="card-body">
							<div style="float: right;">
								<a href="{{ url()->current()."?export_type=exel" }}" class="btn btn-primary filterButton">Export</a>
							</div>

							<div class="table-responsive">
								<table id="retailersTable"
									class="table table-no-bordered table-hover doorderTable "
									cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th class="filterhead">Business Type</th>
											<th class="filterhead">Retailer Name</th>
											<th class="filterhead">Locations No.</th>
											<th class="filterhead">Actions</th>
										</tr>
										<tr class="theadColumnsNameTr">
											<th>Business Type</th>
											<th>Retailer Name</th>
											<th>Locations No.</th>
											<th class="disabled-sorting ">Actions</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="retailer in retailers"
											v-if="retailers.length > 0" class="order-row"
											@click="openViewRetailer(event,retailer.id)">
											<td>@{{ retailer.business_type}}</td>
											<td>@{{ retailer.name}}</td>
											<td>@{{ retailer.nom_business_locations }}</td>
											<td><a
												class="btn  btn-link btn-primary-doorder btn-just-icon edit"
												@click="openRetailer(retailer.id)"><i
													class="fas fa-pen-fancy"></i></a>
												<button type="button"
													class="btn btn-link btn-danger btn-just-icon remove"
													@click="clickDeleteRetailer(retailer.id)">
													<i class="fas fa-trash-alt"></i>
												</button></td>
										</tr>

										<tr v-else>
											<td colspan="4" class="text-center"><strong>No data found.</strong>
											</td>
										</tr>
									</tbody>
								</table>
								<nav aria-label="pagination" class="float-right"></nav>
							</div>
						</div>
					</div>
					{{--<div class="d-flex justify-content-center">{$retailers->links()}</div>--}}
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
				<div class="modal-dialog-header deleteHeader">Are you sure you want
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
			<div class=" row">
				<div class="col-sm-6">
					<button type="button"
						class="btn btn-primary doorder-btn-lg doorder-btn"
						onclick="$('form#delete-retailer').submit()">Yes</button>
				</div>

				<div class="col-sm-6">
					<button type="button"
						class="btn btn-danger doorder-btn-lg doorder-btn"
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
        "initComplete": function() {
            
        }
    });
    
      $(".filterhead").each(function (i) {
                 if (i == 0  ) {
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
