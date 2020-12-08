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
        .deliverers-container .deliverer-card .deliverer-details:focus{
            color: #f7dc69;
        }
    </style>
@endsection
@section('title','DoOrder | View Order')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6" id="details-container">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="card-icon">
                                {{--                                    <i class="material-icons">home_work</i>--}}
                                <img class="page_icon" src="{{asset('images/doorder_icons/orders_table_white.png')}}">
                            </div>
                            <h4 class="card-title ">Order Number {{$order->order_id}}</h4>
                        </div>
                        <div style="padding: 10px 0;"></div>
                    </div>
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" id="customer-details-header" data-target="#customer-details" aria-expanded="true" aria-controls="customer-details">
                            <div class="d-flex form-head">
                                <span>1</span>
                                Customer Details
                            </div>
                        </div>
                        <div id="customer-details" class="collapse show" aria-labelledby="customer-details-header" data-parent="#details-container">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first_name" class="control-label">First Name:</label>
                                                <input id="first_name" type="text" class="form-control" value="{{$order->first_name}}" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="last_name" class="control-label">Last Name:</label>
                                                <input id="last_name" type="text" class="form-control" value="{{$order->last_name}}" name="last_name" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email" class="control-label">Email:</label>
                                                <input id="email" type="email" class="form-control" value="{{$order->customer_email}}" name="email">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="customer_phone" class="control-label">Contact Number:</label>
                                                <input id="customer_phone" type="tel" class="form-control" value="{{$order->customer_phone}}" name="customer_phone" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="customer_address" class="control-label">Address:</label>
                                                <input id="customer_address" type="text" class="form-control" value="{{$order->customer_address}}" name="customer_address" required>
                                                <input type="hidden" name="customer_lat" id="customer_lat" value="{{$order->customer_address_lat}}">
                                                <input type="hidden" name="customer_lon" id="customer_lon" value="{{$order->customer_address_lon}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="eircode" class="control-label">Eircode:</label>
                                                <input id="eircode" type="text" class="form-control" value="{{$order->eircode}}" name="eircode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" data-toggle="collapse" id="package-details-header" data-target="#package-details" aria-expanded="true" aria-controls="package-details">
                            <div class="d-flex form-head">
                                <span>2</span>
                                Package Details
                            </div>
                        </div>
                        <div id="package-details" class="collapse" aria-labelledby="package-details-header" data-parent="#details-container">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="pick_address" class="control-label">Pickup Address</label>
                                                <input id="pick_address" name="pickup_address" type="text" class="form-control" value="{{$order->pickup_address}}" required>
                                                <!--<select id="pick_address" name="pickup_address" data-style="select-with-transition" class="form-control selectpicker">
                                                    <option value="88 - 95 Grafton Street Dublin , Dublin Ireland">88 - 95 Grafton Street Dublin , Dublin Ireland </option>
                                                    <option value="12 Brook Lawn, Lehenagh More, Cork, Ireland">12 Brook Lawn, Lehenagh More, Cork, Ireland</option>
                                                </select>-->
                                                <input type="hidden" name="pickup_lat" id="pickup_lat" value="{{$order->pickup_lat}}">
                                                <input type="hidden" name="pickup_lon" id="pickup_lon" value="{{$order->pickup_lon}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="fulfilment" class="control-label">Order Fulfilment</label>
                                                <input id="fulfilment" type="text" name="fulfilment" class="form-control" value="{{$order->fulfilment}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="weight" class="control-label">Package Weight in Kg</label>
                                                <input id="weight" type="text" class="form-control" name="weight" value="{{$order->weight}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="dimensions" class="control-label">Package Dimensions in cm</label>
                                                <input id="dimensions" type="text" name="dimensions" class="form-control" value="{{$order->dimensions}}" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notes" class="control-label">Other Details</label>
                                                <input id="notes" type="text" name="notes" class="form-control" value="{{$order->notes}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="deliver_by" class="control-label">Deliver By:</label>
                                                {{--<select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">--}}
                                                    {{--<option>Car</option>--}}
                                                    {{--<option>Scooter</option>--}}
                                                {{--</select>--}}
                                                <select id="deliver_by" name="deliver_by" data-style="select-with-transition" class="form-control selectpicker">
                                                    <option value="car" @if($order->deliver_by=='car') selected @endif>Car</option>
                                                    <option value="scooter" @if($order->deliver_by=='scooter') selected @endif>Scooter</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="fragile" class="control-label">Fragile Package?</label>
                                                <div class="radio-container row">
                                                    <div class="form-check form-check-radio form-check-inline d-flex justify-content-between"><label class="form-check-label">
                                                            <input type="radio" name="fragile" id="inlineRadio1" value="1" class="form-check-input" required @if($order->fragile==1) checked @endif>
                                                            Yes
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-radio form-check-inline d-flex justify-content-between"><label class="form-check-label">
                                                            <input type="radio" name="fragile" id="inlineRadio1" value="0" class="form-check-input" required @if($order->fragile==0) checked @endif>
                                                            No
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" data-toggle="collapse" id="deliverer-details-header" data-target="#deliverer-details" aria-expanded="true" aria-controls="deliverer-details">
                            <div class="d-flex form-head">
                                <span>3</span>
                                Deliverers
                            </div>
                        </div>
                        <div id="deliverer-details" class="collapse" aria-labelledby="deliverer-details-header" data-parent="#details-container">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 deliverers-container">
                                            @foreach($available_drivers as $driver)
                                                <div id="driver-{{$driver->id}}" class="card deliverer-card"
                                                     data-driver-id="{{$driver->id}}" data-driver-name="{{$driver->name}}"
                                                     onclick="showAssignDriverModal({{$driver->id}})">
                                                    <div class="card-header deliverer-details row">
                                                        <div class="col-6">
                                                            <span class="deliverer-name">{{$driver->name}}</span>
                                                        </div>
                                                        <div class="col-6" style="text-align: right">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn bt-submit">Submit</button>
                        </div>
                    </div>-->
                </div>
                <div class="col-12 col-sm-6" id="map-container">
                    <div id="map" style="width:100%; height: 100%; min-height: 400px; margin-top:0;border-radius:6px;"></div>
                </div>
            </div>
        </div>
        <!-- Assign deliverer modal -->
        <div class="modal fade" id="assign-deliverer-modal" tabindex="-1" role="dialog" aria-labelledby="assign-deliverer-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assign-deliverer-label">Assign deliverer</h5>
                    </div>
                    <div class="modal-body">
                        <h2>This deliverer is successfully selected and ready to be assigned</h2>

                        <div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 deliverers-container">
                                            <div id="driver-modal-card" class="card deliverer-card">
                                                <div class="card-header deliverer-details row">
                                                    <div class="col-6">
                                                        <span id="deliverer-modal-name" class="deliverer-name"></span>
                                                    </div>
                                                    <div class="col-6" style="text-align: right">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                    <form method="POST" action="{{url('order/assign')}}">
                                                        @csrf
                                                        <input type="hidden" id="order-id" name="order_id" value="{{$order->id}}"/>
                                                        <input type="hidden" id="driver-id" name="driver_id" required/>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
    <script>
        // var input = document.getElementById('customer_address');
        // var autocomplete = '';
        // var place = '';
        // function submitForm(e) {
        //     e.preventDefault();
        //     place = autocomplete.getPlace();
        //     console.log(place);
        //     if (!place.geometry) {
        //         // User entered the name of a Place that was not suggested and
        //         // pressed the Enter key, or the Place Details request failed.
        //         window.alert("No details available for input: '" + place.name + "'");
        //         return;
        //     } else {
        //         var place_lat = place.geometry.location.lat();
        //         var place_lon = place.geometry.location.lng();
        //         document.getElementById("lat").value = place_lat.toFixed(5);
        //         document.getElementById("lon").value = place_lon.toFixed(5);
        //
        //         // check distance if location is available
        //         a_latlng = place.geometry.location;
        //         if(b_latlng != null){
        //             var request = {
        //                 origin : a_latlng,
        //                 destination : b_latlng,
        //                 travelMode : 'DRIVING'
        //             };
        //         }
        //
        //     }
        // }
        let map;
        let customer_marker;
        let customer_latlng = null;
        let pickup_marker;
        let pickup_latlng = null;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });

            let customer_address = document.getElementById('customer_address');
            let autocomplete = new google.maps.places.Autocomplete(customer_address);
            autocomplete.setComponentRestrictions({'country': ['ie','gb']});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                console.log(place);
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                    var place_lat = place.geometry.location.lat();
                    var place_lon = place.geometry.location.lng();
                    document.getElementById("customer_lat").value = place_lat.toFixed(5);
                    document.getElementById("customer_lon").value = place_lon.toFixed(5);

                    // // check distance if location is available
                    // a_latlng = place.geometry.location;
                    // if(b_latlng != null){
                    //     var request = {
                    //         origin : a_latlng,
                    //         destination : b_latlng,
                    //         travelMode : 'DRIVING'
                    //     };
                    // }

                }
            });

            customer_marker = new google.maps.Marker({
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
            }

            pickup_marker = new google.maps.Marker({
                map: map,
                label: 'P',
                anchorPoint: new google.maps.Point(0, -29)
            });
            pickup_marker.setVisible(false);
            let pickup_address_lat = $("#pickup_lat").val();
            let pickup_address_lon = $("#pickup_lon").val();
            console.log(pickup_address_lat,pickup_address_lon);
            if(pickup_address_lat!=null && pickup_address_lat!='' &&
                pickup_address_lon!=null && pickup_address_lon!=''){
                pickup_marker.setPosition({lat: parseFloat(pickup_address_lat),lng: parseFloat(pickup_address_lon)});
                pickup_marker.setVisible(true);
            }
        }

        function showAssignDriverModal(driver_id){
            let driver_card = $('#driver-'+driver_id);
            let driver_name = driver_card.data('driver-name');
            $('#deliverer-modal-name').html(driver_name);
            $('#driver-id').val(driver_id);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
