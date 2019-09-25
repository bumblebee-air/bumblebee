@extends('templates.audio')

@section('page-styles')
<style>
  #start_button:focus {
    outline: none;
  }
  #transcript {
    font-weight:bold;
    font-size:20px;
  }
</style>
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div>
            <canvas class="centered-canvas" id="visualizer" width="400" height="400"></canvas>
            <div>
                <button id="start_button" onclick="startButton(event);" class="centered">
                    <img src="{{asset('images/microphone.png')}}" id="microphone" class="centered" title="Record Audio" />
                </button>
            </div>
            <div id="auth" class="centered-auth">
                <img id="loading-image" style="display:none" src="{{asset('images/loading.gif')}}" alt="Loading..." />
                <div class="container">
                  <div class="col-sm-12 col-md-12 col-xs-12">
                    <div id="transcript" style="display: block"></div>
                  </div>
                </div>
            </div>
            <form class="form_save_audio" method="POST" action="{{url('upload-record-file')}}" style="display:none" id="audio_file_save_form">
                {{ csrf_field() }}
                <div class="form-label-group">
                    <input type="text" id="audio_file" name="music" class="form-control" >
                </div>
            </form>
        </div>
    </div>
@endsection
@section('page-scripts')
<script type="text/javascript">
    // Track audio recording state and objects
    let recording = false;
    let recordingStream = null;
    let webAudioRecorder = null;

    // Canvas dimensions for analyser animation
    const WIDTH = 600;
    const HEIGHT = 400;
    const HEIGHT2 = HEIGHT / 2;
    let start = null;
    let audioData;
    let bufferSize;
    let analyser;
    var canvas = document.getElementById('visualizer');
    var context = document.getElementById('visualizer').getContext('2d');
    let user = null;
    const MICROPHONE_IMAGE = "{{asset('images/microphone.png')}}";
    const MICROPHONE_RECORDING_IMAGE = "{{asset('images/microphonerecording.png')}}";

    // Handle the user clicks of the recording button
    const startButton = (event) => {
        console.log('startButton');
        if (recording){
            stopRecording();
        } else {
            startRecording();
        }
    }
    
// Animate the audio analyser data using a canvas
const animationStep = (timestamp) => {
  if (recording) {
    requestAnimationFrame(animationStep);
  } else {
    // context.clearRect(0, 0, WIDTH, HEIGHT);
    return;
  }
  analyser.getByteTimeDomainData(audioData);

  // context.fillRect(0, 0, WIDTH, HEIGHT);

  // context.beginPath();
  let xIncrement = WIDTH * 1.0 / bufferSize;
  let x = 0;
  for (let i = 0; i < bufferSize; i++) {
    let v = audioData[i] / 128.0;
    let y = v * HEIGHT2;

    if (i === 0) {
      // context.moveTo(x, y);
    } else {
      // context.lineTo(x, y);
    }

    x += xIncrement;
  };
  // context.stroke();
}

const startRecording = () => {
  console.log('startRecording');
  $('#transcript').text('');
  console.log(navigator);
  // Start microphone access
  // https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
  navigator.mediaDevices.getUserMedia({audio: true, video:false}).then(function(stream) {
    console.log('getUserMedia');
    recordingStream = stream;

    const audioContext = new AudioContext();
    const audioSource = audioContext.createMediaStreamSource(stream);

    // Load the worker for the OGG encoder
    // https://github.com/higuma/web-audio-recorder-js
    webAudioRecorder = new WebAudioRecorder(audioSource, {
      workerDir: 'js/web_audio_js/',
      encoding: 'mp3',
      onEncoderLoading: (recorder, encoding) => {
        console.log('onEncoderLoading');
      },
      onEncoderLoaded: (recorder, encoding) => {
        console.log('onEncoderLoaded');
      },
      onEncodingProgress: (recorder, progress) => {
        console.log('onEncodingProgress: ' + progress);
      },
      onComplete: (recorder, blob) => {
        console.log('onComplete');
        $('#start_button').prop('disabled', true);
        $('#loading-image').show();
        persistFile(blob);
      }
    });

    webAudioRecorder.setOptions({
      timeLimit: 58, // max number of seconds for recording
      encodeAfterRecord: true, // encode the audio data after recording
      ogg: {
        bitRate: 160 // 160 Hz bitrate
      }
    });

    // Visualize the audio data
    analyser = audioContext.createAnalyser();
    analyser.fftSize = 1024;
    bufferSize = analyser.frequencyBinCount;
    audioData = new Uint8Array(bufferSize);

    // Start the recording process
    webAudioRecorder.startRecording();
    audioSource.connect(analyser);
    requestAnimationFrame(animationStep);
    recording = true;
    document.getElementById('microphone').src = MICROPHONE_RECORDING_IMAGE;

    console.log('startRecording');
  }).catch((err) => {
    console.log('getUserMedia error: ' +  JSON.stringify(err));
    recording = false;
    document.getElementById('microphone').src = MICROPHONE_IMAGE;
    alert(err.message);
  });
}

const stopRecording = () => {
  console.log('stopRecording');
  // Stop microphone access
  recordingStream.getAudioTracks()[0].stop();

  // Finish the recording and start encoding
  webAudioRecorder.finishRecording();
  recording = false;
  document.getElementById('microphone').src = MICROPHONE_IMAGE;

  console.log('Recording stopped');
}

// Upload the geneerated OGG file to cloud storage.
// https://firebase.google.com/docs/storage/web/upload-files
const persistFile = (blob) => {

  /* code for convert the audio to base64 and direct call google api - Start */
  var reader = new FileReader();
  var api_key = "{{$api_key}}";
  var config = {};
  reader.readAsDataURL(blob); 
  reader.onloadend = function() {
      var base64data = reader.result.replace(/^data:.+;base64,/, '');
      console.log(base64data);
      config.config = {
        encoding: 'MP3',  //AMR, AMR_WB, LINEAR16(for wav)
        sampleRateHertz: 44100,  //16000 giving blank result.
        languageCode: 'en-US',
        maxAlternatives: 1,
        audioChannelCount: 2,
        enableSeparateRecognitionPerChannel: false,
        enableAutomaticPunctuation: true,
        model: 'command_and_search'
      };
      config.audio = {
        content : base64data
      };

      $.ajax({
          url: 'https://speech.googleapis.com/v1p1beta1/speech:recognize?key=' + api_key,
          type: 'POST',
          dataType: "json",
          data: JSON.stringify(config),
          contentType: false,
          processData: false,
      }).done(function (response) {
        console.log(response);
        if(response.results) {
          $('#transcript').text(response.results[0].alternatives[0].transcript);
        } else {
          $('#transcript').text('Please try again');
        }
        $('#loading-image').hide();
        $('#start_button').prop('disabled', false);
      });    
  }
  
  /* code for convert the audio to base64 and direct call google api - End */


    
  /* code for create the audio file and save to local folder - Start */

  /* console.log(blob);
  var CSRF_TOKEN = $('input[name=_token]').val();
  var data = new FormData();
  data.append('file', blob);
  data.append('file_name', 'test');
  data.append('_token', CSRF_TOKEN);
  $.ajax({
      url: '{{url('upload-record-file')}}',
      type: 'POST',
      data: data,
      contentType: false,
      processData: false,
  }).done(function (response) {
      console.log(response);
      $('#transcript').text(response);
      $('#loading-image').hide();
      $('#start_button').prop('disabled', false);
  }).fail(function (response) {
      console.log(response);
  }); */

  /* code for create the audio file and save to local folder - End */
  
}
  $(document).ready(function() {
  });

</script>
@endsection
