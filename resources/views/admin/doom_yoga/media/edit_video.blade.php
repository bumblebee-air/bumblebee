@extends('templates.dashboard') @section('title', 'Do OmYoga | Edit
Video') @section('page-styles')
<link
	href="{{asset('css/fileinput.min.css')}}"
	media="all" rel="stylesheet" type="text/css" />
<style>
body {
	font-family: 'Futura', Fallback, sans-serif !important;
}

.select2-container .select2-selection--single .select2-selection__rendered
	{
	color: #444 !important;
}

.fileinput {
	display: block;
	width: 50%
}

.fileinput .btn {
	width: 200px !important;
	font-size: 15px !important;
	text-transform: initial;
	padding: 15px;
}

.fileinput .thumbnail {
	width: 200px !important;
	height: 150px
}

.btn-default.btn-file, .fileinput-remove-button {
	width: 100% !important;
	font-size: 15px !important;
	text-transform: initial;
	padding: 15px;
}
@media only screen and (max-width: 992px){

.btn-default.btn-file, .fileinput-remove-button {
	width: 48% !important;
	
}
}

.file-drop-zone-title {
	font-size: 20px;
}
.kv-file-zoom {
border : none !important;
}

.file-drop-zone {
	border: none;
	min-height: auto;
	margin: 0;
	padding: 0;
}

.krajee-default.file-preview-frame {
	margin: 0;
	border: none;
	box-shadow: none;
}

.krajee-default.file-preview-frame:not(.file-preview-error):hover {
	border: none;
	box-shadow: none;
}

.krajee-default.file-preview-frame .kv-file-content, .krajee-default.file-preview-frame .kv-file-content video
	{
	width: 100% !important;
	height: auto !important;
}

.krajee-default.file-preview-frame .file-thumbnail-footer {
	height: auto
}

.krajee-default .file-footer-caption {
	margin: 0;
}

.krajee-default .file-drag-handle, .krajee-default .file-upload-indicator
	{
	display: none;
}
.file-footer-caption,.file-actions,.kv-file-remove{
display: none !important;
}
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			<form action="{{route('doomyoga_postEditVideo', 'doom-yoga')}}"
				method="POST" id="addVideoForm" enctype="multipart/form-data"
				autocomplete="off">
				{{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-icon card-header-rose row">
								<div class="col-12 col-md-8">
									<div class="card-icon">
										<img class="page_icon"
											src="{{asset('images/doom-yoga/Video.png')}}">
									</div>
									<h4 class="card-title ">Edit Video</h4>
								</div>
								<div class="col-6 col-md-4 mt-4">
									<div class="row justify-content-end"></div>
								</div>
							</div>
							<div class="card-body">
								<div class="container py-4">
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
									<!-- <div class="row">
										<div class="col-md-12 d-flex form-head pl-3 py-2">
											<span> 1 </span>
											<h5 class="formSubTitleH5">Event Details</h5>
										</div>
									</div> -->
									<div class="row">
										<input type="hidden" name="id" value="{{$video->id}}">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Title</label> <input type="text"
													class="form-control" name="title" value="{{$video->title}}" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Category</label> <select
													class="form-control" id="categorySelect" name="category">
													<option value="">Select category</option>
													@if(count($categoryList) > 0) @foreach($categoryList as
													$category)
													<option value="{{$category->id}}">{{$category->name}}</option>
													@endforeach @endif
												</select>
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-lg-4 col-md-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Thumbnail</label>
												
												<div class="file-loading">
													<input id="inputImage" type="file" name="thumbnail"
														accept="image/*">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-md-6">
											<div class="form-group bmd-form-group">
												<label class="formLabel">Video</label>
													<input type="hidden" name="duration" id="duration" value="{{$video->duration}}">	
												<div class="file-loading">
													<input id="inputVideo" type="file" name="video"
														accept="video/*">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>



					</div>


				</div>
				<div class="row text-center">
					<div class="col-12 text-center">

						<button id="addEventBtn" type="submit"
							class="btn btn-doomyoga-grey" id="">Edit</button>

					</div>
				</div>
			</form>
		</div>

	</div>
</div>
@endsection @section('page-scripts')
<!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you 
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script
	src="{{asset('js/file-input-preview/piexif.min.js')}}"
	type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script
	src="{{asset('js/file-input-preview/sortable.min.js')}}"
	type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
   3.3.x versions without popper.min.js. -->
<script
	src="{{asset('js/file-input-preview/popper.min.js')}}"></script>
<!-- the main fileinput plugin file -->
<script
	src="{{asset('js/file-input-preview/fileinput.min.js')}}"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script
	src="{{asset('js/file-input-preview/theme.js')}}"></script>
<!-- optionally if you need translation for your language then include  locale file as mentioned below (replace LANG.js with your locale file) -->
<script
	src="{{asset('js/file-input-preview/LANG.js')}}"></script>

<script src="{{asset('js/select2.min.js')}}"></script>

<script type="text/javascript">

 $(document).ready(function() {
       			
	$("#categorySelect").select2({
	  placeholder: 'Select category'
	}).val({!! $video->categoryId !!}).change();
	
	
    var urlVideo = '{{ asset($video->videoUrl) }}',
        urlImage = '{{ asset($video->posterImageUrl) }}';
	
    $("#inputVideo").fileinput({
    
    	fileActionSettings: {
                        showRemove: false,
                        showUpload: false,
                        showZoom: false,
                        showDrag: false,
                },
    	initialPreview: [urlVideo],
     	initialPreviewAsData: true,
     	 initialPreviewConfig: [
        {   
            type: "video",
            filetype: "video/mp4",
           key: 1,
            
        }, ],
   		overwriteInitial:true,
    
    	browseOnZoneClick:true,
        showZoom: false,
        showCaption: false,
        showUpload: false,
        showClose:false,
        browseClass: "btn btn-default btn-round",
        browseLabel: "Pick video",
        browseIcon: "<i class=\"fas fa-video\"></i>",
        removeClass: "btn btn-danger btn-round",
        removeLabel: "Delete",
        removeIcon: "<i class=\"fas fa-trash-alt\"></i>",
        zoomIcon: "<i class=\"fas fa-trash-alt\"></i>",
    });
    
	$('#inputVideo').on('fileloaded', function(event, file, previewId, fileId, index, reader) {
//     	console.log("fileloaded");
//     	console.log(file);
    	var myVideoPlayer =document.getElementsByClassName('file-preview-video')[0];
    	myVideoPlayer.addEventListener('loadedmetadata', function () {
    	
    	$("#duration").val(durationToFormat(myVideoPlayer.duration))
    	});
	});

    $("#inputImage").fileinput({
    
    	fileActionSettings: {
                        showRemove: false,
                        showUpload: false,
                        showZoom: false,
                        showDrag: false,
                },
    	initialPreview: [urlImage],
     	initialPreviewAsData: true,
     	
    	browseOnZoneClick:true,
        showZoom: false,
        showCaption: false,
        showUpload: false,
        showClose:false,
        browseClass: "btn btn-default btn-round",
        browseLabel: "Pick image",
        browseIcon: "<i class=\"fas fa-image\"></i>",
        removeClass: "btn btn-danger btn-round",
        removeLabel: "Delete",
        removeIcon: "<i class=\"fas fa-trash-alt\"></i>",
// 		layoutTemplates: {footer: '<div class="file-thumbnail-footer">\n' +
// 					'    <div class="file-caption-name">{caption}</div>\n </div>',},
        //previewThumbTags
    });
});
    

function durationToFormat(d){
	var sec_num = parseInt(d, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+' h '+minutes+' min '+seconds+' sec';

}    
</script>
@endsection
