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
                    <div style="/*background-color: #e3e3e3*/margin-bottom: 20px; height: 200px; overflow: auto;" id="chat-area" class="chat-area chat">
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
                      padding-left: 30px; padding-right: 30px;" type="button" disabled="disabled">Send</button>
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
        let obd_id = null;
        let vehicle_reg = null;
        let vehicle_mid = null;
        let room = '{{$room}}';
        let socket_connected = false;
        let socket = io('https://cartowans.westeurope.cloudapp.azure.com:4000');
        socket.on('connect', () => {
            console.log('socket is connected!');
            socket.emit('join room', room);
            socket_connected = true;
            $('#chat-area-end').before('<p>You are connected!</p>');
            $('#chat-send').removeAttr('disabled');
        });

        socket.on('disconnect', (reason) => {
            console.log('socket disconnected for reason: '+reason);
            socket_connected = false;
            $('#chat-area-end').before('<p>You are disconnected!</p>');
            $('#chat-send').attr('disabled','disabled');
        });

        socket.on('reconnect', (attemptNumber) => {
            console.log('socket has reconnected!');
        });

        $(document).ready(function() {

            $('form#customer-chat').submit(function(e){
                e.preventDefault(); // prevents page reloading
                if(socket_connected) {
                    let the_message = $('#message');
                    let message_content = the_message.val();
                    if (the_message.val().trim() !== '') {
                        socket.emit('chat message', {'room': room, 'message': message_content});
                        the_message.val('');
                    }
                    $('#chat-area-end').before('<div class="chat-bubble tri-right btm-right-in round"><div class="inner right"><p>'+message_content+'</p></div></div>');
                }
                return false;
            });

            $('button#chat-send').on('click', function(){
                //e.preventDefault(); // prevents page reloading
                if(socket_connected) {
                    let the_message = $('#message');
                    let message_content = the_message.val();
                    if (the_message.val().trim() !== '') {
                        socket.emit('chat message', {'room': room, 'message': message_content});
                        the_message.val('');
                    }
                    $('#chat-area-end').before('<div class="chat-bubble tri-right btm-right-in round"><div class="inner right"><p>'+message_content+'</p></div></div>');
                }
                //return false;
            });

            socket.on('obd id', function(data){
                obd_id = data;
                $('#customer-emit-end').before('<p>OBD identified, identifying vehicle now ...</p>');
                getVehicleByObd();
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
                scrollChat();
            });

            $('#check-dtc').on('click', function() {
                if(socket_connected) {
                    socket.emit('remote function', {'room': room, 'command': 'dtc'});
                }
            });

            function requestObdId(){
                if(socket_connected) {
                    socket.emit('identify obd', {'room': room, 'request': 'id'});
                }
            }
        });

        function getVehicleByObd(){
            $.ajax({
                url: '{{url('api/vehicle-by-obd')}}',
                data: {
                    obd_id: obd_id,
                    csrfmiddlewaretoken: '{{ csrf_token() }}'
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    if(data.errr !== null){
                        let the_vehicle = data.vehicle;
                        vehicle_mid = the_vehicle.external_id;
                        $('#customer-emit-end').before('<p>Vehicle identified successfully</p>');
                    } else {
                        $('#customer-emit-end').before('<p style="color: darkred">The vehicle was not identified, ' +
                            'you can contact the support and ask them about the OBD device with this ID: '+obd_id+'</p>');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Unable to retrieve Vehicle information!<br/>"+"Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                    $('#customer-emit-end').before('<p style="color: darkred">There was an error while identifying the vehicle ' +
                        'with the following info: '+textStatus+'</p>');
                }
            });
        }

        function scrollChat(){
            $('#chat-area').animate({
                scrollTop: $('#chat-area').get(0).scrollHeight}, 1000);
        }
    </script>
@endsection
