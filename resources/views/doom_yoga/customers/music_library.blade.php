@extends('templates.doom_yoga') @section('title', 'Doom Yoga | Music
Library') @section('styles')

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
	position: relative;
	z-index: 0;
}

#app {
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
	background-color: black;
	opacity: 1;
	z-index: 1;
}

.post_wrap {
	width: 100%;
}

.pst {
	width: 100%
}
</style>
@endsection @section('content')

<div class="container-fluid " id="app" style="">
	<video playsinline autoplay="autoplay" muted="muted" loop="loop"
		id="myVideo">
		<source src="{{asset('videos/doom-yoga/music_video.mp4')}}"
			type="video/mp4">
		Your browser does not support HTML5 video.
	</video>

	<div class="main main-raised">
		<div class="h-100 row align-items-center">
			<div class="col-md-12 text-center">
				<a href="{{route('getCustomerAccount','doom-yoga')}}"><img
					src="{{asset('images/doom-yoga/doom-yoga-logo.png')}}" width="160"
					style="height: 150px" alt="DoomYoga"></a>
			</div>
		</div>
		<div class="container-fluid">
			<div class="section mt-2 mt-md-3">
				<div class="row">
					<div class="col-md-6">
						<h4 class="accountTitle">Music Library</h4>
					</div>
				</div>
				<div class="row mx-0 mb-1 text-center">
					
					<iframe
						src="https://open.spotify.com/embed/album/4H6vP0sSlRFyd4EeDhJhPV"
						width="500" height="450" frameborder="0" allowtransparency="true"
						allow="encrypted-media" style="margin: auto;"></iframe>

				</div>
			</div>
		</div>
	</div>


</div>
@endsection @section('scripts')

<script type="text/javascript">
        
 $(document).ready(function() {



});

</script>

@endsection
