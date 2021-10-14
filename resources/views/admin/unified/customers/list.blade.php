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
@endsection @section('title', 'Unified | Customers')
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
										src="{{asset('images/unified/Customer.png')}}"
										style="width: 42px !important; height: 32px !important;">
								</div>
								<h4 class="card-title ">Customers</h4>
							</div>
							<div class="col-12 col-md-4 mt-4">
								<div class="row justify-content-end">
									<a class="btn btn-unified-grey btn-import"
										href="{{route('unified_getAddCustomer', 'unified')}}">Add</a>
									
									<button class="btn btn-unified-primary btn-import"
										onclick="clickImportCustomers()">Import</button>
								</div>
							</div>

						</div>
						<div class="card-body">
							<div class="table-responsive">

								<p id="serviceTypeFilter"></p>
								<p id="contractFilter" class="pl-2"></p>
								<table id="customersTable"
									class="table table-no-bordered table-hover unifiedTable"
									cellspacing="0" width="100%" style="width: 100%">

									<thead>

										<tr class="theadColumnsNameTr">
											<th>Name</th>
											<th>Product Type</th>
											<th>Contract</th>
											<th>Location</th>
											<th>Contact</th>
											<th>Email</th>
											<th class="disabled-sorting ">Actions</th>
										</tr>
									</thead>

									<tbody>
										@if(count($customers) > 0) @foreach($customers as $customer)
										<tr class="order-row"
											onclick="clickViewCustomer(event,{{$customer->id}})">
											<td>{{$customer->name}}</td>
											<td>{{$customer->serviceType}}</td>
											<td>
{{--												@if($customer->contract == true)<span--}}
{{--												 class="hidden-val">Yes</span><img--}}
{{--												class="status_icon"--}}
{{--												src="{{asset('images/unified/Contract.png')}}"--}}
{{--												alt="Contract"> @elseif($customer->contract == false) <span--}}
{{--												 class="hidden-val">No</span><img--}}
{{--												class="status_icon"--}}
{{--												src="{{asset('images/unified/No contract.png')}}"--}}
{{--												alt="NoContract"> @endif--}}
												@if($customer->contract)
													<span class="hidden-val">Yes</span><span class="text-success">
														YES
													</span>
												@else
													<span class="hidden-val">No</span><span class="text-danger">
														NO
													</span>
												@endif
											</td>
											<td>
												<span data-toggle="tooltip" data-placement="top" title="{{$customer->address}}">
													{{$customer->county}}
												</span>
											</td>
											<td>{{$customer->contacts ? (json_decode($customer->contacts, true) ? json_decode($customer->contacts, true)[0]['contactName'] : false) : 'N/A'}}</td>
											<td>{{$customer->user->email}}</td>
											<td><a
												class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
												onclick="editCustomer({{$customer->id}})"> <img
													class="edit_icon" alt=""
													src="{{asset('images/unified/Edit.png')}}">
											</a>
												<button type="button"
													class="btn btn-link btn-danger btn-just-icon remove"
													onClick="clickDeleteCustomer({{$customer->id}})">
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
<div class="modal fade" id="delete-customer-modal" tabindex="-1"
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

					<form method="POST" id="delete-customer"
						action="{{url('unified/customers/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="customerId" name="customerId"
							value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-unified-primary modal-btn"
					onclick="$('form#delete-customer').submit()">Yes</button>
				<button type="button" class="btn  btn-unified-danger modal-btn"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete customer modal -->

<!-- import customers modal -->

<div class="modal fade" id="importCustomersModal" tabindex="-1"
	role="dialog" aria-labelledby="importCustomersLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-upload">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<form method="POST" id="importCustomersForm"
						enctype="multipart/form-data"
						action="{{url('unified/customers/import')}}"
						style="margin-bottom: 0 !important;">
						@csrf 
			<div class="modal-body">
				<div class=" uploadHeader  ">Upload a file</div>

				<div class="mt-2 uploadCustomersDiv text-center">

					<input class="file-upload inputFileHidden" id="customers-file"
							name="customers-file" type="file"
							accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
							required
							onchange="onChangeFile(event, 'customers_file_input')" />
					<div class="" onclick="addFile('customers-file')">
								
									<img class="page_icon"
										src="{{asset('images/unified/upload.png')}}"
										style="width: 33px !important; height: 30px !important;">
										
									<p class="mt-2 uploadFileP" id="">Uplaod your file</p>	
									
							</div>		
							
					
				</div><p id="customers_file_input" class="mt-2 uploadFileP" ></p>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="submit" class="btn  btn-unified-primary modal-btn">Upload</button>

			</div>
			</form>
		</div>
	</div>
</div>

<!-- end import customers modal -->

@endsection @section('page-scripts')
<script
	src="//cdn.datatables.net/plug-ins/1.10.24/sorting/alt-string.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table= $('#customersTable').DataTable({
   
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
        	var column = this.api().column(1);
                  var select = $('<select id="" class="form-control selectFilter"><option value="">Filter by product type</option></select>')
                    .appendTo( $('#serviceTypeFilter').empty().text('') )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? "(^|, )" + val + "(,|$)" : "", true, false).draw();
                      
                  } );
//                   column.data().unique().sort().each( function( d, j ) {      
//                            var nameArr = d.split(",");
//                             nameArr.forEach(function(number) {                
//                                 var optionExists = ($("#language option[value='"+number+"']").length > 0);
//                                 if(!optionExists){
//                                     select.append( '<option value="'+number+'">'+number+'</option>' );
//                                 }                    
//                             });                     
                   
//                 	} );
                	
                	var nameArr = {!! $services !!};
                    nameArr.forEach(function(number) {
                    var optionExists = ($("#language option[value='"+number+"']").length > 0);
                        select.append( '<option value="'+number+'">'+number+'</option>' );
                    });            
                  
              // filter contract
              var column2 = this.api().column(2);
                  var select2 = $('<select id="" class="form-control selectFilter"><option value="">Filter by contract</option></select>')
                    .appendTo( $('#contractFilter').empty().text('') )
                    .on( 'change', function () {  console.log("'"+$(this).val()+"'");
                    var val2 = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                        );
                    column2
                    .search( val2  )
                    .draw();
                  });
                  column2.data().unique().sort().each( function ( d, j ) {
                  
                    var html_val = $.parseHTML(d)
                    console.log(html_val);

                    if (html_val != null){ // check if html is not null
                        var new_d = $(html_val)[0].innerText // take first html object <span> in this case
                        console.log(new_d);
                        select2.append( '<option value="'+new_d+'">'+new_d+'</option>' )
                    }
                  } );        
        }
    });
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "alt-string-pre": function ( a ) {
        return a.match(/alt="(.*?)"/)[1].toLowerCase();
    },
 
    "alt-string-asc": function( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "alt-string-desc": function(a,b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );

jQuery.fn.dataTable.ext.type.search.hiddenVal = function(data) {
    return $('<div>').append(data).find('.hidden-val').text()
}


} );


function clickViewCustomer(e,customerId){
 		e.preventDefault();
                	console.log(e.target.cellIndex)
        if (e.target.cellIndex == undefined) {  }
        else{
        	window.location.href = "{{url('unified/customers/view/')}}/"+customerId;
        }
}
function editCustomer(customerId){
	window.location.href = "{{url('unified/customers/edit/')}}/"+customerId;
}
function clickDeleteCustomer(customerId){
$('#delete-customer-modal').modal('show')
$('#delete-customer-modal #customerId').val(customerId);

}

function clickImportCustomers(){
$('#importCustomersModal').modal('show')
}

function addFile(id){
                    $('#' + id).click();
}
function onChangeFile(e ,id) {
console.log(e.target.files[0].name);
                    $("#" + id).html(e.target.files[0].name);
                }
</script>
@endsection
