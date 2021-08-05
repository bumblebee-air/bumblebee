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

<style>
.spotifyapp {
	height: 600px;
	width: 100%;
	display: flex;
	position: relative;
	color: white;
	margin: 0;
}

.spotifyapp  a {
	text-decoration: none;
}

.spotifyapp  ul {
	margin: 0;
	list-style: none;
	padding: 0;
}

.topbar {
	position: absolute;
	top: 0;
	height: 50px;
	background: #070707;
	left: 250px;
	width: calc(100% - 250px);
	padding: 20px;
}

.spotifySidebar {
	width: 250px;
	height: 100%;
	background: #000000;
	padding: 10px;
}

.spotifySidebar img {
	height: 60px;
	padding-left: 20px;
	margin-bottom: 20px;
}

.spotifySidebar   li {
	padding-left: 20px;
	text-transform: capitalize;
	margin-bottom: 10px;
	cursor: pointer;
	font-weight: bold;
}

.spotifySidebar #playlistsUl li {
	font-weight: normal;
	font-size: 16px;
}

.spotifySidebar  li.active {
	background-color: #797979;
}

.spotifySidebar  li.library {
	cursor: unset;
	color: #999;
	text-transform: uppercase;
	font-weight: normal;
}
/* 
.spotifySidebar  li.new-playlist {
	position: absolute;
	bottom: 80px;
} */
.spotifySidebar  li.new-playlist   i {
	margin-right: 5px;
	transform: translateY(1px);
}

}
.spotifySidebar  li.new-playlist span {
	color: #999;
	font-weight: 300;
}

.content {
	width: calc(100% - 250px);
	padding: 20px;
	background: #121212;
	margin-top: 50px;
}

.playbar {
	position: absolute;
	bottom: 0;
	left: 0;
	width: 100%;
	height: 75px;
	background: #282828;
	z-index: 99;
	padding: 10px;
}

hr {
	border-color: #9b9b9b
}

/* .sidebar-wrapper {
	position: relative;
	overflow: auto;
	width: 260px;
	z-index: 4;
	padding-bottom: 30px;
} */
.playlist-title {
	font-size: 20px;
	color: white;
}

table {
	border-collapse: collapse;
	width: 100%;
	margin-top: 15px;
	font-size: initial;
}

table tr:not(:last-of-type) {
	border-bottom: 1px solid #282828;
}

table td {
	padding: 10px 0;
}

td img {
	width: 70px;
}

#current-track-name {
	font-size: 14px;
	font-weight: 500;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 1;
	line-height: 1rem;
	height: 1rem;
	margin-bottom: 0;
	overflow: hidden;
}

#current-track-artist {
	font-size: 12px;
	font-weight: 300;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 1;
	line-height: 1rem;
	height: 1rem;
	overflow: hidden;
}

.progress {
	border: 0.15em solid #eee;
	height: 1em;
}

.progress__bar {
	background-color: #888;
	border: 0.1em solid transparent;
	height: 0.75em;
}

.playPauseButton .playing i:before {
	content: "\f28B"
}

.playPauseButton .paused i:before {
	content: "\f144"
}

.btn-play {
	background: none;
	box-shadow: none;
	border: none;
	color: white;
	font-size: 20px;
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

				<div class="row">
					<div class="spotifyapp">
						<div class="topbar"></div>
						<div class="spotifySidebar sidebar-wrapper">
							<img src="{{asset('images/doom-yoga/spotify-white.png')}}"
								style="height: 50px" alt="DoomYoga">

							<ul>
								<li class="active">Home</li>
								<li>Favorites</li>

								<li class="new-playlist"><i class="fa fa-plus-circle"></i> <span>New
										Playlist</span></li>
							</ul>
							<hr>
							<!--  -->
							<div data-spy="scroll" data-target="#playlistsUl"
								data-offset="50">
								<ul id="playlistsUl" class="overflow-auto "
									style="max-height: 320px">


								</ul>
							</div>
						</div>
						<div class="content" data-spy="scroll"
							data-target="#playlistTracksTable" data-offset="50">
							<div class="playlist-title"></div>

							<div id="playlistTracksTable" class="overflow-auto "
								style="max-height: 400px">
								<table>
									<thead>
										<tr>
											<td>#</td>
											<td>Title</td>
											<td>Album</td>
											<td>Date Added</td>
											<td><i class="far fa-clock"></i></td>
										</tr>
									</thead>

									<tbody>

									</tbody>
								</table>
							</div>
						</div>
						<div class="playbar">
							<div class="row">
								<div class="col-md-3">
									<div class="row">
										<div class="col-4">
											<img id="current-track" style="width: 60px" />
										</div>
										<div class="col-8 px-0 py-3">
											<p id="current-track-name"></p>
											<p id="current-track-artist"></p>
										</div>
									</div>
								</div>
								<div class="col-md-7 text-center">
									<button class="btn-play" onclick="clickPreviousTrack()">
										<i class="fas fa-step-backward"></i>
									</button>
									<button class="btn-play playPauseButton" onclick="clickPlayPauseTrack()"
										>
										<i class="fas fa-play-circle"></i>
									</button>
									<span class="now-playing__status"></span>
									<button class="btn-play" onclick="clickNextTrack()">
										<i class="fas fa-step-forward"></i>
									</button>
									<div class="progress">
										<div class="progress__bar" style=""></div>
									</div>
								</div>
								<div class="col-md-2 p-3">
									<div style="float: right">
										<i class="fas fa-volume-up"></i> <input type="range" min="0"
											max="100" value="50" class="slider" id="myRange">
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>




				<div class="row mx-0 mb-1 text-center">



					<!-- 					<iframe -->
					<!-- 						src="https://open.spotify.com/embed/playlist/6ZaLoqQ3NYG3Coq3Jd3YUy" -->
					<!-- 						width="500" height="450" frameBorder="0" allowtransparency="true" -->
					<!-- 						allow="encrypted-media" style="margin: auto;"></iframe> -->

				</div>

			</div>
		</div>
	</div>


</div>
@endsection @section('scripts')
<script src="https://sdk.scdn.co/spotify-player.js"></script>

<script type="text/javascript">
        
   
   const hash = window.location.hash
        .substring(1)
        .split('&')
        .reduce(function (initial, item) {
          if (item) {
            var parts = item.split('=');
            initial[parts[0]] = decodeURIComponent(parts[1]);
          }
          return initial;
        }, {});

    window.location.hash = "";   
   
const authEndpoint = 'https://accounts.spotify.com/authorize';

// Replace with your app's client ID, redirect URI and desired scopes
const clientId = '67951e40953545c2b2b6115b313010e6';     
//const redirectUri = 'http://localhost/bumblebee/public/doom-yoga/customer/music_library';
const redirectUri = 'https://doomyoga.bumblebeeai.io/doom-yoga/customer/music_library';
const scopes = [
  'streaming','playlist-read-private',
  'user-read-private',
  'user-modify-playback-state',
  'user-read-currently-playing',
  'user-read-recently-played',
  'user-read-playback-state',
  'user-top-read',
  'user-modify-playback-state',
   'user-read-email', 
  
];


//   const token = 'BQAuY2Ps5rz76xx2KbQHugSWci4V-EUdvvtKDd74EvrCHmLGTpX7UWgl9aqFPOmDQSEdYBDr-esYqOBDNN0o0IXiVmi75ZU0a5QBLbGz0YcY-qiR7qeQD4gQ26q97xANg4s3Cvsf9tW8GMvKb2u28P9ULW2j23le';
//   const token2 = 'BQD6Cok_XlDSQi2ntf9684r7VXMbMWewf873rOBNJJWQWw1AiaprlndrS3GYVUlDnhCOtZMM78vGyX-QQTnzYt3zqCo0rXwWMtUQC8Ngc-FchI5my2gTxDqnZi7Ie5-RgM3iUIgPO5FyV2hj5W4KI7pAHw';
  
console.log(hash)
    var token = hash.access_token;
   // token = 'BQAuY2Ps5rz76xx2KbQHugSWci4V-EUdvvtKDd74EvrCHmLGTpX7UWgl9aqFPOmDQSEdYBDr-esYqOBDNN0o0IXiVmi75ZU0a5QBLbGz0YcY-qiR7qeQD4gQ26q97xANg4s3Cvsf9tW8GMvKb2u28P9ULW2j23le';
  
  console.log(token)
// If there is no token, redirect to Spotify authorization
if (!token) {
  window.location = `${authEndpoint}?client_id=${clientId}&redirect_uri=${redirectUri}&scope=${scopes.join('%20')}&response_type=token&show_dialog=true`;
}   
  console.log(token)
      
 var deviceId, currentTrack;				 
 
window.onSpotifyWebPlaybackSDKReady = () => {
  const player = new Spotify.Player({
    name: 'Web Playback SDK Quick Start Player',
    getOAuthToken: cb => { cb(token); },
    
  });

  // Error handling
  player.addListener('initialization_error', ({ message }) => { console.error(message); });
  player.addListener('authentication_error', ({ message }) => { console.error(message); });
  player.addListener('account_error', ({ message }) => { console.error(message); });
  player.addListener('playback_error', ({ message }) => { console.error(message); });

 
   // Playback status updates
  player.on('player_state_changed', state => {
    console.log(state)
    $('#current-track').attr('src', state.track_window.current_track.album.images[0].url);
    $('#current-track-name').text(state.track_window.current_track.name);state.track_window.current_track.artists[0].name
    $('#current-track-artist').text(state.track_window.current_track.artists[0].name);
    
    currentTrack = state;
    
    $(".now-playing__status").html(state.paused ? 'Paused' : 'Playing');
    
    if(state.paused){
    	$(".playPauseButton").removeClass("played");
    	$(".playPauseButton").addClass("paused");
    	$(".playPauseButton").html('<i class="fas fa-play-circle"></i>')
    }else{
    	$(".playPauseButton").removeClass("paused");
    	$(".playPauseButton").addClass("played");
    	$(".playPauseButton").html('<i class="fas fa-pause-circle"></i>')
    	
    }
    
    console.log(state.position* 100/state.duration)
    $(".progress__bar").css("width",state.position* 100/state.duration+'%')
    
    let {
    current_track,
    next_tracks: [next_track]
  } = state.track_window;

  //mainContainer.innerHTML = template(state.track_window.current_track);
  //console.log('Currently Playing', current_track);
  //console.log('Playing Next', next_track);
  });

  
  var previousResponse = null;
  
  // Ready
  player.addListener('ready', ({ device_id }) => {
    console.log('Ready with Device ID', device_id);
    deviceId = device_id;
    
    //setTimeout( play(device_id),6000);
    // Play a track using our new device ID
  // play(device_id);
   getPlaylists(device_id)
  });


  // Not Ready
  player.addListener('not_ready', ({ device_id }) => {
    console.log('Device ID has gone offline', device_id);
  });
  // Connect to the player!
 player.connect().then(success => {
  if (success) {
    console.log('The Web Playback SDK successfully connected to Spotify!');
  }
	});
	
player.disconnect().then(success => {
  if (success) {
    console.log('The Web Playback SDK successfully disconnected to Spotify!');
    
  }
	});	
}

//https://open.spotify.com/track/1zTQ15oZLmBb93cIXYvUnF?si=b982397f1ece4e3f
// Play a specified track on the Web Playback SDK's device ID
function play(device_id) {
  $.ajax({
   url: "https://api.spotify.com/v1/me/player/play?device_id=" + device_id,
   type: "PUT",
   data: JSON.stringify({uris:  ["spotify:track:4t4wCwf3lJI9tW9toT2nBw","spotify:track:1zTQ15oZLmBb93cIXYvUnF"]}),
   
   headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer '+token
          },success: function(data) { 
   		console.log("play action")
     console.log(data)
   },error: function(data) {
   	console.log('error')
   }
  });
}
function getPlaylists(device_id) {
			
  $.ajax({
   url: "https://api.spotify.com/v1/users/kamellia/playlists?limit=50&offset=0",
   type: "GET",
   beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer ' + token );},
   success: function(data) { 
     console.log(data.items);
     
     $("#playlistsUl").html('');
     
     for(var i=0; i<data.items.length; i++){
     	if(!data.items[i].public){
     		$("#playlistsUl").append('<li onclick="getTracksOfPlaylist(\''
     						+data.items[i].id +'\' , \'' + data.items[i].name
     						+ '\')">' + data.items[i].name + '</li>')
     	}
     }
     
     
   }
  });
}

var tracksOfPlaylist =[];

function getTracksOfPlaylist(playlist_id, playlist_name){
console.log("get tracks of playlist "+playlist_id);
	
	tracksOfPlaylist =[];
			
  $.ajax({
   url: "https://api.spotify.com/v1/playlists/"+playlist_id+"/tracks",
   type: "GET",
   beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer ' + token );},
   success: function(data) { 
     console.log("get tracks of playlist ajax")
     console.log(data);
     $(".playlist-title").html(playlist_name);
     
     $('tbody').html('');
     
     for(var i=0; i<data.items.length; i++){
     	$('tbody').append('<tr onclick="playTrack(\''+i+'\')" > <td>'+(i+1)+' </td><td> <img src="'
     	+data.items[i].track.album.images[0].url+'" /> <p> '
     	+ data.items[i].track.name  +'<br>'+ data.items[i].track.artists[0].name
     	+ ' </td><td>'+data.items[i].track.album.name+' </p> </td><td>'
     	+ new Date(data.items[i].added_at).toDateString() +' </td><td>'
     	+ millisToMinutesAndSeconds(data.items[i].track.duration_ms) +' </td>   </tr>');
     	
     	tracksOfPlaylist.push("spotify:track:"+data.items[i].track.id);
     }
    // console.log(tracksOfPlaylist)
     
   }
  });
  
}

function playTrack(trackId){
var track = "spotify:track:"+trackId
 $.ajax({
   url: "https://api.spotify.com/v1/me/player/play?device_id=" + deviceId,
   type: "PUT",
  // data: JSON.stringify({uris:  [track]}),
   
   data: JSON.stringify({uris:  tracksOfPlaylist, "offset": {position: trackId} }),
   
   headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer '+token
          },success: function(data) { 
   		console.log("play action "+trackId)
     console.log(data)
   },error: function(data) {
   	console.log('error')
   }
  });

}

function clickPlayPauseTrack(){
console.log("click play pause");
console.log($(".now-playing__status").text());

var trackStatus = $(".now-playing__status").text();
    if(trackStatus==='Playing'){
    	 $.ajax({
           url: "https://api.spotify.com/v1/me/player/pause?device_id=" + deviceId,
           type: "PUT",   
           headers: {
                      'Content-Type': 'application/json',
                      'Authorization': 'Bearer '+token
                  },success: function(data) { 
           		console.log("click play pause action")
             console.log(data)
           },error: function(data) {
           	console.log('error')
           }
          });
    }
    else{
    	 $.ajax({
           url: "https://api.spotify.com/v1/me/player/play?device_id=" + deviceId,
           type: "PUT",   
           headers: {
                      'Content-Type': 'application/json',
                      'Authorization': 'Bearer '+token
                  },success: function(data) { 
           		console.log("click pause play action")
             console.log(data)
           },error: function(data) {
           	console.log('error')
           }
          });
    }
}

function clickNextTrack(){
	 $.ajax({
           url: "https://api.spotify.com/v1/me/player/next?device_id=" + deviceId,
           type: "POST",   
           headers: {
                      'Content-Type': 'application/json',
                      'Authorization': 'Bearer '+token
                  },success: function(data) { 
           		console.log("click next action")
             console.log(data)
           },error: function(data) {
           	console.log('error')
           }
          });
}
function clickPreviousTrack(){
	 $.ajax({
           url: "https://api.spotify.com/v1/me/player/previous?device_id=" + deviceId,
           type: "POST",   
           headers: {
                      'Content-Type': 'application/json',
                      'Authorization': 'Bearer '+token
                  },success: function(data) { 
           		console.log("click previous action")
             console.log(data)
           },error: function(data) {
           	console.log('error')
           }
          });
}

$(document).ready(function(){


$("#myRange").on("input", function() {
  console.log("slider", this.value);
  
  $.ajax({
   url: "https://api.spotify.com/v1/me/player/volume?device_id=" + deviceId+"&volume_percent="+ this.value,
   type: "PUT",
   headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer '+token
          },success: function(data) { 
   		console.log("volume action")
     console.log(data)
   },error: function(data) {
   	console.log('error')
   }
  });
  
  
})

});


function millisToMinutesAndSeconds(millis) {
  var minutes = Math.floor(millis / 60000);
  var seconds = ((millis % 60000) / 1000).toFixed(0);
  return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}

</script>

@endsection
