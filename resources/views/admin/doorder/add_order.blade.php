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
    </style>
@endsection
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form id="order-form" method="POST" action="{{route('doorder_saveNewOrder', 'doorder')}}" onsubmit="submitForm(event)">
                            {{csrf_field()}}
                            <div class="card">
                                <div class="card-header card-header-icon card-header-rose">
                                    <div class="card-icon">
                                        {{--                                    <i class="material-icons">home_work</i>--}}
                                        <img class="page_icon" src="{{asset('images/doorder_icons/orders_table_white.png')}}">
                                    </div>
                                    <h4 class="card-title ">New Order</h4>
                                </div>
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 d-flex form-head">
                                                <span>
                                                    1
                                                </span>
                                                Customer Details
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email" class="control-label">First Name:</label>
                                                    <input id="first_name" type="text" class="form-control" value="{{old('first_name')}}" name="first_name" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email" class="control-label">Last Name:</label>
                                                    <input id="last_name" type="text" class="form-control" value="{{old('last_name')}}" name="last_name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email" class="control-label">Email:</label>
                                                    <input id="email" type="email" class="form-control" value="{{old('email')}}" name="email">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="customer_phone" class="control-label">Contact Number:</label>
                                                    <input id="customer_phone" type="tel" class="form-control" value="{{old('customer_phone')}}" name="customer_phone" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="customer_address" class="control-label">Address:</label>
                                                    <input id="customer_address" type="text" class="form-control" value="{{old('customer_address')}}" name="customer_address" required>
                                                    <input type="hidden" name="customer_lat" id="customer_lat" value="{{old('customer_lat')}}">
                                                    <input type="hidden" name="customer_lon" id="customer_lon" value="{{old('customer_lon')}}">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="eircode" class="control-label">Eircode:</label>
                                                    <input id="eircode" type="text" class="form-control" value="{{old('eircode')}}" name="eircode">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 d-flex form-head">
                                                <span>
                                                    2
                                                </span>
                                                Package Details
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="pick_address" class="control-label">Pickup Address</label>
{{--                                                    <input id="pick_address" name="pickup_address" type="text" class="form-control" value="{{old('pickup_address')}}" required>--}}
                                                    <select id="pick_address" name="pickup_address" data-style="select-with-transition" class="form-control selectpicker">
                                                        <option value="88 - 95 Grafton Street Dublin , Dublin Ireland">88 - 95 Grafton Street Dublin , Dublin Ireland </option>
                                                        <option value="12 Brook Lawn, Lehenagh More, Cork, Ireland">12 Brook Lawn, Lehenagh More, Cork, Ireland</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="fulfilment" class="control-label">Order Fulfilment</label>
                                                    <input id="fulfilment" type="text" name="fulfilment" class="form-control" value="{{old('fulfilment')}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="weight" class="control-label">Package Weight in Kg</label>
                                                    <input id="weight" type="text" class="form-control" name="weight" value="{{old('weight')}}" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="dimensions" class="control-label">Package Dimensions in cm</label>
                                                    <input id="dimensions" type="text" name="dimensions" class="form-control" value="{{old('dimensions')}}" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="notes" class="control-label">Other Details</label>
                                                    <input id="notes" type="text" name="notes" class="form-control" value="{{old('notes')}}">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="deliver_by" class="control-label">Deliver By:</label>
{{--                                                    <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">--}}
{{--                                                        <option>Car</option>--}}
{{--                                                        <option>Scooter</option>--}}
{{--                                                    </select>--}}
                                                    <select id="deliver_by" name="deliver_by" data-style="select-with-transition" class="form-control selectpicker">
                                                        <option value="car">Car</option>
                                                        <option value="scooter">Scooter</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="deliver_by" class="control-label">Fragile Package?</label>
                                                    <div class="radio-container row">
                                                        <div class="form-check form-check-radio form-check-inline d-flex justify-content-between"><label class="form-check-label">
                                                                <input type="radio" name="fragile" id="inlineRadio1" value="1" class="form-check-input" required>
                                                                Yes
                                                                <span class="circle">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <div class="form-check form-check-radio form-check-inline d-flex justify-content-between"><label class="form-check-label">
                                                                <input type="radio" name="fragile" id="inlineRadio1" value="0" class="form-check-input" required>
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
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn bt-submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-scripts')
    <script src="http://bumblebee.host/js/bootstrap-selectpicker.js"></script>
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
        function initMap() {
            var input = document.getElementById('customer_address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setComponentRestrictions({'country': ['ie','gb']});
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
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
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
