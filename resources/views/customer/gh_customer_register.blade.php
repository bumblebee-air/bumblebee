<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Garden Help</title>

    <!-- Styles -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/all.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/material-dashboard.min.css')}}" rel="stylesheet">
    @yield('page-styles')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <style>

    </style>
</head>

<body>
    <!-- Page Content -->
    <div class="wrapper">
        @include('partials.flash')
        <div class="container-fluid">
            <h3 class="text-center text-rose" style="font-weight: 400;">Welcome to Garden Help, please fill up below form to create an account.</h3>
            <div class="row">
                <div class="col-md-5 ml-auto ">
                    <div class="card match-height">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <h4 class="card-title">Register</h4>
                        </div>
                        <form action="{{ url('complete-registration') . '/' . $code }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}" />
                            <input type="hidden" name="lon" id="lon" value="{{ old('lon') }}" />
                            <div class="card-body">
                                <h5 class="">General Information</h5>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group bmd-form-group">
                                            <label for="first_name">First Name*</label>
                                            <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Enter first name" value="{{ !empty(old('first_name')) ? old('first_name') : $user->first_name }}" required />
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group bmd-form-group">
                                            <label for="last_name">Last Name*</label>
                                            <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Enter last name" value="{{ !empty(old('last_name')) ? old('last_name') : $user->last_name }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="phone_number">Phone Number*</label>
                                    <input id="phone_number" name="phone_number" type="text" class="form-control" placeholder="Enter phone number" value="{{ !empty(old('phone_number')) ? old('phone_number') : $user->phone }}" required />
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="email">Email*</label>
                                    <input id="email" name="email" type="text" class="form-control" placeholder="Enter email address" value="{{ !empty(old('email')) ? old('email') : $user->email }}" required />
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="password">Password*</label>
                                    <input id="password" autocomplete="off" name="password" type="password" class="form-control" placeholder="Enter password" required />
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="address">Address*</label>
                                    <input id="address" name="address" type="text" class="form-control" placeholder="Type for autocomplete or select from map" value="{{ old('address') }}" required />
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="communication_method">Preferred Method Of Communication</label>
                                    <select id="communication_method" name="communication_method" class="form-control selectpicker" required>
                                        <option value="">Select communication method</option>

                                        @foreach($communication_methods as $methodKey => $method)
                                        <option value="{{ $methodKey }}" {{ old('communication_method') == $methodKey ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <label for="notes">Additional Notes</label>
                                    <input id="notes" name="notes" type="text" class="form-control" value="{{ old('notes') }}" placeholder="Enter notes" />
                                </div>

                            </div>
                            <div class="card-btns text-center" style="padding: 20px;">
                                <button type="submit" class="btn btn-fill btn-rose">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="map-container" class="col-md-5 mr-auto match-height" style="height: 500px;">
                    <div id="map" style="width:100%; height: 100%;margin-top:30px;border-radius:6px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/moment-timezone.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var map;
        var directionsService;
        var directionsDisplay;
        var marker;
        var a_latlng;
        var b_latlng;
        var base_latlng = null;
        var distance;

        $('.match-height').matchHeight({
            byRow: false
        });

    function initMap() {
        
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 51.5117884, lng: -0.1429935}
        });
        var input = document.getElementById('address');
        //Mutation observer hack for chrome address autofill issue
        let observerHackAddress = new MutationObserver(function() {
            observerHackAddress.disconnect();
            input.setAttribute("autocomplete", "new-password");
        });
        observerHackAddress.observe(input, {
            attributes: true,
            attributeFilter: ['autocomplete']
        });
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setComponentRestrictions({'country': ['ie','gb']});
        a_latlng = null;
        b_latlng = null;

        marker = new google.maps.Marker({
            map: map,
            label: 'A',
            anchorPoint: new google.maps.Point(0, -29)
        });
        marker.setVisible(false);
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        directionsDisplay.setMap(map);

        google.maps.event.addListener(map, "click", function(event) {
            // get lat/lon of click
            var clickLat = event.latLng.lat();
            var clickLon = event.latLng.lng();
            // check distance if destination is available
            a_latlng = event.latLng;
            // set in input box
            document.getElementById("lat").value = clickLat.toFixed(5);
            document.getElementById("lon").value = clickLon.toFixed(5);
            // change marker position
            marker.setVisible(false);
            marker.setPosition(event.latLng);
            marker.setVisible(true);
            $.ajax({
                url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+clickLat+','+clickLon+'&key=<?php echo config('google.api_key'); ?>',
                async: true,
                dataType: "json"
            }).done(function (response) {
                document.getElementById("address").value = response.results[0].formatted_address;
            }).fail(function (response) {
                console.log(response);
            });
        });

        autocomplete.addListener('place_changed', function() {
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            } else {
                var place_lat = place.geometry.location.lat();
                var place_lon = place.geometry.location.lng();
                document.getElementById("lat").value = place_lat.toFixed(5);
                document.getElementById("lon").value = place_lon.toFixed(5);

                // check distance if location is available
                a_latlng = place.geometry.location;
                if(b_latlng != null){
                    var request = {
                        origin : a_latlng,
                        destination : b_latlng,
                        travelMode : 'DRIVING'
                    };
                }
                
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(12);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });
    }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap">
    </script>
</body>

</html>