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
					<form id="jobTypeForm" method="POST"
						action="{{route('unified_postAddJobType', ['unified'])}}"
						@submit="onSubmitForm">
						{{csrf_field()}}
						<div class="card">
							<div class="card-header card-header-icon  row">
								<div class="col-12 col-md-8">
									<div class="card-icon p-3">
										<img class="page_icon"
											src="{{asset('images/unified/Add Service Form.png')}}"
											style="">
									</div>
									<h4 class="card-title customerProfile">Add Job Type</h4>
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
													name="name" placeholder="Name" required>
											</div>
										</div>

									</div>

								</div>
							</div>
						</div>
						
						<div class="row ">
							<div class="col-md-12 text-center">

								<button class="btn btn-unified-primary singlePageButton">Add</button>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts')

<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script src="{{asset('js/form-builder/form-builder.min.js')}}"></script>
<script src="{{asset('js/form-builder/form-render.min.js')}}"></script>
    
<script type="text/javascript">
/////////////// form builder opti

$( document ).ready(function() {
          	
});


    </script>
@endsection
