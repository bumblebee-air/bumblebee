@extends('templates.dashboard') @section('title', 'Do OmYoga ')
@section('page-styles')
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.0/css/lightgallery.min.css"
	rel="stylesheet">
<link
	href="https://sachinchoolur.github.io/lightGallery/lightgallery/css/lightgallery.css"
	rel="stylesheet">

<link
	href="http://jongacnik.github.io/slick-lightbox/gh-pages/bower_components/slick-carousel/slick/slick.css"
	rel="stylesheet">
<link
	href="http://jongacnik.github.io/slick-lightbox/gh-pages/bower_components/slick-carousel/slick/slick-theme.css"
	rel="stylesheet">
<link
	href="http://jongacnik.github.io/slick-lightbox/dist/slick-lightbox.css"
	rel="stylesheet">
<style>
body {
	background-color: #f9f9fa
}

.flex {
	-webkit-box-flex: 1;
	-ms-flex: 1 1 auto;
	flex: 1 1 auto
}

.card {
	position: relative;
	display: flex;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	background-color: #aaa;
	background-clip: border-box;
	border: 1px solid #d2d2dc;
	border-radius: 0
}

.card .card-body {
	padding: 1.25rem 1.75rem
}

.card-body {
	flex: 1 1 auto;
	padding: 0 !important;
}

.card .card-title {
	color: #000000;
	margin-bottom: 0.625rem;
	text-transform: capitalize;
	font-size: 0.875rem;
	font-weight: 500
}

p {
	font-size: 0.875rem;
	margin-bottom: .5rem;
	line-height: 1.5rem
}

.lightGallery {
	width: 100%;
	margin: 0
}

.row {
	display: flex;
	flex-wrap: wrap;
	margin-right: -15px;
	margin-left: -15px
}

.lightGallery .image-tile {
	position: relative;
	margin-bottom: 30px;
}

.lightGallery .image-tile .demo-gallery-poster {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0
}

.lightGallery .image-tile .demo-gallery-poster img {
	display: block;
	margin: auto;
	width: 40%;
	max-width: 60px;
	min-width: 20px;
	margin-top: 80px
}

.lg-backdrop.in {
	opacity: 0.5;
}

.fixed-size.lg-outer .lg-inner {
	background-color: #000;
}

.fixed-size.lg-outer .lg-sub-html {
	position: absolute;
	text-align: left;
}

.fixed-size.lg-outer .lg-toolbar {
	background-color: #000;
	height: 0;
}

.fixed-size.lg-outer .lg-toolbar .lg-icon {
	color: #FFF;
}

.fixed-size.lg-outer .lg-img-wrap {
	padding: 12px;
}
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
								<div class="page-content page-container" id="page-content">
									<div class="padding">
										<div
											class="row container d-flex justify-content-center m-0 p-0">
											<div class="col-lg-12">
												<div class="">
													<div class="card-body">
														<h4 class="card-title">light video gallary</h4>
														<p class="card-text">Click on any image to open video in
															lightbox gallery</p>
														<div id="lightgallery" class="row lightGallery ">
															<a href="{{asset('images/wheat-field.mp4')}}"
																class="image-tile col-md-3" data-abc="true"><img
																src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1533639162/sample.jpg"
																alt="image small">
																<div class="demo-gallery-poster">
																	<img
																		src="http://www.urbanui.com/fily/template/images/lightbox/play-button.png"
																		alt="image">
																</div> </a> <a
																href="https://www.youtube.com/watch?v=YW3q59Kn42M"
																class="image-tile col-md-3" data-abc="true"><img
																src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1556030070/desktop-1985856_640.jpg"
																alt="image small">
																<div class="demo-gallery-poster">
																	<img
																		src="http://www.urbanui.com/fily/template/images/lightbox/play-button.png"
																		alt="image">
																</div> </a> <a
																href="https://www.youtube.com/watch?v=y0yUXWjwYh4"
																class="image-tile col-md-3" data-abc="true"><img
																src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1533641246/billing_invoicing_finance_copy-720x360.png"
																alt="image small">
																<div class="demo-gallery-poster">
																	<img
																		src="http://www.urbanui.com/fily/template/images/lightbox/play-button.png"
																		alt="image">
																</div> </a> <a
																href="https://www.youtube.com/watch?v=_EZbYkmkSoY"
																class="image-tile col-md-3" data-abc="true"><img
																src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1556030102/home-office-336373_640.jpg"
																alt="image small4">
																<div class="demo-gallery-poster">
																	<img
																		src="http://www.urbanui.com/fily/template/images/lightbox/play-button.png"
																		alt="image">
																</div> </a>
														</div>

														<div class="mt-5">
															<div style="display: none;" id="video1">
																<video class="lg-video-object lg-html5" controls
																	preload="none">
																	<source src="{{asset('images/wheat-field.mp4')}}"
																		type="video/mp4">
																	Your browser does not support HTML5 video.
																</video>
															</div>
															<div style="display: none;" id="video2">
																<video class="lg-video-object lg-html5" controls
																	preload="none">
																	<source src="{{asset('images/wheat-field.mp4')}}"
																		type="video/mp4">
																	Your browser does not support HTML5 video.
																</video>
															</div>

															<!-- data-src should not be provided when you use html5 videos -->
															<ul id="html5-videos" class="list-unstyled row">
																<li class="col-xs-6 col-sm-4 col-md-3 video"
																	data-sub-html="video caption1" data-html="#video1"><video
																		style="width: 100%; height: 200px">
																		<source src="{{asset('images/wheat-field.mp4')}}"
																			type="video/mp4">
																		Your browser does not support HTML video.
																	</video></li>
																<li class="col-xs-6 col-sm-4 col-md-3 video"
																	data-poster="{{asset('images/doom-yoga/doom-yoga-logo.png')}}"
																	data-sub-html="video caption2" data-html="#video2">
																	<img src="{{asset('images/doom-yoga/successfully.png')}}" />
																	</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>



								<div class="row mt-4 mx-2" id="video">
									<div class="col-xs-4">
										<div data-link="{{asset('images/wheat-field.mp4')}}#"
											class="thumbnail">
											<img
												src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1533639162/sample.jpg"
												alt="">
										</div>
									</div>
									<div class="col-xs-4">
										<a data-link="https://www.youtube.com/embed/YW3q59Kn42M"
											rel="noopener" class="thumbnail"><img
											src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1556030070/desktop-1985856_640.jpg"
											alt="">
											<p>ss</p></a>
									</div>
									<div class="col-xs-4">
										<a data-link="https://www.youtube.com/embed/y0yUXWjwYh4"
											rel="noopener" class="thumbnail"><img
											src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1533641246/billing_invoicing_finance_copy-720x360.png"
											alt=""></a>
									</div>
									<div class="col-xs-4">
										<a
											data-link="https://player.vimeo.com/external/138504815.sd.mp4?s=8a71ff38f08ec81efe50d35915afd426765a7526&profile_id=112"
											rel="noopener" class="thumbnail"><img
											src="https://res.cloudinary.com/dxfq3iotg/image/upload/c_scale,h_241,w_241/v1556030102/home-office-336373_640.jpg"
											alt=""></a>
									</div>
								</div>

								<div class="mt-4 mx-3">
									<div id="lightgallery2" class="row lightGallery ">
										<div class="image-tile col-md-3" onclick="clickItem(0)">
											<video style="width: 100%; height: 200px"
												data-link="{{asset('images/wheat-field.mp4')}}">
												<source src="{{asset('images/wheat-field.mp4')}}"
													type="video/mp4">
												Your browser does not support HTML video.
											</video>
										</div>
										<div class="image-tile col-md-3" onclick="clickItem(1)">
											<video style="width: 100%; height: 200px">
												<source src="{{asset('images/wheat-field.mp4')}}"
													type="video/mp4">
												Your browser does not support HTML video.
											</video>
										</div>
										<div class="image-tile col-md-3" onclick="clickItem(2)">
											<video style="width: 100%; height: 200px">
												<source src="{{asset('images/wheat-field.mp4')}}"
													type="video/mp4">
												Your browser does not support HTML video.
											</video>
										</div>
										<div class="image-tile col-md-3" onclick="clickItem(3)">
											<video style="width: 100%; height: 200px">
												<source src="{{asset('images/wheat-field.mp4')}}"
													type="video/mp4">
												Your browser does not support HTML video.
											</video>
										</div>
									</div>
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
<script
	src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1556817331/lightgallery-all.min.js"></script>
<script
	src="https://sachinchoolur.github.io/lightGallery/lightgallery/js/lg-fullscreen.js"></script>

<script
	src="http://jongacnik.github.io/slick-lightbox/gh-pages/bower_components/slick-carousel/slick/slick.js"></script>
<script
	src="http://jongacnik.github.io/slick-lightbox/dist/slick-lightbox.js"></script>
<script type="text/javascript">

 function clickItem(e){
 	console.log(e);
 	
 }
 
 $(document).ready(function() {
  $('video').click(function(e) {
   console.log('click video');
  //e.stopPropagation(); 
   e.preventDefault();
});
 
 $('a.thumbnail').click(function(e) {
   console.log('click');
  //e.stopPropagation(); 
});
 
 $('#video,#lightgallery2').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
  autoplaySpeed: 2000,
  arrows: true,
  dots: false,
  infinite: false
  
});

    var demo = $('#video').slickLightbox({
    	  src:'data-link',

      slick: {infinite:false}
  });
  $('#lightgallery2').slickLightbox({
    	  itemSelector:'div.image-tile > video',
    	  src:'data-link',
    	  images:false,
      slick: {infinite:false}
  });

 
 
         $('#lightgallery').lightGallery({
         	loop:false, width: '700px',
    height: '470px',
    mode: 'lg-fade',
    addClass: 'fixed-size',
     counter: false,
    download: false,
    startClass: '',
    enableSwipe: false,
    enableDrag: false,
    speed: 500
         });
  
    });
$('#html5-videos').lightGallery(); 

</script>
@endsection
