 @extends('templates.doom_yoga') @section('title', 'Doom Yoga |
Meditation Library') @section('styles')

<style>
body {
	height: inherit;
}

#containerPageBackgrundDiv {
	background-image: none !important;
	background-color: #dedede !important;
}

#myVideo {
	object-fit: cover;
	width: 100vw;
	height: 100vh;
	position: fixed;
	right: 0;
	bottom: 0;
	min-width: 100%;
	min-height: 100%;
}

.main {
	padding-top: 40px !important;
}
</style>

<style>
/* Desktop
================================================== */
.container {
	position: relative;
	margin: 0 auto !important;
	width: 700px;
}

.column {
	width: inherit;
}

/* Tablet (Portrait)
================================================== */
@media only screen and (min-width: 768px) and (max-width: 959px) {
	.container {
		width: 95%;
	}
}

/* Mobile (Portrait)
================================================== */
@media only screen and (max-width: 767px) {
	.container {
		width: 100%;
	}
}

/* Mobile (Landscape)
================================================== */
@media only screen and (min-width: 480px) and (max-width: 767px) {
	.container {
		width: 95%;
	}
}

/* CSS Reset
================================================== */
html, body, div, span, h1, h6, p, a, ul, li, audio {
	border: 0;
	font: inherit;
	font-size: 100%;
	margin: 0;
	padding: 0;
	vertical-align: baseline;
}

body {
	line-height: 1;
}

ul {
	list-style: none;
}

/* Basic Styles
================================================== */

/* Typography
================================================== */
h1, h6, p {
	color: #808080;
	font-weight: 200;
}

h1 {
	font-size: 42px;
	line-height: 44px;
	margin: 20px 0 0;
}

h6 {
	font-size: 18px;
	line-height: 20px;
	margin: 4px 0 20px;
}

p {
	font-size: 18px;
	line-height: 20px;
	margin: 0 0 2px;
}

/* Links
================================================== */
a, a:visited {
	color: #ddd;
	outline: 0;
	text-decoration: underline;
}

a:hover, a:focus {
	color: #bbb;
}

p a, p a:visited {
	line-height: inherit;
}

/* Misc.
================================================== */
.add-bottom {
	margin-bottom: 20px !important;
}

.left {
	float: left;
}

.right {
	float: right;
}

.center {
	text-align: center;
}

/* Custom Styles
================================================== */

/* CSS Transitions */
* {
	-moz-transition: all 100ms ease;
	-o-transition: all 100ms ease;
	-webkit-transition: all 100ms ease;
	transition: all 100ms ease;
}

/* Highlight Styles */
::selection {
	background-color: #262223;
	color: #444;
}

::-moz-selection {
	background-color: #262223;
	color: #444;
}

/* Audio Player Styles
================================================== */

/* Default / Desktop / Firefox */
audio {
	margin: 0 15px 0 14px;
	width: 98%;
}

#mainwrap { /* add box-shadow or other styles here */
	
}

#audiowrap {
	/* background-color: #231F20; */
	margin: 0 auto;
}

#plwrap {
	margin: 0 auto;
}

#tracks {
	min-height: 65px;
	position: relative;
	text-align: center;
	text-decoration: none;
	top: 3px;
}

#nowPlay {
	display: inline;
}

#npTitle {
	margin: 0;
	padding: 21px;
	text-align: right;
}

#npAction {
	padding: 21px;
	position: absolute;
}

#plList {
	margin: 0;
}

#plList li {
	/* background-color: #231F20; */
	cursor: pointer;
	margin: 0;
	padding: 21px 0;
}

#plList li:hover {
	background-color: #00000021;
}

.plItem {
	position: relative;
}

.plTitle {
	left: 50px;
	overflow: hidden;
	position: absolute;
	right: 65px;
	text-overflow: ellipsis;
	top: 0;
	white-space: nowrap;
}

.plNum {
	padding-left: 21px;
	width: 25px;
}

.plLength {
	padding-left: 21px;
	position: absolute;
	right: 21px;
	top: 0;
}

.plSel, .plSel:hover {
	background-color: #00000021 !important;
	cursor: default !important;
}

a[id^="btn"] {
	color: #C8C7C8;
	cursor: pointer;
	font-size: 35px;
	margin: 0;
	padding: 0 15px 10px;
	text-decoration: none;
}

a[id^="btn"]:last-child {
	margin-left: -4px;
}

a[id^="btn"]:hover, a[id^="btn"]:active {
	background-color: #61616126;
}

a[id^="btn"]::-moz-focus-inner {
	border: 0;
	padding: 0;
}

/* Audio Player Media Queries
================================================== */

/* Tablet Portrait */
@media only screen and (min-width: 768px) and (max-width: 959px) {
	audio {
		width: 100%;
	}
}

/* Mobile Landscape */
@media only screen and (min-width: 480px) and (max-width: 767px) {
	audio {
		width: 85%;
	}
	#npTitle {
		width: 245px;
	}
}

/* Mobile Portrait */
@media only screen and (max-width: 479px) {
	audio {
		width: 90%;
	}
	#npTitle {
		width: 200px;
	}
}
</style>
@endsection @section('content')

<div class="container-fluid " id="app">
	<video playsinline autoplay="autoplay" muted="muted" loop="loop"
		id="myVideo">
		<source src="{{asset('videos/doom-yoga/meditation_video.mp4')}}"
			type="video/mp4">
		Your browser does not support HTML5 video.
	</video>

	<div class="main main-raised">

		<div class="h-100 row align-items-center">
			<div class="col-md-12 text-center">
				<a href="{{route('getCustomerAccount','doom-yoga')}}"><img
					src="{{asset('images/doom-yoga/Doomyoga-logo-black.png')}}"
					width="160" style="height: 150px" alt="DoomYoga"></a>
			</div>
		</div>
		<div class="container-fluid p-0">
			<div class="section mt-2 mt-md-3">
				<div class="row">
					<div class="col-md-6">
						<h4 class="accountTitle">Meditation Library</h4>
					</div>
				</div>
				<div class="row mx-0 mb-1">
					<div class="container m-0 p-0">
						<div class="column add-bottom">
							<div id="mainwrap">
								<div id="nowPlay">
									<span class="left" id="npAction">Paused...</span> <span
										class="right" id="npTitle"></span>
								</div>
								<div id="audiowrap">
									<div id="audio0">
										<audio preload id="audio1" controls="controls"
											controlsList="nodownload">Your browser does not support HTML5
											Audio!
										</audio>
									</div>
									<div id="tracks">
										<a id="btnPrev">&laquo;</a> <a id="btnNext">&raquo;</a>
									</div>
								</div>
								<div id="plwrap">
									<ul id="plList">

										<li v-for="audio in audios">
											<div class="plItem">
												<div class="plNum">@{{audio.track}}.</div>
												<div class="plTitle">@{{audio.name}}</div>
												<div class="plLength">@{{audio.length}}</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>


</div>
@endsection @section('scripts')

<script src="https://api.html5media.info/1.1.8/html5media.min.js">
</script>
<script
	src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1556817331/lightgallery-all.min.js"></script>
<script
	src="https://sachinchoolur.github.io/lightGallery/lightgallery/js/lg-fullscreen.js"></script>
<script type="text/javascript">
            
             Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                audios: {!! $audios !!},
            },
            mounted() {
            },
        });
            
            $(document).ready(function() {
                
                // html5media enables <video> and <audio> tags in all major browsers
// External File: https://api.html5media.info/1.1.8/html5media.min.js


// Add user agent as an attribute on the <html> tag...
// Inspiration: https://css-tricks.com/ie-10-specific-styles/
var b = document.documentElement;
b.setAttribute('data-useragent', navigator.userAgent);
b.setAttribute('data-platform', navigator.platform);


// HTML5 audio player + playlist controls...
// Inspiration: http://jonhall.info/how_to/create_a_playlist_for_html5_audio
// Mythium Archive: https://archive.org/details/mythium/
jQuery(function ($) {
    var supportsAudio = !!document.createElement('audio').canPlayType;
    if (supportsAudio) {
        var index = 0,
            playing = false,
            extension = '',
            tracks = {!! $audios !!},
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            audio = $('#audio1').bind('play', function () {
                playing = true;
                npAction.text('Now Playing...');
            }).bind('pause', function () {
                playing = false;
                npAction.text('Paused...');
            }).bind('ended', function () {
                npAction.text('Paused...');
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    audio.play();
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }).get(0),
            btnPrev = $('#btnPrev').click(function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').click(function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').click(function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = function (id) {
                $('.plSel').removeClass('plSel');
                $('#plList li:eq(' + id + ')').addClass('plSel');
                npTitle.text(tracks[id].track +". "+tracks[id].name);
                index = id;
                audio.src = '{{asset('')}}'+tracks[id].file;
                //audio.src =  '../../'+tracks[id].file;//mediaPath + tracks[id].file + extension;
            },
            playTrack = function (id) {
                loadTrack(id);
                audio.play();
            };
        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
        loadTrack(index);
    }
});
                
            });
                
                </script>

@endsection
