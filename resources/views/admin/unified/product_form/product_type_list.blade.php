@extends('templates.dashboard') @section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

.unifiedTable>tbody>tr>td, .unifiedTable>tbody>tr>th, .unifiedTable>tfoot>tr>td, .unifiedTable>tfoot>tr>th, .unifiedTable>thead>tr>td, .unifiedTable>thead>tr>th{
    padding: 5px !important;
}

.selectFilter {
	display: inline-block;
	width: 200px;
}

.hidden-val {
	display: none
}
.productTypeBorderColorDiv{
    width: 20px;
    height: 20px;
    border-radius: 50% ;
    margin: auto;
}
.productTypeBackgroundColorDiv{
    width: 90%;
    height: 20px;
    margin: auto;
}
</style>
@endsection @section('title', 'Unified | Product Types')
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
										src="{{asset('images/unified/Add Service Form.png')}}"
										style="">
								</div>
								<h4 class="card-title ">Product Type</h4>
							</div>
							<div class="col-12 col-md-4 mt-4">
								<div class="row justify-content-end">
									<a class="btn btn-unified-grey btn-import"
										href="{{route('unified_getAddProductType', 'unified')}}">Add</a>
								</div>
							</div>

						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="productTypesTable"
									class="table table-no-bordered table-hover unifiedTable"
									cellspacing="0" width="100%" style="width: 100%">

									<thead>

										<tr class="theadColumnsNameTr">
											<th>Name</th>
											<th class="disabled-sorting ">Color</th>
											<th class="disabled-sorting ">Actions</th>
										</tr>
									</thead>

									<tbody>
										@if(count($product_types) > 0) @foreach($product_types as $product_type)
										<tr class="order-row"
											onclick="clickViewProductType(event,{{$product_type->id}})">
											<td>{{$product_type->name}}</td>
											<td>
											<div class="productTypeBorderColorDiv" style="background-color:{{$product_type->borderColor}} "></div>
											</td>											
											<td><a
												class="btn  btn-link btn-link-gardenhelp btn-just-icon edit"
												onclick="editProductType({{$product_type->id}})"> <img
													class="edit_icon" alt=""
													src="{{asset('images/unified/Edit.png')}}">
											</a>
												<button type="button"
													class="btn btn-link btn-danger btn-just-icon remove"
													onClick="clickDeleteProductType({{$product_type->id}})">
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

<!-- delete productType modal -->
<div class="modal fade" id="delete-productType-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-productType-label"
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
					to delete this product type?</div>

				<div>

					<form method="POST" id="delete-productType"
						action="{{url('unified/product_types/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="productTypeId" name="productTypeId"
							value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-unified-primary modal-btn"
					onclick="$('form#delete-productType').submit()">Yes</button>
				<button type="button" class="btn  btn-unified-danger modal-btn"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete productType modal -->


@endsection @section('page-scripts')
<script
	src="//cdn.datatables.net/plug-ins/1.10.24/sorting/alt-string.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table= $('#productTypesTable').DataTable({
   
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
    	},  ],
    	
    });
} );


function clickViewProductType(e,productTypeId){
 		e.preventDefault();
                	console.log(e.target.cellIndex)
        if (e.target.cellIndex == undefined) {  }
        else{
        	window.location.href = "{{url('unified/product_types/edit/')}}/"+productTypeId;
        }
}
function editProductType(productTypeId){
	window.location.href = "{{url('unified/product_types/edit/')}}/"+productTypeId;
}
function clickDeleteProductType(productTypeId){
$('#delete-productType-modal').modal('show')
$('#delete-productType-modal #productTypeId').val(productTypeId);

}
</script>
@endsection
