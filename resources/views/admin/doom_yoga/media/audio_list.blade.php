@extends('templates.dashboard') @section('title', 'Do OmYoga | Audios')
@section('page-styles')
<style>
tr.order-row:hover, tr.order-row:focus {
	cursor: pointer;
	box-shadow: 5px 5px 18px #88888836, 5px -5px 18px #88888836;
}

audio {
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
										src="{{asset('images/doom-yoga/audio.png')}}">
								</div>
								<h4 class="card-title ">Audios List</h4>
							</div>
							<div class="col-12 col-md-4 mt-4">
								<div class="row justify-content-end">
									<a class="btn btn-doomyoga-grey btn-import"
										href="{{route('doomyoga_getAddAudio', 'doom-yoga')}}">Add
										audio</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									
									<table id="audiosTable"
										class="table table-no-bordered table-hover doomyogaTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th>Title</th>
												<th>Audio</th>
												<th>Actions</th>
											</tr>
										</thead>

										<tbody>


											<tr v-for="audio in audios" class="order-row">
												<td>@{{audio.name}}</td>
												<td><audio preload :src="'{{asset('')}}'+audio.file"
														controls="controls" controlsList="nodownload">Your browser
														does not support HTML5 Audio!
													</audio></td>
												<td><a
													class="btn  btn-link btn-primary-doorder btn-just-icon edit"
													@click="clickEditAudio(audio.id)"><i
														class="fas fa-pen-fancy"></i></a>
													<button type="button"
														class="btn btn-link btn-danger btn-just-icon remove"
														@click="clickDeleteAudio(audio.id)">
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


<!-- delete audio modal -->
<div class="modal fade" id="delete-audio-modal" tabindex="-1"
	role="dialog" aria-labelledby="delete-audio-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close d-flex justify-content-center"
					data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<div
					class="modal-dialog-header deleteHeader modalHeaderH2 mt-4 mb-5">
					<h2 id="successMessageHeaderDiv">Are you sure you want to delete
						this audio?</h2>
				</div>
				<div>

					<form method="POST" id="delete-audio"
						action="{{url('doom-yoga/delete_audio')}}"
						style="margin-bottom: 0 !important;">
						@csrf <input type="hidden" id="audioId" name="audioId" value="" />
					</form>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-around mb-2">
				<button type="button" class="btn btn-doomyoga-grey"
					onclick="$('form#delete-audio').submit()">Yes</button>
				<button type="button" class="btn btn-doomyoga-black"
					data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- end delete audio modal -->
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
     $('#audiosTable').DataTable({
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
    });
 });   
 
 
        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                audios: {!! json_encode($audios) !!}
            },
            mounted() {

            },
            methods: {
                
                clickEditAudio(id) {
                    window.location = "{{url('doom-yoga/edit_audio')}}/"+id
                },
                clickDeleteAudio(id){console.log("delete audio "+id)
                
                    $('#delete-audio-modal').modal('show')
                    $('#delete-audio-modal #audioId').val(id);
                },
            }
        });
</script>
@endsection
