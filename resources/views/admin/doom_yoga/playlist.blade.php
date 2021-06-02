@extends('templates.dashboard') @section('title', 'Do OmYoga ')
@section('page-styles')
<!-- bootstrap 5.x and 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
<!-- link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
<style>
</style>
@endsection @section('page-content')

<div class="content">
	<div class="container-fluid">
		<div class="container-fluid">
			{{csrf_field()}}
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon card-header-rose row">
							<div class="col-12 col-sm-6">

								<h4 class="card-title "></h4>
							</div>
							<div class="col-6 col-sm-6 mt-4">
								<div class="row justify-content-end"></div>
							</div>
						</div>
						<div class="card-body">
							<div class="container py-4">
								<div class="file-loading">
									<input id="input-20" type="file">
								</div>
							</div>
						</div>
					</div>

				</div>


			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts')<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you 
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
   3.3.x versions without popper.min.js. -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
    dialog. Bootstrap 5.x and 4.x is supported. You can also use the 3.3.x versions. -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/fileinput.min.js"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/themes/fa/theme.js"></script>
<!-- optionally if you need translation for your language then include  locale file as mentioned below (replace LANG.js with your locale file) -->
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.1/js/locales/LANG.js"></script>


<script type="text/javascript">

 $(document).ready(function() {     
 	$("#input-20").fileinput({
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Pick Image",
        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
        removeClass: "btn btn-danger",
        removeLabel: "Delete",
        removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
        uploadClass: "btn btn-info",
        uploadLabel: "Upload",
        uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
    });   
 });
</script>
@endsection
