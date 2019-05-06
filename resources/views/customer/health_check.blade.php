@extends('templates.aviva')

@section('page-styles')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">

            <header class="masthead text-center d-flex" style="height: 300px; min-height: 300px;">
                <div class="container my-auto">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <h1 class="text-uppercase">
                                <strong>Bumblebee Health Check</strong>
                            </h1>
                            <hr>
                        </div>
                    </div>
                </div>
            </header>

            <section id="services">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <h1>OBD connection</h1>

                            <div id="bth-status">
                                <p></p>
                                <button type="button" id="bth-btn" class="btn btn-lg btn-primary">Connect to the car</button>
                            </div>
                            <br/>
                            <div id="command-buttons" style="display: none">
                                <!--<button type="button" class="btn btn-primary" id="rpm-start-btn">Start RPM</button>
                                <button type="button" class="btn btn-primary" id="rpm-stop-btn" style="display: none">Stop RPM</button>-->
                                <button type="button" class="btn btn-secondary" id="dtc-btn">Get DTC</button>
                                <!--<button type="button" class="btn btn-secondary" id="vin-btn">Get VIN</button>-->
                                <br/>
                            </div>
                            <div id="dtc-status" style="display: none">
                                <h4>DTC value</h4>
                                <p></p>
                                <span id="dtc-info"></span>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div id="customer-support">
                                <p id="support-code"></p>
                                <div id="chat-area">
                                    <span id="chat-area-end" style="display: none"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script src="{{asset('js/raphael-2.1.4.min.js')}}"></script>
    <script src="{{asset('js/justgage.js')}}"></script>
    <script src="{{asset('js/socket.io.js')}}"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.2/twilio-chat.min.js"></script>
<script type="text/javascript">
        let found_services_string = '';
        let bth_btn = document.getElementById('bth-btn');
        let status_p = $('div#bth-status p');
        let status_action = 'append';
        let obd_device = null;
        let obd_server = null;
        let obd_service = null;
        let obd_notify = null;
        let obd_write = null;
        let obd_command_interval = false;
        let rpm_interval = false;
        let get_dtc = false;
        let eolChar = "\r";
        let encoder = new TextEncoder('UTF-8');
        let decoder = new TextDecoder('UTF-8');
        let serviceUUID = '0000fff0-0000-1000-8000-00805f9b34fb';
        let readCharacteristic = '0000fff1-0000-1000-8000-00805f9b34fb';
        let writeCharacteristic = '0000fff2-0000-1000-8000-00805f9b34fb';
        let elm_initialized = false;

        let rpmMin = 0;
        let rpmMax = 6000;
        let rpmDefault = 0;

        /*let gauge = new JustGage({
            id: "gauge",
            value: rpmDefault,
            min: rpmMin,
            max: rpmMax,
            title: "Engine RPM",
            animationSpeed: 60,
        });*/

        bth_btn.addEventListener('click', function(event) {
            navigator.bluetooth.requestDevice({
                filters: [{
                    services: ['0000fff0-0000-1000-8000-00805f9b34fb']
                }]
                /*acceptAllDevices: true,
                optionalServices: ['battery_service','generic_access','alert_notification','automation_io','current_time',
                    'cycling_power','cycling_speed_and_cadence','device_information','environmental_sensing',
                    'generic_attribute','http_proxy','human_interface_device','immediate_alert','internet_protocol_support',
                    'location_and_navigation','object_transfer','phone_alert_status','pulse_oximeter','reference_time_update',
                    'running_speed_and_cadence','scan_parameters','transport_discovery','tx_power','user_data']*/
                /*filters: [{
                    services: ['current_time','battery_service']
                }]*/
            })
                .then(device=> {
                    obd_device = device;
                    device.addEventListener('gattserverdisconnected', onDisconnected);
                    console.log('Blutooth Device connected with the following data:');
                    console.log(device);
                    return device.gatt.connect();
                })
                .then(server => {
                    obd_server = server;
                    status_p.html('Getting Service with UUID: '+serviceUUID);
                    return server.getPrimaryService(serviceUUID);
                })
                .then(service => {
                    obd_service = service;
                    status_p.html('Getting first characteristic of the service');
                    // Get all characteristics.
                    //console.log(service.getCharacteristics());
                    return service.getCharacteristic(readCharacteristic);
                })
                /*.then(characteristics => {
                    status_p.html('The Characteristics of service 0000fff0-0000-1000-8000-00805f9b34fb: <br/>' +
                        characteristics.map(c => c.uuid).join('<br/>' + ' '.repeat(19)));
                })*/
                .then(characteristic => {
                    //return characteristic.readValue();
                    obd_notify = characteristic;
                    return obd_notify.startNotifications().then(_ => {
                        obd_notify.addEventListener('characteristicvaluechanged', handleNotifications);
                    });
                })
                .then(_ => {
                    //sendRPMCommand
                    //sendATICommand
                    console.log("subscribed to reading notifications");
                    return obd_service.getCharacteristic(writeCharacteristic);
                })
                .then(characteristic => {
                    obd_write = characteristic;
                })
                .then(_ => {
                    return initializeELMAdapter();
                })
                .then(_ => {
                    console.log('ELM adapter initialized');
                })
                /*.then(value => {
                    console.log(value);
                    console.log('Data read from characteristic is: ' + value.getUint8(0));
                })*/
                /*.then(server => {
                    $('div#bth-status p').html('Discovering Bluetooth services on OBD device');
                    return server.getPrimaryServices();
                })
                .then(services=> {
                    $('div#bth-status p').html('Getting Characteristics of the services');
                    let queue = Promise.resolve();
                    services.forEach(service => {
                        queue = queue.then(_ => service.getCharacteristics().then(characteristics => {
                            found_services_string += '-Service: ' + service.uuid + '<br/>';
                            characteristics.forEach(characteristic => {
                                found_services_string += '  -Characteristic: ' + characteristic.uuid + ' ' +
                                    getSupportedProperties(characteristic) + '<br/>';
                            });
                        }));
                    });
                    $('div#bth-status p').html(found_services_string);
                    return queue;
                })*/
                .catch(error => {
                    console.log(error);
                });
        });

        function onDisconnected(event) {
            let device = event.target;
            alert('Device ' + device.name + ' is disconnected.');
            if (obd_notify) {
                obd_notify.stopNotifications()
                    .then(_ => {
                        console.log('> Notifications stopped');
                        obd_notify.removeEventListener('characteristicvaluechanged',
                            handleNotifications);
                    })
                    .catch(error => {
                        console.log('Argh! ' + error);
                    });
                obd_device = null;
                obd_server = null;
                obd_service = null;
                obd_notify = null;
                obd_write = null;
                //clearInterval(obd_command_interval);
                obd_command_interval = false;
                rpm_interval = false;
                get_dtc = false;
                $('#command-buttons').hide();
                //$('#rpm-status').hide();
            }
        }

        function handleNotifications(event) {
            let value = event.target.value;
            /*let a = [];
            // Convert raw data bytes to hex values just for the sake of showing something.
            // In the "real" world, you'd use data.getUint8, data.getUint16 or even
            // TextDecoder to process raw data bytes.
            for (let i = 0; i < value.byteLength; i++) {
              a.push(('00' + value.getUint8(i).toString(16)).slice(-2));
            }*/
            let decodedValue = decoder.decode(value);
            let readable_value= '';
            let pass = true;
            if(elm_initialized) {
                if(get_dtc){
                    console.log('DTC response:  ' + decodedValue);
                    let dtc_response = decodedValue.replace(/\s/g, '');
                    if(dtc_response.startsWith("47") || dtc_response.startsWith("43")) {
                        let the_mode = null;
                        if(dtc_response.startsWith("47")){
                            the_mode = '7';
                        } else if(dtc_response.startsWith("43")){
                            the_mode = '3';
                        }
                        if (status_action == 'append') {
                            status_p.append('DTC mode '+the_mode+' response <br/>');
                        } else if (status_action == 'overwrite') {
                            status_p.html('DTC mode '+the_mode+' response');
                        }
                        dtc_response = dtc_response.substr(2);
                        let dtc_count = parseInt(dtc_response.substr(0,2));
                        let the_dtc = null;
                        let first_bit = null;
                        let formatted_dtc = null;
                        if(dtc_count>0) {
                            dtc_response = dtc_response.substr(2);
                            for (let i = 0; i < dtc_count; i++) {
                                the_dtc = dtc_response.substr(0, 4);
                                first_bit = the_dtc.substr(0,1);
                                if(first_bit=='0'){
                                    formatted_dtc = 'P0';
                                } else if(first_bit=='1'){
                                    formatted_dtc = 'P1';
                                } else if(first_bit=='2'){
                                    formatted_dtc = 'P2';
                                } else if(first_bit=='3'){
                                    formatted_dtc = 'P3';
                                } else if(first_bit=='4'){
                                    formatted_dtc = 'C0';
                                } else if(first_bit=='5'){
                                    formatted_dtc = 'C1';
                                } else if(first_bit=='6'){
                                    formatted_dtc = 'C2';
                                } else if(first_bit=='7'){
                                    formatted_dtc = 'C3';
                                } else if(first_bit=='8'){
                                    formatted_dtc = 'B0';
                                } else if(first_bit=='9'){
                                    formatted_dtc = 'B1';
                                } else if(first_bit=='A'){
                                    formatted_dtc = 'B2';
                                } else if(first_bit=='B'){
                                    formatted_dtc = 'B3';
                                } else if(first_bit=='C'){
                                    formatted_dtc = 'U0';
                                } else if(first_bit=='D'){
                                    formatted_dtc = 'U1';
                                } else if(first_bit=='E'){
                                    formatted_dtc = 'U2';
                                } else if(first_bit=='F'){
                                    formatted_dtc = 'U3';
                                }
                                formatted_dtc += the_dtc.substr(1);
                                if (status_action == 'append') {
                                    status_p.append('DTC read: ' + formatted_dtc + '<br/>');
                                } else if (status_action == 'overwrite') {
                                    status_p.html('DTC read: ' + formatted_dtc);
                                }
                                emitToRoom('Found DTC: '+formatted_dtc);
                                /*$.ajax({
                                    url: '{url('save_obd')}}',
                                    data: {
                                        res: formatted_dtc,
                                        csrfmiddlewaretoken: '{ csrf_token() }}'
                                    },
                                    dataType: 'json',
                                    method: 'POST',
                                    success: function (data) {
                                        console.log('OBD result '+ formatted_dtc +' saved successfully!');
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        console.log("Unable to save OBD result!<br/>"+"Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                                    }
                                });*/
                                $.ajax({
                                    url: '{{url('get-dtc-info')}}',
                                    data: {
                                        dtc: formatted_dtc,
                                        csrfmiddlewaretoken: '{{ csrf_token() }}'
                                    },
                                    dataType: 'json',
                                    method: 'POST',
                                    success: function (data) {
                                        console.log('DTC '+formatted_dtc+' info retrieved successfully');
                                        var faults_desc = '<h4>Detected fault locations</h4>';
                                        data.forEach(function(fault,index){
                                            console.log(fault);
                                            faults_desc += '<h5>'+fault.description+'</h5>'+
                                               '<span style="font-weight: bold">System:</span> '+fault.system+
                                               '<h5>Probable causes</h5>';
                                            fault.probable_causes.forEach(function(cause,index){
                                               faults_desc += '<span style="font-weight: bold">'+cause.description+'</span>';
                                            });
                                        });
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        console.log("Unable to retrieve DTC information!<br/>"+"Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                                    }
                                });
                                dtc_response = dtc_response.substr(4);
                            }
                        } else {
                            if (status_action == 'append') {
                                status_p.append('No DTC found!<br/>');
                            } else if (status_action == 'overwrite') {
                                status_p.html('No DTC found!');
                            }
                        }
                    }
                } else {
                    if (decodedValue.startsWith("4")) {
                        readable_value = convertValue(decodedValue);
                        console.log(readable_value);
                        //changeGauge(readable_value);
                    } else if (decodedValue.startsWith('7E8')) {
                        readable_value = convertValue(decodedValue);
                        //pass = false;
                    } else {
                        console.log('unknown byte size: ' + decodedValue);
                    }
                    if (!pass) {
                        if (status_action == 'append') {
                            status_p.append('read data : ' + readable_value + '<br/>');
                        } else if (status_action == 'overwrite') {
                            status_p.html(readable_value);
                        }
                    }
                }
            } else {
                //status_p.append('> ' + decodedValue + '<br/>');
            }
        }

        function sendRPMCommand(){
            //obd_command_interval = setInterval(rpmCommandInterval, 500);
            if(rpm_interval){
                rpmCommandInterval();
            }
        }

        function rpmCommandInterval(){
            /*if(obd_server && obd_service){
                obd_service.getCharacteristic('0000fff2-0000-1000-8000-00805f9b34fb')
                .then(characteristic=>{
                    //let rpm_command = fromHexString('7DF02010C5555555555');
                    return characteristic.writeValue(rpm_command);
                }).then(_ => {
                    console.log('RPM command sent');
                }).catch(error => { console.log(error); });
            }*/
            let cmd = '01 0c';
            sendCommand(cmd,'RPM')
                .then(_ => {
                    return _sleep(150);
                })
                .then(
                    sendRPMCommand
                )
        }

        /*function sendATICommand(){
            if(obd_server && obd_service){
                obd_service.getCharacteristic('0000fff2-0000-1000-8000-00805f9b34fb')
                .then(characteristic=>{
                    let cmd = 'ATI';
                    let ati_command = unicodeStringToTypedArray(cmd);
                    return characteristic.writeValue(ati_command);
                }).then(_ => {
                    console.log('ATI command sent');
                }).catch(error => { console.log(error); });
            }
        }*/

        function initializeELMAdapter(){
            if(obd_server && obd_service){
                let cmd = '';
                //Reset command
                cmd = 'AT Z';
                sendCommand(cmd,'ATZ (reset)')
                    .then(_ => {
                        return _sleep(1000);
                    })
                    .then(_ => {
                        //Echo off command
                        cmd = 'ATE0';
                        return sendCommand(cmd, 'ATE0 (Echo off)');
                    })
                    .then(_ => {
                        return _sleep(300);
                    })
                    .then(_ => {
                        //Headers off command
                        cmd = 'ATH0';
                        return sendCommand(cmd, 'ATH0 (Headers off)');
                    })
                    .then(_ => {
                        return _sleep(300);
                    })
                    /*.then(_ =>{
                        //Linefeeds off command
                        cmd = 'ATL0';
                        return sendCommand(cmd, 'ATLO (Linefeeds off)');
                    })
                    .then(_ => {
                        return _sleep(300);
                    })*/
                    .then(_ => {
                        //Auto protocol command
                        cmd = 'ATSP0';
                        return sendCommand(cmd, 'ATSP0 (Auto protocol)');
                    })
                    .then(_ => {
                        return _sleep(300);
                    })
                    .then(_ => {
                        //Search protocols command
                        cmd = '0100';
                        return sendCommand(cmd, '0100 (Search protocols)')
                    })
                    /*.then(_ => {
                        //List protocol number
                        cmd = 'ATDPN';
                        return sendCommand(cmd, 'ATDPN (List protocol number)')
                    })*/
                    .then(_ => {
                        elm_initialized = true;
                        status_p.append('- Adapter initialised successfully!<br/>');
                        //sendRPMCommand();
                        showCommandButtons();
                    })
                    .catch(error =>{
                        console.log(error);
                    });
            }
        }

        function sendDTCCommand(){
            let cmd = '03';
            sendCommand(cmd,'DTC (General 03)')
            .then(_ => {
                return _sleep(100);
            })
            .then(_ => {
                cmd = '07';
                return sendCommand(cmd,'DTC (Last/Current cycle 07)');
            })
            .then(_ => {

            })
        }

        function sendVINCommand(){
            let cmd = '0902';
            sendCommand(cmd,'VIN')
                .then(_ => {

                })
        }

        function sendCustomCommand(){
            let cmd = $('#custom-command').val();
            if(cmd && cmd.trim()!='') {
                sendCommand(cmd, cmd)
                    .then(_ => {
                        $('#custom-command-status').html('Command '+cmd+' sent!');
                    });
            } else {
                $('#custom-command-status').html('No Command was sent!');
            }
        }

        function showCommandButtons(){
            $('#command-buttons').show();
        }

        function sendCommand(cmd, text){
            let bth_command = encodeCommand(cmd);
            return obd_write.writeValue(bth_command)
                .then(_ => {
                    console.log(text+' command sent');
                    //console.log(_);
                }).catch(error => { console.log(error); });
        }

        function getSupportedProperties(characteristic) {
            let supportedProperties = [];
            for (const p in characteristic.properties) {
                if (characteristic.properties[p] === true) {
                    supportedProperties.push(p.toUpperCase());
                }
            }
            return '[' + supportedProperties.join(', ') + ']';
        }

        /*let obd_btn = document.getElementById('obd-btn');
        obd_btn.addEventListener('click', function(event) {
            $('div#obd-status p').html('Testing OBD connection');
            $.ajax({
                url: ' request.scheme :// request.get_host /test-obd',
                dataType: 'json',
                success: function (data) {
                    $('div#obd-status p').html('OBD connection status value is: ' + data.status + '<br/> connection string is: ' + data.status_string);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                }
            });
        });*/

        const fromHexString = hexString =>
            new Uint8Array(hexString.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

        const toHexString = bytes =>
            bytes.reduce((str, byte) => str + byte.toString(16).padStart(2, '0'), '');

        function unicodeStringToTypedArray(s) {
            let escstr = encodeURIComponent(s);
            let binstr = escstr.replace(/%([0-9A-F]{2})/g, function(match, p1) {
                return String.fromCharCode('0x' + p1);
            });
            let ua = new Uint8Array(binstr.length);
            Array.prototype.forEach.call(binstr, function (ch, i) {
                ua[i] = ch.charCodeAt(0);
            });
            return ua;
        }

        function _sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function encodeCommand(commandText) {
            return encoder.encode(commandText + eolChar);
        }

        function convertValue(decodedValue) {
            let hexString = decodedValue.substr(6).replace(/\s/g, "");

            if (hexString.length > 4){
                hexString = hexString.substr(0,4);
            }
            return parseInt(hexString, 16) / 4;
        }

        function changeGauge(value) {
            if(gauge) {
                gauge.refresh(value);
            }
        }
        $(document).ready(function(){
            /*let rand_num = null;
            setInterval(function(){
                rand_num = Math.floor(Math.random()*6000);
                changeGauge(rand_num);
            },1000);*/
            /*$('#rpm-start-btn').on('click', function(){
                $('#dtc-status').hide();
                get_dtc = false;
                rpm_interval = true;
                $('#rpm-status').show();
                $(this).hide();
                $('#rpm-stop-btn').show();
                status_p = $('div#rpm-status p');
                status_action = 'overwrite';
                sendRPMCommand();
            });
            $('#rpm-stop-btn').on('click', function(){
                rpm_interval = false;
                $('#rpm-status').hide();
                $(this).hide();
                $('#rpm-start-btn').show();
            });*/
            $('#dtc-btn').on('click', function(){
                rpm_interval = false;
                get_dtc = true;
                $('#rpm-status').hide();
                $('#rpm-start-btn').show();
                $('#rpm-stop-btn').hide();
                $('#dtc-status').show();
                let cmd =  'ATH1';
                status_p = $('div#bth-status p');
                status_action = 'append';
                /*elm_initialized = false;
                sendCommand(cmd,'ATH1 (Headers on)')
                .then(_ => {
                    elm_initialized = true;
                    _sleep(500);
                })
                .then(_ => {
                    status_p = $('div#dtc-status p');
                    status_action = 'append';
                    status_p.html('Getting DTC...');
                    sendDTCCommand();
                });*/
                status_p = $('div#dtc-status p');
                status_action = 'append';
                status_p.html('Getting DTC... <br/>');
                sendDTCCommand();
            });
            /*$('#vin-btn').on('click', function(){
                rpm_interval = false;
                get_dtc = false;
                $('#rpm-status').hide();
                $('#rpm-start-btn').show();
                $('#rpm-stop-btn').hide();
                $('#dtc-status').show();
                status_p = $('div#bth-status p');
                status_action = 'append';
                status_p.html('Getting VIN... <br/>');
                sendVINCommand();
            });
            $('#send-custom-command').on('click', function(){
                rpm_interval = false;
                $('#rpm-status').hide();
                $('#rpm-stop-btn').hide();
                $('#rpm-start-btn').show();
                sendCustomCommand();
            });*/

            /*$('#obd-save-btn').on('click', function(){
                let the_res = (Math.random()*100)+1;
            });*/
        });
    </script>
    <!-- Socket script -->
    <script type="text/javascript">
        let room = '';
        let socket = io('https://cartowans.westeurope.cloudapp.azure.com:4000');
        $(document).ready(function() {
            for(let i=0;i<6;i++){
                var random = getRandomIntegerDigit();
                room += random.toString();
            }
            console.log(room);
            $('#support-code').append('Your support code is '+room);
            //Join the randomly generated room name
            socket.emit('join room', room);

            socket.on('new message', function(data){
                console.log('message received!');
                console.log(data);
                $('#chat-area-end').before('<p>'+data+'</p>');
            });
        });

        function emitToRoom(data){
            if(room!=null){
                socket.emit('customer emit', {'room': room, 'message': data});
            }
        }

        function getRandomIntegerDigit(max=9, min=0){
            return Math.floor(Math.random() * (max - min)) + min;
        }
    </script>
@endsection
