@extends('templates.dashboard')

@section('page-styles')
    <style>
        h3 {
            margin-top: 0;
            font-weight: bold;
        }

        .main-panel>.content {
            margin-top: 0px;
        }

        audio {
            height: 32px;
            margin-top: 8px;
        }

        .swal2-popup .swal2-styled:focus {
            box-shadow: none !important;
        }

        div[data-toggle='collapse']{
            cursor: pointer;
        }

        .deliverers-container .deliverer-card{
            cursor: pointer;
        }
        .deliverers-container .deliverer-card .deliverer-details{
            color: #3c4858;
        }
        .deliverers-container .deliverer-card .deliverer-details:hover,
        .deliverers-container .deliverer-card .deliverer-details:focus,
        .deliverer-name{
            color: #f7dc69;
        }

        .modal-dialog-header {
            font-size: 25px;
            font-weight: 500;
            line-height: 1.2;
            text-align: center;
            color: #cab459;
        }

        .modal-content {
            /*padding: 51px 51px 112px 51px;*/
            border-radius: 30px!important;
            border: solid 1px #979797!important;
            background-color: #ffffff;
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 972px!important;
                margin-left: 16.75rem!important;
                margin-right: 16.75rem!important;
            }
        }

        .modal-header .close {
            width: 15px;
            height: 15px;
            margin: 39px 37px 95px 49px;
            background-color: #e8ca49;
            border-radius: 30px;
            color: white!important;
            top: -20px!important;
            padding: 0.6rem;
        }

        .modal-header .close i {
            font-size: 10px!important;
            margin: -5px;
        }
    </style>
@endsection
@section('title','DoOrder | View Order')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="map-container">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                {{--                                    <i class="material-icons">home_work</i>--}}
                                <img class="page_icon" src="{{asset('images/map_icon_card_white.png')}}">
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
    <script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
    <script>
        let map;
        let deliverers_array = JSON.parse('{!! $drivers_arr !!}');
        let deliverer_markers = [];
        console.log(deliverers_array);

        function initMap() {
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
            let deliverer_marker = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            if(deliverers_array.length > 0){
                deliverers_array.forEach(function(deliverer,index){
                    let del_lat = parseFloat(deliverer.lat);
                    let del_lon = parseFloat(deliverer.lon);
                    let deliverer_latlng = {lat: del_lat, lng: del_lon};
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
                    deliverer_markers[deliverer.driver.id] = dlvrr_mrkr;
                });
            }
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
