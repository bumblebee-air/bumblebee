@extends('templates.dashboard') @section('title', 'Do OmYoga | Videos')
@section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

video {
	width: 100%;
}

select.form-control:not([size]):not([multiple]) {
	height: 36px !important;
	padding: 5px 8px;
	border-radius: 5px;
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
	font-family: Quicksand;
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	letter-spacing: 0.77px;
	color: #4d4d4d;
	width: 100%;
	height: auto;
}

.form-control:read-only {
	background-image: none !important;
}

.modal-dialog .modal-header .close {
	top: 0 !important;
	right: 0 !important;
}

.modal-header .close {
	width: 15px;
	height: 15px;
	margin: 39px 37px 35px 49px;
	background-color: #4f4f4f;
	border-radius: 30px;
	color: white !important;
	padding: 0.6rem;
	opacity: 1 !important;
	width: 15px;
}

.modal-header .close i {
	font-size: 10px !important;
	margin: -5px;
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
							<div class="col-12 col-md-8">
								<div class="card-icon">
									<img class="page_icon"
										src="{{asset('images/doom-yoga/Video.png')}}">
								</div>
								<h4 class="card-title ">Videos List</h4>
							</div>
							<div class="col-12 col-md-4 mt-4">
								<div class="row justify-content-end">
									<a class="btn btn-doomyoga-grey btn-import" href="{{route('doomyoga_getAddVideo', 'doom-yoga')}}"
										>Add video</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<div class="">
										<label class=" col-form-label filterLabelDashboard">Filter:</label>

										<div class="col-md-3" style="display: inline-block;">
											<div id="categoryDiv" class="form-group bmd-form-group"></div>
										</div>
									</div>
									<table id="videosTable"
										class="table table-no-bordered table-hover doomyogaTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th>Title</th>
												<th>Video</th>
												<th>Category</th>
												<th>Actions</th>
											</tr>
										</thead>

										<tbody>


											<tr v-for="video in videos" class="order-row"
												>
												<td>@{{video.title}}</td>
												<td><video class="lg-video-object lg-html5" controls
														preload="none">
														<source :src="'{{asset('')}}'+video.videoUrl"
															type="video/mp4">
														Your browser does not support HTML5 video.
													</video></td>
												<td>@{{video.categoryName}}</td>
												<td><a
													class="btn  btn-link btn-primary-doorder btn-just-icon edit"
													@click="clickEditVideo(video.id)"><i class="fas fa-pen-fancy"></i></a>
													<button type="button"
														class="btn btn-link btn-danger btn-just-icon remove"
														@click="clickDeleteVideo(video.id)">
														<i class="fas fa-trash-alt"></i>
													</button></td>
											</tr>
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


<!-- delete video modal -->
<div class="modal fade" id="delete-video-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-video-label"
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
				<div class="modal-dialog-header deleteHeader modalHeaderH2 mt-4 mb-5">
				<h2 id="successMessageHeaderDiv">Are you sure you want
					to delete this video?</h2></div>
				<div>

					<form method="POST" id="delete-video"
						action="{{url('doom-yoga/delete_video')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="videoId" name="videoId" value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around mb-2">
				<button type="button"
					class="btn btn-doomyoga-grey"
					onclick="$('form#delete-video').submit()">Yes</button>
				<button type="button"
					class="btn btn-doomyoga-black"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete video modal -->
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
     $('#videosTable').DataTable({
    "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50,100, -1],
          [10, 25, 50,100, "All"]
        ],
        responsive: true,
    	"language": {  
    		search: '',
			"searchPlaceholder": "Search ",
    	},
    	"columnDefs": [ {
    		"targets": -1,
    		"orderable": false
    	} ],
    	initComplete: function () {
         	var column = this.api().column(2);
			var select = $('<select id="selectFilter" class="form-control" name="retailer"><option value="">Select category </option></select>')
			.appendTo( $('#categoryDiv').empty().text('') )
			.on( 'change', function () {
				var val = $.fn.dataTable.util.escapeRegex(
					$(this).val()
				);
			column
			.search( val ? '^'+val+'$' : '', true, false )
			.draw();

			} );
			column.data().unique().sort().each( function ( d, j ) {
			select.append( '<option value="'+d+'">'+d+'</option>' );
			} );
        }
    });
 });   
 
 
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                videos: {!! json_encode($videos) !!}
            },
            mounted() {

            },
            methods: {
                
                clickEditVideo(id) {
                    window.location = "{{url('doom-yoga/edit_video')}}/"+id
                },
                clickDeleteVideo(id){console.log("delete video "+id)
                
                    $('#delete-video-modal').modal('show')
                    $('#delete-video-modal #videoId').val(id);
                },
            }
        });
</script>
@endsection
