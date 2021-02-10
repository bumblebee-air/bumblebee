@extends('templates.garden_help')

@section('title', 'GardenHelp | Customers Registration')

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
            padding-bottom: 35px;
            margin-bottom: 20px;
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

        /*.bootstrap-select>.dropdown-toggle.bs-placeholder {*/
        /*    color: white;*/
        /*}*/

        .form-group-none:invalid {

        }
    </style>
@endsection

@section('content')
    <div class="container" id="app">
        <form action="{{route('postContractorRegistration', 'garden-help')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
{{--                                <label class="bmd-label-floating">Location</label>--}}
{{--                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>--}}
                                <select name="location" data-style="select-with-transition" class="form-control selectpicker" @change="changeLocation">
                                    <option disabled selected>Location</option>
                                    <option value="Limerick">Limerick</option>
                                    <option value="Drumcondra">Drumcondra</option>
                                    <option value="Dún Laoghaire">Dún Laoghaire</option>
                                    <option value="Smithfield">Smithfield</option>
                                    <option value="Clontarf">Clontarf</option>
                                    <option value="Blackrock">Blackrock</option>
                                    <option value="Glasnevin">Glasnevin</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                {{--                                <label class="bmd-label-floating">Location</label>--}}
                                {{--                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>--}}
                                <select name="type_of_work" data-style="select-with-transition" class="form-control selectpicker" v-model="type_of_work">
                                    <option disabled selected>Type of work</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="type_of_work == 'Residential'">
                        <div class="col-md-12">
                            <h5 class="sub-title">Property Information</h5>
                        </div>
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
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Phone</label>
                                <input type="tel" class="form-control" name="phone" value="{{old('phone')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Password</label>
                                <input type="password" class="form-control" name="password" value="{{old('password')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main main-raised content-card">
                <div class="container">
                    <div class="section">
                        <h5 class="sub-title">Services Details</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="type_of_experience" class="bmd-label-floating">Service Type</label>
                                <div class="d-flex justify-content-between" @click="openModal('service_type')">
                                    <input name="service_types" type="text" class="form-control" id="service_type_input" v-model="service_type_input" {{old('service_type_input')}} required>
                                    <a class="select-icon">
                                        <i class="fas fa-caret-down"></i>
                                    </a>
                                </div>
                                <!-- Button trigger modal -->
                                <a id="service_type_btn_modal" data-toggle="modal"
                                   data-target="#service_typeModal" style="display: none"></a>

                                <!-- Modal -->
                                <div class="modal fade" id="service_typeModal" tabindex="-1" role="dialog"
                                     aria-labelledby="type_of_experienceLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-left" id="type_of_experienceLabel">Service Type</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-between" v-for="type in service_types"  @click="toggleCheckedValue(type)">
                                                        <label for="my-check-box" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
                                                        <div class="my-check-box" id="check">
                                                            <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h5 class="modal-title text-left" id="type_of_experienceLabel">Other Service</h5>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-between" v-for="type in other_service_types"  @click="toggleCheckedValue(type)">
                                                        <label for="my-check-box" :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">@{{ type.title }}</label>
                                                        <div class="my-check-box" id="check">
                                                            <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                                                </button>
                                                <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('experience_type')">
                                                    Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main main-raised content-card">
                <div class="container">
                    <div class="section">
                        <h5 class="sub-title">Property Information</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating" for="location">Location</label>
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

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label class="bmd-label-floating">Property size</label>
                                <input type="text" class="form-control" name="property_size" value="{{old('property_size')}}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group bmd-form-group">
                                <label for="vat-number">Is this the first time you do service for your property?</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios2" name="has_smartphone" value="1" {{old('has_smartphone') === '1' ? 'checked' : ''}} required>
                                                Yes
                                                <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" id="exampleRadios1" name="has_smartphone" value="0" {{old('has_smartphone') === '0' ? 'checked' : ''}} required>
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
        <a id="addOtherLocationBtn" data-toggle="modal"
           data-target="#addOtherLocationModal" style="display: none"></a>
        <!-- Modal -->
        <div class="modal fade" id="addOtherLocationModal" tabindex="-1" role="dialog"
             aria-labelledby="type_of_experienceLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-left" id="type_of_experienceLabel">Type of work experience</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <input type="text" class="form-control" placeholder="Add Other">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link modal-button-close" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-link modal-button-done" data-dismiss="modal" @click="changeSelectedValue('experience_type')">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                type_of_work: 'Residential',
                service_types: [
                    {
                        title: 'Garden Maintenance',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Garden Maintenance') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Grass Cutting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Grass Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ],
                other_service_types: [
                    {
                        title: 'Landscaping/Garden Design',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Landscaping/Garden Design') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Tree Surgery/Stump Removal',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Tree Surgery/Stump Removal') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Fencing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Fencing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Decking',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Decking') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Decking Repairs',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Decking Repairs') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Strimming',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Strimming') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Power Washing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Power Washing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Shed Repairs',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Shed Repairs') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Flat Pack Garden Furniture Assembly',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Flat Pack Garden Furniture Assembly') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Green Waste Removal',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Green Waste Removal') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Patio Installation',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Patio Installation') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Lawn Fertilization',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Lawn Fertilization') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Garden Painting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Garden Painting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Gutter VAC',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Gutter VAC') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Leaf blowing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Leaf blowing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Mulching',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Mulching') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Power Washing',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Power Washing') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                    {
                        title: 'Hedge Cutting',
                        is_checked: JSON.parse("{{old('service_types') ? ( strpos(old('service_types'), 'Hedge Cutting') === false ? 'false' : 'true' ) : 'false'}}"),
                    },
                ]
            },
            mounted() {

            },
            methods: {
                changeLocation(e) {
                    if(e.target.value == 'Other') {
                        $('#addOtherLocationBtn').click();
                    }
                },
                openModal(type) {
                    $('#' + type + '_btn_modal').click();
                },
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
