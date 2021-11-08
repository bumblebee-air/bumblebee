@extends('templates.dashboard') @section('page-styles')

<style>
.overallRating img{
    width: 18px;
    height: 18px;
}
</style>
 @endsection
@section('title', 'DoOrder | Deliverers') @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-sm-4">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/doorder_icons/Deliverers-white.png')}}">
								</div>
								<h4 class="card-title ">Deliverers</h4>
							</div>

						</div>
						<div class="card-body">
							<div style="float: right;">
								<a href="{{ url()->current()."?export_type=exel" }}" class="btn btn-primary filterButton">Export</a>
							</div>
							<div class="table-responsive">
								<table id="driversTable"
									class="table table-no-bordered table-hover doorderTable "
									cellspacing="0" width="100%" style="width: 100%">
									<thead>
										<tr>
											<th class="filterhead">Location</th>
											<th class="filterhead">Deliverer Name</th>
											<th class="filterhead">Overall Rating</th>
											<th class="filterhead">Address</th>
											<th class="filterhead">Transport Type</th>
											<th class="filterhead">Work Type</th>
											<th class="filterhead">Shift Time</th>
											<th class="filterhead">Action</th>
										</tr>


										<tr class="theadColumnsNameTr">
											<th>Location</th>
											<th>Deliverer Name</th>
											<th>Overall Rating</th>
											<th>Address</th>
											<th>Transport Type</th>
											<th>Work Type</th>
											<th>Shift Time</th>
											<th class="disabled-sorting ">Action</th>
										</tr>
									</thead>

									<tbody>
										<tr v-for="driver in drivers"
											v-if="drivers.length > 0" class="order-row"
											 @click="openViewDriver(event,driver.id)">
											<td>@{{ JSON.parse(driver.work_location).name}}</td>
											<td>@{{ driver.first_name}} @{{ driver.last_name }}</td>
											<td><div class="overallRating" :data-score="driver.overall_rating"></div>
											</td>
											<td>@{{ driver.address}}</td>
											<td>@{{ driver.transport }}</td>
											<td></td>


											<td></td>

											<td><a
												class="btn  btn-link btn-primary-doorder btn-just-icon edit"
												 @click="openDriver(driver.id)"><i class="fas fa-pen-fancy"></i></a>
												<button type="button"
													class="btn btn-link btn-danger btn-just-icon remove"
													@click="clickDeleteDriver(driver.id)">
													<i class="fas fa-trash-alt"></i>
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
					{{--<div class="d-flex justify-content-center">{$drivers->links()}</div>--}}
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
				<div class="modal-dialog-header deleteHeader">Are you sure you want
					to delete this account?</div>

				<div>

					<form method="POST" id="delete-driver"
						action="{{url('doorder/driver/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="driverId" name="driverId" value="" />
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<button type="button"
					class="btn btn-primary doorder-btn-lg doorder-btn"
					onclick="$('form#delete-driver').submit()">Yes</button></div>
				<div class="col-sm-6">
					<button type="button"
					class="btn btn-danger doorder-btn-lg doorder-btn"
					data-dismiss="modal">Cancel</button></div>
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
    	}, {
                    render: function (data, type, full, meta) {
                    	return '<span data-toggle="tooltip" data-placement="top" title="'+data+'">'+data+'</span>';
                    },
                    targets: 3
                } ],
    	
        initComplete: function(settings, json) {
    		$('.dataTables_scrollBody thead tr').css({visibility:'collapse'})
        },
          
        scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
    });
    
       $(".filterhead").each(function (i) {
                 if (i == 0  || i==4 || i==5 ) {
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
             
        $('.overallRating').raty({
  					readOnly: true, 
                    starHalf:     '{{asset("images/doorder_icons/star-half.png")}}',
                	starOff:      '{{asset("images/doorder_icons/star.png")}}',
                	starOn:       '{{asset("images/doorder_icons/star-selected.png")}}',
                	hints: null
        });  
           
    
} );

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
