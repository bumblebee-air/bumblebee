@extends('templates.dashboard') @section('title', 'Do OmYoga |
Registrations') @section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-sm-6">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/doom-yoga/Registrations.png')}}">
								</div>
								<h4 class="card-title ">Registrations</h4>
							</div>
							<div class="col-6 col-sm-6 mt-4">
								<div class="row justify-content-end"></div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table id="registrationsTable"
										class="table table-no-bordered table-hover gardenHelpTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th>Date/Time</th>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Subscription Type</th>
												<th>Level</th>
												<th>Contact Through</th>
											</tr>
										</thead>

										<tbody>
											@if(count($registrationsList) > 0)
												@foreach($registrationsList as $item)
												<tr class="order-row">
													<td>{{$item->created_at->toDateTimeString()}}</td>
													<td>{{$item->first_name}}</td>
													<td>{{$item->last_name}}</td>
													<td>{{$item->subscription_type}}</td>
													<td>{{$item->level}}</td>
													<td>
														@foreach(json_decode($item->contact_through) as $contact)
														{{$contact}},
														@endforeach
													</td>
												</tr>
												@endforeach
											@endif
										</tbody>
									</table>
									<nav aria-label="pagination" class="float-right"></nav>
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

<script type="text/javascript">
$(document).ready(function() {
     $('#registrationsTable').DataTable({
          fixedColumns: true,
          "lengthChange": false,
          "searching": false,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
    });
 });   
</script>
@endsection
