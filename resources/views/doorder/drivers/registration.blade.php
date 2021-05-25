@extends('templates.doorder')

@section('title', 'Driver Registration')

@section('styles')
    <style>
        body {
            font-family: Quicksand;
        }
        .doorder-logo {
            width: 85px;
            padding-top: 30px;
        }

        .page-title-section {
            text-align: center;
            padding-top: 10px;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.19;
            letter-spacing: 0.1px;
            color: #e5c538;
        }

        input.form-control {
            padding: 11px 14px 11px 14px;
            border-radius: 10px;
            box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
        }

        label {
            font-size: 14px;
            font-weight: 300;
            line-height: 1.36;
            letter-spacing: 1px;
            color: #000000;
            margin-left: 10px;
        }

        .form-head {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.19;
            letter-spacing: 0.8px;
            color: #4d4d4d;
            padding-left: 0px;
        }

        .form-head span {
            width: 23px;
            height: 23px;
            background-color: #f7dc69;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 10px;
            margin-right: 10px;
            font-size: 12px;
            padding-top: 5px;
            font-weight: bold;
        }

        .my-check-box {
            width: 15px;
            height: 15px;
            color: #c3c7d2;
            padding-right: 20px;
        }

        .upload-file-card {
            padding: 13px 25px 20px 24px;
            border-radius: 10px;
            box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
            margin-bottom: 5px;
        }

        .upload-file-title {
            font-size: 14px;
            line-height: 1.36;
            letter-spacing: 1px;
            color: #000000;
        }

        .upload-file-subtitle {
            font-size: 11px;
            line-height: 1.09;
            letter-spacing: 0.79px;
            color: #000000;
        }

        .btn-white {
            background-color: red;
            box-shadow: 2px 2px 5px 0 #ffffff, 0 2px 4px 0 rgba(182, 182, 182, 0.5);
        }

        .btn-round {
            border-radius: 50%;
            width: 46px;
            height: 46px;
            text-align: center;
        }

        .terms-container {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.3px;
            color: #5d5d5d;
            padding: 20px;
        }

        .btn-submit {
            height: 50px;
            border-radius: 22px 0 22px 0;
            box-shadow: 0 12px 36px -12px rgba(76, 151, 161, 0.35);
            background-color: #e8ca49;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 0.99px;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .my-check-box-checked {
            color: #f7dc69;
        }

        .iti {
            width: 100%;
        }

        .transport-tip-button {
            color: #f7dc69;
            background-color: white;
        }

        #transport-tip {
            width: 347px;
            padding: 11px 5px;
            border-radius: 10px;
            box-shadow: 0 2px 48px 0 rgb(0 0 0 / 8%);
            background-color: #e8ca49;
            color: white;
            z-index: 9999;
            margin-top: 10px!important;
            margin-left: 10px!important;
            display: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
@endsection

@section('content')
    <div class="container" id="app">
        <form action="{{route('postDriverRegistration', ['client_name' => 'doorder'])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="main main-raised">
                <div class="h-100 row align-items-center">
                    <div class="col-md-12 text-center">
                        <img class="doorder-logo" src="{{asset('images/doorder-logo.png')}}" alt="DoOrder">
                    </div>
                </div>
                <form action="">
                    <div class="container">
                        <div class="page-title-section">
                            <h4 class="title">
                                Apply now to become part of
                                <br>
                                the DoOrder team
                            </h4>
                        </div>
                        @if(count($errors))
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 d-flex form-head pl-3">
                                <span>
                                    1
                                </span>
                                A bit about you
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">First Name</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Last Name</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Email Address</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="email" value="{{old('email')}}" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Phone Number</label> <span style="color: red">*</span>
                                    <input id="driver_phone" type="text" class="form-control" name="driver_phone" value="{{old('driver_phone')}}" required>
                                </div>
                            </div>
                        </div>

{{--                        <div class="row">--}}
{{--                            <div class="col-sm-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="bmd-label-floating">Contact through</label> <span style="color: red">*</span>--}}
{{--                                    <div class="d-flex">--}}
{{--                                        <div class="contact-through d-flex pr-5" @click="changeContact('whatsapp')">--}}
{{--                                            <div id="check" :class="contact == 'whatsapp' ? 'my-check-box my-check-box-checked' : 'my-check-box'">--}}
{{--                                                <i class="fas fa-check-square"></i>--}}
{{--                                            </div>--}}
{{--                                            Whatsapp--}}
{{--                                        </div>--}}

{{--                                        <div class="contact-through d-flex" @click="changeContact('sms')">--}}
{{--                                            <div id="check" :class="contact == 'sms' ? 'my-check-box my-check-box-checked' : 'my-check-box'">--}}
{{--                                                <i class="fas fa-check-square"></i>--}}
{{--                                            </div>--}}
{{--                                            SMS--}}
{{--                                        </div>--}}
                                        <input type="hidden" v-model="contact" name="contact_through">
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Date of Birth</label> <span style="color: red">*</span>
                                    <input type="date" class="form-control" name="birthdate" value="{{old('birthdate')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Address</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="address" id="driver_address" value="{{old('address')}}" required>
                                    <input type="hidden" class="form-control" name="address_coordinates" id="driver_address_coordinates" value="{{old('address_coordinates')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">PPS Number</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="pps_number" value="{{old('pps_number')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Emergency Contact Name</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="emergency_contact_name" value="{{old('emergency_contact_name')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Emergency Contact Number</label> <span style="color: red">*</span>
                                    <input type="text" class="form-control" name="emergency_contact_number" value="{{old('emergency_contact_number')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Max package Weight</label> <span style="color: red">*</span>
                                    {{--                                <input type="text" class="form-control" name="emergency_contact_name" value="{{old('emergency_contact_name')}}" required>--}}
                                    <select name="max_package_size" class="form-control" required>
                                        <option selected disabled>Choose Max Package Weight</option>
                                        <option value="Very Light">Very Light</option>
                                        <option value="Light">Light</option>
                                        <option value="Medium Weight">Medium Weight</option>
                                        <option value="Very Heavy">Very Heavy</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Transport Type</label> <span style="color: red">*</span>
{{--                                    <a href="#" id="transport-tip-button" class="transport-tip-button" aria-describedby="tooltip">--}}
                                        <i class="fas fa-info-circle transport-tip-button" id="transport-tip-button" aria-describedby="tooltip" @click="fadeTransportTip"></i>
{{--                                    </a>--}}
                                    <div id="transport-tip" role="tooltip">
                                        You must be 18+ years old to apply with a
                                        scooter or bicycle and 25+ to apply with a
                                        car or van
                                    </div>
    {{--                                <input type="text" class="form-control" name="pps_number" value="{{old('pps_number')}}" required>--}}
                                    <select name="transport_type" class="form-control" required>
                                        <option selected disabled>Choose Transportation</option>
                                        <option value="car">Car</option>
                                        <option value="scooter">Scooter</option>
{{--                                        <option value="van">Van</option>--}}
                                        <option value="bicycle">Bicycle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-form-group">Work Location</label> <span style="color: red">*</span>
                                    {{--                                <input type="text" class="form-control" name="emergency_contact_name" value="{{old('emergency_contact_name')}}" required>--}}
                                    <select name="work_location" class="form-control" required v-model="work_location" id="work_location" @change="changeWorkLocation()">
                                        <option value="" selected disabled>Select Area</option>
                                        <option v-for="county of counties" :value="JSON.stringify(county)">@{{ county.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group pl-2">
                                    <div class="contact-through d-flex" @click="changeRadiusStatus()">
                                        <div id="check" :class="has_radius ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                            <i :class="has_radius ? 'fas fa-check-square' : 'far fa-square'"></i>
                                        </div>
                                        I want to have a radius from my address (KM)
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" v-if="has_radius">
                                    {{--<label class="bmd-form-group">Emergency Contact Number</label>--}}
                                    <input type="number" class="form-control" id="work_radius" name="work_radius" placeholder="Work Radius (Km unit)" v-model="work_radius" @change="changeRadiusValue()" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="map" style="height: 300px"></div>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row pl-3">
                            <div class="col-md-12 d-flex form-head">
                                <span>
                                    2
                                </span>
                                Uploads and Verifications
                            </div>
                            <p class="pl-4 pt-0">Please upload the following:</p>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Evidence you can legally work in Ireland  <span style="color: red">*</span></p>
                                    <p class="upload-file-subtitle">
                                        (Work permit or Passport/National Identity Card
                                        issued by a state that is part of the EEA)
                                    </p>
                                </div>
                                <div class="col-md-12">
    {{--                                <div class="d-flex">--}}
    {{--                                    <p style="font-size: 14px;--}}
    {{--                                              font-weight: normal;--}}
    {{--                                              font-stretch: normal;--}}
    {{--                                              font-style: normal;--}}
    {{--                                              line-height: normal;--}}
    {{--                                              letter-spacing: 0.26px;--}}
    {{--                                              color: #4d4d4d;--}}
    {{--                                            ">Upload file</p>--}}
    {{--                                    <div class="btn btn-white btn-round ml-4">--}}
    {{--                                        <i class="fas fa-cloud-upload-alt" style="font-size: 20px"></i>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
                                    <input type="file" name="proof_id" required>
                                </div>
                            </div>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Driving License <small>(unless using a bicycle)</small></p>
                                    <p class="upload-file-subtitle">
                                        Please make sure the photo is clear and expiry
                                        date is visible
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="upload-file-subtitle">Front</p>
                                    <input type="file" name="proof_driving_license">
                                </div>
                                <div class="col-md-6">
                                    <p class="upload-file-subtitle">Back</p>
                                    <input type="file" name="proof_driving_license_back">
                                </div>
                            </div>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Proof of Insurance <small>(unless using a bicycle)</small></p>
    {{--                                <p class="upload-file-subtitle">--}}
    {{--                                    Please make sure the photo is clear and expiry--}}
    {{--                                    date is visible--}}
    {{--                                </p>--}}
                                </div>
                                <div class="col-md-12">
                                    <div class="contact-through d-flex pr-5" @click="changeHasInsurace">
                                        <div id="check" :class="hasInsurance ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                            <i :class="hasInsurance ? 'fas fa-check-square' : 'far fa-square'"></i>
                                        </div>
                                        I have business insurance
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3" v-if="hasInsurance">
                                    <input type="file" name="proof_insurance" required>
                                </div>
                            </div>
                        </div>

                        <div class="upload-file-card">
                            <div class="row">
                                <div class="col-md-12 upload-file-title-container">
                                    <p class="upload-file-title">Proof of Address <span style="color: red">*</span></p>
                                    <p class="upload-file-subtitle">
                                        (bank statement, utility bill, driving licence)
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="proof_address" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 terms-container">
                                By clicking 'Submit', I hereby acknowledge and agree that I have read and understood
                                <a href="https://44fc5dd5-ecb5-4c2e-bb94-31bcbc8408a1.filesusr.com/ugd/0b2e42_1b6020943d804795becb839f2c103421.pdf" style="color: #e8ca49"
                                target="_blank">DoOrder's Privacy Policy</a>. DoOrder uses Cookies to personalise your
                                experience. For DoOrder's full Cookies Policy, please <a href="https://44fc5dd5-ecb5-4c2e-bb94-31bcbc8408a1.filesusr.com/ugd/0b2e42_64b44367a7ab4471b94569c71c610c6e.pdf" style="color: #e8ca49"
                                target="_blank">click here</a>.
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-block btn-submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    contact: 'sms',
                    hasInsurance: false,
                    has_radius: false,
                    counties: [],
                    work_location: '',
                    work_radius: {!! old('work_radius') ? old('work_radius') : 0 !!}
                }
            },
            mounted() {
                let iresh_counties_json = jQuery.getJSON('{{asset('iresh_counties.json')}}', data => {
                    for (let county of data) {
                        //Limit available work location temporarily to Dublin
                        if(county.city.toLowerCase()=='dublin') {
                            this.counties.push({name: county.city, coordinates: {lat: county.lat, lng: county.lng}});
                        }
                    }
                });

                let transport_tip_button = document.querySelector('#transport-tip-button');
                let transport_tip = document.querySelector('#transport-tip');
                let popperInstance = Popper.createPopper(transport_tip_button, transport_tip);

            },
            methods: {
                changeContact(contact) {
                    this.contact = contact;
                },
                changeHasInsurace() {
                    this.hasInsurance = !this.hasInsurance;
                },
                changeRadiusStatus() {
                    this.has_radius = !this.has_radius;
                    window.home_address_circle.setRadius(0);
                    this.work_radius = 0;
                },
                changeRadiusValue() {
                    if (this.work_radius != 0) {
                        window.home_address_circle.setRadius(parseInt(this.work_radius) * 1000);
                        this.mapFitBound();
                    }
                },
                changeWorkLocation() {
                    let select_value = JSON.parse($('select#work_location').val());
                    window.workLocationMarker.setPosition({lat: parseFloat(select_value.coordinates.lat), lng: parseFloat(select_value.coordinates.lng)});
                    window.workLocationMarker.setVisible(true);
                    this.mapFitBound();
                },
                mapFitBound() {
                    let bounds = new google.maps.LatLngBounds();
                    let work_location_value = $('select#work_location').val();
                    let address_coords_value = $('input#driver_address_coordinates').val();
                    if (work_location_value != '' && work_location_value != null) {
                        work_location_value = JSON.parse(work_location_value)
                        let latlng_object = {lat: parseFloat(work_location_value.coordinates.lat), lng: parseFloat(work_location_value.coordinates.lng)};
                        // console.log(latlng_object);
                        // return;
                        bounds.extend(latlng_object);
                    }
                    if (address_coords_value != '' && address_coords_value != null) {
                        address_coords_value = JSON.parse(address_coords_value)
                        let latlng_object = {lat: address_coords_value.lat, lng: address_coords_value.lon};
                        bounds.extend(latlng_object);
                    }
                    window.googleMaps.fitBounds(bounds);
                },
                fadeTransportTip() {
                    $('#transport-tip').fadeToggle();
                }
            }
        });

        function initMap() {
            //Map Initialization
            window.googleMaps = this.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });

            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };

            window.workLocationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                // anchorPoint: new google.maps.Point(0, -29)
                position: {lat: 53.346324, lng: -6.258668}
            });

            window.homeAddressMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position: {lat: 0, lng: 0}
            });

            window.workLocationMarker.setVisible(false);
            window.homeAddressMarker.setVisible(false);

            window.home_address_circle = new google.maps.Circle({
                center: {lat: 0, lng: 0},
                map: this.map,
                radius: 0,
                strokeColor: "#f5da68",
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: "#f5da68",
                fillOpacity: 0.4,
            });

            //Autocomplete Initialization
            let driver_address_input = document.getElementById('driver_address');
            //Mutation observer hack for chrome address autofill issue
            let observerHackDriverAddress = new MutationObserver(function() {
                observerHackDriverAddress.disconnect();
                driver_address_input.setAttribute("autocomplete", "new-password");
            });
            observerHackDriverAddress.observe(driver_address_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete_driver_address = new google.maps.places.Autocomplete(driver_address_input);
            autocomplete_driver_address.setComponentRestrictions({'country': ['ie']});
            autocomplete_driver_address.addListener('place_changed', () => {
                let place = autocomplete_driver_address.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                    let place_lat = place.geometry.location.lat();
                    let place_lon = place.geometry.location.lng();
                    document.getElementById("driver_address_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) +'}';
                    this.homeAddressMarker.setPosition({lat: place_lat, lng: place_lon});
                    this.homeAddressMarker.setVisible(true)
                    this.home_address_circle.setCenter({lat: place_lat, lng: place_lon});
                    if ($('input#work_radius').val() != '' && $('input#work_radius').val() != null) {
                        this.home_address_circle.setRadius(parseInt($('input#work_radius').val()) * 1000);
                    }
                    let bounds = new google.maps.LatLngBounds();
                    bounds.extend({lat: place_lat, lng: place_lon})
                    window.googleMaps.fitBounds(bounds);
                }
            });
        }

        $(document).ready(function () {
            let driver_phone_input = document.querySelector("#driver_phone");
            window.intlTelInput(driver_phone_input, {
                hiddenInput: 'phone_number',
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
        })
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
