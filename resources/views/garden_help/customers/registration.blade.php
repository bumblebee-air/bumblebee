@extends('templates.garden_help')

@section('title', 'Contractors Registration')

@section('styles')
    <style>
        html, body {
            height: 100%;
        }

        .title {
            color: #62a043;
            font-weight: bold;
        }

        .sub-title {
            font-weight: bold;
        }

        .container {
            /*padding-left: 12px;*/
            /*padding-right: 12px;*/

            padding-left: 0px;
            padding-right: 0px;
        }

        .main {
            background-color: white;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            padding-top: 10px;
            padding-left: 23px;
            padding-right: 23px;
        }

        .modal-content {
            border-radius: 20px!important;
            box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08)!important;
            padding-left: 12px;
            padding-right: 12px;
        }

        .modal-body .row .d-flex{
            padding-bottom: 13px;
        }
        .modal-title {
            font-weight: bold;
        }

        .form-check-label {
            font-family: Roboto;
            font-size: 17px !important;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal !important;
            letter-spacing: 0.32px;

        }

        .modal-button-close {
            width: 57px;
            height: 45px;
            font-family: Roboto;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 2.5;
            letter-spacing: 0.17px;
            color: #767676;
        }

        .modal-button-done {
            width: 43px;
            height: 45px;
            font-family: Roboto;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 2.5;
            letter-spacing: 0.17px;
            color: #60a244 !important;
        }

        .modal-button-done:disabled {
            color: #999 !important;
        }

        .content-card {
            border-radius: 20px;
            box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
            margin-top: 10px;
            padding-top: 25px;
        }

        .my-check-box-label {
            font-family: Roboto;
            font-size: 17px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.32px;
            color: #acb1c0!important;
        }

        .my-check-box-label-checked {
            color: #6c707c!important;
            font-weight: bold!important;
        }

        .my-check-box {
            width: 15px;
            height: 15px;
            color: #c3c7d2;
            margin-right: 10px;
        }
        .my-check-box .checked {
            color: #60a244;
        }

        .add-other-button {
            position: absolute;
            right: 0;
            color: gray;
            margin-top: 10px;
            margin-right: 15px;
            color: #c3c7d2!important;
            transition: 0.3s ease-in-out;
        }

        .inputFileVisible {
            background-image: none;
        }

        .circle {
            border-color: #60a244!important;
        }

        .check {
            background-color: #60a244!important;
        }

        .form-check-label {
            font-size: 17px;
            letter-spacing: 0.32px;
            color: #1e2432;

        }

        .terms {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.32px;
            color: #1e2432;
            padding-right: 29px;
            padding-left: 29px;
        }
        .terms-text {
            color: #60a244;
        }

        .submit-btn {
            height: 48px;
            border-radius: 24px;
            background-color: #60a244!important;
            font-size: 14px;
            font-weight: bold;
            line-height: 0.79;
            letter-spacing: 0.32px;
            text-align: center;
            color: #ffffff!important;
        }

        .submit-container {
            padding-left: 29px;
            padding-right: 29px;
        }

        .select-icon {
            position: absolute;
            right: 0;
            color: gray;
            margin-top: 10px;
            margin-right: 15px;
            color: #c3c7d2!important;
            transition: 0.3s ease-in-out;
            font-size: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container" id="app">
        <form action="{{route('postContractorRegistration')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{csrf_field()}}
            <div class="main main-raised">
                <div class="h-100 row align-items-center">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/Garden-Help-Logo.png')}}" alt="GardenHelp">
                    </div>
                </div>
                <div class="container">
                    <div class="section">
                        <h4 class="title">Customer Registration Form</h4>
                        <h5 class="sub-title">Personal Details</h5>
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
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="bmd-label-floating">Contact through</label>
                                <div class="d-flex">
                                    <div class="contact-through d-flex pr-5" @click="changeContact('whatsapp')">
                                        <div id="check" :class="contact == 'whatsapp' ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        Whatsapp
                                    </div>

                                    <div class="contact-through d-flex" @click="changeContact('sms')">
                                        <div id="check" :class="contact == 'sms' ? 'my-check-box my-check-box-checked' : 'my-check-box'">
                                            <i class="fas fa-check-square"></i>
                                        </div>
                                        SMS
                                    </div>
                                    <input type="hidden" v-model="contact" name="contact_through">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            {{--Other Details--}}
            <div class="main main-raised content-card">
                <div class="container">
                    <div class="section">
                        <h5 class="sub-title">Property Information</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
{{--                                <label class="bmd-label-floating" for="location">Location</label>--}}
                                <input type="text" class="form-control" id="location" name="location" value="{{old('location')}}" required>
                                <input type="hidden" id="location_coordinates" name="location_latlang">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <div id="map" style="height: 400px; margin-top: 0"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-file-upload form-file-multiple bmd-form-group">
                                <label class="bmd-label-static" for="photographs_of_property">
                                    Upload Photographs of Property
                                </label>
                                <br>
                                <input id="age_proof" name="photographs_of_property" type="file" class="inputFileHidden" @change="onChangeFile($event, 'age_proof_input')">
                                <div class="input-group" @click="addFile('age_proof')">
                                    <input type="text" id="age_proof_input" class="form-control inputFileVisible" placeholder="Upload Photo" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-fab btn-round btn-success">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <p class="terms">
                        By clicking Submit, you agree to our <span class="terms-text">Terms & Conditions</span> and that you have read our <span class="terms-text">Privacy Policy</span>
                    </p>
                </div>

                <div class="col-md-12 submit-container">
                    <button class="btn btn-success btn-block submit-btn" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                experience_level: '{{old('experience_level_value') ? old('experience_level_value') : 1}}',
                experience_level_input: '{{old('experience_level') ?  old('experience_level') : 'Level 1 (0-2 Years)'}}',
                experience_level_selected_value: '{{old('experience_level_value') ? old('experience_level_value') : 1}}',
                experience_types: [
                    {
                        title: 'Garden Design',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Garden Design') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Tree surgery',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Tree surgery') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"]
                    },
                    {
                        title: 'Garden Maintenance',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Garden Maintenance') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Grass Cutting',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Grass Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Fencing')  === false  ? 'false' : true) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Groundwork',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Groundwork') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["1", "2", "3"]
                    },
                    {
                        title: 'Landscaping',
                        is_checked: JSON.parse("{{old('type_of_work_exp') ? ( strpos(old('type_of_work_exp'), 'Landscaping') === false  ? 'false' : 'true' ) : 'false'}}"),
                        level: ["2", "3"],
                    },
                ],
                experience_type: '{{old('type_of_work_exp')}}',
                experience_type_input: '{{old('type_of_work_exp')}}',
                experience_type_other: '',
                available_tools: [
                    {
                        title: 'Hedge cutters',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hedge cutters') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Hand fork',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hand fork') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Lawn scarifier',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Lawn scarifier') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Hoe',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Hoe') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Secateurs',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Secateurs') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Dibber',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Dibber') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Pruning saw',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Pruning saw') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Paving knife',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Paving knife') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Edging knife',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Edging knife') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Mattock',
                        is_checked: JSON.parse("{{old('available_equipments') ? ( strpos(old('available_equipments'), 'Mattock') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                ],
                available_tool_other: '',
                available_tool_input: "{{old('available_equipments')}}",
                transport_types: [
                    {
                        title: 'Van',
                        is_checked: JSON.parse("{{old('type_of_transport') ? ( strpos(old('type_of_transport'), 'Van') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{{old('type_of_transport') ? ( strpos(old('type_of_transport'), 'Trailer') === false  ? 'false' : 'true' ) : 'false'}}")
                    }
                ],
                transport_type_input: "{{old('type_of_transport')}}",
                charge: "{{old('charge_type')}}",
                call_out_fee: "{{old('has_callout_fee')}}",
                call_out_fee_charge: "{{old('callout_fee_value')}}",
                green_waste_collection_methods: [
                    {
                        title: 'Ton bags',
                        is_checked: JSON.parse("{{old('green_waste_collection_method') ? ( strpos(old('green_waste_collection_method'), 'Ton bags') === false  ? 'false' : 'true' ) : 'false'}}")
                    },
                    {
                        title: 'Trailer',
                        is_checked: JSON.parse("{{old('green_waste_collection_method') ? ( strpos(old('green_waste_collection_method'), 'Trailer') === false  ? 'false' : 'true' ) : 'false'}}")
                    }
                ],
                green_waste_collection_method_input: "{{old('green_waste_collection_method')}}",
                green_waste_collection_method_other: ''
            },
            mounted() {

            },
            methods: {
                changeExperienceLevel() {
                    if (this.experience_level == 1) {
                        this.experience_level_input = "Level 1 (0-2 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    } else if (this.experience_level == 2) {
                        this.experience_level_input = "Level 2 (2-5 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    } else {
                        this.experience_level_input = "Level 3 (+5 Years)";
                        this.experience_level_selected_value = this.experience_level;
                    }
                },
                openModal(type) {
                    $('#' + type + '_btn_modal').click();
                },
                toggleCheckedValue(type) {
                    type.is_checked = !type.is_checked;
                },
                addOtherInput(type) {
                    if (type === 'experience_type') {
                        this.experience_types.push({
                            title: this.experience_type_other,
                            is_checked: true,
                            level: [this.experience_level],
                        });
                        this.experience_type_other = '';
                    } else if (type === 'available_tools') {
                        this.available_tools.push({
                            title: this.available_tool_other,
                            is_checked: true
                        });
                        this.available_tool_other = '';
                    } else if (type === 'green_waste_collection_method') {
                        this.green_waste_collection_methods.push({
                            title: this.green_waste_collection_method_other,
                            is_checked: true
                        });
                        this.green_waste_collection_method_other = '';
                    }
                },
                changeSelectedValue(type) {
                    let input = '';
                    let list = '';
                    if (type === 'experience_type') {
                        this.experience_type_input = '';
                        list = this.experience_types;
                        for(let item of list) {
                            item.is_checked === true ? this.experience_type_input += (this.experience_type_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'available_tools') {
                        this.available_tool_input = '';
                        list = this.available_tools;
                        for(let item of list) {
                            item.is_checked === true ? this.available_tool_input += (this.available_tool_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'transport_types') {
                        this.transport_type_input = '';
                        list = this.transport_types;
                        for(let item of list) {
                            item.is_checked === true ? this.transport_type_input += (this.transport_type_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    } else if(type === 'green_waste_collection_methods') {
                        this.green_waste_collection_method_input = '';
                        list = this.green_waste_collection_methods;
                        for(let item of list) {
                            item.is_checked === true ? this.green_waste_collection_method_input += (this.green_waste_collection_method_input == '' ? item.title : ', ' + item.title ) : '';
                        }
                    }
                },
                addFile(id) {
                    $('#' + id).click();
                },
                onChangeFile(e ,id) {
                    $("#" + id).val(e.target.files[0].name);
                }
            }
        });

        function initMap() {
            //Map Initialization
            this.map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668}
            });

            //Marker
            let marker_icon = {
                url: "{{asset('images/doorder_driver_assets/customer-address-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };

            let locationMarker = new google.maps.Marker({
                map: this.map,
                icon: marker_icon,
                position: {lat: 53.346324, lng: -6.258668}
            });

            locationMarker.setVisible(false)

            //Autocomplete Initialization
            let location_input = document.getElementById('location');
            let autocomplete_location = new google.maps.places.Autocomplete(location_input);
            autocomplete_location.setComponentRestrictions({'country': ['ie']});
            autocomplete_location.addListener('place_changed', () => {
                let place = autocomplete_location.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                    let place_lat = place.geometry.location.lat();
                    let place_lon = place.geometry.location.lng();

                    locationMarker.setPosition({lat: place_lat, lng: place_lon})
                    locationMarker.setVisible(true);

                    //Fit Bounds
                    let bounds = new google.maps.LatLngBounds();
                    bounds.extend({lat: place_lat, lng: place_lon})
                    this.map.fitBounds(bounds);

                    document.getElementById("location_coordinates").value = '{"lat": ' + place_lat.toFixed(5) + ', "lon": ' + place_lon.toFixed(5) +'}';
                }
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
