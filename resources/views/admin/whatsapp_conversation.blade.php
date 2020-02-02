@extends('templates.dashboard')

@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/whatsapp-chat.css')}}"/>
    <style>
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
            max-height: 400px;
            overflow-y: auto;
            background-color: #ece5dd;
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
    <div class="content">
        <div class="container-fluid">
            <div class="row card-group">
                <div class="card col-4 px-0">
                    <div id="conversations-group" class="list-group list-group-flush">
                        @foreach($conversations as $conversation)
                            <button type="button" class="list-group-item list-group-item-action rounded-0"
                                    data-user-id="{{$conversation->user_id}}"
                                    data-user-name="{{$conversation->name}}"
                                    data-user-phone="{{$conversation->phone}}">
                                {{$conversation->name}}
                                <br/>
                                {{$conversation->message}}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div id="conversation-area" class="card col-8 px-0">
                    <div id="conversation-header" class="card-header">
                        <i class="fab fa-whatsapp"></i> Whatsapp
                    </div>
                    <div id="conversation-body" class="card-body">
                        <h5 class="card-title">Select a customer to display the conversation here</h5>
                        <!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->
                    </div>
                    <div id="conversation-form-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        let customer_phone = null;

        function loadConversationMessages(user_id, page){
            $.ajax({
                url: '{{url('whatsapp-conversation')}}/'+user_id+'?is_json=1&page='+page,
                success: function(result){
                    let res = JSON.parse(result);
                    //console.log(res);
                    let prev = page-1;
                    let messages = res.messages.data.reverse();
                    let is_more = res.more;
                    let time_window = res.time_window;
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
                                    chat_body += '</div>';
                                }
                            }
                            chat_body += '</div>';
                        } else if(item.address != null && item.address != ''){
                            chat_body += '<p>' + item.address + ' <a href="https://maps.google.com/maps?q='+item.lat+','+item.lon+'" target="_blank">' +
                                'Click here to open in maps</a> </p>';
                        }
                        chat_body += '<p>' +item.message + '</p></div>';
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
                                '<div class="form-group">' + '<div class="input-group">' +
                                '<input type="text" class="form-control" placeholder="Write your message" id="message-body" name="message_body">' +
                                '<span class="input-group-btn" style="padding-right: 0">' +
                                '<button type="button" class="btn btn-fab btn-round btn-info" onclick="$(\'#attachment\').click();">' +
                                '<i class="material-icons">attach_file</i>' +
                                '</button> </span>' +
                                '<span class="input-group-btn">' +
                                '<button type="button" class="btn btn-fab btn-round btn-primary" onclick="submitConversationForm();">' +
                                '<i class="material-icons">send</i>' +
                                '</button> </span>' +
                                '</div> </div>' +
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
                }
            });
        }

        $(document).ready(function(){
            $('#conversations-group button').on('click', function (e) {
                e.preventDefault();
                let user_id = $(this).data('user-id');
                let user_name = $(this).data('user-name');
                customer_phone = $(this).data('user-phone');
                loadConversationMessages(user_id, 1);
                $('#conversations-group .list-group-item').removeClass('active');
                $(this).addClass('active');
                $('#conversation-area #conversation-header').html('<i class="fab fa-whatsapp"></i> ' + user_name);
                $('#conversation-area #conversation-body').html('<div id="load-more"></div> <div id="chat-page-0"><h5 class="card-title"><i class="fa fa-spin fa-sync"></i> Loading conversation</h5></div>');
                $('#conversation-area #conversation-form-container').html('').removeClass('card-footer');
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
    </script>
@endsection