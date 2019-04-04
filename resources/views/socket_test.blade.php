@extends('templates.main')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <form id="socket-room" method="POST">
                <h3>Enter room number</h3>
                <div class="form-label-group">
                    <label for="room">Message</label>
                    <input id="room" class="form-control" name="room">
                </div>
                <br/>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Join</button>
            </form>
            <form id="socket-test" method="POST" style="display: none;">
                {{ csrf_field() }}
                <h3>Sample Socket functionality</h3>
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
                $('form#socket-test').show();
                return false;
            });

            $('form#socket-test').submit(function(e){
                e.preventDefault(); // prevents page reloading
                let the_message = $('#message');
                socket.emit('chat message', {'room': room, 'message': the_message.val()});
                the_message.val('');
                return false;
            });

            socket.on('new message', function(data){
                console.log('message received!');
                console.log(data);
                $('#chat-area-end').before('<p>'+data+'</p>');
            });
        });
    </script>
@endsection
