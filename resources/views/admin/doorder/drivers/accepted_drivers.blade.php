@extends('templates.doorder_dashboard') @section('page-styles')

<link
	href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css"
	rel="stylesheet">

<style>
.overallRating img {
	width: 18px;
	height: 18px;
}

table tbody td {
	text-align: left;
}

input[type="checkbox"] {
	display: none;
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
					<form method="POST" id="assignOrdersDrivers"
						action="{{url('doorder/assign_orders_drivers')}}"
						style="margin-bottom: 0 !important;">
						{{csrf_field()}}
						<input type="hidden" name="selectedOrders" id="selectedOrders" :value="selectedOrders">
						<div class="card">

							<div class="card-body">
								<div style="float: right;"></div>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-3 px-md-1">
										<div id="locationP" class="form-group bmd-form-group"></div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 px-md-1">
										<div id="vehicleP" class="form-group bmd-form-group"></div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 px-md-1">
										<div id="workTypeP" class="form-group bmd-form-group"></div>
									</div>
								</div>

								<div class="table-responsive">
									<table id="driversTable"
										class="table table-no-bordered table-hover doorderTable "
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr class="theadColumnsNameTr">
												<th width="5%" v-if="selectedOrders.length > 0"></th>
												<th>Deliverer & Status</th>
												<th>Location</th>
												<th>Vehicle</th>
												<th>Work Type</th>
												<th>Shift Time</th>
												<th>Overall Rating</th>
												<th>Last Seen</th>
												<th class="disabled-sorting ">Actions</th>
											</tr>
										</thead>

										<tbody>
											<tr v-for="driver in drivers" v-if="drivers.length > 0"
												class="order-row" @click="openViewDriver(event,driver.id)">
												<td v-if="selectedOrders.length > 0" class="p-3"><input
													type="checkbox" name="selectedDrivers[]"
													v-bind:value="driver.id"></td>
												<td class="text-left"><span v-if="driver.in_duty"
													class="inDutyDriverSpan inDutyTrue"> <i
														class="fas fa-circle"></i>
												</span> <span v-else class="inDutyDriverSpan inDuty0"> <i
														class="fas fa-circle"></i>
												</span> @{{ driver.first_name}} @{{ driver.last_name }}</td>
												<td>@{{ JSON.parse(driver.work_location).name}}</td>
												<td>@{{ driver.transport }}</td>
												<td></td>
												<td></td>
												<td><div class="overallRating"
														:data-score="driver.overall_rating"></div></td>
												<td>@{{ driver.last_active_web }}</td>
												<td class="actionsTd"><button type="button" class="edit"
														@click="openDriver(driver.id)">
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
						<div class="card" v-if="selectedOrders.length > 0"
							style="background-color: transparent; box-shadow: none;">
							<div class="card-body p-0">
								<div class="container w-100" style="max-width: 100%">

									<div class="row justify-content-end ">
										<div
											class="col-xl-3 col-lg-4  col-md-4 col-sm-5 px-md-1 text-center w-100">

											<button class="btnDoorder btn-doorder-primary  mb-1" id="enableRouteOptimizationBtn"
												@click="submitForm">Enable route optimization</button>
										</div>
									</div>

								</div>
							</div>
						</div>
					</form>
					<form method="POST" id="goToMapViewForm"
						action="{{url('doorder/view_route_optimization_map')}}"
						>
						{{csrf_field()}}
						<input type="hidden" name="map_routes" id="map_routes">
						<input type="hidden" name="selectedDrivers" id="selectedDriversMap">
						<input type="hidden" name="selectedOrders" id="selectedOrdersMap">
					</form>	
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
				<div class="modal-dialog-header modalHeaderMessage">Are you sure you
					want to delete this account?</div>

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
					<button type="button" class="btnDoorder btn-doorder-primary mb-1"
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
<script
	src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script type="text/javascript">

    var token = '{{csrf_token()}}';
	 var table;
	 var mapViewFlag = false
	 
$(document).ready(function() {


	if(app.selectedOrders.length > 0){
            table= $('#driversTable').DataTable({
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
                		"targets": [0,-1],
                		"orderable": false
            		}, 
                        {
                        orderable: false,
                        className: 'select-checkbox',
                        selector: 'td:first-child',
                        targets:   0,
                     }
                 ],
                 select: {
                            style:    'multi',
                 },
                 order: [[ 1, 'asc' ]],        
            	
                initComplete: function(settings, json) {
            		$('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
            			
                 	var column1 = this.api().column(2);
                 	drawFilter(column1,'locationP','location');
                 	var column2 = this.api().column(3);
                 	drawFilter(column2,'vehicleP','vehicle');
                 	var column3 = this.api().column(4);
                 	drawFilter(column3,'workTypeP','work type');
                 	
                },
                  
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 0,
                },
            });
            
             table.on( 'selectItems', function ( e, dt, items ) {
                console.log( 'Items to be selected are now: ', items );
            } );
            table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
               if($(originalEvent.target).children().is(':checked')){
                	$(originalEvent.target).children().attr('checked',false)
                }else{
                	$(originalEvent.target).children().attr('checked','checked')
                }	
            } );
            
    	}
    	else{
    	  table= $('#driversTable').DataTable({
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
                		"targets": [-1],
                		"orderable": false
            		},                        
                 ],
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
                       
    	}	
           
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
                drivers: {!! json_encode($drivers) !!},
                selectedOrders: {!! isset($selectedOrders) ? json_encode($selectedOrders) : json_encode([]) !!},
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
                	    if (e.target.cellIndex == undefined || e.target.cellIndex == 0) {
                	    	
                	    }
                		else{
                   			//window.location.href = "{{url('doorder/drivers/view/')}}/"+driver_id;
                   			window.location.href = "{{url('doorder/drivers/view_orders/')}}/"+driver_id;
                   		}
                },
                toggleCheckbox(e){
                },
                parseDateTime(date) {
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
                },
                submitForm(e){
                    if(mapViewFlag){
                    	e.preventDefault();
                    	$('#goToMapViewForm').submit();
                    }
                    else{
                    	e.preventDefault();
                    	// disable button
                          $("#enableRouteOptimizationBtn").removeAttr('onclick');
                          $("#enableRouteOptimizationBtn").prop("disabled", true);
                          $("#enableRouteOptimizationBtn").removeClass("btn-doorder-primary");
                          $("#enableRouteOptimizationBtn").addClass("btn-doorder-grey");
                        //   add spinner to button
                          $("#enableRouteOptimizationBtn").html(
                            ' Wait for a few minutes  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                          );
                          
                          var selectedOrders = $("#selectedOrders").val();
                          var selectedDrivers = [];
                         $("input[name='selectedDrivers[]']:checked").each(function(){
                                selectedDrivers.push($(this).val());
                            });
						  let token = document.getElementsByName("_token")[0].value
						  console.log('token',token)
                          $.ajax({
                                type:'POST',
                                url: '{{url("doorder/assign_orders_drivers")}}',
								data:{
									_token: token,
									selectedOrders : selectedOrders,
									selectedDrivers : selectedDrivers
								},
                                success:function(data) {
                                      console.log(data);
                                      $("#map_routes").val(data.mapRoutes);
                                      $("#selectedOrdersMap").val(data.selectedOrders)
                                      $("#selectedDriversMap").val(data.selectedDrivers)
                                      
                                      
                                    $("#enableRouteOptimizationBtn").prop("disabled", false);
        							$("#enableRouteOptimizationBtn").html('Go to map view');
                          			$("#enableRouteOptimizationBtn").removeClass("btn-doorder-grey");
                          			$("#enableRouteOptimizationBtn").addClass("btn-doorder-green");
                          			
                          			mapViewFlag = true;
                          			
                                 } 
                          });
                          
                          //{{url('doorder/assign_orders_drivers')}}
                          //$("#assignOrdersDrivers").submit();
                      }    
                }
            }
        });
        
    </script>
@endsection
