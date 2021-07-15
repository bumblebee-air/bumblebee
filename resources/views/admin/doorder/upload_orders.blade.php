@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
#importButton {
	font-size: 14px;
	font-weight: 600;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.72px;
	color: #ffffff;
	border-radius: 12px 0;
	text-transform: inherit !important;
	height: auto;
	padding: 10px;
}

.uploadHeader {
	font-family: Quicksand;
	font-size: 20px !important;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 2.14;
	letter-spacing: 0.2px !important;
	color: #7b7b7b !important;
}

.uploadDiv {
	padding: 10px;
	border-radius: 8px;
	border: dashed 1px #979797;
	background-color: #f4f4f4;
}

.uploadedFilesDiv {
	padding: 10px;
	border-radius: 8px;
}

.uploadFileP {
	font-family: Quicksand;
	font-size: 17px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 2.65;
	letter-spacing: 0.16px;
	color: #bfbfbf;
}

.uploadedFilesDiv .uploadFileP {
	font-family: Quicksand;
	font-size: 21px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 2.14;
	letter-spacing: 0.2px;
	color: #7b7b7b;
	opacity: 0.5;
}

.inputFileHidden {
	display: none;
}

.hidden-val {
	display: none
}

.bt-submit {
	font-size: 18px;
	width: 220px
}

#orders_file_input {
	font-family: Quicksand;
	font-size: 21px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 2.14;
	letter-spacing: 0.2px;
	color: #000000;
}

.dropdown-menu.inner.show li a {
	font-family: Quicksand;
	font-size: 14px;
	font-weight: 400;
	 display: inline-block;
    overflow: hidden;
    text-align: left;
    white-space: normal;
    width: 100%;
    word-wrap: break-word;
}

.dropdown-menu.show {
	width: inherit;
}
.bootstrap-select .btn.dropdown-toggle.select-with-transition{
height: 50px;
background-color: #f4f4f4 !important;
}
.bootstrap-select .dropdown-toggle .filter-option {
	font-family: Quicksand;
	font-size: 17px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	letter-spacing: 0.16px;}
.btn.dropdown-toggle.select-with-transition{
height: auto}
.btn.dropdown-toggle.select-with-transition	.filter-option .filter-option-inner .filter-option-inner-inner{

    overflow: hidden;
    white-space: normal;
    width: 100%;
    word-wrap: break-word;
}
	
</style>
@endsection @section('title','DoOrder | Upload Mass Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12">
					<form id="order-form" method="POST"
						action="{{url('doorder/orders/import')}}"
						enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 ">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/doorder_icons/icon_export_header.png')}}">
									</div>
									<h4 class="card-title ">Upload Mass Order</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-10 offset-md-1">
											<div class=" uploadHeader  ">Upload Excel Sheet</div>

											<div class="mt-2 uploadDiv text-center">

												<input class="file-upload inputFileHidden" id="orders-file"
													name="orders-file" type="file"
													accept=".csv,.xlsm, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
													required
													onchange="onChangeFile(event, 'orders_file_input')" />
												<div class="" onclick="addFile('orders-file')">



													<p class="mt-2 uploadFileP" id="">Click here to upload your
														file</p>

												</div>

											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10 offset-md-1">
											<div class="form-group">
												<label for="address" class=" uploadHeader"> Address </label>
												<select id="address" name="address"
													data-style="select-with-transition" data-width="100%"
													class=" selectpicker" required>
													<option value="">Select address</option>
													@foreach($pickup_addresses as $address)
													<option value="{{json_encode($address)}}">{{$address['address']}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-10 offset-md-1 text-right">
											<button class="btn bt-submit">Submit</button>
										</div>
									</div>

								</div>
							</div>
						</div>
					</form>
					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-10 offset-md-1 d-flex form-head">
										<span> 2 </span>
										<h4 class="card-title mt-0"
											style="line-height: 1.14; margin-top: 0 !important;">
											Uploaded Files</h4>
									</div>


								</div>
								<div class="row">
									<div class="col-md-10 offset-md-1">
										<div class="mt-2 uploadedFilesDiv text-center">
											<p class="mt-2 uploadFileP" id="">Upload your mass order file
												to appear here</p>



										</div>
										<div class="mt-2">
											<p id="orders_file_input"></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script>
       
function addFile(id){
                    $('#' + id).click();
}
function onChangeFile(e ,id) {
console.log(e.target.files[0].name);
                    $("#" + id).html(e.target.files[0].name);
                    $(".uploadedFilesDiv").css("display","none")
                }
    </script>
@endsection
