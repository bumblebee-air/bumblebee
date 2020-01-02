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
        #load-more {
            text-align: center;
        }
        .status-tick {
            width: 15px;
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
            });
        });
    </script>
@endsection