@extends('templates.aviva')

@section('page-styles')
    <style>
        :root {
            --input-padding-x: 1.5rem;
            --input-padding-y: .75rem;
        }

        body {
            background: #eee;
            /*background: linear-gradient(to right, #0062E6, #33AEFF);*/
        }

        .card-signin {
            border: 0;
            border-radius: 1rem;
            background: #eee;
            /*box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);*/
        }

        .card-signin .card-title {
            margin-bottom: 2rem;
            font-weight: 300;
            font-size: 1.5rem;
        }

        .card-signin .card-body {
            padding: 2rem;
            color: #00479d;
        }

        .form-signin {
            width: 100%;
        }

        .form-signin .btn {
            /*font-size: 90%;*/
            border-radius: 5rem;
            /*letter-spacing: .1rem;*/
            font-weight: 700;
            padding: 1rem;
            transition: all 0.2s;
        }

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group input {
            height: auto;
            border-radius: 2rem;
        }

        .form-label-group>input,
        .form-label-group>label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0;
            /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }

        .btn-google {
            color: white;
            background-color: #ea4335;
        }

        .btn-facebook {
            color: white;
            background-color: #3b5998;
        }
    </style>
@endsection
@section('page-content')
    <div class="row">
        @if($invitation != null)
            <div class="col-12">
                <img src="{{asset('images/customer-registration-top.png')}}" style="display: block; max-width: 100%;" alt="Bumblebee customer registration">
            </div>
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-1">
                    <div class="card-body">
                        <p class="text-center" style="font-size: 18px">Hi {{$invitation->name}}! Nice to meet you</p>
                        <p class="text-center" style="font-size: 18px">I'm Bumblebee, I'll need you to input three things so I can customise myself for you and your car</p>
                        <form class="form-signin" method="POST" action="{{url('customer/register')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="invitation" value="{{$invitation->id}}">

                            <div class="form-label-group">
                                <input id="mileage" class="form-control" name="mileage" placeholder="Mileage" required autofocus>
                                <label for="mileage">Mileage</label>
                            </div>

                            <div class="form-label-group">
                                <input id="vehicle-reg" class="form-control" name="vehicle_reg" placeholder="Vehicle Reg" required>
                                <label for="vehicle-reg">Vehicle Reg</label>
                            </div>
                            <div class="form-label-group" id="vehicle-form" style="margin: 0px !important;">
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="password-confirmation" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password-confirmation">Confirm Password</label>
                            </div>

                            <!--<div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Remember password</label>
                            </div>-->
                            <button class="btn btn-lg btn-aviva btn-block text-uppercase" type="submit">Next</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <h2>The invitation code is invalid, please contact the call centre.</h2>
        @endif
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            function vehicleInfoItem(label, value, name, hidden=false) {
                let html = '<div class="row vehicle-info" style="margin-bottom: 0">';
                if(!hidden)
                    html +='<label class="col-sm-5 control-label">' + label +'</label>' +
                    '<div class="col-sm-7">' +
                    '<div class="form-control-static">' + value + '</div>';
                html += '<input name="' + name + '" type="hidden" value="' + value + '"/>';
                if(!hidden)
                    html += '</div> </div>';
                return html
            }

            $('#vehicle-reg').change(function () {
                let reg = $('#vehicle-reg').val();
                reg = reg.trim();
                if(reg!='') {
                    $.ajax({
                        url: '{{url('vehicle-lookup')}}/' + reg,
                        async: true,
                        dataType: "json"
                    }).done(function (response) {
                        console.log(response);
                        if (response.error == '10') {
                            $('.vehicle-info').remove();
                            $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                '<label class="orange-header control-label">' +
                                '<i class="fa fa-times"></i> No data available for this vehicle' +
                                '</label>' +
                                '</div></div>');
                        } else {
                            if (response.error == '100' || response.error == '101' || response.error == '102' || response.error == '103' || response.error == '104' || response.error == '105') {
                                $('.vehicle-info').remove();
                                $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                    '<label class="orange-header control-label">' +
                                    '<i class="fa fa-times"></i> Could not retrieve vehicle info' +
                                    '</label>' +
                                    '</div></div>');
                            } else {
                                if (response.error == 1) {
                                    $('.vehicle-info').remove();
                                    $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                        '<label class="orange-header control-label">' +
                                        'Error: ' + response.error_bag['response'] + '<br/>' + response.error_bag['error'] +
                                        '</label>' +
                                        '</div></div>');
                                    $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                        '<label class="orange-header control-label">' +
                                        '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                                        '</div></div>');
                                } else {
                                    var vehicle = response.vehicle;
                                    var make = vehicle.manufacturer;
                                    var model = vehicle.model;
                                    var version = vehicle.version;
                                    var engineSize = vehicle.engineSize;
                                    var fuel = vehicle.fuel;
                                    var transmission = vehicle.transmission;
                                    var colour = vehicle.colour;
                                    var external_id = vehicle.mid;
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
                                    if (external_id === '' || external_id == null)
                                        external_id = '-';
                                    $('.vehicle-info').remove();
                                    $('#vehicle-form').after('<div style="margin-bottom: 10px"></div>');
                                    $('#vehicle-form').after(vehicleInfoItem('External ID', external_id, 'external_id', true));
                                    $('#vehicle-form').after(vehicleInfoItem('Colour', colour, 'colour'));
                                    $('#vehicle-form').after(vehicleInfoItem('Transmission', transmission, 'transmission'));
                                    $('#vehicle-form').after(vehicleInfoItem('Fuel', fuel, 'fuel'));
                                    $('#vehicle-form').after(vehicleInfoItem('Engine Size', engineSize, 'engine-size'));
                                    $('#vehicle-form').after(vehicleInfoItem('Version', version, 'version'));
                                    $('#vehicle-form').after(vehicleInfoItem('Model', model, 'model'));
                                    $('#vehicle-form').after(vehicleInfoItem('Make', make, 'make'));

                                    $('#vehicle-form').after('<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                                        '<h4 class="orange-header" style="font-weight: 400">Vehicle Details</h4>' +
                                        '</div>');
                                }
                            }
                        }
                    }).fail(function (response) {
                        console.log(response);
                        $('.vehicle-info').remove();
                        $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                            '<label class="orange-header control-label">' +
                            '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                            '</div></div>');
                    });
                    $('.vehicle-info').remove();
                    $('#vehicle-form').after('<div class="form-group vehicle-info">' +
                        '<div><label class="orange-header control-label">' +
                        '<i class="fa fa-sync fa-spin"></i> Retrieving vehicle information</label></div>' +
                        '</div>');
                } else {
                    $('.vehicle-info').remove();
                }
            });
        });
    </script>
@endsection