@extends('templates.main')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <form id="socket-room" method="POST">
                <h3>Enter support number</h3>
                <div class="form-label-group">
                    <label for="room">Number</label>
                    <input id="room" class="form-control" name="room">
                </div>
                <br/>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Join</button>
            </form>
            <div id="customer-emits" style="display: none">
                <h3>Customer logs will appear here</h3>
                <span id="customer-emit-end" style="display: none"></span>
            </div>
            <form id="customer-chat" method="POST" style="display: none;">
                {{ csrf_field() }}
                <h3>Send a message to customer</h3>
                <div style="background-color: #e3e3e3" id="chat-area">
                    <span id="chat-area-end" style="display: none"></span>
                </div>
                <div class="form-label-group">
                    <label for="message">Message</label>
                    <input id="message" class="form-control" name="message" autocomplete="off">
                </div>
                <br/>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>
            </form>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script src="{{asset('js/socket.io.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let room = null;
            let socket = io('https://cartowans.westeurope.cloudapp.azure.com:4000');

            $('form#socket-room').submit(function(e){
                e.preventDefault(); // prevents page reloading
                room = $('#room').val();
                socket.emit('join room', room);
                $(this).hide();
                $('div#customer-emits').show();
                $('form#customer-chat').show();
                return false;
            });

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
        });
    </script>
@endsection
