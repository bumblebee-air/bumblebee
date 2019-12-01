@extends('templates.main')

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

            <header class="masthead text-center text-white d-flex" style="height: 300px; min-height: 300px;">
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

                            <canvas id="dtc-chart" width="500px" height="200px" style="display: none"></canvas>
                            <div id="bth-status">
                                <p></p>
                                <button type="button" id="bth-btn" class="btn btn-lg btn-primary">Connect to OBD</button>
                            </div>
                            <br/>
                            <div id="command-buttons" style="display: none">
                                <button type="button" class="btn btn-primary" id="rpm-start-btn">Start RPM</button>
                                <button type="button" class="btn btn-primary" id="rpm-stop-btn" style="display: none">Stop RPM</button>
                                <button type="button" class="btn btn-secondary" id="dtc-btn">Get DTC</button>
                                <button type="button" class="btn btn-info" id="dtc-btn-cont">Continuous DTC</button>
                                <button type="button" class="btn btn-warning" id="clear-dtc-btn">Clear DTC</button>
                                <button type="button" class="btn btn-primary" id="speed-start-btn">Start speed test</button>
                                <button type="button" class="btn btn-primary" id="speed-stop-btn" style="display: none">Stop speed test</button>
                                <button type="button" class="btn btn-secondary" id="vin-btn">Get VIN</button>
                                <br/>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="custom-command" class="control-label">Custom command</label>
                                        <div>
                                            <input id="custom-command" name="custom_command" class="form-control">
                                            <br>
                                            <p id="custom-command-status"></p>
                                            <button type="button" id="send-custom-command" class="btn btn-primary">Send command</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="rpm-status" style="display: none">
                                <h4>RPM value</h4>
                                <p></p>
                                <div id="gauge" style="width: 500px; height: 500px;"></div>
                            </div>
                            <div id="speed-status" style="display: none">
                                <h4>Speed readings</h4>
                                <p></p>
                                <span id="crash-report"></span>
                                <div id="speed-gauge" style="width: 500px; height: 500px;"></div>
                            </div>
                            <div id="dtc-status" style="display: none">
                                <h4>DTC value</h4>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript" src="{{asset('js/raphael-2.1.4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/justgage.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/smoothie-charts.js')}}"></script>
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
        let speed_interval = false;
        let speed_interval_value = 1;
        let crash_speed_threshold = 20;
        let get_dtc = false;
        let get_dtc_cont = false;
        let dtc_cont_interval = null;
        let eolChar = "\r";
        let encoder = new TextEncoder('UTF-8');
        let decoder = new TextDecoder('UTF-8');
        let serviceUUID = '0000fff0-0000-1000-8000-00805f9b34fb';
        let readCharacteristic = '0000fff1-0000-1000-8000-00805f9b34fb';
        let writeCharacteristic = '0000fff2-0000-1000-8000-00805f9b34fb';
        let elm_initialized = false;
        let speed_readings = [];
        let speed_readings_string = null;

        let rpmMin = 0;
        let rpmMax = 6000;
        let rpmDefault = 0;
        let gauge = new JustGage({
            id: "gauge",
            value: rpmDefault,
            min: rpmMin,
            max: rpmMax,
            title: "Engine RPM",
            animationSpeed: 60,
        });

        let speedMin = 0;
        let speedMax = 255;
        let speedDefault = 0;
        let speed_gauge = new JustGage({
            id: "speed-gauge",
            value: speedDefault,
            min: speedMin,
            max: speedMax,
            title: "Vehicle speed",
            animationSpeed: 60,
        });

        //DTC status chart
        let smoothie = new SmoothieChart({
            labels: { fillStyle:'rgb(123, 123, 255)'}
        });
        let dtc_interval = null;
        smoothie.streamTo(document.getElementById("dtc-chart"), 300);
        let dtc_line = new TimeSeries();
        smoothie.addTimeSeries(dtc_line,
            { strokeStyle:'rgb(0, 123, 255)', fillStyle:'rgba(0, 123, 255, 0.4)', lineWidth:2 });

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
                get_dtc_cont = false;
                clearDTCCont();
                $('#command-buttons').hide();
                $('#rpm-status').hide();
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
                                        alert("Unable to save OBD result!<br/>"+"Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                                    }
                                });*/
                                dtc_response = dtc_response.substr(4);
                            }
                            //display for chart
                            dtc_line.append(new Date().getTime(), 1);
                        } else {
                            if (status_action == 'append') {
                                status_p.append('No DTC found!<br/>');
                            } else if (status_action == 'overwrite') {
                                status_p.html('No DTC found!');
                            }
                            //display for chart
                            dtc_line.append(new Date().getTime(), 0);
                        }
                    }
                } else if(speed_interval) {
                    if (decodedValue.startsWith("4")) {
                        console.log('Speed before convert: '+decodedValue);
                        readable_value = convertSpeed(decodedValue);
                        console.log('Speed after convert: '+readable_value);
                        if(speed_readings.length >= 10){
                            speed_readings.shift();
                        }
                        changeSpeedGauge(readable_value);
                        speed_readings.push(readable_value);
                        if((speed_readings[speed_readings.length-1] - readable_value) >= crash_speed_threshold){
                            $('#crash-report').after('<p style="color:red">Crash detected! latest speed values: '+speed_readings.toString()+'</p>');
                        }
                        speed_readings_string = speed_readings.toString();
                        status_p.html(speed_readings_string);
                    } else if (decodedValue.startsWith('7E8')) {
                        readable_value = convertSpeed(decodedValue);
                        console.log('Unrecognizable speed response: '+readable_value);
                    } else {
                        console.log('unknown byte size: ' + decodedValue);
                    }
                } else {
                    if (decodedValue.startsWith("4")) {
                        readable_value = convertValue(decodedValue);
                        console.log(readable_value);
                        changeGauge(readable_value);
                    } else if (decodedValue.startsWith('7E8')) {
                        readable_value = convertValue(decodedValue);
                        pass = false;
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
                status_p.append('> ' + decodedValue + '<br/>');
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

        function sendSpeedCommand(){
            if(speed_interval){
                speedCommandInterval(speed_interval_value);
            }
        }

        function speedCommandInterval(speed_interval_value){
            let cmd = '01 0d';
            sendCommand(cmd,'Speed')
                .then(_ => {
                    return _sleep(speed_interval_value);
                })
                .then(
                    sendSpeedCommand
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
            /*let cmd = '03';
            sendCommand(cmd,'DTC (General 03)')
                .then(_ => {
                    return _sleep(100);
                })
                .then(_ => {
                    cmd = '07';
                    return sendCommand(cmd,'DTC (Last/Current cycle 07)');
                })
                .then(_ => {

                })*/
            let cmd = '07';
            sendCommand(cmd,'DTC (Last/Current cycle 07)');
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

        function convertSpeed(decodedValue) {
            let hexString = decodedValue.replace(/\s/g, "").substr(4);

            if (hexString.length > 4){
                hexString = hexString.substr(0,4);
            }
            return parseInt(hexString, 16);
        }

        function changeGauge(value) {
            if(gauge) {
                gauge.refresh(value);
            }
        }

        function changeSpeedGauge(value) {
            if(speed_gauge) {
                speed_gauge.refresh(value);
            }
        }

        function clearDTCCont(){
            if(get_dtc_cont===true) {
                //clearInterval(dtc_cont_interval);
                dtc_cont_interval = false;
                status_p = $('div#bth-status p');
                status_action = 'append';
                status_p.html('Stopped getting continuous DTC <br/>');
            }
        }

        $(document).ready(function(){
            /*function startSmoothie(){
                $('canvas#dtc-chart').show();
                dtc_interval = setInterval(function() {
                    dtc_line.append(new Date().getTime(), Math.round(Math.random()));
                }, 300);
            }
            function stopSmoothie(){
                clearInterval(dtc_interval);
                dtc_line.data = [];
                $('canvas#dtc-chart').hide();
            }*/
            /*let rand_num = null;
            setInterval(function(){
                rand_num = Math.floor(Math.random()*6000);
                changeGauge(rand_num);
            },1000);*/
            $('#rpm-start-btn').on('click', function(){
                $('#dtc-status').hide();
                get_dtc = false;
                clearDTCCont();
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
            });
            $('#dtc-btn').on('click', function(){
                rpm_interval = false;
                get_dtc = true;
                clearDTCCont();
                $('#rpm-status').hide();
                $('#rpm-start-btn').show();
                $('#rpm-stop-btn').hide();
                $('#dtc-status').show();
                let cmd =  'ATH1';
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
            $('#speed-start-btn').on('click', function(){
                $('#dtc-status').hide();
                get_dtc = false;
                clearDTCCont();
                speed_interval = true;
                $('#speed-status').show();
                $(this).hide();
                $('#speed-stop-btn').show();
                status_p = $('div#speed-status p');
                status_action = 'overwrite';
                sendSpeedCommand();
            });
            $('#speed-stop-btn').on('click', function(){
                speed_interval = false;
                $('#speed-status').hide();
                $(this).hide();
                $('#speed-start-btn').show();
            });
            $('#vin-btn').on('click', function(){
                rpm_interval = false;
                get_dtc = false;
                clearDTCCont();
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
                get_dtc = false;
                clearDTCCont();
                $('#rpm-status').hide();
                $('#rpm-stop-btn').hide();
                $('#rpm-start-btn').show();
                sendCustomCommand();
            });

            /*$('#obd-save-btn').on('click', function(){
                let the_res = (Math.random()*100)+1;
            });*/
            $('#dtc-btn-cont').on('click', function(){
                rpm_interval = false;
                get_dtc = true;
                clearDTCCont();
                $('#rpm-status').hide();
                $('#rpm-start-btn').show();
                $('#rpm-stop-btn').hide();
                $('#dtc-status').show();
                status_p = $('div#bth-status p');
                status_action = 'overwrite';
                status_p.html('Getting continuous DTC... <br/>');
                getContinuousDtc();
            });

            function getContinuousDtc(){
                get_dtc_cont = true;
                $('canvas#dtc-chart').show();
                /*dtc_interval = setInterval(function() {
                    dtc_line.append(new Date().getTime(), Math.round(Math.random()));
                }, 300);*/
                dtc_cont_interval = true;
                getContinuousDtcInterval();
                /*clearInterval(dtc_interval);
                dtc_line.data = [];
                $('canvas#dtc-chart').hide();*/
            }

            function getContinuousDtcInterval(){
                if(dtc_cont_interval==true){
                    let cmd = '07';
                    sendCommand(cmd,'DTC (07)')
                      .then(_ => {
                          return _sleep(300);
                      })
                      .then(
                          getContinuousDtcInterval
                      )
                }
            }

            $('#clear-dtc-btn').on('click', function() {
                let was_dtc_cont = false;
                if(get_dtc_cont===true){
                    was_dtc_cont = true;
                    get_dtc_cont = false;
                    clearDTCCont();
                }
                sendClearDTCCommand().then(_=>{
                    return _sleep(300);
                }).then(_=>{
                    if(was_dtc_cont===true){
                        get_dtc_cont = true;
                        dtc_cont_interval = true;
                        getContinuousDtcInterval();
                        //dtc_cont_interval = setInterval(sendDTCCommand, 1000);
                    }
                });
            });

            function sendClearDTCCommand(){
                let cmd = '04';
                return sendCommand(cmd,'Clear DTC 04').then(_=>{

                });
            }
        });
    </script>
@endsection
