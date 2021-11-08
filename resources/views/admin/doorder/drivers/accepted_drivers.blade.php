@extends('templates.doorder_dashboard') @section('page-styles')

<style>
.overallRating img {
	width: 18px;
	height: 18px;
}

table tbody td {
	text-align: left;
}
</style>
@endsection @section('title', 'DoOrder | Deliverers')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">

								<h4 class="card-title my-4 mb-sm-1">Deliverers</h4>
							</div>
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
								<div
									class="row justify-content-end mt-2 mt-xs-0 filterContrainerDiv mb-2 mt-1">
									

									<div class="col-lg-3 col-md-3  col-sm-3 px-md-1">
										<a href="{{ url()->current().'?export_type=exel' }}"
											class="btn-doorder-filter w-100"> Export list </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card">

						<div class="card-body">
							<div style="float: right;"></div>
							<div class="row"><div class="col-lg-3 col-md-3 col-sm-3 px-md-1">
										<div id="locationP" class="form-group bmd-form-group"></div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 px-md-1">
										<div id="vehicleP" class="form-group bmd-form-group"></div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 px-md-1">
										<div id="workTypeP" class="form-group bmd-form-group"></div>
									</div></div>
							<div class="table-responsive">
								<table id="driversTable"
									class="table table-no-bordered table-hover doorderTable "
									cellspacing="0" width="100%" style="width: 100%">
									<thead>
										<tr class="theadColumnsNameTr">
											<th>Deliverer</th>
											<th>Location</th>
											<th>Vehicle</th>
											<th>Work Type</th>
											<th>Shift Time</th>
											<th>Overall Rating</th>
											<th class="disabled-sorting ">Actions</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="driver in drivers" v-if="drivers.length > 0"
											class="order-row" @click="openViewDriver(event,driver.id)">
											<td class="text-left">@{{ driver.first_name}} @{{
												driver.last_name }}</td>
											<td>@{{ JSON.parse(driver.work_location).name}}</td>
											<td>@{{ driver.transport }}</td>
											<td></td>
											<td></td>
											<td><div class="overallRating"
													:data-score="driver.overall_rating"></div></td>
											<td class="actionsTd"><button type="button"
													class="edit" @click="openDriver(driver.id)">
													<img
														src="{{asset('images/doorder-new-layout/edit-icon.png')}}">
												</button>
												<button type="button" class="remove"
													@click="clickDeleteDriver(driver.id)">

													<img
														src="{{asset('images/doorder-new-layout/delete-icon.png')}}">
												</button></td>

										</tr>
										<tr v-else>
											<td colspan="8" class="text-center"><strong>No data found.</strong>
											</td>
										</tr>
									</tbody>
								</table>
								<nav aria-label="pagination" class="float-right">{{--
									{{$clients->links('vendor.pagination.bootstrap-4')}}--}}</nav>
							</div>
						</div>
					</div>
					{{--
					<div class="d-flex justify-content-center">{$drivers->links()}</div>
					--}}
				</div>
			</div>
		</div>

	</div>
</div>

<!-- delete driver modal -->
<div class="modal fade" id="delete-driver-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-deliverer-label"
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

					<form method="POST" id="delete-driver"
						action="{{url('doorder/driver/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="driverId" name="driverId" value="" />
					</form>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 text-center">
					<button type="button"
						class="btnDoorder btn-doorder-primary mb-1"
						onclick="$('form#delete-driver').submit()">Yes</button>
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
<!-- end delete driver modal -->

@endsection @section('page-scripts')
<script src="{{asset('js/jquery-raty.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
    var table= $('#driversTable').DataTable({
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
    	}, {
                    render: function (data, type, full, meta) {
                    	return '<span data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
                    },
                    targets: 3
                } ],
    	
        initComplete: function(settings, json) {
    		$('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
    			
         	var column1 = this.api().column(1);
         	drawFilter(column1,'locationP','location');
         	var column2 = this.api().column(2);
         	drawFilter(column2,'vehicleP','vehicle');
         	var column3 = this.api().column(3);
         	drawFilter(column3,'workTypeP','work type');
         	
        },
          
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    });
           
        $('.overallRating').raty({
  					readOnly: true, 
                    starHalf:     '{{asset("images/doorder_icons/star-half.png")}}',
                	starOff:      '{{asset("images/doorder_icons/star.png")}}',
                	starOn:       '{{asset("images/doorder_icons/star-selected.png")}}',
                	hints: null
        });  
           
    
} );

function drawFilter(column,divId,name){
                
			var select = $('<select id="" data-style="select-with-transition" class="form-control selectpicker" >'
							+'<option value="">Filter '+name+' </option></select>')
			.appendTo( $('#'+divId).empty().text('') )
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

function clickDeleteDriver(driverId){
$('#delete-driver-modal').modal('show')
$('#delete-driver-modal #driverId').val(driverId);

}
</script>
<script>    
        
        var app = new Vue({
            el: '#app',
            data: {
                drivers: {!! json_encode($drivers) !!}
            },
            mounted() {
                // socket.on('doorder-channel:new-order', (data) => {
                //     let decodedData = JSON.parse(data)
                //     this.orders.data.unshift(decodedData.data);
                // });
                //
                // socket.on('doorder-channel:update-order-status', (data) => {
                //     let decodedData = JSON.parse(data);
                //     console.log(decodedData);
                //     // this.orders.data.filter(x => x.id === decodedData.data.id).map(x => x.foo);
                //     let orderIndex = this.orders.data.map(function(x) {return x.id; }).indexOf(decodedData.data.id)
                //     if (orderIndex != -1) {
                //         this.orders.data[orderIndex].status = decodedData.data.status;
                //         this.orders.data[orderIndex].driver = decodedData.data.driver;
                //         updateAudio.play();
                //     }
                // });
            },
            methods: {
                openDriver(driver_id){
                   window.location.href = "{{url('doorder/drivers/')}}/"+driver_id;
                },
                openViewDriver(e,driver_id){
                  e.preventDefault();
                	
                	    if (e.target.cellIndex == undefined) {
                	    	
                	    }
                		else{
                   			//window.location.href = "{{url('doorder/drivers/view/')}}/"+driver_id;
                   			window.location.href = "{{url('doorder/drivers/view_orders/')}}/"+driver_id;
                   		}
                },
                parseDateTime(date) {
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date(date);
                    let date_moment = new moment(date);
                    /*dateTime += parseDate.getDate() + '/';
                    dateTime += parseDate.getMonth()+1 + '/';
                    dateTime += parseDate.getFullYear() + ' ';
                    dateTime += parseDate.getHours() + ':';
                    dateTime += parseDate.getMinutes();*/
                    dateTime = date_moment.format('DD-MM-YYYY HH:mm');
                    return dateTime;
                }
            }
        });
    </script>
@endsection
