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
                <!--<div class="form-label-group">
                    <label for="message">Message</label>
                    <input id="message" class="form-control" name="message" autocomplete="off">
                </div>
                <br/>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>-->
                <section>
                    <div id="messages"></div>
                    <input id="chat-input" type="text" class="form-control" placeholder="say anything" autofocus/>
                    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Send</button>
                </section>
            </form>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.2/twilio-chat.min.js"></script>
    <script src="{{asset('js/socket.io.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let room = null;
            /*let socket = io('https://cartowans.westeurope.cloudapp.azure.com:4000');

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
            });*/

            let chat_window = $('#messages');
            let chat_client = null;
            let chat_channel = null;
            let username = 'Test username';
            $('form#socket-room').submit(function(e){
                e.preventDefault(); // prevents page reloading
                chat_channel = $('#room').val();
                $(this).hide();
                $('form#customer-chat').show();
                initializeTwilioClient();
                return false;
            });

            // Helper function to print info messages to the chat window
            function print(infoMessage, asHtml) {
                let msg = $('<div class="info">');
                if (asHtml) {
                    msg.html(infoMessage);
                } else {
                    msg.text(infoMessage);
                }
                chat_window.append(msg);
            }
            // Helper function to print chat message to the chat window
            function printMessage(fromUser, message) {
                let user = $('<span class="username">').text(fromUser + ':');
                if (fromUser === username) {
                    user.addClass('me');
                }
                let the_message = $('<span class="message">').text(message);
                let container = $('<div class="message-container">');
                container.append(user).append(the_message);
                chat_window.append(container);
                chat_window.scrollTop(chat_window[0].scrollHeight);
            }

            function initializeTwilioClient() {
                $.ajax({
                    url: '{{url('api/twilio-token')}}',
                    data: {
                        device: 'browser',
                        identity: username,
                        csrfmiddlewaretoken: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    method: 'POST',
                    success: function (data) {
                        console.log(data);
                        username = data.identity;
                        print('You have been assigned the username: '
                            + '<span class="me">' + username + '</span>', true);
                        // Initialize the Chat client
                        Twilio.Chat.Client.create(data.token).then(client => {
                            chat_client = client;
                            chat_client.getSubscribedChannels().then(getOrCreateChannel(chat_channel));
                        });
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log("Error during getting Twilio token<br/>" + "Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                    }
                });
            }
            function getOrCreateChannel(channel_name){
                chat_client.getChannelByUniqueName(channel_name)
                    .then(function(channel) {
                        chat_channel = channel;
                        console.log('Found the channel: '+channel_name);
                        console.log(chat_channel);
                        setupChannel();
                    }).catch(function() {
                    // If it doesn't exist, let's create it
                    console.log('Creating channel: '+channel_name);
                    chat_client.createChannel({
                        uniqueName: channel_name,
                        friendlyName: channel_name+' Channel'
                    }).then(function(channel) {
                        console.log('Created channel:');
                        console.log(channel);
                        chat_channel = channel;
                        setupChannel();
                    }).catch(function(channel) {
                        console.log('Channel could not be created:');
                        console.log(channel);
                    });
                });
            }

            function setupChannel() {
                // Join the general channel
                chat_channel.join().then(function(channel) {
                    print('Joined channel as '
                        + '<span class="me">' + username + '</span>.', true);
                });

                // Listen for new messages sent to the channel
                chat_channel.on('messageAdded', function(message) {
                    printMessage(message.author, message.body);
                });
            }

            // Send a new message to the general channel
            /*let input = $('#chat-input');
            input.on('keydown', function(e) {
                if (e.keyCode == 13) {
                    chat_channel.sendMessage(input.val());
                    input.val('');
                }
            });*/
            $('form#customer-chat').submit(function(e){
                e.preventDefault(); // prevents page reloading
                let input = $('#chat-input');
                chat_channel.sendMessage(input.val());
                input.val('');
                return false;
            });
        });
    </script>
@endsection
