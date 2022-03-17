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
	padding:15px 10px
}
.td-100 {
	width: 100%;
	padding:15px 10px
}
</style>
@endsection @section('content')
<div class="" style="width:874px; max-width: 874px; padding-left:0">
	<table class="pl-0 " style="border: 2px solid #000">
		<tbody>
			<!-- tr represents .row and td represents .col -->
			<tr>
			<td colspan="2" class="td-100 py-2" style="border-bottom: 2px solid black;">
					<div class="my-2  py-1">
						<img src="{{asset('images/doorder-logo.png')}}"
							style="width: 200px; height: 140px">
					</div>
					 </td>			</tr>
			<tr>
				<td class="td-50">
				<div class="my-2" style="margin-left:10px">
					<div class="form-group ">
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

					</div></div></td>
				<td class="td-50 ">
						<div class="delivery-qrcode-reader" style="margin-right: 10px">
							<img src="data:image/svg+xml;base64,{{ base64_encode($qr_str) }}" />
						
					</div></td>
			</tr>
			<tr>
				<td colspan="2" class="td-100"
					style="border-bottom: 2px solid black; border-top: 2px solid black;">
					<div class="form-group my-2"  style="margin-left:10px"><label class="control-label mb-0">From: </label>
					<span class="control-label"
						  style="display: block; font-weight: 600">{{$from_name}}</span> </div>
					
				</td>
			</tr>
			@if(isset($package_no) && isset($package_total))
			<tr>
				<td colspan="2" class="td-100 text-center">
					<h4 class="my-2">Package {{$package_no}} of {{$package_total}}</h4>
				</td>
			</tr>
			@endif
		</tbody>
	</table>

</div>
@endsection
