@extends('templates.print') @section('title', 'Print QR')

@section('styles')
<style>
#printDiv {
	/* 	width: 600px; */
	/*             height: 600px; */
	
}

.col-6 {
	width: 50% !important;
}

.td-50 {
	width: 50%;
}
</style>
@endsection @section('content')
<div class="" style="width:874px; max-width: 874px">
	<table class="table-borderless">
		<tbody>
			<!-- tr represents .row and td represents .col -->
			<tr>
				<td class="td-50"><div class="form-group ">
						<label class="control-label  mb-0">Name: </label> <span
							class="control-label  " style="display: block; font-weight: 600">
							{{$name}} </span>
					</div>
					<div class="form-group ">
						<label class="control-label mb-0">Order number: </label> <span
							class="control-label" style="display: block; font-weight: 600">
							{{$order_number}}</span>
					</div>
					<div class="form-group" style="width: 400px; max-width: 100%">
						<label class="control-label mb-0">Customer address:  <span
							class="control-label" style="display: block; font-weight: 600; max-width: 100%">
							{!! $customer_address !!} <span> </span></span></label>
					</div>
					<div class="form-group ">
						<label class="control-label mb-0">Phone number: </label> <span
							class="control-label" style="display: block; font-weight: 600">
							{{$customer_phone}}</span>

					</div></td>
				<td class="td-50 pl-5">
					<div class="text-center">
						<div class="delivery-qrcode-reader">
							<img src="data:image/svg+xml;base64,{{ base64_encode($qr_str) }}" />
						</div>
					</div>
					<div class="text-center  py-3">
						<img src="{{asset('images/doorder-logo.png')}}"
							style="width: 200px; height: 140px">
					</div></td>
			</tr>
			@if(isset($package_no) && isset($package_total))
			<tr>
				<td colspan="2" class="text-center">
					<h4>Package {{$package_no}} of {{$package_total}}</h4>
				</td>
			</tr>
			@endif
		</tbody>
	</table>

</div>
@endsection
