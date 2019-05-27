@extends('templates.aviva')

@section('page-styles')
    <link href="{{asset('css/chat.css')}}" rel="stylesheet">
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
          <div class="card">
              <div class="card-header">
                Chat with the driver
              </div>
              <div class="card-body">
                <form id="customer-chat" method="POST">
                    {{ csrf_field() }}
                    <!--<h3>Send a message to the driver</h3>-->
                    <div style="/*background-color: #e3e3e3*/margin-bottom: 20px;" id="chat-area chat">
                        <span id="chat-area-end" style="display: none"></span>
                    </div>
                    <div class="form-label-group">
                        <label for="message">Message</label>
                        <input id="message" class="form-control" name="message" autocomplete="off">
                    </div>
                    <!--<section>
                        <div id="messages"></div>
                        <input id="chat-input" type="text" class="form-control" placeholder="say anything" autofocus/>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>
                    </section>-->
                </form>
              </div>
              <div class="card-footer text-right">
                  <button class="btn text-uppercase" id="chat-send" style="background-color: #ebbd1d; color: #FFF;
                      padding-left: 30px; padding-right: 30px;" type="button">Send</button>
              </div>
          </div>
        </div>
        <div class="col-sm">
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>Check for DTC</h4>
                            <div id="action-buttons">
                                <button id="check-dtc" class="btn btn-lg btn-primary text-uppercase" type="button">Check</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div id="customer-emits">
                                <h4 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">OBD results</h4>
                                <span id="customer-emit-end" style="display: none"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.2/twilio-chat.min.js"></script>
    <script src="{{asset('js/socket.io.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let room = '{{$room}}';
            let socket = io('https://cartowans.westeurope.cloudapp.azure.com:4000');
            socket.emit('join room', room);

            $('button#chat-send').on('click', function(){
                //e.preventDefault(); // prevents page reloading
                let the_message = $('#message');
                if(the_message.val().trim()!=='') {
                    socket.emit('chat message', {'room': room, 'message': the_message.val()});
                    the_message.val('');
                }
                //return false;
            });

            socket.on('customer emit', function(data){
                console.log('customer emit received!');
                console.log(data);
                $('#customer-emit-end').before('<p style="font-weight: bold;">'+data+'</p>');
                if(data.toString().toLowerCase().indexOf('found dtc')!== -1){

                }
            });

            socket.on('new message', function(data){
                console.log('message received!');
                console.log(data);
                $('#chat-area-end').before('<div class="chat-bubble tri-right btm-left-in round"><div class="inner left"><p>'+data+'</p></div></div>');
            });

            $('#check-dtc').on('click', function() {
                socket.emit('remote function', {'room': room, 'command': 'dtc'});
            });
        });
    </script>
@endsection
