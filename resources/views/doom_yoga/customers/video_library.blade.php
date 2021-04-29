@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Live
Stream Video Library') @section('styles')
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.0/css/lightgallery.min.css"
	rel="stylesheet">
<link
	href="https://sachinchoolur.github.io/lightGallery/lightgallery/css/lightgallery.css"
	rel="stylesheet">

<style>
body {
	background-color: #000
}

#containerPageBackgrundDiv {
	background-image: none !important;
}

.main {
	padding-top: 40px !important;
}

.post_wrap {
	width: 100%;
}

.pst {
	width: 100%
}
</style>
@endsection @section('content')

<div class="container-fluid " id="app">

	<div class="main main-raised">
		<div class="h-100 row align-items-center">
			<div class="col-md-12 text-center">
				<a href="{{route('getCustomerAccount','doom-yoga')}}"><img src="{{asset('images/doom-yoga/doom-yoga-logo.png')}}"
					width="160" style="height: 150px" alt="DoomYoga"></a>
			</div>
		</div>
		<div class="container-fluid">
			<div class="section mt-3">
				<div class="row">
					<div class="col-md-6">
						<h4 class="accountTitle">Live Stream Video Library</h4>
					</div>
					<div class="col-md-6 accountButtonContainerDiv" >
						<button class="btn btn-doomyoga-login btn-doomyoga-account"
							style="float: right">Sign up for next stream class</button>
					</div>
				</div>
				<div class="categoryDiv mt-3 mb-4" v-if="categories.length > 0"
					v-for="category in categories">
					<div class="row">
						<div class="col-md-6">
							<h4 class="accountSubTitle">@{{category.title}}</h4>
						</div>
						<div class="col-md-6"></div>
					</div>
					<div class="row">
						<div  class=" row post_wrap mx-0 category-videos">
							<div class="col-6 col-sm-4 col-md-3 col-lg-2 video pst"
								v-for="(video,index) in category.videos"
								:data-poster="'{{asset('')}}'+video.posterImageUrl"
								:data-sub-html="video.title" :data-html="'#video'+index">

								<img :src="'{{asset('')}}'+video.posterImageUrl" width="180"
									height="100" />
								<p class="videoTitleP mt-1 mb-0">@{{video.title}}</p>
								<p class="videoDurationP mt-0">@{{video.duration}}</p>



								<div style="display: none;" :id="'video'+index"><video
									class="lg-video-object lg-html5" controls preload="none">
									<source :src="'{{asset('')}}'+video.videoUrl" type="video/mp4">
									Your browser does not support HTML5 video.
								</video>
								</div>
							</div>


						</div>
						<div class="row mx-md-0 mt-2   w-100">
							<div class="col-md-6 offset-md-6" >
								<span class="message showAllMessageSpan"
									style="display: block;float: right;"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
@endsection @section('scripts')

<script
	src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1556817331/lightgallery-all.min.js"></script>
<script
	src="https://sachinchoolur.github.io/lightGallery/lightgallery/js/lg-fullscreen.js"></script>
<script type="text/javascript">



        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                categories: {!! $categories !!},
            },
            mounted() {
            },
        });
        
 $(document).ready(function() {
$('.category-videos').lightGallery(); 

        var windowsize = $(window).width();

$ShowHideMore = $('.post_wrap');
$ShowHideMore.each(function() {
    var $times = $(this).children('.pst');
    if (windowsize>=992 && $times.length > 7) {
        $ShowHideMore.children(':nth-of-type(n+7)').addClass('moreShown').css("display","none");;
        $('span.message').addClass('more-times').html('See all');
    }
    else  if (windowsize>=768 && $times.length > 5) {
        $ShowHideMore.children(':nth-of-type(n+5)').addClass('moreShown').css("display","none");;
        $('span.message').addClass('more-times').html('See all');
    }
    else if (windowsize>=576 && $times.length > 4) {
        $ShowHideMore.children(':nth-of-type(n+4)').addClass('moreShown').css("display","none");;
        $('span.message').addClass('more-times').html('See all');
    }
    else{
        $ShowHideMore.children(':nth-of-type(n+3)').addClass('moreShown').css("display","none");;
        $('span.message').addClass('more-times').html('See all');
    }
});

$(document).on('click', 'span.message', function() {
  var that = $(this);
  var thisParent = that.parent().parent().prev();
  console.log(thisParent)
  if (that.hasClass('more-times')) {
    thisParent.find('.moreShown').css("display","block");
    that.toggleClass('more-times', 'less-times').html('- See less');
  } else {
    thisParent.find('.moreShown').css("display","none");
    that.toggleClass('more-times', 'less-times').html('See all');
  }  
});


});

</script>

@endsection
