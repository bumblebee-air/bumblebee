@extends('templates.doorder_dashboard')

@section('page-styles')
<link
	href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css"
	rel="stylesheet">
@endsection
@section('title', 'DoOrder | Orders')
@section('page-content')
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12">
								<h4 class="card-title my-md-4 mt-4 mb-1">Stripe payment logs</h4>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-no-bordered table-hover doorderTable ordersListTable"
									   id="paymentLogsTable">
									<thead>
									<tr>
										<th>Date/Time</th>
										<th class="text-center">Description</th>
										<th>Operation</th>
										<th>Status</th>
										<th class="text-center">Failure message</th>
									</tr>
									</thead>

									<tbody>
									<tr v-for="a_log in logs_data.data" v-if="logs_data.data.length > 0" class="order-row">
										<td class="orderDateTimeTd">
											@{{ a_log.date_time }}
										</td>
										<td class="text-center">@{{ a_log.description }}</td>
										<td>@{{ a_log.operation_type }}</td>
										<td>@{{ a_log.status }}</td>
										<td class="text-center">@{{ a_log.fail_message }}</td>
									</tr>
									<tr v-else>
										<td colspan="8" class="text-center">
											<strong>No data found.</strong>
										</td>
									</tr>
									</tbody>
								</table>
								<nav aria-label="pagination" class="float-right">
								</nav>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-center">
						{{ $logs_data->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page-scripts')
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
	integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
	crossorigin="anonymous"></script>
<script>
	let token = '{{csrf_token()}}';
	let table;
	let userRole = '{!! auth()->user()->user_role  !!}';

	$(document).ready(function() {
		table = $('#paymentLogsTable').DataTable({
			fixedColumns: true,
			"lengthChange": false,
			"searching": true,
			"info": false,
			"ordering": false,
			"paging": false,
			"responsive": true,
			"language": {
				search: '',
				"searchPlaceholder": "Search ",
			},
			scrollX: true,
			scrollCollapse: true,
			fixedColumns: {
				leftColumns: 0,
			},

		});
	});
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                logs_data: {}
            },
            mounted() {
                let logs_data = {!! json_encode($logs_data) !!};

                /*for(let log of logs_data.data) {
                }*/

                this.logs_data = logs_data;
            },
            methods: {
            }
        });
    </script>
@endsection
