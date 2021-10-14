@extends('templates.dashboard') @section('page-styles')

<style>
</style>
@endsection @section('title','Unified | Add Job Type ')
@section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					@if($readOnly==0)
					<form id="jobTypeForm" method="POST"
						action="{{route('unified_postJobTypeSingleEdit', ['unified',$jobType->id])}}"
						@submit="onSubmitForm">@endif
						{{csrf_field()}}
						<input type="hidden" name="job_type_id"
							value="{{$jobType->id}}">
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Add Service Form.png')}}"
											style="">
									</div>
									<h4 class="card-title customerProfile">Job Type / {{$jobType->name}}</h4>
								</div>
								<div class="col-6 col-md-4 mt-4">
									<div class="row justify-content-end">
										@if($readOnly==1)
										<a class="btn btn-unified-primary btn-import w-auto"
											href="{{url('unified/job_types/edit')}}/{{$jobType->id}}">
											Edit job type </a>
										@endif	
									</div>

								</div>

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
											<div class="form-group bmd-form-group">
												<label>Name</label> <input type="text" class="form-control"
													name="name" placeholder="Name" required value="{{$jobType->name}}">
											</div>
										</div>

									</div>

								</div>
							</div>
						</div>
												
						@if($readOnly==0)
						<div class="row ">
							<div class="col-md-4 offset-md-2 text-center">

								<button class="btn btn-unified-primary singlePageButton">Edit</button>
							</div>
							<div class="col-md-4 text-center">
								<button class="btn btn-unified-danger singlePageButton"
									type="button" data-toggle="modal"
									data-target="#delete-jobType-modal">Delete</button>
							</div>
						</div>
					</form>
					@endif
					

				</div>
			</div>
		</div>

	</div>
</div>

<!-- delete jobType modal -->
<div class="modal fade" id="delete-jobType-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-jobType-label"
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
					to delete this job type?</div>

				<div>

					<form method="POST" id="delete-jobType"
						action="{{url('unified/job_types/delete')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="jobTypeId" name="jobTypeId"
							value="{{$jobType->id}}" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around">
				<button type="button" class="btn  btn-unified-primary modal-btn"
					onclick="$('form#delete-jobType').submit()">Yes</button>
				<button type="button" class="btn  btn-unified-danger modal-btn"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete jobType modal -->

@endsection @section('page-scripts')


<script>
var readonly = {!! $readOnly !!};


$( document ).ready(function() {

	if(readonly==1){
    	$("input").prop('disabled', true);
    	$("textarea").prop('disabled', true);
    	$("select").prop('disabled', true);
	}
      
});


    </script>
@endsection
