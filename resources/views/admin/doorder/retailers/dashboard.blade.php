@extends('templates.dashboard')

@section('title', 'DoOrder | Dashboard')

@section('page-styles')
@endsection
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="map-container">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                {{--<i class="material-icons">home_work</i>--}}
                                <img class="page_icon" src="{{asset('images/map_icon_card_white.png')}}" alt="Map icon">
                            </div>
                            <h4 class="card-title ">Map</h4>
                        </div>

                        <div class="card-body">
                            <div id="map" style="width:100%; height: 100%; min-height: 400px; margin-top:0;border-radius:6px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
        let google_initialized = false;
        let map;
        let deliverers_array = JSON.parse('{!! $drivers_arr !!}');
        let deliverer_markers = [];
        let deliverer_marker;

        function initMap() {
            google_initialized = true;
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });
            /*customer_marker = new google.maps.Marker({
                map: map,
                label: 'D',
                anchorPoint: new google.maps.Point(0, -29)
            });
            customer_marker.setVisible(false);
            let customer_address_lat = $("#customer_lat").val();
            let customer_address_lon = $("#customer_lon").val();
            if(customer_address_lat!=null && customer_address_lat!='' &&
                customer_address_lon!=null && customer_address_lon!=''){
                customer_marker.setPosition({lat: parseFloat(customer_address_lat),lng: parseFloat(customer_address_lon)});
                customer_marker.setVisible(true);
            }*/
            deliverer_marker = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            if(deliverers_array.length > 0){
                deliverers_array.forEach(function(deliverer,index){
                    let del_lat = parseFloat(deliverer.lat);
                    let del_lon = parseFloat(deliverer.lon);
                    /*let deliverer_latlng = {lat: del_lat, lng: del_lon};
                    let dlvrr_mrkr = new google.maps.Marker({
                        map: map,
                        icon: deliverer_marker,
                        //anchorPoint: new google.maps.Point(del_lat, del_lon),
                        position: deliverer_latlng
                    });
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="deliverer-name">' + deliverer.driver.name + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + deliverer.timestamp;
                    contentString += '</span>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    dlvrr_mrkr.addListener('click', function () {
                        infowindow.open(map, dlvrr_mrkr);
                    });
                    deliverer_markers[deliverer.driver.id] = {
                        marker: dlvrr_mrkr,
                        info_window: infowindow
                    };*/
                    drawDelivererMarker(deliverer.driver.id,deliverer.driver.name,del_lat,del_lon,deliverer.timestamp);
                });
            }
        }

        // let map_socket = io.connect(window.location.protocol+'//' + window.location.hostname + ':8890');
        //
        // map_socket.on('doorder-channel:update-driver-location', (data) => {
        //     let decodedData = JSON.parse(data);
        //     console.log('driver location update');
        //     let the_data = decodedData.data;
        //     let driver_id = the_data.driver_id;
        //     let driver_name = the_data.driver_name;
        //     let lat = the_data.lat;
        //     let lon = the_data.lon;
        //     let the_timestamp = the_data.timestamp;
        //     if(google_initialized){
        //         if(deliverer_markers[driver_id] === undefined){
        //             drawDelivererMarker(driver_id,driver_name,lat,lon,the_timestamp);
        //         } else {
        //             let the_marker = deliverer_markers[driver_id]['marker'];
        //             the_marker.setPosition({lat: lat, lng: lon});
        //             let the_info_window = deliverer_markers[driver_id]['info_window'];
        //             let contentString = '<h3 style="font-weight: 400">' +
        //                 '<span class="deliverer-name">' + driver_name + '</span></h3>' +
        //                 '<span style="font-weight: 400; font-size: 16px">' +
        //                 'Last updated: ' + the_timestamp;
        //             the_info_window.setContent(contentString);
        //         }
        //     }
        // });

        function drawDelivererMarker(deliverer_id,deliverer_name,lat,lon,the_timestamp){
            let deliverer_latlng = {lat: lat, lng: lon};
            let dlvrr_mrkr = new google.maps.Marker({
                map: map,
                icon: deliverer_marker,
                //anchorPoint: new google.maps.Point(del_lat, del_lon),
                position: deliverer_latlng
            });
            let contentString = '<h3 style="font-weight: 400">' +
                '<span class="deliverer-name">' + deliverer_name + '</span></h3>' +
                '<span style="font-weight: 400; font-size: 16px">' +
                'Last updated: ' + the_timestamp;
            contentString += '</span>';
            let infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            dlvrr_mrkr.addListener('click', function () {
                infowindow.open(map, dlvrr_mrkr);
            });
            deliverer_markers[deliverer_id] = {
                marker: dlvrr_mrkr,
                info_window: infowindow
            };
        }

        function updateDriversLocations() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '{{url('doorder/dashboard?accept_json')}}',
                data: {
                },
                dataType: 'json',
                method: 'GET',
                success: function (data){
                    deliverers_array = data;
                    if (deliverer_markers.length > 0) {
                        deliverer_markers.forEach(function (deliverer, index) {
                            deliverer.marker.setMap(null);
                        });
                    }
                    deliverer_markers = [];
                    if(deliverers_array.length > 0){
                        deliverers_array.forEach(function(deliverer,index){
                            let del_lat = parseFloat(deliverer.lat);
                            let del_lon = parseFloat(deliverer.lon);
                            drawDelivererMarker(deliverer.driver.id,deliverer.driver.name,del_lat,del_lon,deliverer.timestamp);
                        });
                    }
                }
            })
        }
        $(document).ready(function () {
            setInterval(() => {
                updateDriversLocations();
            }, 30000)
        });
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
