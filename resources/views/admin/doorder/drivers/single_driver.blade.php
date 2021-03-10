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

        .iti {
            width: 100%;
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

        input.form-control, textarea.form-control {
            padding: 11px 14px 11px 14px;
            border-radius: 5px;
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

        .reg-inputs-scroll {
            position: absolute;
            overflow-y: scroll;
        }

        .business_day_switch {
            width: 75px;
            height: 31px;
            margin: 45px 18px 10px 85px;
            border-radius: 2px;
            background-color: #eeeeee;
        }

        .business_day_switch_checked {
            background-color: #e8ca49;
        }

       

        .workingBusinssDay {
            background-color: #e8ca49;
            border-radius: 2px!important;
            border: none!important;
            max-height: 21px!important;
        }

        .dayOff {
            background-color: #eeeeee;
            border-radius: 2px;
            border: none!important;
            max-height: 21px!important;
        }

        .file-url-container {
            padding: 8px 44px 8px 17px;
            border-radius: 9px;
            border: solid 1px #e3e3e3;
            background-color: #ffffff;
            /*width: fit-content;*/
        }
        .file-url-container i {
            font-size: 50px;
            color: #e2e5e7;
        }
    </style>
@endsection
@section('title','DoOrder | Driver ' . $driver->first_name . ' ' . $driver->last_name)
@section('page-content')
    <div class="content" id="app">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{csrf_field()}}
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                    <img class="page_icon" src="{{asset('images/doorder_icons/Deliverers-white.png')}}">
                                </div>
                                <h4 class="card-title ">{{$driver->first_name}} {{$driver->last_name}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(count($errors))
                                                <div class="alert alert-danger" role="alert">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{$error}}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 d-flex form-head pl-3">
                                            <span>
                                                1
                                            </span>
                                            Deliverer Details
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name" value="{{$driver->first_name}}" placeholder="First Name" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name" value="{{$driver->last_name}}" placeholder="Last Name" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Email Address</label>
                                                <input type="email" class="form-control" name="email" value="{{$driver->user->email}}" placeholder="Email Address" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" name="contact_number" value="{{$driver->user->phone}}" placeholder="Contact Number" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Contact Through</label>
                                                <input type="text" class="form-control" name="contact_channel" value="{{$driver->contact_channel}}" placeholder="Contact Through" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Date of Birth</label>
                                                <input type="text" class="form-control" name="birthdate" value="{{$driver->dob}}" placeholder="Date of Birth" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" name="address" placeholder="Address" rows="5" required>{{$driver->address}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>PPS Number</label>
                                                <input type="text" class="form-control" name="pps_number" value="{{$driver->pps_number}}" placeholder="PPS Number" required>
                                            </div>
                                            <div class="form-group bmd-form-group">
                                                <label>Emergency Contact Name</label>
                                                <input type="text" class="form-control" name="emergency_contact_name" value="{{$driver->emergency_contact_name}}" placeholder="Emergency Contact Name" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label>Emergency Contact Phone Number</label>
                                                <input type="text" class="form-control" name="emergency_contact_number" value="{{$driver->emergency_contact_number}}" placeholder="Emergency Contact Phone Number" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            {{--                                <div class="card-header card-header-icon card-header-rose">--}}
                            {{--                                    <div class="card-icon">--}}
                            {{--                                        --}}{{--                                    <i class="material-icons">home_work</i>--}}
                            {{--                                        <img class="page_icon" src="{{asset('images/doorder_icons/add-plus-outline.png')}}">--}}
                            {{--                                    </div>--}}
                            {{--                                    <h4 class="card-title ">New Order</h4>--}}
                            {{--                                </div>--}}
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
{{--                                        <div class="col-md-12 d-flex form-head pl-3">--}}
{{--                                            <span>--}}
{{--                                                2--}}
{{--                                            </span>--}}
{{--                                            Locations Details--}}
{{--                                        </div>--}}

                                        <div class="col-md-12">
{{--                                            <label v-if="locations.length > 1">Location @{{ index + 1 }}</label>--}}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
                                                        <label>Transport Type</label>
                                                        <input class="form-control" value="{{$driver->transport}}" placeholder="Transport Type" required>
                                                    </div>

                                                    <div class="form-group bmd-form-group">
                                                        <label>Max package size</label>
                                                        <input class="form-control" value="{{$driver->max_package_size}}" placeholder="Max package size" required>
                                                    </div>

                                                    <div class="form-group bmd-form-group">
                                                        <label>Work Location</label>
                                                        <input class="form-control" value="{{json_decode($driver->work_location)->name}}" placeholder="Work Location" required>
                                                    </div>

                                                    <div class="form-group bmd-form-group">
                                                        <label>Radius</label>
                                                        <input class="form-control" value="{{$driver->work_radius}}" placeholder="Radius" required>
                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group bmd-form-group">
{{--                                                        <label>Address</label>--}}
{{--                                                        <textarea class="form-control" rows="14" placeholder="Address" required></textarea>--}}
                                                        <div id="driver_map" style="height: 320px;"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Workig Hours Modal -->
                                            <div class="modal fade" :id="'exampleModal' + index" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Select Working Days and Hours</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-center">
                                                                <div :id="'business_hours_container' + (index + 1)"></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" class="btn btn-submit" @click="serializeBusinessHours(index + 1)" data-dismiss="modal" aria-label="Close">Save changes</button>
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
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 d-flex form-head pl-3">
                                            <span>
                                                3
                                            </span>
                                            Verification Documents
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <a target="_blank" href="{{asset($driver->legal_word_evidence)}}" style="color: #333">
                                                    <div class="file-url-container d-flex">
                                                        <i class="fas fa-file"></i>
                                                        <p class="mt-3 pl-3">
                                                            Evidence you can legally work in Ireland
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <a target="_blank" href="{{asset($driver->address_proof)}}" style="color: #333">
                                                    <div class="file-url-container d-flex">
                                                        <i class="fas fa-file"></i>
                                                        <p class="mt-3 pl-3">
                                                            Proof of Address
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        @if($driver->driver_license)
                                            <div class="col-sm-6">
                                                <div class="form-group bmd-form-group">
                                                    <a target="_blank" href="{{asset($driver->driver_license)}}" style="color: #333">
                                                        <div class="file-url-container d-flex">
                                                            <i class="fas fa-file"></i>
                                                            <p class="mt-3 pl-3">
                                                                Driving License front
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                        @if($driver->driver_license_back)
                                            <div class="col-sm-6">
                                                <div class="form-group bmd-form-group">
                                                    <a target="_blank" href="{{asset($driver->driver_license_back)}}" style="color: #333">
                                                        <div class="file-url-container d-flex">
                                                            <i class="fas fa-file"></i>
                                                            <p class="mt-3 pl-3">
                                                                Driving License back
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        @if($driver->insurance_proof)
                                            <div class="col-sm-6">
                                                <div class="form-group bmd-form-group">
                                                    <a target="_blank" href="{{asset($driver->insurance_proof)}}" style="color: #333">
                                                        <div class="file-url-container d-flex">
                                                            <i class="fas fa-file"></i>
                                                            <p class="mt-3 pl-3">
                                                                Proof of Insurance
                                                            </p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <form id="order-form" method="POST" action="{{route('post_doorder_drivers_single_request', ['doorder', $driver->id])}}">
                                    {{csrf_field()}}
                                    <button class="btn bt-submit">Accept</button>
                                </form>
                            </div>
                            <div class="col-sm-6 text-center">
                                <button class="btn bt-submit btn-danger" data-toggle="modal" data-target="#rejection-reason-modal">Reject</button>
                            </div>
                        </div>

                        <!-- Rejection Reason modal -->
                        <div class="modal fade" id="rejection-reason-modal" tabindex="-1" role="dialog" aria-labelledby="assign-deliverer-label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        {{--                        <h5 class="modal-title" id="assign-deliverer-label">Assign deliverer</h5>--}}
                                        <button type="button" class="close d-flex justify-content-center" data-dismiss="modal" aria-label="Close">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <form id="request-rejection" method="POST" action="{{route('post_doorder_drivers_single_request', ['doorder', $driver->id])}}">
                                                {{csrf_field()}}
                                                <div class="text-center" style="  font-size: 30px;
                                                                                  font-weight: bold;
                                                                                  font-stretch: normal;
                                                                                  font-style: normal;
                                                                                  line-height: normal;
                                                                                  letter-spacing: normal;
                                                                                  color: #414141;">
                                                    <img src="{{asset('images/doorder_icons/red-tick.png')}}" style="width: 160px" alt="Reqject">
                                                    <br>
                                                    Rejected
                                                </div>
                                                <div class="form-group bmd-form-group">
                                                    <label>Please add reason for rejection</label>
                                                    <textarea class="form-control" name="rejection_reason" rows="4" required></textarea>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-around">
                                        <button type="button" class="btn btn-primary doorder-btn-lg doorder-btn" onclick="$('form#request-rejection').submit()">Send</button>
                                        <button type="button" class="btn btn-danger doorder-btn-lg doorder-btn" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
        function initMap() {
            let address_coordinates = JSON.parse({!! json_encode($driver->address_coordinates) !!});
            let work_location_coordinates = JSON.parse({!! json_encode($driver->work_location) !!});
            let map = new google.maps.Map(document.getElementById('driver_map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });

            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
            };

            window.workLocationMarker = new google.maps.Marker({
                map: map,
                icon: marker_icon,
                // anchorPoint: new google.maps.Point(0, -29)
                position: {lat: parseFloat(work_location_coordinates.coordinates.lat), lng: parseFloat(work_location_coordinates.coordinates.lng)}
            });

            window.homeAddressMarker = new google.maps.Marker({
                map: map,
                icon: marker_icon,
                position: {lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)}
            });

            let home_address_circle = new google.maps.Circle({
                center: {lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)},
                map: map,
                radius: parseInt({!! $driver->work_radius ? $driver->work_radius : 0 !!}) * 1000,
                strokeColor: "#f5da68",
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: "#f5da68",
                fillOpacity: 0.4,
            });
            let bounds = new google.maps.LatLngBounds();
            bounds.extend({lat: parseFloat(work_location_coordinates.coordinates.lat), lng: parseFloat(work_location_coordinates.coordinates.lng)})
            bounds.extend({lat: parseFloat(address_coordinates.lat), lng: parseFloat(address_coordinates.lon)})
            map.fitBounds(bounds);
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
