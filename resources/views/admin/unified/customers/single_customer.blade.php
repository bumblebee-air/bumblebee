@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

@endsection @section('title','Unified | Customer ' . $customer->name)
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)
					<form id="order-form" method="POST"
						action="{{route('unified_postCustomerSingleEdit', ['unified', $customer->id])}}">
						@endif {{csrf_field()}} <input type="hidden" name="customer_id"
							value="{{$customer->id}}">
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Customer.png')}}"
											style="width: 42px !important; height: 32px !important;">
									</div>
									<h4 class="card-title ">{{$customer->name}}</h4>
								</div>
								@if($readOnly==1)
								<div class="col-6 col-md-4 mt-5">
									<div class="row justify-content-end">
										<a class="editLinkA btn  btn-link btn-primary-doorder  edit"
											href="{{url('unified/customers/edit')}}/{{$customer->id}}">
											<p>Edit customer</p>
										</a>
									</div>
								</div>
								@endif
							</div>
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											@if(count($errors))
											<div class="alert alert-danger" role="alert">
												<ul>
													@foreach ($errors->all() as $error)
													<li>{{$error}}</li> @endforeach
												</ul>
											</div>
											@endif
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Name</label> <input type="text"
															class="form-control" name="name"
															value="{{$customer->name}}" placeholder="Name" required>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Service type</label> <input type="text"
															class="form-control" name="serviceType"
															value="{{$customer->serviceType}}"
															placeholder="Service type" required>
													</div>
												</div>

												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Address</label>
														<textarea class="form-control" name="address"
															placeholder="Address" required> {{$customer->address}}</textarea>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Mobile</label> <input type="text"
															class="form-control" name="mobile"
															value="{{$customer->mobile}}" placeholder="Mobile" required>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Contact</label> <input type="text"
															class="form-control" name="contact"
															value="{{$customer->contact}}" placeholder="Contact"
															required>
													</div>
												</div>
												<div class="col-md-12 mb-3">
												<div class=" row" style="margin-top: 15px">
													<label class="labelRadio col-12" for="">Contract</label>
													<div class="col-12 row">
														<div class="col">
															<div class="form-check form-check-radio">
																<label class="form-check-label"> <input
																	class="form-check-input" type="radio"
																	id="exampleRadios2" name="contract" value="1"
																	{{$customer->contract ? 'checked' : ''}}
																	required> Yes <span class="circle"> <span class="check"></span>
																</span>
																</label>
															</div>
														</div>
														<div class="col">
															<div class="form-check form-check-radio">
																<label class="form-check-label"> <input
																	class="form-check-input" type="radio"
																	id="exampleRadios1" name="contract" value="0"
																	{{$customer->contract == '0' ? 'checked' : ''}}
																	required> No <span class="circle"> <span class="check"></span>
																</span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Email address</label> <input type="text"
															class="form-control" name="email"
															value="{{$customer->email}}" placeholder="Email address"
															required>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Postcode</label> <input type="text"
															class="form-control" name="postcode"
															value="{{$customer->postcode}}" placeholder="Postcode"
															required>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group bmd-form-group">
														<label>Phone</label> <input type="text"
															class="form-control" name="phone"
															value="{{$customer->phone}}" placeholder="Phone"
															required>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>



						@if($readOnly==0)
						<div class="row ">
							<div class="col-md-4 offset-md-2 text-center">

								<button class="btn btn-unified-primary singlePageButton">Save</button>
							</div>
							<div class="col-md-4 text-center">
								<button class="btn btn-unified-danger singlePageButton"
									type="button" data-toggle="modal"
									data-target="#delete-customer-modal">Delete</button>
							</div>
						</div>
					</form>
					@endif
					<!-- Delete modal -->
					<div class="modal fade" id="delete-customer-modal" tabindex="-1"
						role="dialog" aria-labelledby="delete-customer-label"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">

									<button type="button"
										class="close d-flex justify-content-center"
										data-dismiss="modal" aria-label="Close">
										<i class="fas fa-times"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="modal-dialog-header deleteHeader">Are you sure you
										want to delete this account?</div>
									<div>
										<form method="POST" id="delete-customer"
											action="{{url('doorder/customer/delete')}}"
											style="margin-bottom: 0 !important;">
											@csrf <input type="hidden" id="customerId" name="customerId"
												value="{{$customer->id}}" />
										</form>
									</div>
								</div>
								<div class="modal-footer d-flex justify-content-around">
									<button type="button"
										class="btn btn-primary doorder-btn-lg doorder-btn"
										onclick="$('form#delete-customer').submit()">Yes</button>
									<button type="button"
										class="btn btn-danger doorder-btn-lg doorder-btn"
										data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts') {{--
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
--}} {{--
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
--}}
<script>
$( document ).ready(function() {

var readonly = {!! $readOnly !!};
if(readonly==1){
$("input").prop('disabled', true);
$("textarea").prop('disabled', true);
}
});
     
    </script>
@endsection
