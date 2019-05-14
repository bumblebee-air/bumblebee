@extends('templates.main')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <div id="customer-emits">
                <h3>The driver logs will appear here</h3>
                <span id="customer-emit-end" style="display: none"></span>
            </div>
            <form id="customer-chat" method="POST">
                {{ csrf_field() }}
                <h3>Send a message to the driver</h3>
                <div style="background-color: #e3e3e3" id="chat-area">
                    <span id="chat-area-end" style="display: none"></span>
                </div>
                <div class="form-label-group">
                    <label for="message">Message</label>
                    <input id="message" class="form-control" name="message" autocomplete="off">
                </div>
                <br/>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>
                <!--<section>
                    <div id="messages"></div>
                    <input id="chat-input" type="text" class="form-control" placeholder="say anything" autofocus/>
                    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>
                </section>-->
            </form>
            <br/>
            <div id="action-buttons">
                <button id="check-dtc" class="btn btn-lg btn-primary text-uppercase" type="button">Check for DTC</button>
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

            $('form#customer-chat').submit(function(e){
                e.preventDefault(); // prevents page reloading
                let the_message = $('#message');
                socket.emit('chat message', {'room': room, 'message': the_message.val()});
                the_message.val('');
                return false;
            });

            socket.on('customer emit', function(data){
                console.log('customer emit received!');
                console.log(data);
                $('#customer-emit-end').before('<p style="font-weight: bold;">'+data+'</p>');
            });

            socket.on('new message', function(data){
                console.log('message received!');
                console.log(data);
                $('#chat-area-end').before('<p>'+data+'</p>');
            });

            $('#check-dtc').on('click', function() {
                socket.emit('remote function', {'room': room, 'command': 'dtc'});
            });
        });
    </script>
@endsection
