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
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <h3>Vehicle lookup</h3>
                        <label for="vehicle-reg" class="control-label">Vehicle Reg</label>
                        <div>
                            <input id="vehicle-reg" name="vehicle_reg" class="form-control">
                            <br>
                            <button type="button" id="vehicle-lookup" class="btn btn-lg btn-primary">Lookup vehicle</button>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <div id="vehicle-specs">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <h3>Get current location</h3>
                        <!--<label for="coordinates">Coordinates</label>-->
                        <div>
                            <p id="coordinates"></p>
                            <p id="road-name"></p>
                            <input type="hidden" id="lat"/>
                            <input type="hidden" id="lon"/>
                            <input type="hidden" id="road"/>
                            <br>
                            <button type="button" id="get-coordinates" class="btn btn-lg btn-primary">Get current coordinates</button>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <a href="{{asset('record-audio')}}" class="btn btn-lg btn-primary">Record Audio</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm">
            <div id="map" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-sm">
            <!--<button type="button" id="test-whatsapp" class="btn btn-lg btn-primary"
                data-toggle="modal" data-target="#whatsapp-form">Test Whatsapp</button>-->
            <!-- Whatsapp modal -->
            <!--<div class="modal fade" id="whatsapp-form" role="dialog" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title orange-header" id="cc-comment-title">Test sending Whatsapp template</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="form form-horizontal" method="post" action="{{url('test-whatsapp')}}"
                                  style="border: none">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="customer-name" class="col-sm-4 col-xs-12 control-label">Customer name</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input id="customer-name" name="customer_name" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer-phone" class="col-sm-4 col-xs-12 control-label">Customer phone</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input id="customer-phone" name="customer_phone" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier" class="col-sm-4 col-xs-12 control-label">Supplier</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <select id="supplier" name="supplier" class="form-control" required>
                                            <option value="CarTow.ie">CarTow.ie</option>
                                            <option value="Abo Ghaly motors">Abo Ghaly motors</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Send Whatsapp template</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">
        let the_map = null;
        let car_marker = null;
        let car_lat = 53.349536;
        let car_lon = -6.260135;
        let infowindow = null;
        let current_vehicle = null;

        function getVehicleSpecs() {
            let reg = $.trim($('#vehicle-reg').val());
            console.log(reg);
            /*$.ajax({
                url: '{ request.scheme }://{ request.get_host }/vehicle-lookup/' + reg,
                async: true,
                dataType: "json"
            }).done(function (response) {
                console.log('Success');
                console.log(response);
            }).fail(function (response) {
                console.log('FAIL!');
                console.log(response);
            });*/
            $.ajax({
                url: '{{url('vehicle-lookup')}}' + reg,
                async: true,
                dataType: "json"
            }).done(function (response) {
                if (response.error_code == '10') {
                    jQuery('.vehicle-info').remove();
                    jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                        '<i class="fa fa-times orange-header"></i> No data available for this vehicle' +
                        '</div>');
                } else {
                    if (response.error_code == '100' || response.error_code == '101' || response.error_code == '102' || response.error_code == '103' || response.error_code == '104' || response.error_code == '105') {
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                            '<i class="fa fa-times orange-header"></i> Could not retrieve vehicle info' +
                            '</div>');
                    } else {
                        let vehicle = response.vehicle;
                        let make = vehicle.make;
                        let model = vehicle.model;
                        let version = vehicle.version;
                        let engineSize = vehicle.engineSize;
                        let fuel = vehicle.fuel;
                        let transmission = vehicle.transmission;
                        let colour = vehicle.colour;
                        if (make === '' || make == null)
                            make = '-';
                        if (model === '' || model == null)
                            model = '-';
                        if (version === '' || version == null)
                            version = '-';
                        if (engineSize === '' || engineSize == null)
                            engineSize = '-';
                        if (fuel === '' || fuel == null)
                            fuel = '-';
                        if (transmission === '' || transmission == null)
                            transmission = '-';
                        if (colour === '' || colour == null)
                            colour = '-';
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-specs').html('<div class="vehicle-info">' +
                            '<label class="orange-header">Make</label>' + '&nbsp;&nbsp;' +make + '<br/>' +
                            '<label class="orange-header">Model</label>' + '&nbsp;&nbsp;' +model + '<br/>' +
                            '<label class="orange-header">Version</label>' + '&nbsp;&nbsp;' +version + '<br/>' +
                            '<label class="orange-header">Colour</label>' + '&nbsp;&nbsp;' +colour + '<br/>' +
                            '<label class="orange-header">Fuel</label>' + '&nbsp;&nbsp;' +fuel + '<br/>' +
                            '<label class="orange-header">Transmission</label>' + '&nbsp;&nbsp;' +transmission + '<br/>' +
                            '<label class="orange-header">Engine Size</label>' + '&nbsp;&nbsp;' +engineSize +
                            '</div>');
                    }
                }
            }).fail(function (response) {
                console.log(response);
                jQuery('.vehicle-info').remove();
                jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                    '<i class="fa fa-times orange-header"></i> Could not retrieve vehicle info</label>' +
                    '</div>');
            });
            jQuery('.vehicle-info').remove();
            jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                '<i class="fa fa-sync fa-spin orange-header"></i> Retrieving vehicle information</label>' +
                '</div>');
        }

        function getVehicleSpecsAutoData() {
            let reg = $.trim($('#vehicle-reg').val());
            $.ajax({
                url: '{{url('vehicle-lookup')}}'+'/'+reg,
                async: true,
                dataType: "json"
            }).done(function (response) {
                console.log('Success!');
                console.log(response);
                if (response.error !== 0) {
                    jQuery('.vehicle-info').remove();
                    jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                        '<i class="fa fa-times orange-header"></i> No data available for this vehicle' +
                        '</div>');
                } else {
                    let vehicle = response.vehicle;
                    current_vehicle = vehicle;
                    let make = vehicle.manufacturer;
                    let model = vehicle.model;
                    let version = vehicle.subbody;
                    let engineSize = vehicle.litres;
                    let fuel = vehicle.fuel;
                    let transmission = vehicle.tuning;
                    let colour = null;
                    if (make === '' || make == null)
                        make = '-';
                    if (model === '' || model == null)
                        model = '-';
                    if (version === '' || version == null)
                        version = '-';
                    if (engineSize === '' || engineSize == null)
                        engineSize = '-';
                    if (fuel === '' || fuel == null)
                        fuel = '-';
                    if (transmission === '' || transmission == null)
                        transmission = '-';
                    if (colour === '' || colour == null)
                        colour = '-';
                    jQuery('.vehicle-info').remove();
                    jQuery('#vehicle-specs').html('<div class="vehicle-info">' +
                        '<label id="vehicle-make" class="orange-header">Make</label>' + '&nbsp;&nbsp;' +make + '<br/>' +
                        '<label id="vehicle-model" class="orange-header">Model</label>' + '&nbsp;&nbsp;' +model + '<br/>' +
                        '<label id="vehicle-version" class="orange-header">Version</label>' + '&nbsp;&nbsp;' +version + '<br/>' +
                        '<label id="vehicle-colour" class="orange-header">Colour</label>' + '&nbsp;&nbsp;' +colour + '<br/>' +
                        '<label id="vehicle-fuel" class="orange-header">Fuel</label>' + '&nbsp;&nbsp;' +fuel + '<br/>' +
                        '<label id="vehicle-transmission" class="orange-header">Transmission</label>' + '&nbsp;&nbsp;' +transmission + '<br/>' +
                        '<label id="vehicle-engine-size" class="orange-header">Engine Size</label>' + '&nbsp;&nbsp;' +engineSize +
                        '</div>');
                }
            }).fail(function (response) {
                console.log('Failed!');
                console.log(response);
                jQuery('.vehicle-info').remove();
                jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                    '<i class="fa fa-times orange-header"></i> Could not retrieve vehicle info</label>' +
                    '</div>');
            });
            jQuery('.vehicle-info').remove();
            jQuery('#vehicle-specs').html('<div class="form-group vehicle-info">' +
                '<i class="fa fa-sync fa-spin orange-header"></i> Retrieving vehicle information</label>' +
                '</div>');
        }

        function getCoordinates(){
            let x = $("#coordinates");
            let lat = $('#lat');
            let lon = $('#lon');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let the_lat = position.coords.latitude;
                    let the_lon = position.coords.longitude;
                    x.html('Coordinates: <br/>'+the_lat+','+the_lon);
                    lat.val(position.coords.latitude);
                    lon.val(position.coords.longitude);
                    lat.change();
                    lon.change();
                    let latlng = {lat: the_lat, lng: the_lon};
                    car_marker.setVisible(false);
                    car_marker.setPosition(latlng);
                    the_map.setCenter(latlng);
                    car_marker.setVisible(true);
                });
            } else {
                x.html("Geolocation is not supported by this browser");
            }
        }

        $(document).ready(function() {
            $('#vehicle-lookup').on('click', function() {
                //getVehicleSpecs();
                getVehicleSpecsAutoData();
            });
            $('#get-coordinates').on('click', function() {
                getCoordinates();
            });
            $('#lat').on('change', function(){
                let lat = $(this).val();
                let lon = $('#lon').val();
                $.ajax({
                    url: 'https://roads.googleapis.com/v1/nearestRoads?points='+lat+','+lon+'&key=AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM',
                    async: true,
                    dataType: "json"
                }).done(function (response) {
                    console.log('Success');
                    console.log(response);
                    let road_loc = response.snappedPoints[0].location;
                    $.ajax({
                        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+road_loc.latitude+','+road_loc.longitude+'&key=AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM',
                        async: true,
                        dataType: "json"
                    }).done(function (response) {
                        //console.log(response.results[0]);
                        let road_name = response.results[0].address_components[1].long_name;
                        $('#road').val(road_name).change();
                        $('#road-name').html('Road name: '+road_name);
                    }).fail(function (response) {
                        console.log(response);
                    });
                }).fail(function (response) {
                    console.log('Fail');
                    console.log(response);
                });
            });
            $('#road,#vehicle-reg').on('change', function(){
                let road_name = $('#road').val();
                let vehicle_reg = $('#vehicle-reg').val();
                if(road_name!='' && vehicle_reg!='') {
                    let vehicle_make = current_vehicle.manufacturer;
                    let vehicle_model = current_vehicle.model;
                    let contentString = '<p style="font-weight: 400; font-size: 16px">' +
                        road_name + ', speed limit: ' + '<span style="color: #1e7e34">50kmph</span>' + '<br/>' +
                        vehicle_make + ' ' + vehicle_model + ', current speed: ' + '<span style="color: #005cbf">35kmph</span>' + '</p>';
                    if (infowindow != null) {
                        infowindow.close();
                        infowindow = null;
                    }
                    infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    infowindow.open(the_map, car_marker);
                    car_marker.addListener('click', function () {
                        infowindow.open(the_map, car_marker);
                    });
                }
            });
        });

        function initMap() {
            if(document.getElementById('map') != null) {
                the_map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: {lat: 53.349536, lng: -6.260135}
                });

                let car_marker_image = "{{asset('images/car-marker.png')}}";
                car_marker = new google.maps.Marker({
                    map: the_map,
                    //label: 'C',
                    icon: car_marker_image,
                    anchorPoint: new google.maps.Point(car_lat, car_lon)
                    //position: driver_latlng
                });
                car_marker.setVisible(false);
                //the_map.setCenter(driver_latlng);
            }
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM&libraries=geometry,places&callback=initMap">
    </script>
@endsection
