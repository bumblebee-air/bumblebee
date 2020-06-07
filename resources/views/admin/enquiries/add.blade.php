@extends('templates.dashboard')
@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}"/>
    <style>
        h3 {
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: bold;
        }
        div.card-btns {
            margin: 0 15px 10px;
            padding: 0;
            padding-top: 10px;
        }
        div.iti {
            width: 100%;
        }
</style>
@endsection
@section('page-content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 match-height">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">account_box</i>
                        </div>
                        <h4 class="card-title">Add General Enquiry</h4>
                    </div>
                    <form id="customer-form" action="{{url('general-enquiry')}}" method="post">
                        <div class="card-body ">
                            {{ csrf_field() }}

                            <div class="form-group bmd-form-group">
                                <label for="client">Client *</label>
                                <select id="client" name="client_id" class="form-control selectpicker" required>
                                    <option value="">Select client</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="name">Customer name *</label>
                                <input name="customer_name" type="text" class="form-control" id="name" placeholder="Enter customer name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="phone">Customer phone *</label>
                                <input name="customer_phone" type="text" class="form-control" id="phone" placeholder="Enter customer phone" value="{{ old('phone') }}" required>
                                <p id="customer-phone-intl-output"></p>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="email">Email</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Enter email address" value="{{ old('email') }}">
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="enquiry">Enquiry *</label>
                                <textarea name="enquiry" class="form-control" id="enquiry" required></textarea>
                            </div>
                        </div>
                        <div class="card-btns">
                            <button type="submit" id="addCustomer" class="btn btn-fill btn-rose">Add</button>
                            <a href="{{ url('/') }}" class="btn">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div id="map-container" class="col-md-4 match-height" style="height: 300px;">
                <div id="map" style="width:100%; height: 100%;margin-top:0;border-radius:6px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        let customer_phone = document.querySelector("#phone");
        customer_phone = window.intlTelInput(customer_phone, {
            hiddenInput: 'customer_phone_international',
            initialCountry: 'IE',
            separateDialCode: true,
            preferredCountries: ['IE', 'GB'],
            utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
        });
        let customer_phone_jq = $('#phone');
        let customer_phone_intl_output = $('#customer-phone-intl-output');
        customer_phone_jq.on("keyup change", function() {
            let intlNumber = customer_phone.getNumber();
            if (intlNumber) {
                customer_phone_intl_output.text("International: " + intlNumber);
            } else {
                customer_phone_intl_output.text("Please enter a number below");
            }
        });
    });

    let map;
    let marker;
    let contractor_latlng = null;

    $('.match-height').matchHeight({
        byRow: false
    });

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 51.5117884, lng: -0.1429935}
        });

        marker = new google.maps.Marker({
            map: map,
            label: 'A',
            anchorPoint: new google.maps.Point(0, -29)
        });
        marker.setVisible(false);
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap">
</script>
@endsection