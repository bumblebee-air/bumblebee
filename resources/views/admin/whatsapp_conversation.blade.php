@extends('templates.dashboard')

@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/whatsapp-chat.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/whatsapp.css')}}"/>
    <style>
        .main-panel>.content{
            margin-top: 0px;
        }
        #whatsAppKeywordModalLabel{
            font-weight: 400;
        }
        #whatsAppKeywordModal ul.keyword-container li.matched-keyword{
            padding-top: 0;
            font-size: 14px;
        }
        #conversations-group .list-group-item.active{
            /*background-color: #219631;
            border-color: #219631;*/
            background-color: #64b968;
            border-color: #64b968;
        }
        #conversation-area #conversation-header{
            background-color: #64b968;
            color: #ffffff;
            font-weight: 500;
        }
        #conversation-area #conversation-body {
            min-height: 400px;
            height: calc(100vh - 300px);
            overflow-y: auto;
            background-color: #ece5dd;
            padding: 20px 40px 10px;
        }
        #conversation-area #conversation-form-container form {
            width: 100%;
        }
        #conversation-form-container #conversation-form .btn-primary {
            background-color: #64b968;
        }
        #conversation-form-container #conversation-form .btn-primary:hover,
        #conversation-form-container #conversation-form .btn-primary:active {
            background-color: #4b914f;
        }
        #conversation-form-container #conversation-form .form-control,
        #conversation-form-container #conversation-form .is-focused .form-control{
            background-image: linear-gradient(0deg,#64b968 2px,rgba(156,39,176,0) 0),linear-gradient(0deg,#d2d2d2 1px,hsla(0,0%,82%,0) 0);
        }
        #load-more {
            text-align: center;
        }
        .status-tick {
            width: 15px;
        }
        span.remove-attachment {
            cursor: pointer;
        }
        span.remove-attachment:hover,
        span.remove-attachment:active {
            color: red;
        }
    </style>
@endsection
@section('page-content')
    <input type="hidden" name="view_csrf_token" value="{{csrf_token()}}"/>
    <div class="content">
        <div class="container-fluid">
            <div class="row conversation-blog">
                <div class="col-12 conversation-wrapper">
                    <div class="conversation-tab">
                        <!--<ul>
                            <li class="active">
                                <a href="#">Carjo</a>
                            </li>
                            <li>
                                <a href="#">emergency response</a>
                            </li>
                            <li>
                                <a href="#">intelligent protection</a>
                            </li>
                            <li>
                                <a href="#">rescue management</a>
                            </li>
                        </ul>-->
                        <select id="clients-select" class="form-control selectpicker">
                            <option value="">Select client</option>
                            @foreach($the_clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="chat-issue-list">
                            <ul>
                                <li>
                                    <a class="red" href="#">Critical
                                        <span>(4)</span>
                                    </a>
                                </li> 
                                <li>
                                    <a class="yellow" href="#">Major
                                        <span>(2)</span>
                                    </a>
                                </li> 
                                <li>
                                    <a class="green" href="#">Minor
                                        <span>(1)</span>
                                    </a>
                                </li> 
                            </ul>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row person-chat-wrapper">
                        <div class="col-4 px-0">
                            <div class="left-searchbar">
                                <div class="search-wrapper">
                                    <i class="material-icons">search</i>
                                    <input type="search" placeholder="Search or start conversation">
                                </div>
                            </div>
                            <ul id="conversations-group" class="list-group list-group-flush user-list">
                                @foreach($conversations as $conversation)
                                <li class="list-group-item-action">
                                    <a class="conversation" href="#" data-user-id="{{$conversation['message']->user_id}}"
                                            data-user-name="{{$conversation['message']->name}}"
                                            data-user-phone="{{$conversation['message']->phone}}">
                                        <!--<img src="{asset('images/user.png')}" />-->
                                        <span class="user-info"> 
                                            <span class="user-name">
                                                {{$conversation['message']->name}}
                                            </span>
                                            <span class="user-detail">
                                                <span class="time">{{$conversation['message']->time}}</span>
                                                <span class="total-msg" id="user-{{$conversation['message']->user_id}}-badge"
                                                @if($conversation['unread_count']<=0)
                                                    style="display: none"
                                                @endif >{{$conversation['unread_count']}}<span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div id="conversation-area" class="col-8 px-0">
                            <div id="conversation-header" class="person-header">
                                <div class="person-name">
                                    <i class="fab fa-whatsapp"></i> Whatsapp
                                </div>
                            </div>
                            <div id="conversation-body" class="card-body">
                                <h5 class="card-title">Select a customer to display the conversation here</h5>
                            </div>
                            <div id="conversation-form-container" class="chat-footer" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyword Modal -->
    <div class="modal fade" id="whatsAppKeywordModal" tabindex="-1" role="dialog" aria-labelledby="whatsAppKeywordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="whatsAppKeywordModalLabel">
                Matched Keywords</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <ul class="list-group keyword-container">
            <div style="padding: 0 1.25rem 10px 1.25rem; font-weight:400;" class="d-flex justify-content-between align-items-center">
                Name
                <span>Weight</span>
            </div>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script type="text/javascript">
        let customer_phone = null;

        function loadConversationMessages(user_id, page){
            $.ajax({
                url: '{{url('whatsapp-conversation')}}/'+user_id+'?is_json=1&page='+page,
                success: function(result){
                    let res = JSON.parse(result);
                    //console.log(res);
                    let prev = page-1;

                    if($('.matchedKeywordCount').length === 0)
                    {
                        $('#conversation-area #conversation-header .person-name').append('<span style="margin-left:5px;cursor:pointer;" class="badge badge-danger badge-pill matchedKeywordCount" data-toggle="tooltip" onClick="openKeywordModal('+res.countMatchedKeywords+')" data-title="'+ res.countMatchedKeywords +' keywords matched!">' + res.countMatchedKeywords + '</span>');
                        $('#whatsAppKeywordModal ul.keyword-container li.matched-keyword').remove();
                        if(res.countMatchedKeywords > 0)
                        {
                            res.matchedKeywords.forEach(keyword => {
                                $('#whatsAppKeywordModal ul.keyword-container').append('<li class="matched-keyword list-group-item d-flex justify-content-between align-items-center">'+ keyword.keyword +'<span class="badge badge-primary badge-pill">'+ keyword.weight +'</span></li>');
                            });
                        }
                    }

                    let messages = res.messages.data.reverse();
                    let is_more = res.more;
                    let time_window = res.time_window;
                    let unread_count = res.unread_count;
                    let messages_string = '<ul class="whatsapp-chat" id="chat-page-'+page+'">';
                    messages.forEach(function(item,index){
                        let chat_panel = '';
                        let chat_body = '<div class="whatsapp-chat-panel"> <div class="whatsapp-chat-body">';
                        if(item.num_of_media != null && parseInt(item.num_of_media)>0){
                            chat_body += '<div class="row">';
                            let media_types_array = item.media_types.split(',');
                            let media_array = item.media_urls.split(',');
                            let image_media_types = ['image/jpeg','image/jpg','image/png','image/bmp','image/tiff','image/gif'];
                            let audio_media_types = ['audio/ogg','audio/mpeg','audio/wav'];
                            for(let i=0; i<parseInt(item.num_of_media); i++){
                                if(image_media_types.includes(media_types_array[i])){
                                    chat_body += '<div class="col-6">';
                                    chat_body += '<a href="'+media_array[i]+'" target="_blank"><img class="img-fluid img-thumbnail" src="'+media_array[i]+'" /></a>';
                                    chat_body += '</div>';
                                } else if (audio_media_types.includes(media_types_array[i])){
                                    chat_body += '<div class="col-12">';
                                    chat_body += '<audio controls src="'+media_array[i]+'" type="'+media_types_array[i]+'">Your browser doesn\'t support audio</audio>';
                                    let the_audio_transcript = item.audio_transcript;
                                    chat_body += '<div id="audio-transcript-container-'+item.id+'">';
                                    if(the_audio_transcript!=null){
                                        chat_body += '<button class="btn btn-link" onclick="$(\'#audio-transcript-'+item.id+'\').toggle(); $(this).toggle();">Show transcript</button>' +
                                            '<p id="audio-transcript-'+item.id+'" style="display: none">'+the_audio_transcript.transcript+'</p>';
                                    } else {
                                        chat_body += '<button class="btn btn-info" onclick="translateAudioFile(\'' + media_array[i] + '\',\'' + media_types_array[i] + '\',\'' + user_id + '\',\'' + item.id + '\')">Translate audio</button>' +
                                        '<span id="audio-transcript-indicator-'+item.id+'"></span>';
                                    }
                                    chat_body += '</div>';
                                    chat_body += '</div>';
                                }
                            }
                            chat_body += '</div>';
                        } else if(item.address != null && item.address != ''){
                            chat_body += '<p>' + item.address + ' <a href="https://maps.google.com/maps?q='+item.lat+','+item.lon+'" target="_blank">' +
                                'Click here to open in maps</a> </p>';
                        }
                        chat_body += '<p>' +item.message + '</p></div>';
                        console.log("imtem from", item.from)
                            console.log("customer phone ", customer_phone);
                        if(item.from==customer_phone){
                            
                            chat_panel += '<li class="whatsapp-chat-inverted">';
                            chat_panel += chat_body;
                            //chat_panel += '<h6>' + item.from + '</h6>';
                            let chat_time = new moment(item.created_at);
                            chat_panel += '<h6> <span style="float:right">' + chat_time.format('D/M HH:mm') + '</span> </h6>';
                        } else {
                            chat_panel += '<li>';
                            chat_panel += chat_body;
                            let message_status = '';
                            if(item.status == 'read'){
                                message_status = '<img src="{{asset('images/double-tick-blue.svg')}}" class="status-tick" alt="(Read)"/>';
                            } else {
                                message_status = message_status = '<img src="{{asset('images/double-tick-grey.svg')}}" class="status-tick" alt="(Unead)"/>';
                            }
                            //chat_panel += '<h6>' + item.from + '<span style="float:right">' +message_status + '</span></h6>';
                            let chat_time = new moment(item.created_at);
                            chat_panel += '<h6> <span style="float:right">' + chat_time.format('D/M HH:mm') + ' ' + message_status + '</span></h6>';
                        }
                        chat_panel += '</div></li>';
                        messages_string += chat_panel;
                    });
                    messages_string += '</ul>';
                    $('#chat-page-'+prev.toString()).before(messages_string);
                    if(page===1){
                        $('#chat-page-'+prev.toString()).html('');
                    }
                    if(is_more===true){
                        let load_more_string = '<div id="load-more">' +
                            '<button class="btn btn-info">Load previous messages</button>' +
                            '</div>';
                        $('#load-more').html(load_more_string);
                        $('#load-more button').on('click', function(ev){
                            ev.preventDefault();
                            $('#load-more').html('<h5 class="card-title"><i class="fa fa-spin fa-sync"></i> Loading messages</h5>');
                            page = page+1;
                            loadConversationMessages(user_id, page);
                        });
                    } else {
                        $('#load-more').html('<h5 class="card-title">You\'ve reached the beginning of the conversation</h5>');
                    }
                    if(time_window === true){
                        let conv_form_check = document.getElementById('conversation-form');
                        if(conv_form_check==null) {
                            let csrf_field = '{{csrf_field()}}';
                            let form_action = '{{url('whatsapp/customer/send')}}';
                            let form_html = '<form id="conversation-form" enctype="multipart/form-data" action="' + form_action + '" method="post">' +
                                csrf_field +
                                '<input type="hidden" name="customer_id" value="' + user_id + '"/>' +
                                '<input type="file" id="attachment" name="attachment" style="display:none"/>' +
                                '<p id="attachment-info" style="display: none"></p>' +
                                '' + '<div class="input-group">' +
                                '<input type="text" placeholder="Write your message" id="message-body" name="message_body">' +
                                '<span class="input-group-btn" style="padding-right: 0">' +
                                '<a class="attach-file" onclick="$(\'#attachment\').click();"><i class="material-icons">attach_file</i></a></span>' +
                                '<span class="input-group-btn">' +
                                '<a class="btn btn-fab btn-round btn-primary" onclick="submitConversationForm();">' +
                                '<i class="material-icons">send</i>' +
                                '</a> </span>' +
                                '<a href="#" class="key-voice"><span class="material-icons">keyboard_voice</span></a>' +
                                '</div>' +
                                '</form>';
                            $('#conversation-form-container').html(form_html).addClass('card-footer');
                            $("#conversation-form").on('submit', function (e) {
                                e.preventDefault();
                                submitConversationForm();
                            });
                            $('#attachment').on('change',function(){
                                $('#attachment-info').html(this.files[0].name + '&nbsp;&nbsp;' +
                                    '<span title="Remove file" onclick="resetAttachmentField();" class="remove-attachment"><i class="far fa-times-circle"></i></span>');
                                $('#attachment-info').show();
                            });
                        }
                    } else {
                        $('#conversation-form-container').html('<h4>The 24hr time window to chat with this customer has finished</h4>').removeClass('card-footer');
                    }
                    //update unread messages count
                    let user_badge = $('#user-' + user_id + '-badge');
                    if(unread_count>0) {
                        user_badge.html(unread_count);
                    } else {
                        user_badge.hide();
                    }
                }
            });
        }

        $(document).ready(function(){

            $('#conversations-group .conversation').on('click', function (e) {
                $('li.list-group-item-action').removeClass('active');
                $(this).parents('li').addClass('active');
                e.preventDefault();
                let user_id = $(this).data('user-id');
                let user_name = $(this).data('user-name');
                customer_phone = $(this).data('user-phone');
                loadConversationMessages(user_id, 1);
                $('#conversations-group .list-group-item').removeClass('active');
                $(this).addClass('active');
                $('#conversation-area #conversation-header').html('<div class="person-name"><i class="fab fa-whatsapp"></i> '+ user_name + '</div><div class="search"><a href="#" onClick="openSearchBox(this)"><i class="material-icons">search</i></a><div class="search-wrapper"><i class="material-icons">search</i><input type="search" placeholder="Search this conversation"></div></div>');

                $('#conversation-area #conversation-body').html('<div id="load-more"></div> <div id="chat-page-0"><h5 class="card-title"><i class="fa fa-spin fa-sync"></i> Loading conversation</h5></div>');
                $('#conversation-area #conversation-form-container').html('').removeClass('card-footer');
                $('#conversation-form-container').show();
            });
        });

        function submitConversationForm() {
            let the_form = $("#conversation-form");
            let the_data = new FormData(the_form[0]);
            let message_field = $('#message-body');
            let attachment_field = $('#attachment');
            if((message_field.val()==null || message_field.val()=='') &&
                (attachment_field.val()==null || attachment_field.val()=='')){
                return false;
            }
            message_field.attr('disabled','disabled');
            message_field.parent().parent().before('<div id="sending-indicator"><i class="fas fa-sync fa-spin"></i> <p>Sending message</p></div>');
            $('#sending-status').remove();
            $.ajax({
                url: the_form.attr('action'),
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: the_data,
                success: function(result){
                    let res = JSON.parse(result);
                    if(res.fault===0) {
                        message_field.val('');
                        resetAttachmentField();
                        message_field.parent().parent().before('<div id="sending-status" style="color: forestgreen"><i class="fas fa-check"></i> <span>'+res.message+'</span></div>');
                    } else {
                        message_field.parent().parent().before('<div id="sending-status" style="color: red"><i class="fas fa-times"></i> <span>'+res.message+'</span></div>');
                    }
                },
                error: function(XMLHttpRequest, text_status, error_thrown){
                    console.log('ERROR!');
                    console.log(XMLHttpRequest);
                    console.log('Text status: ');
                    console.log(text_status);
                    console.log('Error thrown');
                    console.log(error_thrown);
                    message_field.parent().parent().before('<div id="sending-status" style="color: red"><i class="fas fa-times"></i> <span>'+text_status+': '+error_thrown+'</span></div>');
                },
                complete: function(data, status){
                    message_field.removeAttr('disabled');
                    $('#sending-indicator').remove();
                }
            });
        }
        function resetAttachmentField(){
            $('#attachment').val('');
            $('#attachment-info').html('');
            $('#attachment-info').hide();
        }

        function translateAudioFile(file_url, file_type, user_id, message_id) {
            let audio_transcript_container = $('#audio-transcript-container-'+message_id);
            let audio_transcript_indicator = $('#audio-transcript-indicator-'+message_id);
            audio_transcript_indicator.html('<i class="fas fa-spin fa-sync"></i> Retrieving audio transcript')
            let the_data = {
                'audio_file_url': file_url,
                'audio_file_type': file_type,
                'user_id': user_id,
                'message_id': message_id
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="view_csrf_token"]').val()
                },
                url: '{{url('translate-audio-url')}}',
                type: "POST",
                data: the_data,
                success: function(result) {
                    let res = JSON.parse(result);
                    if(res.success != 1){
                        audio_transcript_indicator.html('<i class="fas fa-cross"></i> Audio transcript failed with error: '+
                            res.message);
                    } else {
                        audio_transcript_container.html('<p id="audio-transcript-'+message_id+'">'+
                            res.transcript+'</p>');
                    }
                },
                error: function(XMLHttpRequest, text_status, error_thrown) {
                    console.log('ERROR!');
                    console.log(XMLHttpRequest);
                    console.log('Text status: ');
                    console.log(text_status);
                    console.log('Error thrown');
                    console.log(error_thrown);
                }
            });
        }

        function openKeywordModal(keywordCount) {
            if(parseInt(keywordCount))
            {
                $("#whatsAppKeywordModal").modal('show');
            }
        }

        function openSearchBox(obj)
        {
            if(!$(obj).parents('div.search').hasClass('search-open')){
                $(obj).parents('.search').addClass('search-open');
            } else {
                $(obj).parents('.search').removeClass('search-open');
            }
        }

        //Audio recording
        // Track audio recording state and objects
        /*let recording = false;
        let recordingStream = null;
        let webAudioRecorder = null;
        function toggleRecording(){
            console.log('toggle recording');
            if (recording){
                stopRecording();
            } else {
                startRecording();
            }
        }
        function startRecording() {
            console.log('Start Recording');
            //$('#transcript').text('');
            console.log(navigator);
            // Start microphone access
            // https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
            navigator.mediaDevices.getUserMedia({audio: true, video:false}).then(function(stream) {
                console.log('getUserMedia');
                recordingStream = stream;

                var AudioContext = window.AudioContext || window.webkitAudioContext;
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
        }*/
    </script>
@endsection