@extends('templates.doorder')

@section('title', 'Order Tracking')

@section('styles')
    <style>
        .tracking-title {
            font-size: 18px;
            letter-spacing: 0.99px;
            text-align: center;
            color: #4d4d4d;
            padding-top: 25px;
        }
        .tracking-logo {
            text-align: center;
            padding-top: 10px;
        }
        .tracking-logo img {
            width: 180px;
            height: 110px;
        }
    </style>
@endsection

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col-md-12 tracking-logo">
                <img src="{{asset('images/doorder-logo.png')}}" alt="DoOrder logo">
            </div>
            <div class="col-md-12 tracking-title">
                <p>Order #{{$order_id}} tracking</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="map" style="width:100%; height: 400px;"></div>
                <div style="margin-bottom: 20px"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let map;
        let deliverer_marker;
        let deliverer_infowindow;
        let dlvrr_mrkr;
        let driver_lat = '{{$driver_lat}}';
        let driver_lon = '{{$driver_lon}}';
        let latest_timestamp = '{{$latest_timestamp}}';
        let customer_code = '{{$customer_code}}';
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });
            dlvrr_mrkr = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            let deliverer_latlng = {lat: parseFloat(driver_lat),lng: parseFloat(driver_lon)};
            deliverer_marker = new google.maps.Marker({
                map: map,
                icon: dlvrr_mrkr,
                //anchorPoint: new google.maps.Point(del_lat, del_lon),
                position: deliverer_latlng
            });
            let contentString = '<h4 style="font-weight: 400">' +
                '<span class="deliverer-name">' + 'Your driver' + '</span></h4>' +
                '<span style="font-weight: 400; font-size: 16px">' +
                'Last updated: ' + latest_timestamp;
            contentString += '</span>';
            deliverer_infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            deliverer_marker.addListener('click', function () {
                deliverer_infowindow.open(map, deliverer_marker);
            });
            deliverer_infowindow.open(map, deliverer_marker);
            map.setCenter(deliverer_latlng);
        }
        function updateDriverLocation(){
            $.ajax({
                url: '{{url('customer/tracking')}}/'+customer_code+'?return=json',
                dataType: 'json',
                success: function (data) {
                    if(data.redirect != 0){
                        window.location.href = data.redirect;
                        return;
                    }
                    driver_lat = data.driver_lat;
                    driver_lon = data.driver_lon;
                    latest_timestamp = data.latest_timestamp;
                    deliverer_marker.setPosition({lat: driver_lat, lng: driver_lon});
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="deliverer-name">' + 'Your driver' + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + latest_timestamp;
                    deliverer_infowindow.setContent(contentString);
                    setTimeout(updateDriverLocation,10000);
                }
            });
        }
        $(document).ready(function(){
            setTimeout(updateDriverLocation,10000);
        });
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
