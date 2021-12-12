@extends('templates.doorder_dashboard') @section('page-styles')
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
	font-family: Montserrat;
	font-style: normal;
	font-weight: normal;
	font-size: 17px;
	line-height: 25px;
	letter-spacing: 0.16px;
	color: #BFBFBF;
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
	font-family: Montserrat;
	font-size: 21px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 25px;
	letter-spacing: 0.2px;
	color: #000000;
}

.form-control-select{
    min-height: 50px;
}
.dropdown-menu.inner.show li a {
	
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

.bootstrap-select .btn.dropdown-toggle.select-with-transition {
	height: 50px;
}

.bootstrap-select .btn.dropdown-toggle.select-with-transition:focus {
	box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08) !important;
}

.btn.dropdown-toggle.select-with-transition {
	height: auto
}

.btn.dropdown-toggle.select-with-transition	.filter-option .filter-option-inner .filter-option-inner-inner
	{
	overflow: hidden;
	white-space: normal;
	width: 90%;
	word-wrap: break-word;
	position: absolute;
	top: 50%;
	-ms-transform: translateY(-50%);
	transform: translateY(-50%);
}
</style>
@endsection @section('title','DoOrder | Upload Mass Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 col-xl-7 col-lg-8 col-md-9 col-sm-12">
								<h4 class="card-title my-md-4 mt-4 mb-md-1 mb-4">Upload Mass
									Order</h4>
							</div>
						</div>
					</div>
					<form id="order-form" method="POST"
						action="{{url('doorder/orders/import')}}"
						enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="card">

							<div class="card-body">
								<div class="container">
									<div class="row mt-2">

										<div class="col-md-6 ">
											<div class="form-group pb-0">
												<label for="address" class=" "> Upload Excel
													Sheet </label>
											</div>
											<div class="uploadDiv text-center">

												<input class="file-upload inputFileHidden" id="orders-file"
													name="orders-file" type="file"
													accept=".csv,.xlsm, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
													required
													onchange="onChangeFile(event, 'orders_file_input')" />
												<div class="" onclick="addFile('orders-file')">
													<p class="m-0 uploadFileP" id="">Click here to upload your
														file</p>

												</div>

											</div>
										</div>
										<div class="col-md-6 ">
											<div class="form-group">
												<label for="address" class=" "> Address </label>
												<select id="address" name="address"
													data-style="select-with-transition" data-width="100%"
													class="form-control form-control-select selectpicker" required>
													<option value="">Select address</option>
													@foreach($pickup_addresses as $address)
													<option value="{{json_encode($address)}}">{{$address['address']}} {{$address['address']}}</option>
													@endforeach
												</select>
											</div>
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
									<div class="col-md-10  ">
										<div class="form-group pb-0">
												<label  class=""> Uploaded Files </label>
											</div>
									</div>


								</div>
								<div class="row">
									<div class="col-md-10 ">
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
					
					
						<div class="row justify-content-center">
							<div class="col-lg-3  col-md-3 col-sm-4 px-md-1 text-center">
								<button type="submit"
									class="btnDoorder btn-doorder-primary  mb-1">Submit</button>
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
