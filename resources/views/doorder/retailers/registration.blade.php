@extends('templates.doorder')

@section('title', 'Retailer Registration')

@section('styles')
    <style>
        html, body {
            background-color: #f2f2f2;
            height: 100%;
        }
        .navbar-brand img {
            height: 60px;
        }

        .color-e8ca49 {
            color: #e8ca49;
        }

        .step-tabs-container {
            position: fixed;
        }

        .reg-inputs-container {
            background-color: white;
            border-radius: 18px;
            height: 80%;
        }

        .step-tabs-title {
            font-size: 20px;
            font-weight: 500;
            line-height: 0.95;
            letter-spacing: 0.8px;
            color: #4d4d4d;
        }
        .step-tabs-subtitle {
            font-size: 15px;
            line-height: 1.27;
            letter-spacing: 0.6px;
            color: #4d4d4d;
        }

        .steps-tabs {
            padding: 0;
            margin-top: 55px;
        }

        .steps-tab {
            border-left: 3px solid #cbcbcb;
            list-style-type: none;
            margin: 0;
            padding: 20px 40px;
            transition: all .8s;
        }

        .steps-tab-selected {
            border-left: 4px solid #f7dc69;
            transition: all .8s;
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
        #app {
            margin-top: 120px;
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

        .modal-content {
            border-radius: 28px;
            border: solid 1px #979797;
            background-color: #ffffff;
            padding: 50px 40px;
        }

        .modal-header {
            border: none;
        }

        .modal-footer {
            border: none;
            padding-top: 40px;
        }

        .modal-header .close {
            width: 25px;
            height: 25px;
            padding: 0;
            background-color: #e8ca49;
            border-radius: 50%;
            color: white;
        }

        .iti {
            width: 100%;
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <link rel="stylesheet" href="{{asset('css/jquery.businessHours.css')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=places"></script>
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
@endsection

@section('content')
    {{--NavBar--}}
    <nav class="navbar navbar-light fixed-top bg-white justify-content-between pr-md-5 pl-md-5">
        <a class="navbar-brand" href="#">
            <img src="{{asset('images/doorder-logo.png')}}" class="d-inline-block align-top" alt="DoOrder">
        </a>
        <div>
            Need Help <i class="fas fa-question-circle color-e8ca49"></i>
        </div>
    </nav>
    {{--NavBar--}}

    <div class="container pl-md-1 pr-md-2" id="app">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="container-fluid step-tabs-container">
                    <h2 class="step-tabs-title">
                        Retailer Registration Form
                    </h2>
                    <p class="step-tabs-subtitle">
                        Sign up and partner with DoOrder Today
                    </p>

                    <ul class="steps-tabs">
                        <li :class="current_tab == 'company' ? 'steps-tab steps-tab-selected' : 'steps-tab'">
                            Company Details
                        </li>
                        <li :class="current_tab == 'location' ? 'steps-tab steps-tab-selected' : 'steps-tab'">
                            Location Details
                        </li>
                        <li :class="current_tab == 'contact' ? 'steps-tab steps-tab-selected' : 'steps-tab'">
                            Contact Details
                        </li>
                        <li :class="current_tab == 'payment' ? 'steps-tab steps-tab-selected' : 'steps-tab'">
                            Payment Details
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8 reg-inputs-container p-3">
                <form id="registeration-form" action="{{route('postRetailerRegistration', 'doorder')}}" method="post" v-on:submit="checkPaymentCard">
                    {{csrf_field()}}
                    <div class="row" @click="changeCurrentTap('company')">
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
                            Company Details
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group bmd-form-group">
                                {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                <input type="text" class="form-control" name="company_name" value="{{old('company_name')}}" placeholder="Company Name" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group bmd-form-group">
                                {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                <input type="text" class="form-control" name="company_website" value="{{old('company_website')}}" placeholder="Company Website" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group bmd-form-group">
                                {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                <input type="text" class="form-control" name="business_type" value="{{old('business_type')}}" placeholder="Business Type" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group bmd-form-group">
                                {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                <input type="text" class="form-control" name="number_business_locations" value="{{old('number_business_locations')}}" placeholder="Number of Business Locations" required>
                            </div>
                        </div>
                    </div>

                    <div class="row" @click="changeCurrentTap('location')">
                        <div class="col-md-12 d-flex form-head pl-3">
                        <span>
                            2
                        </span>
                            Locations Details <i class="fas fa-plus-circle color-e8ca49" @click="addLocation()"></i>
                        </div>

                        <div class="col-md-12" v-for="(location, index) in locations">
                            <label v-if="locations.length > 1">Location @{{ index + 1 }}</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                        <textarea :id="'location' + (index +1)" class="form-control" rows="3" :name="'address' + (index + 1)" placeholder="Address" required v-model="location.address">{{old('address')}}</textarea>
                                        <input :id="'location_'+ (index+1) +'_coordinates'" :name="'address_coordinates_' + (index + 1)" type="hidden">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                        <input type="text" class="form-control" :name="'eircode' + (index + 1)" :id="'eircode' + (index + 1)" value="{{old('eircode')}}" placeholder="Postcode/Eircode" required>
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                        <select class="form-control" :id="'country' + (index + 1)" :name="'country' + (index + 1)" required>
                                            <option disabled>Select Country</option>
                                            <option value="Ireland" selected>Ireland</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                        <input type="text" class="form-control" :id="'business_hours' + (index + 1)" :name="'business_hours' + (index + 1)" value="{{old('business_hours')}}" placeholder="Working Days and Hours" data-toggle="modal" :data-target="'#exampleModal' + index" required>
                                        <input type="hidden" :id="'business_hours_json' + (index + 1)" :name="'business_hours_json' + (index + 1)">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        {{--                            <label class="bmd-label-floating">First Name</label>--}}
                                        <select class="form-control" :id="'county' + (index + 1)" :name="'county' + (index + 1)" required>
                                            <option selected disabled>Select County</option>
                                            <option v-for="county in counties" :value="county">@{{ county }}</option>
                                        </select>
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

                    <div class="row" @click="changeCurrentTap('contact')">
                        <div class="col-md-12 d-flex form-head pl-3">
                        <span>
                            3
                        </span>
                            Contact Details <i class="fas fa-plus-circle color-e8ca49" @click="addContact()"></i>
                        </div>

                        <div class="col-md-12" v-for="(contact, index) in contacts">
                            <label v-if="contacts.length > 1">Contact Details @{{ index + 1 }}</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" class="form-control" :id="'contact_name' + (index + 1)" :name="'contact_name' + (index + 1)" value="{{old('contact_name')}}" placeholder="Contact Name" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" class="form-control" :id="'contact_number' + (index + 1)" name="contact_number" value="{{old('contact_number')}}" placeholder="Contact Number" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" class="form-control" :id="'contact_email' + (index + 1)" :name="'contact_email' + (index + 1)" value="{{old('contact_email')}}" placeholder="Contact Email Addess" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
    {{--                                    <input type="text" class="form-control" name="contact_location" value="{{old('contact_location')}}" placeholder="Location" required>--}}
                                        <select class="form-control" :id="'contact_location' + (index + 1)"  :name="'contact_location' + (index + 1)">
                                            <option selected disabled>Location</option>
                                            <option v-for="(location, index) of locations" value="location" v-if="location.address">Location @{{ index +1 }}</option>
                                            <option value="all" v-if="locations.length > 1">All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" @click="changeCurrentTap('payment')">
                        <div class="col-md-12 d-flex form-head pl-3">
                        <span>
                            4
                        </span>
                            Payment Details
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" class="form-control" id="card_number" name="payment_card_number" value="{{old('payment_card_number')}}" placeholder="Card Number" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" class="form-control" id="cvc" name="payment_cvc_number" value="{{old('payment_cvc_number')}}" placeholder="CVC Number" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" class="form-control" id="payment_exp_date" name="payment_exp_date" value="{{old('payment_exp_date')}}" placeholder="Expire Date" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group bmd-form-group">
{{--                                        <input type="text" class="form-control" name="payment_exp_date" value="{{old('payment_exp_date')}}" placeholder="Expire Date" required>--}}
                                        <img src="{{asset('images/pay-with-stripe.png')}}" style="max-width: 100%; max-height: 40px" alt="Pay With Stripe">
                                    </div>
                                </div>
                                <input type='hidden' name='stripeToken' v-model="stripeToken"/>
                                <input type='hidden' id="locations_details" name='locations_details'/>
                                <input type='hidden' id='contacts_details' name='contacts_details'/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 terms-container">
                            By clicking ‘Submit’, I hereby acknowledge and agree that I have read and understood
                            <a href="#" style="color: #e8ca49">DoOrder Privacy Policy</a>. DoOrder use cookies to personalise your experience. For our full
                            <a href="#" style="color: #e8ca49">Cookies Policy</a>.
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-block btn-submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.businessHours.min.js')}}"></script>
    <script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    locations: [
                        {}
                    ],
                    business_hours: {},
                    current_tab: 'company',
                    counties: [],
                    contacts: [
                        {}
                    ],
                    stripeToken: '',
                }
            },
            mounted() {
                //Google MAp autocomplete
                let driver_address_input = document.getElementById('location1');
                let autocomplete_driver_address = new google.maps.places.Autocomplete(driver_address_input);
                autocomplete_driver_address.setComponentRestrictions({'country': ['ie']});
                autocomplete_driver_address.addListener('place_changed', function () {
                    let place = autocomplete_driver_address.getPlace();
                    if (!place.geometry) {
                        // User entered the name of a Place that was not suggested and
                        // pressed the Enter key, or the Place Details request failed.
                        window.alert("No details available for input: '" + place.name + "'");
                    } else {
                        let place_lat = place.geometry.location.lat();
                        let place_lon = place.geometry.location.lng();
                        document.getElementById("location_1_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
                    }
                });

                let iresh_counties_json = jQuery.getJSON('{{asset('iresh_counties.json')}}', data => {
                    for (let county of data.objects.counties.geometries) {
                        this.counties.push(county.id);
                    }
                });

                this.addIntelInput();

                window['business_hours_container1'] = $('#business_hours_container1').businessHours({
                    dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                        '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                        '<div class="weekday"></div>' +
                        '<div class="operationDayTimeContainer">' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" class="mini-time form-control operationTimeFrom" name="startTime" value=""></div>' +
                        '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" class="mini-time form-control operationTimeTill" name="endTime" value=""></div>' +
                        '</div></div>',
                    checkedColorClass: 'workingBusinssDay',
                    uncheckedColorClass: 'dayOff',
                })
            },
            methods: {
                addLocation() {
                    this.locations.push({})
                    this.timer = setTimeout(() => {
                        this.addAutoCompleteInput();
                        this.addBusinessHoursContainer();
                    }, 500)
                },
                addContact() {
                    this.contacts.push({});
                    this.timer = setTimeout(() => {
                        this.addIntelInput();
                    }, 500)
                },
                addAutoCompleteInput() {
                    let latest_key = this.locations.length;
                    let driver_address_input = document.getElementById('location'+latest_key)
                    let autocomplete_driver_address = new google.maps.places.Autocomplete(driver_address_input);
                    autocomplete_driver_address.setComponentRestrictions({'country': ['ie']});
                    autocomplete_driver_address.addListener('place_changed', function () {
                        let place = autocomplete_driver_address.getPlace();
                        if (!place.geometry) {
                            // User entered the name of a Place that was not suggested and
                            // pressed the Enter key, or the Place Details request failed.
                            window.alert("No details available for input: '" + place.name + "'");
                        } else {
                            let place_lat = place.geometry.location.lat();
                            let place_lon = place.geometry.location.lng();
                            document.getElementById("location_"+latest_key +"_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
                        }
                    });
                },
                addIntelInput() {
                    let latest_key = this.contacts.length;
                    let driver_phone_input = document.querySelector("#contact_number" + latest_key);
                    window.intlTelInput(driver_phone_input, {
                        hiddenInput: "contact_number" + latest_key,
                        initialCountry: 'IE',
                        separateDialCode: true,
                        preferredCountries: ['IE', 'GB'],
                        utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
                    });
                },
                changeCurrentTap(value) {
                    this.current_tab = value;
                },
                wait(ms) {
                    var start = new Date().getTime();
                    var end = start;
                    while(end < start + ms) {
                        end = new Date().getTime();
                    }
                },
                serializeBusinessHours(index) {
                    let businessHoursoutput = window['business_hours_container' + index].serialize()
                    let businessHoursText = '';
                    let businessHours = {};
                    let weekDays = {
                        0:'Monday',
                        1:'Tuesday',
                        2:'Wednesday',
                        3:'Thursday',
                        4:'Friday',
                        5:'Saturday',
                        6:'Sunday',
                    }
                    for (let item of businessHoursoutput) {
                        if (item.isActive) {
                            businessHoursText += weekDays[businessHoursoutput.indexOf(item)] + ': From:' + item.timeFrom + ', To: ' + item.timeTill + '/'
                        }
                        let key = weekDays[businessHoursoutput.indexOf(item)]
                        businessHours[key] = item;
                    }
                    $('#business_hours' + index).val(businessHoursText)
                    $('#business_hours_json' + index).val(JSON.stringify(businessHours))
                },
                addBusinessHoursContainer() {
                    let latest_key = this.locations.length;
                    window['business_hours_container' + latest_key] = $('#business_hours_container' + latest_key).businessHours({
                        dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
                            '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
                            '<div class="weekday"></div>' +
                            '<div class="operationDayTimeContainer">' +
                            '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" name="startTime" class="mini-time form-control operationTimeFrom" value=""></div>' +
                            '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" name="endTime" class="mini-time form-control operationTimeTill" value=""></div>' +
                            '</div></div>',
                        checkedColorClass: 'workingBusinssDay',
                        uncheckedColorClass: 'dayOff',
                    })
                },
                checkPaymentCard(e) {
                    e.preventDefault();
                    // console.log($form);
                    let exp_date = $('#payment_exp_date').val();
                    let exp_month = exp_date.split('/')[0];
                    let exp_year = exp_date.split('/')[1];
                    Stripe.setPublishableKey('{{env('STRIPE_PUBLIC_KEY')}}');
                    Stripe.createToken({
                        number: $('#card_number').val(),
                        cvc: $('#cvc').val(),
                        exp_month: exp_month,
                        exp_year: exp_year
                    }, this.stripeResponseHandler);
                    return false;
                },
                stripeResponseHandler(status, response) {
                    if (response.error) {
                        alert(response.error.message);
                    } else {
                        // token contains id, last4, and card type
                        var token = response['id'];
                        this.stripeToken = token;
                        let location_details = [];
                        let contacts_details = [];
                        //Make Location Details Input
                        for(let item of this.locations) {
                            location_details.push({
                                address: $('#location' + (this.locations.indexOf(item) + 1)).val(),
                                coordinates: $('#location_' + (this.locations.indexOf(item) + 1) + '_coordinates').val(),
                                eircode: $('#eircode' + (this.locations.indexOf(item) + 1)).val(),
                                country: $('#country' + (this.locations.indexOf(item) + 1)).val(),
                                business_hours: $('#business_hours' + (this.locations.indexOf(item) + 1)).val(),
                                business_hours_json: $('#business_hours_json' + (this.locations.indexOf(item) + 1)).val(),
                                county: $('#county' + (this.locations.indexOf(item) + 1)).val(),
                            });
                        }

                        for (let item of this.contacts) {
                            contacts_details.push({
                                contact_name: $('#contact_name' + (this.contacts.indexOf(item) + 1)).val(),
                                contact_phone: $('contact_phone' + (this.contacts.indexOf(item) + 1)).val(),
                                contact_email: $('#contact_email' + (this.contacts.indexOf(item) + 1)).val(),
                                contact_location: $('#contact_location' + (this.contacts.indexOf(item) + 1)).val()
                            });
                        }

                        console.log(location_details);
                        console.log(contacts_details);
                        $('#locations_details').val(JSON.stringify(location_details))
                        $('#contacts_details').val(JSON.stringify(contacts_details))
                        var $form = $("#registeration-form");
                        setTimeout(() => {
                            $form.get(0).submit();
                        }, 300)
                    }
                }
            }
        });

        // function initMap() {
        //     //Google MAp autocomplete
        //     let driver_address_input = document.getElementById('location0');
        //     let autocomplete_driver_address = new google.maps.places.Autocomplete(driver_address_input);
        //     autocomplete_driver_address.setComponentRestrictions({'country': ['ie']});
        //     autocomplete_driver_address.addListener('place_changed', function () {
        //         let place = autocomplete_driver_address.getPlace();
        //         if (!place.geometry) {
        //             // User entered the name of a Place that was not suggested and
        //             // pressed the Enter key, or the Place Details request failed.
        //             window.alert("No details available for input: '" + place.name + "'");
        //         } else {
        //             let place_lat = place.geometry.location.lat();
        //             let place_lon = place.geometry.location.lng();
        //             document.getElementById("driver_address_coordinates").value = '{lat: ' + place_lat.toFixed(5) + ', lon: ' + place_lon.toFixed(5) +'}';
        //         }
        //     });
        // }
    </script>
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>-->
@endsection