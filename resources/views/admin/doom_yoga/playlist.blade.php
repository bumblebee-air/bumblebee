@extends('templates.dashboard') @section('title', 'Do OmYoga ')
@section('page-styles')

<style>
.container {
	max-width: 640px;
	margin: 0 auto;
}

.video-selected {
	width: 100%;
	max-width: 640px;
	margin: 0 auto;
}

.video-iframe {
	position: relative;
	padding-bottom: 56.25%;
	padding-top: 30px;
	height: 0;
	margin-bottom: 10px;
}

.video-iframe iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

.video-thumbnails {
	margin: 0 auto;
	padding: 0;
	width: 100%;
}

.video-thumb {
	min-height: 200px;
	height: auto;
}

.video-thumb img {
	background-color: #d8d9da;
	width: 100%;
	height: 100px;
}

.video-thumb iframe {
	display: none;
}

.video-thumb, .video-selected {
	padding: 5px;
}

.video-thumb p {
	margin: 0;
	font-size: 12px;
}

.video-thumb p.name {
	margin-top: 5px;
	font-weight: bold;
}

.active {
	box-shadow: 0 0 2px #898989;
	border: 2px solid red;
}
</style>

<link
	href="http://features.hrw.org/features/HRW_2015_reports/report_files/js/plugins/royalslider/templates/assets/royalslider/royalslider.css"
	rel="stylesheet">
<link
	href="http://features.hrw.org/features/HRW_2015_reports/report_files/js/plugins/royalslider/templates/assets/royalslider/skins/default/rs-default.css"
	rel="stylesheet">
<style>
#video-gallery {
	width: 100%;
}

.videoGallery .rsTmb {
	padding: 17px;
}

.videoGallery .rsThumbs .rsThumb {
	width: 200px;
	height: 90px;
	border-bottom: 1px solid #2E2E2E;
}

.videoGallery .rsThumbs {
	width: 640px;
	padding: 0;
}

.videoGallery .rsThumb:hover {
	background: #000;
}

.videoGallery .rsThumb.rsNavSelected {
	background-color: #02874A;
	border-bottom: -color #02874A;
}

.sampleBlock {
	left: 3%;
	top: 1%;
	width: 100%;
	max-width: 400px;
}

@media screen and (min-width: 0px) and (max-width: 500px) {
	.videoGallery .rsTmb {
		padding: 6px 8px;
	}
	.videoGallery .rsTmb h5 {
		font-size: 12px;
		line-height: 17px;
	}
	.videoGallery .rsThumbs.rsThumbsVer {
		width: 100px;
		padding: 0;
	}
	.videoGallery .rsThumbs .rsThumb {
		width: 100px;
		height: 47px;
	}
	.videoGallery .rsTmb span {
		display: none;
	}
	.videoGallery .rsOverflow, .royalSlider.videoGallery {
		height: 300px !important;
	}
	.sampleBlock {
		font-size: 14px;
	}
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
								<div class="row">
									<iframe
										src="https://open.spotify.com/embed/album/5K7DDI3qXmRpsOSR6jKjTr"
										width="300" height="380" frameborder="0"
										allowtransparency="true" allow="encrypted-media"></iframe>

								</div>

								<div class="row mt-3" style="border: 1px solid grey">
									<div class="container">

										<div class="row video-thumbnails">
											<div class="video-thumb col-md-3">
												<img src="test.png">
												<p class="name">Joe Fabian '08</p>
												<p class="description">Account Director at Reval</p>
												<iframe class="iframe" width="640" height="352"
													src="https://www.youtube.com/embed/TpnPzrvJp3Y?rel=0"
													frameborder="0" allowfullscreen></iframe>
											</div>

											<div class="video-thumb col-md-3">
												<img src="test.png">
												<p class="name">Lauren Lawlor '09</p>
												<p class="description">HR Professional at Central Hudson Gas
													&amp; Electric</p>
												<iframe class="iframe" width="640" height="352"
													src="https://www.youtube.com/embed/sFcUVK6XupY?rel=0"
													frameborder="0" allowfullscreen></iframe>
											</div>

											<div class="video-thumb col-md-3">
												<img src="">
												<p class="name">Jamar Palmer '13</p>
												<p class="description">Marketing Analyst at UPS</p>
												<iframe class="iframe" width="640" height="352"
													src="https://www.youtube.com/embed/mLwqW8cG8aA?rel=0"
													frameborder="0" allowfullscreen></iframe>
											</div>
											<div class="video-thumb col-md-3">
												<img src="test.png">
												<p class="name">Aarika Friend '09</p>
												<p class="description">Assistant Project Manager at FASB</p>
												<iframe class="iframe" width="640" height="352"
													src="https://www.youtube.com/embed/f9c2ETBgJx8?rel=0"
													frameborder="0" allowfullscreen></iframe>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 video-selected">
												<div class="video-iframe">
													<iframe width="640" height="352"
														src="https://www.youtube.com/embed/TpnPzrvJp3Y?rel=0"
														frameborder="0" allowfullscreen></iframe>
												</div>

											</div>
										</div>
									</div>
								</div>

								<div class="row mt-3">
									<div id="video-gallery"
										class="royalSlider videoGallery rsDefault">
										<a class="rsImg" data-rsw="843" data-rsh="473"
											data-rsvideo="http://www.youtube.com/watch?v=HFbHRWwyihE"
											href="http://dimsemenov.com/plugins/royal-slider/img/admin-video.png">
											<div class="rsTmb">
												<h5>New RoyalSlider</h5>
												<span>by Dmitry Semenov</span>
											</div>
										</a> <a class="rsImg"
											data-rsvideo="https://vimeo.com/45830194"
											href="http://b.vimeocdn.com/ts/319/715/319715493_640.jpg">
											<div class="rsTmb">
												<h5>Stanley Piano</h5>
												<span>by Digital Kitchen</span>
											</div>
										</a>
										<div class="rsContent">
											<a class="rsImg" data-rsvideo="https://vimeo.com/31240369"
												href="http://b.vimeocdn.com/ts/210/393/210393954_640.jpg">
												<div class="rsTmb">
													<h5>I Believe I Can Fly</h5>
													<span>by sebastien montaz-rosset</span>
												</div>
											</a>
											<h3 class="rsABlock sampleBlock">Animated block, to show you
												that you can put anything you want inside each slide.</h3>
										</div>
										<a class="rsImg" data-rsvideo="https://vimeo.com/44878206"
											href="http://b.vimeocdn.com/ts/311/891/311891198_640.jpg">
											<div class="rsTmb">
												<h5>Dubstep Dispute</h5>
												<span>by Fluxel Media</span>
											</div>
										</a> <a class="rsImg"
											data-rsvideo="https://vimeo.com/45778774"
											href="http://b.vimeocdn.com/ts/318/502/318502540_640.jpg">
											<div class="rsTmb">
												<h5>The Epic &amp; The Beasts</h5>
												<span>by Sebastian Linda</span>
											</div>
										</a> <a class="rsImg"
											data-rsvideo="https://vimeo.com/41132461"
											href="http://b.vimeocdn.com/ts/284/709/284709146_640.jpg">
											<div class="rsTmb">
												<h5>Barcode Band</h5>
												<span>by Kang woon Jin</span>
											</div>
										</a> <a class="rsImg"
											data-rsvideo="hhttps://vimeo.com/44388232"
											href="http://b.vimeocdn.com/ts/308/375/308375094_640.jpg">
											<div class="rsTmb">
												<h5>Samm Hodges Reel</h5>
												<span>by Animal</span>
											</div>
										</a> <a class="rsImg"
											data-rsvideo="http://www.youtube.com/watch?v=VDspPKDMBMo"
											href="../img/video/02.jpg">
											<div class="rsTmb">
												<h5>The Foundry Showreel</h5>
												<span>by The Foundry</span>
											</div>
										</a>
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

<script src="http://features.hrw.org/features/HRW_2015_reports/report_files/js/plugins/royalslider/templates/assets/royalslider/jquery.royalslider.min.js"></script>
<script type="text/javascript">

 $(document).ready(function() {        
 	$(".video-thumb").click(function() {
          $('.video-thumb > img').removeClass("active");
          $(this).children('img').addClass("active");
        });

        $('div.video-thumb').click(function() {
          $('.video-iframe iframe').attr('src', ($(this).children('iframe').attr('src').replace('iframe')));
        });
    });
    
     $('#video-gallery').royalSlider({
    arrowsNav: false,
    fadeinLoadedSlide: true,
    controlNavigationSpacing: 0,
    controlNavigation: 'thumbnails',

    autoScaleSlider: true, 
    autoScaleSliderWidth: 960,     
    autoScaleSliderHeight: 850,
    
    loop: false,
    
    thumbs: { 
    	appendSpan: true,
      paddingBottom: 4
    },
    
    arrowsNav:true,
    arrowsNavAutoHide: true,
    arrowsNavHideOnTouch: true,
    keyboardNavEnabled: true,
    imageScaleMode: 'fill',
    imageAlignCenter:true,
    slidesSpacing: 0,
    loopRewind: true,
    numImagesToPreload: 3,
    video: {
      autoHideArrows:true,
      autoHideControlNav:false,
      autoHideBlocks: true
    }, 

    /* size of all images http://help.dimsemenov.com/kb/royalslider-jquery-plugin-faq/adding-width-and-height-properties-to-images */
    imgWidth: 680,
    imgHeight: 360

  });
</script>
@endsection
