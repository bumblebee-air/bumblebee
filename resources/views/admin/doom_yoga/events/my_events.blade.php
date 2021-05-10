@extends('templates.dashboard') @section('title', 'Do OmYoga | My
Events') @section('page-styles')
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
										src="{{asset('images/doom-yoga/My-Events.png')}}">
								</div>
								<h4 class="card-title ">My Events</h4>
							</div>
							<div class="col-6 col-sm-6 mt-4">
								<div class="row justify-content-end"></div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table id="myEventsTable"
										class="table table-no-bordered table-hover gardenHelpTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th>Date/Time</th>
												<th>Name</th>
												<th>Event Type</th>
												<th>Event In Person</th>
												<th>Duration in Mins</th>
												<th>Attending</th>
												<th>Reccuring</th>
											</tr>
										</thead>

										<tbody>
											@if(count($myevents) > 0) @foreach($myevents as $event)
											<tr class="order-row">
											    <td>{{$event->dateTime}}</td>
												<td>{{$event->event_name}}</td>
												<td>{{$event->event_type}}</td>
												<td>{{$event->eventInPerson}}</td>
												<td>{{$event->durationInMins}}</td>
												<td>{{$event->attending}}</td>
												<td>{{$event->reccuring}}</td>
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
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
     $('#myEventsTable').DataTable({
          fixedColumns: true,
          "lengthChange": false,
          "searching": false,
  		  "info": false,
  		  "ordering": false,
    });
 });   
</script>
@endsection
