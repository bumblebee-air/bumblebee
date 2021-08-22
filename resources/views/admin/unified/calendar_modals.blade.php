
<!-- calendar-modal-job-list empty-->
<div class="modal fade" id="calendar-modal-job-list-empty" tabindex="-1"
	role="dialog" aria-labelledby="calendar-label-job-list-empty"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">

				<input type="hidden" id="date"> <input type="hidden"
					id="isDateHidden"> <input type="hidden" id="serviceId">
				<div>
					<h3 class="addJobSubTitleModal">
						<span id="jobsListTitleModalSpan"></span> Jobs List
					</h3>

					<div class="row mt-3 text-center">
						<div class="col-12 text-center">
							<h3 class="noJobsAddedHeader">No jobs added to that day so far</h3>
						</div>
						<div class="col-12 mt-4 text-center">
<!-- 							<button class=" btn-nojob-add-calendar" 
								onclick="clickAddScheduledJobListModal('nojob')"> -->
								<a class=" btn-nojob-add-calendar" 
													href="{{route('unified_getAddScheduledJob', ['unified','0','0'])}}">
													<img src="{{asset('images/unified/add-job.png')}}"></a>
<!-- 							</button> -->
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- end calendar-modal-job-list empty -->

<!-- calendar-modal-job-list -->

<div class="modal fade" id="calendar-modal-job-list" tabindex="-1"
	role="dialog" aria-labelledby="calendar-joblist-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">

				<input type="hidden" id="date"> <input type="hidden"
					id="isDateHidden"> <input type="hidden" id="serviceId">

				<h3 class="addJobSubTitleModal">
					<span id="jobsListTitleModalSpan"></span> Jobs List
				</h3>

				<div class="row mt-3 ">
					<div class="col">
						<ul class="list-group" id="jobsListUl">
						</ul>
					</div>
				</div>


				<div class="row mt-4">
					<div class="col-12">
<!--						<button class=" btn-add-calendar" style="float: right;"
							onclick="clickAddScheduledJobListModal('hasjobs')">
 							<img class="" src="{{asset('images/unified/add-icon.png')}}"> -->
<!-- 						</button> -->
						<a class=" btn-add-calendar" style="float: right;"
													href="{{route('unified_getAddScheduledJob', ['unified','0','0'])}}">
													<img class=""
														src="{{asset('images/unified/add-icon.png')}}">
												</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end calendar-modal-job-list -->


<!-- calendar-modal-contract-list -->

<div class="modal fade" id="calendar-modal-contract-list" tabindex="-1"
	role="dialog" aria-labelledby="calendar-contractlist-label"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-dialog-header addJobModalHeader">
					<span id="dateSpan"></span>
				</div>
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body mb-4">

				<h3 class="addJobSubTitleModal">
					<span id="contractListTitleModalSpan"></span>
				</h3>

				<div class="row mt-3 mb-3">
					<div class="col">
						<ul class="list-group" id="contractListUl">
						</ul>
					</div>
				</div>


				
			</div>
		</div>
	</div>
</div>
<!-- end calendar-modal-contract-list -->